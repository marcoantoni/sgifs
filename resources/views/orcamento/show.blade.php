@extends('layout')

@section('content')
<h1 class="ls-title-intro ls-ico-stats">Resumo da execução orcamentaria</h1>

<div class="ls-box ls-board-box">
  <div id="sending-stats" class="row">
    <div class="col-sm-6 col-md-3">
      <div class="ls-box ls-tooltip-top" aria-label="Esse valor é previsto no PAT e não quer dizer que será o valor disponível">
        <div class="ls-box-head">
          <h6 class="ls-title-4">Valor previsto</h6>
        </div>
        <div class="ls-box-body">
          <strong>{{ number_format($orcamento[0]->valor_previsto, 2, ',', '.')  }} </strong>
          <small>reais</small>
        </div>
        @if (Auth::check())
          <div class="ls-box-footer">
            <a href="/orcamento/{{ $orcamento[0]->ano }}/edit/" aria-label="Valor previsto para este ano" class="ls-btn ls-btn-sm" title="Alterar orçamento deste ano">Editar</a>
          </div>
        @endif
      </div>
    </div>
    <div class="col-sm-6 col-md-3">
      <div class="ls-box">
        <div class="ls-box-head">
          <h6 class="ls-title-4">Valor liberado</h6>
        </div>
        <div class="ls-box-body">
          <strong>{{ number_format($recursos_liberados, 2, ',', '.') }}</strong>
          <small>reais</small>
        </div>
        <div class="ls-box-footer">
          <a href="/rlib" aria-label="Ver histórico de liberação" class="ls-btn ls-btn-sm" title="Ver histórico de liberação">Histórico de liberação</a>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-md-3">
      <div class="ls-box">
        <div class="ls-box-head">
          <h6 class="ls-title-4">Valor já gasto</h6>
        </div>
        <div class="ls-box-body">
          <strong>{{ number_format($total_gasto, 2, ',', '.') }}</strong>
          <small>reais</small>
        </div>
        <div class="ls-box-footer">
          <a href="/empenho/graficos/" aria-label="Gráficos referente aos gastos do ano" class="ls-btn ls-btn-sm" title="Gráficos referente aos gastos do ano">Gráficos</a>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-md-3">
      <div class="ls-box">
        <div class="ls-box-head">
          <h6 class="ls-title-4">Valor disponível</h6>
        </div>
        <div class="ls-box-body">
          <strong>{{ number_format(($recursos_liberados - $total_gasto), 2, ',', '.') }}</strong>
          <small>reais</small>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  function redirectToOrcamento(){
  var e = document.getElementById("anos_anteriores");
  var ano = e.options[e.selectedIndex].text

  var baseUrl = location.protocol+'//'+location.hostname+(location.port ? ':'+location.port: '');
  var redirectTo = baseUrl + '/orcamento/' + ano;
  window.location.replace(redirectTo);
}
</script>

<div class="ls-box-filter">
  <form action="javascript:redirectToOrcamento();" class="ls-form ls-form-inline ls-float-left">
    <label class="ls-label col-md-6 col-sm-8">
      <b class="ls-label-text">Anos anteriores</b>
      <div class="ls-custom-select ls-field-sm">
        <select id="anos_anteriores" name="anos_anteriores" class="ls-select">
          @foreach ($orc_anual as $o)
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
  </form>-->
  <style type="text/css">
    .cancelado{
           color: red;
      }
  </style>
</div>

<table class="ls-table ls-sm-space ls-table-layout-auto">
  <thead>
    <tr>
      <th class="ls-data-descending"><a href="#">Nº empenho</a></th>
      <th class="ls-data-descending"><a href="#">Empresa</a></th>
      <th class="ls-data-descending hidden-xs"><a href="#">CNPJ</a></th>
      <th class="ls-data-descending hidden-xs"><a href="#">Natureza</a></th>
      <th class="ls-data-descending"><a href="#">Valor</a></th>
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
<!-- paginação 
<div class="ls-pagination-filter">
  <ul class="ls-pagination">
    <li><a href="#">« Anterior</a></li>
    <li class="ls-active"><a href="#">1</a></li>
    <li><a href="#">2</a></li>
    <li><a href="#">3</a></li>
    <li><a href="#" class="hidden-xs">4</a></li>
    <li><a href="#" class="hidden-xs">5</a></li>
    <li><a href="#">Próximo »</a></li>
  </ul>
   paginação -->

<!-- filtro quantidade
  <div class="ls-filter-view">
    <label for="">
      Exibir
      <div class="ls-custom-select ls-field-sm">
        <select name="" id="">
          <option value="10">10</option>
          <option value="30">30</option>
          <option value="50">50</option>
          <option value="100">100</option>
        </select>
      </div>
      ítens por página
    </label>
  </div>
</div>
 filtro quantidade -->

    </div>
<script src="{{ URL::asset('js/jquery.tablesorter.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
  $(document).ready(function() { 
    $("table").tablesorter( {sortList: [[0,0], [1,0]]} ); 
  }); 
</script>
@stop