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
use App\Helper\ApiWallet;

class Table extends Component
{
    use LivewireAlert;

    public $user;
    public $userObj;
    public $userId;
    public $valueTransfer;
    public $pix;
    public $botaoClicado = false;
    public $checkBoxDesmarcado = true;
    public $checkBoxDescontoDesmarcado = true;
    public $checkBoxValue;
    public $checkBoxValueDesconto;
    public $valorMinimo;

    public function requestWithdraw(): void
    {
        if ($this->botaoClicado) {
            return;
        }
        $this->valorMinimo = System::where('nome_config', 'Valor Minimo')->first()->value;
        $horarioMaximo = System::where('nome_config', 'Horario Maximo')->first()->value;
        $value = Money::toDatabase($this->valueTransfer);

        
        if (empty($this->pix)) {
            $this->alert('warning', 'Chave PIX não informada. Por favor, entre em contato com o suporte.', [
                'position' => 'center',
                'timer' => '2000',
                'toast' => false,
                'timerProgressBar' => true,
                'allowOutsideClick' => false
            ]);
            return;
        }
       
        if(intval($value) < intval($this->valorMinimo) || is_null($this->valueTransfer)){
            $this->alert('warning', 'Valor precisa ser de pelo menos R$'.$this->valorMinimo, [
                'position' => 'center',
                'timer' => '2000',
                'toast' => false,
                'timerProgressBar' => true,
                'allowOutsideClick' => false
            ]);

            return;
        }
        
        $now = Carbon::now()->format('H:i');   
     
        if(Carbon::now()->between(Carbon::parse($this->user['first_schedule_one'])->format('H:i'), Carbon::parse($this->user['second_schedule_one'])->format('H:i'))
         || Carbon::now()->between(Carbon::parse($this->user['first_schedule_two'])->format('H:i'), Carbon::parse($this->user['second_schedule_two'])->format('H:i'))) {
            $this->alert('warning', 'O saque não é Possível entre esses Horários: ' . $this->user['first_schedule_one'] . ' E ' . $this->user['second_schedule_one'] . ' e também entre ' . $this->user['first_schedule_two'] . ' E ' . $this->user['second_schedule_two'], [
                'position' => 'center',
                'timer' => '10000',
                'toast' => false,
                'timerProgressBar' => true,
                'allowOutsideClick' => false
            ]);

            return;
        }

        $value = str_replace(',', '.', $this->valueTransfer);
        $value = Money::toDatabase($this->valueTransfer);

        

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
        
        if($this->checkBoxValue == "bonus"){
            $this->retiradaBonus($value);
        }else if($this->checkBoxValue == "saldo"){
            $this->retiradaSaldo($value);
        }
        
       
    }
    public function marcarCheckBox()
    {
          if($this->checkBoxValue != false){
            $this->checkBoxDesmarcado = false;
          } else{
            $this->checkBoxDesmarcado = true;
          }
        
        
    }
    public function marcarCheckBoxDesconto()
    {
          if($this->checkBoxValueDesconto != false){
            $this->checkBoxDescontoDesmarcado = false;
          } else{
            $this->checkBoxDescontoDesmarcado = true;
          }
        
        
    }

    public function retiradaBonus($valueAtTransfer){
        $retonoApi = ApiWallet::getUsuario($this->user['id']);
       
        if ($valueAtTransfer > $retonoApi->bonus){
            $this->alert('warning', 'Saldo de Bonus inferior ao solicitado!', [
                'position' => 'center',
                'timer' => '2000',
                'toast' => false,
                'timerProgressBar' => true,
                'allowOutsideClick' => false
            ]);
            return;
        }

        if(intval($valueAtTransfer) >= intval($this->valorMinimo) && intval($valueAtTransfer) <= $retonoApi->bonus){
            if($this->checkBoxValueDesconto == "now"){
                $pagamentoAutomatico = "yes";

            }else{
                $pagamentoAutomatico = "no";
            }
            $withdrawRequest = WithdrawRequest::create([
                'user_id' => $this->userId,
                'value' => Money::toDatabase($this->valueTransfer),
                'old_value' => Money::toDatabase($this->user['bonus']),
                'value_a' => Money::toDatabase($this->user['bonus'] - Money::toDatabase($this->valueTransfer)),
                'pagamento_automatico'=>  $pagamentoAutomatico,
                'type' => "Saque de Bônus"
            ]);

            LockBalance::create([
                'withdraw_request_id' => $withdrawRequest->id,
                'value' => Money::toDatabase($this->valueTransfer)
            ]);

            $this->userObj->bonus = $this->userObj->bonus - Money::toDatabase($this->valueTransfer);
            $this->userObj->pix = $this->pix;
 
            $this->userObj->save();
            $retonoApiAltera = ApiWallet::updateUsuario($this->userObj);
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
    
    public function retiradaSaldo($valueAtTransfer){
        $retonoApi = ApiWallet::getUsuario($this->user['id']);

        if ($valueAtTransfer > $retonoApi->available_withdraw){
            $this->alert('warning', 'Saldo Saque Disponível inferior ao solicitado!', [
                'position' => 'center',
                'timer' => '2000',
                'toast' => false,
                'timerProgressBar' => true,
                'allowOutsideClick' => false
            ]);
            return;
        }

        if(intval($valueAtTransfer) >= intval($this->valorMinimo) && intval($valueAtTransfer) <= $retonoApi->available_withdraw){

            if($this->checkBoxValueDesconto == "now"){
                $pagamentoAutomatico = "yes";

            }else{
                $pagamentoAutomatico = "no";
            }
        
            $withdrawRequest = WithdrawRequest::create([
                'user_id' => $this->userId,
                'value' => Money::toDatabase($this->valueTransfer),
                'old_value' => Money::toDatabase($this->user['available_withdraw']),
                'value_a' => Money::toDatabase($this->user['available_withdraw'] - Money::toDatabase($this->valueTransfer)),
                'pagamento_automatico'=>  $pagamentoAutomatico,
                'type' => "Saque de Saldo Disponível"
            ]);
 
            LockBalance::create([
                'withdraw_request_id' => $withdrawRequest->id,
                'value' => Money::toDatabase($this->valueTransfer)
            ]);
 
            $this->userObj->available_withdraw = $this->userObj->available_withdraw - Money::toDatabase($this->valueTransfer);
            $this->userObj->pix = $this->pix;
 
            $this->userObj->save();
            $retonoApiAltera = ApiWallet::updateUsuario($this->userObj);
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
