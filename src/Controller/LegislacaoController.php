<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class LegislacaoController extends AppController
{
    public function index()
    {
        $conditions = array();
        $limite_paginacao = Configure::read('Pagination.limit');

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
                'data' => 'DESC'
            ]
        ];

        $t_legislacao = TableRegistry::get('Legislacao');
        $t_tipo_legislacao = TableRegistry::get('TipoLegislacao');
        $t_assuntos = TableRegistry::get('Assunto');

        $legislacao = $this->paginate($t_legislacao);
        $inicial = count($this->request->query) == 0;
        $qtd_total = $t_legislacao->find('all', ['conditions' => $conditions])->count();

        $destaques = null;
        $anos = null;
        $tipos_legislacao = null;
        $assuntos = null;

        if($inicial)
        {
            $destaques = $t_legislacao->find('destaque', [
                'order' => [
                    'data' => 'DESC'
                ]
            ]);

            $anos = $t_legislacao->find('ativo');
            $anos->select([
                'ano' => $anos->func()->year(['data' => 'identifier'])
            ])->group('ano')->order([
                'ano' => 'DESC'
            ]);

            $tipos_legislacao = $t_tipo_legislacao->find('all', [
                'conditions' => [
                    'ativo' => true
            ]]);

            $assuntos = $t_assuntos->find('all', [
                'conditions' => [
                    'tipo' => 'LG'
                ],
                'order' => [
                    'descricao' => 'ASC'
                ]
            ]);
        }

        $this->set('title', "Legislação");
        $this->set('legislacao', $legislacao->toArray());
        $this->set('destaques', $destaques == null ? [] : $destaques->toArray());
        $this->set('tipos_legislacao', $tipos_legislacao == null ? [] : $tipos_legislacao->toArray());
        $this->set('assuntos', $assuntos == null ? [] : $assuntos->toArray());
        $this->set('anos', $anos == null ? [] : $anos->toArray());
        $this->set('inicial', $inicial);
        $this->set('qtd_total', $qtd_total);
        $this->set('limit_pagination', $limite_paginacao);
    }

    public function tipo(int $id)
    {
        $conditions = array();
        $limite_paginacao = Configure::read('Pagination.limit');

        if($this->request->is('get') && count($this->request->query) > 0)
        {
            $chave = $this->request->query('chave');

            $conditions['titulo LIKE'] = '%' . $chave . '%';

            $data = array();

            $data['chave'] = $chave;

            $this->request->data = $data;
        }

        $conditions['ativo'] = true;
        $conditions['tipo'] = $id;

        $this->paginate = [
            'limit' => $limite_paginacao,
            'conditions' => $conditions,
            'order' => [
                'data' => 'DESC'
            ]
        ];

        $t_legislacao = TableRegistry::get('Legislacao');
        $t_tipo_legislacao = TableRegistry::get('TipoLegislacao');
        $t_assuntos = TableRegistry::get('Assunto');

        $legislacao = $this->paginate($t_legislacao);
        $inicial = count($this->request->query) == 0;
        $qtd_total = $t_legislacao->find('all', ['conditions' => $conditions])->count();
        $tipo_legislacao = $t_tipo_legislacao->get($id);

        $destaques = null;
        $anos = null;
        $assuntos = null;

        if($inicial)
        {
            $destaques = $t_legislacao->find('destaque', [
                'conditions' => [
                    'tipo' => $id
                ],
                'order' => [
                    'data' => 'DESC'
                ]
            ]);

            $anos = $t_legislacao->find('ativo', [
                'conditions' => [
                    'tipo' => $id
                ]
            ]);
            $anos->select([
                'ano' => $anos->func()->year(['data' => 'identifier'])
            ])->group('ano')->order([
                'ano' => 'DESC'
            ]);

            $assuntos = $t_assuntos->find('all', [
                'conditions' => [
                    'tipo' => 'LG'
                ],
                'order' => [
                    'descricao' => 'ASC'
                ]
            ]);
        }

        $this->set('title', "Legislação");
        $this->set('legislacao', $legislacao->toArray());
        $this->set('destaques', $destaques == null ? [] : $destaques->toArray());
        $this->set('tipo_legislacao', $tipo_legislacao);
        $this->set('assuntos', $assuntos == null ? [] : $assuntos->toArray());
        $this->set('anos', $anos == null ? [] : $anos->toArray());
        $this->set('inicial', $inicial);
        $this->set('qtd_total', $qtd_total);
        $this->set('limit_pagination', $limite_paginacao);
    }

    public function assunto(int $id)
    {
        $conditions = array();
        $limite_paginacao = Configure::read('Pagination.limit');

        if($this->request->is('get') && count($this->request->query) > 0)
        {
            $chave = $this->request->query('chave');

            $conditions['titulo LIKE'] = '%' . $chave . '%';

            $data = array();

            $data['chave'] = $chave;

            $this->request->data = $data;
        }

        $conditions['ativo'] = true;
        $conditions['assunto'] = $id;

        $this->paginate = [
            'limit' => $limite_paginacao,
            'conditions' => $conditions,
            'contain' => ['AssuntoLegislacao'],
            'order' => [
                'data' => 'DESC'
            ]
        ];

        $t_legislacao = TableRegistry::get('Legislacao');
        $t_tipo_legislacao = TableRegistry::get('TipoLegislacao');
        $t_assuntos = TableRegistry::get('Assunto');

        $legislacao = $this->paginate($t_legislacao);
        $inicial = count($this->request->query) == 0;
        $qtd_total = $t_legislacao->find('all', ['contain' => ['AssuntoLegislacao'], 'conditions' => $conditions])->count();
        $assunto = $t_assuntos->get($id);

        $destaques = null;
        $anos = null;
        $tipos_legislacao = null;
        $assuntos = null;

        if($inicial)
        {
            $destaques = $t_legislacao->find('destaque', [
                'contain' => ['AssuntoLegislacao'],
                'conditions' => [
                    'assunto' => $id
                ],
                'order' => [
                    'data' => 'DESC'
                ]
            ]);

            $anos = $t_legislacao->find('ativo');
            $anos->select([
                'ano' => $anos->func()->year(['data' => 'identifier'])
            ])->group('ano')->order([
                'ano' => 'DESC'
            ]);

            $tipos_legislacao = $t_tipo_legislacao->find('all', [
                'conditions' => [
                    'ativo' => true
            ]]);
        }

        $this->set('title', "Legislação");
        $this->set('legislacao', $legislacao->toArray());
        $this->set('destaques', $destaques == null ? [] : $destaques->toArray());
        $this->set('tipos_legislacao', $tipos_legislacao == null ? [] : $tipos_legislacao->toArray());
        $this->set('assunto', $assunto);
        $this->set('anos', $anos == null ? [] : $anos->toArray());
        $this->set('inicial', $inicial);
        $this->set('qtd_total', $qtd_total);
        $this->set('limit_pagination', $limite_paginacao);
    }

    public function ano(int $ano)
    {
        $conditions = array();
        $limite_paginacao = Configure::read('Pagination.limit');

        if($this->request->is('get') && count($this->request->query) > 0)
        {
            $chave = $this->request->query('chave');

            $conditions['titulo LIKE'] = '%' . $chave . '%';

            $data = array();

            $data['chave'] = $chave;

            $this->request->data = $data;
        }

        $conditions['ativo'] = true;
        $conditions['year(data)'] = $ano;

        $this->paginate = [
            'limit' => $limite_paginacao,
            'conditions' => $conditions,
            'order' => [
                'data' => 'DESC'
            ]
        ];

        $t_legislacao = TableRegistry::get('Legislacao');
        $t_tipo_legislacao = TableRegistry::get('TipoLegislacao');
        $t_assuntos = TableRegistry::get('Assunto');

        $legislacao = $this->paginate($t_legislacao);
        $inicial = count($this->request->query) == 0;
        $qtd_total = $t_legislacao->find('all', ['conditions' => $conditions])->count();

        $destaques = null;
        $anos = null;
        $tipos_legislacao = null;
        $assuntos = null;

        if($inicial)
        {
            $destaques = $t_legislacao->find('destaque', [
                'conditions' => [
                    'year(data)' => $ano
                ],
                'order' => [
                    'data' => 'DESC'
                ]
            ]);

            $tipos_legislacao = $t_tipo_legislacao->find('all', [
                'conditions' => [
                    'ativo' => true
            ]]);

            $assuntos = $t_assuntos->find('all', [
                'conditions' => [
                    'tipo' => 'LG'
                ],
                'order' => [
                    'descricao' => 'ASC'
                ]
            ]);
        }

        $this->set('title', "Legislação");
        $this->set('legislacao', $legislacao->toArray());
        $this->set('destaques', $destaques == null ? [] : $destaques->toArray());
        $this->set('tipos_legislacao', $tipos_legislacao == null ? [] : $tipos_legislacao->toArray());
        $this->set('assuntos', $assuntos == null ? [] : $assuntos->toArray());
        $this->set('ano', $ano);
        $this->set('inicial', $inicial);
        $this->set('qtd_total', $qtd_total);
        $this->set('limit_pagination', $limite_paginacao);
    }

    public function documento(int $id)
    {
        $t_legislacao = TableRegistry::get('Legislacao');
        $legislacao = $t_legislacao->get($id);

        $this->set('title', $legislacao->titulo);
        $this->set('legislacao', $legislacao);
    }
}
