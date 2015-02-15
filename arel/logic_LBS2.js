arel.sceneReady(function() {
    //Just for Debuging purposes
    arel.Debug.activate();
    arel.Debug.deactivateArelLogStream();

    var object = arel.Scene.getObjects();

    n = object.length; 

    for (it = 0; it < n; ++it) {
        var poi = object[it]; 

        var id = poi["id"];

        // It's a contact
        if ( id % 3 == 1) {
            poi.getLocation().setAltitude(10.0); 
            poi.setVisibility(true, false, false);
            arel.Debug.log(poi.getVisibility()); 
            arel.Events.setListener(poi, function(obj, type, params){handlePoiCallventMigas(obj, type, params);});
            // It's a website
        } else if ( id % 3 == 2) { 
            arel.Events.setListener(poi, function(obj, type, params){handleCustomPoiEvent(obj, type, params);});
        }
    }
});

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
        arel.Media.openWebsite("tel:00582122394895",true);
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
