<?php

namespace LilNickel;
use GuzzleHttp\Client;

require_once(__DIR__.'/vendor/autoload.php');
require 'simple_html_dom.php';


class IslamicFinder {

    public function ListCountries()
    {
        $client = new Client();
        $request = $client->request('GET', 'https://www.islamicfinder.org/world/');
        if($request->getStatusCode() != 200) return false;
        $content = (string) $request->getBody();
        $Html = str_get_html($content);
        $Json = $Html->find('script[id=countries-data]', 0)->innertext;
        $Arry = json_decode($Json, true); # => array
        // Get Ready For The Headache ...
        $Total = [];
        $Total['Continents'][] = $Arry['Africa'];
        $Total['Continents'][] = $Arry['Antarctica'];
        $Total['Continents'][] = $Arry['Asia'];
        $Total['Continents'][] = $Arry['Europe'];
        $Total['Continents'][] = $Arry['Oceania'];
        $Total['Continents'][] = $Arry['North America'];
        $Total['Continents'][] = $Arry['South America'];
        for($Continent=0;$Continent<count($Total['Continents']);$Continent++){
            $index = $Total['Continents'][$Continent];
            for($Country=0;$Country<count($index);$Country++){
                $Continent_index = $index[$Country];
                $Total[] = $Continent_index['countryName'];
            } // if u hadn't a headache that's mean u are not using vim ;(
        }
        unset($Total['Continents']);
	    return $Total;
    }

    public function ListCities($Country)
    {
	    $client = new Client();
	    try {
            $request = $client->request('GET', "https://www.islamicfinder.org/world/{$Country}");
        } catch (\Throwable $err) {
            return false; 
        }
        if($request->getStatusCode() != 200) return false;
	    $content = (string) $request->getBody();
	    $Html = str_get_html($content);
	    $Table = $Html->find("table[aria-hidden=true]", 0);
	    $Tbody = $Table->find("tbody", 0);
	    $Columns = $Tbody->find("tr");
	    $cities = [];
	    foreach($Columns as $Column){
            if($Column->find("td", 0)->find("a", 0) == null) continue;
		    $city = $Column->find("td", 0)->find("a", 0)->innertext;
            $cities[] = $city;
	    }
	    return $cities;
    }
    public function TimesPerCountry($Country)
    {
	    $client = new Client();
        try {
            $request = $client->request('GET', "https://www.islamicfinder.org/world/{$Country}");
        } catch (\Throwable $th) {
            return false; 
        }
        if($request->getStatusCode() != 200) return false;
	    $content = (string) $request->getBody();
	    $Html = str_get_html($content);
        $Table = $Html->find("table[aria-hidden=true]", 0);
	    $Tbody = $Table->find("tbody", 0);
	    $Columns = $Tbody->find("tr");
	    $Times = [];
	    foreach($Columns as $Column){
            if($Column->find("td", 0)->find("a", 0) == null) continue;
		    $city = $Column->find("td", 0)->find("a", 0)->innertext;
		    if($city != 'City'){
                $Times[$city] = [
                    "Fajr" => $Column->find("td", 1)->innertext,
                    "Sunrise" => $Column->find("td", 2)->innertext,
                    "Duhr" => $Column->find("td", 3)->innertext,
                    "Asr" => $Column->find("td", 4)->innertext,
                    "Maghrib" => $Column->find("td", 5)->innertext,
                    "Isha" => $Column->find("td", 6)->innertext,
                    "Qiyam" => $Column->find("td", 7)->innertext,
                ];
            }else{
                continue;
            }
	    }
	    return $Times;
    }
    public function TimesPerCity($Country, $City)
    {
	    $client = new Client();
	    try {
            $request = $client->request('GET', "https://www.islamicfinder.org/world/{$Country}");
        } catch (\Throwable $th) {
            return false; 
        }
        if($request->getStatusCode() != 200) return false;
	    $content = (string) $request->getBody();
	    $Html = str_get_html($content);
        $Table = $Html->find("table[aria-hidden=true]", 0);
	    $Tbody = $Table->find("tbody", 0);
	    $Columns = $Tbody->find("tr");
	    $Times = [];
	    foreach($Columns as $Column){
            if($Column->find("td", 0)->find("a", 0) == null) continue;
		    $city = $Column->find("td", 0)->find("a", 0)->innertext;
		    if($city != 'City' && strtoupper(str_replace("\n", "", $city)) == strtoupper($City)){
                $Times = [
                    "City" => $city,
                    "Fajr" => $Column->find("td", 1)->innertext,
                    "Sunrise" => $Column->find("td", 2)->innertext,
                    "Duhr" => $Column->find("td", 3)->innertext,
                    "Asr" => $Column->find("td", 4)->innertext,
                    "Maghrib" => $Column->find("td", 5)->innertext,
                    "Isha" => $Column->find("td", 6)->innertext,
                    "Qiyam" => $Column->find("td", 7)->innertext,
                ];
                break;
            }else{
                continue;
            }
	    }
	    return $Times;
    }
}
