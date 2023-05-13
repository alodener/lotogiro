<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{asset('admin/layouts/plugins/overlayScrollbars/css/OverlayScrollbars.css')}}">
    <link rel="stylesheet" href="{{asset('admin/layouts/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/layouts/plugins/toastr/toastr.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/layouts/css/master.css')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:100,400,600">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Exo&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quattrocento&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.0/dist/alpine.min.js" defer></script>

    <link rel="shortcut icon" href="{{ App\Helper\Configs::getConfigLogo() }}">


    @livewireStyles

    <style>
        body, * {
            font-family: "Exo", sans-serif;
        }

        .hide {
            display: none;
        }
    </style>

    @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed @impersonating($guard = null) impersonating  @endImpersonating" style="font-family: Montserrat, sans-serif;">

@impersonating($guard = null)
    <div class="leave-current-user-wrapper">
        <span><strong>Conectado Como: </strong> {{ auth()->user()->name }}</span>
        <a href="{{ route('admin.settings.users.logout-as') }}" class="text-white">X Sair da Sessão</a>
    </div>

    <style>
        body.impersonating{
            padding-top: 50px;
        }
        .leave-current-user-wrapper {
            display: flex;
            justify-content: space-between;
            position: absolute;
            top: 0;
            width: 100%;
            background: #000;
            z-index: 999999;
            padding: 10px 20px;
            text-align: center;
            color: #fff
        }
    </style>
@endImpersonating

@if (session('success'))
    @push('scripts')
        <script>
            toastr["success"]("{{ session('success') }}")
        </script>
    @endpush
@endif
@if (session('error'))
    @push('scripts')
        <script>
            toastr["error"]("{{ session('error') }}")
        </script>
    @endpush
@endif
<div class="wrapper">

    @include('admin.layouts.navbar')
    @include('admin.layouts.sidebar')

    <div class="content-wrapper">
        <div class="container-fluid pt-3">
            @yield('content')
        </div>
    </div>

    @include('admin.layouts.assets.footer')

</div>

<script src="{{asset('admin/layouts/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('admin/layouts/plugins/overlayScrollbars/js/OverlayScrollbars.js')}}"></script>
<script src="{{asset('admin/layouts/plugins/toastr/toastr.min.js')}}"></script>
<script src="{{asset('admin/layouts/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin/layouts/js/master.js')}}"></script>
<script src="{{asset('admin/layouts/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>

<script>
    $(document).ready(function () {
        setInterval(() => {
            $.ajax({
                url: '/admin/notifications',
                success: function(response) {
                    shownNotifications = $('.notification_dropdown .timeline li');

                    if(response.notifications.length > shownNotifications.length) {
                        $.each(response.notifications, function(i, notification) {
                            let date = new Date(notification.created_at);

                           $newNotification = `
                                <li>
                                    <a href="${notification.data.url}">
                                        <div class="timeline-panel">
                                            <div class="media-body">
                                                <h6 class="mb-1">${notification.data.title}</h6>
                                                <small class="d-block">${date.toLocaleDateString('pt-BR')}</small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            `;

                            $('.notification_dropdown .timeline').append($newNotification);
                            $('.notification_dropdown .nav-link').addClass('show-notifcations-indicatior');
                            $('.notification_dropdown .nav-link .notifications-count').text(response.unreadCount);
                        });
                    }
                }
            })
        }, 10000);

        $('.notification_dropdown .nav-link').on('click', function() {
            $.ajax({
                url: '/admin/notifications/readAll',
                success: function(response) {
                    if(response.success) {
                        $('.notification_dropdown .nav-link').removeClass('show-notifcations-indicatior');
                        $('.notification_dropdown .nav-link .notifications-count').text('');
                    }
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function () {
        bsCustomFileInput.init();
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    function addChartItem(item) {
        $.ajax({
            url: '{{url('/')}}/admin/bets/bichao/add/chart',
            type: 'POST',
            dataType: 'json',
            data: { item  },
            success: function(data) {
                location.reload();
            }
        });
    }

    $('#clear-all-chart').click(function(ev) {
        $.ajax({
            url: '{{url('/')}}/admin/bets/bichao/remove-all/chart',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                location.reload();
            }
        });
    });

    $('#marcar-premio-pago').click(function(ev) {
        ev.preventDefault();
        const id = $(this).attr('data-id');

        $.ajax({
            url: '{{url('/')}}/admin/bets/bichao/marcar-premio-pago',
            type: 'POST',
            dataType: 'json',
            data: { id  },
            success: function(data) {
                location.reload();
            }
        });
    });

    $('.chart-remove-item').click(function(ev) {
        ev.preventDefault();
        const url = $(this).attr('url');
        console.log('Chamando remoção do carrinho', url);

        $.ajax({
            url,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                console.log('Remoção do carrinho realizada', data);
                location.reload();
            }
        });
    });

    $('#selecionar-estado-bichao').change(function() {
        const estado_id = $(this).val();

        if (estado_id > 0) {
            $.ajax({
                url: '{{url('/')}}/admin/bets/bichao/horarios',
                type: 'POST',
                dataType: 'json',
                data: { estado_id },
                success: function(data) {
                    if (data.horarios.length == 0) {
                        $('#horarios-resultados').html(`
                            <p>Não há sorteios disponíveis no momento, por favor selecione outro estado.</p>
                        `);
                    } else {
                        const horarios = data.horarios.map((horario, index) => (`
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="bichao-horario-sorteio" id="bichao-horario-sorteio-${horario.id}" value="${horario.id}" ${index === 0 && 'checked'}>
                                <label class="form-check-label" for="bichao-horario-sorteio-${horario.id}">
                                    ${horario.horario} - ${horario.banca}
                                </label>
                            </div>
                        `));
                        $('#horarios-resultados').html(horarios);
                    }
                    $('#estado-sorteio').removeClass('hide');
                }
            });
        }
    });

    $('#cadastrar-jogos').click(function() {
        const horario_id = $('input[name=bichao-horario-sorteio]:checked').val();

        if (!horario_id > 0) return alert('Selecione um estado e um sorteio');

        $.ajax({
            url: '{{url('/')}}/admin/bets/bichao/checkout',
            type: 'POST',
            dataType: 'json',
            data: { horario_id },
            success: function(data) {
                if (!data.status) {
                    console.log(data);
                    return alert(data.message);
                }

                let htmlTable = data.chart.map((item) => (`
                    <tr>
                        <td>${item.id}</td>
                        <td>R$ ${item.valor.toLocaleString('pt-br', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                        <td>${item.modalidade.nome}</td>
                        <td>
                            <a href="{{url('/')}}/admin/bets/bichao/receipt/${item.id}/txt">
                                <button type="button" class="btn btn-primary text-light" title="Baixar bilhete TXT">
                                    <i class="bi bi-ticket"></i>
                                </button>
                            </a>
                            <a href="{{url('/')}}/admin/bets/bichao/receipt/${item.id}/pdf">
                                <button type="button" class="btn btn-danger text-light" title="Baixar bilhete PDF">
                                    <i class="bi bi-ticket"></i>
                                </button>
                            </a>
                            <a href="https://api.whatsapp.com/send?phone=55${item.client.ddd+item.client.phone}&text=Jogo de ${item.modalidade.nome} cadastrado com sucesso! Id da Aposta: ${item.id}, Cliente: ${item.client.name} ${item.client.last_name}, Aposta: ${item.aposta}, Valor R$ ${item.valor.toLocaleString('pt-br', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}, Prêmio Máximo R$ ${item.premio_maximo.toLocaleString('pt-br', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}, Data: ${item.emitido_em}" target="_blank">
                                <button type="button" class="btn btn-success text-light" title="Enviar por whatsapp">
                                    <i class="bi bi-whatsapp"></i>
                                </button>
                            </a>
                        </td>
                    </tr>
                `));

                $('#jogos-realizados-table').html(htmlTable);
                $('#chart-text').html(`<p class="text-center">Seu carrinho está vazio, faça um jogo para realizar uma aposta.</p>`);
                $('#estado-sorteio').addClass('hide');
                $('#jogos-realizados').modal('show');
            }
        });
    });

    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
</script>


@livewireScripts
@stack('scripts')

</body>

</html>
