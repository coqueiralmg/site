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
            'contain' => ['StatusConcurso'],
            'order' => [
                'dataProva' => 'DESC'
            ]
        ];

        $opcao_paginacao = [
            'name' => 'concursos',
            'name_singular' => 'concurso',
            'predicate' => 'encontrados',
            'singular' => 'econtrado'
        ];

        $concursos = $this->paginate($t_concursos);
        $qtd_total = $t_concursos->find('all', ['conditions' => $conditions])->count();

        $informativos = $t_informativo->find('all', [
            'conditions' => [
                'Informativo.ativo' => true
            ],
            'order' => [
                'data' => 'DESC'
            ],
            'contain' => ['Concurso'],
            'limit' => 10
        ]);

        $this->set('title', "Concursos Públicos e Processos");
        $this->set('concursos', $concursos->toArray());
        $this->set('informativos', $informativos->toArray());
        $this->set('qtd_total', $qtd_total);
        $this->set('limit_pagination', $limite_paginacao);
        $this->set('opcao_paginacao', $opcao_paginacao);
    }
}
