<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\External\WhoisService;

class serviceTest extends TestCase
{
    public function test_the_service_is_on(): void
    {
		$whoisResult=WhoisService::get("");
		$this->assertTrue($whoisResult["status"]==200);
    }
    public function test_the_service_returns_error_with_invalid_input(): void
    {
		$whoisResult=WhoisService::get("invalid@domain:!");
		$this->assertTrue($whoisResult["status"]==500);
    }
    public function test_the_service_returns_a_successful_response(): void
    {
		$whoisResult=WhoisService::get("google.com");
		$whoisJson=json_decode($whoisResult["content"]);
		$this->assertTrue($whoisResult["status"]==200);
		$this->assertTrue(property_exists($whoisJson,'domain'));
		$this->assertTrue(property_exists($whoisJson,'registrar'));
		$this->assertTrue(property_exists($whoisJson,'registrant'));
		$this->assertTrue(property_exists($whoisJson,'administrative'));
		$this->assertTrue(property_exists($whoisJson,'technical'));
		$this->assertTrue($whoisJson->domain->domain=="google.com");
    }
}