<?php

use App\Enums\OrderStatus;

return [

    OrderStatus::PENDING    => "En attente",
    OrderStatus::CANCEL     => "Panier non disponible",
    OrderStatus::ACCEPT     => "Accepté",
    OrderStatus::REJECT     => "Rejeté",
    OrderStatus::PROCESS    => "En préparation",
    OrderStatus::ON_THE_WAY => "Prêt à être récupéré",
    OrderStatus::COMPLETED  => "Récupéré",

];
