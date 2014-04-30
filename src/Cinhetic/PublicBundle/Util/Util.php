<?php

namespace Cinhetic\PublicBundle\Util;
use Doctrine\Common\Util\Debug as Debug;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

/**
 * Class Util
 * @package Cinhetic\PublicBundle\Util
 */
class Util
{

    /**
     * @param $text
     * @return string
     */
    public static function slugize($text)
    {
        $text = preg_replace('/\W+/', '-', $text);
        $text = strtolower(trim($text, '-'));
        return $text;
    }

    /**
     * @param $string
     * @return string
     */
    public static function underscore($string)
    {
        return strtolower(preg_replace(array('/([A-Z]+)([A-Z][a-z])/', '/([a-z\d])([A-Z])/'), array('\\1_\\2', '\\1_\\2'), strtr($string, '_', '.')));
    }

    /**
     * Get Limit of Word
     * @param $string
     * @return string
     */
    public static function limit_words($words, $limit = 30, $append = ' ...', $break=".") {
        if(strlen($words) <= $limit) return $words;
        // is $break present between $limit and the end of the string?
        if(false !== ($breakpoint = strpos($words, $break, $limit)))
            if($breakpoint < strlen($words) - 1)
                $words = substr($words, 0, $breakpoint) . $append;
        return $words;
    }

    /**
     * @param $string
     * @return mixed
     */
    public static function camelize($string)
    {
        return preg_replace_callback('/(^|_|\.)+(.)/', function ($match) {
            return ('.' === $match[1] ? '_' : '') . strtoupper($match[2]);
        }, $string);
    }

    /**
     * @param null $day
     * @param null $month
     * @param null $year
     * @return string
     */
    public static function getDateFr($day = null, $month = null, $year = null)
    {
        if (!$day)
            $day = new date('w');
        if (!$month)
            $month = new date("n") - 1;
        if (!$year)
            $year = new date('Y');

        $mois = array("Janvier", "Fevrier", "Mars",
            "Avril", "Mai", "Juin",
            "Juillet", "Août", "Septembre",
            "Octobre", "Novembre", "Decembre");

        $jours = array("Dimanche", "Lundi", "Mardi",
            "Mercredi", "Jeudi", "Vendredi",
            "Samedi");

        return $jours[$day] . " " . date("j") . (date("j") == 1 ? "er" : " ") .
        $mois[$month] . " " . $year;
    }

    /**
     * @param $text
     * @return mixed
     */
    public static function removeAccents($text)
    {
        $alphabet = array(
            'Š' => 'S', 'š' => 's', 'Ð' => 'Dj', 'Ž' => 'Z', 'ž' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A',
            'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I',
            'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U',
            'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a',
            'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i',
            'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u',
            'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y', 'ƒ' => 'f',
        );
        $text = strtr($text, $alphabet);
        $text = preg_replace('/\W+/', '-', $text); //slugify
        return $text;
    }

    /**
     * @param null $city
     * @param null $date
     * @return null
     */
    public static function getMeteo($city = null, $date=null)
    {

        /**
         * Google Geoloc
         */
        $cityclean = str_replace(" ", "+", $city);
        $details_url = "http://api.worldweatheronline.com/free/v1/weather.ashx?q=".$cityclean."&format=json&num_of_days=1&date".$date."&key=9xmrqdsffsqwe9uu2huvcdb3";

        $ch = @curl_init();
        @curl_setopt($ch, CURLOPT_URL, $details_url);
        @curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $meteo = json_decode(curl_exec($ch), true);

        if(array_key_exists('data',$meteo))
            return $meteo['data'];

        return null;
    }


    /**
     * @param null $city
     * @return array|null
     */
    public static function geocode($city = null)
    {
        /**
         * Google Geoloc
         */
        $cityclean = str_replace(" ", "+", $city);
        $details_url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . $cityclean . "&sensor=false";

        $ch = @curl_init();
        @curl_setopt($ch, CURLOPT_URL, $details_url);
        @curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $geoloc = json_decode(curl_exec($ch), true);

        if (array_key_exists('results', $geoloc)) {
            if ($geoloc && isset($geoloc['results'][0]['geometry'])) {
                $lng = $geoloc['results'][0]['geometry']['location']['lng'];
                $lat = $geoloc['results'][0]['geometry']['location']['lat'];
                return array('lng' => $lng, 'lat' => $lat);
            }
        }

        /**
         * Geocoding ClouMate
         */
        $cityclean = str_replace(" ", "+", $city);
        $details_url = "http://geocoding.cloudmade.com/8ee2a50541944fb9bcedded5165f09d9/geocoding/v2/find.js?query=" . $cityclean;

        $ch = @curl_init();
        @curl_setopt($ch, CURLOPT_URL, $details_url);
        @curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $geoloc = json_decode(curl_exec($ch), true);

        if (array_key_exists('bounds', $geoloc)) {
            if (!empty($geoloc['bounds'])) {
                return array('lng' => (float)str_replace(",", ".", $geoloc['bounds'][0][1]), 'lat' => (float)str_replace(",", ".", $geoloc['bounds'][0][0]));
            }
            return $geoloc['bounds'];
        } else {
            return null;
        }
        return null;


        /**
         * Bing geoloc
         */
//        $cityclean = str_replace(" ", "+", $city);
//        http://dev.virtualearth.net/REST/v1/Locations/Paris?key=AoPZV0kjdjWIjCiCU-buK-w2wCloDqXMDFQc45NXBaNkD3pmjdbB4o42q1wYppr-
//        $details_url = "http://dev.virtualearth.net/REST/v1/Locations?&q=75001&maxResults=5&key=AoPZV0kjdjWIjCiCU-buK-w2wCloDqXMDFQc45NXBaNkD3pmjdbB4o42q1wYppr-";
//        http://dev.virtualearth.net/REST/v1/Locations/Lyon?output=json&key=AoPZV0kjdjWIjCiCU-buK-w2wCloDqXMDFQc45NXBaNkD3pmjdbB4o42q1wYppr-
//        $details_url = "http://dev.virtualearth.net/REST/v1/Locations?output=json&countryRegion=Fr&postalCode=75001&maxResults=5&key=AoPZV0kjdjWIjCiCU-buK-w2wCloDqXMDFQc45NXBaNkD3pmjdbB4o42q1wYppr-";
//        $ch = @curl_init();
//        @curl_setopt($ch, CURLOPT_URL, $details_url);
//        @curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        $geoloc = curl_exec($ch);
//
//        exit(Debug::dump($geoloc));
//
//        return $geoloc;
//
//        return null;


        /**
         * Mapquest API
         */

//        http://open.mapquestapi.com/geocoding/v1/address?key=Fmjtd%7Cluub2duz25%2Cbx%3Do5-9u25u6&location=Paris,%20FR
//        $cityclean = str_replace(" ", "+", $city);
//        $details_url = "http://open.mapquestapi.com/geocoding/v1/address?key=Fmjtd%7Cluub2duz25%2Cbx%3Do5-9u25u6&location=".$cityclean.",%20FR";
//        $ch = @curl_init();
//        @curl_setopt($ch, CURLOPT_URL, $details_url);
//        @curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        $geoloc = curl_exec($ch);
//
//        exit(Debug::dump($geoloc));


        /**
         * Gisgraphy API
         */
//        http://services.gisgraphy.com//geocoding/geocode?address=75002&country=FR&outputformat=json


        $cityclean = str_replace(" ", "+", $city);
        $details_url = "http://services.gisgraphy.com//geocoding/geocode?address=75002&country=FR&outputformat=json";
        $ch = @curl_init();
        @curl_setopt($ch, CURLOPT_URL, $details_url);
        @curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $geoloc = curl_exec($ch);
        $reader = new  \DOMDocument();
        $reader->load('http://services.gisgraphy.com//geocoding/geocode?address=75002&country=FR&outputformat=json');
        $lng = '';
        $lat = '';
        if (!empty($reader)) {
            $results = $reader->getElementsByTagName("lng");
            if (!empty($results))
                $lng = $results->item(0)->nodeValue;
            $results = $reader->getElementsByTagName("lat");
            if (!empty($results))
                $lat = $results->item(0)->nodeValue;
            return array('lng' => (float)str_replace(",", ".", $lng), 'lat' => (float)str_replace(",", ".", $lat));
        }

        /**
         * Yahoo Geoloc
         */

        //key of auth
// Public:       dj0yJmk9UEwxYXFxVEdwRnZtJmQ9WVdrOWQzbFViRmROTTJVbWNHbzlORFUxTVRNNU9EWXkmcz1jb25zdW1lcnNlY3JldCZ4PWNj
//Private:   113d17ceaf703c1a0e80285c240dde0b7b449651
        return null;
    }

}
