<aside class="main-sidebar sidebar-dark-info elevation-4" style="overflow-x: hidden">
    <a href="/" class="brand-link">

      <img src="{{ App\Helper\Configs::getConfigLogo() }}"
             alt="Logo"
             class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light" style="font-size: 15px">{{ env("nome_sistema") }}</span>


    </a>

    <div class="sidebar">

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-child-indent" data-widget="treeview"
                role="menu" data-accordion="false">
                <center>
                    <li>
                        <a href="/" class="nav-link"><button type="button" class="btn btn-success">{{ trans('admin.menu.façajogo') }}</button></a>
                    </li>
                </center>
                @canany(['read_sale', 'read_gain'])
                    <li class="nav-item has-treeview @if(request()->is('admin/dashboards/*')) @endif">
                        <a href="#" class="nav-link @if(request()->is('admin/dashboards/*'))menu-open @endif">
                            <i class="nav-icon fas fa-chart-line"></i>
                            <p>
                            {{ trans('admin.menu.dashboard') }}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        
                        <ul class="nav nav-treeview">

                            @if(\App\Helper\Configs::getPlanoDeCarreira() == "Ativado")
                                @can('read_extract')
                                <li class="nav-item">
                                    <a href="{{route('admin.dashboards.ranking.index')}}"
                                        class="nav-link @if(request()->is('admin/ranking')) active @endif">
                                        <i class="fas fa-star nav-icon"></i>
                                        <p>{{ trans('admin.menu.ranking') }}</p>
                                    </a>
                                </li>
                                
                                @endcan
                                    
                               
                                @can('read_extract')
                                <li class="nav-item">
                                    <a href="{{route('admin.dashboards.extracts.points.index')}}"
                                        class="nav-link @if(request()->is('admin/dashboards/extracts/points')) active @endif">
                                        <i class="fas fa-star nav-icon"></i>
                                        <p>{{ trans('admin.menu.pontos') }}</p>
                                    </a>
                                </li>
                                @endcan
                            @endif    
                            @if(\App\Helper\UserValidate::iAmAdmin())
                                <li class="nav-item">
                                    <a href="{{route('admin.dashboards.extracts.winning-ticket')}}"
                                       class="nav-link @if(request()->is('admin/dashboards/extracts/winning-ticket')) active @endif">
                                        <i class="fas fa-file-alt nav-icon"></i>
                                        <p>{{ trans('admin.menu.bilhetesP') }}</p>
                                    </a>
                                </li>
                            @endif
                            @can('read_gain')
                            <li class="nav-item">
                                <a href="/admin/dashboards/Reportday" class="nav-link">
                                <i class="nav-icon fas fa-list-alt "></i>
                                    <p>
                                    {{ trans('admin.menu.vendasR') }}
                                    </p>
                                </a>
                            </li>
                                <li class="nav-item">
                                    <a href="{{route('admin.dashboards.gains.index')}}"
                                       class="nav-link @if(request()->is('admin/dashboards/gains*')) active @endif">
                                        <i class="fas fa-hand-holding-usd nav-icon"></i>
                                        <p> {{ trans('admin.menu.ganhos') }}</p>
                                    </a>
                                </li>                             
                            @endcan
                            @can('read_sale')
                                <li class="nav-item">
                                    <a href="{{route('admin.dashboards.sales.index')}}"
                                       class="nav-link @if(request()->is('admin/dashboards/sales')) active @endif">
                                        <i class="fas fa-funnel-dollar nav-icon"></i>
                                        <p>{{ trans('admin.menu.vendas') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @if(\App\Helper\Configs::getBichao() == "Ativado")
                            @can('read_sale')
                                <li class="nav-item">
                                    <a href="{{route('admin.dashboards.sales.bichao')}}"
                                       class="nav-link @if(request()->is('admin/dashboards/sales/bichao')) active @endif">
                                        <i class="fas fa-funnel-dollar nav-icon"></i>
                                        <p>{{ trans('admin.menu.vendasB') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @endif
                        </ul>
                    </li>
                @endcanany
                @canany(['read_client', 'read_competition', 'read_type_game', 'read_game'])
                    <li class="nav-item has-treeview @if(request()->is('admin/bets/*')) menu-open @endif">
                        <a href="#" class="nav-link @if(request()->is('admin/bets/*')) active @endif">
                            <i class="nav-icon fas fa-ticket-alt"></i>
                            <p>
                            {{ trans('admin.menu.apostas') }}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                        <!--@can('read_client')
                                <li class="nav-item">
                                    <a href="{{route('admin.bets.clients.index')}}"
                                       class="nav-link @if(request()->is('admin/bets/clients*')) active @endif">
                                        <i class="fas fa-users nav-icon"></i>
                                        <p>{{ trans('admin.menu.cliente') }}</p>
                                    </a>
                                </li>
                            @endcan-->

                            @can('read_client')
                                <li class="nav-item">
                                 <a href="{{route('admin.bets.validate-games.index')}}"
                                   class="nav-link @if(request()->is('admin/bets/validate-games*')) active @endif">
                                     <i class="fas fa-check nav-icon"></i>
                                     <p>{{ trans('admin.menu.validarJogo') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @can('read_competition')
                                <li class="nav-item">
                                    <a href="{{route('admin.bets.competitions.index')}}"
                                       class="nav-link @if(request()->is('admin/bets/competitions*')) active @endif">
                                        <i class="fas fa-trophy nav-icon"></i>
                                        <p>{{ trans('admin.menu.concursos') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @can('read_type_game')
                                <li class="nav-item">
                                    <a href="{{route('admin.bets.type_games.index')}}"
                                       class="nav-link @if(request()->is('admin/bets/type_games*')) active @endif">
                                        <i class="fas fa-tags nav-icon"></i>
                                        <p>{{ trans('admin.menu.tiposJogos') }}</p>
                                    </a>
                                </li>
                            @endcan

                            @can('read_game')
                                <li class="nav-item has-treeview @if(request()->is('admin/bets*') && !request()->is('admin/bets/draws*') && !request()->is('admin/bets/comissions*')) menu-open @endif">
                                    <a href="#"
                                       class="nav-link">
                                        <i class="fas fa-ticket-alt nav-icon"></i>
                                        <p>{{ trans('admin.menu.jogos') }}</p>
                                        <i class="right fas fa-angle-left"></i>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @if(\App\Models\TypeGame::count() > 0)
                                            @foreach(\App\Models\TypeGame::get() as $menu)
                                                <li class="nav-item">
                                                    <a href="{{route('admin.bets.games.index', ['type_game' => $menu->id])}}"
                                                       class="nav-link @if(request()->is('admin/bets/games/'. $menu->id) || request()->is('admin/bets/games/create/'. $menu->id)) active @endif">
                                                        <i class="far fa-dot-circle nav-icon"></i>
                                                        <p>{{$menu->name}}</p>
                                                    </a>
                                                </li>
                                            @endforeach
                                        @endif
                                        @if(\App\Helper\Configs::getBichao() == "Ativado")
                                        <li class="nav-item">
                                            <a 
                                                href="{{ route('admin.bets.bichao.index') }}"
                                                class="nav-link @if (request()->is('admin/bets/bichao*')) active @endif"
                                            >
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Bichão da Sorte</p>
                                            </a>
                                        </li>
                                        @endif
                                    </ul>
                                </li>
                            @endcan
                            @canany(['read_payments_commission', 'read_payments_draw'])
                                <li class="nav-item has-treeview @if(request()->is('admin/bets/payments*')) menu-open @endif">
                                    <a href="#"
                                       class="nav-link">
                                        <i class="fas fa-dollar-sign nav-icon"></i>
                                        <p>{{ trans('admin.menu.pagamentos') }}</p>
                                        <i class="right fas fa-angle-left"></i>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @can('read_payments_commission')
                                            <li class="nav-item">
                                                <a href="{{route('admin.bets.payments.commissions.index')}}"
                                                   class="nav-link @if(request()->is('admin/bets/payments/commissions')) active @endif">
                                                    <i class="fas fa-comments-dollar nav-icon"></i>
                                                    <p>{{ trans('admin.menu.comissoes') }}</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('read_payments_draw')
                                            <li class="nav-item">
                                                <a href="{{route('admin.bets.payments.draws.index')}}"
                                                   class="nav-link @if(request()->is('admin/bets/payments/draws')) active @endif">
                                                    <i class="fas fa-donate nav-icon"></i>
                                                    <p>{{ trans('admin.menu.premios') }}</p>
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcanany
                            @if(\App\Helper\Configs::getBichao() == "Ativado")
                                @canany(['read_payments_commission', 'read_payments_draw'])
                                    <li class="nav-item has-treeview @if(request()->is('admin/bets/draws/bichao') || request()->is('admin/bets/comissions/bichao')) menu-open @endif">
                                        <a href="#"
                                            class="nav-link">
                                            <i class="fas fa-dollar-sign nav-icon"></i>
                                            <p>{{ trans('admin.menu.pagamentoB') }}</p>
                                            <i class="right fas fa-angle-left"></i>
                                        </a>
                                    <ul class="nav nav-treeview">
                                            @can('read_payments_commission')
                                            <li class="nav-item">
                                                <a href="{{route('admin.bets.comissions.bichao')}}"
                                                   class="nav-link @if(request()->is('admin/bets/comissions/bichao')) active @endif">
                                                    <i class="fas fa-comments-dollar nav-icon"></i>
                                                    <p>{{ trans('admin.menu.comissoes') }}</p>
                                                </a>
                                            </li>
                                            @endcan
                                            @can('read_payments_draw')
                                            <li class="nav-item">
                                                <a href="{{route('admin.bets.draws.bichao')}}"
                                                   class="nav-link @if(request()->is('admin/bets/draws/bichao')) active @endif">
                                                    <i class="fas fa-donate nav-icon"></i>
                                                    <p>{{ trans('admin.menu.premios') }}</p>
                                                </a>
                                            </li>
                                            @endcan
                                        </ul>
                                    </li>
                                @endcanany
                            @endif
                            @can('read_draw')
                                <li class="nav-item">
                                    <a href="{{route('admin.bets.draws.index')}}"
                                       class="nav-link @if(request()->is('admin/bets/draws')) active @endif">
                                        <i class="fas fa-hand-scissors nav-icon"></i>
                                        <p>{{ trans('admin.menu.sorteio') }}</p>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                @endcanany

                @canany(['read_user', 'read_role', 'read_permission'])
                    <li class="nav-item has-treeview @if(request()->is('admin/reports/*')) menu-open @endif">
                        <a href="#" class="nav-link @if(request()->is('admin/reports/*')) active @endif">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>
                            {{ trans('admin.menu.relatorios') }}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('read_user')
                            <li class="nav-item">
                                <a href="{{route('admin.reports.used.dozens')}}"
                                    class="nav-link @if(request()->is('admin/settings/used-dozens*')) active @endif">
                                    <i class="fas fa-star nav-icon"></i>
                                    <p>{{ trans('admin.menu.dezenasUtiliz') }}</p>
                                </a>

                                <a href="{{route('admin.reports.points-by-user')}}"
                                    class="nav-link @if(request()->is('admin/settings/points-by-user*')) active @endif">
                                    <i class="fas fa-users nav-icon"></i>
                                    <p>{{ trans('admin.menu.pontosCliente') }}</p>
                                </a>

                                @can('read_extract')
                                <li class="nav-item">
                                    <a href="{{route('admin.dashboards.extracts.index')}}"
                                       class="nav-link @if(request()->is('admin/dashboards/extracts/')) active @endif">
                                        <i class="fas fa-file-alt nav-icon"></i>
                                        <p>{{ trans('admin.menu.extrato') }}</p>
                                    </a>
                                </li>
                            @endcan
                            <!--
                            @if(\App\Helper\UserValidate::iAmAdmin())
                                <li class="nav-item">
                                    <a href="{{route('admin.dashboards.extracts.manualRecharge')}}"
                                       class="nav-link @if(request()->is('admin/dashboards/extracts/manual-recharge')) active @endif">
                                        <i class="fas fa-file-alt nav-icon"></i>
                                        <p>{{ trans('admin.menu.extratoRecarga') }} </p>
                                    </a>
                                </li>
                            @endif-->
                            @if (\App\Helper\UserValidate::iAmAdmin())
                                <li class="nav-item">
                                    <a href="{{ route('admin.dashboards.customer.balance') }}"
                                        class="nav-link @if (request()->is('admin/dashboards/custome/balance')) active @endif">
                                        <i class="fas fa-file-alt nav-icon"></i>
                                        <p>{{ trans('admin.menu.saldoClientes') }}</p>
                                    </a>
                                </li>
                            @endif
                            @if(\App\Helper\UserValidate::iAmAdmin())
                                <li class="nav-item">
                                    <a href="{{route('admin.dashboards.extracts.sales')}}"
                                       class="nav-link @if(request()->is('admin/dashboards/extracts/sales')) active @endif">
                                        <i class="fas fa-file-alt nav-icon"></i>
                                        <p>{{ trans('admin.menu.extratoVendas') }}</p>
                                    </a>
                                </li>
                            @endif


                            @if(\App\Helper\Configs::getBichao() == "Ativado")
                            @if(\App\Helper\UserValidate::iAmAdmin())
                                <li class="nav-item">
                                    <a href="{{route('admin.reports.bichao.bilhetes')}}"
                                       class="nav-link @if(request()->is('admin/reports/bichao/bilhetes')) active @endif">
                                        <i class="fas fa-file-alt nav-icon"></i>
                                        <p>{{ trans('admin.menu.bilhete') }}</p>
                                    </a>
                                </li>
                            @endif
                            @endif

                            </li>
                            @endcan

                        </ul>
                    </li>

                @endcanany
                    <li class="nav-link ">
                        <a href="{{route('admin.dashboards.wallet.index')}}"
                        class="nav-link  @if(request()->is('admin/dashboards/wallet/index*')) active @endif">
                        <i class="nav-icon fas fa-wallet"></i>
                        <i class="fas fa-dice-d8 "></i>
                            <p>
                            {{ trans('admin.menu.carteira') }}
                            </p>
                        </a>
                    </li>

                    
                    <li class="nav-item">
                            <a href="{{route('admin.dashboards.help.index')}}"
                                class="nav-link @if(request()->is('/admin/dashboards/tutoriais')) active @endif">
                                <i class="fas fa-book-open nav-icon"></i>
                                <p>Tutoriais</p>
                            </a>
                        </li>
                    </li>
                @canany(['read_user', 'read_role', 'read_permission'])
                <li class="nav-item has-treeview @if(request()->is('admin/settings/*')) menu-open @endif">
                    <a href="#" class="nav-link @if(request()->is('admin/settings/*')) active @endif">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                        {{ trans('admin.menu.configs') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('read_permission')
                            <li class="nav-item">
                                <a href="{{route('admin.settings.permissions.index')}}"
                                   class="nav-link @if(request()->is('admin/settings/permissions*')) active @endif">
                                    <i class="fas fa-user-lock nav-icon"></i>
                                    <p>{{ trans('admin.menu.permissoes') }}</p>
                                </a>
                            </li>
                        @endcan
                        @can('read_role')
                            <li class="nav-item">
                                <a href="{{route('admin.settings.roles.index')}}"
                                   class="nav-link @if(request()->is('admin/settings/roles*')) active @endif">
                                    <i class="fas fa-user-tag nav-icon"></i>
                                    <p>{{ trans('admin.menu.funcoes') }}</p>
                                </a>
                            </li>
                        @endcan
                        @can('read_user')
                            <li class="nav-item">
                                <a href="{{route('admin.settings.users.index')}}"
                                   class="nav-link @if(request()->is('admin/settings/users*')) active @endif">
                                    <i class="fas fa-user nav-icon"></i>
                                    <p>{{ trans('admin.menu.usuarios') }}</p>
                                </a>
                            </li>
                        @endcan
                        @if(\App\Helper\Configs::getPlanoDeCarreira() == "Ativado")
                        @can('read_user')

                        <li class="nav-item">
                            <a href="{{route('admin.settings.qualifications.index')}}"
                                class="nav-link @if(request()->is('admin/settings/qualifications*')) active @endif">
                                <i class="fas fa-star nav-icon"></i>
                                <p>{{ trans('admin.menu.qualificacoes') }}</p>
                            </a>
                        </li>
                        @endcan
                        @endif
                        @can('read_user')
                        <li class="nav-item">
                            <a href="{{route('admin.settings.systems.index')}}"
                                class="nav-link @if(request()->is('admin/settings/system*')) active @endif">
                                <i class="nav-icon fas fa-cog"></i>
                                <p>{{ trans('admin.menu.sistema') }}</p>
                            </a>
                        </li>
                        @endcan
                        @if(\App\Helper\Configs::getBichao() == "Ativado")
                            @can('read_user')
                            <li class="nav-item">
                                <a href="{{ route('admin.settings.bichao.index') }}"
                                    class="nav-link @if (request()->is('admin/settings/bichao*')) active @endif">
                                    <i class="nav-icon fas fa-ticket-alt"></i>
                                    <p>Bichão da sorte</p>
                                </a>
                            </li>
                            @endcan
                        @endif
            @endcanany
            
            </ul>
        </nav>
    </div>
</aside>


