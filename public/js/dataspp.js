
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
    setTimeout(() => {
        $('.wrapper-popup').toggleClass('display')
    }, 200);
})

// BUTTON EDIT SISWA
$(document).on('click','.button-edit',function(){
    $('#text-header-popup').html('Edit Data SPP')
    const getDataJson = JSON.parse($(this).attr('attr-data-string'))
    $('.wrapper-popup').toggleClass('display')
    setTimeout(() => {
        $('.popup-add-data').toggleClass('down')
    }, 0);
    $('.popup-add-data').attr('attr-mode', 'edit')
    $('.form-input-data-spp').attr('action', `data-spp/edit/${getDataJson['id_spp']}`)
    $('#input-tahun').val(getDataJson['tahun'])
    $('#input-nominal').val(getDataJson['nominal'])
    $(document).on('keydown', function(event){
        if (event.keyCode === 13) {
            $('.save-form').trigger('click')
            $(this).off('keydown')
        }
    });
});


// BUTTON DELETE
$(document).on('click','.button-delete',function(){
    $('#confirm-delete-button').attr('href', '/dashboard/data-spp/delete/'+$(this).attr('attr-id'))
    $('.wrapper-popup2').toggleClass('display')
    setTimeout(() => {
        $('.popup-delete-data').toggleClass('down')
    }, 0);
    const deleteURL = '/dashboard/data-spp/delete/'+$(this).attr('attr-id')
    $(document).on('keydown', function(event){
        if (event.keyCode === 13) {
            window.location = deleteURL
            $(this).off('keydown')
        }
    });
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
        window.location = "/dashboard/data-spp";
        return false;
    }
    $('.wrapper-popup').toggleClass('display')
    fetch(`/dashboard/data-spp/feature/search/${getSearch}`)
    .then(response => response.text())
    .then(data => {
        $('.wrapper-popup').toggleClass('display')
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

$('#input-nominal').on('keyup', function(event){
    if(event.keyCode >= 48 && event.keyCode <= 57 || event.keyCode == 8){
        if($(this).val() == '0'){
            $(this).val('')
        }
        let inputValue = $(this).val().replace(/\./g, "")
        let changeNumber = parseInt(inputValue)
        if (!isNaN(inputValue) && $(this).val().length >= 4) {
            var rupiah = changeNumber.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
            var number = rupiah.replace(/Rp/g, '').slice(0, -3)
            $(this).val(number)
            $('#input-nominal-hidden').val(changeNumber)
            if($(this).val() == '0'){
                $(this).val('')
            }
        }
    }

})