<?php

namespace App\Http\Livewire\Pages\Dashboards\Wallet;

use App\Helper\Money;
use App\Models\TransactBalance;
use App\Models\User;
use App\Models\WithdrawRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use App\Helper\ApiWallet;

class Convert extends Component
{
    use LivewireAlert;

    public $valueConvert;
    public $valueConvertBonus;
    public $valueConvertWithdraw;
    public $user;

    public function transferBalance(): void
    {
        $this->valueConvert = Money::toDatabase($this->valueConvert);
        $myOldBalance = $this->user->balance;
        $myOldBonus = $this->user->bonus;

        if($myOldBonus < $this->valueConvert){
            $this->alert('error', 'Valor precisa ser menor ou igual ao seu Bônus!', [
                'position' => 'center',
                'timer' => '2000',
                'toast' => false,
                'timerProgressBar' => true,
                'allowOutsideClick' => false
            ]);
        }

        if($myOldBonus >= $this->valueConvert) {

            $this->user->balance += $this->valueConvert;
            $this->user->bonus -= $this->valueConvert;
            
            $this->user->save();
            $alteraUsuarioApi = ApiWallet::updateUsuario($this->user);
            $this->storeTransact($this->user, $this->valueConvert, $myOldBalance, $this->user->balance,  "Saldo recebido a partir de Bônus.");

            $this->flash('success', 'Conversão realizada com sucesso!', [
                'position' => 'center',
                'timer' => '2000',
                'toast' => false,
                'timerProgressBar' => true,
                'allowOutsideClick' => false
            ], route('admin.dashboards.wallet.index'));
        }
    }

    public function transferBonusToAvailableWithdraw(): void
    {
        $this->valueConvertBonus = Money::toDatabase($this->valueConvertBonus);
        $myOldBonus = $this->user->bonus;
        $now = Carbon::now()->format('H');
    
        if(intval($now) > 23) {
            $this->alert('error', 'A conversão bônus para saque só poderá ser solicitada até 15:00 horas todos os dias', [
                'position' => 'center',
                'timer' => '2000',
                'toast' => false,
                'timerProgressBar' => true,
                'allowOutsideClick' => false
            ]);
    
            return;
        }
    
        if($myOldBonus < $this->valueConvertBonus){
            $this->alert('error', 'Valor precisa ser menor ou igual ao seu Bônus!', [
                'position' => 'center',
                'timer' => '2000',
                'toast' => false,
                'timerProgressBar' => true,
                'allowOutsideClick' => false
            ]);
    
            return;
        }
    
        $withdraw_request = WithdrawRequest::select(DB::raw('SUM(value) AS convert_requested'))
                                            ->where('user_id', auth()->user()->id)
                                            ->where('status', 0)
                                            ->where('type', 'bonus_to_available_withdraw')
                                            ->first();
    
        $available_to_request = $myOldBonus - $withdraw_request->convert_requested;
    
        if($this->valueConvertBonus > $available_to_request) {
            $this->alert('error', 'Valor precisa ser menor ou igual ao seu Bônus disponível! Bônus disponível: R$'. $available_to_request , [
                'position' => 'center',
                'timer' => '2000',
                'toast' => false,
                'timerProgressBar' => true,
                'allowOutsideClick' => false
            ]);
    
            return;
        }
    
    
       /* if($myOldBonus >= $this->valueConvertBonus) {
            WithdrawRequest::create([
                'user_id'   => $this->user->id,
                'value'     => $this->valueConvertBonus,
                'type'      => 'bonus_to_available_withdraw'
            ]);*/
    
            $this->user->bonus -= $this->valueConvertBonus;
            $this->user->available_withdraw += $this->valueConvertBonus;
            
            $this->user->save();
            
            $this->storeTransact($this->user, $this->valueConvertBonus, $myOldBonus, $this->user->bonus,  "Saldo disponivel recebido atravez do bônus.");
    
            $this->flash('success', 'Conversão solicitada com sucesso!', [
                'position' => 'center',
                'timer' => '2000',
                'toast' => false,
                'timerProgressBar' => true,
                'allowOutsideClick' => false
            ], route('admin.dashboards.wallet.index'));
        /*}*/
    }
    
    public function transferAvailableWithdrawToBalance(): void
    {
        $this->valueConvertWithdraw = Money::toDatabase($this->valueConvertWithdraw);
        $myOldWithdraw = $this->user->available_withdraw;
        $myOldBalance = $this->user->balance;

        if($myOldWithdraw < $this->valueConvertWithdraw){
            $this->alert('error', 'Valor precisa ser menor ou igual ao seu Saque Disponível!', [
                'position' => 'center',
                'timer' => '2000',
                'toast' => false,
                'timerProgressBar' => true,
                'allowOutsideClick' => false
            ]);
        }

        if($myOldWithdraw >= $this->valueConvertWithdraw) {
            $this->user->balance += $this->valueConvertWithdraw;
            $this->user->available_withdraw -= $this->valueConvertWithdraw;
            
            $this->user->save();
            $alteraUsuarioApi = ApiWallet::updateUsuario($this->user);
            $this->storeTransact($this->user, $this->valueConvertWithdraw, $myOldBalance, $this->user->balance,  "Saldo recebido a partir de Saque Disponível.");

            $this->flash('success', 'Conversão realizada com sucesso!', [
                'position' => 'center',
                'timer' => '2000',
                'toast' => false,
                'timerProgressBar' => true,
                'allowOutsideClick' => false
            ], route('admin.dashboards.wallet.index'));
        }
    }

    private function storeTransact(User $user, string $value, string $oldValue, string $valueA,  string $type): void
    {
        TransactBalance::create([
            'user_id_sender' => $user->id,
            'user_id' => $user->id,
            'value' => $value,
            'old_value' => $oldValue,
            'value_a' => $valueA,
            'type' => $type
        ]);
    }

    public function mount()
    {
        $this->user = auth()->user();
    }
    public function render()
    {
        return view('livewire.pages.dashboards.wallet.convert');
    }
}
