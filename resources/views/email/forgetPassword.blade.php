<center>

    <img src="https://superjogo.loteriabr.com/{{env('logo')}}" alt="" width=150 height=150>


    <h1>{{ trans('admin.pagesF.resetSenha') }}</h1>
</center>

<pre>
        {{ trans('admin.pagesF.ola') }}
    
    <a href="{{ route('reset.password.get', $token) }}">{{ trans('admin.pagesF.recSenha') }}</a>

    {{ trans('admin.pagesF.atenc') }}

    {{ env("nome_sistema") }}</pre>

