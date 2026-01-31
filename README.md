## Setup
-composer install
-cp .env.example .env
-php artisan key:generate

# Authentication / JWT-based authentication
- php artisan jwt:secret 

# run migration
php artisan migrate 

# to add payment Gateways (credit card and paypal) run:
- php artisan module:seed Payment  

## Payment Gateway Extensibility
    - Database-driven gateway configuration
  
     1. Add DB record
        INSERT INTO payment_gateways (name, config)
        VALUES ('new_gateway', '{"secret":"sk_test"}');
    
    2. Create class in Modules\Payment\App\Services
        class NewGateway implements PaymentGatewayInterface
        {
            public function pay(Order $order, array $config): bool
            {
                return true;
            }
        }
    
    3. Register in PaymentGatewayFactory
        'new_gateway' => new NewGateway()


## Testing
    - php artisan test Modules/Payment/Tests 

## API Documentation URL
    - https://er30nhkmvn.apidog.io/
