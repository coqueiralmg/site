<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class CidadeController extends AppController
{
    public function historico()
    {
       $this->set('title', "História de Coqueiral");
    }

    public function perfil()
    {
        $this->set('title', "O Perfil do Município");
    }

    public function localizacao()
    {
        $this->set('title', "Localização da Cidade");
    }
}