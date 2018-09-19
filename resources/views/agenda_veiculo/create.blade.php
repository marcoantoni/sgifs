@extends('layout')

@section('content')
<h1 class="ls-title-intro ls-ico-week">Adicionando novo agendamento de veículo</h1>
<div class="col-md-4">
@if (session('error'))
  <div class="ls-alert-danger ls-dismissable" id="alert-error">
    <span data-ls-module="dismiss" class="ls-dismiss">&times;</span>
    {!! session('error') !!} 
  </div>
@endif
{!! Form::open([
    'route' => 'agendaveiculos.store',
    'class' => 'ls-form ls-form-horizontal row'
]) !!}
  <form action="" class="ls-form ls-form-horizontal row">
    <label class="ls-label col-md-4 col-xs-4">
      <b class="ls-label-text">Data</b>
      <input type="date" name="dia" placeholder="Dia que será usado" class="ls-field" value="{{ old('dia') }}" required>
    </label>
    <label class="ls-label col-md-4 col-xs-4">
      <b class="ls-label-text">Saída</b>
      <input type="time" name="inicio" placeholder="Início do deslocamento" class="ls-field" value="{{ old('inicio') }}" required>
    </label> 
    <label class="ls-label col-md-4 col-xs-4">
      <b class="ls-label-text">Retorno</b>
      <input type="time" name="fim" placeholder="Fim do deslocamento" class="ls-field" value="{{ old('fim') }}" required>
    </label>
    <label class="ls-label col-md-6 col-xs-12">
      <b class="ls-label-text">Solicitante</b>
      <input type="text" name="solicitante" list="dt_solicitante" autocomplete="off" placeholder="Quem solicitou" class="ls-field" data-ls-module="charCounter" maxlength="45" value="{{ old('solicitante') }}" required>
      <datalist id="dt_solicitante">
        @foreach ($solicitantes AS $s)
          <option value="{{ $s->solicitante }}">
        @endforeach
      </datalist>
    </label> 
    <label class="ls-label col-md-6 col-xs-12">
      <b class="ls-label-text">Motorista</b>
      <input type="text" name="motorista" list="dt_mototistas" autocomplete="off" placeholder="Quem vai dirigir" class="ls-field" data-ls-module="charCounter" maxlength="45" value="{{ old('motorista') }}" required>
      <datalist id="dt_mototistas">
        @foreach ($motoristas AS $m)
          <option value="{{ $m->motorista }}">
        @endforeach
      </datalist>
    </label> 
    <label class="ls-label col-md-col-md-12 col-xs-12">
      <b class="ls-label-text">Para onde vai</b>
      <input type="text" name="para_onde" list="dt_destinos" autocomplete="off" placeholder="Destino do deslocamento" class="ls-field" data-ls-module="charCounter" maxlength="45" value="{{ old('para_onde') }}" >
      <datalist id="dt_destinos">
        @foreach ($destinos AS $d)
          <option value="{{ $d->para_onde }}">
        @endforeach
      </datalist>
    </label> 
    <label class="ls-label col-md-12 col-xs-12">
      <b class="ls-label-text">Veículo a ser utilizado</b>
      <div class="ls-custom-select">
        <select class="ls-custom" name="id_veiculo">
          <option selected="selected">Selecione</option>
          @foreach ($veiculos as $veiculo)
            <option value="{{ $veiculo->id }}">{{ $veiculo->modelo }}</option>
          @endforeach
        </select>
      </div>
    </label>
    <label class="ls-label col-md-12 col-xs-12">
      <b class="ls-label-text">Observação</b>
      <textarea rows="4" name="observacao" data-ls-module="charCounter" maxlength="1000">{{ old('observacao') }}</textarea>
    </label>

    <div class="ls-actions-btn">
      <button class="ls-btn" type="submit">Salvar</button>
      <button class="ls-btn-danger">Cancelar</button>
    </div>
  </form>
</div>
@stop