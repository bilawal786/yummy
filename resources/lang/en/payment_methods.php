<?php

use App\Enums\PaymentMethod;

return [
    PaymentMethod::CASH_ON_DELIVERY => 'À la livraison',
    PaymentMethod::PAYPAL           => 'Par PayPal',
    PaymentMethod::STRIPE           => 'Par Stripe',
];
