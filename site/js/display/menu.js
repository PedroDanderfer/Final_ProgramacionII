function displayMenu(e){
    let menu = d.getElementById('navMenu');

    if(menu.style.display === 'block'){
        menu.style.transform = 'translateX(-100%)';
        menu.style.display = 'none';
        document.body.style.overflow = 'scroll';
    }else{
        menu.style.display ='block';
        menu.style.transform = 'translateX(0px)';
        document.body.style.overflow = 'hidden';
    }
}