<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TradersExport implements FromView
{
    public function __construct($orders)
    {
        $this->orders =$orders;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        return view('admin.orders.export', [
            'orders' =>   $this->orders
        ]);
    }
}
