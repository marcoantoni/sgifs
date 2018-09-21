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
@if(Auth::check())
<a href="{{ route('detalheempenho.create') }}" class="ls-btn-primary">Adicionar novo item a esse empenho</a>
@endif

<table class="ls-table ls-sm-space ls-table-layout-auto">
  <thead>
    <tr>
      <th>Nome</th>
      <th>Quantidade</th>
      <th>Status da entrega</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    @foreach ($itens as $item)
    <tr>
      <td>{{ $item->nome }}@if ($item->cancelado == 1) <span class="ls-tag-warning">Cancelado</span></h5>  @endif</td>
      <td>{{ $item->quantidade }}</td>
      <td>
        <?php
            $hoje =  \Carbon\Carbon::createFromFormat('d/m/Y', date('d/m/Y'));
            $previsao_entrega = \Carbon\Carbon::createFromFormat('Y-m-d', $item->previsao_entrega);
            
            // item entregue
            if ($item->entregue){
              if ($previsao_entrega < $item->entregue) {
                $entregue = \Carbon\Carbon::createFromFormat('Y-m-d', $item->entregue);
                $atraso = $entregue->diffInDays($previsao_entrega);
                echo "Entregue com $atraso dias de atraso";
              } else {
                echo "Entregue";
              }
              // item ainda nao entregue
            } else {
              if ($previsao_entrega > $hoje) {
                echo "Dentro do prazo";
              } else {
                $atraso = $hoje->diffInDays($previsao_entrega);
                echo "Atraso de $atraso dias";
              }
            }
        ?>          
      </td> 
      <td class="ls-group-btn">
        @if(Auth::check())
          <a href="{{ URL::to('detalheempenho/' . $item->id . '/edit') }}" class="ls-btn ls-btn-sm" title="Editar">Editar</a>
           <!-- form para exclusão com ajax -->
          <form class="formApagarDetalheEmpenho" action="{{ route('detalheempenho.destroy', $item->id) }}" method="POST" onsubmit="return false">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <input type="submit" class="ls-btn-danger ls-btn-sm btnDeleteDetalheEmpenho" value="Apagar"  data-id="{{ $item->id }}" >
          </form> 
        @endif
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>
<script>
  $('.formApagarDetalheEmpenho').on('click', function(e) {
    if (confirm('Deseja mesmo excluir?')) {
      var inputData = $('.formApagarDetalheEmpenho').serialize();
      var dataId = $('.btnDeleteDetalheEmpenho').attr('data-id');
      var parent = $(this).parent();
      var url = '{{ url("/detalheempenho") }}' + '/' + dataId;
      
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