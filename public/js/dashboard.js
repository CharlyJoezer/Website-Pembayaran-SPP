function showNotif(){
    $('.notif').addClass('show-notif')
    setTimeout(() => {
        $('.notif').removeClass('show-notif')
    }, 5000);
}