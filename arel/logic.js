arel.sceneReady(function() {
    //Just for Debuging purposes
    //arel.Debug.activate();
    arel.Debug.deactivateArelLogStream();

    var object = arel.Scene.getObjects();

    var n = object.length; 
    for (it = 0; it < n; ++it) {
        var poi = object[it]; 

        var id = poi["id"];

        // It's a contact
        if ( id % 3 == 1) {
            arel.Events.setListener(poi, function(obj, type, params){handlePoiCallventMigas(obj, type, params);});
            // It's a website
        } else if ( id % 3 == 2) { 
            arel.Events.setListener(poi, function(obj, type, params){handleCustomPoiEvent(obj, type, params);});
        }
    }
});

// TODO: Test this
function handleRestaurantRanking(obj, type, param) {
    rankRestaurant(obj.getParameter("restaurant_id"), obj.getParameter("score")); 
}

function rankRestaurant(id, score) {
    $.post("/CcsCome/controller.php", { restaurant_id : id, score: score })
     .done(function(data) {
        alert(data); 
    });

}

function handleCustomPoiEvent(obj, type, param)
{
    //check if there is tracking information available
    if(type && type === arel.Events.Object.ONTOUCHSTARTED)
    {
        $('#info .text').html(obj.getParameter("description"));
        $('#info .buttons').html("<div class=\"button\" onclick=\"arel.Media.openWebsite('" + obj.getParameter("url") + "')\">" + obj.getParameter("url") + "</div>");
        $('#info').show();
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

function handlePoiCallventMigas(obj, type, param)
{
    //check if there is tracking information available
    if(type && type === arel.Events.Object.ONTOUCHSTARTED)
    {
        arel.Media.openWebsite(obj.getParameter("phone"),true);
    }
};

function handlePoiCallventMcDonalds(obj, type, param)
{
    //check if there is tracking information available
    if(type && type === arel.Events.Object.ONTOUCHSTARTED)
    {
        arel.Media.openWebsite("tel:00582127060000",true);
    }
};
