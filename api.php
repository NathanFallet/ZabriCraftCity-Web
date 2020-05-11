<?php
// Main config file
if (!file_exists(dirname(__FILE__).'/.env.php')) {
  die('Environment file not found!');
}
require_once dirname(__FILE__).'/.env.php';

// Headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

// Connect to database
try {
  $db = new PDO('mysql:host='.$_ENV['db_host'].';dbname='.$_ENV['db_name'], $_ENV['db_username'], $_ENV['db_password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"));
} catch(Exception $e) {
	exit ('Error while connecting to database: '.$e->getMessage());
}

// Get players from database
$sql = $db->query("SELECT * FROM players WHERE emeralds > 0 AND op = 0 ORDER BY emeralds DESC LIMIT 10");
$players = array();
$position = 1;
while ($dn = $sql->fetch()) {
  $players[] = array(
    'uuid' => $dn['uuid'],
    'position' => $position,
    'pseudo' => $dn['pseudo'],
    'emeralds' => $dn['emeralds']
  );
  $position++;
}

// Return the data
echo json_encode($players);
