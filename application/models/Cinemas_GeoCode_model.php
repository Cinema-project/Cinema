﻿<?php

class Cinemas_geocode_model extends CI_Model
{
		private $cinemasNumber = 1;
		
		private function setCinemasNumber($cinemasNumber)
		{
			$this->cinemasNumber = $cinemasNumber;
		}
		
		private function getXMLFilePath()
		{
			return 'https://apibeta.multikino.pl/repertoire.xml?cinema_id=xx';
		}
		private function getXML($url)
		{
			return simplexml_load_string( file_get_contents($url) , 'SimpleXMLElement', LIBXML_NOCDATA );
		}
		private function getGeoCode($address)//zwraca tablice z szerokoscia i dlugoscia geograficzna podanego adresu
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
		private function getConnection()
		{
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

				if(!$polaczenie->set_charset("utf8"))
				{
					printf("Couldn't set utf8: ", $polaczenie->error);
				}
				else
				{
					return $polaczenie;
				}

			}catch(Exception $e)
			{
				echo 'Blad serwera i polaczenia z baza danych'.$e;
			}
		}
		
		public function insertDataToDataBaseSingle()
		{
			$xml = $this->getXML($this->getXMLFilePath())->children();
			$cinemaNameArray = array();
			$cinemaIdArray = array();
			$cinemaData = array();
			foreach($xml->children() as $a)
			{
				$child = $a->children();
				$cinemaName = $child->cinema_name;
				$cinemaId = $child->ig_cinema_id;
				//echo $cinemaId;
				//echo $cinemaName;

				array_push($cinemaNameArray, $cinemaName);
				array_push($cinemaIdArray, $cinemaId);
				
			}
			$cinemaNameResult = array_unique($cinemaNameArray);//tworze tablice bez powtorzonych rekordow
			$cinemaIdResult = array_unique($cinemaIdArray);
			
			$cinemaDataResult = array_combine($cinemaIdResult, $cinemaNameResult);//tworzy array , 1 parametr to klucze a 2 to wartosci
			
			//echo count($cinemaIdResult);
			//echo count($cinemaNameResult);
			//$this->setCinemasNumber(count($cinemaIdResult));
			
			//print($this->cinemasNumber);
			
			//dane konifguracyjne do polaczenia z baza danych
			$polaczenie = $this->getConnection();
			if(isset($polaczenie))
			{
				$zapytanieZwrocRekordyCinemas = "select name from cinemas";
				$result = $polaczenie->query($zapytanieZwrocRekordyCinemas);
				if(!$result)
				{
					throw new Exception($polaczenie->error);
				}
				$num_rows = $result->num_rows;//liczba zwroconyuhc rekordow
				//echo $num_rows." ";
				if($num_rows > 0)//jesli znajde kino o danej nazwie to go nie wstawiam jeszcze raz
				{
					//echo $result;
					$cinamasNameArray = array();
					while($row = mysqli_fetch_array($result))
					{
						//$cinemaNameFromDataBase = $row['name'];
						array_push($cinamasNameArray, $row['name']);
					}
					//print_r($cinamasNameArray);
					//echo " ";
					foreach($cinemaDataResult as $cinemaId => $cinemaName)
					{
						if(!(in_array($cinemaName, $cinamasNameArray)))//jesli NIE znajdzie w tablicy
						{
							//$address = $cinemaName;
							
							//echo $address." ".',';
							$this->insertDataCheck($cinemaId, $cinemaName, $polaczenie);
						}
					}
				}
				else
				{
					foreach($cinemaDataResult as $cinemaId => $cinemaName)
					{

						//$result = $polaczenie->query($zapytanie);

						$this->insertDataCheck($cinemaId, $cinemaName, $polaczenie);
					}
				}
				$polaczenie->close();
			}
			
		}
		private function insertDataCheck($idCinema, $address, $polaczenie)
		{
			$dataArray = array();
			$dataArray = $this->getGeoCode($address);
			if($dataArray)
			{
				$lat = $dataArray[0];
				$long = $dataArray[1];

				try
				{
					$zapytanie = "insert into `cinemas` (`id_cinema`, `name`, `locationEW`, `locationNS`)
					values ('$idCinema', '$address', '$long', '$lat')";
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
		public function insertDataToDataBase()//bedzie wstawial rekordy az beda wszystkie kina
		{
			ini_set('max_execution_time', 300);
			$polaczenie = $this->getConnection();
			if(isset($polaczenie))
			{
				$done = false;

				while(!$done)
				{
					$zapytanieZwrocRekordyCinemas = "select * from cinemas";
					$result = $polaczenie->query($zapytanieZwrocRekordyCinemas);
					if(!$result)
					{
						throw new Exception($polaczenie->error);
					}
					$num_rows = $result->num_rows;//liczba zwroconyuhc rekordow
					echo $num_rows." ";
					if($num_rows >= 2)//jesli jest tyle rekordow w tabeli ile kin to przerwij wstawianie
					{
						$done = true;
					}
					else
					{
						$this->insertDataToDataBaseSingle();
					}
				}
			}
		}
}
?>
