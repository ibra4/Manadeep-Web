function toggleNav() {
    var nav = document.getElementById("mySidenav")
    nav.classList.toggle('hide')
    if (nav.classList.contains('hide')) {
        document.getElementById("mySidenav").style.width = "100px";
    } else {
        document.getElementById("mySidenav").style.width = "320px";
    }
}

$('#mySidenav a').hover(function () {
    $(this).append('<div id="popup" class="popup">' + $(this).children('span').text() + '</div>')
}, function () {
    $(this).children("#popup").remove();
})