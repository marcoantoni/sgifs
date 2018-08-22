@extends('layout')

@section('content')
<h1 class="ls-title-intro ls-ico-numbered-list">{{ $pgtitulo }}</h1>
@if (session('success'))
  <div class="ls-alert-success ls-dismissable" id="alert-sucess">
    <span data-ls-module="dismiss" class="ls-dismiss">&times;</span>
    {{ session('success') }} 
  </div>
@endif
@if (session('error'))
  <div class="ls-alert-danger ls-dismissable" id="alert-error">
    <span data-ls-module="dismiss" class="ls-dismiss">&times;</span>
    {!! session('error') !!} 
  </div>
@endif
<a href="{{ route('item.create') }}" class="ls-btn-primary">Adicionar novo item a esse empenho</a>
<table class="ls-table ls-sm-space">
  <thead>
    <tr>
      <th>Nome</th>
      <th>Quantidade</th>
      <th>Entregue</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    @foreach ($itens as $item)
    <tr>
      <td>{{ $item->nome }} @if ($item->cancelado == 1) <span class="ls-tag-danger">Cancelado</span></h5>  @endif</td>
      <td>{{ $item->quantidade }}</td>
      <td>{{ $item->entregue }}</td>      
      <td class="ls-txt-right ls-regroup">
        <a href="{{ URL::to('detalheempenho/' . $item->id . '/edit') }}" class="ls-btn ls-btn-sm" title="Editar">Editar</a>
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
@stop