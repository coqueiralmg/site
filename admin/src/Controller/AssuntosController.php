<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use \Exception;

class AssuntosController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->validationRole = false;
    }

    public function list()
    {
        if ($this->request->is('post'))
        {
            $chave = $this->request->getData('chave');
            $tipo = $this->request->getData('tipo');

            $t_assuntos = TableRegistry::get('Assunto');

            $assuntos = $t_assuntos->find('all', [
                'conditions' => [
                    'descricao LIKE' => '%' . $chave . '%',
                    'tipo' => $tipo
                ],
                'order' => [
                    'descricao' => 'ASC'
                ]
            ]);

            $this->set([
                'assuntos' => $assuntos->toArray(),
                '_serialize' => ['assuntos']
            ]);
        }
    }
}
