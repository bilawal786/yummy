<?php

use App\Enums\TransactionType;

return [
    TransactionType::ADDFUND  => 'Ajout de fonds',
    TransactionType::PAYMENT  => 'Paiement',
    TransactionType::REFUND   => 'Remboursé',
    TransactionType::TRANSFER => 'Transfert',
    TransactionType::WITHDRAW => 'Retrait',
];
