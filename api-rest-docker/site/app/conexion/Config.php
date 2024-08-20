<?php

/**
 * Database config variables
 * Change this according to your server settings
 */


 define("DB_HOST", getenv('DB_HOST'));
 define("DB_USER", getenv('MYSQL_USER'));
 define("DB_PASSWORD", getenv('MYSQL_PASSWORD'));
 define("DB_DATABASE", getenv('DB_DATABASE'));

// If deployed in a web server, change this according to your configuration
// For Example. the domain name is www.someUrl.com, then if the php files are stored in
// a folder named as "responsive" then the complete url would be
// www.someUrl.com/responsive/
define("ROOT_URL", "http://localhost/personal/restau/");


// FOLDER DIRECTORY FOR XML DATA PHP FILE
// DONT CHANGE THIS
define("XML_FILE", "rest/data_xml.php");

// FOLDER DIRECTORY FOR JSON DATA PHP FILE
// DONT CHANGE THIS
define("JSON_FILE", "rest/data_json.php");



// DON NOT CHANGE THIS
// FOLDER DIRECTORY FOR IMAGES UPLOADED FROM
// THE DESKTOP
define("IMAGE_UPLOAD_DIR", "upload_pic");

?>