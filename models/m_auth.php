<?php
  require("m_db.php");

  class m_auth extends m_db{
    private $user_id, $cedula, $password, $pregunta1, $pregunta2, $respuesta1, $respuesta2;

    public function __construct(){
      parent::__construct();
      $this->user_id = null;
      $this->cedula = null;
      $this->password = null;
      $this->pregunta1 = null;
      $this->pregunta2 = null;
      $this->respuesta1 = null;
      $this->respuesta2 = null;
    }
    
    public function SetDatos($d){
      $this->user_id = isset($d['user_id']) ? $d['user_id'] : null;
      $this->cedula = isset($d['cedula']) ? $d['cedula'] : null;
      $this->password = isset($d['password']) ? $d['password'] : null;
      $this->pregunta1 = isset($d['pregunta1']) ? $d['pregunta1'] : null;
      $this->pregunta2 = isset($d['pregunta2']) ? $d['pregunta2'] : null;
      $this->respuesta1 = isset($d['respuesta1']) ? $d['respuesta1'] : null;
      $this->respuesta2 = isset($d['respuesta2']) ? $d['respuesta2'] : null;
    }
    
    public function Login(){
      $res = $this->Query("SELECT * FROM personas 
      INNER JOIN usuarios ON usuarios.person_id_user = personas.id_person 
      INNER JOIN roles_usuario ON roles_usuario.id = usuarios.id_rol
      WHERE personas.cedula_person = '$this->cedula' ;");
      
      if($res->num_rows > 0){
        $datos = $this->Get_array($res);
        if($datos['status_user'] === "0") return [false,"err/06AUTH"];

        if(password_verify($this->password, $datos['password_user'])){
          session_start();
          $_SESSION['user_id'] = $datos['id_user'];
          $_SESSION['cedula'] = $datos['cedula_person'];
          $_SESSION['username'] = $datos['nom_person'];
          $_SESSION['permisos'] = $datos['nivel_permisos_rol'];
          $_SESSION['nom_rol'] = $datos['nom_rol'];
          
          return [true,'msg/01AUTH'];
        }else return [false,'err/07AUTH'];
      }
      else return [false,"err/05AUTH"];
      
    }

    public function Register_user(){
      // Comprobamos que la persona ya este registrada en la base de datos
      $res = $this->Query("SELECT id_person,if_user FROM personas WHERE cedula_person = $this->cedula;");

      if($res->num_rows > 0){
        // Comprobamos que la persona tenga permisos para tener usuario
        $datos = $this->Get_array($res);
        if($datos['if_user'] == "0") return "err/03AUTH";

        // Comprobamos si la persona ya posee un usuario
        $res = $this->Query("SELECT * FROM usuarios WHERE person_id_user = ".$datos['id_person']." ;");
        if($res->num_rows > 0) return "err/04AUTH";

        $this->password = password_hash($this->password, PASSWORD_BCRYPT, ['cost' => 12]);

        $sql_insert = "INSERT INTO usuarios(id_user,person_id_user,password_user,status_user,id_rol,
        created_user,pregun1_user,pregun2_user,respuesta1_user,respuesta2_user) 
        VALUES(null,".$datos['id_person'].",'$this->password',1,3,NOW(),$this->pregunta1,$this->pregunta2,$this->respuesta1,$this->respuesta2);";
            
        $this->Query($sql_insert);

        if($this->Result_last_query()) return "msg/02AUTH";
        else return "err/05AUTH";
      }else{
        return "err/02AUTH";
      }
    }

    public function FindUser($cod){
      $cod = $this->Clean(intval($cod));

      $sql = "SELECT personas.id_person,personas.if_user FROM personas WHERE personas.cedula_person = $cod ;";
      $result = $this->Query($sql); 

      if($result->num_rows > 0){
        $datos = $this->Get_array($result);

        if($datos['if_user'] == '0'){
          return [
            'status' => false,
            'next' => 1,
            'message' => [
              'code' => 'error',
              'msg' => "Usted no esta habilidato para poseer un usuario",
            ],
          ];
        }

        $sql2 = "SELECT usuarios.id_user,usuarios.pregun1_user,usuarios.pregun2_user FROM usuarios WHERE usuarios.person_id_user = ".$datos['id_person'];
        $result_2 = $this->Query($sql2);

        if($result_2->num_rows == 0){
          return [
            'status' => true,
            'cedula' => $cod,
            'id' => $datos['id_person'],
            'next' => 2,
            'message' => [
              'code' => 'success',
              'msg' => "Puedes proceder a crear tu usuario, con tu clave, preguntas y respuestas de seguridad",
            ],
            'view' => 'sign_in'
          ];
        }

        $datos_2 = $this->Get_array($result_2);
        $pg1 = $this->Get_Preguntas($datos_2['pregun1_user']);
        $pg2 = $this->Get_Preguntas($datos_2['pregun2_user']);

        $rp1 = $this->Get_Respuestas_to_preguntas($datos_2['pregun1_user']);
        $rp2 = $this->Get_Respuestas_to_preguntas($datos_2['pregun2_user']);

        return [
          'cedula' => $cod,
          'id' => $datos_2['id_user'],
          'pregun1' => $pg1,
          'pregun2' => $pg2,
          'respues1' => $rp1,
          'respues2' => $rp2,
          'status' => true,
          'next' => 2,
          'view' => 'recuperar_clave'
        ];
      }

      return [
        'status' => false,
        'next' => 1,
        'message' => [
          'code' => 'error',
          'msg' => "Su cédula no se encuentra registrada",
        ]
      ];      
    }
    public function ValidarRespuestas($array){
      $rp1 = $this->Clean($array['respuesta1']);
      $rp2 = $this->Clean($array['respuesta2']);
      $id = $this->Clean(intval($array['user_id']));

      $sql = "SELECT person_id_user FROM usuarios WHERE respuesta1_user = $rp1 AND respuesta2_user = $rp2 AND id_user = $id;";
      $result = $this->Query($sql);

      if($result->num_rows > 0){
        return [
          'cedula' => $array['cedula'],
          'id' => $id,
          'next' => 3,
          'status' => true,
        ];
      }

      return [
        'cedula' => $array['cedula'],
        'id' => $id,
        'next' => 2,
        'status' => false,
        'message' => [
          'code' => 'error',
          'msg' => "Las respuestas no son correctas",
        ]
      ];
    }

    public function resetPassword($array){
      $password = password_hash($array['password'], PASSWORD_BCRYPT, ['cost' => 12]);
      $id = $this->Clean(intval($array['user_id']));

      $sql = "UPDATE usuarios SET password_user = '$password' WHERE id_user = $id ;";
      $this->Query($sql);

      if($this->Result_last_query()){
        return [
          'status' => true,
          'next' => 1,
          'message' => [
            'code' => 'success',
            'msg' => "Su clave a sido actualizada",
          ]
        ];
      }

      return [
        'status' => false,
        'next' => 1,
        'message' => [
          'code' => 'error',
          'msg' => "Su clave no a sido actualizada"
        ]
      ];
    }

    public function Get_Preguntas($id = ""){
      if($id == "") $sql = "SELECT * FROM preguntas ;"; else $sql = "SELECT * FROM preguntas WHERE id_pregun = $id ;";
      if($id == "") return $this->Get_todos_array($this->Query($sql)); else return $this->Get_array($this->Query($sql));
    }

    public function Get_Respuestas_to_preguntas($id_pregunta){
      $sql = "SELECT * FROM respuestas WHERE pregun_id_respues = $id_pregunta ;";
      return $this->Get_todos_array($this->Query($sql));
    }
  }