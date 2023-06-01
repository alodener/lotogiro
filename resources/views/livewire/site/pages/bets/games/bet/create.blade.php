<div>
    <div>
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>


       @endif
     </div>
     <table class="table">
         <thead>
         <tr>

            <th scope="col">{{ trans('admin.sitePages.type') }} </th>
            <th scope="col">{{ trans('admin.sitePages.conc') }} </th>
            <th scope="col">{{ trans('admin.sitePages.dateSort') }} </th>
         </tr>
         </thead>
         <tbody>
         <tr>
             <td>{{$typeGame->name}}</td>
             @if(empty($typeGame->competitions->last()))

                <td colspan="2" class="text-danger">{{ trans('admin.sitePages.nExist') }} </td>
             @else
                 <td>{{$typeGame->competitions->last()->number}}</td>
                 <td>{{\Carbon\Carbon::parse($typeGame->competitions->last()->sort_date)->format('d/m/Y H:i:s')}}</td>
             @endif
         </tr>

                     @if(isset($values) && $values->count() > 0)
                         @foreach($values as $value)
                     <input type="text" id="multiplicador" value="{{$value->multiplicador}}" name="multiplicador" hidden>
                     <input type="text" id="maxreais" value="{{$value->maxreais}}" name="maxreais" hidden>
                     <input type="text" id="valueId" value="{{$value->id}}" name="valueId" hidden>
                    {{ trans('admin.sitePages.digitValue') }}
                     <input wire:model="vv" type="text" id="vv" wire:change="$set('premio', '0')" value="{{old('vv', $vv ?? null)}}" name="vv" required oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                    {{ trans('admin.sitePages.valP') }} R$
                     <input wire:model="premio" type="text" id="premio" value="{{old('premio', $premio ?? null)}}"name="premio" required disabled>
                    <button  class="btn btn-info" wire:click="calcular()" type="button">{{ trans('admin.sitePages.calc') }} </button>
                         @endforeach
                     @endif
             </div>
         </div>
         <div class="row">
             <div class="col-md-12">
                 @if(isset($matriz))

                    <h4>{{ trans('admin.sitePages.selecN') }} ({{count($selectedNumbers)}}/{{$numbers}})</h4>
 
                     @if($typeGame->name == "SLG - 15 LotofÃ¡cil" || $typeGame->name == "SLG - 20 LotoMania" || $typeGame->name == "Lotogiro - 1000X LotofÃ¡cil" || $typeGame->name == "ACUMULADO 15 lotofacil")

                    <button wire:click="selecionaTudo()" class="btn btn-info" type="button">{{ trans('admin.sitePages.selecNum') }} </button>
                     @endif
                     
                     <br>
                     <br>
                     {{-- puxar do banco de dados quantos numeros pode se jogar --}}

         </div>
         <div class="row">
             <div class="col-md-12">
                 @if($premio > 0 && $vv > 0)
                 <button type="submit" id="button_game"

                        class="btn btn-block btn-outline-success">{{ trans('admin.sitePages.criarJ') }}
                 </button>
                     
                 @else
                 <button type="submit" id="button_game"
                class="btn btn-block btn-outline-success" disabled>{{ trans('admin.sitePages.criarJ') }}
                 </button>
                       
                 @endif
             </div>
         </div>
    </form>

</div>


