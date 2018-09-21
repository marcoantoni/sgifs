@extends('layout')

@section('content')
<h1 class="ls-title-intro ls-ico-dashboard">Abastecimentos</h1>
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
@if (Auth::check())
  <a href="{{ route('abastecimento.create') }}" class="ls-btn-primary">Novo abastecimento</a>
@endif
<div class="ls-box-filter">
  <form action="javascript:pesquisar();" class="ls-form ls-form-inline">
    <label class="ls-label col-md-3 col-sm-5 col-xs-5">
      <b class="ls-label-text">Veículo a ser pesquisado</b>
      <div class="ls-custom-select ls-field-sm">
        <select id="id_veiculo" name="id_veiculo" class="ls-select">
          @foreach ($veiculos as $veiculo)
            <option value="{{ $veiculo->id }}">{{ $veiculo->modelo }}</option>
          @endforeach
        </select>
      </div>
    </label>
    <div class="ls-actions-btns">
     <input type="submit" value="Buscar" class="ls-btn ls-btn-sm" title="Buscar"> 
    </div>
  </form>
</div>
<table class="ls-table ls-sm-space ls-table-layout-auto" id="abastecimentos">
  <thead>
    <tr>
      <th>Data</th>
      <th>Valor</th>
      <th>KM</th>
      <th>Consumo</th>
      <th>Litros</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    @foreach ($abastecimentos AS $abastecimento)
    <tr>
      <td>{{ \Carbon\Carbon::parse($abastecimento->data)->format('d/m/Y') }}</td>
      <td>{{ number_format($abastecimento->valor, 2, ',', '.') }}</td>
      <td>{{ $abastecimento->km }}</td>
      <td>{{ $abastecimento->media }} km/l</td>
      <td>{{ $abastecimento->litros }}</td>
      <td class="ls-group-btn">
        @if (Auth::check())
          <a href="{{ URL::to('abastecimento/' . $abastecimento->id . '/edit') }}" class="ls-btn ls-btn-sm" title="Editar abastecimento">Editar</a>
          <form class="formApagarAbastecimento" action="{{ route('abastecimento.destroy', $abastecimento->id) }}" method="POST" onsubmit="return false">
              <input type="hidden" name="_method" value="DELETE">
              <input type="hidden" name="_token" value="{{ csrf_token() }}" />
              <input type="submit" class="ls-btn-danger ls-btn-sm btnApagarAbastecimento" value="Apagar" data-id="{{ $abastecimento->id }}" >
            </form> 
        @endif
        @if ($abastecimento->arquivo == NULL)
          <a href="#" class="ls-btn ls-btn-sm ls-disabled " title="Não foi anexado nota fiscal deste abastecimento">Download</a>
        @else
          <a href="{{ url("storage/nfabastecimentos/$abastecimento->arquivo") }}" class="ls-btn ls-btn-sm " title="Download da nota fiscal" >Download</a>
        @endif
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>
<script type="text/javascript">
  function pesquisar(){
    var id_veiculo = $('#id_veiculo').val();
    var baseUrl = location.protocol+'//'+location.hostname+(location.port ? ':'+location.port: '');
    var redirectTo = baseUrl + '/abastecimento/' + id_veiculo;
    window.location.replace(redirectTo);
  }

  $('.formApagarAbastecimento').on('click', function(e) {
    if (confirm('Deseja mesmo excluir?')) {
      var inputData = $('.formApagarAbastecimento').serialize();
      var dataId = $('.btnApagarAbastecimento').attr('data-id');
      var parent = $(this).parent();
      var url = '{{ url("/abastecimento") }}' + '/' + dataId;
      
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