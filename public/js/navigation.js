function Navigation() {
    var navigation = document.getElementById('navbar_setting');
    if (navigation.style.display === 'none' || navigation.style.display === '') {
        navigation.style.display = 'block';
    } else {
        navigation.style.display = 'none';
    }
}
function logout(){
    window.alert('are you sure logout?')
}

