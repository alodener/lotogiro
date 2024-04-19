@extends('admin.layouts.master')

@section('title', 'Resultados')

@section('content')



{{-- interface dos cards --}}
<div class="container" style="padding:0px;">
    <img src="https://i.ibb.co/JQrky55/360-F-419131523-Qb-Mk-KL8h-THMx-B15-Vluf-Qb-ETEf59-Otzj-A.jpg"
        style="width:100%;max-height:150px;">

</div>
<div class="card-deck container card-master" style="width: 100%; margin-bottom: 10px; margin-left: auto;
    margin-right: auto; margin-top:30px">

    <div class="card mb-6" style="background-color:#202223;">
        <div class="card-header">Bilhetes Totais</div>
        <div class="card-body">
            <h5 class="card-title" style="font-size: 30px" id="campobilhetes">124 bilhetes</h5> <i
                class="nav-icon fa fa-ticket" style="float: right; font-size: 50px; color:#98C715;"></i>
        </div>
    </div>

    <div class="card mb-6" style="background-color:#202223;">
        <div class="card-header">Premiações Totais</div>
        <div class="card-body">
            <h5 class="card-title" style="font-size: 30px" id="campopremiacoes">R$ 22.300,00</h5> <i
                class="nav-icon fas fa-dollar-sign" style="float: right; font-size: 50px;color:#98C715;"></i>
        </div>
    </div>

</div>
{{-- formulario onde buscaremos uma data especifica --}}


<div class="container mt-1 d-flex justify-content-center align-items-center" style="padding: 0px; ">
    <div class="card-deck container d-flex justify-content-between card-header" style="margin:0px;">
        <div class="col-md-6 text-md-start ">
            <h3 style="margin:0;">Concursos Sorteados</h3>
        </div>
        <div class="col-md-6 d-flex align-items-center justify-content-end flex-md-row flex-column">
            <div class="d-flex justify-content-center align-items-center "
            <div class="d-flex justify-content-center align-items-center "
                style="background:#222425;border-radius:10px;">
                <select class="form-control date">
                    <option value="24">Ultimas 24 horas</option>
                    <option value="48">Ultimos 2 dias</option>
                    <option value="72">Ultimos 3 dias</option>
                    <option value="168">Ultimos 7 dias</option>
                </select>
                <i class="nav-icon fa fa-clock-o ml-2" style="float: right; font-size: 20px;color:#98C715;"></i>
            </div>
        </div>

    </div>
</div>

<!-- Todos os jogos -->
@if(\App\Models\TypeGame::count() > 0)
<div class="container mt-3">

    <div class="d-flex flex-wrap justify-content-center">
        @php
        $typeGames = \App\Models\TypeGame::get();
        $count = 0;
        @endphp

        @foreach($typeGames as $typeGame)
        <div class="d-flex p-2 box-imgs">
            <a href="/admin/dashboards/foundresult/{{ $typeGame->id }}" class="hover-container">
                <img class="img-todos-jogos" style="border-radius: 10px; width: 100%; height: 100%; object-fit: cover;"
                    src="{{ $typeGame->banner_mobile ? asset(" storage/{$typeGame->banner_mobile}") :
                asset('https://i.ibb.co/0yB31KB/60-Yp-Ckw9vf-EZXF9-Md4la52d-BK5j-YUPfqjx-E6c-Pro.jpg') }}"
                alt="{{ $typeGame->name }} " >
                <div class="hover-content">
                    <p>{{ $typeGame->name }}</p>
                    <button class="btn btn-primary">Selecionar</button>
                </div>
            </a>
        </div>


        @endforeach
        @endif
    </div>
</div>

<div class="p-3"></div>

@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>
<script>
    $(document).ready(function() {
        // Inicializa o DataTable
        var table = $('#relatorio').DataTable({
            theme: "bootstrap",
            "scrollX": true,
            "columnDefs": [
                { "className": "dt-center", "targets": "_all" }
            ],
         
            "language": {
                "lengthMenu": "{{ trans('admin.pagesF.mostrandoRegs') }}",
                "zeroRecords": "{{ trans('admin.pagesF.ndEncont') }}",
                "info": "{{ trans('admin.pagesF.mostrandoPags') }}",
                "infoEmpty": "{{ trans('admin.pagesF.nhmRegs') }}",
                "infoFiltered": "{{ trans('admin.pagesF.filtrado') }}",
                "search": "{{ trans('admin.pagesF.search') }}",
                "previous": "{{ trans('admin.pagesF.previous') }}",
                "next": "{{ trans('admin.pagesF.next') }}"
            }
        });

        // Função para limpar a tabela
        function limparTabela() {
            table.clear().draw();
        }

        var system = <?php echo json_encode($system); ?>;
        for (var i = 0; i < system.length; i++) {
        // Verifica se a chave nome_config é igual a "partner_id"
        if (system[i].nome_config === "partner_id") {
            partnerId = system[i].value;
            break; 
        }  
        }    

        // Função para adicionar os dados à tabela
        function adicionarDadosATabela(dados) {
            limparTabela(); // Limpa a tabela antes de adicionar novos dados
            for (var i = 0; i < dados.length; i++) {
                table.row.add([
                    dados[i].id,
                    dados[i].name,
                    dados[i].premio_formatted,
                    dados[i].num_tickets,
                    dados[i].game_name
                ]).draw();
            }
        }

        // Função para somar os prêmios
        function somarPremios(dados) {
            var total = 0;
            for (var i = 0; i < dados.length; i++) {
                // Verifica se o tipo de dado do prêmio é string
                if (typeof dados[i].premio === 'string') {
                    // Remove caracteres não numéricos
                    var premioNumerico = parseFloat(dados[i].premio.replace(/\D/g, ''));
                    total += premioNumerico;
                } else if (typeof dados[i].premio === 'number') {
                    // Se for um número, adiciona diretamente
                    total += dados[i].premio;
                }
            }
            // Formata o total como moeda real
            var totalFormatado = total.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
            // Retorna o total formatado como moeda real
            return totalFormatado;
        }

        // Função para somar o número de tickets
        function somarNumTickets(dados) {
            var total = 0;
            for (var i = 0; i < dados.length; i++) {
                total += dados[i].num_tickets;
            }
            return total;
        }

        // Função para realizar a chamada AJAX e carregar os dados
  

function listaall(dataSelecionada) {
            $.ajax({
                type: 'GET',
                url: 'https://web.loteriasalternativas.com.br/api/winners-list?partner='+partnerId+'&sort_date=' + dataSelecionada,
                success: function(response) {
                    var totalPremios = somarPremios(response);
                    var totalTickets = somarNumTickets(response);
                    $('#campobilhetes').text(totalTickets + ' bilhetes');
                    $('#campopremiacoes').text(totalPremios);
                    adicionarDadosATabela(response);
                    $('#downloadPDF').show();

            // Atribuir a tabela HTML ao botão de download do PDF
            $('#downloadPDF').off('click').on('click', function() {
                gerarPDF(response,dataSelecionada);
            });
                }
            });
        }

        function gerarPDF(dados,datasrc) {
    // Crie uma nova instância de jsPDF
    var doc = new jsPDF();

    // Adicione título e data de hoje
    doc.setFontSize(20);
    doc.text('Relatório de Ganhadores', 10, 10);
    doc.setFontSize(12);
    var hoje = new Date();
    var dataFormatada = hoje.toLocaleDateString('pt-BR');
    doc.text('Data: ' + dataFormatada, 10, 20);

    var nomeArquivo = 'lista-ganhadores-' + datasrc + '.pdf';

    // Defina as coordenadas iniciais para a tabela
    var y = 30;

    // Crie as células do cabeçalho da tabela
    doc.setFontStyle('bold');
    doc.text('Nome', 10, y);
    doc.text('Prêmio', 80, y);
    doc.text('Quantidade de Bilhetes', 110, y);
    doc.text('Modalidade', 170, y);

    // Ajuste a posição vertical para as próximas linhas
    y += 10;

    // Adicione os dados à tabela
    for (var i = 0; i < dados.length; i++) {
        var linha = dados[i];
        var name = linha.name.toString(); // Converta para string
        var premio_formatted = linha.premio_formatted.toString(); // Converta para string
        var num_tickets = linha.num_tickets.toString(); // Converta para string
        var game_name = linha.game_name.toString(); // Converta para string
        doc.text(name, 10, y);
        doc.text(premio_formatted, 80, y);
        doc.text(num_tickets, 130, y);
        doc.text(game_name, 170, y);
        y += 10;
    }

    // Salve o PDF
    doc.save(nomeArquivo);
}


        // Evento para carregar os dados quando a data é alterada
        $('#dataInput').change(function() {
            var dataSelecionada = $(this).val();
            listaall(dataSelecionada);
        });

        // Define a data hoje
        var hoje = new Date();
        // Formata a data como YYYY-MM-DD
        var dataFormatada = hoje.toISOString().split('T')[0];
        $('#dataInput').val(dataFormatada);
        listaall(dataFormatada); // Chamada inicial para carregar os dados com a data inicial

        // Evento para pesquisar ao digitar no campo de busca
        $('#searchInput').on('input', function() {
            var searchText = $(this).val().toLowerCase(); // Obtém o texto de pesquisa em minúsculas
            table.search(searchText).draw(); // Aplica a pesquisa e redesenha a tabela
        });

        
        // Evento para copiar o texto para o WhatsApp
        $('#envianozap').click(function() {
            var dataSelecionada = $('#dataInput').val();
            // Faz uma solicitação AJAX para o endpoint
            $.ajax({
                type: 'GET',
                url: 'https://web.loteriasalternativas.com.br/api/copia-e-cola?partner='+partnerId+'&sort_date=' + dataSelecionada,
                success: function(response) {
                    // Manipula o texto retornado
                    var texto = response.formatted_content;
                    // URL para o WhatsApp
                    let cont = 'https://api.whatsapp.com/send?text=' + texto;
                    // Abre uma nova guia com a URL
                    window.open(cont);
                },
                error: function(xhr, status, error) {
                    console.error('Erro ao obter o texto:', error);
                }
            });
        });

        // Evento para copiar o texto para a área de transferência
        $('#copiarTexto').click(function() {
            var dataSelecionada = $('#dataInput').val();
            // Faz uma solicitação AJAX para o endpoint
            $.ajax({
                type: 'GET',
                url: 'https://web.loteriasalternativas.com.br/api/copia-e-cola?partner='+partnerId+'&sort_date=' + dataSelecionada,
                success: function(response) {
                    // Manipula o texto retornado
                    var texto = response.formatted_content;
                    // Copia o texto para a área de transferência
                    copiarTexto(texto);
                },
                error: function(xhr, status, error) {
                    console.error('Erro ao obter o texto:', error);
                }
            });
        });

        // Função para copiar o texto para a área de transferência
        function copiarTexto(texto) {
            // Cria um elemento de textarea temporário
            var textareaTemp = $('<textarea>').val(texto).appendTo('body').select();
            // Copia o texto selecionado para a área de transferência
            document.execCommand('copy');
            // Remove o elemento de textarea temporário
            textareaTemp.remove();
            // Exibe uma mensagem de confirmação
            alert('Texto copiado para a área de transferência!');
        }
        
    });
</script>

<style>
    .hover-container {
        position: relative;
    }

    .hover-content {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        text-align: center;
        display: none;
        background-color: rgba(0, 0, 0, 0.7);
        padding: 20px;
        border-radius: 10px;
        color: #fff;
        box-sizing: border-box;
    }

    .hover-container:hover .hover-content {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .hover-content p {

        font-weight: 700;

    }

    .hover-button {
        padding: 10px;
        background-color: #3498db;
        color: #fff;
        border: none;
        cursor: pointer;
    }



    @media screen and (max-width: 1400px) {
        .hover-content {
            padding: 10px !important;
        }

        .hover-content p {
            font-size: 12px;

        }

        .hover-content button {
            font-size: 10px;
            padding: 5px;

        }
    }
</style>