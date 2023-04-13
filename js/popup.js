function popup_show(popup){
    document.querySelector("#"+popup).classList.add("show");
    document.querySelector('header').classList.add('blur');
    document.querySelector('main').classList.add('blur');
}

function popup_hide(popup){
    document.querySelector("#"+popup).classList.remove("show");
    document.querySelector('header').classList.remove('blur');
    document.querySelector('main').classList.remove('blur');
}