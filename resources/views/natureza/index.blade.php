@extends('layout')

@section('content')
<h1 class="ls-title-intro ls-ico-users">Lista de naturezas</h1>
  @if (session('sucess'))
    <div class="ls-alert-success ls-dismissable" id="alert-sucess">
      <span data-ls-module="dismiss" class="ls-dismiss">&times;</span>
      {{ session('sucess') }} 
    </div>
  @endif
  @if (session('error'))
    <div class="ls-alert-danger ls-dismissable" id="alert-error">
      <span data-ls-module="dismiss" class="ls-dismiss">&times;</span>
      {{ session('error') }} 
    </div>
  @endif
  @if (Auth::check())
    <a href="{{ route('natureza.create') }}" class="ls-btn-primary">Adicionar nova natureza</a>
  @endif
  <table class="ls-table ls-sm-space ls-table-layout-auto">
    <thead>
      <tr>
        <th>id</th>
        <th>Natureza</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($naturezas as $natureza)
      <tr>
        <td>{{ $natureza->id }}</td>
        <td>{{ $natureza->nome }}</td>
        <td class="ls-txt-right ls-regroup">
          @if (Auth::check())
            <a href="{{ URL::to('natureza/' . $natureza->id . '/edit') }}" class="ls-btn ls-btn-sm" title="Editar">Editar</a>
          @endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@stop