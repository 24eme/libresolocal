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
    shell_exec("nodejs bin/download_avis_".$name.".js \"".$url."\" true > ".$htmlFile);
}
$csv = shell_exec("nodejs bin/parse_avis_".$name.".js $htmlFile");

if($format == "csv") {

    header('Content-Type: text/plain');
    echo $csv;
    exit;
}

$avis = array();

$plateformes = array();
foreach(explode("\n", $csv) as $line) {
    if(!$line) {
        continue;
    }
    $data = str_getcsv($line, ";");
    $avis[] = array("plateforme" => $data[0], "content" => $data[6], "date" => new DateTime($data[3]), "note" => $data[4], "author" => $data[5]);
    $plateformes[$data[0]]++;
}
?>

<?php foreach($avis as $a): ?>
    <span class="text-secondary"><?php echo $a['date']->format("F Y"); ?></span>&nbsp;<span class="badge badge-info"><?php echo $a['plateforme']; ?></span><span class="badge badge-warning float-right"><?php echo $a['note']; ?></span>
    <p class="mt-2"><?php echo $a['content']; ?><br /><small><em><?php echo $a['author']; ?></em></small></p>

    <hr />
<?php endforeach; ?>
