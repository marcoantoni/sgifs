@extends('layout')

@section('content')
<h1 class="ls-title-intro ls-ico-week">{{ $pgtitulo }}</h1>
<div class="col-md-6">
  @if (session('error'))
    <div class="ls-alert-danger ls-dismissable" id="alert-error">
      <span data-ls-module="dismiss" class="ls-dismiss">&times;</span>
      {!! session('error') !!} 
    </div>
  @endif
  {!! Form::open([
      'route' => 'eventos.store',
      'class' => 'ls-form ls-form-horizontal row'
  ]) !!}
    <label class="ls-label col-md-7 col-xs-12">
      <b class="ls-label-text">Nome do evento</b>
      <input type="text" name="nome_evento" placeholder="Nome do evento" class="ls-field" data-ls-module="charCounter" maxlength="100" value="{{ old('nome_evento') }}" required>
    </label>
    <label class="ls-label col-md-5 col-xs-12">
      <b class="ls-label-text">Responsável</b>
      <input type="text" name="responsavel" placeholder="Responsável pela organização" class="ls-field" data-ls-module="charCounter" maxlength="100" value="{{ old('responsavel') }}" required>
    </label>  
    <label class="ls-label col-md-4 col-xs-12">
      <b class="ls-label-text">Data inicio</b>
      <input type="date" name="data_inicio" placeholder="" class="ls-field" value="{{ old('data_inicio') }}" required>
    </label>
    <label class="ls-label col-md-4 col-xs-12">
      <b class="ls-label-text">Data fim</b>
      <input type="date" name="data_fim" placeholder="" class="ls-field" value="{{ old('data_fim') }}" required>
    </label> 
    <label class="ls-label col-md-4 col-xs-12">
      <b class="ls-label-text">Hora de ínicio</b>
      <input type="time" name="hora_inicio" placeholder="" class="ls-field" value="{{ old('hora_inicio') }}" >
    </label>
    <label class="ls-label col-md-6 col-xs-6">
      <b class="ls-label-text">Espaço a ser utizado</b>
      <div class="ls-custom-select">
        <select class="ls-custom" name="id_sala">
          <option selected="selected">Selecione</option>
          @foreach ($salas as $sala)
            <option value="{{ $sala->id }}">{{ $sala->nome }}</option>
          @endforeach
        </select>
      </div>
    </label>
    <label class="ls-label col-md-6 col-xs-12">
      <b class="ls-label-text">Público alvo</b>
      <input type="text" name="alvo" placeholder="Público alvo do evento" class="ls-field" data-ls-module="charCounter" maxlength="100" value="{{ old('alvo') }}">
    </label> 
    <label class="ls-label col-md-12 col-xs-12">
      <b class="ls-label-text">Observação</b>
      <input type="text" name="observacao" placeholder="Observação" class="ls-field" data-ls-module="charCounter" maxlength="1000" value="{{ old('observacao') }}">
    </label>
    <label class="ls-label col-md-8 col-xs-12">
      <b class="ls-label-text">Link</b>
      <input type="url" name="link" placeholder="Link para inscrição do evento" class="ls-field" data-ls-module="charCounter" maxlength="100" value="{{ old('link') }}" >
    </label>
    <label class="ls-label col-md-4 col-xs-12">
      <b class="ls-label-text">Nome do link</b>
      <input type="text" name="nomelink" placeholder="Aparecerá ao lado do nome do evento" class="ls-field" data-ls-module="charCounter" maxlength="45" value="{{ old('nomelink') }}" >
    </label>
    <!--<label class="ls-label col-md-12">
      <b class="ls-label-text">Observação</b>
      <textarea rows="4" name="observacao" data-ls-module="charCounter" maxlength="1000">{{ old('observacao') }}</textarea>
    </label>-->

    <div class="ls-actions-btn">
      <button class="ls-btn" type="submit">Salvar</button>
      <button class="ls-btn-danger">Cancelar</button>
    </div>
  </form>
</div>
@stop