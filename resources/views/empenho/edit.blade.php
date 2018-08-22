@extends('layout')

@section('content')
<h1 class="ls-title-intro ls-ico-pencil">Editando empenho nº <b>{{ $empenho->numero }}</b> </h1>
<div class="col-md-6">
@if (session('error'))
  <div class="ls-alert-danger ls-dismissable" id="alert-error">
    <span data-ls-module="dismiss" class="ls-dismiss">&times;</span>
    {!! session('error') !!} 
  </div>
@endif
{!! Form::model($empenho, [
      'method' => 'PATCH',
      'route' => ['empenho.update', $empenho->id], 
      'class' => 'ls-form ls-form-horizontal row',
      'id' => 'id',
  ]) !!}
  <form action="" class="ls-form ls-form-horizontal row">
    <label class="ls-label col-md-3 col-xs-6">
      <b class="ls-label-text">Nº empenho</b>
      <input type="text" name="numero" placeholder="Nº do empenho" class="ls-field" data-ls-module="charCounter" maxlength="45" required value="{{ $empenho->numero }}">
    </label>
    <label class="ls-label col-md-3 col-xs-6">
      <b class="ls-label-text">Valor</b>
      <input type="text" name="valor" placeholder="centavos separados por '.'" class="ls-field" required value="{{ $empenho->valor }}">
    </label>  <label class="ls-label col-md-3 col-xs-6">
      <b class="ls-label-text">Data</b>
      <input type="date" name="data" placeholder="Data do empenho" class="ls-field" required value="{{ $empenho->data }}">
    </label>
    <label class="ls-label col-md-3 col-xs-6">
      <b class="ls-label-text">Orçamento</b>
      <div class="ls-custom-select">
        <select class="ls-custom" name="id_orcamento">
          @foreach ($orcamento as $o)
            @if ($o->ano == $empenho->id_orcamento)
              <option value="{{ $o->ano }}" selected>{{ $o->ano }}</option>
            @else
              <option value="{{ $o->ano }}">{{ $o->ano }}</option>
            @endif
          @endforeach
        </select>
      </div>
    </label>
    <label class="ls-label col-md-12 col-xs-12">
      <b class="ls-label-text">Empresa</b>
      <div class="ls-custom-select">
        <select class="ls-custom" name="id_empresa">
          @foreach ($empresas as $empresa)
            @if ($empresa->id == $empenho->id_empresa)
              <option value="{{ $empresa->id }}" selected="selected">{{ $empresa->nome_fantasia }} / {{ $empresa->cnpj }}</option>
            @else 
              <option value="{{ $empresa->id }}" >{{ $empresa->nome_fantasia }} / {{ $empresa->cnpj }}</option>
            @endif
          @endforeach
        </select>
      </div>
    </label>
    <label class="ls-label col-md-12 col-xs-12">
      <b class="ls-label-text">Natureza</b>
      <div class="ls-custom-select">
        <select class="ls-custom" name="id_natureza">
          <option selected="selected">Todos</option>
          @foreach ($natureza as $n)
            @if ($n->id == $empenho->id_natureza)
            <option value="{{ $n->id }}" selected>{{ $n->nome }}</option>
            @else
            <option value="{{ $n->id }}">{{ $n->nome }}</option>
            @endif
          @endforeach
        </select>
      </div>
    </label>
    
	  <label class="ls-label col-md-12 col-xs-12">
      <b class="ls-label-text">Anular empenho</b><p>Similar a exclusão: o valor não será mais somado ao total já gasto</p>
      <div class="ls-custom-select">
        <select class="ls-custom" name="cancelado">
        	<option value="0" selected>Não anulado</option>
        	<option value="1">Anulado</option>
        </select>
      </div>
    </label>
	   <label class="ls-label col-md-12 col-xs-12">
      <b class="ls-label-text">Arquivo do empenho</b>
      <input type="file" name="nome" placeholder="Arquivo do empenho" class="ls-field">
    </label>
    <div class="ls-actions-btn">
      <button class="ls-btn" type="submit">Salvar</button>
      <button class="ls-btn-danger">Cancelar</button>
    </div>
  </form>
</div>
<div class="col-md-6">

</div>
@stop