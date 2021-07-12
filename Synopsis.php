<?php
ini_set("allow_url_fopen", 1);
if (isset($_GET['Username'])) {
	$Username = ($_GET['Username']);
    print "Your Username is $Username <br>";
	print "I can now Parse your anime_id's from <a href=https://myanimelist.net/animelist/$Username/load.json?status=7&offset=0>load.json</a> to compare with <a href=Anime_Synopsis.json>Anime_Synopsis.json</a> <br>";
$i = 0;
for ($x = 0; $x <= 50000 ; $x+=300) {
	$url = "https://myanimelist.net/animelist/$Username/load.json?status=7&offset=$x";
	$someJSON = file_get_contents($url);
	//print $someJSON;
	$someArray = json_decode($someJSON, true);
	if ($someArray[1]["anime_id"] == ""){break;}
	//print "Gathering offset " . $x . " anime_id's <br>";
	
	foreach($someArray as $myarray) {
		$var = $myarray["anime_id"];
		//print $var.', ';
		$array[$i] = array($i => $var);
		$i++;
	}
	//print "<br>";
}
$url2 = "Anime_Synopsis.json";
$someJSON2 = file_get_contents($url2);
//print $someJSON2;
$someArray2 = json_decode($someJSON2, true);
print "Gathering anime_id's <br>";
$i = 0;
foreach ($array as $myarray1) {
	print_r ($myarray1[$i].', ');
	$i++;
}

print "<br>Gathering Anime_Synopsis.json synopsis <br>";
print_r ($someArray2[0][1]);
print_r ($someArray2[1][5]);
//print_r ($array);

//foreach($someArray2 as $myarray2) {
	//foreach($array as $myarray3) {

		//if ($myarray2[$myarray3] == ""){
		//}else{
			//if (!$myarray2[$myarray3] == ""){
				//$var2 = $myarray2[$myarray3];
				//print ($var2).', ';
			//	unset($array[$myarray3]);
			//	break;
			//}
		//}
	//}
//}
print "<br>";
} else {
    print "No Username. <br>";
}
if (isset($_GET['Template'])) {
	$Template = ($_GET['Template']);
    print "Your Template is #$Template which I will need to create your CSS file. <br>";

	if (strpos($Template, '[ID]') !== false) {
		if (strpos($Template, '[DESC]') !== false) {
			print "I have not yet programed this part <br>";
		}else{
			print "[DESC] not present, I can not create your CSS <br>";
		}
	}else{
		print "[ID] not present, I can not create your CSS <br>";
	}
} else {
    print "No Template. <br>";
}
print "If anyone would like to help me with this project the source is available at <a target=blank href=https://github.com/shaggyze/MyAnimeList-PHP>https://github.com/shaggyze/MyAnimeList-PHP</a><br>";
?>