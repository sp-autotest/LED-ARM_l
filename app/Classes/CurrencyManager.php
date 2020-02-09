<?php 
namespace App\Classes;

use Carbon\Carbon;
use Auth;
use App\Currency;

class CurrencyManager
{

    public $currentlink = "https://www.cbr-xml-daily.ru/daily_json.js";
    
    public static function CBR_XML_Daily_Ru() {
	    $json_daily_file = storage_path().'/daily.json';
	    
	    if (!is_file($json_daily_file) || filemtime($json_daily_file) < time() - 3600) {
	        if ($json_daily = file_get_contents('https://www.cbr-xml-daily.ru/daily_json.js')) {
	            file_put_contents($json_daily_file, $json_daily);
	        }
	    }

	    return json_decode(file_get_contents($json_daily_file), 1);
	}
    public static function convert($summ, $from, $to){
    	$cur = CurrencyManager::CBR_XML_Daily_Ru();
    	//$cur = json_decode(file_get_contents("https://www.cbr-xml-daily.ru/daily_json.js"), 1);
    	$cur['Valute']['RUB'] = [
			"ID" => "R00000",
			"NumCode" => "000",
			"CharCode" => "RUB",
			"Nominal" => 1,
			"Name" => "Российский Рубль",
			"Value" => 1,
			"Previous" => 1
    	];

    	if($from == 'RUB'){
    		$result = $summ/($cur['Valute'][$to]['Value']/$cur['Valute'][$to]['Nominal']);
    	}elseif($to == 'RUB'){
    		$result = $summ*($cur['Valute'][$from]['Value']/$cur['Valute'][$from]['Nominal']);
    	}else{
    		$result = $summ*($cur['Valute'][$from]['Value']/$cur['Valute'][$from]['Nominal'])/($cur['Valute'][$to]['Value']/$cur['Valute'][$to]['Nominal']);
    	}
    	return /*money_format ( '%.2n' ,*/ round($result, 4) /*)*/;
    }

}
?>