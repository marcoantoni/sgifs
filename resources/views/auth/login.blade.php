<!DOCTYPE html>
<html class="ls-theme-green" lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>Tela de Login</title>
    <meta name="description" content="Portal de informações do IFSC São Carlos">
    <meta name="keywords" content="agendamento, empenhos, orçamento, IFSC São Carlos">
    <meta name="author" content="Marco Antoni - marco.antoni@ifsc.edu.br">
    <meta name="mobile-web-app-capable" content="yes">
    <link href="{{ URL::asset('locawebstyles/stylesheets/locastyle.css') }}" rel="stylesheet" type="text/css" />
  </head>
  <body>
    <div class="ls-login-parent">
      <div class="ls-login-inner">
      <div class="ls-login-container">
        <div class="ls-login-box">
        <h1 class="ls-login-logo"></h1>
        <form class="form-horizontal" method="POST" action="{{ route('login') }}">
          {{ csrf_field() }}
          <fieldset>
            <label class="ls-label">
              <b class="ls-label-text ls-hidden-accessible">Usuário</b>
              <input type="email" id="email" class="ls-login-bg-user ls-field-lg" name="email" placeholder="E-mail" required autofocus>
            </label>
            </label>
            <label class="ls-label">
              <b class="ls-label-text ls-hidden-accessible">Senha</b>
              <div class="ls-prefix-group ls-field-lg">
                <input id="password" class="ls-login-bg-password" type="password" name="password" placeholder="Senha" >
                <a class="ls-label-text-prefix ls-toggle-pass ls-ico-eye" data-toggle-class="ls-ico-eye, ls-ico-eye-blocked" data-target="#password" href="#"></a>
              </div>
            </label>
            <p><a class="ls-login-forgot" href="forgot-password"></a></p>
            <input type="submit" value="Entrar" class="ls-btn-primary ls-btn-block ls-btn-lg">
          </fieldset>
        </form>
        </div>
      </div>
      </div>
    </div>
    <script src="http://opensource.locaweb.com.br/locawebstyle/assets/javascripts/libs/jquery-2.1.0.min.js" type="text/javascript">
    </script><script src="{{ URL::asset('locawebstyles/javascripts/locastyle.js') }}" type="text/javascript"></script>
  </body>
</html>
