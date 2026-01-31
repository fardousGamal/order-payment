<?php
namespace Modules\Payment\App\Services\Gateways;

use Modules\Payment\App\Services\PaymentGatewayInterface;
use Modules\Order\App\Models\Order;

class CreditCardGateway implements PaymentGatewayInterface
{
    public function pay(Order $order, array $config): bool
    {

        return rand(0, 1) === 1;
    }
}
