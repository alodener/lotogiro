@extends('admin.layouts.login')

@section('title', 'Login')

@section('content')


  <div class="container-login100">

         @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        
        @if (session('SenhaRecuperada'))
            <div class="alert alert-success" role="alert">
                {{ session('SenhaRecuperada') }}
            </div>
        @endif
        
        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif
        <div class="wrap-login100">
            <div class="card-body login-card-body">
                        <div class="login-logo mt-md-5">

            <img src="{{ asset(env('logo')) }}" alt="" width="150" height="150">

        </div>
                <div class="col-md-12 px-4">
                    @error('success')
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ $message }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @enderror
                    @error('error')
                    <div class="alert alert-default-danger alert-dismissible fade show">
                        {{ $message }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @enderror
                </div>
                <h3 class="login-box-msg">Login</h3>

                <form method="POST" action="{{route('admin.post.login')}}">
                    @csrf
                    <div class="wrap-input100">
                        <input type="email" class="form-control @error('email') is-invalid @enderror input100" name="email"
                               placeholder="E-mail">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        </span>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="wrap-input100">
                        <input type="password" class="form-control @error('password') is-invalid @enderror input100"
                               name="password" placeholder="Senha">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                        <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" name="remember"
                                       id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Manter conectado
                                </label>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="login100-form-btn">Acessar</button>
                        </div>
                    </div>
                </form>
                
                <a href="{{ route('forget.password.get') }}">Esqueceu sua Senha?</a>

                <div class="row">
                    <div class="col-sm-12">
                        <p class="mb-1 text-bold">
                            Não é cadastrado?<br>
                            <a class="btn btn-block btn-info right"
                               href="{{ route('register') }}">
                                Cadastre-se
                            </a>
                        </p>

                        <a href="https://wa.me/558196826967?text=Olá, poderia me ajudar?"
                           class="btn btn-block btn-success"
                           title="Precisa de ajuda?"
                           target="_blank">
                            <i style="border:none;"class="fa fa-whatsapp"></i> Precisa de ajuda?
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
