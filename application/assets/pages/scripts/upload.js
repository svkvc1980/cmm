$('#uploadCsv').change(function(){
                
    var ext = $(this).val().split('.').pop().toLowerCase();
    if($.inArray(ext, ['csv']) == -1) {
        alert('invalid extension! allowed .csv only');
        $(this).val('');
        return false;
    }
});
        
$('#bulkupload_frm').submit(function(){
    var csvFile = $('#uploadCsv').val();
    if(csvFile=='')
    {
        alert('Please upload CSV file');
        return false;
    }
});