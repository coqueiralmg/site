<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;
use \Exception;

class PublicacoesController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $t_publicacao = TableRegistry::get('Publicacao');
        $limite_paginacao = Configure::read('limitPagination');

        $condicoes = array();
        $data = array();

        if(count($this->request->getQueryParams()) > 0)
        {

        }

        $this->paginate = [
            'limit' => $limite_paginacao,
            'conditions' => $condicoes,
            'order' => [
                'data' => 'DESC'
            ]
        ];

        $opcao_paginacao = [
            'name' => 'publicações',
            'name_singular' => 'publicação'
        ];

        $publicacoes = $this->paginate($t_publicacao);

        $qtd_total = $t_publicacao->find('all', [
            'conditions' => $condicoes]
        )->count();

        $combo_mostra = ["T" => "Todos", "A" => "Somente ativos", "I" => "Somente inativos"];
        
        $this->set('title', 'Publicações');
        $this->set('icon', 'library_books');
        $this->set('combo_mostra', $combo_mostra);
        $this->set('publicacoes', $publicacoes);
        $this->set('qtd_total', $qtd_total);
        $this->set('limit_pagination', $limite_paginacao);
        $this->set('opcao_paginacao', $opcao_paginacao);
        $this->set('data', $data);
    }

    public function add()
    {
        $this->redirect(['action' => 'cadastro', 0]);
    }

    public function edit(int $id)
    {
        $this->redirect(['action' => 'cadastro', $id]);
    }

    public function cadastro(int $id)
    {
        $title = ($id > 0) ? 'Edição da Publicação' : 'Nova Publicação';
        $icon = ($id > 0) ? 'group' : 'group_add';

        $this->set('title', $title);
        $this->set('icon', $icon);
    }

}