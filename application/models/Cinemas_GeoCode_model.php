<?php

class Cinemas_GeoCode_model extends CI_Model
{
	public function insertDataToDataBase()
	{
		function getXMLFilePath()
		{
			return 'https://apibeta.multikino.pl/repertoire.xml?cinema_id=xx';
		}
		function getXML($url)
		{
			return simplexml_load_string( file_get_contents($url) , 'SimpleXMLElement', LIBXML_NOCDATA );
		}
		function getGeoCode($address)//zwraca tablice z szerokoscia i dlugoscia geograficzna podanego adresu
		{
			$addressCorrect = str_replace(' ','+',$address);
			
			
			
			$geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.urlencode($addressCorrect).'&sensor=false');
			
			
			
			$output= json_decode($geocode, true);
			
			if($output['status']=="OK")//jesli znaleziono kordy
			{
			
				$lat = $output['results'][0]['geometry']['location']['lat'];//szerokosc
				$long = $output['results'][0]['geometry']['location']['lng'];//dlugosc
				$addressResponse = $output['results'][0]['formatted_address'];
				
				if($lat && $long && $addressResponse)
				{
					//echo $addressResponse." ".$lat." ".$long;
					//echo "\n";
					//wstawiam dane do tablicy
					$data_array = array();            
					 
					array_push
					( 
						$data_array,
						$lat, 
						$long
					);
					 
					return $data_array;
				}
				else
				{
					return false;
				}
				
			}
			else
			{
				return false;
			}
		}
		$xml = getXML(getXMLFilePath())->children();
		$cinemaNameArray = array();
		foreach($xml->children() as $a)
		{
			$child = $a->children();
			$cinemaName = $child->cinema_name;
			//echo $cinemaId;
			//echo $cinemaName;
			
			array_push($cinemaNameArray, $cinemaName);
			
			
		}
		$cinemaNameResult = array_unique($cinemaNameArray);//tworze tablice bez powtorzonych rekordow
		//dane konifguracyjne do polaczenia z baza danych
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
				
				
				foreach($cinemaNameResult as $cinemaName)
				{
					$address = $cinemaName;
					$dataArray = array();
					$dataArray = getGeoCode($address);
					
					if($dataArray)
					{
						$lat = $dataArray[0];
						$long = $dataArray[1];
						
						try
						{
							$zapytanie = "insert into cinemas (name, locationEW, locationNS)
							values ('$cinemaName','$long', '$lat')
							
							
							
							";
						
						
							$result = $polaczenie->query($zapytanie);
							
							if(!$result)
							{
								throw new Exception($polaczenie->error);
							}
						}catch(Exception $e)
						{
							echo 'Blad w foreach'.$e;
						}
					}
				}
				
				$polaczenie->close();
			}
				
				
		}catch(Exception $e)
		{
			echo 'Blad serwera i polaczenia z baza danych'.$e;
		}
	}
}
?>