@extends('admin.layouts.master')

@section('title', 'Tutoriais')

@section('content')

<div class="row"> <div class="col-md-12">

  <div class="col-md-12 p-4 card-header  mt-3 mb-3">
    <h3 class="text-center text-bold">{{ trans('admin.menu.tutoriais') }}
    </h3>
  </div>
  <div class="container">
    <ul class="nav nav-tabs" id="myTabs" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="btn-primary br active mr-4 mb-3" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1" type="button"
          role="tab" aria-controls="tab1" aria-selected="true">Loterias</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="btn-primary br mb-3" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2" type="button" role="tab"
          aria-controls="tab2" aria-selected="false">Bichão</button>
      </li>
    </ul>

<style>
  .br{
    border-radius: 5px;
    

  }</style>
    <!-- loterias tab1 -->
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active " id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
        <div class="container">
          <div class="row mt-3">
            <div class="col-sm-6 col-md-4 d-flex justify-content-center">
              <div class="card" onclick="openModal1()">
                <div class="card-content">
                  <h3 class="card-title">CONSULTOR 001 - Como Apostar para o Cliente</h3>
                </div>
              </div>
            </div>

            <div class="col-sm-6 col-md-4 d-flex justify-content-center">
              <div class="card" onclick="openModal2()">
                <div class="card-content">
                  <h3 class="card-title">CONSULTOR 002 - Como Apostar Para Si</h3>
                </div>
              </div>
            </div>


            <div class="col-sm-6 col-md-4 d-flex justify-content-center">
              <div class="card" onclick="openModal3()">
                <div class="card-content">
                  <h3 class="card-title">JOGO 001 - Chispaloto</h3>
                </div>
              </div>
            </div>

            <div class="col-sm-6 col-md-4 d-flex justify-content-center">
              <div class="card" onclick="openModal4()">
                <div class="card-content">
                  <h3 class="card-title">JOGO 002 - Dia de Alegria</h3>
                </div>
              </div>
            </div>


            <div class="col-sm-6 col-md-4 d-flex justify-content-center">
              <div class="card" onclick="openModal5()">
                <div class="card-content">
                  <h3 class="card-title">JOGO 003 - Lotinha</h3>
                </div>
              </div>
            </div>


            <div class="col-sm-6 col-md-4 d-flex justify-content-center">
              <div class="card" onclick="openModal6()">
                <div class="card-content">
                  <h3 class="card-title">JOGO 004 - Mania de Jogo</h3>
                </div>
              </div>
            </div>


            <div class="col-sm-6 col-md-4 d-flex justify-content-center">
              <div class="card" onclick="openModal7()">
                <div class="card-content">
                  <h3 class="card-title">JOGO 005 - Mania de Time</h3>
                </div>
              </div>
            </div>

            <div class="col-sm-6 col-md-4 d-flex justify-content-center">
              <div class="card" onclick="openModal8()">
                <div class="card-content">
                  <h3 class="card-title">JOGO 006 - O milionário</h3>
                </div>
              </div>
            </div>


            <div class="col-sm-6 col-md-4 d-flex justify-content-center">
              <div class="card" onclick="openModal9()">
                <div class="card-content">
                  <h3 class="card-title">JOGO 007 - Super 5</h3>
                </div>
              </div>
            </div>

            <div class="col-sm-6 col-md-4 d-flex justify-content-center">
              <div class="card" onclick="openModal10()">
                <div class="card-content">
                  <h3 class="card-title">JOGO 008 - Super 6</h3>
                </div>
              </div>
            </div>


            <div class="col-sm-6 col-md-4 d-flex justify-content-center">
              <div class="card" onclick="openModal11()">
                <div class="card-content">
                  <h3 class="card-title">JOGO 009 - Santa Lúcia Loto</h3>
                </div>
              </div>
            </div>


            <div class="col-sm-6 col-md-4 d-flex justify-content-center">
              <div class="card" onclick="openModal12()">
                <div class="card-content">
                  <h3 class="card-title">JOGO 010 - Quina Fácil</h3>
                </div>
              </div>
            </div>


            <div class="col-sm-6 col-md-4 d-flex justify-content-center">
              <div class="card" onclick="openModal13()">
                <div class="card-content">
                  <h3 class="card-title">JOGO 011 - Duplo 6</h3>
                </div>
              </div>
            </div>

            <div class="col-sm-6 col-md-4 d-flex justify-content-center">
              <div class="card" onclick="openModal14()">
                <div class="card-content">
                  <h3 class="card-title">PLATAFORMA 002 - Convidar Cliente (Consultor)</h3>
                </div>
              </div>
            </div>

            <div class="col-sm-6 col-md-4 d-flex justify-content-center">
              <div class="card" onclick="openModal22()">
                <div class="card-content">
                  <h3 class="card-title">PLATAFORMA 003 - Ver Apostas Realizadas</h3>
                </div>
              </div>
            </div>

            <div class="col-sm-6 col-md-4 d-flex justify-content-center">
              <div class="card" onclick="openModal23()">
                <div class="card-content">
                  <h3 class="card-title">PLATAFORMA 004 - Depositar</h3>
                </div>
              </div>
            </div>

            <div class="col-sm-6 col-md-4 d-flex justify-content-center">
              <div class="card" onclick="openModal25()">
                <div class="card-content">
                  <h3 class="card-title">PLATAFORMA 005 - Sacar</h3>
                </div>
              </div>
            </div>

            <div class="col-sm-6 col-md-4 d-flex justify-content-center">
              <div class="card" onclick="openModal26()">
                <div class="card-content">
                  <h3 class="card-title">PLATAFORMA 006 - Converter</h3>
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
          <div class="row mt-3">
            <div class="col-sm-6 col-md-4 d-flex justify-content-center">
              <div class="card" onclick="openModal15()">
                <div class="card-content">
                  <h3 class="card-title">{{ trans('admin.tutoriais.jogaremgrupo') }}</h3>
                </div>
              </div>
            </div>


            <div class="col-sm-6 col-md-4 d-flex justify-content-center">
              <div class="card" onclick="openModal16()">
                <div class="card-content">
                  <h3 class="card-title">{{ trans('admin.tutoriais.duquededezena') }}</h3>
                </div>
              </div>
            </div>

            <div class="col-sm-6 col-md-4 d-flex justify-content-center">
              <div class="card" onclick="openModal17()">
                <div class="card-content">
                  <h3 class="card-title">{{ trans('admin.tutoriais.duquedegrupo') }}</h3>
                </div>
              </div>
            </div>

            <div class="col-sm-6 col-md-4 d-flex justify-content-center">
              <div class="card" onclick="openModal18()">
                <div class="card-content">
                  <h3 class="card-title">{{ trans('admin.tutoriais.milharcentena') }}</h3>
                </div>
              </div>
            </div>

            <div class="col-sm-6 col-md-4 d-flex justify-content-center">
              <div class="card" onclick="openModal19()">
                <div class="card-content">
                  <h3 class="card-title">{{ trans('admin.tutoriais.resultbichao') }}</h3>
                </div>
              </div>
            </div>

            <div class="col-sm-6 col-md-4 d-flex justify-content-center">
              <div class="card" onclick="openModal20()">
                <div class="card-content">
                  <h3 class="card-title">{{ trans('admin.tutoriais.ternodezena') }}</h3>
                </div>
              </div>
            </div>

            <div class="col-sm-6 col-md-4 d-flex justify-content-center">
              <div class="card" onclick="openModal21()">
                <div class="card-content">
                  <h3 class="card-title">{{ trans('admin.tutoriais.ternogrupo') }}</h3>
                </div>
              </div>
            </div>

            <div class="col-sm-6 col-md-4 d-flex justify-content-center">
              <div class="card" onclick="openModal24()">
                <div class="card-content">
                  <h3 class="card-title">008 - Como Fazer Múltiplos Jogos no Bichão </h3>
                </div>
              </div>
            </div>

            <div class="col-sm-6 col-md-4 d-flex justify-content-center">
              <div class="card" onclick="openModal27()">
                <div class="card-content">
                  <h3 class="card-title">009 - Milhar </h3>
                </div>
              </div>
            </div>

            <div class="col-sm-6 col-md-4 d-flex justify-content-center">
              <div class="card" onclick="openModal31()">
                <div class="card-content">
                  <h3 class="card-title">010 - Milhar Invertida </h3>
                </div>
              </div>
            </div>

            <div class="col-sm-6 col-md-4 d-flex justify-content-center">
              <div class="card" onclick="openModal28()">
                <div class="card-content">
                  <h3 class="card-title">011 - Centena </h3>
                </div>
              </div>
            </div>

             <div class="col-sm-6 col-md-4 d-flex justify-content-center">
              <div class="card" onclick="openModal32()">
                <div class="card-content">
                  <h3 class="card-title">012 - Centena Invertida </h3>
                </div>
              </div>
            </div>

            <div class="col-sm-6 col-md-4 d-flex justify-content-center">
              <div class="card" onclick="openModal29()">
                <div class="card-content">
                  <h3 class="card-title">013 - Dezena </h3>
                </div>
              </div>
            </div>

            <div class="col-sm-6 col-md-4 d-flex justify-content-center">
              <div class="card" onclick="openModal30()">
                <div class="card-content">
                  <h3 class="card-title">014 - Grupo </h3>
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




<!-- modal 1-->

<div class="modal fade" id="video-modal-1" tabindex="-1" aria-labelledby="video-modal-1-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-1-label">CONSULTOR 001 - Como Apostar para o Cliente</h5>
        <div class="close-button">
          <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">
        <div class="d-flex align-items-center justify-content-center">
          <video controls width="500">
            <source src="{{asset('admin/videos/apostar_cliente.mp4')}}" type="video/mp4">
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
        <h5 class="modal-title" id="video-modal-2-label">CONSULTOR 002 - Como Apostar Para Si</h5>
        <div class="close-button">
          <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">
        <div class="d-flex align-items-center justify-content-center">
          <video controls width="500">
            <source src="{{asset('admin/videos/apostar_si.mp4')}}" type="video/mp4">
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
        <h5 class="modal-title" id="video-modal-3-label">JOGO 001 - Chispaloto</h5>
        <div class="close-button">
          <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">
        <div class="d-flex align-items-center justify-content-center">
          <video controls width="500">
            <source src="{{asset('admin/videos/chispaloto.mp4')}}" type="video/mp4">
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
        <h5 class="modal-title" id="video-modal-4-label">JOGO 002 - Dia de Alegria</h5>
        <div class="close-button">
          <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">
        <div class="d-flex align-items-center justify-content-center">
          <video controls width="500">
            <source src="{{asset('admin/videos/dia_alegria.mp4')}}" type="video/mp4">
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
        <h5 class="modal-title" id="video-modal-5-label">JOGO 003 - Lotinha</h5>
        <div class="close-button">
          <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">
        <div class="d-flex align-items-center justify-content-center">
          <video controls width="500">
            <source src="{{asset('admin/videos/lotinha.mp4')}}" type="video/mp4">
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
        <h5 class="modal-title" id="video-modal-6-label">JOGO 004 - Mania de Jogo</h5>
        <div class="close-button">
          <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">
        <div class="d-flex align-items-center justify-content-center">
          <video controls width="500">
            <source src="{{asset('admin/videos/mania_jogo.mp4')}}" type="video/mp4">
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
        <h5 class="modal-title" id="video-modal-7-label">JOGO 005 - Mania de Time</h5>
        <div class="close-button">
          <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">
        <div class="d-flex align-items-center justify-content-center">
          <video controls width="500">
            <source src="{{asset('admin/videos/mania_time.mp4')}}" type="video/mp4">
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
        <h5 class="modal-title" id="video-modal-8-label">JOGO 006 - O milionário</h5>
        <div class="close-button">
          <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">
        <div class="d-flex align-items-center justify-content-center">
          <video controls width="500">
            <source src="{{asset('admin/videos/milionario.mp4')}}" type="video/mp4">
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
        <h5 class="modal-title" id="video-modal-9-label">JOGO 007 - Super 5</h5>
        <div class="close-button">
          <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">
        <div class="d-flex align-items-center justify-content-center">
          <video controls width="500">
            <source src="{{asset('admin/videos/super5.mp4')}}" type="video/mp4">
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
        <h5 class="modal-title" id="video-modal-10-label">JOGO 008 - Super 6</h5>
        <div class="close-button">
          <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">
        <div class="d-flex align-items-center justify-content-center">
          <video controls width="500">
            <source src="{{asset('admin/videos/super6.mp4')}}" type="video/mp4">
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
        <h5 class="modal-title" id="video-modal-11-label">JOGO 009 - Santa Lúcia Loto</h5>
        <div class="close-button">
          <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">
        <div class="d-flex align-items-center justify-content-center">
          <video controls width="500">
            <source src="{{asset('admin/videos/sta_lucia.mp4')}}" type="video/mp4">
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
        <h5 class="modal-title" id="video-modal-12-label">JOGO 010 - Quina Fácil</h5>
        <div class="close-button">
          <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">
        <div class="d-flex align-items-center justify-content-center">
          <video controls width="500">
            <source src="{{asset('admin/videos/quina_facil.mp4')}}" type="video/mp4">
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
        <h5 class="modal-title" id="video-modal-13-label">JOGO 011 - Duplo 6</h5>
        <div class="close-button">
          <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">
        <div class="d-flex align-items-center justify-content-center">
          <video controls width="500">
            <source src="{{asset('admin/videos/duplo6.mp4')}}" type="video/mp4">
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
        <h5 class="modal-title" id="video-modal-14-label">PLATAFORMA 002 - Convidar Cliente (Consultor)</h5>
        <div class="close-button">
          <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">
        <div class="d-flex align-items-center justify-content-center">
          <video controls width="500">
            <source src="{{asset('admin/videos/conv_cliente.mp4')}}" type="video/mp4">
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
          <video controls width="500">
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
          <video controls width="500">
            <source src="{{asset('admin/videos/duquedezena.mp4')}}" type="video/mp4">
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
          <video controls width="500">
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
          <video controls width="500">
            <source src="{{asset('admin/videos/milharcent.mp4')}}" type="video/mp4">
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
          <video controls width="500">
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
          <video controls width="500">
            <source src="{{asset('admin/videos/ternodezena.mp4')}}" type="video/mp4">
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
          <video controls width="500">
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
        <h5 class="modal-title" id="video-modal-22-label">PLATAFORMA 003 - Ver Apostas Realizadas</h5>
        <div class="close-button">
          <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">
        <div class="d-flex align-items-center justify-content-center">
          <video controls width="500">
            <source src="{{asset('admin/videos/apostas_realizadas.mp4')}}" type="video/mp4">
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
        <h5 class="modal-title" id="video-modal-23-label">PLATAFORMA 004 - Depositar</h5>
        <div class="close-button">
          <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">
        <div class="d-flex align-items-center justify-content-center">
          <video controls width="500">
            <source src="{{asset('admin/videos/depositar.mp4')}}" type="video/mp4">
          </video>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- modal 24-->

<div class="modal fade" id="video-modal-24" tabindex="-24" aria-labelledby="video-modal-24-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-24-label">008 - Como Fazer Múltiplos Jogos no Bichão</h5>
        <div class="close-button">
          <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">
        <div class="d-flex align-items-center justify-content-center">
          <video controls width="500">
            <source src="{{asset('admin/videos/multiplos-jogos.mp4')}}" type="video/mp4">
          </video>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- modal 25-->

<div class="modal fade" id="video-modal-25" tabindex="-25" aria-labelledby="video-modal-25-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-25-label">PLATAFORMA 005 - Sacar</h5>
        <div class="close-button">
          <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">
        <div class="d-flex align-items-center justify-content-center">
          <video controls width="500">
            <source src="{{asset('admin/videos/sacar.mp4')}}" type="video/mp4">
          </video>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- modal 26-->

<div class="modal fade" id="video-modal-26" tabindex="-26" aria-labelledby="video-modal-26-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-26-label">PLATAFORMA 006 - Converter</h5>
        <div class="close-button">
          <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">
        <div class="d-flex align-items-center justify-content-center">
          <video controls width="500">
            <source src="{{asset('admin/videos/converter.mp4')}}" type="video/mp4">
          </video>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- modal 27-->

<div class="modal fade" id="video-modal-27" tabindex="-27" aria-labelledby="video-modal-27-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-27-label">009 - Milhar</h5>
        <div class="close-button">
          <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">
        <div class="d-flex align-items-center justify-content-center">
          <video controls width="500">
            <source src="{{asset('admin/videos/milhar.mp4')}}" type="video/mp4">
          </video>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- modal 28-->

<div class="modal fade" id="video-modal-28" tabindex="-28" aria-labelledby="video-modal-28-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-28-label"> 010 - Centena  </h5>
        <div class="close-button">
          <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">
        <div class="d-flex align-items-center justify-content-center">
          <video controls width="500">
            <source src="{{asset('admin/videos/dezena.mp4')}}" type="video/mp4">
          </video>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- modal 29-->

<div class="modal fade" id="video-modal-29" tabindex="-29" aria-labelledby="video-modal-29-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-29-label">011 - Dezena</h5>
        <div class="close-button">
          <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">
        <div class="d-flex align-items-center justify-content-center">
          <video controls width="500">
            <source src="{{asset('admin/videos/dezena.mp4')}}" type="video/mp4">
          </video>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- modal 30-->

<div class="modal fade" id="video-modal-30" tabindex="-30" aria-labelledby="video-modal-30-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-30-label">012 - Grupo</h5>
        <div class="close-button">
          <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">
        <div class="d-flex align-items-center justify-content-center">
          <video controls width="500">
            <source src="{{asset('admin/videos/grupo.mp4')}}" type="video/mp4">
          </video>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- modal 31-->

<div class="modal fade" id="video-modal-31" tabindex="-31" aria-labelledby="video-modal-31-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-31-label">010 - Milhar Invertida </h5>
        <div class="close-button">
          <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">
        <div class="d-flex align-items-center justify-content-center">
          <video controls width="500">
            <source src="{{asset('admin/videos/milhinvertida.mp4')}}" type="video/mp4">
          </video>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- modal 32-->

<div class="modal fade" id="video-modal-32" tabindex="-32" aria-labelledby="video-modal-32-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video-modal-32-label">012 - Centena Invertida </h5>
        <div class="close-button">
          <a href="/admin/dashboards/help/tutoriais"><span class="close-icon">&times;</span></a>
        </div>
      </div>
      <div class="modal-body">
        <div class="d-flex align-items-center justify-content-center">
          <video controls width="500">
            <source src="{{asset('admin/videos/centinvertida.mp4')}}" type="video/mp4">
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
  function openModal24() {
    $('#video-modal-24').modal('show');
  }
  function openModal25() {
    $('#video-modal-25').modal('show');
  }
  function openModal26() {
    $('#video-modal-26').modal('show');
  }
  function openModal27() {
    $('#video-modal-27').modal('show');
  }
  function openModal28() {
    $('#video-modal-28').modal('show');
  }
  function openModal29() {
    $('#video-modal-29').modal('show');
  }
  function openModal30() {
    $('#video-modal-30').modal('show');
  }
  
function openModal31() {
    $('#video-modal-31').modal('show');
  }
    
    function openModal32() {
      
    $('#video-modal-32').modal('show');
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
