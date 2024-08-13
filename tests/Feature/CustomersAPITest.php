<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomersAPITest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_get_all_customers_from_a_guest_fails(): void
    {
        Customer::factory()->count(5)->create();

        $response = $this->get('/api/customers');

        $response->assertFound();
    }

    /**
     * A basic feature test example.
     */
    public function test_get_all_customers(): void
    {
        $user = User::factory()->create();
        Customer::factory()->count(5)->create();

        $response = $this->actingAs($user)->get('/api/customers');

        $response->assertStatus(200);
        $this->assertCount(5, $response->json()['data']);
        $this->assertArrayHasKey('id', $response->json()['data'][0]);
        $this->assertArrayHasKey('name', $response->json()['data'][0]);
        $this->assertArrayHasKey('email', $response->json()['data'][0]);
        $this->assertArrayHasKey('address', $response->json()['data'][0]);
        $this->assertArrayHasKey('phone_number', $response->json()['data'][0]);
    }

    /**
     * A basic feature test example.
     */
    public function test_create_a_new_customer_fail_by_validation(): void
    {
        Customer::factory()->create([
            'email' => 'email@example.com'
        ]);
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/api/customers', [
            'email' => 'email@example.com',
        ]);

        $response->assertFound();

        $response->assertInvalid(['name', 'email', 'address', 'phone_number']);
    }

    /**
     * A basic feature test example.
     */
    public function test_create_a_new_customer(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/api/customers', [
            'name' => 'Some Name',
            'email' => 'email@example.com',
            'address' => '6 Tchernikhovski St.',
            'phone_number' => '1-700-70-70-70',
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseCount('customers', 1);
        $this->assertDatabaseHas('customers', [
            'name' => 'Some Name',
            'email' => 'email@example.com',
            'address' => '6 Tchernikhovski St.',
            'phone_number' => '1-700-70-70-70',
        ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_get_a_customer(): void
    {
        $user = User::factory()->create();
        $customer = Customer::factory()->create([
            'name' => 'Some Name',
            'email' => 'email@example.com',
            'address' => '6 Tchernikhovski St.',
            'phone_number' => '1-700-70-70-70',
        ]);

        $response = $this->actingAs($user)->get("/api/customers/{$customer->id}");

        $response->assertStatus(200);
        $this->assertEquals($response->json()['data']['id'], $customer->id);
        $this->assertEquals($response->json()['data']['name'], $customer->name);
        $this->assertEquals($response->json()['data']['email'], $customer->email);
        $this->assertEquals($response->json()['data']['address'], $customer->address);
        $this->assertEquals($response->json()['data']['phone_number'], $customer->phone_number);
    }

    /**
     * A basic feature test example.
     */
    public function test_update_a_customer_fail_by_validation(): void
    {
        $user = User::factory()->create();
        $customer = Customer::factory()->create([
            'name' => 'Some Name',
            'email' => 'email@example.com',
            'address' => '6 Tchernikhovski St.',
            'phone_number' => '1-700-70-70-70',
        ]);

        $response = $this->actingAs($user)->put("/api/customers/{$customer->id}", [
            'name' => 123,
            'email' => 'change_example_com',
            'address' => true,
            'phone_number' => 3.1415926,
        ]);

        $response->assertFound();

        $response->assertInvalid(['name', 'email', 'address', 'phone_number']);

        $this->assertDatabaseCount('customers', 1);
        $this->assertDatabaseHas('customers', [
            'name' => 'Some Name',
            'email' => 'email@example.com',
            'address' => '6 Tchernikhovski St.',
            'phone_number' => '1-700-70-70-70',
        ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_update_a_customer(): void
    {
        $user = User::factory()->create();
        $customer = Customer::factory()->create([
            'name' => 'Some Name',
            'email' => 'email@example.com',
            'address' => '6 Tchernikhovski St.',
            'phone_number' => '1-700-70-70-70',
        ]);

        $response = $this->actingAs($user)->put("/api/customers/{$customer->id}", [
            'name' => 'Other Name',
            'email' => 'change@example.com',
            'address' => '666 Tchernikhovski St.',
            'phone_number' => '1-800-80-80-80',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseCount('customers', 1);
        $this->assertDatabaseMissing('customers', [
            'name' => 'Some Name',
            'email' => 'email@example.com',
            'address' => '6 Tchernikhovski St.',
            'phone_number' => '1-700-70-70-70',
        ]);
        $this->assertDatabaseHas('customers', [
            'name' => 'Other Name',
            'email' => 'change@example.com',
            'address' => '666 Tchernikhovski St.',
            'phone_number' => '1-800-80-80-80',
        ]);
        $this->assertEquals('Other Name', $response->json()['data']['name']);
        $this->assertEquals('change@example.com', $response->json()['data']['email']);
        $this->assertEquals('666 Tchernikhovski St.', $response->json()['data']['address']);
        $this->assertEquals('1-800-80-80-80', $response->json()['data']['phone_number']);
    }

    /**
     * A basic feature test example.
     */
    public function test_delete_a_customer(): void
    {
        $user = User::factory()->create();
        $customer = Customer::factory()->create();
        $this->assertDatabaseCount('customers', 1);

        $response = $this->actingAs($user)->delete("/api/customers/{$customer->id}");

        $response->assertOk();
        $this->assertEmpty($response->json()['data']);
        $this->assertDatabaseCount('customers', 0);
    }
}
