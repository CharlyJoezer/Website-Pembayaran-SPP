$('#add-data').click(function(){
    $('#text-header-popup').html('Form Data Kelas')
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
        $('.form-input-data-kelas').trigger('reset')
        $('.form-input-data-kelas').attr('action', 'data-kelas/create')
    }
    $('.popup-add-data').toggleClass('down')
    $('.wrapper-popup').toggleClass('display')
})

// BUTTON EDIT SISWA
$(document).on('click','.button-edit',function(){
    $('#text-header-popup').html('Edit Data Kelas')
    const getDataJson = JSON.parse($(this).attr('attr-data-string'))
    $('.wrapper-popup').toggleClass('display')
    setTimeout(() => {
        $('.popup-add-data').toggleClass('down')
    }, 0);
    $('.popup-add-data').attr('attr-mode', 'edit')
    $('.form-input-data-kelas').attr('action', `data-kelas/edit/${getDataJson['id_kelas']}`)
    $('#input-kelas').val(getDataJson['nama_kelas'])
    $('#input-jurusan').val(getDataJson['kompetensi_keahlian'])
});


// BUTTON DELETE
$(document).on('click','.button-delete',function(){
    $('#confirm-delete-button').attr('href', '/dashboard/data-kelas/delete/'+$(this).attr('attr-id'))
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
    if(getSearch.trim() === ""){
        $('.wrapper-popup').toggleClass('display')
        window.location = "/dashboard/data-kelas";
        return false;
    }
    fetch(`/dashboard/data-kelas/feature/search/${getSearch}`)
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