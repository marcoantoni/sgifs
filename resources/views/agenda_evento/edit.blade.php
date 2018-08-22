@extends('layout')

@section('content')
<h1 class="ls-title-intro ls-ico-pencil">{{ $pgtitulo }}</h1>
<div class="col-md-8">
  @if (session('error'))
    <div class="ls-alert-danger ls-dismissable" id="alert-error">
      <span data-ls-module="dismiss" class="ls-dismiss">&times;</span>
      {!! session('error') !!} 
    </div>
  @endif
  {!! Form::model($evento, [
      'method' => 'PATCH',
      'route' => ['eventos.update', $evento->id], 
      'class' => 'ls-form ls-form-horizontal row',
      'id' => 'id',
  ]) !!}
    <label class="ls-label col-md-7 col-xs-12">
      <b class="ls-label-text">Nome do evento</b>
      <input type="text" name="nome_evento" placeholder="Nome do evento" class="ls-field" data-ls-module="charCounter" maxlength="100" value="{{ $evento->nome_evento }}" required>
    </label>
    <label class="ls-label col-md-5 col-xs-12">
      <b class="ls-label-text">Responsável</b>
      <input type="text" name="responsavel" placeholder="Responsável pela organização" class="ls-field" data-ls-module="charCounter" maxlength="100" value="{{ $evento->responsavel }}" required>
    </label>  
    <label class="ls-label col-md-4 col-xs-12">
      <b class="ls-label-text">Data inicio</b>
      <input type="date" name="data_inicio" placeholder="" class="ls-field" value="{{ $evento->data_inicio }}" required>
    </label>
    <label class="ls-label col-md-4 col-xs-12">
      <b class="ls-label-text">Data fim</b>
      <input type="date" name="data_fim" placeholder="" class="ls-field" value="{{ $evento->data_fim }}" required>
    </label> 
    <label class="ls-label col-md-4 col-xs-12">
      <b class="ls-label-text">Hora de ínicio</b>
      <input type="time" name="hora_inicio" placeholder="" class="ls-field" value="{{ $evento->hora_inicio }}" required>
    </label>
    <label class="ls-label col-md-6">
      <b class="ls-label-text">Espaço a ser utilizado</b>
      <div class="ls-custom-select">
        <select class="ls-custom" name="id_sala">
          <option selected="selected">Selecione</option>
          @foreach ($salas as $sala)
            @if ($sala->id == $evento->id_sala)
              <option value="{{ $sala->id }}" selected>{{ $sala->nome }}</option>
            @else
              <option value="{{ $sala->id }}">{{ $sala->nome }}</option>
            @endif
          @endforeach
        </select>
      </div>
    </label>
    <label class="ls-label col-md-6 col-xs-12">
      <b class="ls-label-text">Público alvo</b>
      <input type="text" name="alvo" placeholder="Público alvo do evento" class="ls-field" data-ls-module="charCounter" maxlength="100" value="{{ $evento->alvo }}" required>
    </label>  
    <div class="ls-actions-btn">
      <button class="ls-btn" type="submit">Salvar</button>
      <button class="ls-btn-danger">Cancelar</button>
    </div>
  </form>
</div>
@stop