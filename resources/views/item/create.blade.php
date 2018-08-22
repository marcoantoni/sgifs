@extends('layout')

@section('content')
<h1 class="ls-title-intro ls-ico-plus">{{ $pgtitulo }}</h1>
<div class="col-md-6">
  @if (session('error'))
    <div class="ls-alert-danger ls-dismissable" id="alert-error">
      <span data-ls-module="dismiss" class="ls-dismiss">&times;</span>
      {!! session('error') !!} 
    </div>
  @endif
  {!! Form::open([
      'route' => 'item.store',
      'class' => 'ls-form ls-form-horizontal row'
  ]) !!}
    <label class="ls-label col-md-12 col-xs-12">
      <b class="ls-label-text">Item</b>
      <input type="text" name="nome" placeholder="Nome do item" class="ls-field" data-ls-module="charCounter" maxlength="45" required>
    </label>
    
    <label class="ls-label col-md-12 col-xs-12">
      <b class="ls-label-text">Descrição do item</b>
      <textarea rows="4" data-ls-module="charCounter" maxlength="10000" name="descricao"></textarea>
    </label>
    <div class="ls-actions-btn">
      <button class="ls-btn" type="submit">Salvar</button>
      <button class="ls-btn-danger">Cancelar</button>
    </div>
  </form>
</div>
@stop