@extends('layout')

@section('content')
<h1 class="ls-title-intro ls-ico-stats">Recursos liberados em {{ date('Y') }}</h1>
@if (session('sucess'))
<div class="ls-alert-success ls-dismissable" id="alert-sucess">
  <span data-ls-module="dismiss" class="ls-dismiss">&times;</span>
  {{ session('sucess') }} 
</div>
@endif
@if (Auth::check())
  <a href="{{ route('rlib.create') }}" class="ls-btn-primary">Liberar novo recurso</a>
@endif
<table class="ls-table">
  <thead>
    <tr>
      <th>Data de liberação</th>
      <th>Valor liberado</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    @foreach ($rlibs as $rlib)
    <tr>
      <td>{{ $rlib->data }}</td>
      <td>{{ number_format($rlib->valor, 2, ',', '.') }}</td>
      @if (Auth::check())
        <td class="ls-txt-right ls-regroup">
          <a href="{{ URL::to('rlib/' . $rlib->id . '/edit') }}" class="ls-btn ls-btn-sm" title="Editar">Editar</a>
        </td>
      @endif
    </tr>
    @endforeach
  </tbody>
</table>


    </div>
@stop