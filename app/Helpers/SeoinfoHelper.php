<?php

namespace App\Helpers;

class SeoinfoHelper
{
	private $seoData = [];

	private static $instance = null;

	public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
    	$file = fopen(base_path() . '/seo.csv', 'r');
		$outData = [];

		fgetcsv($file, 10000, ",");

		while (($data = fgetcsv($file, 10000, ',')) !== false) {
		    $outData[$data[0]] = [
		    	'title' => $data[1],
		    	'desc' => $data[2],
		    	'keywords' => $data[3],
		    	'h1' => $data[4],
		    	'text' => $data[5],
		    ];
		}

		fclose($file);

		$this->seoData = $outData;
    }

	public function getSeoData(){
		return $this->seoData;
	}

	public function prepareUrl($url){
		return str_replace(' ', '+', urldecode($url));
	}

	public function getSeoForUrl($url){
		$url = $this->prepareUrl($url);

		return (!empty($this->seoData[$url])) ? $this->seoData[$url] : false;
	}
}