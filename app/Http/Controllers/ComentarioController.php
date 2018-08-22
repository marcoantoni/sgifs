<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Html\FormFacade;
use Illuminate\Html\HtmlFacade;
use Illuminate\Support\Facades\Auth;
use App\Assunto;
use App\Comentario;
use App\Setor;
use App\PermissaoUsuario;
use Illuminate\Support\Facades\Hash;


class ComentarioController extends Controller {
    
    protected $msgSemPermissao = "Você não tem permissão para fazer isso";
    protected $nivelPermissaoRequerida = 3;

    public function index() {
        //return Hash::make('123456'); 
        // 1 - buscar comentários públicos, respondidos e de todos os setores 
        $comentarios = Comentario::getComentarios(1, 1, 0);   
        $pgtitulo = "Perguntas frequentes";
        return view('comentario.index')->with(['comentarios' => $comentarios, 'pgtitulo' => $pgtitulo]);
    }

    public function indexAdmin() {
        
        $temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

        if (!Auth::check()) {
            return redirect('login');
        } else if (!$temPermissao) {
          return $this->msgSemPermissao;
        }

        $id_setor_user = Auth::user()->id_setor; 

        // 0 - buscar comentários não respondidos do setor do usuário logado
        $comentarios = Comentario::getComentarios(2, 0, $id_setor_user);   
        $pgtitulo = "Interface de administração";
        return view('comentario.indexadmin')->with(['comentarios' => $comentarios, 'pgtitulo' => $pgtitulo]);
    }

    public function create() {
    
       // $assuntos = Assunto::getAll(0);
        $setores = Setor::get();
        return view('comentario.create')->with(['setores' => $setores, 'pgtitulo' => 'Deixe sua dúvida ou sugestão']);
    }

   
    public function store(Request $request) {

        $comentario = new Comentario();
        $comentario->nome = $request->input('nome');
        $comentario->email = $request->input('email');
        $comentario->telefone = $request->input('telefone');
        $comentario->id_setor = $request->input('id_setor');
        $comentario->id_assunto = $request->input('id_assunto');
        $comentario->texto = $request->input('texto');
        $comentario->responder = $request->input('responder');
        $comentario->cpublica = $request->input('cpublica');

        // upload do arquivo
        if ($request->hasFile('arquivo')) {
            $nome = date('hsdmY') . $request->file('arquivo')->getClientOriginalName();
            $upload = $request->file('arquivo')->storeAs('comentarios', $nome);
            $comentario->arquivo = $nome;
        }
        
        try {
            $comentario->save();
            return redirect('comentario')->with('sucess', 'Sua mensagem foi enviada com sucesso!');
        } catch (\Illuminate\Database\QueryException $ex) {
            return back()->withInput()->with('error', 'Verifique os campos Setor e Assunto estão selecionados! <br/>Erro: ' . $ex->getMessage());
        }
        
    }

    public function show($id) {
        //
    }

    public function edit($id) {
       
        $temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

        if (!Auth::check()) {
            return redirect('login');
        } else if (!$temPermissao) {
            return redirect('comentario')->with(['error' => $this->msgSemPermissao]);
        }
        
        // retorna apenas o comentário caso ele pertença ao mesmo setor que o usuário logado
        $comentario = Comentario::find($id);

        if ($comentario->id_setor != Auth::user()->id_setor) {
            return redirect('comentario')->with(['error' => "Essa mensagem não pertence ao seu setor!"]);
        }

        $assuntos = Assunto::get();
        $setores = Setor::get();
        return view('comentario.edit')->with(['comentario' => $comentario, 'assuntos' => $assuntos, 'setores' => $setores, 'pgtitulo' => 'Respondendo dúvida ou suguestão']);
    }

    public function update(Request $request, $id) {
       
        $temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

        if (!Auth::check()) {
            return redirect('login');
        } else if (!$temPermissao) {
          return $this->msgSemPermissao;
        }

        $comentario = Comentario::find($id);
        $log = Auth::user()->name . ' fez as seguintes alterações em ' . date('d/m/Y H:m');
        
        if ($comentario->id_setor != $request->input('id_setor')){
            $log = $log . '<br/>alterou o assunto;';
            $comentario->id_setor = $request->input('id_setor');
        }


        if ($comentario->id_assunto != $request->input('id_assunto')){
            $log = $log . '<br/>alterou o assunto;';
            $comentario->id_assunto = $request->input('id_assunto');
        }

        if ($request->input('respondido') == 1){
           $log = $log . '<br/>marcou a questão como respondida;';
           $comentario->respondido = $request->input('respondido');
        }

        $comentario->id_setor = $request->input('id_setor');
        $comentario->id_assunto = $request->input('id_assunto');
        $comentario->resposta = $request->input('resposta');

        // upload do arquivo
        if ($request->hasFile('arquivo')) {
            $nome = date('hsdmY') . $request->file('arquivo')->getClientOriginalName();
            $upload = $request->file('arquivo')->storeAs('comentario', $nome);
            $comentario->arquivo = $nome;
        }
        
        $comentario->log = $comentario->log . '<br/>' . $log;
        
        try {
            $comentario->save();
            return redirect('comentario/admin')->with('sucess', 'Mensagem alterada com sucesso!');
        } catch (\Illuminate\Database\QueryException $ex) {
            return back()->withInput()->with('error', 'Verifique se todos os campos estão preenchidos corretamente! <br/>Erro: ' . $ex->getMessage());
        }

    }

    public function destroy($id) {
        //
    }

}
