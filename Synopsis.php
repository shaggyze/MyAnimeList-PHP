<?php
//header('Content-disposition: attachment; filename=gen.css');
//header('Content-type: text/plain');
$time_start = microtime(true); 
ini_set("allow_url_fopen", 1);
if (isset($_GET['Template'])) {
if (($_GET['url']) == "test") {
	$html = file_get_contents('https://myanimelist.net/animelist/ShaggyZE?status=7&season=summer&season_year=2021&order=4&order2=12');
} else {
	$html = file_get_contents($_SERVER['HTTP_REFERER']);
}
$start = stripos($html, 'table class="list-table" data-items');
$end = stripos($html, '<tbody><tr class="list-table-header">', $offset = $start);
$length = $end - $start;
$htmlSection = substr($html, $start, $length);
//echo $htmlSection;
$i=0;
redo:
if (preg_match_all('@video_url&quot;:&quot;\\\/(.+)@', $htmlSection, $matches) == False) {goto cont;}
$listItems = $matches[1];

foreach ($listItems as $item) {
    //echo "{$item}";
}
//echo $item;
$start = stripos($item, 'anime\/');
//echo $start;
$end = stripos($item, '\\', $offset = $start);
//echo $end;
$length = $end - $start;
$remove=substr($item, $start, $length);
//echo $remove;
//if ($array[$i-1] == substr($item, $start+7, $length)) {goto cont;}
$array[] = array(1 => substr($item, $start+7, $length));
$htmlSection = substr($item, strlen($remove)+2, strlen($item));
//print_r ($array[$i]);
//echo $htmlSection;
$i++;
goto redo;
cont:
//var_dump ($array);


	$Template = ($_GET['Template']);
    //print "Your Template is #$Template which I will need to create your CSS file. <br>";
//print "Gathering anime_id's and synopsis <br />";
//print "<br>";
//var_dump ($array);
$i=0;
foreach ($array as $myarray) {
//for ($i2 = 0; $i2 <= 3 ; $i2+=1){
if (isset($_GET['Count'])) {
if ($i >= $_GET['Count']) {break;}
} else {
if ($i >= 40) {break;}
}
//print_r ('#'.$myarray[1].', ');
$url2 = "https://api.jikan.moe/v3/anime/$myarray[1]";
$someJSON2 = file_get_contents($url2);
$someArray2 = json_decode($someJSON2, True);
//var_dump ($someArray2);
if ((!$someArray2["synopsis"]) == "") {
	$CSS = str_replace("[DESC]",$someArray2["synopsis"],$Template);
} else {
	sleep(2);
	$url2 = "https://api.jikan.moe/v3/anime/$myarray[1]";
	$someJSON2 = file_get_contents($url2);
	$someArray2 = json_decode($someJSON2, True);
}
$i++;
	if (($someArray2["synopsis"]) == "") {
		$CSS = str_replace("[DESC]","No synopsis information has been added to this title. Help improve our database by adding a synopsis here.",$Template);
	} else {
		$CSS = str_replace("[DESC]",$someArray2["synopsis"],$Template);
	}
	$CSS = str_replace("[ID]",$myarray[1],$CSS);
print ("#" . $CSS);
print ("<br>");
//print('.data.image a[href^="/anime/41710/"]:before{background-image:url(https://cdn.myanimelist.net/images/anime/1706/115694.webp)}');
//print('#tags-41710:after {font-family: Finger Paint; content:"O, Hero! When Kazuya Souma is unexpectedly transported to another world, he knows the people expect a hero. But Souma's idea of heroism is more practical than most—he wants to rebuild the flagging economy of the new land he's found himself in! Betrothed to the princess and abruptly planted on the throne, this realist hero must gather talented people to help him get the country back on its feet—not through war, or adventure, but with administrative reform! (Source: Seven Seas Entertainment)";}');
}

$time_end = microtime(true);
$execution_time = ($time_end - $time_start)/60;
	if (strpos($Template, '[ID]') !== false) {
		if (strpos($Template, '[DESC]') !== false) {
			//print "I have not yet programed the building of the CSS<br>";
		}else{
			//print "[DESC] not present, I can not create your CSS <br>";
		}
	}else{
		//print "[ID] not present, I can not create your CSS <br>";
	}
} else {
    //print "No Template. <br>";
}
//print "If anyone would like to help me with this project the source is available at <a target=blank href=https://github.com/shaggyze/MyAnimeList-PHP>https://github.com/shaggyze/MyAnimeList-PHP</a><br>";
//echo '<b>Total Execution Time:</b> '.round($execution_time,1).' Mins';
?>