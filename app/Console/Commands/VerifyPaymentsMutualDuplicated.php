<?php

namespace App\Console\Commands;

use App\Models\RechargeOrder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Helper\Configs;
use Illuminate\Support\Facades\DB;
use App\Models\TransactBalance;
use App\Models\User;
use App\Notifications\RechargeProcessedNotification;
class VerifyPaymentsMutualDuplicated extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lotoverify:paymentsMutual';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verify payments.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
        
        $paymentReference = DB::table('recharge_order')
                ->select('reference', 'user_id', DB::raw('Count(*) as total'))
                ->where('status', 1)
                
                ->groupBy('reference')
                ->groupBy('user_id')
                ->havingRaw('total > 1')
                ->get();
        
        $contador = 0;
        foreach ($paymentReference as $recharge) {
            
            $paymentReferenceFor = RechargeOrder::where('reference', $recharge->reference)->get();
             foreach ($paymentReferenceFor as $rechargeFor) {
                 
                 echo  "1 passada" . $rechargeFor;
                if($rechargeFor->status == 1){
                    $contador++;
                echo  "Entrou no if 1" . $rechargeFor;
                }
                if($contador > 1){
                    echo  "Entrou no if 2" . $rechargeFor;
                    $user = User::find($rechargeFor->user_id);
                    $totalRecharge = $rechargeFor->value;
                    $rechargeOrderNotification = RechargeOrder::where('id', $rechargeFor->id)->where('status', 1)->first();
                    $deleted = RechargeOrder::where('id', $rechargeFor->id)->delete();
                    TransactBalance::create([
                        'user_id_sender' => 759,
                        'user_id' => $user->id,
                        'value' => $totalRecharge,
                        'old_value' => $user->balance,
                        'value_a' => $user->balance + $totalRecharge,
                        'type' => "Recarga efetuada por meio da plataforma"
                     ]);
                    $user->balance += $totalRecharge;
                    $user->save();
                    
                    
                    if($rechargeOrderNotification != null){
                    $user = User::where('id', $rechargeOrderNotification->user_id )->first();
                    $user->notify(new RechargeProcessedNotification($user, $rechargeOrderNotification));
                    }
                 }
             }
            
        }
                echo  $paymentReference;
                
    }
}
