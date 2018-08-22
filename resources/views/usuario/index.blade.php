@extends('layout')

@section('content')
<h1 class="ls-title-intro ls-ico-users">{{ $pgtitulo }}</h1>
  @if (session('success'))
  <div class="ls-alert-success ls-dismissable" id="alert-success">
    <span data-ls-module="dismiss" class="ls-dismiss">&times;</span>
    {!! session('success') !!} 
  </div>
  @endif
<a href="{{ route('usuario.create') }}" class="ls-btn-primary">Adicionar novo usuário</a>
<table class="ls-table">
  <thead>
    <tr>
      <th>Nome</th>
      <th>Email</th>
      <th>Telefone</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    @foreach ($usuarios as $usuario)
    <tr>
      <td>{{ $usuario->name }}</td>
      <td>{{ $usuario->email }}</td>
      <td>{{ $usuario->telefone }}</td>
      <td></td>
      <td class="ls-txt-right ls-regroup">
        <a href="{{ URL::to('usuario/' . $usuario->id . '/edit') }}" class="ls-btn ls-btn-sm" title="Editar usuário selecionado">Editar</a>
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