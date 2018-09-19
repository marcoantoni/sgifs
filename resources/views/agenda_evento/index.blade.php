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
        <th>Data início</th>
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
        <td>
          @if ($evento->data_inicio == date('Y-m-d'))
           {{ \Carbon\Carbon::parse($evento->data_inicio)->format('d/m/Y')}} <a href="#" class="ls-tag-primary">Hoje</a>
          @else
            {{ \Carbon\Carbon::parse($evento->data_inicio)->format('d/m/Y')}}
          @endif
        </td>
        <td>{{ $evento->hora_inicio }}</td>
        <td>{{ $evento->nome }}</td>
        <td>{{ $evento->alvo }}</td>
        <td>{{ $evento->observacao }}</td>
        <td class="ls-group-btn">
          @if ((Auth::check()))
            <a href="{{ URL::to('eventos/' . $evento->id . '/edit') }}" class="ls-btn ls-btn-sm" title="Editar">Editar</a>
						<!-- form para exclusão com ajax -->
            <form class="formApagarEvento" action="{{ route('eventos.destroy', $evento->id) }}" method="POST" onsubmit="return false">
				        <input type="hidden" name="_method" value="DELETE">
				        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
				        <input type="submit" class="ls-btn-danger ls-btn-sm btnDeleteProduct" value="Apagar" id="btnDelete" data-id="{{ $evento->id }}" >
				    </form>	
          @endif 
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
<script>
	$('.formApagarEvento').on('click', function(e) {
		if (confirm('Deseja mesmo excluir?')) {
			var inputData = $('.formApagarEvento').serialize();
			var dataId = $('.btnDeleteProduct').attr('data-id');
			var parent = $(this).parent();
			var url = '{{ url("/eventos") }}' + '/' + dataId;
			
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