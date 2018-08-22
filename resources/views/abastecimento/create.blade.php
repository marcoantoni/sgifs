@extends('layout')
@section('content')
<h1 class="ls-title-intro ls-ico-plus">{{ $pgtitulo }}</h1>
<div class="col-md-6">
  {!! Form::open([
      'route' => 'abastecimento.store',
      'class' => 'ls-form ls-form-horizontal row',
      'enctype' => 'multipart/form-data' 
  ]) !!}   
    <label class="ls-label col-md-3 col-xs-6">
      <b class="ls-label-text">Data</b>
      <input type="date" name="data" placeholder="Data do abastecimento" class="ls-field" required>
    </label>
    <label class="ls-label col-md-3 col-xs-6">
      <b class="ls-label-text">Valor</b>
      <input type="text" name="valor" placeholder="Valor em reais" class="ls-field" required>
    </label>
    <label class="ls-label col-md-3 col-xs-6">
      <b class="ls-label-text">Litros</b>
      <input type="text" name="litros" placeholder="Litros" class="ls-field" required>
    </label>
    <label class="ls-label col-md-3 col-xs-6">
      <b class="ls-label-text">KM</b>
      <input type="number" name="km" placeholder="Quilometragem" class="ls-field" required>
    </label>
    <label class="ls-label col-md-6 col-xs-12">
      <b class="ls-label-text">Veículo</b>
      <div class="ls-custom-select">
        <select class="ls-custom" name="id_veiculo">
          @foreach ($veiculos as $veiculo)
            <option value="{{ $veiculo->id }}">{{ $veiculo->modelo }}</option>
          @endforeach
        </select>
      </div>
    </label> 
    <label class="ls-label col-md-6 col-xs-12">
      <b class="ls-label-text">Responsável pelo abastecimento</b>
      <div class="ls-custom-select">
        <select class="ls-custom" name="id_user">
          @foreach ($usuarios as $usuario)
            <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
          @endforeach
        </select>
      </div>
    </label>
    <label class="ls-label col-md-12 col-xs-12">
      <b class="ls-label-text">Arquivo</b>
      <input type="file" name="arquivo" placeholder="Arquivo da nota fiscal" class="ls-field">
    </label>
    <div class="ls-actions-btn">
      <button class="ls-btn" type="submit">Salvar</button>
      <button class="ls-btn-danger">Cancelar</button>
    </div>
  </form>
</div>
@stop