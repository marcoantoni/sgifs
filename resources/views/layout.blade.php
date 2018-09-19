<!DOCTYPE html>
<html class="ls-theme-green" lang="pt-BR">
  <head>
  <title>{{ $pgtitulo }}</title>
  <meta charset="utf-8">
  <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
  <meta name="description" content="Portal de informações do IFSC São Carlos">
  <meta name="keywords" content="agendamento, empenhos, orçamento, IFSC São Carlos">
  <meta name="author" content="Marco Antoni - marco.antoni@ifsc.edu.br">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <link rel="icon" sizes="192x192" href="/locawebstyle/assets/images/ico-painel1.png">
  <meta name="apple-mobile-web-app-title" content="Painel 1">
  <!--<script src="../../../../assets/javascripts/libs/mediaqueries-ie.js" type="text/javascript"></script><script src="../../../../assets/javascripts/libs/html5shiv.js" type="text/javascript"></script>-->
  <script src="{{ URL::asset('javascript/jquery-3.2.1.min.js') }}" type="text/javascript"></script>
  <link href="{{ URL::asset('locawebstyles/stylesheets/locastyle.css') }}" rel="stylesheet" type="text/css" />
  </head>
  <body class="">
    <div class="ls-topbar ">
      <!-- Barra de Notificações -->
      <div class="ls-notification-topbar">
        <!-- Links de apoio -->
        <div class="ls-alerts-list">
          <!--<a href="#" id="aviso-notificacao" class="ls-ico-bell-o" data-counter="0" data-ls-module="topbarCurtain" data-target="#ls-notification-curtain"><span>Notificações</span></a>-->
          <!-- <a href="#" class="ls-ico-bullhorn" data-ls-module="topbarCurtain" data-target="#ls-help-curtain"><span>Ajuda</span></a>
          <a href="#" class="ls-ico-question" data-ls-module="topbarCurtain" data-target="#ls-feedback-curtain"><span>Sugestões</span></a>
          -->
        </div>
        <!-- Dropdown com detalhes da conta de usuário -->
        <div data-ls-module="dropdown" class="ls-dropdown ls-user-account">
          <a href="#" class="ls-ico-user">
            <!--<img src="/locawebstyle/assets/images/locastyle/avatar-example.jpg" alt="" />-->
            <span class="ls-name"> 
              @if (Auth::check())
                {{	Auth::user()->name }}
              @endif
            </span>
          </a>
          <nav class="ls-dropdown-nav ls-user-menu">
            <ul>
              @if (!Auth::check())
              <li><a href="/login">Entrar</a></li>
              @else
              <li><a href="/alterar-senha">Alterar senha</a></li>
              <li>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
                </form>
              </li>
              @endif
            </ul>
          </nav>
        </div>
        <!-- Dropdown com detalhes da conta de usuário -->
      </div>
      <!-- Barra de Notificações -->

      <span class="ls-show-sidebar ls-ico-menu"></span>
      <a href="/"  class="ls-go-prev"><span class="ls-text">Voltar ao início</span></a>

      <!-- Nome do produto/marca com sidebar -->
      <h1 class="ls-brand-name">
        <a href="http://saocarlos.ifsc.edu.br/" class="ls-ico-earth">Instituto Federal Santa Catarina<small>campus São Carlos</small></a>
      </h1>
      <!-- Nome do produto/marca sem sidebar quando for o pre-painel  -->
    </div>

    <aside class="ls-sidebar">
      <div class="ls-sidebar-inner">
        <a href="/"  class="ls-go-prev"><span class="ls-text">Voltar à lista de serviços</span></a>

        <nav class="ls-menu">
          <ul>
            <li><a href="{{ URL::route('orcamento.index') }}" class="ls-ico-stats" title="Resumo do orçamento">Orçamento</a></li>
            <li>
              <a href="#" class="ls-ico-calendar" title="Administrar informações do portal">Agenda</a>
              <ul>
                  <li><a href="{{ URL::route('agenda.index') }}" class="" title="Agenda de reservas dos laboratórios">Laboratórios</a></li>
                  <li><a href="{{ URL::route('eventos.index') }}" class="" title="Agenda de eventos previsto">Eventos</a></li>
                  <li><a href="{{ URL::route('agendaveiculos.index') }}" class="" title="Agenda de reservas dos veículos">Veículos</a></li>
              </ul>
            </li>
            <li><a href="{{ URL::route('abastecimento.index') }}" class="ls-ico-dashboard" title="Gastos com combustível dos veículos oficiais">Abastecimento de veículos</a></li>           
            <li><a href="{{ URL::route('comentario.index') }}" class="ls-ico-bullhorn" title="Deixe sua mensagem para nós">Deixe sua mensagem</a></li>
            @if (Auth::check())
            <li>
              <a href="#" class="ls-ico-cog" title="Administrar informações do portal">Administrar orçamento</a>
              <ul>
              <li><a href="/empenho">Empenhos</a></li>
              <li><a href="/empresa">Empresas</a></li>
              <li><a href="/rlib">Recursos</a></li>
              <li><a href="/natureza">Natureza</a></li>
              <li><a href="/item" title="Administração de itens que compõem um empenho">Itens</a></li>
              </ul>
            </li>
            <li>
              <a href="#" class="ls-ico-envelope" title="Administrar perguntas e assuntos relacionados">Administrar perguntas</a>
              <ul>
              <li><a href="/comentario/admin">Não respondidas</a></li>
              <li><a href="/comentario">Respondidas</a></li>
              <li><a href="/assunto">Assuntos</a></li>
              </ul>
            </li>
            <li><a href="{{ URL::route('usuario.index') }}" class="ls-ico-users" title="Administrar usuários">Usuários</a></li>
            @endif
          </ul>
        </nav>
      </div>
    </aside>
    <!--<aside class="ls-notification">
    <nav class="ls-notification-list" id="ls-notification-curtain">
    <h3 class="ls-title-2">Notificações</h3>
    <ul>
    <li class="ls-dismissable">
    <a href="#">Beatae aut qui quis id distinctio dolorem necessitatibus nostrum quia ex voluptatem</a>
    <a href="#" data-ls-module="dismiss" class="ls-ico-close ls-close-notification"></a>
    </li>
    </ul>
    <p class="ls-no-notification-message">Não há notificações.</p>
    </nav>
    </aside>-->
    <main class="ls-main">
      <div class="container-fluid">
        @yield('content')
      </div>
      <footer class="ls-footer" role="contentinfo">
        <nav class="ls-footer-menu">
          <h2 class="ls-title-footer">Links úteis</h2>
            <ul class="ls-footer-list">
            <li>
              <a href="https://chamados.ifsc.edu.br/" target="_blank" class="ls-ico-mobile" title="Acesso ao sistema de chamados do IFSC">
              <span class="visible-lg">Chamados</span>
              </a>
            </li>
            <li>
              <a href="https://intranet.ifsc.edu.br/" target="_blank" class="ls-ico-earth" title="Acesso a intranet do IFSC">
              <span class="visible-lg">Intranet</span>
              </a>
            </li>
            <li>
              <a href="https://sigaa.ifsc.edu.br/" target="_blank" class="ls-ico-screen" title="Acesso ao portal do aluno/professor">
              <span class="visible-lg">SIGAA</span>
              </a>
            </li>
            <li>
              <a href="http://webmail.ifsc.edu.br/" target="_blank" class="ls-ico-envelop" title="Acesso do webmail institucional">
              <span class="visible-lg">Webmail</span>
            </a>
            </li>
          </ul>
        </nav>
        <div class="ls-footer-info">
        <!--<<span class="last-access ls-ico-screen"><strong>Último acesso: </strong>99/99/9999 99:99:99</span>
        div class="set-ip"><strong>IP:</strong> 000.00.00.000</div>-->
        <p class="ls-copy-right">Desenvolvido por CTIC São Carlos @ 2018</p>
        </div>
      </footer>
    </main>
    <script src="{{ URL::asset('locawebstyles/javascripts/locastyle.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
      $('#error').hide();
      
      function ocultarNotificacao(id){
        var baseUrl = location.protocol+'//'+location.hostname+(location.port ? ':'+location.port: '')+'/ocultar-notificacao/'+id;
          $.get(baseUrl, function( data ) {

        });
      }
    </script>
  </body>
</html>