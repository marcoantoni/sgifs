@extends('layout')

@section('content')
  <h1 class="ls-title-intro ls-ico-question">{{ $pgtitulo}}</h1>
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

  <div class="ls-group-btn">
    <a href="{{ route('comentario.create') }}" class="ls-btn">Nova mensagem</a>
    @if (Auth::check())
      <a href="/comentario/admin" class="ls-btn-primary">Administrar</a>
    @endif
  </div>
  <table class="ls-table ls-sm-space ls-table-layout-auto">
    <thead>
      <tr>
        <th>Texto</th>
        <th>Resposta</th>
        <th>Assunto</th>
        <th>Setor</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($comentarios as $comentario)
      <tr>
        <td>{{ $comentario->texto }}</td>
        <td>{{ $comentario->resposta }}</td>
        <td>{{ $comentario->assunto }}</td>
        <td>{{ $comentario->nome_setor }}</td>
              
        <td class="ls-txt-right ls-regroup ls-group-btn"> 
          @if (Auth::check())
            <a href="{{ URL::to('comentario/' . $comentario->id . '/edit') }}" class="ls-btn ls-btn-sm" title="Editar comentario">Responder</a>
          @endif
          @if ($comentario->arquivo == NULL)
           <a href="#" class="ls-btn ls-btn-sm ls-disabled " title="Download desse arquivo">Download</a>
          @else
           <a href="{{ url("storage/comentarios/$comentario->arquivo") }}" class="ls-btn ls-btn-sm " title="Download desse arquivo" >Download</a>
          @endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@stop