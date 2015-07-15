$(document).ready(function(){
	 $(".submenu").hide();	
	 var flag=1;
	 $("#pull").click(function(){
	 	$(".submenu").toggle(300);
	 	if (flag==1) {$("#pullico").removeClass("glyphicon-chevron-down").addClass("glyphicon-chevron-up");flag=0;} 
	 	else{$("#pullico").removeClass("glyphicon-chevron-up").addClass("glyphicon-chevron-down");flag=1;};   
	 });
     $(".nav li").click(function(){
     	$(".nav li").removeClass("active");
     	$(this).addClass("active");
     });

	 $('body').append('<div class="rs-overlay" />');
	$("button[rel='rs-dialog']").each(function(){
		var trigger 	= $(this);
		var rs_dialog 	= $('#' + trigger.data('target'));
		var rs_box 		= rs_dialog.find('.rs-dialog-box');
		var rs_close 	= rs_dialog.find('.close');
		var rs_overlay 	= $('.rs-overlay');
		if( !rs_dialog.length ) return true;

		// Open dialog
		trigger.click(function(){
			//Get the scrollbar width and avoid content being pushed
			var w1 = $(window).width();
			$('html').addClass('dialog-open');
			var w2 = $(window).width();
			c = w2-w1 + parseFloat($('body').css('padding-right'));
			if( c > 0 ) $('body').css('padding-right', c + 'px' );

			rs_overlay.fadeIn('fast');
			rs_dialog.show( 'fast', function(){
				rs_dialog.addClass('in');
			});	
			return false;
		});

		// Close dialog when clicking on the close button
		rs_close.click(function(e){			
			rs_dialog.removeClass('in').delay(150).queue(function(){
				rs_dialog.hide().dequeue();	
				rs_overlay.fadeOut('slow');
				$('html').removeClass('dialog-open');
				$('body').css('padding-right', '');		
			});
			return false;
		});

		// Close dialog when clicking outside the dialog
		rs_dialog.click(function(e){
			rs_close.trigger('click');		
		});
		rs_box.click(function(e){
			e.stopPropagation();
		});		
	});
  
   var inputid;
   $("#allName1").blur(function(){
         inputid=$(this).attr("id");
   });
   $("#allName2").blur(function(){
         inputid=$(this).attr("id");
   });
      $("#friends1").change(function(){
       var name=$(this).children('option:selected').val();
       var flag1=1;
       var flag2=1;
       var allname1 = $("#allName1").val();
       var allname2 = $("#allName2").val();
       
       if(allname1.length>0){
        var arrname1 = allname1.split(';');
         for(var i=0;i<arrname1.length;i++) {
          
          if(arrname1[i] == name) {
             flag1 = 0;
             break;
          }
        }
           
      }
      if(allname2.length>0){
        var arrname2 = allname2.split(';');
         for(var i=0;i<arrname2.length;i++) {
          if(arrname2[i] == name) {
             flag2 = 0;
             break;
          }
        }  
      }
      
       if (inputid=="allName1"&&flag1==1&&flag2==1) {

        $("#allName1").val($("#allName1").val()+name+";");
       };
       if (inputid=="allName2"&&flag1==1&&flag2==1) {
        $("#allName2").val($("#allName2").val()+name+";");
       };
   });
   $("#clearout1").click(function(){
        $("#allName1").val("");
   });
   $("#clearout2").click(function(){
        $("#allName2").val("");
   });
   $("#workergroup").toggle();
   $("#backtodis").toggle();
   $("#transmit").click(function(){
        $(this).toggle(200);
        $("#confirmmeg").toggle(200);
        $("#workergroup").toggle(200);
        $("#backtodis").toggle(200);

   });
   $("#backtodis").click(function(){
        $(this).toggle(200);
        $("#confirmmeg").toggle(200);
        $("#workergroup").toggle(200);
        $("#transmit").toggle(200);
        $("#workerlist").val("");

   });
  
   $(".form_datetime").hide();
   $("#ordinarym").hide();
   $("#warningm").click(function(){
       $(this).toggle(200);
       $("#ordinarym").toggle(200);
       $(".form_datetime").toggle(200);
   });
   $("#ordinarym").click(function(){
       $(this).toggle(200);
       $("#warningm").toggle(200);
       $(".form_datetime").toggle(200);
      
       $(".visibletime").val("");
       $("#dtp_input1").val("");
   });
   $("#examinerlist").hide();
   $("#myonoffswitch").click(function(){
        $("#examinerlist").toggle(200);
        $("#lister").val("");

   });


   var instyle={
    'background-color':'#ccc',
    'border':'1px solid #fff'
   };
   var outstyle={'background-color':'',
   'border':'1px solid #ccc'
   };
   $(".fileico").mouseover(function(){$(this).css(instyle);});
   $(".fileico").mouseout(function(){$(this).css(outstyle);});
   var filecount =$("#filecount").val();
   var filetype = new Array();
   filetype[0] = new Array("0","../views/layouts/img/0.png");
   filetype[1] = new Array("1","../views/layouts/img/1.png");
   filetype[2] = new Array("2","../views/layouts/img/2.png");
   filetype[3] = new Array("3","../views/layouts/img/3.png");
   filetype[4] = new Array("4","../views/layouts/img/4.png");
   filetype[5] = new Array("5","../views/layouts/img/5.png");
   var realtype = $("#filetype").val();
   var realname = $("#filenamefield").val();
   var reallink = $("#filelinkfield").val();
   if (realtype.length>0) {
       var realfiletype=realtype.split(';');
   };
   if (realname.length>0) {
       var realfilename=realname.split(';');
   };
   if (reallink.length>0) {
       var realfilelink=reallink.split(';');
   };
   for (var i = 0; i<filecount; i++) {
        if (realfiletype[i]=='6'){
          $(".fileimg:eq("+i+")").attr('src',realfilelink[i]);

        }else{
        $(".fileimg:eq("+i+")").attr('src',filetype[(realfiletype[i])][1]);
        }
        $(".filename:eq("+i+")").text(realfilename[i]);
       
   };
   
   switch (filecount) {
    
    case ("1"):
    $(".fileico:gt(0)").hide();
    
    break;
    case ("2"):
    $(".fileico:gt(1)").hide();
    break;
    case ("3"):
    $(".fileico:gt(2)").hide();
    break;
    case ("4"):
    $(".fileico:gt(3)").hide();
    break;
    case ("5"):
    $(".fileico:gt(4)").hide();
    break;
    case ("6"):
    $(".fileico:gt(5)").hide();
    break;
    default:
    $(".fileico:lt(6)").hide();
  };


     


   

 


})