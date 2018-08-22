@extends('layout')

@section('content')
<h1 class="ls-title-intro ls-ico-envelope">{{ $pgtitulo }}</h1>
<div class="col-md-9">
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
  <div id="error" class="ls-alert-danger ls-dismissable">
    <span data-ls-module="dismiss" class="ls-dismiss">&times;</span>
    <strong><p id="msgaviso"></p></strong>
  </div>
  {!! Form::open([
      'route' => 'comentario.store',
      'class' => 'ls-form ls-form-horizontal row',
      'enctype' => 'multipart/form-data'
  ]) !!}
    <label class="ls-label col-md-3 col-xs-12">
      <b class="ls-label-text">Nome</b>
      <input type="text" id="nome" name="nome" placeholder="" class="ls-field" data-ls-module="charCounter" maxlength="45" value="{{ old('nome') }}">
    </label>
    <label class="ls-label col-md-3 col-xs-12">
      <b class="ls-label-text">Email</b>
      <input type="email" id="email" name="email" placeholder="" class="ls-field" data-ls-module="charCounter" maxlength="45" value="{{ old('email') }}">
    </label> 
    <label class="ls-label col-md-3 col-xs-12">
      <b class="ls-label-text">Telefone</b>
      <input type="tel" name="telefone" placeholder="" class="ls-field" data-ls-module="charCounter" maxlength="45" value="{{ old('telefone') }}">
    </label>
    <label class="ls-label col-md-4">
      <b class="ls-label-text">Setor</b>
      <div class="ls-custom-select">
        <select class="ls-custom" name="id_setor" id="id_setor">
          <option value="0" selected>Escolha</option>
          @foreach ($setores as $setor)
            <option value="{{ $setor->id }}">{{ $setor->nome }}</option>
          @endforeach
        </select>
      </div>
    </label>
    <label class="ls-label col-md-5 col-xs-12">
      <b class="ls-label-text">Assunto</b>
      <div class="ls-custom-select">
        <select class="ls-custom" name="id_assunto" id="id_assunto">
          <option value="0">Selecione o setor</option>
        </select>
      </div>
    </label>
    <label class="ls-label col-md-9 col-xs-12">
      <b class="ls-label-text">Texto</b>
      <textarea rows="4" name="texto" data-ls-module="charCounter" maxlength="1000">{{ old('texto') }}</textarea>
    </label>
    <label class="ls-label col-md-9 col-xs-12">
      <b class="ls-label-text">Deseja receber uma resposta?</b>
       <input class="form-check-input" type="radio" name="responder" value="1" id="respostasim"> Sim
       <input class="form-check-input" type="radio" name="responder" value="0" id="respostanao" checked> Não
    </label>
    <label class="ls-label col-md-9 col-xs-12">
      <b class="ls-label-text">Deseja tornar isto público?</b>
       <input class="form-check-input" type="radio" name="cpublica" value="1" > Sim
       <input class="form-check-input" type="radio" name="cpublica" value="0" checked> Não
    </label>
    <label class="ls-label col-md-12 col-xs-12">
      <b class="ls-label-text">Anexar um arquivo</b>
      <input type="file" name="arquivo" placeholder="Anexar arquivo" class="ls-field">
    </label>
    <div class="ls-actions-btn">
      <button class="ls-btn" type="submit" onclick="return validarTxtSugestao()">Salvar</button>
      <button class="ls-btn-danger">Cancelar</button>
    </div>
  </form>
</div>

<script type="text/javascript">
   $('#id_assunto').attr('disabled', 'disabled');

  $(document).ready(function() {
    $('#id_setor').change(function() {
      var id_setor = $('#id_setor').val();
      if (id_setor == 0){
        $('select[name=id_assunto]').empty();
        $('select[name=id_assunto]').append('<option value="0">Selecione o setor</option>');
        $('#id_assunto').attr('disabled', 'disabled');
      } else {
        var baseUrl = location.protocol+'//'+location.hostname+(location.port ? ':'+location.port: '')+'/obter-assuntos/'+id_setor;
        $.get(baseUrl, function (problemas) {
          $('select[name=id_assunto]').empty();
          $.each(problemas, function (key, value) {
            $('select[name=id_assunto]').append('<option value=' + value.id + '>' + value.assunto + '</option>');               
          });
        });
        $('#id_assunto').removeAttr('disabled');
      }
    });
  });

  function validarTxtSugestao(){
    if(document.getElementById('respostasim').checked) {
      var nome = $('#nome').val(); 
      var email = $('#email').val(); 
      var erros = 0;
      $('#msgaviso').empty();
      
      if (nome.length < 3){
        erros++;
        $('#msgaviso').append('Você marcou que deseja uma respota: Preencha seu nome<br>'); 
      }
      if (email.length < 3){
        erros++;
        $('#msgaviso').append('Você marcou que deseja uma respota: Preencha seu email<br>');
      }

      if (erros > 0){
        $('#error').show();
        return false;
      }
      return true;
    }
  }

</script>

@stop