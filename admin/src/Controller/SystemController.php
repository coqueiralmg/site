<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;


class SystemController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }

    public function login()
    {
        $this->viewBuilder()->layout('guest');
        $this->set('title', 'Controle de Acesso');
    }

    public function board()
    {
        $this->set('title', 'Painel Principal');
        $this->set('icon', 'dashboard');
    }
}