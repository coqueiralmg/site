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

    public function ban()
    {
        if ($this->request->is('post'))
        {
            $id = $this->request->getData('id');
            
            $t_manifestante = TableRegistry::get('Manifestante');
            $manifestante = $t_manifestante->get($id);

            $manifestante->bloqueado = true;

            $t_manifestante->save($manifestante);

            $this->set([
                'sucesso' => true,
                'manifestante' => $manifestante,
                '_serialize' => ['sucesso', 'manifestante']
            ]);
        }
    }

    public function release()
    {
        if ($this->request->is('post'))
        {
            $id = $this->request->getData('id');
            
            $t_manifestante = TableRegistry::get('Manifestante');
            $manifestante = $t_manifestante->get($id);

            $manifestante->bloqueado = false;

            $t_manifestante->save($manifestante);

            $this->set([
                'sucesso' => true,
                'manifestante' => $manifestante,
                '_serialize' => ['sucesso', 'manifestante']
            ]);
        }
    }
}