<?php

namespace App\External;

class WhoisService
{
	public static function get($domain){
		$context = stream_context_create(['http' => ['ignore_errors' => true]]);
		$result = file_get_contents(env('EXTERNAL_WHOIS_SERVICE').$domain, false, $context);
		$status_line = $http_response_header[0];
		preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);
		$status = $match[1];
		return array("status"=>$status,"content"=>trim($result));		
	}

}