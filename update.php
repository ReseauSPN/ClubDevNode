<?php

require_once './dataManager.php';

$data = new dataManager();

$name = $_POST['name'];
$value = strtoupper($_POST['value']);
$user = strtoupper($_POST['user']);
$data->setByName($name, $value);
$data->save();
header('Content-Type: application/json');
echo json_encode(array("name" => $name, "value" => $value));

