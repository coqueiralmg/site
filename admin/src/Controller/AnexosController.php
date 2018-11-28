<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;


class AnexosController extends AppController
{

    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Licitacoes');
    }

}
