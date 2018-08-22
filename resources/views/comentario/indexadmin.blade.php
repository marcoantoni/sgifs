@extends('layout')

@section('content')
  <h1 class="ls-title-intro ls-ico-bullhorn">{{ $pgtitulo}}</h1>
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
  <a href="{{ route('comentario.index') }}" class="ls-btn-primary">Questões públicas</a>
  <table class="ls-table ls-sm-space ls-table-layout-auto">
    <thead>
      <tr>
        <th>Texto</th>
        <th>Contato</th>
        <th>Texto</th>
        <th>Assunto</th>
        <th>Setor</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($comentarios as $comentario)
      <tr>
        <td>{{ $comentario->nome }} @if ($comentario->responder == 1) <span class="ls-tag">deseja resposta</span></h3> @endif</td>
        <td>{{ $comentario->telefone }} / {{ $comentario->email }} </td>
        <td>{{ $comentario->texto }} </td>
        <td>{{ $comentario->assunto }}</td>
        <td>{{ $comentario->nome_setor }}</td>
              
        <td class="ls-txt-right ls-regroup">
          <a href="{{ URL::to('comentario/' . $comentario->id . '/edit') }}" class="ls-btn ls-btn-sm" title="Editar comentario">Responder</a>
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