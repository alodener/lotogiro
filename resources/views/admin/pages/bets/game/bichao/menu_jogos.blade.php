<div class="row">
    <div class="col">
    <p>{{ trans('admin.bichao.escolha') }}</p>
    </div>
</div>
<div class="row">
    <div class="col button-group overflow-auto gap-2">
        <a type="button" class="btn btn-{{ Request::route()->getName() === 'admin.bets.bichao.index' ? '' : 'outline-' }}primary mb-1" href="{{ route('admin.bets.bichao.index') }}"><b>{{ trans('admin.bichao.milhar') }}</b></a>
        <a type="button" class="btn btn-{{ Request::route()->getName() === 'admin.bets.bichao.centena' ? '' : 'outline-' }}primary mb-1" href="{{ route('admin.bets.bichao.centena') }}"><b>{{ trans('admin.bichao.centena') }}</b></a>
        <a type="button" class="btn btn-{{ Request::route()->getName() === 'admin.bets.bichao.dezena' ? '' : 'outline-' }}primary mb-1" href="{{ route('admin.bets.bichao.dezena') }}"><b>{{ trans('admin.bichao.dezena') }}</b></a>
        <a type="button" class="btn btn-{{ Request::route()->getName() === 'admin.bets.bichao.group' ? '' : 'outline-' }}primary mb-1" href="{{ route('admin.bets.bichao.group') }}"><b>{{ trans('admin.bichao.grupo') }}</b></a>
        <a type="button" class="btn btn-{{ Request::route()->getName() === 'admin.bets.bichao.milhar.centena' ? '' : 'outline-' }}primary mb-1" href="{{ route('admin.bets.bichao.milhar.centena') }}"><b>{{ trans('admin.bichao.milhcent') }}</b></a>
        <a type="button" class="btn btn-{{ Request::route()->getName() === 'admin.bets.bichao.terno.dezena' ? '' : 'outline-' }}primary mb-1" href="{{ route('admin.bets.bichao.terno.dezena') }}"><b>{{ trans('admin.bichao.terndez') }}</b></a>
        <a type="button" class="btn btn-{{ Request::route()->getName() === 'admin.bets.bichao.duque.dezena' ? '' : 'outline-' }}primary mb-1" href="{{ route('admin.bets.bichao.duque.dezena') }}"><b>{{ trans('admin.bichao.duqdez') }}</b></a>
        <a type="button" class="btn btn-{{ Request::route()->getName() === 'admin.bets.bichao.quina.grupo' ? '' : 'outline-' }}primary mb-1" href="{{ route('admin.bets.bichao.quina.grupo') }}"><b>{{ trans('admin.bichao.quinagrup') }}</b></a>
        <a type="button" class="btn btn-{{ Request::route()->getName() === 'admin.bets.bichao.quadra.grupo' ? '' : 'outline-' }}primary mb-1" href="{{ route('admin.bets.bichao.quadra.grupo') }}"><b>{{ trans('admin.bichao.quadragrup') }}</b></a>
        <a type="button" class="btn btn-{{ Request::route()->getName() === 'admin.bets.bichao.terno.grupo' ? '' : 'outline-' }}primary mb-1" href="{{ route('admin.bets.bichao.terno.grupo') }}"><b>{{ trans('admin.bichao.terngrup') }}</b></a>
        <a type="button" class="btn btn-{{ Request::route()->getName() === 'admin.bets.bichao.duque.grupo' ? '' : 'outline-' }}primary mb-1" href="{{ route('admin.bets.bichao.duque.grupo') }}"><b>{{ trans('admin.bichao.duqgrup') }}</b></a>
        <a type="button" class="btn btn-{{ Request::route()->getName() === 'admin.bets.bichao.unidade' ? '' : 'outline-' }}primary mb-1" href="{{ route('admin.bets.bichao.unidade') }}"><b>{{ trans('admin.bichao.unidade') }}</b></a>
        <a type="button" class="btn btn-{{ Request::route()->getName() === 'admin.bets.bichao.milhar.invertida' ? '' : 'outline-' }}primary mb-1" href="{{ route('admin.bets.bichao.milhar.invertida') }}"><b>{{ trans('admin.bichao.milharinvertida') }}</b></a>
        <a type="button" class="btn btn-{{ Request::route()->getName() === 'admin.bets.bichao.centena.invertida' ? '' : 'outline-' }}primary mb-1" href="{{ route('admin.bets.bichao.centena.invertida') }}"><b>{{ trans('admin.bichao.centenainvertida') }}</b></a>
    </div>
</div>