@extends('layout')

@section('content')
<h1 class="ls-title-intro ls-ico-dashboard">Abastecimentos</h1>
@if (session('success'))
  <div class="ls-alert-success ls-dismissable" id="alert-sucess">
    <span data-ls-module="dismiss" class="ls-dismiss">&times;</span>
    {{ session('success') }} 
  </div>
@endif
@if (session('error'))
  <div class="ls-alert-danger ls-dismissable" id="alert-error">
    <span data-ls-module="dismiss" class="ls-dismiss">&times;</span>
    {!! session('error') !!} 
  </div>
@endif
@if (Auth::check())
  <a href="{{ route('abastecimento.create') }}" class="ls-btn-primary">Novo abastecimento</a>
@endif

<div class="ls-box-filter">
  <form action="javascript:pesquisar();" class="ls-form ls-form-inline">
    <label class="ls-label col-md-3 col-sm-5 col-xs-5">
      <b class="ls-label-text">Veículo a ser pesquisado</b>
      <div class="ls-custom-select ls-field-sm">
        <select id="id_veiculo" name="id_veiculo" class="ls-select">
            <option value="0">Selecione</option>
          @foreach ($veiculos as $veiculo)
            <option value="{{ $veiculo->id }}">{{ $veiculo->modelo }}</option>
          @endforeach
        </select>
      </div>
    </label>
    <div class="ls-actions-btns">
     <input type="submit" value="Buscar" class="ls-btn ls-btn-sm" title="Buscar"> 
    </div>
  </form>
</div>
<script type="text/javascript">
  function pesquisar(){
    var id_veiculo = $('#id_veiculo').val();
    var baseUrl = location.protocol+'//'+location.hostname+(location.port ? ':'+location.port: '');
    var redirectTo = baseUrl + '/abastecimento/' + id_veiculo;
    window.location.replace(redirectTo);
  }
</script>
@stop