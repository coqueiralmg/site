<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;


class UsuariosController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $this->set('title', 'Lista de Usuários');
        $this->set('icon', 'person');
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
        $title = ($id > 0) ? 'Edição de Usuário' : 'Novo Usuário';
        $icon = ($id > 0) ? 'person_outline' : 'person_add';

        $this->set('title', $title);
        $this->set('icon', $icon);
    }
}