<?php
namespace Modules\Payment\App\Services;


use Modules\Order\App\Models\Order;

interface PaymentGatewayInterface
{
    public function pay(Order $order, array $config): bool;
}

