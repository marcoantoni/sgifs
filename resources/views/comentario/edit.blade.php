@extends('layout')

@section('content')
<div class="col-md-8">
<h1 class="ls-title-intro ls-ico-envelop">Respondendo questão #{{ $comentario->id }}</h1>
@if (session('error'))
<div class="ls-alert-danger ls-dismissable" id="alert-error">
<span data-ls-module="dismiss" class="ls-dismiss">&times;</span>
{!! session('error') !!} 
</div>
@endif
  {!! Form::model($comentario, [
    'method' => 'PATCH',
    'route' => ['comentario.update', $comentario->id], 
    'class' => 'ls-form ls-form-horizontal row',
    'id' => 'id',
  ]) !!}
  <label class="ls-label col-md-3 col-xs-12">
    <b class="ls-label-text">Nome</b>
    <input type="text" name="nome" placeholder="" class="ls-fields" data-ls-module="charCounter" maxlength="45" value="{{ $comentario->nome }}">
  </label>
  <label class="ls-label col-md-3 col-xs-12">
    <b class="ls-label-text">Email</b>
    <input type="email" name="email" placeholder="" class="ls-field" data-ls-module="charCounter" maxlength="45" value="{{ $comentario->email }}">
  </label> 
  <label class="ls-label col-md-3 col-xs-12">
    <b class="ls-label-text">Telefone</b>
    <input type="tel" name="telefone" placeholder="" class="ls-field" data-ls-module="charCounter" maxlength="45" value="{{ $comentario->telefone }}">
  </label>
  <label class="ls-label col-md-4">
    <b class="ls-label-text">Setor</b>
    <div class="ls-custom-select">
      <select class="ls-custom" name="id_setor" id="id_setor">
        <option selected="selected">Selecione caso queira mudar o assunto</option>
        @foreach ($setores as $setor)
          @if ($comentario->id_setor == $setor->id)
            <option value="{{ $setor->id }}" selected>{{ $setor->nome }}</option>
          @else
            <option value="{{ $setor->id }}">{{ $setor->nome }}</option>
          @endif
        @endforeach
      </select>
    </div>
  </label>
  <label class="ls-label col-md-5">
    <b class="ls-label-text">Assunto</b>
    <div class="ls-custom-select">
      <select class="ls-custom" name="id_assunto" id="id_assunto">
        @foreach ($assuntos AS $assunto)
          @if ($comentario->id_assunto == $assunto->id )
            <option value="{{ $assunto->id }}" selected>{{ $assunto->assunto }}</option>
          @endif
        @endforeach
      </select>
    </div>
  </label>
  <label class="ls-label col-md-9">
    <b class="ls-label-text">Texto</b>
    <textarea rows="4" name="comentario">{{ $comentario->texto }}</textarea>
  </label>
  <label class="ls-label col-md-9">
    <b class="ls-label-text">Resposta</b>
    <textarea rows="4" name="resposta" data-ls-module="charCounter" maxlength="1000">{{ $comentario->resposta }}</textarea>
  </label>
  <label class="ls-label col-md-9 ls-tooltip-top" aria-label="Ao marcar a questão como respondida, ela não pode mais ser editada">
    <b class="ls-label-text">Marcar a questão como respondida?</b>
    <input class="form-check-input" type="radio" name="respondido" value="1"> Sim
    <input class="form-check-input" type="radio" name="respondido" value="0"> Não
  </label>

  <label class="ls-label col-md-12 col-xs-12">
    <b class="ls-label-text">Anexar um arquivo</b>
    <input type="file" name="arquivo" placeholder="Anexar arquivo" class="ls-field">
  </label>
  <div class="ls-actions-btn">
    <button class="ls-btn" type="submit">Salvar</button>
    <button class="ls-btn-danger">Cancelar</button>
  </div>
  </form>
</div>
<script type="text/javascript">
    $(document).ready(function() {
    $('#id_setor').change(function() {
      var id_setor = $('#id_setor').val();
      var baseUrl = location.protocol+'//'+location.hostname+(location.port ? ':'+location.port: '')+'/obter-assuntos/'+id_setor;
      $.get(baseUrl, function (problemas) {
        $('select[name=id_assunto]').empty();
        $.each(problemas, function (key, value) {
          $('select[name=id_assunto]').append('<option value=' + value.id + '>' + value.assunto + '</option>');               
        });
      });
    });
  });
</script>

  <h1 class="ls-title-intro ls-ico-text">Histórico de modificações</h1>
    {!! $comentario->log !!}
</div>
@stop