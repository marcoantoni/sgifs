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
    <a href="{{ route('agendaveiculos.create') }}" class="ls-btn-primary">Novo agendamento</a>
  @endif
  <form  action="" class="ls-form ls-form-inline ls-float-right">
    <label class="ls-label" role="search">
      <b class="ls-label-text">Data inicial</b>
      <input type="date" id="datainicial" name="datainicial" aria-label="Data de inicio" placeholder="" class="ls-field-sm">
    </label>
    <label class="ls-label" role="search">
      <b class="ls-label-text">Data final</b>
      <input type="date" id="datafinal" name="datafinal" aria-label="Data de inicio" placeholder="" class="ls-field-sm">
    </label>
    <div class="ls-actions-btn">
      <a href="#" class="ls-btn ls-btn-sm" title="Buscar" onclick="buscarAgendamento();">Buscar</a>
    </div>
  </form>
  <table class="ls-table ls-sm-space ls-table-layout-auto" id="agendamentos">
    <thead>
      <tr>
        <th>Dia</th>
        <th>Saída</th>
        <th class="hidden-xs">Retorno</th>
        <th class="hidden-xs">Veículo</th>
        <th class="hidden-xs">Solicitante</th>
        <th>Motorista</th>
        <th class="hidden-xs">Destino</th>
        <th class="hidden-xs">Observação</th>
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
        <td class="hidden-xs">{{ $agendamento->fim }}</td>
        <td class="hidden-xs">{{ $agendamento->modelo }}</td>
        <td class="hidden-xs">{{ $agendamento->solicitante }}</td>
        <td>{{ $agendamento->motorista }}</td>
        <td class="hidden-xs">{{ $agendamento->para_onde }}</td>
        <td class="hidden-xs">{{ str_limit($agendamento->observacao, 45, ' ...') }} </td>
      
        <td class="ls-group-btn">
          <a href="#" class="ls-btn ls-btn-sm ls-screen-xs" title="Detalhes" data-ls-module="modal" data-target="#modalExibirEvento" onclick="buscarEvento({{ $agendamento->id }});">Detalhes</a>
          @if (Auth::check())
            <a href="{{ URL::to('agendaveiculos/' . $agendamento->id . '/edit') }}" class="ls-btn ls-btn-sm" title="Editar">Editar</a>
            <form class="formApagarAgendamento" action="{{ route('agendaveiculos.destroy', $agendamento->id) }}" method="POST" onsubmit="return false">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="submit" class="ls-btn-danger ls-btn-sm btnDelete" value="Apagar" id="btnDelete" data-id="{{ $agendamento->id }}" >
            </form> 
          @endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div class="ls-modal" id="modalExibirEvento">
  <div class="ls-modal-box">
    <div class="ls-modal-header">
      <button data-dismiss="modal" onclick="limparConteudoEvento();">&times;</button>
      <h4 class="ls-modal-title">Visualizando item da agenda</h4>
    </div>
    <div class="ls-modal-body" id="conteudoEvento">
      
    </div>
    <div class="ls-modal-footer">
      <button type="submit" class="ls-btn-primary" data-dismiss="modal" onclick="limparConteudoEvento();">Fechar</button>
    </div>
  </div>
</div><!-- /.modal -->

<script type="text/javascript">
  function buscarEvento(id){
    var baseUrl = location.protocol+'//'+location.hostname+(location.port ? ':'+location.port: '')+'/agendaveiculos/'+ id;
    $.get(baseUrl, function (data) {
      $.each(data, function (key, value) {
        $('#conteudoEvento').append('<p>Dia: ' + value.dia + '<p>');               
        $('#conteudoEvento').append('<p>Hora de saída: ' + value.inicio + '</p>');               
        $('#conteudoEvento').append('<p>Hora de retorno: ' + value.fim + '</p>');               
        $('#conteudoEvento').append('<p>Motorista: ' + value.motorista + '</p>');               
        $('#conteudoEvento').append('<p>Solicitante: ' + value.solicitante + '</p>');               
        $('#conteudoEvento').append('<p>Para onde: ' + value.para_onde + '</p>');               
        $('#conteudoEvento').append('<p>Veículo: ' + value.modelo + '</p>');               
        $('#conteudoEvento').append('<p>Observação: ' + value.observacao + '</p>');                       
      });
    });
  }

  function limparConteudoTabela(){
    $("#agendamentos tbody").remove();
  }

  function limparConteudoEvento(){
    $('#conteudoEvento').empty();
  } 

  function buscarAgendamento(){
    var d1 = $('#datainicial').val();
    var d2 = $('#datafinal').val();

    var baseUrl = location.protocol+'//'+location.hostname+(location.port ? ':'+location.port: '')+'/agendaveiculos/obter-reservas/'+ d1+'/'+d2;
    $.get(baseUrl, function (data) {
      $("#agendamentos > tbody").html("");
      $.each(data, function (key, value) {
        $('#agendamentos').append('<tr><td>'+ value.dia +'</td><td>'+ value.inicio +'</td><td>'+ value.fim +'</td><td>'+ value.motorista +'</td><td>'+ value.solicitante +'</td><td>'+ value.para_onde +'</td><td>'+ value.modelo +'</td><td>'+ value.arquivo +'</td></tr>');                 
      });
    });
  }
      
  function limpartabela(){
    $("#agendamentos > tbody").html("");
}
$('.formApagarAgendamento').on('click', function(e) {
    if (confirm('Deseja mesmo excluir?')) {
      var inputData = $('.formApagarAgendamento').serialize();
      var dataId = $('.btnDelete').attr('data-id');
      var parent = $(this).parent();
      var url = '{{ url("/agendaveiculos") }}' + '/' + dataId;
      
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