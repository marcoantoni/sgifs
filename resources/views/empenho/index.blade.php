@extends('layout')

@section('content')
<h1 class="ls-title-intro ls-ico-text">{{ $pgtitulo }}</h1>
  @if (session('sucess'))
    <div class="ls-alert-success ls-dismissable" id="alert-sucess">
      <span data-ls-module="dismiss" class="ls-dismiss">&times;</span>
      {{ session('sucess') }} 
    </div>
  @endif
@if (Auth::check())
  <a href="{{ route('empenho.create') }}" class="ls-btn-primary">Adicionar novo empenho</a>
@endif
<script type="text/javascript">
  function redirectToEmpenhos(){
  var e = document.getElementById("anos_anteriores");
  var ano = e.options[e.selectedIndex].text

  var baseUrl = location.protocol+'//'+location.hostname+(location.port ? ':'+location.port: '');
  var redirectTo = baseUrl + '/empenho/' + ano;
  window.location.replace(redirectTo);
}
</script>
<div class="ls-box-filter">
  <form action="javascript:redirectToEmpenhos();" class="ls-form ls-form-inline ls-float-left">
    <label class="ls-label col-md-6 col-sm-8">
      <b class="ls-label-text">Anos anteriores</b>
      <div class="ls-custom-select ls-field-sm">
        <select id="anos_anteriores" name="anos_anteriores" class="ls-select">
          @foreach ($orcamento as $o)
            <option value="{{ $o->ano }}">{{ $o->ano }}</option>
          @endforeach
        </select>
      </div>
    </label>
    <div class="ls-actions-btn">
     <input type="submit" value="Buscar" class="ls-btn ls-btn-sm" title="Buscar"> 
    </div>
  </form>


  <!--<form  action="" class="ls-form ls-form-inline ls-float-right">
    <label class="ls-label" role="search">
      <b class="ls-label-text ls-hidden-accessible">Nome do cliente</b>
      <input type="text" id="q" name="q" aria-label="Informação a ser filtrada" placeholder="Informação a ser filtrada" required="" class="ls-field-sm">
    </label>
    c
  </form>-->
   <style type="text/css">
    .cancelado{
           color: red;
      }
  </style>
    <a href="/empenho/graficos/" class="ls-btn-primary ls-float-right"><span class="ls-ico-stats"></span> Gráficos</a>
</div>

  <table class="ls-table ls-sm-space ls-table-layout-auto">
    <thead>
      <tr>
        <th>Nº do empenho</th>
        <th>Empresa</th>
        <th class="hidden-xs">CNPJ</th>
        <th class="hidden-xs">Natureza</th>
        <th>Valor</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($empenhos as $empenho)
      <tr @if ($empenho->cancelado == 1) class="cancelado"  @endif>
        <td>{{ $empenho->numero}} @if ($empenho->cancelado == 1) <span class="ls-tag-danger">Cancelado</span></h5>  @endif </td>
        <td>{{ $empenho->nome_fantasia }}</td>
        <td class="hidden-xs">{{ $empenho->cnpj }}</td>
        <td class="hidden-xs">{{ $empenho->natureza }}</td>
        <td>{{ number_format($empenho->valor, 2, ',', '.') }}</td>
        <td class="ls-group-btn">
          <a href="{{ url("detalheempenho/{$empenho->id}") }}" class="ls-btn ls-btn-sm " title="Detalhes dos itens do empenho nº {{ $empenho->numero}}">Detalhes</a>
          @if (Auth::check())
            <a href="{{ URL::to('empenho/' . $empenho->id . '/edit') }}" class="ls-btn ls-btn-sm" title="Editar empenho">Editar</a>
          @endif
          @if ($empenho->arquivo == NULL)
           <a href="#" class="ls-btn ls-btn-sm ls-disabled " title="Não foi anexado o arquivo referente a este empenho">Download</a>
          @else
           <a href="{{ url("storage/empenhos/$empenho->arquivo") }}" class="ls-btn ls-btn-sm " title="Download do empenho nº {{ $empenho->numero }}" >Download</a>
          @endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@stop