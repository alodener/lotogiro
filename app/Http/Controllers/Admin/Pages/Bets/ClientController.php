<?php

namespace App\Http\Controllers\Admin\Pages\Bets;

use App\Helper\Mask;
use App\Http\Controllers\Controller;
use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Resources\ClientResource;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
        public function index(Request $request)
        {
            if(!auth()->user()->hasPermissionTo('read_client')){
                abort(403);
            }

            if ($request->ajax()) {
                if (auth()->user()->hasRole('Administrador')){
                 $client = $this->client->get();
                }else{
                $client = $this->client->get();
                }
                return DataTables::of($client)
                    ->addIndexColumn()
                    ->addColumn('action', function ($client) {
                        $data = '<div class="btn-group" role="group">';
                        if(auth()->user()->hasPermissionTo('read_client')){
                            $data .= '<a href="' . route('admin.bets.clients.edit', ['client' => $client->id]) . '">
                                <button class="btn btn-sm btn-warning" title="Editar"><i class="far fa-edit"></i></button>
                            </a>';
                        }
            
                        /*if (auth()->user()->hasPermissionTo('read_client') && $client->consultor_id == null) {
                            $data .= '&nbsp; <button class="btn btn-sm btn-success" style="width: 31px; height: 31px; " client="' . $client->id . '" title="Vincular" data-toggle="modal" id="btn_vincular_client" data-target="#modal_vincular_client">
                                        <i class="fas fa-link"></i>
                                      </button>';
                            
                        }*/
                
                       /* if(auth()->user()->hasPermissionTo('delete_client')) {
                            $data .= '<button class="btn btn-sm btn-danger" id="btn_delete_client" client="' . $client->id . '" title="Deletar" data-toggle="modal" data-target="#modal_delete_client"> <i class="far fa-trash-alt"></i></button>';
                        }*/
                        return $data;
                    })
                    ->editColumn('name', function ($client) {
                        return $client->name. ' '. $client->last_name;
                    })
                    ->editColumn('cpf', function ($client) {
                        return Mask::addMaskCpf($client->cpf);
                    })
                    ->editColumn('created_at', function ($client) {
                        return Carbon::parse($client->created_at)->format('d/m/Y');
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return view('admin.pages.bets.client.index');
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!auth()->user()->hasPermissionTo('create_client')){
            abort(403);
        }

        return view('admin.pages.bets.client.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!auth()->user()->hasPermissionTo('create_client')){
            abort(403);
        }

        $validatedData = $request->validate([
         'name' => 'required|max:50',
         'last_name' => 'required|max:100',
         // 'cpf' => 'required|max:14',
         'phone' => 'required|max:100',
         // 'email' => 'unique:App\Models\User|email:rfc|required|max:100',
         // 'bank' => 'required|max:100',
         //'agency' => 'required|max:20',
         //'type_account' => 'required|max:20',
         //'account' => 'required|max:50',
         //'pix' => 'required|max:50',
         //'password' => 'min:8|same:password_confirmation|required|max:15',
         //'password_confirmation' => 'required|max:15',
        ]);

        $request['cpf'] = preg_replace('/[^0-9]/', '', $request->cpf);
        $request['phone'] = preg_replace('/[^0-9]/', '', $request->phone);

        try {
            $client = new $this->client;
            $client->cpf = $request->cpf;
            $client->name = $request->name;
            $client->last_name = $request->last_name;
            $client->ddd = substr($request->phone, 0, 2);
            $client->phone = substr($request->phone, 2);
            $client->consultor_id = $request->consultor_id;
            $client->email = $request->email;
            $client->bank = $request->bank;
            $client->type_account = $request->type_account;
            $client->agency = $request->agency;
            $client->account = $request->account;
            $client->pix = $request->pix;
            //$client->password = Hash::make('alterar123');
            $client->save();

            return redirect()->route('admin.bets.clients.index')->withErrors([
                'success' => 'Cliente cadastrado com sucesso'
            ]);

        } catch (\Exception $exception) {

            return redirect()->route('admin.bets.clients.create')->withErrors([
                'error' => config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro ao criar o cliente, tente novamente'
            ]);
         }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        if(!auth()->user()->hasPermissionTo('update_client')){
            abort(403);
        }
        

        return view('admin.pages.bets.client.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
            if (!auth()->user()->hasPermissionTo('update_client')) {
                abort(403);
            }
        
            $validatedData = $request->validate([
                'name' => 'required|max:50',
                'last_name' => 'required|max:100',
                'phone' => 'required|max:100',
            ]);

            
            $request['cpf'] = preg_replace('/[^0-9]/', '', $request->cpf);
            $request['phone'] = preg_replace('/[^0-9]/', '', $request->phone);
        
            try {
                $user = User::where('email', $client->email)->first();
        
                if ($user) {
                    $telefone = null;
                    
                    if (!is_null($request->name)) {
                        $user->name = $request->name;
                    }
        
                    if (!is_null($request->last_name)) {
                        $user->last_name = $request->last_name;
                    }
        
                    if (!is_null($request->email)) {
                        $user->email = $request->email;  
                    }
        
                    if (!is_null($request->cpf)) {
                        $user->cpf = $request->cpf;
                    }

                    if (!is_null($request->pix)) {
                        $user->pixSaque = $request->pix;  
                    }
                    
                    if (!is_null($request->phone)) {
                    $telefoneCompleto = Str::of($request->phone)->replaceMatches('/[^A-Za-z0-9]++/', '');
                    $ddd = Str::of($telefoneCompleto)->substr(0, 2); 
                    $telefone = Str::of($telefoneCompleto)->substr(2);
                    
                    $user->ddd = $ddd;
                    $user->phone = $telefone;
                }
        
                    $user->save();
                }
        
                $client->cpf = $request->cpf;
                $client->name = $request->name;
                $client->last_name = $request->last_name;
                $client->ddd = substr($request->phone, 0, 2);
                $client->phone = substr($request->phone, 2);
                $client->consultor_id = $request->consultor_id;
                $client->email = $request->email;
                $client->bank = $request->bank;
                $client->type_account = $request->type_account;
                $client->agency = $request->agency;
                $client->account = $request->account;
                $client->pix = $request->pix;
                $client->save();
        
                return redirect()->route('admin.bets.clients.index')->withErrors([
                    'success' => 'Cliente alterado com sucesso'
                ]);
        
            } catch (\Exception $exception) {
                return redirect()->route('admin.bets.clients.edit', ['client' => $client->id])->withErrors([
                    'error' => config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro ao alterar o cliente, tente novamente'
                ]);
            }

            try {

                if (!is_null($request->consultor_id)) {
                    $user->id = $request->consultor_id;
                    $client->save();
                }
        
                return view('admin.pages.bets.client.index', ['client' => $client]);

        
        
                } catch (\Exception $exception) {
                    return redirect()->route('admin.bets.clients.index')->withErrors([
                    'error' => config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro ao adicionar cliente, tente novamente'
                ]);
                }
        

        }
        

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        if(!auth()->user()->hasPermissionTo('delete_client')){
            abort(403);
        }

        try {
            $client->delete();

            return redirect()->route('admin.bets.clients.index')->withErrors([
                'success' => 'Cliente deletado com sucesso'
            ]);

        } catch (\Exception $exception) {

            return redirect()->route('admin.bets.clients.index')->withErrors([
                'error' => config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro ao deletar o cliente, tente novamente'
            ]);

        }
    }

    public function listSelect(Request $request)
    {
        $clients = Client::orWhere('name', 'like', '%' . $request->q . '%')->orWhere('last_name', 'like', '%' . $request->q . '%')->get();

        return ClientResource::collection($clients);
    }


   

     
    public function vincularCliente(Request $request, $id_client)
    {    
        $client = Client::find($id_client);
        

            if ($client->consultor_id === null) {

                $consultorId = Auth::user()->id;       
                $client->consultor_id = $consultorId;
                $client->save();
        
                return redirect()->route('admin.bets.clients.index')->withErrors([
                    'success' => 'Cliente vinculado com sucesso'
                ]);

            }

            return redirect()->back()->withErrors([
            'error' => 'O cliente já está vinculado a um consultor.'
        ]);
    

    }
    public function clientConsultor(Request $request)
    {

        $user = auth()->user();
        $consultorId = $user->id;
        
        if ($request->ajax()) {
        $user = User::where('indicador', $consultorId)->get();
        
        return DataTables::of($user)
                    ->addIndexColumn()
                ->editColumn('name', function ($user) {
                    return $user->name. ' '. $user->last_name;    
                })
                ->editColumn('cpf', function ($user) {
                    return Mask::addMaskCpf($user->cpf);
                })
                ->editColumn('created_at', function ($user) {
                    return Carbon::parse($user->created_at)->format('d/m/Y');
                })
                ->make(true);
        
            }
    
        return view('admin.pages.bets.client.consultorclients');
        
    }
    

}

