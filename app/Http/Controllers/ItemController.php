<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Html\FormFacade;
use Illuminate\Html\HtmlFacade;
use Illuminate\Support\Facades\Auth;
use App\Item;
use Validator;
use App\PermissaoUsuario;

class ItemController extends Controller {
    
    protected $msgSemPermissao = "Você não tem permissão para fazer isso";
    protected $nivelPermissaoRequerida = 1;

    public function index() {
       $itens = Item::orderBy('nome', 'asc')->get();
       return view('item.index')->with(['itens' => $itens, 'pgtitulo' => 'Lista de todos os itens cadastrados']);
    }

    public function create() {
      
        $temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

        if (!Auth::check()) {
            return redirect('login');
        } else if (!$temPermissao) {
            return redirect('orcamento')->with(['error' => $this->msgSemPermissao]);
        }
        

        return view('item.create')->with(['pgtitulo' => 'Adicionando novo item']);
    }

    public function store(Request $request) {
       
        $temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

        if (!Auth::check()) {
            return redirect('login');
        } else if (!$temPermissao) {
            return redirect('orcamento')->with(['error' => $this->msgSemPermissao]);
        }

        $item = new Item();

        $item->nome = $request->input('nome');
        $item->descricao = $request->input('descricao');
        $item->save();
        return redirect('item')->with(['success' => 'Item adicionado com sucesso!']); 

    }

    public function show($id) {
        //
    }

    public function edit($id) {
        
        $temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

        if (!Auth::check()) {
            return redirect('login');
        } else if (!$temPermissao) {
            return redirect('orcamento')->with(['error' => $this->msgSemPermissao]);
        }
        

        $item = Item::find($id);
        return view('item.edit')->with(['item' => $item, 'pgtitulo' => 'Editando item']);
    }

    public function update(Request $request, $id) {

        $temPermissao = PermissaoUsuario::getPermissoes(Auth::User()->id, $this->nivelPermissaoRequerida);

        if (!Auth::check()) {
            return redirect('login');
        } else if (!$temPermissao) {
            return redirect('orcamento')->with(['error' => $this->msgSemPermissao]);
        }
        
        $item = Item::find($id);
        $item->nome = $request->input('nome');
        $item->descricao = $request->input('descricao');
        $item->save();
        return redirect('item')->with(['success' => 'Item alterado com sucesso!']); 
  
    }

    public function destroy($id) {
        //
    }

}
