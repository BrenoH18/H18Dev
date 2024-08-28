function menuShow() {
    let menuMobile = document.querySelector('.mobile-menu');
    let menuIcon = document.querySelector('.mobile-menu-icon');
    let menuIconClose = document.querySelector('.mobile-menu-icon-close');
    if(menuMobile.classList.contains('open')){
        menuIconClose.classList.remove('open');
        menuMobile.classList.remove('open');
        menuIcon.classList.remove('close');
    }else{
        menuIconClose.classList.add('open');
        menuMobile.classList.add('open');
        menuIcon.classList.add('close');
    }
}