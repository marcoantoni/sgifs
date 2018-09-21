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
    <a href="{{ route('agenda.create') }}" class="ls-btn-primary">Novo agendamento</a>
  @endif
  <table class="ls-table ls-sm-space ls-table-layout-auto">
    <thead>
      <tr>
        <th>Dia</th>
        <th>Início</th>
        <th>Fim</th>
        <th>Laboratório</th>
        <th>Solicitante</th>
        <th>Responsável</th>
        <th>Observação</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($agendamentos as $agendamento)
      <tr>
        <td>
          @if ($agendamento->dia == date('Y-m-d'))
           {{ \Carbon\Carbon::parse($agendamento->dia)->format('d/m/Y')}} <a href="#" class="ls-tag-primary">Hoje</a>
          @else
           {{ \Carbon\Carbon::parse($agendamento->dia)->format('d/m/Y')}}
          @endif
        </td>
        <td>{{ $agendamento->inicio }}</td>
        <td>{{ $agendamento->fim }}</td>
        <td>{{ $agendamento->nome }}</td>
        <td>{{ $agendamento->solicitante }}</td>
        <td>{{ $agendamento->name }}</td>
        <td>{{ $agendamento->observacao }}</td>
      
        <td class="ls-group-btn">
          @if (Auth::check())
            @if ($agendamento->id_user == Auth::User()->id)
              <a href="{{ URL::to('agenda/' . $agendamento->id . '/edit') }}" class="ls-btn ls-btn-sm" title="Editar">Editar</a>
              <!-- form para exclusão com ajax -->
              <form class="formApagarAgendamento" action="{{ route('agenda.destroy', $agendamento->id) }}" method="POST" onsubmit="return false">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="submit" class="ls-btn-danger ls-btn-sm btnApagarAgendamento" value="Apagar" data-id="{{ $agendamento->id }}" >
            </form> 
            @endif
          @endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
<script>
  $('.formApagarAgendamento').on('click', function(e) {
    if (confirm('Deseja mesmo excluir?')) {
      var inputData = $('.formApagarAgendamento').serialize();
      var dataId = $('.btnApagarAgendamento').attr('data-id');
      var parent = $(this).parent();
      var url = '{{ url("/agenda") }}' + '/' + dataId;
      
      $.ajax({
        url: url,
        type: 'POST',
        data: inputData,
        
        success: function(data) {
          if (data.status === 'successo') {
            // removendo a linha excluida com uma animação
            parent.closest("tr").fadeOut(1000, function(){ 
              $(this).remove();
            });
          } else if (data.status === 'erro'){
            alert(data.msg);
          }
        }
      });
    }
    return false;
  });
</script>
@stop