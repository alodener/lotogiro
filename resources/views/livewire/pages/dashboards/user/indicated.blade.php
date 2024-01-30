<div class="d-flex flex-column ">
    <div class="">
        <div class="card-header">
            <h4 class="my-4">{{ trans('admin.lwIndicated.userInd') }} </h4>
        </div>
    </div>

    <div class="d-flex flex-wrap  justify-content-center align-items-center ">
        @forelse($indicateds as $indicated)
        <div class="col-sm-3 card-master mr-1 mb-1">
            <div class="card flex-column" style="cursor: pointer; {{ $indicated->hasRole([2, 4, 5]) ? 'background-color: #28a745;' : '' }}" wire:click="redirectToRoute({{ $indicated->id }})">
            <div class="p-3">
                    <svg data-v-7515e7cb="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width:80px;">

                        <path fill="#a3d712" d="M256 272c39.77 0 72-32.24 72-72S295.8 128 256 128C216.2 128 184 160.2 184 200S216.2 272 256 272zM288 320H224c-47.54 0-87.54 29.88-103.7 71.71C155.1 426.5 203.1 448 256 448s100.9-21.53 135.7-56.29C375.5 349.9 335.5 320 288 320z" class="primary"></path>

                        <path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 128c39.77 0 72 32.24 72 72S295.8 272 256 272c-39.76 0-72-32.24-72-72S216.2 128 256 128zM256 448c-52.93 0-100.9-21.53-135.7-56.29C136.5 349.9 176.5 320 224 320h64c47.54 0 87.54 29.88 103.7 71.71C356.9 426.5 308.9 448 256 448z" class="secondary"></path>
                    </svg>
                </div>
                <div class="content">
                    <p><b>{{ $indicated->name }} {{ $indicated->last_name }}</b></p>
                    @php $userClient = $indicated->customer() @endphp
                    <p><b>Contato: {{ $userClient ? $userClient->ddd : '' }} {{ $userClient ? $userClient->phone : '-'
                            }}</b></p>
                    <p>
                        <small>Cadastro realizado em: <br>
                            {{ \Carbon\Carbon::parse($indicated->created_at)->format('d/m/Y') }}</small>
                    </p>
                </div>
            </div>
        </div>
        @empty
        <div class="card-header">
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