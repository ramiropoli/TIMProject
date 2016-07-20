
$(document).bind("mobileinit", function () { 
$.support.cors = true; 
$.mobile.allowCrossDomainPages = true; });
$(document).ready(ready);

function ready(){
    console.log("I'm ready!");
    var params = {};
    var t = document.location.search.substr(1).split('&')
    for(var i=0;i<t.length;++i){
        var r = t[i].split('=');
        params[r[0]] = r[1];
    }
    
    $.ajax({
        method: "POST",
        //dataType: "json", //type of data
        crossDomain: true, //localhost purposes
        url: "http://timprj.altervista.org/fordevice.php", //Relative or absolute path to file.php file
        data: {id:params.id, category:params.category},
        success: function(response) {
            console.log(JSON.parse(response));
            var devices=JSON.parse(response);
            var el="";
            for(var i=0;i<devices.length;i++){
                console.log(devices[i].name);
                
                el+="<div class='col'><div class='col-lg-title'><h2>"+devices[i].name+
                    "<div class='col' > <img class='img-responsive' src="+devices[i].image +"></div>"+ "<a class='btn btn-primary btn-lg' href='"+devices[i].link+"' role='button'>Description</a></div>"; 
                
                
            }
            
            $(".row").html(el);
        },
        error: function(request,error) 
          {
            console.log("Error");
        }
    });

}