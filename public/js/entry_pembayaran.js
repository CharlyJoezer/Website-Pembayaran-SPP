$('#add-data').click(function(){
    $('#text-header-popup').html('Form Data SPP')
    $('.popup-add-data').attr('attr-mode', 'create')
    $('.wrapper-popup').toggleClass('display')
    setTimeout(() => {
        $('.popup-add-data').toggleClass('down')
    }, 1);
})
$('.popup-add-data').click(function(event){
    event.stopPropagation();
})
$('.wrapper-popup, .close-form, .cancel-form').click(function(event){
    if($('.popup-add-data').attr('attr-mode') == 'edit'){
        $('.form-input-data-spp').trigger('reset')
        $('.form-input-data-spp').attr('action', 'data-spp/create')
    }
    $('.popup-add-data').toggleClass('down')
    $('.wrapper-popup').toggleClass('display')
})

// FITUR SEARCH
$('#button-search').click(function(){
    const getSearch = $('#input-search').val()
    if(getSearch.trim() === ""){
        $('.wrapper-popup').toggleClass('display')
        window.location = "/dashboard/entry-pembayaran-spp";
        return false;
    }
    fetch(`/dashboard/data-entry-pembayaran-spp/feature/search/${getSearch}`)
    .then(response => response.text())
    .then(data => {
        $('#data-table').html(data)
    })
    .catch(error => {
        return false;
    })
})
    
$('#input-search').on('keydown', function(event){
    if (event.keyCode === 13) {
        $('#button-search').trigger('click')
    }
});