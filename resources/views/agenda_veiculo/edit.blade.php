@extends('layout')

@section('content')
<h1 class="ls-title-intro ls-ico-pencil">Editando agendamento de veículo</h1>
<div class="col-md-8">
  @if (session('error'))
    <div class="ls-alert-danger ls-dismissable" id="alert-error">
      <span data-ls-module="dismiss" class="ls-dismiss">&times;</span>
      {!! session('error') !!} 
    </div>
  @endif
  {!! Form::model($agendamento, [
      'method' => 'PATCH',
      'route' => ['agendaveiculos.update', $agendamento->id], 
      'class' => 'ls-form ls-form-horizontal row',
      'id' => 'id',
  ]) !!}
  <form action="" class="ls-form ls-form-horizontal row">
    <label class="ls-label col-md-3 col-xs-4">
      <b class="ls-label-text">Data</b>
      <input type="date" name="dia" placeholder="Dia que será usado" class="ls-field" value="{{$agendamento->dia }}" required>
    </label>
    <label class="ls-label col-md-3 col-xs-4">
      <b class="ls-label-text">Saída</b>
      <input type="time" name="inicio" placeholder="Início do deslocamento" class="ls-field" value="{{$agendamento->inicio }}" required>
    </label> 
    <label class="ls-label col-md-3 col-xs-4">
      <b class="ls-label-text">Retorno</b>
      <input type="time" name="fim" placeholder="Fim do deslocamento" class="ls-field" value="{{$agendamento->fim }}" required>
    </label>
    <label class="ls-label col-md-5 col-xs-12">
      <b class="ls-label-text">Solicitante</b>
      <input type="text" name="solicitante" placeholder="Quem vai dirigir" class="ls-field" data-ls-module="charCounter" maxlength="45" value="{{ $agendamento->solicitante }}" required>
    </label> 
    <label class="ls-label col-md-4 col-xs-12">
      <b class="ls-label-text">Motorista</b>
      <input type="text" name="motorista" placeholder="Quem vai dirigir" class="ls-field" data-ls-module="charCounter" maxlength="45" value="{{$agendamento->motorista }}" required>
    </label> 
    <label class="ls-label col-md-9 col-xs-12">
      <b class="ls-label-text">Para onde vai</b>
      <input type="text" name="para_onde" placeholder="Destino do deslocamento" data-ls-module="charCounter" maxlength="45" class="ls-field" value="{{$agendamento->para_onde }}">
    </label> 
    <label class="ls-label col-md-5 col-xs-12">
      <b class="ls-label-text">Veículo a ser utilizado</b>
      <div class="ls-custom-select">
        <select class="ls-custom" name="id_veiculo">
          <option selected="selected">Selecione</option>
          @foreach ($veiculos as $veiculo)
            @if ($agendamento->id_veiculo == $veiculo->id)
              <option value="{{ $veiculo->id }}" selected>{{ $veiculo->modelo }}</option>
            @else
              <option value="{{ $veiculo->id }}">{{ $veiculo->modelo }}</option>
            @endif
          @endforeach
        </select>
      </div>
    </label>
    <label class="ls-label col-md-9 col-xs-12">
      <b class="ls-label-text">Observação</b>
      <textarea rows="4" name="observacao" data-ls-module="charCounter" maxlength="1000">{{ $agendamento->observacao }}</textarea>
    </label>
    <label class="ls-label col-md-4 col-xs-12">
      <b class="ls-label-text">Excluir agendamento</b>
      <div class="ls-custom-select">
        <select class="ls-custom" name="excluido">
            <option value="0" selected>Não Excluído</option>
            <option value="1">Excluído</option>
        </select>
      </div>
    </label>
    <div class="ls-actions-btn">
      <button class="ls-btn" type="submit">Salvar</button>
      <button class="ls-btn-danger">Cancelar</button>
    </div>
  </form>
</div>
@stop