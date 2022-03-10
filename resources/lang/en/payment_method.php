<?php

use App\Enums\PaymentMethod;

return [
    PaymentMethod::CASH_ON_DELIVERY => 'Paiement à la livraison',
    PaymentMethod::PAYPAL           => 'Paypal',
    PaymentMethod::STRIPE           => 'Stripe',
    PaymentMethod::WALLET           => 'YummyCOIN'
];
