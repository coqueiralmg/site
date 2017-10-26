<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;

class ManifestacaoController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->validationRole = false;
    }

    public function get(int $id)
    {
        $t_manifestacao = TableRegistry::get('Manifestacao');
        $manifestacao = $t_manifestacao->get($id, ['contain' => ['Manifestante', 'Prioridade', 'Status']]);
        
        if ($this->request->is('ajax'))
        {
            $manifestacao->texto = str_replace("<br />", "", $manifestacao->texto);
        }

        $this->set([
            'manifestacao' => $manifestacao,
            '_serialize' => ['manifestacao']
        ]);
    }
}