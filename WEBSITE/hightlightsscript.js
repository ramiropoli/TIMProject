$(document).ready(ready);

function ready(){
    console.log("I'm ready!");
    var id=1;
    
    $.ajax({
        method: "POST",
        //dataType: "json", //type of data
        crossDomain: true, //localhost purposes
        url: "highlights.php", //Relative or absolute path to file.php file
        data: {devices:id},
        success: function(response) {
            console.log(JSON.parse(response));
            var devices=JSON.parse(response);
            var el="";
            for(var i=0;i<devices.length;i++){
                console.log(devices[i].name);
                
                el+="<div class='panel panel-default'><div class='panel-heading'><a href='smartdescription.html?id="+devices[i].id+"' ><h2 class='panel-title'>"+devices[i].name+"</a></div></div>"; 
                
                
                
            }
            
            
            $(".panel-group").html(el);
        },
        error: function(request,error) 
          {
            console.log("Error");
        }
    });

}