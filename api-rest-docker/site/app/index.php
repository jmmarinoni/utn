<?php

header('Content-Type: application/JSON');

    require_once "PeopleAPI.php";
    require_once "NameAPI.php";
    $peopleAPI = new PeopleAPI();
    $peopleAPI->API();

    $nameAPI = new NameAPI();
    $nameAPI->API();

?>