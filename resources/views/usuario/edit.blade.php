	@extends('layout')

	@section('content')
	<h1 class="ls-title-intro ls-ico-pencil">{{ $pgtitulo }} {{ $usuario->name }}</h1>
	<div class="col-md-4">
	@if (session('error'))
  <div class="ls-alert-danger ls-dismissable" id="alert-error">
    <span data-ls-module="dismiss" class="ls-dismiss">&times;</span>
    {!! session('error') !!} 
  </div>
	@endif
	@if (Auth::check() && Auth::User()->id_setor == 1 || Auth::User()->id_setor == 2)
		{!! Form::model($usuario, [
			'method' => 'PATCH',
			'route' => ['usuario.update', $usuario->id], 
			'class' => 'ls-form ls-form-horizontal row',
			'id' => 'id',
		]) !!}
			<h3>Permissões de acesso</h3>
			@foreach ($permissoes AS $permissao)
			<label class="ls-label col-md-12 col-xs-12">
				<b class="ls-label-text">{{ $permissao->descricao }}</b>
				<div class="ls-custom-select">
					<select class="ls-custom" name="{{ $permissao->id }}">
						<option value="n">Não</option>
						<option value="s">Sim</option>
					</select>
				</div>
			</label>
			@endforeach
			<label class="ls-label col-md-12">
				<b class="ls-label-text">Setor que está vinculado</b>
				<div class="ls-custom-select">
				<select class="ls-custom" name="id_setor">
					@foreach ($setores AS $setor)
						@if ($setor->id == $usuario->id_setor)
							<option value="{{ $setor->id }}" selected>{{ $setor->nome }}</option>
						@else
							<option value="{{ $setor->id }}">{{ $setor->nome }}</option>
						@endif
					@endforeach
					</select>
				</div>
			</label>
			<label class="ls-label col-md-6 col-xs-12">
	      <b class="ls-label-text">Senha</b>
	      <input type="password" name="password" class="ls-field"  placeholder="">
	      @if ($errors->has('password'))
	          <span class="help-block">
	              <strong>{{ $errors->first('password') }}</strong>
	          </span>
	      @endif
    </label>
    <label class="ls-label col-md-6 col-xs-12">
      <b class="ls-label-text">Confirmação da senha</b>
      <input type="password" name="password_confirmation" class="ls-field" placeholder="">
    </label>
	@endif
			<div class="ls-actions-btn">
				<button class="ls-btn" type="submit">Salvar</button>
				<button class="ls-btn-danger">Cancelar</button>
			</div>
		</form>
	</div>
	@stop