const themeToggler = document.querySelector('.theme-toggler');

themeToggler.addEventListener('click', (e) =>{
    document.body.classList.toggle('dark-theme-variables');

    themeToggler.querySelector('span:nth-child(1)').classList.toggle('active');
    themeToggler.querySelector('span:nth-child(1)').classList.toggle('inactive');
    themeToggler.querySelector('span:nth-child(2)').classList.toggle('active')
    themeToggler.querySelector('span:nth-child(1)').classList.toggle('inactive');

})