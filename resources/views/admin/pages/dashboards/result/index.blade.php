@extends('admin.layouts.master')

@section('title', 'Resultados')

@section('content')



{{-- formulario onde buscaremos uma data especifica --}}

<div class="container">
    <div class="card-deck container d-flex justify-content-between card-header" style="padding: 30px;">
        <div class="col-md-6">
            <h3 style="margin:0;">Lista de Ganhadores</h3>
        </div>
        <div class="col-md-6 d-flex align-items-center">
            <h4 style="margin:0;" class="mr-2">Data:</h4>
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
        <thead>
            <tr>
                <th>{{ trans('admin.network-sales.table-id-header') }}</th>
                <th>{{ trans('admin.network-sales.table-name-header') }}</th>
                <th>Prêmio</th>
                <th>Bilhetes</th>
                <th>Modalidade</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>

<div class="p-3"></div>

@endsection



@push('scripts')

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>

<script>
    function Filtro() {
        var select = document.getElementById('Filtro');
        var value = select.options[select.selectedIndex].value;
        if (value == 4) {
            document.getElementById("FiltroPersonalizado").style.display = "block";
        }
        else if (value == 0) {
            document.getElementById("FiltroPersonalizado").style.display = "none";
        }
        else {
            document.getElementById("FiltroPersonalizado").style.display = "none";
            location.href = "{{env('APP_URL')}}/admin/dashboards/Reportday/FiltroEspecifico/" + value;
        }
    }

</script>

<script>
    function limparTabela() {
    var tabela = document.getElementById('relatorio').getElementsByTagName('tbody')[0];
    tabela.innerHTML = ''; // Remove todas as linhas do corpo da tabela
}

function adicionarDadosATabela(dados) {
    limparTabela(); // Limpa a tabela antes de adicionar novos dados
    var tabela = document.getElementById('relatorio').getElementsByTagName('tbody')[0];
    for (var i = 0; i < dados.length; i++) {
        var newRow = tabela.insertRow(tabela.rows.length);
        newRow.innerHTML = "<td>" + dados[i].id + "</td>" +
            "<td>" + dados[i].name + "</td>" +
            "<td>" + dados[i].premio_formatted + "</td>" +
            "<td>" + dados[i].num_tickets + "</td>" +
            "<td>" + dados[i].game_name + "</td>" +
            "<td>" + (dados[i].status === 1 ? "Pago" : "Não Pago") + "</td>";
    }
    document.getElementById('relatorio').style.display = 'table'; // Exibe a tabela após adicionar os dados
}
function somarPremios(dados) {
    var total = 0;
    for (var i = 0; i < dados.length; i++) {
        // Remove a formatação monetária e converte para float
        var premio = parseFloat(dados[i].premio.replace(/\./g, '').replace(',', '.'));
        total += premio;
    }
    // Formata o total como moeda real
    var totalFormatado = total.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
    // Retorna o total formatado como moeda real
    return totalFormatado;
}





function somarNumTickets(dados) {
    var total = 0;
    for (var i = 0; i < dados.length; i++) {
        total += dados[i].num_tickets;
    }
    return total;
}
    $(document).ready(function () {
        $('#relatorio').DataTable({
            theme: "bootstrap",
            "scrollX": true,
            "columnDefs": [
                { "className": "dt-center", "targets": "_all" }
            ],
            paging: false, // Define a opção paging como false para remover a navegação
    pagingType: "", // Define a opção pagingType como vazia para remover a navegação
    lengthChange: false, // Remove o campo de seleção do número de registros por página
    searching: false, // Remove o campo de busca
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


        var system = <?php echo json_encode($system); ?>;
        for (var i = 0; i < system.length; i++) {
        // Verifica se a chave nome_config é igual a "partner_id"
        if (system[i].nome_config === "partner_id") {
            partnerId = system[i].value;
            break; 
        }  
        }    });


        

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
        }
    });


    $('#envianozap').click(function() {
        // Faz uma solicitação AJAX para o endpoint
        $.ajax({
            type: 'GET',
            url: 'https://web.loteriasalternativas.com.br/api/copia-e-cola?partner='+partnerId+'&sort_date=' + dataSelecionada,
            success: function(response) {
                // Manipula o texto retornado
                var texto = response.formatted_content;
                // URL para o WhatsApp
                let cont = 'https://api.whatsapp.com/send?text='+texto;
                // Abre uma nova guia com a URL
                window.open(cont);
            },
            error: function(xhr, status, error) {
                console.error('Erro ao obter o texto:', error);
            }
        });
    });


    $('#copiarTexto').click(function() {
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

    
}

$(document).ready(function() {
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

});



  
</script>
@endpush