<?php

namespace Modules\Payment\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Payment\App\Models\PaymentGateway;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentGateway::insert([
            [
                'name' => 'credit_card',
                'config' => json_encode([
                    'api_key' => 'cc_key',
                    'secret' => 'cc_secret'
                ]),
            ],
            [
                'name' => 'paypal',
                'config' => json_encode([
                    'client_id' => 'paypal_client',
                    'secret' => 'paypal_secret'
                ]),
            ]
        ]);
    }
}
