<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Html\FormFacade;
use Illuminate\Html\HtmlFacade;
use Illuminate\Support\Facades\Auth;

use App\Notificacao;
use App\Setor;
use App\User;
use App\Permissao;
use App\PermissaoUsuario;


class UsuarioController extends Controller {
    
    protected $nivelPermissaoRequerida = 4;
    protected $msgSemPermissao = "Você não tem permissão para fazer isso";

    public function index() {
        
        $temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

        if (!Auth::check()) {
            return redirect('login');
        } else if (!$temPermissao) {
            return redirect('orcamento')->with(['error' => $this->msgSemPermissao]);
        }

        $usuarios = User::orderBy("name", "ASC")->get();
        $pgtitulo = "Lista de usuários";
        return view('usuario.index')->with(['usuarios' => $usuarios, 'pgtitulo' => $pgtitulo]);
    }

    public function create() {
        
        $temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

        if (!Auth::check()) {
            return redirect('login');
        } else if (!$temPermissao) {
            return redirect('orcamento')->with(['error' => $this->msgSemPermissao]);
        }

        $setores = Setor::get();
        return view('usuario.create')->with(['setores' => $setores, 'pgtitulo' => 'Criando novo usuário']);
    }

   
    public function store(Request $request) {
        
        $temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

        if (!Auth::check()) {
            return redirect('login');
        } else if (!$temPermissao) {
            return redirect('orcamento')->with(['error' => $this->msgSemPermissao]);
        }

        $usuario = new User();
        $usuario->name = $request->input('name');
        $usuario->password = bcrypt($request->input('password'));
        $usuario->email = $request->input('email');
        $usuario->id_setor = $request->input('id_setor');
        
        $usuario->save();

        return redirect('orcamento'); 
    }

    public function show($id) {
        //
    }

    public function edit($id) {
       
        if (! Auth::check()) {
            return redirect('login');
        }

        $setores = Setor::get();
        $permissoes = Permissao::get();

        $usuario = User::find($id);
        return view('usuario.edit')->with(['usuario' => $usuario, 'permissoes' => $permissoes, 'setores' => $setores, 'pgtitulo' => 'Editando usuário']);

    }

    public function alterarSenha(Request $request) {
       
        if (! Auth::check()) {
            return redirect('login');
        }

        if ($request->isMethod('get')) {
            $usuario = User::find(Auth::User()->id);
            return view('usuario.alterarsenha')->with(['usuario' => $usuario, 'pgtitulo' => 'Alterando a senha']);
        }

        if ($request->isMethod('patch')) {

            $usuario = User::find(Auth::User()->id);

            if ($request->input('password') == $request->input('password_confirmation')) {
                $usuario->password = bcrypt($request->input('password'));
                $usuario->save();
            }
        
        }
        return redirect('/');  
    }

    public function update(Request $request, $id) {
       
        if (! Auth::check()) {
            return redirect('login');
        }

        $usuario = User::find($id);

        if ($request->input('id_setor'))
            $usuario->id_setor = $request->input('id_setor');

        $usuario->telefone = $request->input('telefone');

        if (!empty($request->input('password'))) {
            if ($request->input('password') ==  $request->input('password_confirmation'))
                $usuario->password = bcrypt($request->input('password'));
            else
                return back()->withInput()->with('error', 'Senhas não são iguais <br/>');
        }

        $usuario->save();

        // armazenando as permissões
        // busca as permissões no banco de dados
        $permissoes = Permissao::get();
       
        // percorre o array de permissões do banco de dados
        foreach ($permissoes AS $a) {

            // teste se o campo cujo name é igual ao nível da permissão no banco de dados
            // caso seja igual 
            if($request->input($a->nivel) == 's'){
                
                // busca se o usuário já tem essa permissão concedida
                $temPermissao = PermissaoUsuario::getPermissoes($id, $a->nivel);

                // se não tem, insere a permissão na tabela permissao_usuarios
                if (!$temPermissao){
                    $permissao = new PermissaoUsuario();
                    $permissao->id_user = $id;
                    $permissao->id_permissao = $a->id;
                    $permissao->save();
                }
                // se não tiver a permissão for Não, tenta apagar do banco de dados a linha correspondente
            } else if($request->input($a->nivel) == 'n') {
                PermissaoUsuario::setPermissoes($id, $a->id);
            }
        }

        return redirect('usuario')->with(['success' => 'Alteração feita com sucesso!']);
    }

    public function destroy($id) {
        //
    }

    public function ocultarNotificacao($id){
        $notificacao = Notificacao::find($id);
        if ($notificacao->id_user == Auth::User()->id) {
            $notificacao->lida = 1;
            $notificacao->save();
            return 1;
        } else {
            return 0;
        }
    }

}
