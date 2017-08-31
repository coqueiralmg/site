<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;


class SecretariaController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }

    public function index(string $slug)
    {
        $t_secretarias = TableRegistry::get('Secretaria');

        $gate = explode('-', $slug);
        $id = end($gate);

        $secretaria = $t_secretarias->get($id);
        
        $this->set('title', $secretaria->nome);
        $this->set('secretaria', $secretaria);
    }
}