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

    public function concurso(string $slug)
    {
        $gate = explode('-', $slug);
        $id = end($gate);

        $t_concursos = TableRegistry::get('Concurso');
        $t_documentos = TableRegistry::get('Documento');
        $t_cargos = TableRegistry::get('Cargo');
        $t_informativo = TableRegistry::get('Informativo');

        $concurso = $t_concursos->get($id, ['contain' => 'StatusConcurso']);

        $condicoes = [
            'concurso' => $id,
            'ativo' => true
        ];

        $documentos = $t_documentos->find('all', [
            'conditions' => $condicoes,
            'order' => [
                'data' => 'DESC'
            ]
        ]);

        $informativos = $t_informativo->find('all', [
            'conditions' => $condicoes,
            'order' => [
                'data' => 'ASC'
            ]
        ]);

        $cargos = $t_cargos->find('all', [
            'conditions' => $condicoes
        ]);

        $this->set('title', $concurso->numero . ' - ' . $concurso->titulo);
        $this->set('concurso', $concurso);
        $this->set('documentos', $documentos);
        $this->set('informativos', $informativos);
        $this->set('cargos', $cargos);
    }

    public function cargo(int $id)
    {
        $t_cargos = TableRegistry::get('Cargo');
        $t_informativo = TableRegistry::get('Informativo');

        $cargo = $t_cargos->get($id, ['contain' => ['Concurso' => ['StatusConcurso']]]);
        $concurso = $cargo->concurso;

        $informativos = $t_informativo->find('all', [
            'conditions' => [
                'concurso' => $concurso->id,
                'ativo' => true
            ],
            'order' => [
                'data' => 'ASC'
            ]
        ]);

        $this->set('title', $concurso->numero . ' - ' . $concurso->titulo);
        $this->set('concurso', $concurso);
        $this->set('cargo', $cargo);
        $this->set('informativos', $informativos);
    }
}
