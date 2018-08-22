@extends('layout')

@section('content')
<h1 class="ls-title-intro ls-ico-pencil">Editando natureza "{{ $natureza->nome}}"</h1>
<div class="col-md-6">

{!! Form::model($natureza, [
      'method' => 'PATCH',
      'route' => ['natureza.update', $natureza->id], 
      'class' => 'ls-form ls-form-horizontal row',
      'id' => 'id',
  ]) !!}
    <label class="ls-label col-md-6 col-xs-12">
      <b class="ls-label-text">Natureza</b>
      <input type="text" name="nome" placeholder="Natureza de gasto" class="ls-field" data-ls-module="charCounter" maxlength="45" value="{{ $natureza->nome}}" required>
    </label>
  
    <div class="ls-actions-btn">
      <button class="ls-btn" type="submit">Salvar</button>
      <button class="ls-btn-danger">Cancelar</button>
    </div>
  </form>
</div>
@stop