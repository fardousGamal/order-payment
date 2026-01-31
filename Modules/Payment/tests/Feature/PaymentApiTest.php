<?php
namespace Modules\Payment\Tests\Feature;
use Modules\Order\App\Models\Order;
use Modules\Payment\App\Models\PaymentGateway;
use Tests\TestCase;
use App\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentApiTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate()
    {
        $user = User::factory()->create();

        $token = auth('api')->login($user);

        return [
            'Authorization' => "Bearer $token"
        ];
    }

    /** @test */
    public function user_can_process_payment_for_confirmed_order()
    {
        PaymentGateway::create([
            'name' => 'credit_card',
            'config' => ['api_key' => 'test'],
        ]);

        $order = Order::factory()->create([
            'status' => 'confirmed',
            'total_amount' => 150,
        ]);

        $response = $this->withHeaders($this->authenticate())
            ->postJson('/api/v1/payments', [
                'order_id' => $order->id,
                'payment_method' => 'credit_card',
            ]);

        $response->assertStatus(201);
    }

    /** @test */
    public function payment_fails_for_unconfirmed_order()
    {
        $order = Order::factory()->create([
            'status' => 'pending',
        ]);

        $response = $this->withHeaders($this->authenticate())
            ->postJson('/api/v1/payments', [
                'order_id' => $order->id,
                'payment_method' => 'credit_card',
            ]);

        $response->assertStatus(422);
    }

    /** @test */
    public function user_view_payments_list()
    {
        $response = $this->withHeaders($this->authenticate())
            ->getJson('/api/v1/payments');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'meta',
            ]);
    }
}
