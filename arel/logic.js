arel.sceneReady(function() {
    //Just for Debuging purposes
    //arel.Debug.activate();
    //arel.Debug.deactivateArelLogStream();

    var object = arel.Scene.getObjects();

    var n = object.length; 
    for (it = 0; it < n; ++it) {
        var poi = object[it]; 

        var id = poi["id"];

        // It's a contact
        if ( id % 3 == 1) {
            arel.Events.setListener(poi, function(obj, type, params){handlePoiCallEvent(obj, type, params);});
            // It's a website
        } else if ( id % 3 == 2) { 
            arel.Events.setListener(poi, function(obj, type, params){handleCustomPoiEvent(obj, type, params);});
        }
    }
});

// TODO: Test this
/*function handleRestaurantRanking(obj, type, param) {
    rankRestaurant(obj.getParameter("restaurant_id"), obj.getParameter("score")); 
}*/

function rankRestaurant(id, score) {
    $.post("/CcsCome/controller.php", { restaurant_id : id, score: score })
     .done(function(data) {
    });

};

function handleCustomPoiEvent(obj, type, param)
{
    //check if there is tracking information available
    if(type && type === arel.Events.Object.ONTOUCHSTARTED)
    {
        $('#info .text').html(obj.getParameter("description"));
        $('#info .buttons').html("<div class=\"button\" onclick=\"arel.Media.openWebsite('" + obj.getParameter("url") + "')\">" + obj.getParameter("url") + "</div>");
        $('#info').show();
        $('#star1').show();
        $('#star1').html("<img style=\"width:20px;height:20px\" width=\"50\" heigh=\"50\" border=\"0\" src=\"../imagenes/blackstar.png\" ontouchstart=\"$('#star1').hide(); $('#star6').show();\">");
        $('#star6').html("<img style=\"width:20px;height:20px\" width=\"50\" heigh=\"50\" border=\"0\" src=\"../imagenes/star.png\">");
        $('#star2').show();
        $('#star2').html("<img style=\"width:20px;height:20px\" width=\"50\" heigh=\"50\" border=\"0\" src=\"../imagenes/blackstar.png\" ontouchstart=\"$('#star2').hide(); $('#star7').show();\">");
        $('#star7').html("<img style=\"width:20px;height:20px\" width=\"50\" heigh=\"50\" border=\"0\" src=\"../imagenes/star.png\">");
        $('#star3').show();
        $('#star3').html("<img style=\"width:20px;height:20px\" width=\"50\" heigh=\"50\" border=\"0\" src=\"../imagenes/blackstar.png\" ontouchstart=\"$('#star3').hide(); $('#star8').show();\">");
        $('#star8').html("<img style=\"width:20px;height:20px\" width=\"50\" heigh=\"50\" border=\"0\" src=\"../imagenes/star.png\">");
        
        $('#info .score').html("Calificacion: " + obj.getParameter("avg_score").toString());
        if (($('#star6').is(':visible')) && ($('#star7').is(':visible')) && ($('#star8').is(':visible'))) {
            rankRestaurant(obj.getParameter("restaurant_id"),3);
            $('#info .score').html("Calificacion: " + obj.getParameter("avg_score").toString());
        } else if (($('#star7').is(':visible')) && ($('#star8').is(':visible'))) {
            rankRestaurant(obj.getParameter("restaurant_id"),2);
            $('#info .score').html("Calificacion: " + obj.getParameter("avg_score").toString());
        } else if (($('#star6').is(':visible'))) {
            rankRestaurant(obj.getParameter("restaurant_id"),1);
            $('#info .score').html("Calificacion: " + obj.getParameter("avg_score").toString());
        }

    }
};

function handlePoiSoundEvent(obj, type, param)
{
    //check if there is tracking information available
    if(type && type === arel.Events.Object.ONTOUCHSTARTED)
    {
        arel.Media.startSound("http://dev.junaio.com/publisherDownload/tutorial/test.mp3");
    }
};

function handlePoiCallEvent(obj, type, param)
{
    //check if there is tracking information available
    if(type && type === arel.Events.Object.ONTOUCHSTARTED)
    {
        arel.Media.openWebsite(obj.getParameter("phone"),true);
    }
};
