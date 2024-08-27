<?php

namespace App\Http\Livewire\Pages\Dashboards\Wallet\Withdraw;

use App\Helper\Money;
use App\Models\LockBalance;
use App\Models\System;
use App\Models\User;
use App\Models\WithdrawRequest;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Table extends Component
{
    use LivewireAlert;

    public $user;
    public $userObj;
    public $userId;
    public $valueTransfer;
    public $pix;
    public $botaoClicado = false;

    public function requestWithdraw(): void
    {
        if ($this->botaoClicado) {
            return;
        }
        $valorMinimo = System::where('nome_config', 'Valor Minimo')->first()->value;
        $horarioMaximo = System::where('nome_config', 'Horario Maximo')->first()->value;
        $value = Money::toDatabase($this->valueTransfer);
       
        if(intval($value) < intval($valorMinimo) || is_null($this->valueTransfer)){
            $this->alert('warning', 'Valor precisa ser de pelo menos R$'.$valorMinimo, [
                'position' => 'center',
                'timer' => '2000',
                'toast' => false,
                'timerProgressBar' => true,
                'allowOutsideClick' => false
            ]);

            return;
        }
        
        $now = Carbon::now()->format('H');
        if(intval($now) > intval($horarioMaximo)) {
            $this->alert('warning', 'A conversão bônus para saque só poderá ser solicitado até ' . $horarioMaximo . ':00 horas todos os dias', [
                'position' => 'center',
                'timer' => '2000',
                'toast' => false,
                'timerProgressBar' => true,
                'allowOutsideClick' => false
            ]);

            return;
        }

        $value = str_replace(',', '.', $this->valueTransfer);
        $value = Money::toDatabase($this->valueTransfer);

        if ($value > $this->user['available_withdraw']){
            $this->alert('warning', 'Saldo Saque Disponível inferior ao solicitado!', [
                'position' => 'center',
                'timer' => '2000',
                'toast' => false,
                'timerProgressBar' => true,
                'allowOutsideClick' => false
            ]);
            return;
        }

        $maxSaque = auth()->user()->max_saque;

        if (intval($value) > intval($maxSaque)) {
            $this->alert('warning', 'Valor solicitado maior que o seu limite de saque!', [
                'position' => 'center',
                'timer' => '2000',
                'toast' => false,
                'timerProgressBar' => true,
                'allowOutsideClick' => false
            ]);
            return;
        }

       if(intval($value) >= intval($valorMinimo) && intval($value) <= $this->user['available_withdraw']){
        
           $withdrawRequest = WithdrawRequest::create([
               'user_id' => $this->userId,
               'value' => Money::toDatabase($this->valueTransfer)
           ]);

           LockBalance::create([
               'withdraw_request_id' => $withdrawRequest->id,
               'value' => Money::toDatabase($this->valueTransfer)
           ]);

           $this->userObj->available_withdraw = $this->userObj->available_withdraw - Money::toDatabase($this->valueTransfer);
           $this->userObj->pix = $this->pix;

           $this->userObj->save();
           $this->botaoClicado = true;

           $this->flash('success', 'Solicitação realizada com sucesso!', [
               'position' => 'center',
               'timer' => '2000',
               'toast' => false,
               'timerProgressBar' => true,
               'allowOutsideClick' => false
           ], route('admin.dashboards.wallet.index'));
       }
    }

    public function mount(): void
    {           
        $this->user = User::with('client')->find(auth()->id())->toArray();
        $this->userId = auth()->user()->id;
        $this->userObj = auth()->user();
        $this->pix = auth()->user()->pix;
    }

    public function render()
    {
        $valorMinimo = System::where('nome_config', 'Valor Minimo')->first()->value;

        return view('livewire.pages.dashboards.wallet.withdraw.table', ['valorMinimo' => $valorMinimo]);

    }
}
