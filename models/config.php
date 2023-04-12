<?php
  $url = explode('/', $_SERVER['SCRIPT_NAME']);
  $string_url = "";
  $host_string = $_SERVER['HTTP_HOST'];
  $port_string = $_SERVER['SERVER_PORT'];

  foreach($url as $item){
    if($item === "controller") break;
    if($item != "index.php") $string_url .= $item."/"; else break;
  }
  // "grupos/index","grupos/form",
  $rutas_privadas = [
    "inicio/index","marcas/index","marcas/form","personas/index","personas/form","jornada/index","jornada/form",
    "productos/index","productos/form","entradas/index","entradas/form","salidas/index","salidas/form",
    "usuarios/index","comedor/index","comedor/form","cargo/index","cargo/form","menu/index","menu/form",
    "reportes/index","sistem/index","usuarios/profile"
  ];

  define("URL", "http://$host_string:$port_string$string_url");
  define("PRIVATE_URLS", $rutas_privadas);

  define("username_email", "jesusparrauen@gmail.com");
  // define("password_email", "nqedobqmsaiyyisy");
  define("password_email", "vzqeasodobsjgrgm");
  
  define("port_email","465");

  define("DEV",false);
?>
