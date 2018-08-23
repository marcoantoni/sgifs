@extends('layout')

@section('content')
  <h1 class="ls-title-intro ls-ico-week">{{ $pgtitulo}}</h1>
  @if (session('sucess'))
    <div class="ls-alert-success ls-dismissable" id="alert-sucess">
      <span data-ls-module="dismiss" class="ls-dismiss">&times;</span>
      {{ session('sucess') }} 
    </div>
  @endif
  @if (session('error'))
    <div class="ls-alert-danger ls-dismissable" id="alert-error">
      <span data-ls-module="dismiss" class="ls-dismiss">&times;</span>
      {!! session('error') !!} 
    </div>
  @endif
  @if (Auth::check())
    <a href="{{ route('eventos.create') }}" class="ls-btn-primary">Novo agendamento</a>
  @endif
  <table class="ls-table ls-sm-space ls-table-layout-auto">
    <thead>
      <tr>
        <th>Nome evento</th>
        <th>Responsável</th>
        <th>Data ínicio</th>
        <th>Data fim</th>
        <th>Horário</th>
        <th>Local</th>
        <th>Público alvo</th>
        <th>Observação</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($eventos as $evento)
      <tr>
        <td>
          {{ $evento->nome_evento }}
          @if ($evento->link)
            <a href="{{ $evento->link }}"><span class="ls-tag-primary">{{$evento->nomelink}}</span></a>
          @endif
        </td>
        <td>{{ $evento->responsavel }}</td>
        <td>{{ \Carbon\Carbon::parse($evento->data_inicio)->format('d/m/Y')}}</td>
        <td>{{ \Carbon\Carbon::parse($evento->data_fim)->format('d/m/Y')}}</td>
        <td>{{ $evento->hora_inicio }}</td>
        <td>{{ $evento->nome }}</td>
        <td>{{ $evento->alvo }}</td>
        <td>{{ $evento->observacao }}</td>
        <td class="ls-group-btn">
          @if ((Auth::check()) and  ($evento->id_user == Auth::User()->id))
            <a href="{{ URL::to('eventos/' . $evento->id . '/edit') }}" class="ls-btn ls-btn-sm" title="Editar">Editar</a>
          @endif 
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@stop