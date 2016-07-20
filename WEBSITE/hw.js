
$(document).bind("mobileinit", function () { 
$.support.cors = true; 
$.mobile.allowCrossDomainPages = true; });
$(document).ready(ready);

function ready(){
 var id = document.location.search.substr('?id='.length) | 0;
    console.log("I'm ready!");
    $('.phone-specific').each(function(){
        var e = $(this), h= e.attr('href');
        e.attr('href', h+((~h.indexOf('?'))?'&':'?')+'id='+id);
    });
    
    
    $.ajax({
        method: "POST",
        //dataType: "json", //type of data
        crossDomain: true, //localhost purposes
        url: "hwdescription.php", //Relative or absolute path to file.php file
        data: {device:id},
        success: function(response) {
             console.log(JSON.parse(response));
            var device=JSON.parse(response);
            var el="";
              console.log(device[0].name);
                el+="<h7>Description of the service</h7><p id='p1'>"+device[0].description+"</p>";
            
            
            $(".row").html(el);
        },
        error: function(request,error) 
          {
            console.log("Error");
        }
    });

}