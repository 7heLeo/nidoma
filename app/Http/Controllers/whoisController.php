<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\External\WhoisService;

use Illuminate\Routing\Controller as BaseController;

class whoisController extends BaseController {
	public function whois(Request $request, string $sld, string $tld){
		if(!preg_match('/^[A-Za-z0-9-]{1,63}$/', $sld)) {return whoisController::jsonError(400,400,"Not a valid SLD name");}
		if(!preg_match('/^[A-Za-z]{2,6}$/', $tld)) {return whoisController::jsonError(400,400,"Not a valid TLD name");}
		if($tld!="com"){return whoisController::jsonError(400,400,"Not allowed domain");}
		
		$whoisResult=WhoisService::get($sld.".".$tld);
		if($whoisResult["status"]!=200){return whoisController::jsonError($whoisResult["status"],$whoisResult["status"],$whoisResult["content"]);}
		$whoisJson=json_decode($whoisResult["content"]);
		if(!is_object($whoisJson)){return whoisController::jsonError(500,500,"Internal Server Error");}
		return response(json_encode($whoisJson), 200)->header('Content-Type', 'application/json');
	}
	public function notFound(Request $request){
		return whoisController::jsonError(404,404,"Not found");
	}
	private function jsonError($http_status,$json_status="",$msg=""){
		if($json_status==""){$json_status=$http_status;}
		return response('{"status":"'.$json_status.'","error":"'.$msg.'"}', $http_status)->header('Content-Type', 'application/json');
	}
}
