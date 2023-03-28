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


// INPUT NOMINAL SPP
$('#input-jumlah-dibayar').on('keyup', function(event){
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
            $('#input-jumlah-dibayar-hidden').val(changeNumber)
            if($(this).val() == '0'){
                $(this).val('')
            }
        }
    }
})


$('#input-nisn').focus(function(){
    $('#input-nisn').off('keyup')
    
    $('#input-nisn').keyup(function(){
        $('#input-nisn').off('blur')
        
        $('#input-nisn').blur(function(){
            $('#input-nisn').off('blur')
            const getValue = $('#input-nisn').val()
            if(/^\d+$/.test(getValue) == false){
                $('#info-nisn').html('Input wajib berisi angka!')
                return false;
            }
            $('.save-form').attr('type','submit')
            $('.save-form').removeAttr('disabled')
            $('.save-form').css({
                'background-color' :' rgb(0, 219, 73)',
                'cursor':'pointer',
                'color': 'white'
            })
            $('.wrapper-bulan').html(``)
            fetch(`/dashboard/data-entry-pembayaran/fetch/month/${getValue}`)
            .then(response => response.json())
            .then(data => {
                if(data.status == 'true'){
                    $('#info-nisn').html('')
                    const allMonth = [
                        'Januari',
                        'Februari',
                        'Maret',
                        'April',
                        'Mei',
                        'Juni',
                        'Juli',
                        'Agustus',
                        'September',
                        'Oktober',
                        'November',
                        'Desember'
                    ];
                    for(i = 0; i < 12; i++){
                        if(data.month[allMonth[i]] != undefined){
                            $('.wrapper-bulan').append(`
                                <div style="display:flex;align-items:center;border:1px solid #aaa; padding:5px;width:fit-content;margin-bottom:3px;margin-right:4px;border-radius:3px;">
                                    <input type="checkbox" value="`+allMonth[i]+`" name="`+allMonth[i]+`" style="width:12px;margin:0px;margin-right:5px;">
                                    <div style="font-size:12px;">`+allMonth[i]+`</div>
                                </div>
                            `)
                        }
                    }
                }
                else if(data.status == 'false'){
                    $('#info-nisn').html(data.message)
                    $('.save-form').attr('disabled', 'disabled')
                    $('.save-form').css({
                        'background-color' :'#999',
                        'cursor':'no-drop',
                        'color': 'white'
                    })
                }
            })
            .catch(error => {
                return false;
            })
        })
    })
})
