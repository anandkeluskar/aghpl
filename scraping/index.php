<?php

echo "script execution started...<br>";

require_once('simple_html_dom.php');    //PHP library for html dom parser

include('cons.php');        //database connection file
$obj = new Connection();
$conn = $obj->getConnection();

$url = 'https://en.wikipedia.org/wiki/List_of_towns_and_cities_with_100,000_or_more_inhabitants/cityname:_';
$alphabets = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
$countries = array();

/* Fetch existing countries in mysql database and store it in array */
$sql1 = "SELECT id, name FROM country";
$stmt1 = $conn->prepare($sql1);
$stmt1->setFetchMode(PDO::FETCH_ASSOC);
$stmt1->execute();
$count1 = $stmt1->rowCount();

if($count1 > 0){
    foreach($stmt1 as $row){
        $countries[$row['id']] = $row['name'];
    }
}

/* loop through alphabets array to fetch html content for pages from A to Z */
foreach($alphabets as $char){
    $final_url = $url.$char;
    $html = file_get_html($final_url);

    /* search for html <table> tag with class wikitable */
    $table_data = $html->find('table[class="wikitable"]', 0);
    $counter = 0;

    /* loop through html <tr> tags within the <table> */
    foreach($html->find('tr') as $table_row){

        /* uncomment below code to limit the result set */
        /*if($counter > 5){
            break;
        }*/

        /* skip the html <th> tag (first <tr> tag) */
        if($counter > 0){
            $city_title = $table_row->find('a', 0)->plaintext;
            $country_title = $table_row->find('a', 1)->title;

            /* Insert the country name only if it does not already exists */
            $sql2 = "INSERT INTO country (`name`) SELECT * FROM (SELECT :name) AS tmp WHERE NOT EXISTS (SELECT name FROM country WHERE `name` = :name) LIMIT 1";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bindParam(':name', $country_title, PDO::PARAM_STR);
            $stmt2->execute();
            $country_id = $conn->lastInsertId();    //Get the inserted rowid

            if(!empty($country_id)){
                /* Store the new country in countries array */
                $countries[$country_id] = $country_title;
            } else {
                /* If country already exists then get the rowid from countries array */
                $country_id = array_search($country_title, $countries);
            }

            /* Insert the city name only if it does not already exists along with same country  */
            $sql3 = "INSERT INTO city (`country_id`,`name`) SELECT * FROM (SELECT :country_id, :name) AS tmp WHERE NOT EXISTS (SELECT country_id, name FROM city WHERE `name` = :name AND `country_id` = :country_id) LIMIT 1";
            $stmt3 = $conn->prepare($sql3);
            $stmt3->bindParam(':country_id', $country_id, PDO::PARAM_INT);
            $stmt3->bindParam(':name', $city_title, PDO::PARAM_STR);
            $stmt3->execute();
        }

        $counter++;
    }
}

echo "script execution completed...";

?>