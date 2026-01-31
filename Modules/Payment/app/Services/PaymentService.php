<?php
namespace Modules\Payment\App\Services;

use App\Enums\OrderStatus;
use DomainException;
use Modules\Order\App\Models\Order;
use Modules\Payment\App\Models\Payment;
use Modules\Payment\App\Services\PaymentGatewayFactory;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class PaymentService
{
    public function __construct(
        private PaymentGatewayFactory $gatewayService
    ) {}

    public function process(Order $order, string $method)
    {
        if ($order->status !== OrderStatus::CONFIRMED->value) {
            throw new ConflictHttpException(
                'Payments allowed only for confirmed orders'
            );
        }

        [$gateway, $config] =
            $this->gatewayService->process($method);
            $success = $gateway->pay($order, $config);
            $payment = Payment::create([
                'order_id'        => $order->id,
                'payment_method' => $method,
                'status'          => $success ? 'successful' : 'failed',
                'amount'          => $order->total_amount,
            ]);
            if ($success)
            {
                $order->update(['status' => OrderStatus::COMPLETED]);
            }
        return $payment;
    }
}
