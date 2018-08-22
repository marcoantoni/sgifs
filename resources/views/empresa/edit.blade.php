@extends('layout')

@section('content')
<h1 class="ls-title-intro ls-ico-pencil">Editando empresa <b>{{ $emp->nome_fantasia }}</b></h1>
<div class="col-md-6">

{!! Form::model($emp, [
      'method' => 'PATCH',
      'route' => ['empresa.update', $emp->id], 
      'class' => 'ls-form ls-form-horizontal row',
      'id' => 'id',
  ]) !!}
    <label class="ls-label col-md-6 col-xs-7">
      <b class="ls-label-text">Nome fantasia</b>
      <input type="text" name="nome_fantasia" placeholder="Nome fantasia" class="ls-field" data-ls-module="charCounter" maxlength="100"  required value="{{ $emp->nome_fantasia}}">
    </label>
    <label class="ls-label col-md-3 col-xs-5">
      <b class="ls-label-text">CNPJ</b>
      <input type="text" name="cnpj" placeholder="CNPJ" class="ls-field" data-ls-module="charCounter" maxlength="45" required value="{{ $emp->cnpj}}">
    </label>  
    <label class="ls-label col-md-3 col-xs-6">
      <b class="ls-label-text">Telefone</b>
      <input type="tel" name="telefone" placeholder="Telefone para contato" class="ls-field" data-ls-module="charCounter" maxlength="45" value="{{ $emp->telefone}}">
    </label>  
    <label class="ls-label col-md-5 col-xs-6">
      <b class="ls-label-text">Email</b>
      <input type="email" name="email" placeholder="Email para contato" class="ls-field" data-ls-module="charCounter" maxlength="45" value="{{ $emp->email}}">
    </label>  
    <label class="ls-label col-md-7 col-xs-12">
      <b class="ls-label-text">Endereço</b>
      <input type="text" name="endereco" placeholder="Endereço para correspondência" class="ls-field" data-ls-module="charCounter" maxlength="45" value="{{ $emp->endereco}}">
    </label>
    <label class="ls-label col-md-12 col-xs-12">
      <b class="ls-label-text">Observação</b>
      <textarea rows="4" name="observacao" data-ls-module="charCounter" maxlength="1000">{{ $emp->observacao}}</textarea>
    </label>
    <div class="ls-actions-btn">
      <button class="ls-btn" type="submit">Salvar</button>
      <button class="ls-btn-danger">Cancelar</button>
    </div>
  </form>
</div>
@stop