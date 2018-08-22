@extends('layout')

@section('content')
<h1 class="ls-title-intro ls-ico-text">Adicionando novo empenho</h1>
<div class="col-md-6">
@if (session('error'))
  <div class="ls-alert-danger ls-dismissable" id="alert-error">
    <span data-ls-module="dismiss" class="ls-dismiss">&times;</span>
    {!! session('error') !!} 
  </div>
@endif
{!! Form::open([
    'route' => 'empenho.store',
    'class' => 'ls-form ls-form-horizontal row',
    'enctype' => 'multipart/form-data'
]) !!}
    <label class="ls-label col-md-3 col-xs-6">
      <b class="ls-label-text">Nº empenho</b>
      <input type="text" name="numero" placeholder="Nº do empenho" class="ls-field" value="{{ old('numero') }}" required>
    </label>
    <label class="ls-label col-md-3 col-xs-6">
      <b class="ls-label-text">Valor</b>
      <input type="text" name="valor" placeholder="centavos separados por '.'" class="ls-field" value="{{ old('valor') }}" required>
    </label>  
    <label class="ls-label col-md-3 col-xs-6">
      <b class="ls-label-text">Data</b>
      <input type="date" name="data" placeholder="Data do empenho" class="ls-field" value="{{ old('data') }}" required>
    </label>
    <label class="ls-label col-md-3 col-xs-6">
      <b class="ls-label-text">Orçamento</b>
      <div class="ls-custom-select">
        <select class="ls-custom" name="id_orcamento">
          @foreach ($orcamento as $o)
            <option value="{{ $o->ano }}">{{ $o->ano }}</option>
          @endforeach
        </select>
      </div>
    </label>
    <label class="ls-label col-md-12 col-xs-12">
      <b class="ls-label-text">Empresa</b>
      <div class="ls-custom-select">
        <select class="ls-custom" name="id_empresa">
          <option selected="selected">Selecione</option>
          @foreach ($empresas as $empresa)
            <option value="{{ $empresa->id }}">{{ $empresa->nome_fantasia }} / {{ $empresa->cnpj }}</option>
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
            <option value="{{ $n->id }}">{{ $n->nome }}</option>
          @endforeach
        </select>
      </div>
    </label>
    <label class="ls-label col-md-12 col-xs-12">
      <b class="ls-label-text">Arquivo do empenho</b>
      <input type="file" name="arquivo" placeholder="Arquivo do empenho" class="ls-field">
    </label>

    <div class="ls-actions-btn">
      <button class="ls-btn" type="submit">Salvar</button>
      <button class="ls-btn-danger">Cancelar</button>
    </div>
  </form>
</div>
@stop