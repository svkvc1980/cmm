$(document).ready(function(){
	$('#hours').hide();
	$('#type').change(function() {
	var selected=$(this).val();
	if(selected ==5)
	{
		$('#hours').show();
		$("#hours").prop('required',true);
	}
	else
	{
  		$('#hours').hide();
  		$("#hours").prop('required',false);
	}
	});

	$('#against_day').hide();
	$('#type').change(function() {
	    var selected=$(this).val();
	    if(selected == 8)
	    {
	      $('#against_day').show();
	      $("#against_day").prop('required',true);
	    }
	    else
	    {
	     	$('#against_day').hide();
	     	$("#against_day").prop('required',false);
	    }
	  });

	$('#others').hide();
	$('#reasons').change(function() {
	var selected=$(this).val();
	if(selected == 6)
	{
		//alert("cdun");
		$('#others').show();
		$("#others").prop('required',true);
	}
	else
	{
   		$('#others').hide();
   		$("#others").prop('required',false);
	}
	});

	$('#reason').hide();
	$('#type').change(function(){
	var selected=$(this).val();
	if(selected==1 || selected==3 || selected==6)
	{
		$('#reason').show();
		$("#reason").prop('required',true);
	}
	else
	{
		$('#reason').hide();
		$("#reason").prop('required',false);
	}
	});
	
	$('#selectall').click(function() { 
    
    if ($(this).is(':checked')) { 
        $('.chkbox').prop('checked', true);
    
    } else {
        $('.chkbox').prop('checked', false);
    }
});
	/*var casual_leaves= <?php echo $leaves; ?>;
	alert(casual_leaves);
	if(casual_leaves==0)
	{
		
		$('#type option[value=1]').attr('disabled','disabled');
	}*/

});