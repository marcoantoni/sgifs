@extends('layout')

@section('content')
<h1 class="ls-title-intro ls-ico-users">{{ $pgtitulo }}</h1>
<div class="col-md-6">
  @if (session('sucess'))
    <div class="ls-alert-success ls-dismissable" id="alert-sucess">
      <span data-ls-module="dismiss" class="ls-dismiss">&times;</span>
      {{ session('sucess') }} 
    </div>
  @endif
  @if (session('error'))
    <div class="ls-alert-danger ls-dismissable" id="alert-error">
      <span data-ls-module="dismiss" class="ls-dismiss">&times;</span>
      {{ session('error') }} 
    </div>
  @endif
{!! Form::open([
    'route' => 'assunto.store',
    'class' => 'ls-form ls-form-horizontal row'
]) !!}
  <form action="" class="ls-form ls-form-horizontal row">
    <label class="ls-label col-md-12 col-xs-12">
      <b class="ls-label-text">Assunto</b>
      <input type="text" name="assunto" placeholder="Assunto" class="ls-field" data-ls-module="charCounter" maxlength="45" required>
    </label>
    <label class="ls-label col-md-12">
      <b class="ls-label-text">Esse assunto refere-se a qual setor?</b>
      <div class="ls-custom-select">
        <select class="ls-custom" name="id_setor">
          @foreach ($setores as $setor)
            @if ($setor->id == Auth::User()->id_setor)
              <option value="{{ $setor->id }}" selected>{{ $setor->nome }}</option>
            @else
              <option value="{{ $setor->id }}" >{{ $setor->nome }}</option>
            @endif
          @endforeach
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