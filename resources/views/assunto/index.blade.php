@extends('layout')

@section('content')
<h1 class="ls-title-intro ls-ico-users">{{ $pgtitulo }}</h1>
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
<a href="{{ route('assunto.create') }}" class="ls-btn-primary">Adicionar novo assunto</a>
  <table class="ls-table">
    <thead>
      <tr>
        <th>Assunto</th>
        <th>Setor</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($assuntos as $assunto)
      <tr>
        <td>{{ $assunto->assunto }}</td>
        <td>{{ $assunto->nome_setor }}</td>
        <td class="ls-txt-right ls-regroup">
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@stop