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
        $data = array();
        $limite_paginacao = Configure::read('Pagination.limit');

        if($this->request->is('get') && count($this->request->query) > 0)
        {
            $chave = $this->request->query('chave');
            $ano = $this->request->query('ano');
            $assunto = $this->request->query('assunto');

            $conditions['titulo LIKE'] = '%' . $chave . '%';

            $data['chave'] = $chave;

            if($ano != '')
            {
                $conditions['year(data)'] = $ano;
                $data['ano'] = $ano;
            }

            if($assunto != '')
            {
                $conditions['assunto'] = $assunto;
                $data['assunto'] = $assunto;
            }
        }

        $data['tipo'] = $id;

        $conditions['ativo'] = true;
        $conditions['tipo'] = $id;

        $this->request->data = $data;

        $t_legislacao = TableRegistry::get('Legislacao');
        $t_tipo_legislacao = TableRegistry::get('TipoLegislacao');
        $t_assuntos = TableRegistry::get('Assunto');

        if(isset($data['assunto']))
        {
            $this->paginate = [
                'limit' => $limite_paginacao,
                'conditions' => $conditions,
                'contain' => ['AssuntoLegislacao'],
                'order' => [
                    'data' => 'DESC'
                ]
            ];

            $qtd_total = $t_legislacao->find('all', ['contain' => ['AssuntoLegislacao'], 'conditions' => $conditions])->count();
        }
        else
        {
            $this->paginate = [
                'limit' => $limite_paginacao,
                'conditions' => $conditions,
                'order' => [
                    'data' => 'DESC'
                ]
            ];

            $qtd_total = $t_legislacao->find('all', ['conditions' => $conditions])->count();
        }

        $legislacao = $this->paginate($t_legislacao);
        $inicial = $this->request->query('chave') == '' && $this->request->query('page') == '';

        $tipo_legislacao = $t_tipo_legislacao->get($id);

        $destaques = null;
        $anos = null;
        $assuntos = null;

        if($inicial)
        {
            $filtro = array();
            $filtro['tipo'] = $id;
            if(isset($data['ano'])) $filtro['year(data)'] = $data['ano'];
            if(isset($data['assunto'])) $filtro['assunto'] = $data['assunto'];

            if(isset($data['assunto']))
            {
                $destaques = $t_legislacao->find('destaque', [
                    'contain' => ['AssuntoLegislacao'],
                    'conditions' => $filtro,
                    'order' => [
                        'data' => 'DESC'
                    ]
                ]);

                $anos = $t_legislacao->find('ativo', [
                    'contain' => ['AssuntoLegislacao'],
                    'conditions' => $filtro
                ]);

                $anos->select([
                    'ano' => $anos->func()->year(['data' => 'identifier'])
                ])->group('ano')->order([
                    'ano' => 'DESC'
                ]);
            }
            else
            {
                $destaques = $t_legislacao->find('destaque', [
                    'conditions' => $filtro,
                    'order' => [
                        'data' => 'DESC'
                    ]
                ]);

                $anos = $t_legislacao->find('ativo', [
                    'conditions' => $filtro
                ]);

                $anos->select([
                    'ano' => $anos->func()->year(['data' => 'identifier'])
                ])->group('ano')->order([
                    'ano' => 'DESC'
                ]);
            }

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
        $this->set('data', $data);
        $this->set('limit_pagination', $limite_paginacao);
    }

    public function assunto(int $id)
    {
        $conditions = array();
        $data = array();
        $limite_paginacao = Configure::read('Pagination.limit');

        if($this->request->is('get') && count($this->request->query) > 0)
        {
            $chave = $this->request->query('chave');
            $ano = $this->request->query('ano');
            $tipo = $this->request->query('tipo');

            $conditions['titulo LIKE'] = '%' . $chave . '%';

            $data['chave'] = $chave;

            if($ano != '')
            {
                $conditions['year(data)'] = $ano;
                $data['ano'] = $ano;
            }

            if($tipo != '')
            {
                $conditions['tipo'] = $tipo;
                $data['tipo'] = $tipo;
            }
        }

        $data['assunto'] = $id;

        $conditions['ativo'] = true;
        $conditions['assunto'] = $id;

        $this->request->data = $data;

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
        $inicial = $this->request->query('chave') == '' && $this->request->query('page') == '';
        $qtd_total = $t_legislacao->find('all', ['contain' => ['AssuntoLegislacao'], 'conditions' => $conditions])->count();
        $assunto = $t_assuntos->get($id);

        $destaques = null;
        $anos = null;
        $tipos_legislacao = null;
        $assuntos = null;

        if($inicial)
        {
            $filtro = array();
            $filtro['assunto'] = $id;
            if(isset($data['ano'])) $filtro['year(data)'] = $data['ano'];
            if(isset($data['tipo'])) $filtro['tipo'] = $data['tipo'];

            $destaques = $t_legislacao->find('destaque', [
                'contain' => ['AssuntoLegislacao'],
                'conditions' => [
                    'assunto' => $id
                ],
                'order' => [
                    'data' => 'DESC'
                ]
            ]);

            $anos = $t_legislacao->find('ativo', ['contain' => ['AssuntoLegislacao'], 'conditions' => $filtro]);

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
        $this->set('data', $data);
        $this->set('limit_pagination', $limite_paginacao);
    }

    public function ano(int $ano)
    {
        $conditions = array();
        $data = array();
        $limite_paginacao = Configure::read('Pagination.limit');

        if($this->request->is('get') && count($this->request->query) > 0)
        {
            $chave = $this->request->query('chave');
            $assunto = $this->request->query('assunto');
            $tipo = $this->request->query('tipo');

            $conditions['titulo LIKE'] = '%' . $chave . '%';

            $data = array();

            $data['chave'] = $chave;

            if($assunto != '')
            {
                $conditions['assunto'] = $assunto;
                $data['assunto'] = $assunto;
            }

            if($tipo != '')
            {
                $conditions['tipo'] = $tipo;
                $data['tipo'] = $tipo;
            }
        }

        $data['ano'] = $ano;

        $conditions['ativo'] = true;
        $conditions['year(data)'] = $ano;

        $this->request->data = $data;

        $t_legislacao = TableRegistry::get('Legislacao');
        $t_tipo_legislacao = TableRegistry::get('TipoLegislacao');
        $t_assuntos = TableRegistry::get('Assunto');

        if(isset($data['assunto']))
        {
            $this->paginate = [
                'limit' => $limite_paginacao,
                'conditions' => $conditions,
                'contain' => ['AssuntoLegislacao'],
                'order' => [
                    'data' => 'DESC'
                ]
            ];

            $qtd_total = $t_legislacao->find('all', ['contain' => ['AssuntoLegislacao'], 'conditions' => $conditions])->count();
        }
        else
        {
            $this->paginate = [
                'limit' => $limite_paginacao,
                'conditions' => $conditions,
                'order' => [
                    'data' => 'DESC'
                ]
            ];

            $qtd_total = $t_legislacao->find('all', ['conditions' => $conditions])->count();
        }

        $legislacao = $this->paginate($t_legislacao);
        $inicial = $this->request->query('chave') == '' && $this->request->query('page') == '';
        $qtd_total = $t_legislacao->find('all', ['conditions' => $conditions])->count();

        $destaques = null;
        $anos = null;
        $tipos_legislacao = null;
        $assuntos = null;

        if($inicial)
        {
            $filtro = array();
            $filtro['year(data)'] = $ano;
            if(isset($data['tipo'])) $filtro['tipo'] = $data['tipo'];
            if(isset($data['assunto'])) $filtro['assunto'] = $data['assunto'];

            if(isset($data['assunto']))
            {
                $destaques = $t_legislacao->find('destaque', [
                    'contain' => ['AssuntoLegislacao'],
                    'conditions' => $filtro,
                    'order' => [
                        'data' => 'DESC'
                    ]
                ]);
            }
            else
            {
                $destaques = $t_legislacao->find('destaque', [
                    'conditions' => $filtro,
                    'order' => [
                        'data' => 'DESC'
                    ]
                ]);
            }

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
        $this->set('data', $data);
        $this->set('limit_pagination', $limite_paginacao);
    }

    public function documento(int $id)
    {
        $t_legislacao = TableRegistry::get('Legislacao');
        $legislacao = $t_legislacao->get($id, ['contain' => ['Assunto', 'TipoLegislacao', 'LegislacaoRelacionada']]);

        $this->set('title', $legislacao->titulo);
        $this->set('legislacao', $legislacao);
    }
}
