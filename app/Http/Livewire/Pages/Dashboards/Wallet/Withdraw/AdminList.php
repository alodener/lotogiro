<?php

namespace App\Http\Livewire\Pages\Dashboards\Wallet\Withdraw;

use App\Helper\Money;
use App\Models\LockBalance;
use App\Models\TransactBalance;
use App\Models\User;
use App\Models\WithdrawRequest;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use App\Helper\UserValidate;

class AdminList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function withdrawDone($withdrawId)
    {
        $withdrawRequest = WithdrawRequest::findOrFail($withdrawId);
        $withdrawRequest->update([
            'status' => 1
        ]);

        $userRequest = User::findOrFail($withdrawRequest->user_id);

        if($withdrawRequest->type == 'bonus_to_available_withdraw') {
            $user = User::find($withdrawRequest->user_id);

            $myOldWithdraw = $user->available_withdraw;

            $user->available_withdraw += $withdrawRequest->value;
            $user->bonus -= $withdrawRequest->value;
            
            $user->save();

            $this->storeTransact($user, $withdrawRequest->value, $myOldWithdraw, $user->available_withdraw, "Saque Disponível recebido a partir de Bônus.", 'available_withdraw');
        } else if ($withdrawRequest->type == 'Saque de Saldo Disponível'){
            
            TransactBalance::create([
                'user_id_sender' => auth()->id(),
                'user_id' => $userRequest->id,
                'value' => $withdrawRequest->value,
                'old_value' => $withdrawRequest->old_value,
                'value_a' => $withdrawRequest->value_a,
                'type' => 'Solicitação de Saque disponível finalizada.'
            ]);
    
            LockBalance::where('withdraw_request_id', $withdrawRequest->id)->first()->update([
                'status' => 1
            ]);
        }else if ($withdrawRequest->type == 'Saque de Bônus'){
            TransactBalance::create([
                'user_id_sender' => auth()->id(),
                'user_id' => $userRequest->id,
                'value' => $withdrawRequest->value,
                'old_value' => $withdrawRequest->old_value,
                'value_a' => $withdrawRequest->value_a,
                'type' => 'Solicitação de Saque de Bônus finalizada.'
            ]);
    
            LockBalance::where('withdraw_request_id', $withdrawRequest->id)->first()->update([
                'status' => 1
            ]);
    }
}

    private function storeTransact(User $user, string $value, string $oldValue, string $valueA,  string $type, string $wallet = 'balance'): void
    {
        TransactBalance::create([
            'user_id_sender' => $user->id,
            'user_id' => $user->id,
            'value' => $value,
            'old_value' => $oldValue,
            'value_a' => $valueA,
            'type' => $type,
            'wallet' => $wallet
        ]);
    }

    public function render()
    {
        $withdraws = WithdrawRequest::with('user')
            ->where('user_id', auth()->id())
            ->where('status', 0)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            

        if(UserValidate::iAmAdmin()){
            $withdraws = WithdrawRequest::with('user')
                ->orderBy('created_at', 'desc')
                ->where('status', 0)
                ->paginate(10);
        }

        $withdraws->each(function($item, $key){
            $item->data = Carbon::parse($item->created_at)->format('d/m/y à\\s H:i');
            $item->responsavel = $item->user->name;
            $item->pix = $item->user->pix;
            $item->value = Money::toReal($item->value);
            $item->statusTxt = $item->status === 0 ? 'À fazer' : 'Feito';
        });

        return view('livewire.pages.dashboards.wallet.withdraw.admin-list', [
            'withdraws' => $withdraws
        ]);

        return view('livewire.pages.dashboards.wallet.withdraw.admin-with', [
            'withdraw' => $withdraws
        ]);
    }
}

