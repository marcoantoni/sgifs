@extends('layout')

@section('content')
<h1 class="ls-title-intro ls-ico-pencil">{{ $pgtitulo }}</h1>
<div class="col-md-4">
  @if (session('error'))
    <div class="ls-alert-danger ls-dismissable" id="alert-error">
      <span data-ls-module="dismiss" class="ls-dismiss">&times;</span>
      {!! session('error') !!} 
    </div>
  @endif
  {!! Form::model($item, [
      'method' => 'PATCH',
      'route' => ['detalheempenho.update', $item->id], 
      'class' => 'ls-form ls-form-horizontal row',
      'id' => 'id',
  ]) !!}
    <label class="ls-label col-md-4 col-xs-4">
      <b class="ls-label-text">Item entregue</b>
      <input type="date" id="entregue" name="entregue" class="ls-field" value="{{ $item->entregue }}">
    </label>
    <label class="ls-label col-md-4 col-xs-4">
      <b class="ls-label-text">Previsão de entrega</b>
      <input type="date" id="previsao_entrega" name="previsao_entrega" class="ls-field" value="{{ $item->previsao_entrega }}">
    </label>
    <label class="ls-label col-md-3 col-xs-3">
      <b class="ls-label-text">Quantidade</b>
      <input type="number" name="quantidade" placeholder="Quantidade deste item" class="ls-field" value="{{ $item->quantidade }}" required>
  </label>
  <label class="ls-label col-md-12">
      <b class="ls-label-text">Item cancelado</b>
       <input class="form-check-input" type="radio" name="cancelado" value="1" @if ($item->cancelado == 1) checked @endif> Sim
       <input class="form-check-input" type="radio" name="cancelado" value="0" @if ($item->cancelado == 0) checked @endif> Não
    </label>
  <input type="hidden" name="id_empenho" id="id_empenho" value="{{ $item->id_empenho }}">
  <input type="hidden" name="id_item" id="id_item">

    <div class="ls-actions-btn">
      <button class="ls-btn" type="submit">Salvar</button>
      <button class="ls-btn-danger">Cancelar</button>
    </div>
  </form>
</div>
@stop