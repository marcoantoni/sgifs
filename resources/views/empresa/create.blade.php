@extends('layout')

@section('content')
<h1 class="ls-title-intro ls-ico-users">Adicionando nova empresa</h1>
<div class="col-md-6">
  @if (session('error'))
    <div class="ls-alert-danger ls-dismissable" id="alert-error">
      <span data-ls-module="dismiss" class="ls-dismiss">&times;</span>
      {!! session('error') !!} 
    </div>
  @endif
  {!! Form::open([
      'route' => 'empresa.store',
      'class' => 'ls-form ls-form-horizontal row'
  ]) !!}
    <label class="ls-label col-md-6 col-xs-8">
      <b class="ls-label-text">Nome fantasia</b>
      <input type="text" name="nome_fantasia" placeholder="Nome fantasia" class="ls-field" data-ls-module="charCounter" maxlength="100" required>
    </label>
    <label class="ls-label col-md-3 col-xs-4">
      <b class="ls-label-text">CNPJ</b>
      <input type="text" name="cnpj" placeholder="CNPJ" class="ls-field" data-ls-module="charCounter" maxlength="45" required>
    </label>  
    <label class="ls-label col-md-3 col-xs-6">
      <b class="ls-label-text">Telefone</b>
      <input type="tel" name="telefone" placeholder="Telefone para contato" class="ls-field" data-ls-module="charCounter" maxlength="45" >
    </label>  
    <label class="ls-label col-md-5 col-xs-6">
      <b class="ls-label-text">Email</b>
      <input type="email" name="email" placeholder="Email para contato" class="ls-field" data-ls-module="charCounter" maxlength="45" >
    </label>  
    <label class="ls-label col-md-7 col-xs-12">
      <b class="ls-label-text">Endereço</b>
      <input type="text" name="endereco" placeholder="Endereço para correspondência" class="ls-field" data-ls-module="charCounter" maxlength="45" >
    </label>
    <label class="ls-label col-md-12 col-xs-12">
      <b class="ls-label-text">Observação</b>
      <textarea rows="4" name="observacao" data-ls-module="charCounter" maxlength="1000"></textarea>
    </label>
    <div class="ls-actions-btn">
      <button class="ls-btn" type="submit">Salvar</button>
      <button class="ls-btn-danger">Cancelar</button>
    </div>
  </form>
</div>
@stop