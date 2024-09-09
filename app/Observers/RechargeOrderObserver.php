<?php

namespace App\Observers;

use App\Models\RechargeOrder;
use Illuminate\Support\Str;
use App\Helper\ChaveAleatoria;

class RechargeOrderObserver
{
    /**
     * Handle the RechargeOrder "creating" event.
     *
     * @param  \App\Models\RechargeOrder  $rechargeOrder
     * @return void
     */
    public function creating(RechargeOrder $rechargeOrder)
    {
        if(is_null($rechargeOrder->reference) || empty($rechargeOrder->reference)){
            $rechargeOrder->reference = ChaveAleatoria::generateKey(16);
        }
    }
}
