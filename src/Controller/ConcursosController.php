<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class ConcursosController extends AppController
{
    public function index()
    {
        $t_concursos = TableRegistry::get('Concurso');
        $t_informativo = TableRegistry::get('Informativo');
        $limite_paginacao = Configure::read('Pagination.limit');

        $conditions = array();

        if($this->request->is('get') && count($this->request->query) > 0)
        {
            $chave = $this->request->query('chave');

            $conditions['titulo LIKE'] = '%' . $chave . '%';

            $data = array();

            $data['chave'] = $chave;

            $this->request->data = $data;
        }

        $conditions['ativo'] = true;

        $this->paginate = [
            'limit' => $limite_paginacao,
            'conditions' => $conditions,
            'order' => [
                'dataProva' => 'DESC'
            ]
        ];
    }
}
