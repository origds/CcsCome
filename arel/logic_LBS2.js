arel.sceneReady(function()
{
	//Just for Debuging purposes
	//arel.Debug.activate();
	//arel.Debug.deactivateArelLogStream();
	
    var migasPOIImage      = arel.Scene.getObject("1");
    var migasPOICustom     = arel.Scene.getObject("2");
    var migasPOICall       = arel.Scene.getObject("3");
    var mcdonaldsPOIImage  = arel.Scene.getObject("4");
    var mcdonaldsPOICustom = arel.Scene.getObject("5");
    var mcdonaldsPOICall   = arel.Scene.getObject("6");


	//set a listener on the metaio man (custom pop up)
	arel.Events.setListener(migasPOICustom, function(obj, type, params){handleCustomPoiEvent(obj, type, params);});
	arel.Events.setListener(mcdonaldsPOICustom, function(obj, type, params){handleCustomPoiEvent(obj, type, params);});
	//set a listener on the sound poi
	//arel.Events.setListener(mcdonaldsPOI, function(obj, type, params){handlePoiSoundEvent(obj, type, params);});
    //set a listener on the call poi
    arel.Events.setListener(migasPOICall, function(obj, type, params){handlePoiCallventMigas(obj, type, params);});
    arel.Events.setListener(mcdonaldsPOICall, function(obj, type, params){handlePoiCallventMcDonalds(obj, type, params);});
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
