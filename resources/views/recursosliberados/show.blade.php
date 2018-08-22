@extends('layout')

@section('content')
<h1 class="ls-title-intro ls-ico-stats">{{ $pgtitulo }}</h1>
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
      
      <td class="ls-txt-right ls-regroup">
        <a href="{{ URL::to('rlib/' . $rlib->id . '/edit') }}" class="ls-btn ls-btn-sm" title="Apagar">Editar</a>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>


    </div>
@stop