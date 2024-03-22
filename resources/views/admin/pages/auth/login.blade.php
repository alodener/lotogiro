<div class="container-login100">

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

        <div class="card-body login-card-body" style="border-radius:10px;">
            @if (session('success'))
            <div class="col-md-12 alert alert-success" style=" margin-right:0%;" role="alert">
                {{ session('success') }}
            </div>
            @endif
            <div class="login-logo mt-md-5">

                <img src="{{ App\Helper\Configs::getConfigLogo() }}" alt="" width="150" height="150">

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
                @if (session('erro'))
                <div class="col-md-12 alert alert-danger" style=" margin-right:0%;" role="alert">
                    {{ session('erro') }}
                </div>
                @endif
                @error('error')
                <div class="alert alert-default-danger alert-dismissible fade show">
                    {{ $message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @enderror
            </div>
            <h3 class="login-box-msg" style="color:#A3D712">Entre para continuar</h3>

            <form method="POST" action="{{route('admin.post.login')}}">
                @csrf
                <div class="wrap-input100">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fa fa-user mr-2" aria-hidden="true"></i>

                        <input type="email" class="form-control @error('email') is-invalid @enderror input100"
                            name="email" placeholder="E-mail">
                    </div>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
                <div class="wrap-input100">
                    <div class="d-flex align-items-center">
                        <i class="fa fa-lock mr-2" aria-hidden="true"></i>

                        <input type="password" class="form-control @error('password') is-invalid @enderror input100"
                            name="password" placeholder="Senha">

                    </div>

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="icheck-primary">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ trans('admin.keep-connected') }}
                            </label>
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <button type="submit" class="login100-form-btn login">{{ trans('admin.pagesF.acessar') }}</button>
                    </div>
                </div>
            </form>

            <div class="d-flex justify-content-center align-items-center p-2 login">
               <a href="{{ route('forget.password.get') }}" class="btn btn-block btn-success login">{{ trans('admin.forgot-password-link') }}</a>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <p class="mb-1 text-bold">
                        {{ trans('admin.register-label') }}<br>
                        <button class="btn btn-block btn-info right login"  onclick="toggleModal()">
                            {{ trans('admin.register-button') }}
</button>
                    </p>

                    <a href="https://wa.me/558196826967?text=Olá, poderia me ajudar?" class="btn btn-block btn-success login"
                        title="Precisa de ajuda?" target="_blank">
                        <i style="border:none;" class="fa fa-whatsapp"></i> {{ trans('admin.pagesF.precisaAjuda') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
