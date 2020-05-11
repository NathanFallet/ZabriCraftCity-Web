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
$sql = $db->query("SELECT * FROM players WHERE emeralds > 0 AND op = 0 ORDER BY emeralds DESC");
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

// Helper func
function getClassForPosition($position) {
  if ($position == 1) {
    return 'c-place--first';
  } else if ($position == 2) {
    return 'c-place--second';
  } else if ($position == 3) {
    return 'c-place--third';
  }
  return '';
}

?><!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>ZabriCraftCity</title>
    <link rel="stylesheet" href="/css/style.scss">
  </head>
  <body>
    <div class="l-wrapper" id="wrapper">
      <div class="c-headline">
        <h4 class="c-headline__title"><small class="u-text--danger">ZabriCraftCity</small><br/>Realtime leaderboard</h4>
      </div>
      <table class="c-table">
        <thead class="c-table__head">
          <tr class="c-table__head-row">
            <th class="c-table__head-cell u-text--center">Place</th>
            <th class="c-table__head-cell">Pseudo</th>
            <th class="c-table__head-cell u-text--right">Emeralds</th>
          </tr>
        </thead>
        <tbody>
          <tr class"c-table__row">
<?php
foreach ($players as $value) {
?>
            <td class="c-table__cell c-table__cell--place u-text--center"><span class="c-place <?= getClassForPosition($value['position']) ?>"><?= $value['position'] ?></span></td>
            <td class="c-table__cell c-table__cell--name"><?= $value['pseudo'] ?></td>
            <td class="c-table__cell c-table__cell--points u-text--right"><?= $value['emeralds'] ?></td>
<?php
}
?>
          </tr>
        </tbody>
      </table>
    </div>
  </body>
</html>
