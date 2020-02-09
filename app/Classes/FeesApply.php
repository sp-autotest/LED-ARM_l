<?php 
namespace App\Classes;

use App\FeePlace;
use Illuminate\Http\Request;
use Auth;
use App\User;
use View;
use Carbon\Carbon; 
use App\Profile;
use App\Currency;
use App\Country;
use App\City;
use App\FareFamily;
use App\TypeFee;
use App\Airline;
use App\Aeroport;
use App\BCType;
use DB;
class FeesApply
{

	public static function model_it($dir) { 
		if (is_dir($dir)) { 
	     $objects = scandir($dir); 
	     foreach ($objects as $object) { 
	       if ($object != "." && $object != "..") { 
	         if (is_dir($dir."/".$object))
	           self::model_it($dir."/".$object);
	         else
	           unlink($dir."/".$object); 
	       } 
	     }
	     rmdir($dir); 
	    } 
 	}
	public static function applyFee($summ, $params){
		

		$params[] = ['company_id', Auth::user()->company_id];
		$params1 = $params;
		foreach ($params1 as $key => $value) {
			if($value[0] == 'type_flight'){
				$params1[$key][1] = 0;}
		}

//0 = %
//1 = FIX
		//dd($params);
		$fee = FeePlace::where($params)->orWhere($params1)->whereDate('period_begin_at', '<', Carbon::now())->whereDate('period_end_at', '>', Carbon::now())->orderBy('updated_at', 'desc')->first();
		//dd($fee);
		if(is_null($fee) || $fee->size_fees_inscribed == 0 || $fee == false){return ['summ' => $summ, 'fee' => 0];}
		if($fee->type_fees_inscribed == '0'){
			$feesize = $summ * $fee->size_fees_inscribed / 100;
			$fullsumm = $summ + $feesize;
			if($fullsumm > $fee->max_fees_inscribed){
				$return = ['summ' => $summ , 'fee' => $fee->max_fees_inscribed];
			}elseif($fullsumm < $fee->min_fees_inscribed){
				$return = ['summ'=>$summ, 'fee'=> $fee->min_fees_inscribed];
			}else{
				$return = ['summ' => $summ, 'fee' => $feesize];
			}
			
		}elseif ($fee->type_fees_inscribed == '1') {
			//FIX fees
			/*if($fee->max_fees_inscribed != null && $fee->size_fees_inscribed > $fee->max_fees_inscribed){return $summ + $fee->max_fees_inscribed;
			}elseif($fee->min_fees_inscribed != null && $fee->size_fees_inscribed < $fee->min_fees_inscribed){
				return $summ + $fee->min_fees_inscribed;
			}else{*/
				$return = ['summ'=>$summ, 'fee'=>$fee->size_fees_inscribed];
			/*}*/
		}
		return $return;
		
	}

	public static function getFee($params)
	{
		$params[] = ['company_id', Auth::user()->company_id];
		$params1 = $params;
		foreach ($params1 as $key => $value) {
			if($value[0] == 'type_flight'){
				$params1[$key][1] = 0;}
		}

//0 = %
//1 = FIX
		//dd($params);
		$fee = FeePlace::where($params)->orWhere($params1)->whereDate('period_begin_at', '<', Carbon::now())->whereDate('period_end_at', '>', Carbon::now())->orderBy('updated_at', 'desc')->first();

		return $fee;
	}

}
?>