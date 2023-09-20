<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item d-lg-none">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item pl-3">
        {{ trans('admin.pagesF.saldo') }} R${{\App\Helper\Money::toReal(auth()->user()->balance)}} |
        {{ trans('admin.pagesF.bonus') }}  R${{\App\Helper\Money::toReal(auth()->user()->bonus)}} |
        {{ trans('admin.pagesF.saqueDisponivel') }}  R${{\App\Helper\Money::toReal(auth()->user()->available_withdraw)}}
        </li>
        <li class="nav-item pl-3">
                        <a href="{{ route('admin.dashboards.wallet.recharge') }}" type="button" class="btn btn-block btn-success text-light
                        text-bold">
                            <i class="fas fa-piggy-bank"></i>
                            {{ trans('admin.pagesF.recarregar') }} 
                        </a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" href="https://wa.me/558196826967?text=Olá, Poderia me ajudar?">
               <i class="fas fa-regular fa-question"></i>
            </a>
        </li>
        @php $unreadNotifications = auth()->user()->unreadNotifications; @endphp

        <!-- icone -->
        @if(!empty(auth()->user()->notifications) && count(auth()->user()->notifications) > 0)
            <li class="nav-item dropdown notification_dropdown">
                <a class="nav-link bell ai-icon {{ $unreadNotifications->count() > 0 ? 'show-notifcations-indicatior' : '' }}" href="#" role="button" data-toggle="dropdown">
                    <svg id="icon-user" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 384 512" fill="gray" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"> <path d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM216 232V334.1l31-31c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-72 72c-9.4 9.4-24.6 9.4-33.9 0l-72-72c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l31 31V232c0-13.3 10.7-24 24-24s24 10.7 24 24z"/></svg>
                <!-- <svg id="icon-user"  xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"> -->
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg> 

                    {{-- @if($unreadNotifications->count() > 0) --}}
                        <div class="notifications-count">{{ $unreadNotifications->count() }}</div>
                    {{-- @endif --}}
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div id="DZ_W_Notification1" class="widget-media dz-scroll p-3" style="height:380px; overflow-y: auto">
                        <ul class="timeline">
                            @foreach(auth()->user()->notifications as $notification)
                            <li>
                                <a @if($notification->data['url']) href="{{$notification->data['url']}}" @else href="javascript:;" @endif>
                                <div class="timeline-panel">
                                    <div class="media-body">
                                        <h6 class="mb-1">{{$notification->data['title']}}</h6>
                                        <small class="d-block">{{$notification->created_at->diffForHumans()}}</small>
                                    </div>
                                </div>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <!--<a class="all-notification" href="#">See all notifications <i class="ti-arrow-right"></i></a>-->
                </div>
            </li>
        @endif

        <!--menu de linguagens -->
        <li>
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                   {{ App\Helper\Lang::getCurrentUserLangLabel() }}
                </a>

                @php $availableLangs = App\Helper\Lang::getAvailableLangs() @endphp
                <ul class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                    @if(is_array($availableLangs) && $availableLangs > 0)
                        @foreach($availableLangs as $key => $label)
                            <li style="padding: 5px 10px;">
                                <a href="{{ route('admin.changeLocale', $key) }}" style="color: #555; display: block">{{ $label }}</a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </li>
        </li> 

        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
               <i class="fas fa-cog"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                <p class="px-2 pt-1">
                {{ trans('admin.falta.ola') }}, {{auth()->user()->name}}
                </p>
                @can('read_user')
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{route('admin.settings.users.edit', ['user' => auth()->user()->id])}}">
                    <i class="fas fa-user mr-2"></i> {{ trans('admin.pagesF.conta') }}
                </a>
                @endcan
                @can('edit_all')
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{route('admin.settings.users.edit', ['user' => auth()->user()->id])}}">
                    <i class="fas fa-user mr-2"></i> {{ trans('admin.pagesF.conta') }}
                </a>
                @endcan
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{route('admin.logout')}}">
                    <i class="fas fa-sign-out-alt"></i> {{ trans('admin.pagesF.logout') }}
                </a>
            </div>
        </li>
    </ul>
</nav>
