var Clock = {
  totalSeconds:0,

  start: function () {
    var self = this;

    this.interval = setInterval(function () {
      self.totalSeconds += 1;

      /*$("#hour").text(Math.floor(self.totalSeconds / 3600));
      $("#min").text(Math.floor(self.totalSeconds / 60 % 60));
      $("#sec").text(parseInt(self.totalSeconds % 60));*/
      var dt = new Date();
      var time = (dt.getDate()<10?'0':'')+dt.getDate()+"-"+(dt.getMonth()<9?'0':'')+(dt.getMonth()+1)+"-"+dt.getFullYear()+" "+(dt.getHours()<10?'0':'')+dt.getHours() + ":" +(dt.getMinutes()<10?'0':'')+dt.getMinutes() + ":" +(dt.getSeconds()<10?'0':'')+dt.getSeconds();
        $('#timer').text(time);
      //$('#timer').text(formatNum(Math.floor(self.totalSeconds / 3600 % 24))+':'+formatNum(Math.floor(self.totalSeconds / 60 % 60))+':'+formatNum(parseInt(self.totalSeconds % 60)))
    }, 1000);
  },

  pause: function () {
    clearInterval(this.interval);
    delete this.interval;
  },

  resume: function () {
    if (!this.interval) this.start();
  }
};
//Clock.totalSeconds = parseInt(timer_sec);
Clock.start();

//$('#pauseButton').click(function () { Clock.pause(); });
//$('#resumeButton').click(function () { Clock.resume(); });

$('#pause').click(function(){
    

    var data = 'sess_id='+$('#sess_id').val();
    $.ajax({
        type: "POST",
        url: SITE_URL+"Ajax_ci/pausePM",
        data:data,
    success: function(data){  
        Clock.pause();  
        $('#pause').addClass('hidden');
        $('#resume').removeClass('hidden');

        //disable form fields
        $('#pm_next,#pm_stop,input[type="text"],input[type="file"]').prop('disabled',true);
        $('#pm_previous').attr('disabled','disabled');
        $('.param_remarks').css('pointer-events','none');
    }
    });
    
});

$('#resume').click(function(){

    var data = 'sess_id='+$('#sess_id').val();
    $.ajax({
        type: "POST",
        url: SITE_URL+"Ajax_ci/resumePM",
        data:data,
    success: function(data){  
        Clock.resume();
        $('#resume').addClass('hidden');
        $('#pause').removeClass('hidden');

        //enable form fields
        $('#pm_next,#pm_stop,input[type="text"],input[type="file"]').prop('disabled',false);
        $('#pm_previous').removeAttr('disabled');
        $('.param_remarks').css('pointer-events','unset');
    }
    });
    
});

//mahesh 19th aug 2016, 01:12 pm
$('#pm_stop').click(function(){
    if(confirm('Stopping the PM shall halt the process and push it into WIP bucket.Are you sure you want to stop pm document')){
      var data = 'encoded_id='+$('#encoded_id').val();
      $(".cl-mcont").css("opacity",0.5);
      $("#loader").css("opacity",1);
      $.ajax({
          type: "POST",
          url: SITE_URL+"stopPm",
          data:data,
      success: function(data){  
          $(".cl-mcont").css("opacity",1);
          $("#loader").css("opacity",0);
          Clock.pause();
          if(data=='1')
          window.location = SITE_URL+'wipUsers';
          else alert('There\'s a problem occurred while stopping pm');
      }
      });
    }
    else return false;
});

// format number with leading zero
function formatNum(num) {
  return (num<10)? ("0"+num):num;
}