<?php

namespace Tests\Feature;
use Illuminate\Testing\Fluent\AssertableJson;
// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class appTest extends TestCase
{
    public function test_the_application_returns_error_with_no_input(): void
    {
        $response = $this->get('/api/whois/');
        $response->assertStatus(404);
    }
    public function test_the_application_returns_error_with_no_sld(): void
    {
        $response = $this->get('/api/whois//com');
        $response->assertStatus(404);
    }
    public function test_the_application_returns_error_with_no_tld(): void
    {
        $response = $this->get('/api/whois/google/');
        $response->assertStatus(404);
    }
    public function test_the_application_returns_error_with_invalid_sld(): void
    {
        $response = $this->getJson('/api/whois/invalid@domain:!/com');
        $response->assertStatus(400)
			->assertJson(fn (AssertableJson $json) =>
				$json->where('status', '400')
					 ->where('error', 'Not a valid SLD name')
				);
    }
    public function test_the_application_returns_error_with_invalid_tld(): void
    {
        $response = $this->getJson('/api/whois/google/invalid@domain:!');
        $response->assertStatus(400)
			->assertJson(fn (AssertableJson $json) =>
				$json->where('status', '400')
					 ->where('error', 'Not a valid TLD name')
				);
    }
    public function test_the_application_returns_error_with_not_com_domain(): void
    {
        $response = $this->getJson('/api/whois/aruba/it');
        $response->assertStatus(400)
			->assertJson(fn (AssertableJson $json) =>
				$json->where('status', '400')
					 ->where('error', 'Not allowed domain')
				);
    }
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->getJson('/api/whois/google/com');
        $response->assertStatus(200)
			->assertJson(fn (AssertableJson $json) =>
				$json->hasAll(['domain', 'registrar', 'registrant', 'administrative', 'technical'])
			)
			->assertJsonPath('domain.domain', 'google.com');
    }
}
