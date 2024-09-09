<aside id="sidebar" class="main-sidebar sidebar-dark-info d-none d-md-block elevation-4" style="overflow-x: hidden">

    <div class="sidebar">

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-child-indent" data-widget="treeview"
                role="menu" data-accordion="false">

                @foreach ($layout_button as $layout)
                <li>
                <a href="{{$layout->link}}" @if ($layout->novapagina == 1) target="_blank" @endif class="nav-link @if ($layout->visivel == 0) d-none @endif">
                        <button type="button" style="background:{{$layout->cor}};"
                            class="btn btn-success btn-side d-flex justify-content-around align-items-center">
                            <p>{!!$layout->first_text!!}</p>
                            <div style="width:35px">{!! $layout->second_text !!}</div>
                        </button>


                    </a>
                </li>
                @endforeach


                <!-- VISUALIZAÇÃO LIVRE A TODOS -->
                <li
                    class="nav-item nav-group-item has-treeview  @if(request()->is('admin/bets*') && !request()->is('admin/bets/draws*') && !request()->is('admin/bets/comissions*')) menu-open @endif">
                    <a href="#" class="nav-link nott">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" width="21"
                            viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                            <path fill="#ffffff"
                                d="M216.6 49.9C205.1 38.5 189.5 32 173.3 32C139.4 32 112 59.4 112 93.3v4.9c0 12 3.3 23.7 9.4 34l18.8 31.3c1.1 1.8 1.2 3.1 1 4.2c-.2 1.2-.8 2.5-2 3.6s-2.4 1.8-3.6 2c-1 .2-2.4 .1-4.2-1l-31.3-18.8c-10.3-6.2-22-9.4-34-9.4H61.3C27.4 144 0 171.4 0 205.3c0 16.2 6.5 31.8 17.9 43.3l1.2 1.2c3.4 3.4 3.4 9 0 12.4l-1.2 1.2C6.5 274.9 0 290.5 0 306.7C0 340.6 27.4 368 61.3 368h4.9c12 0 23.7-3.3 34-9.4l31.3-18.8c1.8-1.1 3.1-1.2 4.2-1c1.2 .2 2.5 .8 3.6 2s1.8 2.4 2 3.6c.2 1 .1 2.4-1 4.2l-18.8 31.3c-6.2 10.3-9.4 22-9.4 34v4.9c0 33.8 27.4 61.3 61.3 61.3c16.2 0 31.8-6.5 43.3-17.9l1.2-1.2c3.4-3.4 9-3.4 12.4 0l1.2 1.2c11.5 11.5 27.1 17.9 43.3 17.9c33.8 0 61.3-27.4 61.3-61.3v-4.9c0-12-3.3-23.7-9.4-34l-18.8-31.3c-1.1-1.8-1.2-3.1-1-4.2c.2-1.2 .8-2.5 2-3.6s2.4-1.8 3.6-2c1-.2 2.4-.1 4.2 1l31.3 18.8c10.3 6.2 22 9.4 34 9.4h4.9c33.8 0 61.3-27.4 61.3-61.3c0-16.2-6.5-31.8-17.9-43.3l-1.2-1.2c-3.4-3.4-3.4-9 0-12.4l1.2-1.2c11.5-11.5 17.9-27.1 17.9-43.3c0-33.8-27.4-61.3-61.3-61.3h-4.9c-12 0-23.7 3.3-34 9.4l-31.3 18.8c-1.8 1.1-3.1 1.2-4.2 1c-1.2-.2-2.5-.8-3.6-2s-1.8-2.4-2-3.6c-.2-1-.1-2.4 1-4.2l18.8-31.3c6.2-10.3 9.4-22 9.4-34V93.3C336 59.4 308.6 32 274.7 32c-16.2 0-31.8 6.5-43.3 17.9l-1.2 1.2c-3.4 3.4-9 3.4-12.4 0l-1.2-1.2z" />
                        </svg>
                        <p class="title-link">LOTERIAS</p>
                        <i class="right fas fa-angle-left"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        @if(\App\Models\TypeGame::count() > 0)
                        @foreach(\App\Models\TypeGame::get() as $menu)
                        <li class="nav-item">
                            <a href="{{route('admin.bets.games.index', ['type_game' => $menu->id])}}"
                                class="nav-link @if(request()->is('admin/bets/games/'. $menu->id) || request()->is('admin/bets/games/create/'. $menu->id)) active @endif">
                                <!-- <i class="far fa-dot-circle nav-icon"></i> -->
                                <img width="25" class="mr-2" src="/storage/{{$menu->icon}}" alt="">
                                <p>{{$menu->name}}</p>
                            </a>
                        </li>
                        @endforeach
                        @endif

                    </ul>
                </li>
                @if(\App\Helper\Configs::getBichao() == "Ativado")
                <li
                    class="nav-item nav-group-item has-treeview @if(request()->is('admin/bets/bichao*')) menu-open @endif">
                    <a href="#" class="nav-link nott @if(request()->is('admin/bets/bichao/*'))menu-open @endif">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p class="title-link">
                            Bichão da Sorte
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ route('admin.bets.bichao.index') }}"
                                class="nav-link @if(request()->is('admin/bets/bichao')) active @endif">
                                <i class="nav-icon fas fa-ticket-alt"></i>
                                <p>Apostar</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.bets.bichao.resultados') }}"
                                class="nav-link @if(request()->is('admin/bets/bichao/resultados')) active @endif">
                                <i class="fas fa-trophy nav-icon"></i>
                                <p>Resultados</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.bets.bichao.cotacao') }}"
                                class="nav-link @if(request()->is('admin/bets/bichao/cotacao')) active @endif">
                                <i class="fa fa-money nav-icon" aria-hidden="true"></i>
                                <p>Cotação</p>
                            </a>
                        </li>
                        @can('read_gain')
                        <li class="nav-item">
                            <a href="{{ route('admin.bets.bichao.minhas.apostas') }}"
                                class="nav-link @if(request()->is('admin/bets/bichao/minhas*')) active @endif">
                                <i class="fas fa-star nav-icon"></i>
                                <p>Minhas Apostas</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif
                @can('read_game')


                @canany(['read_sale', 'read_gain'])
                <li
                    class="nav-item nav-group-item has-treeview @if(request()->is('admin/dashboards/*')) menu-open @endif">
                    <a href="#" class="nav-link @if(request()->is('admin/dashboards/*'))menu-open @endif">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p class="title-link">
                            {{ trans('admin.menu.dashboard') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">

                        @if(\App\Helper\Configs::getPlanoDeCarreira() == "Ativado")
                        @if(auth()->user()->hasRole('Administrador'))
                        @can('read_gain')
                        <li class="nav-item">
                            <a href="{{route('admin.dashboards.ranking.index')}}"
                                class="nav-link @if(request()->is('admin/ranking')) active @endif">
                                <i class="fas fa-star nav-icon"></i>
                                <p>{{ trans('admin.menu.ranking') }}</p>
                            </a>
                        </li>

                        @endcan
                        @endif

                        @can('read_gain')
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

                <li
                    class="nav-item nav-group-item has-treeview @if(request()->is('admin/bets/*/')) menu-open @endif">
                    
                    @can('read_client')
                    <a href="#" class="nav-link @if(request()->is('admin/bets/*'))  @endif">
                        <i class="nav-icon fas fa-ticket-alt"></i>
                        <p class="title-link">
                            <!-- Aqui, novo nome -->
                            <!-- {{ trans('admin.menu.apostas') }} -->
                            Ferramentas
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    @endcan
                    
                    <ul class="nav nav-treeview">     
                       @if(auth()->user()->hasRole('Administrador'))
                            @can('read_client')
                                <li class="nav-item">
                                    <a href="{{route('admin.bets.clients.index')}}"
                                        class="nav-link @if(request()->is('admin/bets/clients*')) active @endif">
                                        <i class="fas fa-users nav-icon"></i>
                                        <p>{{ trans('admin.menu.cliente') }}</p>
                                    </a>
                                </li>
                            @endcan
                        @endif
                        @unless(auth()->user()->hasRole('Administrador'))
                            @can('read_client')
                                <li class="nav-item">
                                    <a href="{{route('admin.bets.consultor')}}"
                                        class="nav-link @if(request()->is('admin/bets/clients*')) active @endif">
                                        <i class="fas fa-users nav-icon"></i>
                                        <p>{{ trans('admin.menu.cliente') }}</p>
                                    </a>
                                </li>
                            @endcan
                        @endunless
                        
                        @can('read_client')
                        <li class="nav-item">
                            <a href="{{route('admin.bets.validate-games.index')}}"
                                class="nav-link @if(request()->is('admin/bets/validate-games*')) active @endif">
                                <i class="fas fa-check nav-icon"></i>
                                <p>{{ trans('admin.menu.validarJogo') }}</p>
                            </a>
                        </li>
                        @endcan
                        @endif

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

                        @canany(['read_payments_commission', 'read_payments_draw'])
                        <li class="nav-item has-treeview @if(request()->is('admin/bets/payments*')) menu-open @endif">
                            <a href="#" class="nav-link">
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
                        <li
                            class="nav-item has-treeview @if(request()->is('admin/bets/draws/bichao') || request()->is('admin/bets/comissions/bichao')) menu-open @endif">
                            <a href="#" class="nav-link">
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




                @canany(['read_user', 'read_role', 'read_permission'])
                <li class="nav-item nav-group-item has-treeview @if(request()->is('admin/reports/*')) menu-open @endif">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p class="title-link">
                            {{ trans('admin.menu.relatorios') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('read_user')
                        <li class="nav-item">
                            <a href="{{route('admin.reports.used.dozens')}}"
                                class="nav-link @if(request()->is('admin/reports/used-dozens*')) active @endif">
                                <i class="fas fa-star nav-icon"></i>
                                <p>{{ trans('admin.menu.dezenasUtiliz') }}</p>
                            </a>

                            <a href="{{route('admin.reports.points-by-user')}}"
                                class="nav-link @if(request()->is('admin/reports/points-by-user*')) active @endif">
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
                        @if(\App\Helper\UserValidate::iAmAdmin())
                            <li class="nav-item">
                                <a href="{{route('admin.dashboards.extracts.manualRecharge')}}"
                                    class="nav-link @if(request()->is('admin/dashboards/extracts/manual-recharge')) active @endif">
                                    <i class="fas fa-file-alt nav-icon"></i>
                                    <p>{{ trans('admin.menu.extratoRecarga') }} </p>
                                </a>
                            </li>
                        @endif

                        @if(\App\Helper\UserValidate::iAmAdmin())
                            <li class="nav-item">
                                <a href="{{route('admin.dashboards.extracts.newExtract')}}"
                                    class="nav-link @if(request()->is('admin/dashboards/extracts/new-extract')) active @endif">
                                    <i class="fas fa-file-alt nav-icon"></i>
                                    <p>{{ trans('admin.menu.novoExtrato') }} </p>
                                </a>
                            </li>
                        @endif
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
            @canany(['read_user', 'read_role', 'read_permission'])
            <li class="nav-item nav-group-item has-treeview @if(request()->is('admin/settings/*')) menu-open @endif">
                <a href="#" class="nav-link @if(request()->is('admin/settings/*')) active @endif">
                    <i class="nav-icon fas fa-cog"></i>
                    <p class="title-link">
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
                    @can('read_user')
                    <li class="nav-item">
                        <a href="{{route('admin.settings.layout.index')}}"
                            class="nav-link @if(request()->is('admin/settings/layout*')) active @endif">
                            <i class="fas fa-user nav-icon"></i>
                            <p>Layout</p>
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
                        <a href="{{ route('admin.settings.consultoresIndicados') }}"
                            class="nav-link @if(request()->is('settings/consultores-indicados*')) active @endif">
                            <i class="fas fa-users nav-icon"></i>
                            <p>{{ trans('Consultores') }}</p>
                        </a>
                    </li>
                    
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
                            <p>{{ trans('admin.tutoriais.bichaos') }}</p>
                        </a>
                    </li>
                    @endcan
                    @endif
                    @endcanany

                </ul>

                @endcanany

            </li>
            @canany(['read_user', 'read_role', 'read_permission'])

            <div class="nav-item nav-group-item has-treeview @if(request()->is('admin/result/*')) menu-open @endif">
                <a href="{{route('admin.dashboards.result.index')}}"
                    class="nav-link @if(request()->is('admin/result/*')) active @endif">
                    <i class="fa fa-trophy" aria-hidden="true"></i>
                    <p class="title-link" style="margin:0px;">
                        Lista de Ganhadores
                    </p>
                </a>

            </div>
            @endcanany

            <div class="nav-item nav-group-item has-treeview @if(request()->is('admin/settings/*')) menu-open @endif">
                <a href="{{route('admin.dashboards.help.index')}}"
                    class="nav-link @if(request()->is('admin/settings/*')) active @endif">
                    <i class="fas fa-book-open nav-icon"></i>
                    <p class="title-link" style="margin:0px;">
                        {{ trans('admin.menu.tutoriais') }}
                    </p>
                </a>

            </div>
            <!-- <li class="nav-link">
                <a href="{{route('admin.dashboards.wallet.index')}}"
                    class="nav-link  @if(request()->is('admin/dashboards/wallet/index*')) active @endif">
                    <i class="nav-icon fas fa-wallet"></i>
                    <i class="fas fa-dice-d8 "></i>
                    <p>
                        {{ trans('admin.menu.carteira') }}
                    </p>
                </a>
            </li>


            <li class="nav-link">
                <a href="{{route('admin.dashboards.help.index')}}"
                    class="nav-link @if(request()->is('/admin/dashboards/tutoriais')) active @endif">
                    <i class="fas fa-book-open nav-icon"></i>
                    <p> {{ trans('admin.menu.tutoriais') }} </p>
                </a>
            </li> -->
            </li>

        </nav>
    </div>
</aside>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Verifique se a largura da tela é menor que 768 pixels (ou ajuste conforme necessário)
        if (window.innerWidth < 768) {
            setTimeout(function () {
                // Quando a página carregar e estiver em uma tela mobile, remova a classe d-none do elemento com o id "sidebar"
                var sidebar = document.getElementById("sidebar");
                sidebar.classList.remove("d-none");
            }, 1000);
        }
    });
</script>
