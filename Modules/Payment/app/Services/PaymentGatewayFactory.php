<?php
namespace Modules\Payment\App\Services;

use InvalidArgumentException;
use Modules\Payment\App\Models\PaymentGateway;
use Modules\Payment\App\Services\Gateways\CreditCardGateway;
use Modules\Payment\App\Services\Gateways\PaypalGateway;

class PaymentGatewayFactory
{
    public function process(string $method): array
    {
        $gateway = PaymentGateway::where('name', $method)
            ->firstOrFail();

        $strategy = match ($gateway->name) {
            'credit_card' => new CreditCardGateway(),
            'paypal'      => new PaypalGateway(),
            default       => throw new InvalidArgumentException('Unsupported gateway'),
        };

        return [$strategy, $gateway->config];
    }
}
