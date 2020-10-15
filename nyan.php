<?php

function encode($kata='')
{
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL,"https://mattfedder.com/blog/ham/MorseTranslater");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,
		"message=".$kata."&button=Translate");

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$server_output = curl_exec($ch);

	curl_close ($ch);
	return extractString($server_output, '<textarea id="message" name="message" rows=5 style="width: 100%;" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false">', '</textarea>');
}

function decode($morse='')
{
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL,"https://mattfedder.com/blog/ham/MorseTranslater");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,
		"message=".$morse."&button=Translate");

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$server_output = curl_exec($ch);

	curl_close ($ch);
	return extractString($server_output, '<textarea id="message" name="message" rows=5 style="width: 100%;" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false">', '</textarea>');
}

function extractString($string, $start, $end) {
	$string = " ".$string;
	$ini = strpos($string, $start);
	if ($ini == 0) return "";
	$ini += strlen($start);
	$len = strpos($string, $end, $ini) - $ini;
	return substr($string, $ini, $len);
}


$arg1 	= $argv[1];
$x 		= $argv[2];
if ($arg1 == '-e') 
{
	$y 		= encode($x);
	$tod 	= str_replace(".", "nyan", $y);
	$res 	= str_replace("-", "meow", $tod);

	$pos 	= strpos($res,'nyannyanmeow');
	if($pos !== FALSE)
	{
		$res = substr_replace($res, "kyaa! ", $pos, 0);
	}
	echo $res;
}
elseif($arg1 == '-d')
{
	$s 	= preg_replace("/nyan(.*?)/", ".", $x);
	$cok 	= preg_replace("/meow(.*?)/", "-", $s);
	$res  	= str_replace(" kyaa!","", $cok);
	$res 	= decode($res);
	echo $res;
}
