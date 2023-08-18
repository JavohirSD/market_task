<?php

namespace Tests\Feature;

use App\Models\Merchants;
use App\Models\Shops;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Regsite new user test
     * @return void
     */
    public function test_register_new_user()
    {
        $requestData = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'secretpassword',
        ];

        $response = $this->postJson(route('register'), $requestData);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'data' => [
                    'user' => [
                        'id',
                        'name',
                        'email',
                        'created_at',
                        'updated_at',
                    ],
                    'token',
                ],
                'message',
            ]);

        // Check if the user is actually created in the database
        $this->assertDatabaseHas('users', ['email' => 'johndoe@example.com']);
    }


    /**
     * Create new merchant test
     * @return void
     */
    public function test_create_new_merchant()
    {
        $user = User::factory()->create();

        $requestData = [
            'name'    => 'Test Merchant',
            'balance' => 1000,5,
            'status'  => 2,
        ];

        // Mock authentication
        $this->actingAs($user);

        $response = $this->postJson(route('merchant.store'), $requestData);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'user_id',
                    'name',
                    'balance',
                    'status',
                    'created_at',
                    'updated_at',
                ],
                'message',
            ]);

        $this->assertDatabaseHas('merchants', ['name' => 'Test Merchant']);
    }


    /**
     * Create new shop test
     * @return void
     */
    public function test_create_new_shop()
    {
        $user = User::factory()->create();

        Merchants::factory()->create(['user_id' => $user->id]);

        $requestData = [
            'address'   => '123 Tashkent',
            'schedule'  => '8 AM - 6 PM',
            'latitude'  => 41.315565,
            'longitude' => -69.258780,
            'status'    => 2,
        ];

        $this->actingAs($user);

        $response = $this->postJson(route('shop.store'), $requestData);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'merchant_id',
                    'address',
                    'schedule',
                    'latitude',
                    'longitude',
                    'status',
                ],
            ]);

        $this->assertDatabaseHas('shops', ['address' => '123 Tashkent']);
    }

    /**
     * For error case
     * @return void
     */
    public function test_returns_error_if_no_merchant()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->postJson(route('shop.store'), [
            'address'   => '1234 Tashkent',
            'schedule'  => '8 AM - 6 PM',
            'latitude'  => 41.315565,
            'longitude' => -69.258780,
            'status'    => 2,
        ]);

        $response->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJson([
                'success' => false,
                'data'    => null,
                'message' => 'Please create merchant first',
            ]);
    }


    /**
     * Nearest shops sort by distance test
     * @return void
     */
    public function test_nearest_shops_for_given_location()
    {
        $user = User::factory()->create();

        $merchant = Merchants::factory()->create(['user_id' => $user->id]);

        Shops::factory()->create([
            'merchant_id' => $merchant->id,
            'latitude'    => 41.31965100,
            'longitude'   => 69.26021500,
        ]);

        Shops::factory()->create([
            'merchant_id' => $merchant->id,
            'latitude'    => 41.32546500,
            'longitude'   => 69.26059400,
        ]);

        $url = route('shop.nearest') . '?merchant_id=' . $merchant->id . '&latitude=41.31570600&longitude=69.25621000';

        $response = $this->actingAs($user)->getJson($url);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'merchant_id',
                        'address',
                        'schedule',
                        'latitude',
                        'longitude',
                        'status',
                        'distance',
                    ],
                ],
            ]);

        $this->assertTrue($response->json('data.0.distance') < $response->json('data.1.distance'));
    }

}
