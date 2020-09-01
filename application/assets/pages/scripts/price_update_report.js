$(document).ready(function(){
    $('.pb,.distributor').val('');
    $('.plant').hide();
    //$('.plant_block').hide();
    $('.distributor').change(function(){
        var type_id=$(this).val();
        var mrp_id=$('.mrp').val();
      var raitu_bazar_id=$('.raitu_bazar').val();
        if(parseInt(type_id)==parseInt(mrp_id))
        {
            $('.plant').show();
            $('.plant_block').hide();
        }
      else if(parseInt(type_id)==parseInt(raitu_bazar_id))
      {
        $('.plant').hide();
        $('.plant_block').hide();  
      }
        else
        {
            $('.plant').hide();
            $('.plant_block').show();

        }
    });
    $('.plant_value').click(function(){
        var value=$(this).val();
        if(value==2)
        {
            $('.plant_block').hide();
        }
        else
        {
            $('.plant_block').show();
            $('.pb').prev('i').removeClass('fa-check fa-warning').addClass('fa');
            $('.pb').closest('div.form-group').removeClass('has-success has-error');
            $('.pb').val('');
        }
        
    });
   
});