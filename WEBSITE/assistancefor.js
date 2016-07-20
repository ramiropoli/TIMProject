
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
        url: "http://timprj.altervista.org/assistancefor.php", //Relative or absolute path to file.php file
        data: {id:params.id, category:params.category},
        success: function(response) {
            console.log(JSON.parse(response));
            var devices=JSON.parse(response);
            var el="";
            for(var i=0;i<devices.length;i++){
                console.log(devices[i].name);
                
                 el+="<div class='panel panel-default'><div class='panel-heading'><a href='"+devices[i].link+"' ><h2 class='panel-title'>"+devices[i].name+"</a></div></div>"; 
                
                
            }
            
            $(".panel-group").html(el);
        },
        error: function(request,error) 
          {
            console.log("Error");
        }
    });

}