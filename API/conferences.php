<?php

include("./db/db_connect.php");

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        if (!empty($_GET["id"])) {
            $id = intval($_GET["id"]);
        } else {
            getConferences();
        }
        break;
}

function getConferences(){
    global $conn;
    $query = "SELECT * FROM activités";
    $response = array();

    $conn->query("SET NAMES utf8");
    $result = $conn->query($query);
    while($row = $result->fetch()){
        $response[] = $row;
    }

    $result->closeCursor();
    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
}