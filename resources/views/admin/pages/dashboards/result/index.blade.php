@extends('admin.layouts.master')

@section('title', 'Resultados')

@section('content')

{{-- formulario onde buscaremos uma data especifica --}}

<div class="container mt-5">
    <div class="card-deck container d-flex justify-content-between card-header" style="padding: 30px;">
        <div class="col-md-4 text-md-start ">
            <h3 style="margin:0;">Lista de Ganhadores</h3>
        </div>
        <div class="col-md-4 d-flex align-items-center">
  <input class="form-check-input" type="checkbox" role="switch" id="switchinternacional">
  <label class="form-check-label" for="switchinternacional">Apenas Internacional</label>
</div>
        <div class="col-md-4 d-flex align-items-center flex-md-row flex-column">
            <h4 style="margin:0;" class="mr-2 mt-3 mt-md-0">Data:</h4>
            <input class="form-control date" id="dataInput" type="date">
        </div>
    </div>
</div>

{{-- interface dos cards --}}
<div class="card-deck container card-master" style="width: 100%; margin-bottom: 30px; margin-left: auto;
    margin-right: auto; margin-top:30px">

    <div class="card mb-6" style="background-color:#202223;">
        <div class="card-header">Bilhetes Sorteados</div>
        <div class="card-body">
            <h5 class="card-title" style="font-size: 30px" id="campobilhetes"></h5> <i
                class="nav-icon fas fa-chart-line" style="float: right; font-size: 50px; color:#98C715;"></i>
            <p class="card-text"></p>
        </div>
    </div>

    <div class="card mb-6" style="background-color:#202223;">
        <div class="card-header">Premiações de Hoje</div>
        <div class="card-body">

            <h5 class="card-title" style="font-size: 30px" id="campopremiacoes"></h5> <i
                class="nav-icon fas fa-dollar-sign" style="float: right; font-size: 50px;color:#98C715;"></i>
            <p class="card-text"></p>
        </div>
    </div>

</div>

<div class="container d-flex flex-md-row flex-column">

    <div class="col-md-6 card-header">
        <h3 style="margin:0;">Apostas Vencedoras</h3>
    </div>
    <div class="col-md-3 card-2" style="max-height:57px" id="copiarTexto">
        <button class="btn btn-secondary mr-md-3 mr-2 d-flex justify-content-center align-items-center "
            style="border-radius: 90px;">
            <i style="color:#a3d712" class="fa fa-files-o wallet-nav"></i>
        </button>
        <p style="margin:0;" >Copiar Lista</p>
    </div>
    <div id="envianozap" class="col-md-3 card-2" style="max-height:57px">
        <button class="btn btn-secondary mr-md-3 mr-2 d-flex justify-content-center align-items-center "
            style="border-radius: 90px;">
            <i style="color:#a3d712" class="fa fa-whatsapp wallet-nav"></i>
        </button>
        <p style="margin:0;">Enviar ao WhatsApp</p>
    </div>

</div>

{{-- tabela de rede --}}
<div class="container card-master mt-3">
    
    <table id="relatorio" class="table table-striped" style="width: 100%">
        <div class="d-flex justify-content-end">
            <button id="downloadPDF" class="btn btn-primary mb-2">PDF Ganhadores</button>

        </div>
        <thead>
            <tr>
                <th>{{ trans('admin.network-sales.table-id-header') }}</th>
                <th>{{ trans('admin.network-sales.table-name-header') }}</th>
                <th>Prêmio</th>
                <th>Bilhetes</th>
                <th>Modalidade</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>

<div class="p-3"></div>

@endsection

@push('scripts')
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
  

        var filtrarPorJogosEspecificos = 1; // 0 para listar todos, 1 para listar apenas jogos específicos

// Lista de jogos específicos
var jogosEspecificos = [
    'SLG-KINO LOTO',
    'SLG-RE-KINO LOTO',
    'SLG - PREMIOS ESPECIALES',
    'SLG - CHISPALOTO',
    'SLG-CHAO JEFE LOTO',
    'SLG-MEGA LOTTO',
    'SLG- MEGA KINO',
    'SLG - STª LUCIA DOUBLE'
];

function listaall(dataSelecionada) {
    // Coletar o estado do checkbox
    var filtrarPorJogosEspecificos = $('#switchinternacional').is(':checked') ? 1 : 0;

    $.ajax({
        type: 'GET',
        url: 'https://web.loteriasalternativas.com.br/api/winners-list?partner='+partnerId+'&sort_date=' + dataSelecionada,
        success: function(response) {
            // Filtrar os dados se a variável estiver definida como 1
            if (filtrarPorJogosEspecificos === 1) {
                response = response.filter(function(item) {
                    return jogosEspecificos.includes(item.game_name);
                });
            }

            var totalPremios = somarPremios(response);
            var totalTickets = somarNumTickets(response);
            $('#campobilhetes').text(totalTickets + ' bilhetes');
            $('#campopremiacoes').text(totalPremios);
            adicionarDadosATabela(response);
            $('#downloadPDF').show();

            // Atribuir a tabela HTML ao botão de download do PDF
            $('#downloadPDF').off('click').on('click', function() {
                gerarPDF(response, dataSelecionada);
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

        $('#switchinternacional').click(function() {
            var dataSelecionada = $('#dataInput').val();
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
@endpush
