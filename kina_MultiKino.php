<?php
//require_once "application\config\database.php";
function getXMLFilePath()
{
    return 'https://apibeta.multikino.pl/repertoire.xml?cinema_id=xx';
}


function getXML($url)
{
    return simplexml_load_string( file_get_contents($url) , 'SimpleXMLElement', LIBXML_NOCDATA );
}


//$xml = getXML(getXMLFilePath() . '?cinema_id=1')->children();

$xml = getXML(getXMLFilePath())->children();


//echo $xml->showing[0]->ig_cinema_id;


$cinemaNameArray = array();

foreach($xml->children() as $a)
{
	$child = $a->children();
	$cinemaName = $child->cinema_name;
	//echo $cinemaId;
	//echo $cinemaName;
	
	array_push($cinemaNameArray, $cinemaName);
	
	
}

$cinemaNameResult = array_unique($cinemaNameArray);

//print_r($cinemaNameResult[0]);

$host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "db_cinema";

try
{
	$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
	
	if($polaczenie->connect_errno != 0)
	{
		throw new Exception(mysqli_connect_errno());
	}
	else
	{
		$zapytanieDelete = "delete from cinemas where id_cinema > 0";
		$zapytanieResetAutoIncrement = "alter table cinemas auto_increment = 1";
		
		$result = $polaczenie->query($zapytanieDelete);
			
		if(!$result)
		{
			throw new Exception($polaczenie->error);
		}
		
		$result = $polaczenie->query($zapytanieResetAutoIncrement);
			
		if(!$result)
		{
			throw new Exception($polaczenie->error);
		}
		
		$dlugosc = 1;
		$szerokosc = 1;
		
		
		
		
		foreach($cinemaNameResult as $cinemaName)
		{
			try
			{
				$address = $cinemaName;
				$addressCorrect = str_replace(' ','+',$address);
				//echo $addressCorrect;
				
				$geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.urlencode($addressCorrect).'&sensor=false');

				$output= json_decode($geocode);

				$lat = $output->results[0]->geometry->location->lat;
				$long = $output->results[0]->geometry->location->lng;
				
				/*
				echo $lat;
				echo $long;
				echo " ";
				*/
				
				$zapytanie = "insert into cinemas (name, locationEW, locationNS)
				values ('$cinemaName',$lat, $long)
				
				
				
				";
			
			//$zapytanie = "select * from rezerwacja where"
			
				$result = $polaczenie->query($zapytanie);
				
				if(!$result)
				{
					throw new Exception($polaczenie->error);
				}
				
				
				$dlugosc++;
				$szerokosc++;
			}catch(Exception $e)
			{
				echo 'Blad w foreach'.$e;
			}
		}
		$polaczenie->close();
	}
		
		
}catch(Exception $e)
	{
		echo 'Blad serwera i polaczenia z baza danych'.$e;
	}
	


?>