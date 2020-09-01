var ComponentsEditors = function () {
    
    var handleSummernoteAddress = function () {
        $('#branch_address').summernote({height: 300});
        //API:
        //var sHTML = $('#summernote_1').code(); // get code
        //$('#summernote_1').destroy(); // destroy
    }

    
    return {
        //main function to initiate the module
        init: function () {
            handleSummernoteAddress();
        }
    };

}();

jQuery(document).ready(function() {    
   ComponentsEditors.init(); 
});