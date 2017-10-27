<?php

namespace App\Controller;

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

    public function aceitar()
    {
        if ($this->request->is('post'))
        {
            $t_manifestacao = TableRegistry::get('Manifestacao');

            $id = $this->request->getData('id');

            $manifestacao = $t_manifestacao->get($id);
            $manifestacao->status = Configure::read('Ouvidoria.status.definicoes.aceito');
            
            $t_manifestacao->save($manifestacao);
        }
    }

    public function recusar()
    {
        if ($this->request->is('post'))
        {
            $t_manifestacao = TableRegistry::get('Manifestacao');

            $id = $this->request->getData('id');
            $justificativa = $this->request->getData('justificativa');
        
        }
    }
}