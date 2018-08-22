@extends('layout')

@section('content')
<h1 class="ls-title-intro ls-ico-pencil">{{ $pgtitulo }}</h1>
<div class="col-md-6">

{!! Form::model($orcamento, [
      'method' => 'PATCH',
      'route' => ['orcamento.update', $orcamento->ano], 
      'class' => 'ls-form ls-form-horizontal row'
  ]) !!}
    <label class="ls-label col-md-6 col-xs-12">
      <b class="ls-label-text">Valor previsto no orçamento</b>
      <input type="text" name="valor_previsto" placeholder="Valor previsto" class="ls-field" value="{{ $orcamento->valor_previsto }}" required>
    </label>
  
    <div class="ls-actions-btn">
      <button class="ls-btn" type="submit">Salvar</button>
      <button class="ls-btn-danger">Cancelar</button>
    </div>
  </form>
</div>
@stop