$('#add-data').click(function(){
    $('#text-header-popup').html('Form Data Petugas')
    $('.popup-add-data').attr('attr-mode', 'create')
    $('.box-input-password').css('display', 'table-row')
    $('#input-password').prop('disabled', false)
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
        $('.form-input-data-petugas').trigger('reset')
        $('.form-input-data-petugas').attr('action', 'data-petugas/create')
    }
    $('.popup-add-data').toggleClass('down')
    $('.wrapper-popup').toggleClass('display')
})

// BUTTON EDIT SISWA
$(document).on('click','.button-edit',function(){
    const getDataJson = JSON.parse($(this).attr('attr-data-string'))
    $('.box-input-password').css('display', 'none')
    $('#input-password').prop('disabled', true)
    $('.wrapper-popup').toggleClass('display')
    setTimeout(() => {
        $('.popup-add-data').toggleClass('down')
    }, 0);
    $('#text-header-popup').html('Edit Data Petugas')
    $('.popup-add-data').attr('attr-mode', 'edit')
    $('.form-input-data-petugas').attr('action', `data-petugas/edit/${getDataJson['id_petugas']}`)
    $('#input-username').val(getDataJson['username'])
    $('#input-nama').val(getDataJson['nama_petugas'])
    $(`#level-${getDataJson['level']}`).prop('selected', true) // akan dirubah
});


// BUTTON DELETE
$(document).on('click','.button-delete',function(){
    $('#confirm-delete-button').attr('href', '/dashboard/data-petugas/delete/'+$(this).attr('attr-id'))
    $('.wrapper-popup2').toggleClass('display')
    setTimeout(() => {
        $('.popup-delete-data').toggleClass('down')
    }, 0);
})
$('.wrapper-popup2, .close-delete, .cancel-delete').click(function(){
    $('.popup-delete-data').toggleClass('down')
    setTimeout(() => {
        $('.wrapper-popup2').toggleClass('display')
    }, 200);
})
$('.popup-delete-data').click(function(event){
        event.stopPropagation();
})


// FITUR SEARCH
$('#button-search').click(function(){
    const getSearch = $('#input-search').val()
    if(getSearch == ''){
        $('.wrapper-popup').toggleClass('display')
        window.location = "/dashboard/data-petugas";
        return false;
    }
    fetch(`/dashboard/data-petugas/feature/search/${getSearch}`)
    .then(response => response.text())
    .then(data => {
        $('#data-table').html(data)
    })
    .catch(error => console.error(error))
    })
    
    $('#input-search').on('keydown', function(event){
    if (event.keyCode === 13) {
        $('#button-search').trigger('click')
    }
});