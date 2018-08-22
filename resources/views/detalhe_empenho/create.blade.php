@extends('layout')

@section('content')
<div class="col-md-8">
  <h1 class="ls-title-intro ls-ico-plus"> {{ $pgtitulo }} <span id="numeroEmpenho"></span> </h1>
  @if (session('error'))
    <div class="ls-alert-danger ls-dismissable" id="alert-error">
      <span data-ls-module="dismiss" class="ls-dismiss">&times;</span>
      {!! session('error') !!} 
    </div>
  @endif
  {!! Form::open([
      'route' => 'detalheempenho.store',
      'class' => 'ls-form ls-form-horizontal row',
      'id' => 'itens_empenho'
  ]) !!}
    <label class="ls-label col-md-9">
      <b class="ls-label-text">Vinculando novos itens ao empenho</b>
      <div class="ls-custom-select">
        <select class="ls-custom" name="id_empenho" id="id_empenho">
          @foreach ($empenhos as $empenho)
            <option value="{{ $empenho->id }}" selected>{{ $empenho->numero }}</option>
          @endforeach
        </select>
      </div>
    </label>
    <label class="ls-label col-md-3 col-xs-3">
      <b class="ls-label-text">Previsão de entrega</b>
      <input type="date" id="previsao_entrega" name="previsao_entrega" class="ls-field">
    </label>
    <label class="ls-label col-md-9 col-xs-9">
      <b class="ls-label-text">Item a ser adicionado</b>
      <div class="ls-custom-select">
        <select class="ls-custom" name="id_item" id="id_item">
          @foreach ($itens as $item)
            <option value="{{ $item->id }}" selected>{{ $item->nome }}</option>
          @endforeach
        </select>
      </div>
    </label>
    <label class="ls-label col-md-3 col-xs-3">
      <b class="ls-label-text">Quantidade</b>
      <input type="number" id="quantidade" name="quantidade" placeholder="" class="ls-field" value="1">
    </label>
    <div class="ls-actions-btn">
      <a href="#" class="ls-btn-primary" onclick="adicionar()" id="btn-add">Adicionar item</a>
      <button class="ls-btn" type="submit">Salvar</button>
      <button class="ls-btn-danger">Cancelar</button>
    </div>
  </form>
</div>
<div class="col-md-4" id="boxSelecionados">
  <h1 class="ls-title-intro ls-ico-numbered-list">Itens inclusos</h1>
  <table class="ls-table table-hover ls-bg-header" id="selecionados">
    <thead>
      <tr>
        <td>Descrição</td>
        <td>Quantidade</td>
        <td></td>
      </tr>
    </thead>
  </table>
</div>

<script>
  $('select[name=id_empenho]').change(function () {
    var numeroEmpenho = $('#id_empenho option:selected').text();           
    $('#numeroEmpenho').empty();
    $('#numeroEmpenho').append(' ao empenho ' + numeroEmpenho);
  });
    function adicionar(){
      // pega o código e o nome da opção selecionada
      var idItemSelecionado = $('#id_item').val();
      var nomeItemSelecionado = $('#id_item option:selected').text();
      var quantidadeItemSelecionado = $('#quantidade').val();

      // remove o item selecionado do select
      $('#id_item option[value="'+idItemSelecionado+'"]').remove();
      // adiciona a opção selecionada na tabela de visualizaçãp
      $('#selecionados').append('<tr id="selecionadoTabela'+idItemSelecionado+'"><td>' + nomeItemSelecionado+'</td><td>'+ quantidadeItemSelecionado +'</td><td><a href="#" class="ls-ico-remove" onclick="remover('+idItemSelecionado+')"></td></tr>');
      // adiciona o item selecionado ao campo oculto
      $('#itens_empenho').append('<input type="hidden" name="id_itens_selecionados[]" id="id_item'+idItemSelecionado+'" value="'+ idItemSelecionado +'">');
      $('#itens_empenho').append('<input type="hidden" name="quantidade_itens_selecionados[]" id="id_item'+idItemSelecionado+'" value="'+ quantidadeItemSelecionado +'">');
      $('#boxSelecionados').show();

      var qtdItensDisponiveis = $('#id_item option').length;

      if (qtdItensDisponiveis == 0){
        $('#id_item').attr('disabled', 'disabled');
        $('#btn-add').hide();
      }
    }

    function remover(id){
      $('#id_item'+id).remove();
      $('#selecionadoTabela'+id).hide();
    }

    $( document ).ready(function() {
      $('#boxSelecionados').hide();
    });
</script>

@stop