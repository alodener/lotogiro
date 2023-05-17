<center>

    <img src="https://superjogo.loteriabr.com/{{env('logo')}}" alt="" width=150 height=150>


    <h1>{{ trans ('admin.forgetBlade.reset') }}  </h1>
</center>

<pre>
    
        {{ trans ('admin.forgetBlade.link') }}  
    <a href="{{ route('reset.password.get', $token) }}">  {{ trans ('admin.forgetBlade.recuperarS') }}   </a>

    {{ trans ('admin.forgetBlade.atenc') }}

    {{ env("nome_sistema") }}</pre>

