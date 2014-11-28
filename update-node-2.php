<?php

require_once './dataManager.php';

$data = new dataManager();

$name = $_POST['name'];
$value = strtoupper($_POST['value']);
$user = $_POST['user'];

$data->setByName($name, $value);
$data->save();
header('Content-Type: application/json');
echo json_encode(array("name" => $name, "value" => $value));




$tmpfname = tempnam(__DIR__ . DIRECTORY_SEPARATOR . "spool", "notif_");
file_put_contents($tmpfname, 
        json_encode(
                array(
                        'name' => $name,
                        'value' => $value,
                        'user' => $user,
                )
                , JSON_NUMERIC_CHECK
                )
        );

