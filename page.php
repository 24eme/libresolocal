<?php

require_once("config/config.php");

$name = $_GET['name'];
$title = $_GET['title'];
$url = $_GET['url'];
$id = $_GET['id'];
$format = isset($_GET['f']) ? $_GET['f'] : 'html';
$clearcache = isset($_GET['clearcache']);
$htmlFile = $config["cache_dir"]."/".$id."_".$name.".html";
$imageFile = $config["cache_dir"]."/".$id."_".$name.".jpg";

if(!file_exists($htmlFile) || $clearcache) {
    shell_exec("nodejs bin/download_".$name.".js \"".$url."\" $imageFile true > ".$htmlFile);
}
$csv = shell_exec("nodejs bin/parse_".$name.".js $htmlFile");

if($format == "csv") {

    header('Content-Type: text/plain');
    echo $csv;
    exit;
}

$page = array();
foreach(explode("\n", $csv) as $line) {
    if(!$line) {
        continue;
    }
    $data = str_getcsv($line, ";");
    $page[$data[2]] = $data[3];
}
?>
<div class="card mt-2">
  <div class="row no-gutters">
    <div class="col-md-4">
      <img src="<?php echo $imageFile; ?>" class="card-img" alt="">
    </div>
    <div class="col-md-4">
      <div class="card-body">
        <h5 class="card-title"><?php echo $title ?></h5>
        <p class="card-text"><?php echo $page['nom'] ?></p>
        <p class="card-text"><?php echo $page['adresse'] ?></p>
        <p class="card-text"><?php echo $page['telephone'] ?><br />
            <?php echo $page['site'] ?></p>
        <p class="card-text"><?php echo $page['note'] ?> à partir de <?php echo $page['nombre_avis'] ?> avis</p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card-body">
        <h5 class="card-title">&nbsp;</h5>
        <p class="card-text">
            Lundi&nbsp;:&nbsp;<?php echo $page['horaire_lundi'] ?><br />
            Mardi&nbsp;:&nbsp;<?php echo $page['horaire_mardi'] ?><br />
            Mercredi&nbsp;:&nbsp;<?php echo $page['horaire_mercredi'] ?><br />
            Jeudi&nbsp;:&nbsp;<?php echo $page['horaire_jeudi'] ?><br />
            Vendredi&nbsp;:&nbsp;<?php echo $page['horaire_vendredi'] ?><br />
            Samedi&nbsp;:&nbsp;<?php echo $page['horaire_samedi'] ?><br />
            Dimanche&nbsp;:&nbsp;<?php echo $page['horaire_dimanche'] ?>
        </p>
      </div>
    </div>
  </div>
</div>
