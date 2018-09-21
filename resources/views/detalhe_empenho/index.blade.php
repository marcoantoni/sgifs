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
</div>
@stop