<?php

namespace App\Http\Controllers\Admin\Pages\Settings;

use App\Http\Controllers\Controller;
use App\Models\Layout;
use App\Models\Layout_Button;
use Carbon\Carbon;
use FontLib\Table\Type\post;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Helper\Pagination;
use App\Models\UsersHasPoints;




class LayoutController extends Controller
{

    protected $layout;


    public function __construct(Layout $layout)
    {
        $this->layout = $layout;
    }



    public function index(Request $request)
    {     

        $layout = Layout::all() ;
        
       
        return view ('admin.pages.settings.layout.index', ['layout' => $layout]);
    }




    public function edit(Layout $layout)
    {
        $layout_button = Layout_Button::all() ;
        return view('admin.pages.settings.layout.edit',['layout' => $layout,'layout_button' => $layout_button]);
    }



    public function update(Request $request, Layout_Button $layout_button)
    {
        
        $data = $request->all();   
       


        // Campos PUT Button 1

        if(isset($request->visivel_btn1))
        {
            $layout_button->visivel = $data['visivel_btn1'];
        } 

        if(isset($request->first_text_btn1))
        {
            $layout_button->first_text = $data['first_text_btn1'];
        } 

        if(isset($request->second_text_btn1))
        {
            $layout_button->second_text = $data['second_text_btn1'];
        } 

        if(isset($request->cor_btn1))
        {
            $layout_button->cor = $data['cor_btn1'];
        } 

        if(isset($request->link_btn1))
        {
            $layout_button->link = $data['link_btn1'];
        } 

        $layout_button->where('id', 1)->update([
            'visivel' => $layout_button->visivel,
            'first_text' => $layout_button->first_text,
            'second_text' => $layout_button->second_text,
            'cor' => $layout_button->cor,
            'link' => $layout_button->link,
        ]); 

        if(isset($request->visivel_btn2))
        {
            $layout_button->visivel = $data['visivel_btn2'];
        } 

        if(isset($request->first_text_btn2))
        {
            $layout_button->first_text = $data['first_text_btn2'];
        } 

        if(isset($request->second_text_btn2))
        {
            $layout_button->second_text = $data['second_text_btn2'];
        } 

        if(isset($request->cor_btn2))
        {
            $layout_button->cor = $data['cor_btn2'];
        } 

        if(isset($request->link_btn2))
        {
            $layout_button->link = $data['link_btn2'];
        } 

        $layout_button->where('id', 2)->update([
            'visivel' => $layout_button->visivel,
            'first_text' => $layout_button->first_text,
            'second_text' => $layout_button->second_text,
            'cor' => $layout_button->cor,
            'link' => $layout_button->link,
        ]); 

        try{
           

        
            
            return redirect()->route('admin.settings.layout.index')->withErrors([
                'success' => 'Configuração alterada com sucesso!'
            ]);
        } catch (\Exception $exception) {

            return redirect()->route('admin.settings.layout.index')->withErrors([
                'error' => config('app.env') != 'production' ? $exception->getMessage() : 'Ocorreu um erro ao cadastrar a imagem, tente novamente'
            ]);
   }
        

        
   
   }

   
 
}
