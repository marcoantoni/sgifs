@extends('layout')

@section('content')
<h1 class="ls-title-intro ls-ico-users">Lista de empresas</h1>
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
@if (Auth::check())
  <a href="{{ route('empresa.create') }}" class="ls-btn-primary">Adicionar nova empresa</a>
@endif
<table class="ls-table ls-sm-space ls-table-layout-auto">
  <thead>
    <tr>
      <th>Nome fantasia</th>
      <th>CNPJ</th>
      <th>Telefone</th>
      <th>Email</th>
      <th>Endereço</th>
      <th>Observação</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($empresas as $empresa)
    <tr>
      <td>{{ $empresa->nome_fantasia }}</td>
      <td>{{ $empresa->cnpj }}</td>
      <td>{{ $empresa->telefone }}</td>
      <td>{{ $empresa->email }}</td>
      <td>{{ $empresa->endereco }}</td>
      <td>{{ $empresa->observacao }}</td>
      <td class="ls-txt-right ls-regroup">
        <a href="{{ URL::to('empresa/' . $empresa->id . '/edit') }}" class="ls-btn ls-btn-sm" title="Apagar">Editar</a>
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