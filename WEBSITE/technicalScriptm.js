$(document).ready(ready);

function ready(){
    var id = document.location.search.substr('?id='.length) | 0;
    console.log("I'm ready!");
    $('.phone-specific').each(function(){
       var e = $(this);
        e.attr('href', e.attr('href')+'?id='+id);
    });
    $.ajax({
        method: "POST",
        //dataType: "json", //type of data
        crossDomain: true, //localhost purposes
        url: "modem1.php", //Relative or absolute path to file.php file
        data: {device:id},
        success: function(response) {
             console.log(JSON.parse(response));
            var device=JSON.parse(response);
            var el="";
              console.log(device[0].name);
                el+="<h8>"+device[0].name+"</h8><br><h7>Technical Characteristics</h7><p id='p1'>"+device[0].technical_characteristics+"</p>";
            
            
            $(".row").html(el);
        },
        error: function(request,error) 
          {
            console.log("Error");
        }
    });

}