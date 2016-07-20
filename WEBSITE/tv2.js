$(document).ready(ready);

function ready(){
    console.log("I'm ready!");
    var id=1;
    
    $.ajax({
        method: "POST",
        //dataType: "json", //type of data
        crossDomain: true, //localhost purposes
        url: "tvservice.php", //Relative or absolute path to file.php file
        data: {devices:id},
        success: function(response) {
            console.log(JSON.parse(response));
            var devices=JSON.parse(response);
            var el="";
            for(var i=0;i<devices.length;i++){
                console.log(devices[i].name);
                
                el+="<div class='col'><div class='col-lg-title'><h2>"+devices[i].name+
                    "<div class='col' > <img class='img-responsive' src="+devices[i].image +"></div>"+ "<a class='btn btn-primary btn-lg' href='timvisiondescription.html?id="+devices[i].id+"' role='button'>Description</a></div>"; 
                
                
            }
            
            $(".row").html(el);
        },
        error: function(request,error) 
          {
            console.log("Error");
        }
    });

}