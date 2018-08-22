@extends('layout')
@section('content')
<div class="col-md-6">
  <h1 class="ls-title-intro ls-ico-stats">Liberando novo recurso</h1>
  {!! Form::open([
      'route' => 'rlib.store',
      'class' => 'ls-form ls-form-horizontal row'
  ]) !!}   
    <label class="ls-label col-md-3 col-xs-12">
      <b class="ls-label-text">Valor</b>
      <input type="text" name="valor" placeholder="Valor em reais" class="ls-field" required>
    </label>  <label class="ls-label col-md-3 col-xs-12">
      <b class="ls-label-text">Data</b>
      <input type="date" name="data" placeholder="Data do empenho" class="ls-field" required>
    </label>
    <label class="ls-label col-md-3">
      <b class="ls-label-text">Orçamento</b>
      <div class="ls-custom-select">
        <select class="ls-custom" name="id_orcamento">
          @foreach ($orcamento as $o)
            <option value="{{ $o->ano }}">{{ $o->ano }}</option>
          @endforeach
        </select>
      </div>
    </label>

    <div class="ls-actions-btn">
      <button class="ls-btn" type="submit">Salvar</button>
      <button class="ls-btn-danger">Cancelar</button>
    </div>
  </form>
</div>
<div class="col-md-6">
  <h1 class="ls-title-intro">Recursos liberados</h1>
  <table class="ls-table">
    <thead>
      <tr>
        <th>Data de liberação</th>
        <th>Valor liberado</th>
        <th>Orcamento anual de</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($rlibs as $rlib)
      <tr>
        <td>{{ $rlib->data }}</td>
        <td>{{ number_format($rlib->valor, 2, ',', '.') }}</td>
        <td>{{ $rlib->id_orcamento }}</td>
        <td class="ls-txt-right ls-regroup">
          <a href="{{ URL::to('rlib/' . $rlib->id . '/edit') }}" class="ls-btn ls-btn-sm" title="Apagar">Editar</a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@stop