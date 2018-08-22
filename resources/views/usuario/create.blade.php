@extends('layout')

@section('content')
<h1 class="ls-title-intro ls-ico-user">{{ $pgtitulo }}</h1>
<div class="col-md-4">
	@if (session('error'))
	  <div class="ls-alert-danger ls-dismissable" id="alert-error">
	    <span data-ls-module="dismiss" class="ls-dismiss">&times;</span>
	    {!! session('error') !!} 
	  </div>
	@endif

	{!! Form::open([
	    'route' => 'usuario.store',
	    'class' => 'ls-form ls-form-horizontal row',
	]) !!}
    <label class="ls-label col-md-12 col-xs-12">
      <b class="ls-label-text">Nome</b>
      <input type="text" name="name" class="ls-field" value="{{ old('name') }}" required autofocus>
      @if ($errors->has('name'))
          <span class="help-block">
              <strong>{{ $errors->first('name') }}</strong>
          </span>
      @endif
    </label>
    <label class="ls-label col-md-12 col-xs-12">
      <b class="ls-label-text">Email</b>
      <input type="email" name="email" class="ls-field"  value="{{ old('email') }}" >
    </label>
    <label class="ls-label col-md-12 col-xs-12">
      <b class="ls-label-text">Telefone</b>
      <input type="tel" name="telefone" class="ls-field"  value="{{ old('telefone') }}" >
    </label> 
    <label class="ls-label col-md-12 col-xs-12">
      <b class="ls-label-text">Senha</b>
      <input type="password" name="password" class="ls-field"  placeholder="">
      @if ($errors->has('password'))
          <span class="help-block">
              <strong>{{ $errors->first('password') }}</strong>
          </span>
      @endif
    </label>
    <label class="ls-label col-md-12 col-xs-12">
      <b class="ls-label-text">Confirmação da senha</b>
      <input type="password" name="password_confirmation" class="ls-field" placeholder="">
    </label>

    <label class="ls-label col-md-12">
      <b class="ls-label-text">Setor que está vinculado</b>
      <div class="ls-custom-select">
        <select class="ls-custom" name="id_setor">
          @foreach ($setores AS $setor)
            <option value="{{ $setor->id }}">{{ $setor->nome }}</option>
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