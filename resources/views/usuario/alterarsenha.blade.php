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
  {!! Form::model($usuario, [
      'method' => 'PATCH',
      'class' => 'ls-form ls-form-horizontal row',
      'id' => 'id',
  ]) !!}
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
    <div class="ls-actions-btn">
      <button class="ls-btn" type="submit">Salvar</button>
      <button class="ls-btn-danger">Cancelar</button>
    </div>
  </form>
</div>
@stop