<?php

namespace App\Http\Controllers\Admin\Pages\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\LogUsuario;
use Auth;
use Spatie\Permission\Models\Role;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Throwable;

class RegisterController extends Controller
{
    public function registerIndicate()
    {
        if(!request('indicate')){
            return redirect(route('register'));
        }

        $indicador = User::where('id', request('indicate'))->first();

        if(!$indicador){
            echo "<script>setTimeout(function(){ window.location.href = '/register'; }, 3000);</script>";

            return response(<<<HTML
<div class="alert alert-success" role="alert">
  <h4 class="alert-heading">Algo errado aconteceu!</h4>
  <p>Não encontramos o seu indicador. :(</p>
  <hr>
  <p class="mb-0">Você será redirecionado para a tela de cadastro em alguns instantes.</p>
</div>
HTML);
        }
        $cookie = Cookie::make('indicatorSuperLoto', $indicador->id, (60*24));
        return redirect(route('register'))->withCookie($cookie);
    }

    public function showRegisterForm()
    {
        $findIndicator = 1;
        if(Cookie::has('indicatorSuperLoto')){
            $findIndicator = Cookie::get('indicatorSuperLoto');
        }
        $indicator = User::find($findIndicator);

        return view('admin.pages.auth.register2', ['indicator' => $indicator]);
    }

    protected function create(Request $request)
    {   
        
           
        $this->validate(request(), [
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
            'indicator' => ['required'],
        ]);
 

        try {   
            
                $phone = Str::of($request->phone)->replaceMatches('/[^A-Za-z0-9]++/', '');
                $hashed = Hash::make($request->password);

                $userRoles[] = Role::whereId(13)->first();




                $user = User::create([
                    'name' => $request->name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'indicador' => $request->indicator,
                    'password' => $hashed,
                    'type_client' => 1,
                    'is_active' => 1,
                    'contact_made' => 0
                ]);
                
                $user->syncRoles($userRoles);

                Client::create([
                    'name' => $request->name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'pix' => $request->pix,
                    'ddd' => Str::of($phone)->substr(0, 2),
                    'phone' => Str::of($phone)->substr(2),
                ]);

               
                $description = "Usuário registrado indicado por usuário de ID '" . $request->indicator . "' com os seguintes dados:" . "\n"; //colocar tudo que foi modificado
                $description .= "Nome: " . $request->name . "\n";
                $description .= "Sobrenome: " . $request->last_name . "\n";
                $description .= "E-mail: " . $request->email . "\n";
                $description .= "PIX: " . $request->pix . "\n";
                $description .= "Telefone: " . $request->telefone . "\n";
                $description .= "Senha: " . $hashed . "\n";

                $descricao =  $description;
                LogUsuario::create([
                    'user_id_sender' => $request->indicator,
                    'user_id' => $user->id,
                    'nome_funcao' => "Registro",
                    'description' => $descricao,
                ]);
                
                
                Auth::guard('admin')->login($user);

              

            return redirect('/admin/dashboards/wallet/recharge');

        } catch (Throwable $e) {
            return $e;
        }
    }
}
