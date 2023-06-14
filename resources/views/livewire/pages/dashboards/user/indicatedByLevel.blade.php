<div class="col-sm-12">
     <div class="row bg-white p-3">
         <div class="col-sm-12">

            <h4 class="my-4">{{ trans('admin.lwIndicated.userInd') }}  </h4>
         </div>
     </div>
 
     <div class="row">
         @forelse($indicateds as $indicated)

                     <i class="fa fa-user-circle-o fa-5x"></i>
                 </div>
                 <div class="content my-2">
                     <p><b>{{ $indicated['name'] }} {{ $indicated['last_name'] }}</b></p>
                     <p>

                        <small>{{ trans('admin.lwIndicated.cadastReal') }} <br>
                         {{ \Carbon\Carbon::parse($indicated['created_at'])->format('d/m/Y') }}</small>
                     </p>
                 </div>
             </div>
         </div>
         @empty
             <div class="col-sm-12">

                <h4 class="my-4">{{ trans('admin.lwIndicated.nenhumaInd') }} </h4>
             </div>
         @endforelse
     </div>
     <div class="row">
         <div class="col-sm-12">
            {{ $indicateds->links() }}
        </div>
    </div>
</div>
