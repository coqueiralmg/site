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
        $this->set('title', 'Lista de Grupos Usuários');
        $this->set('icon', 'group_work');
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