<?php

namespace App\Http\Livewire\Pages\Dashboards\Wallet;

use App\Helper\Money;
use App\Models\TransactBalance;
use App\Models\User;
use App\Models\WithdrawRequest;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

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

            $this->user->balance += ($this->valueConvert + ($this->valueConvert * ($this->user->commission/100)));
            $this->user->bonus -= $this->valueConvert;
            
            $this->user->save();

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

        if(intval($now) > 15) {
            $this->alert('error', 'A conversão bônus para saque só poderá ser solicitado até 15:00 horas todos os dias', [
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

        if($myOldBonus >= $this->valueConvertBonus) {
            WithdrawRequest::create([
                'user_id'   => $this->user->id,
                'value'     => $this->valueConvertBonus,
                'type'      => 'bonus_to_available_withdraw'
            ]);

            $this->user->balance += $this->valueConvertWithdraw;
            $this->user->available_withdraw -= $this->valueConvertWithdraw;
            
            $this->user->save();

            $this->flash('success', 'Conversão solicitada com sucesso!', [
                'position' => 'center',
                'timer' => '2000',
                'toast' => false,
                'timerProgressBar' => true,
                'allowOutsideClick' => false
            ], route('admin.dashboards.wallet.index'));
        }
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
