$('.project').click( function(e) {
  var project_id=$(this).attr('data-project-id');
  $(this).closest('.project_dd').find('.project_toggle i').toggleClass('fa-chevron-left fa-chevron-down');
  $('.project-task-row'+project_id).toggleClass('hide');
});

$(document).on('change','.project_dd',function(){
        var ele = $(this).find('.task_dd');
        var projectID = $(this).val();
        if(projectID){
            $.ajax({
                type:'POST',
                url:'task_list',
                data:'project_id='+projectID,
                success:function(html){
                    ele.html(html);
                    //$('#task').html('<option value=""></option>'); 
                }
            }); 
        }
    });
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
$(document).ready(function(){
    function check_effort_total()
    {
        var week_days = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
        // looping week days
        var  flag=false;
        $.each(week_days, function( index, value )
        {

           // if(form.find($("."+ value )).is('disable')==false)
            {
                //alert(value+'ji');
                var count = 0;
                $("."+ value ).each(function( index)
                {
                    
                    if($(this).val()!="")
                    {
                        count = count+parseInt($(this).val());
                    }
                });
                //alert(count);
                if(count>24)
                {
                    $("."+ value ).css("border-color", "red");
                    flag = true;
                }
                else
                {
                    $("."+ value ).css("border-color", "green");
                }
            }
        });
        if(flag==true)
        {
            e.preventDefault();
            return false;
        }   
    }
    


    $('.effort_entry').on('change',function(){

        var day=$(this).attr('data-day');
        var count = 0;
        $("."+ day ).each(function( index)
        {
            
            if($(this).val()!="")
            {
                count = count+parseInt($(this).val());
            }
        });
        //alert(count);
        if(count>24)
        {
            $(this).css("border-color", "red");
            
        }
        else
        {
            $(this).css("border-color", "green");
        }
    
    });

    $('input[type="submit"]').on('submit',function(){

        var check_effort=check_effort_total();
        if(check_effort==false)
        {
            alert("true");
            return false;
        }
        else
        {
            alert("wrong");
        }

    });

    $('#add_row').click(function(){
        var clone_row_holiday = $("#row_holiday").clone();
        clone_row_holiday.find('.date').datepicker();
        clone_row_holiday.find('div:last a')
                        .removeClass('btn-info')
                        .addClass('btn-danger')
                        .click(function(){
                            $(this).closest('#row_holiday').remove();
                        })
                        .find('i')
                        .removeClass('fa-plus')
                        .addClass('fa-trash-o');
        clone_row_holiday.find('input, select').val('');
        $("#row_holiday:last").after(clone_row_holiday);
    });

   
});
