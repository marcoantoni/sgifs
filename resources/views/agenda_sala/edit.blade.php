@extends('layout')

@section('content')
<h1 class="ls-title-intro ls-ico-pencil">{{ $pgtitulo }}</h1>
<div class="col-md-6">
  @if (session('error'))
    <div class="ls-alert-danger ls-dismissable" id="alert-error">
      <span data-ls-module="dismiss" class="ls-dismiss">&times;</span>
      {!! session('error') !!} 
    </div>
  @endif
  {!! Form::model($agenda, [
      'method' => 'PATCH',
      'route' => ['agenda.update', $agenda->id], 
      'class' => 'ls-form ls-form-horizontal row',
      'id' => 'id',
  ]) !!}
    <label class="ls-label col-md-4 col-xs-12">
      <b class="ls-label-text">Data</b>
      <input type="date" name="dia" placeholder="Dia que será usado" class="ls-field" value="{{ $agenda->dia }}" required>
    </label>
    <label class="ls-label col-md-4 col-xs-12">
      <b class="ls-label-text">Hora de inicio</b>
      <input type="time" name="inicio" placeholder="Início do deslocamento" class="ls-field" value="{{ $agenda->inicio }}" required>
    </label> 
    <label class="ls-label col-md-4 col-xs-12">
      <b class="ls-label-text">Hora de fim</b>
      <input type="time" name="fim" placeholder="Fim do deslocamento" class="ls-field" value="{{ $agenda->fim }}" required>
    </label>
    <label class="ls-label col-md-12 col-xs-12">
      <b class="ls-label-text">Solicitante</b>
      <input type="text" name="solicitante" placeholder="Quem solicitou" class="ls-field" data-ls-module="charCounter" maxlength="45" value="{{ $agenda->solicitante }}" required>
    </label>  
    <label class="ls-label col-md-12">
      <b class="ls-label-text">Sala ou laboratório</b>
      <div class="ls-custom-select">
        <select class="ls-custom" name="id_sala">
          <option selected="selected">Selecione</option>
          @foreach ($salas as $sala)
            @if ($sala->id == $agenda->id_sala)
              <option value="{{ $sala->id }}" selected>{{ $sala->nome }}</option>
            @else
              <option value="{{ $sala->id }}">{{ $sala->nome }}</option>
            @endif
          @endforeach
        </select>
      </div>
    </label>
    <label class="ls-label col-md-12">
      <b class="ls-label-text">Observação</b>
      <textarea rows="4" name="observacao" data-ls-module="charCounter" maxlength="1000">{{ $agenda->observacao }}</textarea>
    </label>

    <div class="ls-actions-btn">
      <button class="ls-btn" type="submit">Salvar</button>
      <button class="ls-btn-danger">Cancelar</button>
    </div>
  </form>
</div>
@stop