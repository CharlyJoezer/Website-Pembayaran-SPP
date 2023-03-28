$('#add-data').click(function(){
    $('.box-input-file').children().eq(0).css('display', 'none')
    $('.box-input-file').children().eq(1).prop('required', true)
    $('.box-input-file').children().eq(2).css('display', 'none')
    $('#text-header-popup').html('Form Data Siswa')
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
        $('.form-input-data-siswa').trigger('reset')
        $('.form-input-data-siswa').attr('action', 'data-siswa/create')
    }
    $('.popup-add-data').toggleClass('down')
    $('.wrapper-popup').toggleClass('display')
})

// BUTTON EDIT SISWA
$(document).on('click','.button-edit',function(){
    const getDataJson = JSON.parse($(this).attr('attr-data-string'))
    $('.wrapper-popup').toggleClass('display')
    setTimeout(() => {
        $('.popup-add-data').toggleClass('down')
    }, 0);
    $('#text-header-popup').html('Edit Data Siswa')
    $('.box-input-file').children().eq(0).css('display', 'block')
    $('.box-input-file').children().eq(1).prop('required', false)
    $('.box-input-file').children().eq(2).css('display', 'block')
    $('.popup-add-data').attr('attr-mode', 'edit')
    $('.form-input-data-siswa').attr('action', `data-siswa/edit/${getDataJson['nisn']}`)
    $('.box-input-file').children().eq(0).attr('src', '/storage/image/'+getDataJson['foto'])
    $('#input-nis').val(getDataJson['nis'])
    $('#input-nisn').val(getDataJson['nisn'])
    $('#input-nama').val(getDataJson['nama'])
    $('#input-telepon').val(getDataJson['no_telp'])
    $(`#spp${getDataJson['id_spp']}`).prop('selected', true) // akan dirubah
    $('#input-alamat').val(getDataJson['alamat'])
    $(`#kelas${getDataJson['id_kelas']}`).prop('selected', true) // akan dirubah
});

// BUTTON DELETE SISWA
$(document).on('click','.button-delete',function(){
    $('#confirm-delete-button').attr('href', '/dashboard/data-siswa/delete/'+$(this).attr('attr-nisn'))
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
    window.location = "/dashboard/data-siswa";
    return false;
}
fetch(`/dashboard/data-siswa/feature/search/${getSearch}`)
.then(response => response.text())
.then(data => {
    $('#data-table').html(data)
    $('#all-script').html('test')
})
.catch(error => console.error(error))
})

$('#input-search').on('keydown', function(event){
if (event.keyCode === 13) {
    $('#button-search').trigger('click')
}
});