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
        $("#info #stars").raty({
            starOn   : './raty-2.7.0/lib/images/star-on.png',
            starHalf : './raty-2.7.0/lib/images/star-half.png',
            starOff  : './raty-2.7.0/lib/images/star-off.png',
            score    : function() {
                return obj.getParameter("avg_score"); 
            },
            click    : function(score, evt) {
                rankRestaurant(obj.getParameter("restaurant_id"), score); 
            }
        }); 
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
