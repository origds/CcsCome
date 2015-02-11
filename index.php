<?php
/**
 * @copyright  Copyright 2012 metaio GmbH. All rights reserved.
 * @link       http://www.metaio.com
 * @author     Frank Angermann
 * 
 * @abstract	Learn about the different types of POIs available in junaio. It is a different media type linked with each POI.
 * 				
 * 				Learnings:
 * 					- create multiple POIs within 1 channel
 * 					- use the AREL XML Helper to create the XML output
 * 					- link movie, sound or image with the POI
 * 					- create a custom HTML overlay to be referenced and opened one the custom POI is clicked
 * 					- adding parameters to the POI to be used in AREL JS
 *  			
 **/

require_once './ARELLibrary/arel_xmlhelper.class.php';

//use the Arel Helper to start the output with arel
//start output
ArelXMLHelper::start(NULL, "/arel/index.html", ArelXMLHelper::TRACKING_GPS);

//1. Migas POI Image
$oObject = ArelXMLHelper::createLocationBasedPOI(
		"1", //id
		"Migas Restaurante - Las Mercedes", //title
		array(10.482621, -66.862689, 0), //location
		"http://ra.ldc.usb.ve/0910336/09-10336/Prueba/migas.gif", //thumb
		"http://ra.ldc.usb.ve/0910336/09-10336/Prueba/migas.gif", //icon
		"Disfruta de sandwiches, ensaladas y postres en Caracas.", //description
		array(array("Desayuno Criollo", "imageButton", "http://ra.ldc.usb.ve/0910336/09-10336/Prueba/migas_comida1.jpg"),
			  array("Ensaladas", "imageButton", "http://ra.ldc.usb.ve/0910336/09-10336/Prueba/migas_comida2.jpg"),
			  array("Desayuno Americano", "imageButton", "http://ra.ldc.usb.ve/0910336/09-10336/Prueba/migas_comida3.jpg"),
			  array("Wraps", "imageButton", "http://ra.ldc.usb.ve/0910336/09-10336/Prueba/migas_wraps.jpg"),
			  array("Merengadas y sandwiches", "imageButton", "http://ra.ldc.usb.ve/0910336/09-10336/Prueba/migas_comida4.jpg")) //buttons
	);

//output the object
ArelXMLHelper::outputObject($oObject);

//2. Migas POI
$oObject = ArelXMLHelper::createLocationBasedPOI(
		"2", //id
		"Migas Restaurante en la web", //title
		array(10.482621, -66.862689, 0), //location
		"http://ra.ldc.usb.ve/0910336/09-10336/Prueba/online.png", //thumb
		"http://ra.ldc.usb.ve/0910336/09-10336/Prueba/online.png", //icon
		array()
	);

//add some parameters we will need with AREL
$oObject->addParameter("description", "Visita nuestra pagina web");
$oObject->addParameter("url", "http://www.migascafe.com");

//output the object
ArelXMLHelper::outputObject($oObject);

//3. Migas POI
$oObject = ArelXMLHelper::createLocationBasedPOI(
		"3", //id
		"Contacto Migas Restaurante", //title
		array(10.482621, -66.862689, 0), //location
		"http://ra.ldc.usb.ve/0910336/09-10336/Prueba/call.png", //thumb
		"http://ra.ldc.usb.ve/0910336/09-10336/Prueba/call.png", //icon
		array()
	);

//output the object
ArelXMLHelper::outputObject($oObject);

//4. Mc Donalds POI Image
$oObject = ArelXMLHelper::createLocationBasedPOI(
		"4", //id
		"Mc Donalds  - La Trinidad", //title
		array(10.434526, -66.867997, 0), //location
		"http://ra.ldc.usb.ve/0910336/09-10336/Prueba/mcdonalds.jpg", //thumb
		"http://ra.ldc.usb.ve/0910336/09-10336/Prueba/mcdonalds.jpg", //icon
		"Restaurante de Hamburguesas. Comida rapida. Disfruta de nuestros combos", //description
		array(array("Big Mac", "imageButton", "http://ra.ldc.usb.ve/0910336/09-10336/Prueba/md_bigmac.jpg"),
			  array("Cuarto de Libra con Queso", "imageButton", "http://ra.ldc.usb.ve/0910336/09-10336/Prueba/md_cuartolibra.png"),
			  array("Mc Pollo", "imageButton", "http://ra.ldc.usb.ve/0910336/09-10336/Prueba/md_mcpollo.jpg"),
			  array("Mc Nuggets", "imageButton", "http://ra.ldc.usb.ve/0910336/09-10336/Prueba/md_nuggets.png"),
			  array("Cajita Feliz", "imageButton", "http://ra.ldc.usb.ve/0910336/09-10336/Prueba/md_cajita.gif"),
			  array("Postres", "imageButton", "http://ra.ldc.usb.ve/0910336/09-10336/Prueba/md_postres.jpg"),
			  array("Desayunos", "imageButton", "http://ra.ldc.usb.ve/0910336/09-10336/Prueba/md_desayunos.jpg")) //buttons
	);

//output the object
ArelXMLHelper::outputObject($oObject);

//5. Mc Donalds POI Custom
$oObject = ArelXMLHelper::createLocationBasedPOI(
		"5", //id
		"Mc Donalds en la web", //title
		array(10.434526, -66.867997, 0), //location
		"http://ra.ldc.usb.ve/0910336/09-10336/Prueba/online.png", //thumb
		"http://ra.ldc.usb.ve/0910336/09-10336/Prueba/online.png", //icon
		array() //buttons
	);

//add some parameters we will need with AREL
$oObject->addParameter("description", "Visita nuestra pagina web");
$oObject->addParameter("url", "http://www.mcdonalds.com.ve/");

//output the object
ArelXMLHelper::outputObject($oObject);

//6. Mc Donalds POI Call
$oObject = ArelXMLHelper::createLocationBasedPOI(
		"6", //id
		"Contacto Mc Donalds", //title
		array(10.434526, -66.867997, 0), //location
		"http://ra.ldc.usb.ve/0910336/09-10336/Prueba/call.png", //thumb
		"http://ra.ldc.usb.ve/0910336/09-10336/Prueba/call.png", //icon
		array() //buttons
	);

//output the object
ArelXMLHelper::outputObject($oObject);

//3. Video POI
/*$oObject = ArelXMLHelper::createLocationBasedPOI(
		"3", //id
		"Hello Video POI", //title
		array(48.12307, 11.218636, 0), //location
		"/resources/thumb_video.png", //thumb
		"/resources/icon_video.png", //icon
		"This is our Video POI", //description
		array(array("Start Movie", "movieButton", "http://dev.junaio.com/publisherDownload/tutorial/movie.mp4")) //buttons
	);

//output the object
ArelXMLHelper::outputObject($oObject);

//4. Custom POPup POI
$oObject = ArelXMLHelper::createLocationBasedPOI(
		"4", //id
		"Custom PopUp", //title
		array(48.12317,11.218670,0), //location
		"/resources/thumb_custom.png", //thumb
		"/resources/icon_custom.png", //icon
        array()
	);

//add some parameters we will need with AREL
$oObject->addParameter("description", "This is my special POI. It will do just what I want.");
$oObject->addParameter("url", "http://www.junaio.com");
	
//output the object
ArelXMLHelper::outputObject($oObject);

//5. Phone Call POI
$oObject = ArelXMLHelper::createLocationBasedPOI(
    "5", //id
    "Do Phone Call", //title
    array(48.12302,11.218644,0), //location
    "/resources/thumb_custom.png", //thumb
    "/resources/icon_custom.png", //icon
    array()
);

//output the object
ArelXMLHelper::outputObject($oObject);*/

//end the output
ArelXMLHelper::end();

?>