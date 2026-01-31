<?php
namespace Modules\Payment\App\Services\Gateways;

use Modules\Order\App\Models\Order;
use Modules\Payment\App\Services\PaymentGatewayInterface;

class PaypalGateway implements PaymentGatewayInterface
{
    public function pay(Order $order, array $config): bool
    {
        return rand(0, 1) === 1;
    }
}
