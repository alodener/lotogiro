<?php

namespace App\Http\Controllers\Admin\Pages\Settings;

use App\Http\Controllers\Controller;
use App\Models\System;
use Carbon\Carbon;
use FontLib\Table\Type\post;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Helper\Pagination;
use App\Models\UsersHasPoints;




class SystemController extends Controller
{

    protected $system;


    public function __construct(System $system)
    {
        $this->system = $system;
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {     

        $system = System::all() ;
        
       
        return view ('admin.pages.settings.system.sistema', ['system' => $system]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, System $system)
    {   
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\System  $system
     * @return \Illuminate\Http\Response
     */
    public function edit(System $system)
    {
        
        return view('admin.pages.settings.system.edit',['system' => $system]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, System $system)
    {
        
        $data = $request->all();        
        
        //Token
        if(isset($request->token))
        {
            $system->value = $data['token'];
        
        } 
       
        //Plano de carreira
        else if(isset ($request->exampleRadios))
        {
            
            $system->value = $data['exampleRadios'];
            
        }
        else if(isset ($request->exampleRadios2))
        {
            
            $system->value = $data['exampleRadios2'];
            
        }

        //Bichão
         if(isset ($request->exampleRadios3))
        {
            
            $system->value = $data['exampleRadios'];
            
        }
        else if(isset ($request->exampleRadios4))
        {
            
            $system->value = $data['exampleRadios2'];
            
        }
        //email/remetente

        if(isset($request->mail) && isset($request->remetente))
        {
           $system->value = implode("|", [$data['mail'], $data['remetente']]);
        }

        //Logo
        else if(isset($request->image))
        {
            if ($request->file('image')->isValid())
            {
                $image = $request->image->store('logo');
                $data['logo'] = $image;
             
                $system->value = $data['logo'];
               
             }
        }   
        //telegramUrlBot
        if(isset($request->telegrambot))
        {
            $system->value = $data['telegrambot'];
        
        }
        //TelegramChatid
        if(isset($request->telegramchatid))
        {
            $system->value = $data['telegramchatid'];
        
        }  


        try{
            $system->save();
            return redirect()->route('admin.settings.systems.index')->withErrors([
                'success' => 'Configuração alterada com sucesso!'
            ]);
        } catch (\Exception $exception) {

            return redirect()->route('admin.settings.systems.index')->withErrors([
                'error' => config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro ao cadastrar a imagem, tente novamente'
            ]);
   }
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function desativar(Request $request, $id)
    {
     $UserHasPoints = System::findOrFail($id);
     $UserHasPoints->desativarFuncao();
    return redirect()->back()->with('success', 'Função desativada com sucesso!');
    }
}
