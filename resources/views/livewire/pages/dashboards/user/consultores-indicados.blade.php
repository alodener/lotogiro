<div>
   <h2>Consultores</h2>

   <!-- Filtro de quantidade de registros por página e pesquisa -->
   <div class="form-row mb-3">
       <div class="col">
           <div class="form-group">
               <label for="perPage">Registros por página:</label>
               <select wire:model="perPage" id="perPage" class="form-control">
                   <option value="10">10</option>
                   <option value="25">25</option>
                   <option value="50">50</option>
                   <option value="100">100</option>
               </select>
           </div>
       </div>

       <div class="col">
           <div class="form-group">
               <label for="search">Buscar por Nome:</label>
               <input type="text" wire:model.debounce.300ms="search" id="search" class="form-control" placeholder="Digite o nome ou sobrenome para pesquisar">
           </div>
       </div>
   </div>

   <table class="table table-striped table-hover table-dark">
       <thead class="thead-dark">
           <tr>
               <th>Nome</th>
               <th>Classificação</th>
               <th>Email</th>
               <th>Comissão</th>
               <th>Comissão NV1</th>
               <th>Comissão NV2</th>
               <th>Comissão NV3</th>
               <th>Comissão NV4</th>
               <th>Comissão NV5</th>
               <th>Comissão NV6</th>
               <th>Ações</th>
           </tr>
       </thead>
       <tbody>
           @foreach($consultores as $consultor)
               <tr>
                   <td>{{ $consultor->name }} {{ $consultor->last_name }}</td>
                   <td>{{ $consultor->roles->first()->name ?? 'Não classificado' }}</td>
                   <td>{{ $consultor->email }}</td>
                   <td>{{ $consultor->commission ?? '-' }}</td>
                   <td>{{ $consultor->commission_lv_1 ?? '-' }}</td>
                   <td>{{ $consultor->commission_lv_2 ?? '-' }}</td>
                   <td>{{ $consultor->commission_lv_3 ?? '-' }}</td>
                   <td>{{ $consultor->commission_lv_4 ?? '-' }}</td>
                   <td>{{ $consultor->commission_lv_5 ?? '-' }}</td>
                   <td>{{ $consultor->commission_lv_6 ?? '-' }}</td>
                   <td>
                       <a href="{{ route('admin.settings.nominees', ['consultorId' => $consultor->id]) }}" class="btn btn-warning text-green">
                           <i class="bi bi-people-fill"></i>
                       </a>
                       <a href="{{ route('admin.settings.users.edit', $consultor->id) }}" class="btn btn-warning text-yellow">
                           <i class="bi bi-pencil"></i>
                       </a>
                   </td>
               </tr>
           @endforeach
       </tbody>
   </table>

   <!-- Controles de paginação -->
   <div class="d-flex justify-content-center">
       {{ $consultores->links() }}
   </div>
</div>
