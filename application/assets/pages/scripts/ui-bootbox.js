var UIBootbox = function () {

    var handleDemoproject = function() 
    {
        $('.popup').click(function()
        {
            bootbox.dialog(
            {
                message: $('.table').html(),
                title: "End Date History",
                buttons: 
                {
                  success: 
                  {
                    label: "Okay",
                    className: "green"
                  }
                }
            });
        });
    }

    return {

        //main function to initiate the module
        init: function () {
            handleDemoproject();
        }
    };

}();

jQuery(document).ready(function() {    
   UIBootbox.init();
});