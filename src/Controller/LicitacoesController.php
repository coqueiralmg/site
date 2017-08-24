<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class LicitacoesController extends AppController
{
    public function index()
    {
        $conditions = array();
        $limite_paginacao = Configure::read('Pagination.limit');

        if($this->request->is('get') && count($this->request->query) > 0)
        {
            $chave = $this->request->query('chave');

            $conditions['titulo LIKE'] = '%' . $chave . '%';

            $data = array();

            $data['chave'] = $chave;

            $this->request->data = $data;
        }

        $this->paginate = [
            'limit' => $limite_paginacao,
            'conditions' => $conditions,
            'order' => [
                'id' => 'DESC'
            ]
        ];

        $opcao_paginacao = [
            'name' => 'licitações',
            'name_singular' => 'licitação',
            'predicate' => 'encontradas',
            'singular' => 'econtrada'
        ];

        $t_licitacoes = TableRegistry::get('Licitacao');
        $licitacoes = $this->paginate($t_licitacoes);
        $qtd_total = $t_licitacoes->find('all', ['conditions' => $conditions])->count();

        $this->set('title', "Licitações");
        $this->set('licitacoes', $licitacoes);
        $this->set('qtd_total', $qtd_total);
        $this->set('limit_pagination', $limite_paginacao);
        $this->set('opcao_paginacao', $opcao_paginacao);
    }

    public function licitacao(string $slug)
    {
        $gate = explode('-', $slug);
        $id = end($gate);
        
        $t_licitacoes = TableRegistry::get('Licitacao');
        $licitacao = $t_licitacoes->get($id);

        $this->set('title', $licitacao->titulo);
        $this->set('licitacao', $licitacao);
    }
}