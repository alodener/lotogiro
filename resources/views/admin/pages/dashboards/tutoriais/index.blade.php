@extends('admin.layouts.master')

@section('title', 'Tutoriais')

@section('content')
<div class="row bg-white p-3">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="card-header indica-card">
                    Tutoriais
                </div>
            </div>
        </div>



<html>
<body>
<div class="container">
    <div class="row">
      <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal1()">
    <div class="card-content">
      <h3 class="card-title">Como jogar em Grupo</h3>
      <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#video-modal-1">Assistir</button> -->
    </div>
  </div>
  </div>

      <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal2()">
    <div class="card-content">
      <h3 class="card-title">Duque de Dezena</h3>
    </div>
    </a>
  </div>
  </div>

  
  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal3()">
    <div class="card-content">
      <h3 class="card-title">Duque de Grupo</h3>
    </div>
  </div>
  </div>

  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal4()">
    <div class="card-content">
      <h3 class="card-title">Milhar e Centena</h3>
    </div>
  </div>
  </div>


  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal5()">
    <div class="card-content">
      <h3 class="card-title">Resultado Jogo do Bichão</h3>
    </div>
  </div>
  </div>


  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal6()">
    <div class="card-content">
      <h3 class="card-title">Terno de Dezena</h3>
    </div>
  </div>
  </div>


  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal7()">
    <div class="card-content">
      <h3 class="card-title">Terno de Grupo</h3>
    </div>
  </div>
  </div>

  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal8()">
    <div class="card-content">
      <h3 class="card-title">Apostar na Loto Facil</h3>
    </div>
  </div>
  </div>


  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal9()">
    <div class="card-content">
      <h3 class="card-title">Como Jogar na Timemania</h3>
    </div>
  </div>
  </div>

  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal10()"> 
    <div class="card-content">
      <h3 class="card-title">Como Atualizar o Cadastro</h3>
    </div>
  </div>
  </div>


  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal11()">
    <div class="card-content">
      <h3 class="card-title">Como Convidar Clientes</h3>
    </div>
  </div>
  </div>


  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal12()">
    <div class="card-content">
      <h3 class="card-title">Como Jogar na Die de Sorte</h3>
    </div>
  </div>
  </div>


  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal13()">
    <div class="card-content">
      <h3 class="card-title">Como Jogar na Dupla Sena</h3>
    </div>
  </div>
  </div>

  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal14()">
    <div class="card-content">
      <h3 class="card-title">Como Jogar na Mega Sena</h3>
    </div>
  </div>
  </div>

  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal15()">
    <div class="card-content">
      <h3 class="card-title">Como Realizar Recarga</h3>
    </div>
  </div>
  </div>

  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal16()">
    <div class="card-content">
      <h3 class="card-title">Como Validar Bilhetes</h3>
    </div>
  </div>
  </div>

  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal17()">
    <div class="card-content">
      <h3 class="card-title">Como Ver Apostas no Jogo do Bicho</h3>
    </div>
  </div>
  </div>

  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal18()">
    <div class="card-content">
      <h3 class="card-title">Como Ver Meus Jogos</h3>
    </div>
  </div>
  </div>

  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal19()">
    <div class="card-content">
      <h3 class="card-title">Converter Bônus em Saldo</h3>
    </div>
  </div>
  </div>

  <div class="col-sm-6 col-md-4">
      <div class="card" onclick="openModal20()">
    <div class="card-content">
      <h3 class="card-title">Loto Fácil para Clientes</h3>
    </div>
  </div>
  </div>

  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal21()">
    <div class="card-content">
      <h3 class="card-title">Quina</h3>
</div>
    </div>
  </div>
  </body>

  <!-- modal 1-->

  <div class="modal fade" id="video-modal-1" tabindex="-1" aria-labelledby="video-modal-1-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-1-label">Como jogar em Grupo</h5>
        <div class="close-button">
    <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">

      <div class="d-flex align-items-center justify-content-center">
  <video controls width = "500">
    <source src="{{asset('admin/videos/como-jogar-em-grupo.mp4')}}" type="video/mp4">
  </video>
</div>
      </div>
    </div>
  </div>
</div> 

<!-- modal 2-->

<div class="modal fade" id="video-modal-2" tabindex="-2" aria-labelledby="video-modal-2-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-2-label">Duque de Dezena</h5>
        <div class="close-button">
    <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">

      <div class="d-flex align-items-center justify-content-center">
  <video controls width = "500">
    <source src="{{asset('admin/videos/duque-de-dezena.mp4')}}" type="video/mp4">
  </video>
</div>
      </div>
    </div>
  </div>
</div> 

<!-- modal 3-->

<div class="modal fade" id="video-modal-3" tabindex="-3" aria-labelledby="video-modal-3-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-3-label">Duque de Grupo</h5>
        <div class="close-button">
    <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">

      <div class="d-flex align-items-center justify-content-center">
  <video controls width = "500">
    <source src="{{asset('admin/videos/duque-de-grupo.mp4')}}" type="video/mp4">
  </video>
</div>
      </div>
    </div>
  </div>
</div> 

<!-- modal 4-->

<div class="modal fade" id="video-modal-4" tabindex="-4" aria-labelledby="video-modal-4-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-4-label">Milhar e Centena</h5>
        <div class="close-button">
    <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">

      <div class="d-flex align-items-center justify-content-center">
  <video controls width = "500">
    <source src="{{asset('admin/videos/milhar-centena.mp4')}}" type="video/mp4">
  </video>
</div>
      </div>
    </div>
  </div>
</div> 

<!-- modal 5-->

<div class="modal fade" id="video-modal-5" tabindex="-5" aria-labelledby="video-modal-5-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-5-label">Resultado Jogo do Bichão</h5>
        <div class="close-button">
    <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">

      <div class="d-flex align-items-center justify-content-center">
  <video controls width = "500">
    <source src="{{asset('admin/videos/resultado-jogo-do-bicho.mp4')}}" type="video/mp4">
  </video>
</div>
      </div>
    </div>
  </div>
</div> 

<!-- modal 6-->

<div class="modal fade" id="video-modal-6" tabindex="-6" aria-labelledby="video-modal-6-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-6-label">Terno de Dezena</h5>
        <div class="close-button">
    <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">

      <div class="d-flex align-items-center justify-content-center">
  <video controls width = "500">
    <source src="{{asset('admin/videos/terno-de-dezena.mp4')}}" type="video/mp4">
  </video>
</div>
      </div>
    </div>
  </div>
</div> 

<!-- modal 7-->

<div class="modal fade" id="video-modal-7" tabindex="-7" aria-labelledby="video-modal-7-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-7-label">Terno de Grupo</h5>
        <div class="close-button">
    <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">

      <div class="d-flex align-items-center justify-content-center">
  <video controls width = "500">
    <source src="{{asset('admin/videos/terno-de-grupo.mp4')}}" type="video/mp4">
  </video>
</div>
      </div>
    </div>
  </div>
</div>

<!-- modal 8-->

<div class="modal fade" id="video-modal-8" tabindex="-8" aria-labelledby="video-modal-8-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-8-label">Apostar na Loto Facil</h5>
        <div class="close-button">
    <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">

      <div class="d-flex align-items-center justify-content-center">
  <video controls width = "500">
    <source src="{{asset('admin/videos/apostar-na-lotofacil.mp4')}}" type="video/mp4">
  </video>
</div>
      </div>
    </div>
  </div>
</div> 

<!-- modal 9-->

<div class="modal fade" id="video-modal-9" tabindex="-9" aria-labelledby="video-modal-9-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-9-label">Como Jogar na Timemania</h5>
        <div class="close-button">
    <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">

      <div class="d-flex align-items-center justify-content-center">
  <video controls width = "500">
    <source src="{{asset('admin/videos/como-jogar-na-timemania.mp4')}}" type="video/mp4">
  </video>
</div>
      </div>
    </div>
  </div>
</div> 

<!-- modal 10-->

<div class="modal fade" id="video-modal-10" tabindex="-10" aria-labelledby="video-modal-10-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-10-label">Como Atualizar o Cadastro</h5>
        <div class="close-button">
    <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">

      <div class="d-flex align-items-center justify-content-center">
  <video controls width = "500">
    <source src="{{asset('admin/videos/como-atualizar-o-cadastro.mp4')}}" type="video/mp4">
  </video>
</div>
      </div>
    </div>
  </div>
</div> 

<!-- modal 11-->

<div class="modal fade" id="video-modal-11" tabindex="-11" aria-labelledby="video-modal-11-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-11-label">Como Convidar Clientes</h5>
        <div class="close-button">
    <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">

      <div class="d-flex align-items-center justify-content-center">
  <video controls width = "500">
    <source src="{{asset('admin/videos/como-convidar-clientes.mp4')}}" type="video/mp4">
  </video>
</div>
      </div>
    </div>
  </div>
</div> 

<!-- modal 12-->

<div class="modal fade" id="video-modal-12" tabindex="-12" aria-labelledby="video-modal-12-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-12-label">Como Jogar na Die de Sorte</h5>
        <div class="close-button">
    <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">

      <div class="d-flex align-items-center justify-content-center">
  <video controls width = "500">
    <source src="{{asset('admin/videos/como-jogar-na-die-da-sorte.mp4')}}" type="video/mp4">
  </video>
</div>
      </div>
    </div>
  </div>
</div> 

<!-- modal 13-->

<div class="modal fade" id="video-modal-13" tabindex="-13" aria-labelledby="video-modal-13-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-13-label">Como Jogar na Dupla Sena</h5>
        <div class="close-button">
    <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">

      <div class="d-flex align-items-center justify-content-center">
  <video controls width = "500">
    <source src="{{asset('admin/videos/como-jogar-na-dupla-sena.mp4')}}" type="video/mp4">
  </video>
</div>
      </div>
    </div>
  </div>
</div> 

<!-- modal 14-->

<div class="modal fade" id="video-modal-14" tabindex="-14" aria-labelledby="video-modal-14-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-14-label">Como Jogar na Mega Sena</h5>
        <div class="close-button">
    <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">

      <div class="d-flex align-items-center justify-content-center">
  <video controls width = "500">
    <source src="{{asset('admin/videos/como-jogar-na-mega-sena.mp4')}}" type="video/mp4">
  </video>
</div>
      </div>
    </div>
  </div>
</div> 

<!-- modal 15-->

<div class="modal fade" id="video-modal-15" tabindex="-15" aria-labelledby="video-modal-15-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-15-label">Como Realizar Recarga</h5>
        <div class="close-button">
    <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">

      <div class="d-flex align-items-center justify-content-center">
  <video controls width = "500">
    <source src="{{asset('admin/videos/como-realizar-recarga.mp4')}}" type="video/mp4">
  </video>
</div>
      </div>
    </div>
  </div>
</div> 

<!-- modal 16-->

<div class="modal fade" id="video-modal-16" tabindex="-16" aria-labelledby="video-modal-16-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-16-label">Como Validar Bilhetes</h5>
        <div class="close-button">
    <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">

      <div class="d-flex align-items-center justify-content-center">
  <video controls width = "500">
    <source src="{{asset('admin/videos/como-validar-bilhetes.mp4')}}" type="video/mp4">
  </video>
</div>
      </div>
    </div>
  </div>
</div> 

<!-- modal 17-->

<div class="modal fade" id="video-modal-17" tabindex="-17" aria-labelledby="video-modal-17-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-17-label">Como Ver Apostas no Jogo do Bicho</h5>
        <div class="close-button">
    <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">

      <div class="d-flex align-items-center justify-content-center">
  <video controls width = "500">
    <source src="{{asset('admin/videos/como-ver-apostas-no-jogodobicho.mp4')}}" type="video/mp4">
  </video>
</div>
      </div>
    </div>
  </div>
</div>

<!-- modal 18-->

<div class="modal fade" id="video-modal-18" tabindex="-18" aria-labelledby="video-modal-18-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-18-label">Como Ver Meus Jogos</h5>
        <div class="close-button">
    <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">

      <div class="d-flex align-items-center justify-content-center">
  <video controls width = "500">
    <source src="{{asset('admin/videos/como-ver-meus-jogos.mp4')}}" type="video/mp4">
  </video>
</div>
      </div>
    </div>
  </div>
</div>

<!-- modal 19-->

<div class="modal fade" id="video-modal-19" tabindex="-19" aria-labelledby="video-modal-19-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-19-label">Converter Bônus em Saldo</h5>
        <div class="close-button">
    <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">

      <div class="d-flex align-items-center justify-content-center">
  <video controls width = "500">
    <source src="{{asset('admin/videos/converter-bonus-em-saldo.mp4')}}" type="video/mp4">
  </video>
</div>
      </div>
    </div>
  </div>
</div>

<!-- modal 20-->

<div class="modal fade" id="video-modal-20" tabindex="-20" aria-labelledby="video-modal-20-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-20-label">Loto Fácil para Clientes</h5>
        <div class="close-button">
    <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">

      <div class="d-flex align-items-center justify-content-center">
  <video controls width = "500">
    <source src="{{asset('admin/videos/lotofacil-para-cliente.mp4')}}" type="video/mp4">
  </video>
</div>
      </div>
    </div>
  </div>
</div>

<!-- modal 21-->

<div class="modal fade" id="video-modal-21" tabindex="-21" aria-labelledby="video-modal-21-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-21-label">Quina</h5>
        <div class="close-button">
    <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">

      <div class="d-flex align-items-center justify-content-center">
  <video controls width = "500">
    <source src="{{asset('admin/videos/quina.mp4')}}" type="video/mp4">
  </video>
</div>
      </div>
    </div>
  </div>
</div>

<script>
    function fecharPagina() {
        window.close();
    }
</script>

<script>
    function openModal1() {
      $('#video-modal-1').modal('show');
    }
    function openModal2() {
    $('#video-modal-2').modal('show');
    }
    function openModal3() {
    $('#video-modal-3').modal('show');
    }
    function openModal4() {
    $('#video-modal-4').modal('show');
    }
    function openModal5() {
    $('#video-modal-5').modal('show');
    }
    function openModal6() {
    $('#video-modal-6').modal('show');
    }
    function openModal7() {
    $('#video-modal-7').modal('show');
    }
    function openModal8() {
    $('#video-modal-8').modal('show');
    }
    function openModal9() {
    $('#video-modal-9').modal('show');
    }
    function openModal10() {
    $('#video-modal-10').modal('show');
    }
    function openModal11() {
    $('#video-modal-11').modal('show');
    }
    function openModal12() {
    $('#video-modal-12').modal('show');
    }
    function openModal13() {
    $('#video-modal-13').modal('show');
    }
    function openModal14() {
    $('#video-modal-14').modal('show');
    }
    function openModal15() {
    $('#video-modal-15').modal('show');
    }
    function openModal16() {
    $('#video-modal-16').modal('show');
    }
    function openModal17() {
    $('#video-modal-17').modal('show');
    }
    function openModal18() {
    $('#video-modal-18').modal('show');
    }
    function openModal19() {
    $('#video-modal-19').modal('show');
    }
    function openModal20() {
    $('#video-modal-20').modal('show');
    }
    function openModal21() {
    $('#video-modal-21').modal('show');
    }



  </script>
 





<head>
  <style>
    .card {
      width: 300px;
      border-radius: 5px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
      overflow: hidden;
      transition: transform 0.3s ease;
      cursor: pointer;
      margin-bottom: 20px;
    }
    
    .card:hover {
      transform: translateY(-5px);
    }
    
    .card img {
      width: 100%;
      height: auto;
    }
    
    .card-content {
      padding: 20px;
    }
    
    .card-title {
      font-size: 18px;
      font-weight: bold;
      margin-bottom: 10px;
    }
    
    .card-description {
      font-size: 14px;
      color: #555;
    }
  </style>
</head>
</html>


@endsection





