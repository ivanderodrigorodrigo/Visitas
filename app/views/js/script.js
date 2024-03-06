
function activarSubMenu(idsub){
    var submenu = document.getElementById(idsub);
    var dropdown = document.getElementById('m-dropdown');
    if (submenu.style.display === 'none') {
        submenu.style.display = 'flex';
        submenu.style.flexDirection = 'column';
        dropdown.classList.remove('fa-angle-down');
        dropdown.classList.add('fa-angle-up');
    } else {
        submenu.style.display = 'none';
        dropdown.classList.remove('fa-angle-up');
        dropdown.classList.add('fa-angle-down');
    }
}

function goBack() {
    window.history.back();
}

