<?php

require_once("config/config.php");

$query = $_GET['q'];
$format = isset($_GET['f']) ? $_GET['f'] : 'json';
$clearcache = isset($_GET['clearcache']);
$queryId = md5($query);
$htmlFile = $config["cache_dir"]."/".$queryId.".html";

if(!file_exists($htmlFile) || $clearcache) {
    shell_exec("nodejs bin/download_search.js \"".$query."\" > ".$htmlFile);
}

$csv = shell_exec("nodejs bin/parse_search.js ".$htmlFile);

if($format == "json") {
    $json = array();
    foreach(explode("\n", $csv) as $line) {
        if(!$line) {
            continue;
        }
        $data = str_getcsv($line, ";");
        $json[] = array("name" => $data[0], "title" => $data[1], "url" => $data[2], "id" => $queryId);
    }
    header("Content-Type: application/json");
    echo json_encode($json);
    exit;
}

header("Content-Type: text/plain");
echo "#name;url\n";
echo $csv;
