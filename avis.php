<?php

require_once("config/config.php");

$name = $_GET['name'];
$title = $_GET['title'];
$url = $_GET['url'];
$id = $_GET['id'];
$format = isset($_GET['f']) ? $_GET['f'] : 'html';
$clearcache = isset($_GET['clearcache']);
$htmlFile = $config["cache_dir"]."/".$id."_avis_".$name.".html";

if(!file_exists($htmlFile) || $clearcache) {
    shell_exec("nodejs bin/download_avis_".$name.".js \"".$url."\" > ".$htmlFile);
}
$csv = shell_exec("nodejs bin/parse_avis_".$name.".js $htmlFile");

if($format == "csv") {

    header('Content-Type: text/plain');
    echo $csv;
    exit;
}

$avis = array();
foreach(explode("\n", $csv) as $line) {
    if(!$line) {
        continue;
    }
    $data = str_getcsv($line, ";");
    $avis[] = array("plateforme" => $data[0], "content" => $data[6], "date" => $data[3], "note" => $data[4], "author" => $data[5]);
}
?>

<?php foreach($avis as $a): ?>
    <?php echo $a['plateforme']; ?>&nbsp;<span class="text-muted"><?php echo $a['date']; ?></span>&nbsp;<span class="text-warning"><?php echo $a['note']; ?>/5</span><br />
    <p><?php echo $a['content']; ?><br /><small><em><?php echo $a['author']; ?></em></small></p>

    <hr />
<?php endforeach; ?>
