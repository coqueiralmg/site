<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;


class SecretariasController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $t_secretarias = TableRegistry::get('Secretaria');
        $limite_paginacao = Configure::read('Pagination.limit');
        
        $this->paginate = [
            'limit' => $limite_paginacao
        ];

        $opcao_paginacao = [
            'name' => 'secretarias',
            'name_singular' => 'secretaria',
            'predicate' => 'encontradas',
            'singular' => 'encontrada'
        ];

        $secretarias = $this->paginate($t_secretarias);
        $qtd_total = $t_secretarias->find('all')->count();
        
        $this->set('title', 'Secretarias');
        $this->set('icon', 'business_center');
        $this->set('secretarias', $secretarias);
        $this->set('qtd_total', $qtd_total);
        $this->set('limit_pagination', $limite_paginacao);
        $this->set('opcao_paginacao', $opcao_paginacao);
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
        $title = ($id > 0) ? 'Edição da Secretaria' : 'Nova Secretaria';
        $icon = ($id > 0) ? 'business_center' : 'business_center';

        $this->set('title', $title);
        $this->set('icon', $icon);
    }

}