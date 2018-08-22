@extends('layout')
@section('content')
<h1 class="ls-title-intro ls-ico-pencil">{{ $pgtitulo }}</h1>
<div class="col-md-6">
  {!! Form::model($abastecimento, [
        'method' => 'PATCH',
        'route' => ['abastecimento.update', $abastecimento->id], 
        'class' => 'ls-form ls-form-horizontal row',
        'id' => 'id',
        'enctype' => 'multipart/form-data'
    ]) !!}  
    <label class="ls-label col-md-3 col-xs-6">
      <b class="ls-label-text">Data</b>
      <input type="date" name="data" placeholder="Data do abastecimento" class="ls-field" value="{{ $abastecimento->data }}" required>
    </label>
    <label class="ls-label col-md-3 col-xs-6">
      <b class="ls-label-text">Valor</b>
      <input type="text" name="valor" placeholder="Valor em reais" class="ls-field" value="{{ $abastecimento->valor }}" required>
    </label>
    <label class="ls-label col-md-2 col-xs-6">
      <b class="ls-label-text">Litros</b>
      <input type="text" name="litros" placeholder="Litros" class="ls-field" value="{{ $abastecimento->litros }}" required>
    </label>
    <label class="ls-label col-md-2 col-xs-6">
      <b class="ls-label-text">KM atual</b>
      <input type="number" name="km" placeholder="Quilometragem" class="ls-field" value="{{ $abastecimento->km }}" required>
    </label>
    <label class="ls-label col-md-2 col-xs-6">
      <b class="ls-label-text">Média <a href="#" class="ls-ico-help ls-float-right" data-trigger="hover" data-ls-module="popover" data-placement="left" data-content="Ao editar um abastecimento, a média deve ser calculada manualmente" data-title="Atenção"></a></b>
      <input type="text" name="media" placeholder="Média" class="ls-field" value="{{ $abastecimento->media }}" required>
    </label>
    <label class="ls-label col-md-6 col-xs-12">
      <b class="ls-label-text">Veículo</b>
      <div class="ls-custom-select">
        <select class="ls-custom" name="id_veiculo">
          @foreach ($veiculos as $veiculo)
            @if ($veiculo->id == $abastecimento->id_veiculo)
              <option value="{{ $veiculo->id }}" selected>{{ $veiculo->modelo }}</option>
            @else
              <option value="{{ $veiculo->id }}">{{ $veiculo->modelo }}</option>
            @endif
          @endforeach
        </select>
      </div>
    </label> 
    <label class="ls-label col-md-6 col-xs-12">
      <b class="ls-label-text">Responsável pelo abastecimento</b>
      <div class="ls-custom-select">
        <select class="ls-custom" name="id_user">
          @foreach ($usuarios as $usuario)
            @if ($usuario->id == $abastecimento->id_user)
              <option value="{{ $usuario->id }}" selected>{{ $usuario->name }}</option>
            @else
              <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
            @endif
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