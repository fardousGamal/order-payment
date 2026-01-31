<?php


namespace Modules\Payment\Tests\Unit;

use Modules\Order\App\Models\Order;
use Modules\Payment\App\Models\PaymentGateway;
use Modules\Payment\App\Services\PaymentService;
use Tests\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentProcessorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_throws_exception_if_order_not_confirmed()
    {
        $order = Order::factory()->create([
            'status' => 'pending',
        ]);

        $this->expectException(\DomainException::class);

        $processor = app(PaymentService::class);
        $processor->process($order, 'credit_card');
    }

    /** @test */
    public function it_processes_payment_with_valid_gateway()
    {
        PaymentGateway::create([
            'name' => 'credit_card',
            'config' => ['api_key' => 'test'],
        ]);

        $order = Order::factory()->create([
            'status' => 'confirmed',
            'total_amount' => 100,
        ]);

        $processor = app(PaymentService::class);

        $result = $processor->process($order, 'credit_card');

        $this->assertTrue($result);
    }
}
