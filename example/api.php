<?php

require_once(__DIR__.'../vendor/autoload.php');
use LilNickel\IslamicFinder;

header('Content-Type: application/json');

if (isset($_GET['action'])) {
    $IslamicFinder = new IslamicFinder();
    if ($_GET['action'] == 'list') {
        if (isset($_GET['country']))
            $response = $IslamicFinder->ListCities($_GET['country']);
        else
            $response = $IslamicFinder->ListCountries();
        if ($response != FALSE && $response != null) {
            $JSON = [];
            $JSON['status'] = TRUE;
            $JSON['response'] = $response;
            print(json_encode($JSON, JSON_PRETTY_PRINT));
        } else {
            $JSON = [];
            $JSON['status'] = FALSE;
            $JSON['msg'] = 'UNACCEPTABLE_INPUT';
            $JSON['response'] = [];
            print(json_encode($JSON, JSON_PRETTY_PRINT));
        }
    } else if ($_GET['action'] == 'times' && isset($_GET['country'])) {
        if (isset($_GET['city']))
            $response = $IslamicFinder->TimesPerCity($_GET['country'], $_GET['city']);
        else
            $response = $IslamicFinder->TimesPerCountry($_GET['country']);
        if ($response != FALSE && $response != null) {
            $JSON = [];
            $JSON['status'] = TRUE;
            $JSON['response'] = $response;
            print(json_encode($JSON, JSON_PRETTY_PRINT));
        } else {
            $JSON = [];
            $JSON['status'] = FALSE;
            $JSON['msg'] = 'UNACCEPTABLE_INPUT';
            $JSON['response'] = [];
            print(json_encode($JSON, JSON_PRETTY_PRINT));
        }
    } else {
        $JSON = [];
        $JSON['status'] = FALSE;
        $JSON['msg'] = 'UNKNOWN_ACTION';
        $JSON['response'] = [];
        print(json_encode($JSON, JSON_PRETTY_PRINT));
    }
} else {
    $JSON = [];
    $JSON['status'] = FALSE;
    $JSON['msg'] = 'FEW_ARGUMENTS_ARE_MISSING';
    $JSON['response'] = [];
    print(json_encode($JSON, JSON_PRETTY_PRINT));
}
