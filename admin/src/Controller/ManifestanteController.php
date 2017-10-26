<?php

namespace App\Controller;

use Cake\ORM\TableRegistry;

class ManifestanteController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->validationRole = false;
    }

    public function get(int $id)
    {
        $t_manifestante = TableRegistry::get('Manifestante');
        $manifestante = $t_manifestante->get($id);
        
        $this->set([
            'manifestante' => $manifestante,
            '_serialize' => ['manifestante']
        ]);
    }
}