
<div class="d-flex align-items-start justify-content-center container flex-column card-master">
      <div class="card-header align-items-center">
                    <h4>Escolha uma Modalidade</h4>
                </div>
    <div class="d-flex justify-content-center align-items-center flex-wrap">
        <a type="button" class="mr-2 ml-2 btn btn-{{ Request::route()->getName() === 'admin.bets.bichao.index' ? '' : 'outline-' }}primary mb-1" href="{{ route('admin.bets.bichao.index') }}#game"><b>{{ trans('admin.bichao.milhar') }}</b></a>
        <a type="button" class="mr-2 ml-2 btn btn-{{ Request::route()->getName() === 'admin.bets.bichao.centena' ? '' : 'outline-' }}primary mb-1" href="{{ route('admin.bets.bichao.centena') }}#game"><b>{{ trans('admin.bichao.centena') }}</b></a>
        <a type="button" class="mr-2 ml-2 btn btn-{{ Request::route()->getName() === 'admin.bets.bichao.dezena' ? '' : 'outline-' }}primary mb-1" href="{{ route('admin.bets.bichao.dezena') }}#game"><b>{{ trans('admin.bichao.dezena') }}</b></a>
        <a type="button" class="mr-2 ml-2 btn btn-{{ Request::route()->getName() === 'admin.bets.bichao.group' ? '' : 'outline-' }}primary mb-1" href="{{ route('admin.bets.bichao.group') }}#game"><b>{{ trans('admin.bichao.grupo') }}</b></a>
        <a type="button" class="mr-2 ml-2 btn btn-{{ Request::route()->getName() === 'admin.bets.bichao.milhar.centena' ? '' : 'outline-' }}primary mb-1" href="{{ route('admin.bets.bichao.milhar.centena') }}#game"><b>{{ trans('admin.bichao.milhcent') }}</b></a>
        <a type="button" class="mr-2 ml-2 btn btn-{{ Request::route()->getName() === 'admin.bets.bichao.terno.dezena' ? '' : 'outline-' }}primary mb-1" href="{{ route('admin.bets.bichao.terno.dezena') }}#game"><b>{{ trans('admin.bichao.terndez') }}</b></a>
        <a type="button" class="mr-2 ml-2 btn btn-{{ Request::route()->getName() === 'admin.bets.bichao.duque.dezena' ? '' : 'outline-' }}primary mb-1" href="{{ route('admin.bets.bichao.duque.dezena') }}#game"><b>{{ trans('admin.bichao.duqdez') }}</b></a>
        <a type="button" class="mr-2 ml-2 btn btn-{{ Request::route()->getName() === 'admin.bets.bichao.quina.grupo' ? '' : 'outline-' }}primary mb-1" href="{{ route('admin.bets.bichao.quina.grupo') }}#game"><b>{{ trans('admin.bichao.quinagrup') }}</b></a>
        <a type="button" class="mr-2 ml-2 btn btn-{{ Request::route()->getName() === 'admin.bets.bichao.quadra.grupo' ? '' : 'outline-' }}primary mb-1" href="{{ route('admin.bets.bichao.quadra.grupo') }}#game"><b>{{ trans('admin.bichao.quadragrup') }}</b></a>
        <a type="button" class="mr-2 ml-2 btn btn-{{ Request::route()->getName() === 'admin.bets.bichao.terno.grupo' ? '' : 'outline-' }}primary mb-1" href="{{ route('admin.bets.bichao.terno.grupo') }}#game"><b>{{ trans('admin.bichao.terngrup') }}</b></a>
        <a type="button" class="mr-2 ml-2 btn btn-{{ Request::route()->getName() === 'admin.bets.bichao.duque.grupo' ? '' : 'outline-' }}primary mb-1" href="{{ route('admin.bets.bichao.duque.grupo') }}#game"><b>{{ trans('admin.bichao.duqgrup') }}</b></a>
        <a type="button" class="mr-2 ml-2 btn btn-{{ Request::route()->getName() === 'admin.bets.bichao.unidade' ? '' : 'outline-' }}primary mb-1" href="{{ route('admin.bets.bichao.unidade') }}#game"><b>{{ trans('admin.bichao.unidade') }}</b></a>
        <a type="button" class="mr-2 ml-2 btn btn-{{ Request::route()->getName() === 'admin.bets.bichao.milhar.invertida' ? '' : 'outline-' }}primary mb-1" href="{{ route('admin.bets.bichao.milhar.invertida') }}#game"><b>{{ trans('admin.bichao.milharinvertida') }}</b></a>
        <a type="button" class="mr-2 ml-2 btn btn-{{ Request::route()->getName() === 'admin.bets.bichao.centena.invertida' ? '' : 'outline-' }}primary mb-1" href="{{ route('admin.bets.bichao.centena.invertida') }}#game"><b>{{ trans('admin.bichao.centenainvertida') }}</b></a>
    </div>
</div>