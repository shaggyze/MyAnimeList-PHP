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
print "Gathering anime_id's <br>";
$i = 0;
foreach ($array as $myarray1) {
	print_r ($myarray1[$i].', ');
	$i++;
}
$url2 = "Anime_Synopsis.json";
$someJSON2 = file_get_contents($url2);
print $someJSON2;
$someArray2 = json_decode($someJSON2, True);
print "<br>Gathering Anime_Synopsis.json synopsis <br>";
print_r (($someArray2[0][1]).'<br>');
print_r (($someArray2[1][5]).'<br>');
print_r (($someArray2[1]).'<br>');
for ($i2 = 0; $i2 <= 3 ; $i2+=1) {
$i = 0;
print_r ('#'.($i2).'<br>');
	foreach($array as $myarray3) {
		print_r (($i).'<br>');
		print_r (($myarray3[$i2]).'<br>');
		print_r (($someArray2[$i2][$myarray3[$i]]).'<br>');
		print_r (($someArray2[$i2][$myarray3[$i]]).'<br>');
		if ($myarray2[$i][$myarray3[$i]] == ""){
		}else{
			if (!$myarray2[$i][$myarray3[$i]] == ""){
			//	$var2 = $myarray2[$i][$myarray3[$i]];
			//	print ($var2).', ';
			//	unset($myarray2[$i][$myarray3[$i]]);
			//	break;
			}
		}
	$i++;
	}
}
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