<div>
    <div class="row m-0 p-0">
        <div class="col-md-12 p-0 m-0 mb-3">
            <div class="input-group mb-3">
                <input wire:model="search" type="text" id="author" class="form-control" placeholder="{{ trans('admin.search-user') }}" autocomplete="off">
                <div class="input-group-append">
                    <span wire:click="clearUser" class="input-group-text" title="Limpar"><i class="fas fa-user-times"></i></span>
                </div>
            </div>
        </div>
        <div class="col-md-12 m-0">
            @if($showList)
                <ul class="list-group">
                    @foreach($users as $user)
                        <li wire:click="setId({{ $user }})"
                            class="list-group-item" style="cursor:pointer;">{{ $user->name . ' ' . $user->last_name . ' - ' . $user->email}}</li>
                    @endforeach
                </ul>
            @endif
        </div>
        <input type="hidden" id="livewire-client-id" value="{{ $userId }}" />
    </div>
</div>

@push('styles')
    <link href="{{asset('admin/layouts/plugins/select2/css/select2.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('admin/layouts/plugins/select2-bootstrap4-theme/select2-bootstrap4.css')}}" rel="stylesheet"/>
@endpush

@push('scripts')

    <script src="{{asset('admin/layouts/plugins/daterangepicker/moment.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
    <script src="{{asset('admin/layouts/plugins/select2/js/select2.min.js')}}"></script>


    <script>

        $(document).ready(function () {
            $('#user').select2({
                theme: "bootstrap"
            });
        });
    </script>

@endpush

@push('styles')
    <style>

        @media screen and (max-width: 760px) {
            
            .extractable-cel {
                font-size: 8px;
            }
            .extractable-cel thead th {
                font-size: 9px;
                text-align: center;
            }

    </style>
@endpush
