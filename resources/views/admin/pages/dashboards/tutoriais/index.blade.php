@extends('admin.layouts.master')

@section('title', 'Tutoriais')

@section('content')

<div class="row bg-white p-3">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="card-header indica-card">
                {{ trans('admin.menu.tutoriais') }}
                </div>
            </div>
        </div> 

        <div class="container">
  <ul class="nav nav-tabs" id="myTabs" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1" type="button" role="tab" aria-controls="tab1" aria-selected="true">Loterias</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2" type="button" role="tab" aria-controls="tab2" aria-selected="false">Bichão</button>
    </li>
  </ul>

    <!-- loterias tab1 --> 
    <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
      <div class="container">
        <div class="row">
          <div class="col-sm-6 col-md-4">
            <div class="card" onclick="openModal1()">
              <div class="card-content">
                <h3 class="card-title">{{ trans('admin.tutoriais.convclientes') }}</h3>
              </div>
            </div>
          </div>

      <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal2()">
    <div class="card-content">
      <h3 class="card-title">{{ trans('admin.tutoriais.realrecargas') }}</h3>
    </div>
  </div>
  </div>

  
  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal3()">
    <div class="card-content">
      <h3 class="card-title">{{ trans('admin.tutoriais.comosecadastrar') }}</h3>
    </div>
  </div>
  </div>

  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal4()">
    <div class="card-content">
      <h3 class="card-title">{{ trans('admin.tutoriais.converter') }}</h3>
    </div>
  </div>
  </div>


  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal5()">
    <div class="card-content">
      <h3 class="card-title">{{ trans('admin.tutoriais.atualizarcadastro') }}</h3>
    </div>
  </div>
  </div>


  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal6()">
    <div class="card-content">
      <h3 class="card-title">{{ trans('admin.tutoriais.multiplosjogos') }}</h3>
    </div>
  </div>
  </div>


  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal7()">
    <div class="card-content">
      <h3 class="card-title">{{ trans('admin.tutoriais.apostarlotofacil') }}</h3>
    </div>
  </div>
  </div>

  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal8()">
    <div class="card-content">
      <h3 class="card-title">{{ trans('admin.tutoriais.apostarlotocliente') }}</h3>
    </div>
  </div>
  </div>


  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal9()">
    <div class="card-content">
      <h3 class="card-title">{{ trans('admin.tutoriais.quina') }}</h3>
    </div>
  </div>
  </div>

  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal10()"> 
    <div class="card-content">
      <h3 class="card-title">{{ trans('admin.tutoriais.jogarmegasena') }}</h3>
    </div>
  </div>
  </div>


  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal11()">
    <div class="card-content">
      <h3 class="card-title">{{ trans('admin.tutoriais.jogarduplasena') }}</h3>
    </div>
  </div>
  </div>


  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal12()">
    <div class="card-content">
      <h3 class="card-title">{{ trans('admin.tutoriais.jogardie') }}</h3>
    </div>
  </div>
  </div>


  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal13()">
    <div class="card-content">
      <h3 class="card-title">{{ trans('admin.tutoriais.apostarlotomania') }}</h3>
    </div>
  </div>
  </div>

  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal14()">
    <div class="card-content">
      <h3 class="card-title">{{ trans('admin.tutoriais.jogartimemania') }}</h3>
    </div>
  </div>
  </div>

        <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal22()">
    <div class="card-content">
      <h3 class="card-title">{{ trans('admin.tutoriais.quinasaojoao') }}</h3>
</div>
    </div>
  </div>

  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal23()">
    <div class="card-content">
      <h3 class="card-title">{{ trans('admin.tutoriais.apostmilharcent') }}</h3>
</div>
    </div>
  </div>

  </div>
      </div>
    </div>
  </div>

<!-- bichão tab2--> 
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
      <div class="container">
        <div class="row">
          <div class="col-sm-6 col-md-4">
            <div class="card" onclick="openModal15()">
              <div class="card-content">
                <h3 class="card-title">{{ trans('admin.tutoriais.jogaremgrupo') }}</h3>
              </div>
            </div>
          </div>


  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal16()">
    <div class="card-content">
      <h3 class="card-title">{{ trans('admin.tutoriais.duquededezena') }}</h3>
    </div>
  </div>
  </div>

  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal17()">
    <div class="card-content">
      <h3 class="card-title">{{ trans('admin.tutoriais.duquedegrupo') }}</h3>
    </div>
  </div>
  </div>

  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal18()">
    <div class="card-content">
      <h3 class="card-title">{{ trans('admin.tutoriais.milharcentena') }}</h3>
    </div>
  </div>
  </div>

  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal19()">
    <div class="card-content">
      <h3 class="card-title">{{ trans('admin.tutoriais.resultbichao') }}</h3>
    </div>
  </div>
  </div>

  <div class="col-sm-6 col-md-4">
      <div class="card" onclick="openModal20()">
    <div class="card-content">
      <h3 class="card-title">{{ trans('admin.tutoriais.ternodezena') }}</h3>
    </div>
  </div>
  </div>

  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal21()">
    <div class="card-content">
      <h3 class="card-title">{{ trans('admin.tutoriais.ternogrupo') }}</h3>
</div>
    </div>
  </div>


        </div>
    </div>
</div>
</div>
      </div>
    </div>
  </div>
</div>


<!--

<html>
<body>
<div class="container">
    <div class="row">
      <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal1()">
    <div class="card-content">
      <h3 class="card-title">{{ trans('admin.tutoriais.convclientes') }}</h3>
    </div>
  </div>
  </div>

      <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal2()">
    <div class="card-content">
      <h3 class="card-title">{{ trans('admin.tutoriais.realrecargas') }}</h3>
    </div>
    </a>
  </div>
  </div>

  
  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal3()">
    <div class="card-content">
      <h3 class="card-title">{{ trans('admin.tutoriais.comosecadastrar') }}</h3>
    </div>
  </div>
  </div>

  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal4()">
    <div class="card-content">
      <h3 class="card-title">{{ trans('admin.tutoriais.converter') }}</h3>
    </div>
  </div>
  </div>


  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal5()">
    <div class="card-content">
      <h3 class="card-title">{{ trans('admin.tutoriais.atualizarcadastro') }}</h3>
    </div>
  </div>
  </div>


  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal6()">
    <div class="card-content">
      <h3 class="card-title">{{ trans('admin.tutoriais.multiplosjogos') }}</h3>
    </div>
  </div>
  </div>


  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal7()">
    <div class="card-content">
      <h3 class="card-title">{{ trans('admin.tutoriais.apostarlotofacil') }}</h3>
    </div>
  </div>
  </div>

  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal8()">
    <div class="card-content">
      <h3 class="card-title">{{ trans('admin.tutoriais.apostarlotocliente') }}</h3>
    </div>
  </div>
  </div>


  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal9()">
    <div class="card-content">
      <h3 class="card-title">{{ trans('admin.tutoriais.quina') }}</h3>
    </div>
  </div>
  </div>

  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal10()"> 
    <div class="card-content">
      <h3 class="card-title">{{ trans('admin.tutoriais.jogarmegasena') }}</h3>
    </div>
  </div>
  </div>


  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal11()">
    <div class="card-content">
      <h3 class="card-title">{{ trans('admin.tutoriais.jogarduplasena') }}</h3>
    </div>
  </div>
  </div>


  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal12()">
    <div class="card-content">
      <h3 class="card-title">{{ trans('admin.tutoriais.jogardie') }}</h3>
    </div>
  </div>
  </div>


  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal13()">
    <div class="card-content">
      <h3 class="card-title">{{ trans('admin.tutoriais.apostarlotomania') }}</h3>
    </div>
  </div>
  </div>

  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal14()">
    <div class="card-content">
      <h3 class="card-title">{{ trans('admin.tutoriais.jogartimemania') }}</h3>
    </div>
  </div>
  </div>

  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal15()">
    <div class="card-content">
      <h3 class="card-title">{{ trans('admin.tutoriais.jogaremgrupo') }}</h3>
    </div>
  </div>
  </div>

  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal16()">
    <div class="card-content">
      <h3 class="card-title">{{ trans('admin.tutoriais.duquededezena') }}</h3>
    </div>
  </div>
  </div>

  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal17()">
    <div class="card-content">
      <h3 class="card-title">{{ trans('admin.tutoriais.duquedegrupo') }}</h3>
    </div>
  </div>
  </div>

  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal18()">
    <div class="card-content">
      <h3 class="card-title">{{ trans('admin.tutoriais.milharcentena') }}</h3>
    </div>
  </div>
  </div>

  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal19()">
    <div class="card-content">
      <h3 class="card-title">{{ trans('admin.tutoriais.resultbichao') }}</h3>
    </div>
  </div>
  </div>

  <div class="col-sm-6 col-md-4">
      <div class="card" onclick="openModal20()">
    <div class="card-content">
      <h3 class="card-title">{{ trans('admin.tutoriais.ternodezena') }}</h3>
    </div>
  </div>
  </div>

  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal21()">
    <div class="card-content">
      <h3 class="card-title">{{ trans('admin.tutoriais.ternogrupo') }}</h3>
</div>
    </div>
  </div>

  <div class="col-sm-6 col-md-4">
  <div class="card" onclick="openModal22()">
    <div class="card-content">
      <h3 class="card-title">Apostar na Quina de São João</h3>
</div>
    </div>
  </div> -->



  <!-- modal 1-->

  <div class="modal fade" id="video-modal-1" tabindex="-1" aria-labelledby="video-modal-1-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-1-label">{{ trans('admin.tutoriais.convclientes') }}</h5>
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

<!-- modal 2-->

<div class="modal fade" id="video-modal-2" tabindex="-2" aria-labelledby="video-modal-2-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-2-label">{{ trans('admin.tutoriais.realrecargas') }}</h5>
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

<!-- modal 3-->

<div class="modal fade" id="video-modal-3" tabindex="-3" aria-labelledby="video-modal-3-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-3-label">{{ trans('admin.tutoriais.comosecadastrar') }}</h5>
        <div class="close-button">
    <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">
      <div class="d-flex align-items-center justify-content-center">
  <video controls width = "500">
    <source src="{{asset('admin/videos/como-se-cadastrar.mp4')}}" type="video/mp4">
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
        <h5 class="modal-title" id="video-modal-4-label">{{ trans('admin.tutoriais.converter') }}</h5>
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

<!-- modal 5-->

<div class="modal fade" id="video-modal-5" tabindex="-5" aria-labelledby="video-modal-5-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-5-label">{{ trans('admin.tutoriais.atualizarcadastro') }}</h5>
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

<!-- modal 6-->

<div class="modal fade" id="video-modal-6" tabindex="-6" aria-labelledby="video-modal-6-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-6-label">{{ trans('admin.tutoriais.multiplosjogos') }}</h5>
        <div class="close-button">
    <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">
      <div class="d-flex align-items-center justify-content-center">
  <video controls width = "500">
    <source src="{{asset('admin/videos/fazer-multiplos-jogos.mp4')}}" type="video/mp4">
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
        <h5 class="modal-title" id="video-modal-7-label">{{ trans('admin.tutoriais.apostarlotofacil') }}</h5>
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

<!-- modal 8-->

<div class="modal fade" id="video-modal-8" tabindex="-8" aria-labelledby="video-modal-8-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-8-label">{{ trans('admin.tutoriais.apostarlotocliente') }}</h5>
        <div class="close-button">
    <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">
      <div class="d-flex align-items-center justify-content-center">
  <video controls width = "500">
    <source src="{{asset('admin/videos/lotofacil-para-clientt.mp4')}}" type="video/mp4">
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
        <h5 class="modal-title" id="video-modal-9-label">{{ trans('admin.tutoriais.quina') }}</h5>
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

<!-- modal 10-->

<div class="modal fade" id="video-modal-10" tabindex="-10" aria-labelledby="video-modal-10-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-10-label">{{ trans('admin.tutoriais.jogarmegasena') }}</h5>
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

<!-- modal 11-->

<div class="modal fade" id="video-modal-11" tabindex="-11" aria-labelledby="video-modal-11-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-11-label">{{ trans('admin.tutoriais.jogarduplasena') }}</h5>
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

<!-- modal 12-->

<div class="modal fade" id="video-modal-12" tabindex="-12" aria-labelledby="video-modal-12-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-12-label">{{ trans('admin.tutoriais.jogardie') }}</h5>
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
        <h5 class="modal-title" id="video-modal-13-label">{{ trans('admin.tutoriais.apostarlotomania') }}</h5>
        <div class="close-button">
    <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">
      <div class="d-flex align-items-center justify-content-center">
  <video controls width = "500">
    <source src="{{asset('admin/videos/apostar-lotomania.mp4')}}" type="video/mp4">
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
        <h5 class="modal-title" id="video-modal-14-label">{{ trans('admin.tutoriais.jogartimemania') }}</h5>
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

<!-- modal 15-->

<div class="modal fade" id="video-modal-15" tabindex="-15" aria-labelledby="video-modal-15-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-15-label">{{ trans('admin.tutoriais.jogaremgrupo') }}</h5>
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

<!-- modal 16-->

<div class="modal fade" id="video-modal-16" tabindex="-16" aria-labelledby="video-modal-16-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-16-label">{{ trans('admin.tutoriais.duquededezena') }}</h5>
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

<!-- modal 17-->

<div class="modal fade" id="video-modal-17" tabindex="-17" aria-labelledby="video-modal-17-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-17-label">{{ trans('admin.tutoriais.duquedegrupo') }}</h5>
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

<!-- modal 18-->

<div class="modal fade" id="video-modal-18" tabindex="-18" aria-labelledby="video-modal-18-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-18-label">{{ trans('admin.tutoriais.milharcentena') }}</h5>
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

<!-- modal 19-->

<div class="modal fade" id="video-modal-19" tabindex="-19" aria-labelledby="video-modal-19-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-19-label">{{ trans('admin.tutoriais.resultbichao') }}</h5>
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

<!-- modal 20-->

<div class="modal fade" id="video-modal-20" tabindex="-20" aria-labelledby="video-modal-20-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-20-label">{{ trans('admin.tutoriais.ternodezena') }}</h5>
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

<!-- modal 21-->

<div class="modal fade" id="video-modal-21" tabindex="-21" aria-labelledby="video-modal-21-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-21-label">{{ trans('admin.tutoriais.ternogrupo') }}</h5>
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

<!-- modal 22-->

<div class="modal fade" id="video-modal-22" tabindex="-22" aria-labelledby="video-modal-22-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-22-label">Apostar na Quina de São João</h5>
        <div class="close-button">
    <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">
      <div class="d-flex align-items-center justify-content-center">
  <video controls width = "500">
    <source src="{{asset('admin/videos/apostar-quina-saojoao.mp4')}}" type="video/mp4">
  </video>
</div>
      </div>
    </div>
  </div>
</div>

<!-- modal 23-->

<div class="modal fade" id="video-modal-23" tabindex="-23" aria-labelledby="video-modal-23-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-23-label">{{ trans('admin.tutoriais.apostmilharcent') }}</h5>
        <div class="close-button">
    <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">
      <div class="d-flex align-items-center justify-content-center">
  <video controls width = "500">
    <source src="{{asset('admin/videos/comojogar-milharcentena.mp4')}}" type="video/mp4">
  </video>
</div>
      </div>
    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


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
    function openModal22() {
    $('#video-modal-22').modal('show');
    }
    function openModal23() {
    $('#video-modal-23').modal('show');
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





