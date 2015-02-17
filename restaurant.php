<?php 
//Tables names
define("RESTAURANTS", "0910336_restaurant");
define("DISHES", "0910336_dish");

// Some variables
define("SERVER"  , '127.0.0.1');
define("USERNAME", '0910336');
define("PASSWORD", '0910336');
define("DB_NAME", 'ra');



require_once './ARELLibrary/arel_xmlhelper.class.php';

// Class dish to handle dishes from the restaurant menu
class Dish {
    var $name;
    var $picture_path;
    var $restaurant_id; 

    public function __construct($name, $picture_path) {
        $this->name         = $name;
        $this->picture_path = $picture_path;
    }

    // Saves a dish to the database
    public function save() {
        $query  = 'INSERT INTO '.DISHES.' (name, picture, restaurant_id) VALUES (';
        $query .= '"'.$this->name.'",';
        $query .= '"'.$this->picture_path.'",';
        $query .= '"'.$this->restaurant_id.'")';

        $result = mysql_query($query);
        if (!$result) {
            die("Query failed: " . mysql_error()); 
        }
    }
}

// Class restaurant for handling restaurants from the database
class Restaurant {
    // Basic attributes
    var $id; 
    var $name;
    var $coord;
    var $website;
    var $logo_path;
    var $description;
    var $phone; 

    // Attritbutes for the ranking
    var $avg_score;
    var $total_score;
    var $n_users;

    // Dishes
    var $dishes = array(); 

    // Constructor
    public function __construct($name, $lat, $lon, $website, $logo_path, $description, $phone) {
        $this->id          = -1;
        $this->name        = $name;
        $this->coord       = array($lat, $lon, 0);
        $this->website     = $website;
        $this->logo_path   = $logo_path;
        $this->description = $description; 
        $this->phone       = $phone; 

        $this->avg_score   = 0; 
        $this->total_score = 0; 
        $this->n_users     = 0; 
    }

    // Ranks a restaurant with $score. 
    // It will make an avg with the current score of the restaurant
    public function rank($score) {

        $this->total_score += $score;
        $this->n_users += 1; 
        $this->avg_score = (float) ($this->total_score / $this->n_users); 

        $this->update(); 
    }

    // Adds a dish to the dishes array of the restaurant
    // $dish can be either an array or a Dish object
    public function add_dish($dish) {
        if (is_array($dish)) {
            foreach($dish as $d) {
                array_push($this->dishes, $d); 
            }
        } else {
            array_push($this->dishes, $dish); 
        }

    }

    // Updates all attributes of the restaurant with id $this->id except for the dishes
    // (All attributes because we don't have a lot)
    public function update() {
        $query = 'UPDATE '.RESTAURANTS.' SET ';

        $query .= 'name="'. $this->name . '",';
        $query .= 'latitude="'. $this->coord[0] . '",';
        $query .= 'longitude="'. $this->coord[1] . '",';
        $query .= 'website="'. $this->website . '",';
        $query .= 'logo_path="'. $this->logo_path . '",';
        $query .= 'avg_score="'. $this->avg_score . '",';
        $query .= 'total_score="'. $this->total_score . '",';
        $query .= 'total_users="'. $this->n_users . '" ';

        $query .= ' WHERE id="'.$this->id.'";';

        $result = mysql_query($query);
        if (!$result) {
            die("Query failed: " . mysql_error()); 
        }

    }

    // Stores a new restaurant in the database
    public function save() {
        $query = 'INSERT INTO '.RESTAURANTS.' (name, latitude,';
        $query .= ' longitude, website, logo_path, avg_score,';
        $query .= ' total_score, total_users, description, phone) VALUES (';
        $query .= '"'. $this->name . '",';
        $query .= '"'. $this->coord[0] . '",';
        $query .= '"'. $this->coord[1] . '",';
        $query .= '"'. $this->website . '",';
        $query .= '"'. $this->logo_path . '",';
        $query .= '"'. $this->avg_score . '",';
        $query .= '"'. $this->total_score . '",';
        $query .= '"'. $this->n_users . '",';
        $query .= '"'. $this->description . '",';
        $query .= '"'. $this->phone . '");';

        $result = mysql_query($query);
        if (!$result) {
            die("Query failed: " . mysql_error()); 
        }

        $id = mysql_insert_id(); 

        $this->id = $id;

        // Stores all dishes in the database
        foreach($this->dishes as $dish) {

            $dish->restaurant_id = $id; 
            $dish->save(); 
        }
    }



    // Retrieves all the restaurants from the database
    public static function all() {

        $query = 'SELECT * FROM '.RESTAURANTS.';';
        $result = mysql_query($query); 
        if (!$result) {
            die("Query failed: " . mysql_error()); 
        }


        $restaurants = array(); 

        while ($row = mysql_fetch_array($result)) {
            $res = new Restaurant($row['name'], $row['latitude'], 
                $row['longitude'], $row['website'], $row['logo_path'], 
                $row['description'], $row['phone']); 

            $res->id          = $row['id'];
            $res->avg_score   = $row['avg_score'];
            $res->total_score = $row['total_score'];
            $res->n_users     = $row['total_users'];

            $queryDish = 'SELECT * FROM '.DISHES.' WHERE restaurant_id = "'.$res->id.'";';
            $resultDish = mysql_query($queryDish); 
            if (!$resultDish) {
                die("Query failed: " . mysql_error()); 
            }

            while ($rowDish = mysql_fetch_array($resultDish)) {
                $dish = new Dish($rowDish['name'], $rowDish['picture']);
                array_push($res->dishes, $dish); 
            }

            array_push($restaurants, $res); 
        }
        return $restaurants; 
    }

    public static function find($id) {
        $query  = 'SELECT * FROM '.RESTAURANTS.' WHERE id="'.$id.'"'; 
        $result = mysql_query($query); 

        if (!$result) {
            die("Query failed: " . mysql_error()); 
        }

        // Query to get the restaurant by id
        $row = mysql_fetch_array($result);
        $rest = new Restaurant($row['name'],$row['latitude'],
                               $row['longitude'],$row['website'],
                               $row['logo_path'],$row['description'],
                               $row['phone']); 

        $rest->id = $id; 
        $rest->avg_score = $row['avg_score']; 
        $rest->total_score = $row['total_score']; 
        $rest->n_users = $row['total_users']; 

        // Query to get all dishes associated to that restaurant
        $queryDish = 'SELECT * FROM '.DISHES.' WHERE restaurant_id = "'.$rest->id.'";';
        $resultDish = mysql_query($queryDish); 
        if (!$resultDish) {
            die("Query failed: " . mysql_error()); 
        }

        while ($rowDish = mysql_fetch_array($resultDish)) {
            $dish = new Dish($rowDish['name'], $rowDish['picture']);
            array_push($rest->dishes, $dish); 
        }

        return $rest; 
    }

    public static function dish_to_array($dishes, $button) {
        $dish_array = array(); 
        foreach($dishes as $dish) {
            $current = [ $dish->name, $button, $dish->picture_path ];
            array_push($dish_array, $current); 
        }

        return $dish_array; 
    }
}

// Class to handle the rendering of the restaurants
Class RestaurantInfo {

    public static $server_url = 'http://ra.ldc.usb.ve/0910336/09-10336/CcsCome';
    public static $id = 0; 
    var $restaurant; 

    public function __construct($restaurant) {
        $this->restaurant = $restaurant;
    }


    public static function startRendering() {
        ArelXMLHelper::start(NULL, "/arel/index.html", ArelXMLHelper::TRACKING_GPS);
    }

    public static function stopRendering() {
        ArelXMLHelper::end();
    }

    // Renders all the restaurant info
    public function render() {
        $this->renderImage(); 
        $this->renderContact(); 
        $this->renderWebsite(); 
    }

    // Renders the image of the restaurant in the restaurant location
    private function renderImage() {
        $res = $this->restaurant; 

        $oObject = ArelXMLHelper::createLocationBasedPOI(
            self::$id, //id
            $res->name,  // Name
            $res->coord, // Location
            $res->logo_path, // Thumb
            $res->logo_path, // Icon
            $res->description, // description
            Restaurant::dish_to_array($res->dishes, "imageButton")
        ); 

        $oObject->addParameter("restaurant_id", $res->id); 
        //output the object
        ArelXMLHelper::outputObject($oObject);

        self::$id += 1; 
    }

    // Renders the website button in the restaurant location
    private function renderWebsite() {
        $res = $this->restaurant; 

        $oObject = ArelXMLHelper::createLocationBasedPOI(
            self::$id, //id
            $res->name." en la web", //title
            $res->coord, 
            self::$server_url."/imagenes/online.png", //thumb
            self::$server_url."/imagenes/online.png", //icon
            array()
        );

        //add some parameters we will need with AREL
        $oObject->addParameter("restaurant_id", $res->id); 
        $oObject->addParameter("description", "Visita nuestra pagina web");
        $oObject->addParameter("url", $res->website);

        //output the object
        ArelXMLHelper::outputObject($oObject);

        self::$id += 1; 
    }

    // Renders the contact button in the restaurant location
    private function renderContact() {
        $res = $this->restaurant; 

        $oObject = ArelXMLHelper::createLocationBasedPOI(
            self::$id, //id
            "Contacto ".$res->name, //title
            $res->coord, 
            self::$server_url."/imagenes/call.png", //thumb
            self::$server_url."/imagenes/call.png", //icon
            array()
        );
        //add some parameters we will need with AREL
        $oObject->addParameter("restaurant_id", $res->id); 
        $oObject->addParameter("phone", "tel:".$res->phone);

        ArelXMLHelper::outputObject($oObject);
        self::$id += 1; 
    }
}
?>
