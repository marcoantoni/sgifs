@extends('layout')

@section('content')
<h1 class="ls-title-intro ls-ico-pencil">Editando item <b>{{ $item->nome }}</b></h1>
<div class="col-md-6">

{!! Form::model($item, [
      'method' => 'PATCH',
      'route' => ['item.update', $item->id], 
      'class' => 'ls-form ls-form-horizontal row',
      'id' => 'id',
  ]) !!}
    <label class="ls-label col-md-12 col-xs-12">
      <b class="ls-label-text">Item</b>
      <input type="text" name="nome" placeholder="Nome do item" class="ls-field" data-ls-module="charCounter" maxlength="45" required value="{{ $item->nome}} ">
    </label>
    
    <label class="ls-label col-md-12 col-xs-12">
      <b class="ls-label-text">Descrição do item</b>
      <textarea rows="4" data-ls-module="charCounter" maxlength="10000" name="descricao">{{ $item->descricao }}</textarea>
    </label>
    <div class="ls-actions-btn">
      <button class="ls-btn" type="submit">Salvar</button>
      <button class="ls-btn-danger">Cancelar</button>
    </div>
  </form>
</div>
@stop