<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;


class GruposController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $t_grupos = TableRegistry::get('GrupoUsuario');
        $limite_paginacao = Configure::read('limitPagination');

        $this->paginate = [
            'limit' => $limite_paginacao
        ];

        $grupos = $this->paginate($t_grupos);
        $qtd_total = $t_grupos->find('all')->count();
        
        $this->set('title', 'Lista de Grupos Usuários');
        $this->set('icon', 'group_work');
        $this->set('grupos', $grupos);
        $this->set('qtd_total', $qtd_total);
        $this->set('limit_pagination', $limite_paginacao);
    }

    public function imprimir()
    {
        $t_grupos = TableRegistry::get('GrupoUsuario');
        $grupos = $t_grupos->find('all');
        $qtd_total = $grupos->count();

        $this->viewBuilder()->layout('print');

        $this->set('title', 'Lista de Grupos Usuários');
        $this->set('grupos', $grupos);
        $this->set('qtd_total', $qtd_total);
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
        $title = ($id > 0) ? 'Edição do Grupo' : 'Novo Grupo';
        $icon = ($id > 0) ? 'group' : 'group_add';

        $this->set('title', $title);
        $this->set('icon', $icon);
    }

}