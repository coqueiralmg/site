<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class LicitacoesController extends AppController
{
    public function index()
    {
        $conditions = array();
        $limite_paginacao = Configure::read('Pagination.limit');

        if($this->request->is('get') && count($this->request->query) > 0)
        {
            $chave = $this->request->query('chave');

            $conditions = $this->montarBusca($chave);

            $data = array();

            $data['chave'] = $chave;

            $this->request->data = $data;
        }

        $conditions['Licitacao.ativo'] = true;
        $conditions['Licitacao.antigo'] = false;

        $this->paginate = [
            'limit' => $limite_paginacao,
            'conditions' => $conditions,
            'contain' => ['Modalidade', 'StatusLicitacao'],
            'order' => [
                'dataPublicacao' => 'DESC',
                'dataSessao' => 'DESC'
            ]
        ];

        $opcao_paginacao = [
            'name' => 'licitações',
            'name_singular' => 'licitação',
            'predicate' => 'encontradas',
            'singular' => 'econtrada'
        ];

        $t_licitacoes = TableRegistry::get('Licitacao');
        $t_modalidade = TableRegistry::get('Modalidade');
        $t_assuntos = TableRegistry::get('Assunto');
        $t_status = TableRegistry::get('StatusLicitacao');

        $licitacoes = $this->paginate($t_licitacoes);
        $inicial = count($this->request->query) == 0;
        $qtd_total = $t_licitacoes->find('all', ['conditions' => $conditions])->count();
        $destaques = $populares = $anos = $modalidades = $assuntos = $status = null;

        if($inicial)
        {
            $destaques = $t_licitacoes->find('destaque', [
                'contain' => ['Modalidade', 'StatusLicitacao'],
                'order' => [
                    'dataPublicacao' => 'DESC',
                    'dataSessao' => 'DESC'
                ]
            ]);

            $populares = $t_licitacoes->find('novo', [
                'limit' => $limite_paginacao,
                'contain' => ['Modalidade', 'StatusLicitacao'],
                'conditions' => [
                    'visualizacoes >' => 0
                ],
                'order' => [
                    'visualizacoes' => 'DESC',
                    'dataPublicacao' => 'DESC',
                    'dataSessao' => 'DESC'
                ]
            ]);

            $anos = $t_licitacoes->find('novo')
                    ->select(['ano'])
                    ->group('ano')
                    ->order([
                        'ano' => 'DESC'
                    ]);

            $modalidades = $t_modalidade->find('all', [
                'conditions' => [
                    'ativo' => true
                ]
            ]);

            $assuntos = $t_assuntos->find('all', [
                'conditions' => [
                    'tipo' => 'LC'
                ],
                'order' => [
                    'descricao' => 'ASC'
                ]
            ]);

            $status = $t_status->find('all', [
                'order' => [
                    'ordem' => 'ASC'
                ]
            ]);
        }

        $this->set('title', "Licitações");
        $this->set('licitacoes', $licitacoes->toArray());
        $this->set('destaques', $destaques == null ? [] : $destaques->toArray());
        $this->set('populares', $populares == null ? [] : $populares->toArray());
        $this->set('modalidades', $modalidades == null ? [] : $modalidades->toArray());
        $this->set('assuntos', $assuntos == null ? [] : $assuntos->toArray());
        $this->set('status', $status == null ? [] : $status->toArray());
        $this->set('anos', $anos == null ? [] : $anos->toArray());
        $this->set('qtd_total', $qtd_total);
        $this->set('inicial', $inicial);
        $this->set('limit_pagination', $limite_paginacao);
        $this->set('opcao_paginacao', $opcao_paginacao);
    }

    public function antigas()
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
        $conditions['antigo'] = true;

        $this->paginate = [
            'limit' => $limite_paginacao,
            'conditions' => $conditions,
            'order' => [
                'id' => 'DESC'
            ]
        ];

        $opcao_paginacao = [
            'name' => 'licitações',
            'name_singular' => 'licitação',
            'predicate' => 'encontradas',
            'singular' => 'econtrada'
        ];

        $t_licitacoes = TableRegistry::get('Licitacao');
        $licitacoes = $this->paginate($t_licitacoes);
        $qtd_total = $t_licitacoes->find('all', ['conditions' => $conditions])->count();

        $this->set('title', "Licitações");
        $this->set('licitacoes', $licitacoes->toArray());
        $this->set('qtd_total', $qtd_total);
        $this->set('limit_pagination', $limite_paginacao);
        $this->set('opcao_paginacao', $opcao_paginacao);
    }

    public function modalidade(string $codigo)
    {
        $conditions = array();
        $data = array();
        $limite_paginacao = Configure::read('Pagination.limit');

        if($this->request->is('get') && count($this->request->query) > 0)
        {
            $chave = $this->request->query('chave');
            $assunto = $this->request->query('assunto');
            $status = $this->request->query('status');
            $ano = $this->request->query('ano');

            if($chave != null)
            {
                $conditions = $this->montarBusca($chave);
            }

            if($assunto != '')
            {
                $conditions['assunto'] = $assunto;
            }

            if($status != '')
            {
                $conditions['StatusLicitacao.id'] = $status;
            }

            if($ano != '')
            {
                $conditions['ano'] = $ano;
            }

            $data['chave'] = $chave;
            $data['assunto'] = $assunto;
            $data['status'] = $status;
            $data['ano'] = $ano;
        }

        $conditions['Licitacao.ativo'] = true;
        $conditions['Licitacao.antigo'] = false;
        $conditions['Modalidade.chave'] = $codigo;

        $data['modalidade'] = $codigo;
        $this->request->data = $data;

        $this->paginate = [
            'limit' => $limite_paginacao,
            'conditions' => $conditions,
            'contain' => ['Modalidade', 'StatusLicitacao', 'AssuntoLicitacao'],
            'fields' => $this->getFieldsSelect(),
            'order' => [
                'dataPublicacao' => 'DESC',
                'dataSessao' => 'DESC'
            ]
        ];

        $opcao_paginacao = [
            'name' => 'licitações',
            'name_singular' => 'licitação',
            'predicate' => 'encontradas',
            'singular' => 'econtrada'
        ];

        $t_licitacoes = TableRegistry::get('Licitacao');
        $t_modalidade = TableRegistry::get('Modalidade');
        $t_assuntos = TableRegistry::get('Assunto');
        $t_status = TableRegistry::get('StatusLicitacao');

        $licitacoes = $this->paginate($t_licitacoes);
        $inicial = $this->request->query('chave') == '' && $this->request->query('page') == '';

        $qtd_total = $t_licitacoes->find('all', [
            'contain' => ['Modalidade', 'StatusLicitacao', 'AssuntoLicitacao'],
            'conditions' => $conditions])->select([
                'count' => 'COUNT(DISTINCT Licitacao.id)'
            ])->first()->count;

        $destaques = $populares = $anos = $modalidades = $assuntos = $status = null;

        if($inicial)
        {
            $destaques = $t_licitacoes->find('destaque', [
                'contain' => ['Modalidade', 'StatusLicitacao'],
                'conditions' => [
                    'Modalidade.chave' => $codigo
                ],
                'order' => [
                    'dataPublicacao' => 'DESC',
                    'dataSessao' => 'DESC'
                ]
            ]);

            $populares = $t_licitacoes->find('novo', [
                'limit' => $limite_paginacao,
                'contain' => ['Modalidade', 'StatusLicitacao'],
                'conditions' => [
                    'visualizacoes >' => 0,
                    'Modalidade.chave' => $codigo
                ],
                'order' => [
                    'visualizacoes' => 'DESC',
                    'dataPublicacao' => 'DESC',
                    'dataSessao' => 'DESC'
                ]
            ]);

            $anos = $t_licitacoes->find('novo', [
                        'conditions' => [
                            'modalidade' => $codigo
                        ]
                    ])->select(['ano'])
                      ->group('ano')
                      ->order([
                            'ano' => 'DESC'
                      ]);

            $assuntos = $t_assuntos->find('all', [
                'conditions' => [
                    'tipo' => 'LC'
                ],
                'order' => [
                    'descricao' => 'ASC'
                ]
            ]);

            $status = $t_status->find('all', [
                'order' => [
                    'ordem' => 'ASC'
                ]
            ]);
        }

        $this->set('title', "Licitações");
        $this->set('licitacoes', $licitacoes->toArray());
        $this->set('destaques', $destaques == null ? [] : $destaques->toArray());
        $this->set('populares', $populares == null ? [] : $populares->toArray());
        $this->set('assuntos', $assuntos == null ? [] : $assuntos->toArray());
        $this->set('status', $status == null ? [] : $status->toArray());
        $this->set('anos', $anos == null ? [] : $anos->toArray());
        $this->set('qtd_total', $qtd_total);
        $this->set('inicial', $inicial);
        $this->set('data', $data);
        $this->set('modalidade', $codigo);
        $this->set('limit_pagination', $limite_paginacao);
        $this->set('opcao_paginacao', $opcao_paginacao);
    }

    public function assunto(int $id)
    {
        $conditions = array();
        $data = array();

        $limite_paginacao = Configure::read('Pagination.limit');

        if($this->request->is('get') && count($this->request->query) > 0)
        {
            $chave = $this->request->query('chave');
            $modalidade = $this->request->query('modalidade');
            $status = $this->request->query('status');
            $ano = $this->request->query('ano');

            if($chave != null)
            {
                $conditions = $this->montarBusca($chave);
            }

            if($modalidade != '')
            {
                $conditions['Modalidade.chave'] = $modalidade;
            }

            if($status != '')
            {
                $conditions['StatusLicitacao.id'] = $status;
            }

            if($ano != '')
            {
                $conditions['ano'] = $ano;
            }

            $data['chave'] = $chave;
            $data['modalidade'] = $modalidade;
            $data['status'] = $status;
            $data['ano'] = $ano;
        }

        $conditions['Licitacao.ativo'] = true;
        $conditions['Licitacao.antigo'] = false;
        $conditions['assunto'] = $id;

        $data['assunto'] = $id;
        $this->request->data = $data;

        $this->paginate = [
            'limit' => $limite_paginacao,
            'conditions' => $conditions,
            'contain' => ['Modalidade', 'StatusLicitacao', 'AssuntoLicitacao'],
            'fields' => $this->getFieldsSelect(),
            'order' => [
                'dataPublicacao' => 'DESC',
                'dataSessao' => 'DESC'
            ]
        ];

        $opcao_paginacao = [
            'name' => 'licitações',
            'name_singular' => 'licitação',
            'predicate' => 'encontradas',
            'singular' => 'econtrada'
        ];

        $t_licitacoes = TableRegistry::get('Licitacao');
        $t_modalidade = TableRegistry::get('Modalidade');
        $t_assuntos = TableRegistry::get('Assunto');
        $t_status = TableRegistry::get('StatusLicitacao');

        $licitacoes = $this->paginate($t_licitacoes);
        $inicial = $this->request->query('chave') == '' && $this->request->query('page') == '';
        $qtd_total = $t_licitacoes->find('all', [
            'contain' => ['Modalidade', 'StatusLicitacao', 'AssuntoLicitacao'],
            'conditions' => $conditions])->select([
                'count' => 'COUNT(DISTINCT Licitacao.id)'
            ])->first()->count;
        $destaques = $populares = $anos = $modalidades = $assuntos = $status = null;

        if($inicial)
        {
            $destaques = $t_licitacoes->find('destaque', [
                'contain' => ['Modalidade', 'StatusLicitacao', 'AssuntoLicitacao'],
                'conditions' => [
                    'assunto' => $id
                ],
                'order' => [
                    'dataPublicacao' => 'DESC',
                    'dataSessao' => 'DESC'
                ]
            ]);

            $populares = $t_licitacoes->find('novo', [
                'limit' => $limite_paginacao,
                'contain' => ['Modalidade', 'StatusLicitacao', 'AssuntoLicitacao'],
                'conditions' => [
                    'visualizacoes >' => 0,
                    'assunto' => $id
                ],
                'order' => [
                    'visualizacoes' => 'DESC',
                    'dataPublicacao' => 'DESC',
                    'dataSessao' => 'DESC'
                ]
            ]);

            $anos = $t_licitacoes->find('novo', [
                    'contain' => ['Modalidade', 'StatusLicitacao', 'AssuntoLicitacao'],
                    'conditions' => [
                        'assunto' => $id
                    ]
                  ])->select(['ano'])
                    ->group('ano')
                    ->order([
                        'ano' => 'DESC'
                    ]);

            $modalidades = $t_modalidade->find('all', [
                'conditions' => [
                    'ativo' => true
                ]
            ]);

            $status = $t_status->find('all', [
                'order' => [
                    'ordem' => 'ASC'
                ]
            ]);
        }

        $this->set('title', "Licitações");
        $this->set('licitacoes', $licitacoes->toArray());
        $this->set('destaques', $destaques == null ? [] : $destaques->toArray());
        $this->set('populares', $populares == null ? [] : $populares->toArray());
        $this->set('modalidades', $modalidades == null ? [] : $modalidades->toArray());
        $this->set('status', $status == null ? [] : $status->toArray());
        $this->set('anos', $anos == null ? [] : $anos->toArray());
        $this->set('assunto', $id);
        $this->set('qtd_total', $qtd_total);
        $this->set('inicial', $inicial);
        $this->set('data', $data);
        $this->set('limit_pagination', $limite_paginacao);
        $this->set('opcao_paginacao', $opcao_paginacao);
    }

    public function status(int $id)
    {
        $conditions = array();
        $data = array();

        $limite_paginacao = Configure::read('Pagination.limit');

        if($this->request->is('get') && count($this->request->query) > 0)
        {
            $chave = $this->request->query('chave');
            $modalidade = $this->request->query('modalidade');
            $assunto = $this->request->query('assunto');
            $ano = $this->request->query('ano');

            if($chave != null)
            {
                $conditions = $this->montarBusca($chave);
            }

            if($modalidade != '')
            {
                $conditions['Modalidade.chave'] = $modalidade;
            }

            if($assunto != '')
            {
                $conditions['assunto'] = $status;
            }

            if($ano != '')
            {
                $conditions['ano'] = $ano;
            }

            $data['chave'] = $chave;
            $data['modalidade'] = $modalidade;
            $data['assunto'] = $assunto;
            $data['ano'] = $ano;
        }

        $conditions['Licitacao.ativo'] = true;
        $conditions['Licitacao.antigo'] = false;
        $conditions['StatusLicitacao.id'] = $id;

        $data['status'] = $id;
        $this->request->data = $data;

        $this->paginate = [
            'limit' => $limite_paginacao,
            'conditions' => $conditions,
            'contain' => ['Modalidade', 'StatusLicitacao'],
            'fields' => $this->getFieldsSelect(),
            'order' => [
                'dataPublicacao' => 'DESC',
                'dataSessao' => 'DESC'
            ]
        ];

        $opcao_paginacao = [
            'name' => 'licitações',
            'name_singular' => 'licitação',
            'predicate' => 'encontradas',
            'singular' => 'econtrada'
        ];

        $t_licitacoes = TableRegistry::get('Licitacao');
        $t_modalidade = TableRegistry::get('Modalidade');
        $t_assuntos = TableRegistry::get('Assunto');
        $t_status = TableRegistry::get('StatusLicitacao');

        $licitacoes = $this->paginate($t_licitacoes);
        $inicial = $this->request->query('chave') == '' && $this->request->query('page') == '';
        $qtd_total = $t_licitacoes->find('all', [
            'contain' => ['Modalidade', 'StatusLicitacao', 'AssuntoLicitacao'],
            'conditions' => $conditions])->select([
                'count' => 'COUNT(DISTINCT Licitacao.id)'
            ])->first()->count;

        $destaques = $populares = $anos = $modalidades = $assuntos = $status = null;

        if($inicial)
        {
            $destaques = $t_licitacoes->find('destaque', [
                'contain' => ['Modalidade', 'StatusLicitacao', 'AssuntoLicitacao'],
                'conditions' => [
                    'StatusLicitacao.id' => $id
                ],
                'order' => [
                    'dataPublicacao' => 'DESC',
                    'dataSessao' => 'DESC'
                ]
            ]);

            $populares = $t_licitacoes->find('novo', [
                'limit' => $limite_paginacao,
                'contain' => ['Modalidade', 'StatusLicitacao'],
                'conditions' => [
                    'visualizacoes >' => 0,
                    'StatusLicitacao.id' => $id
                ],
                'order' => [
                    'visualizacoes' => 'DESC',
                    'dataPublicacao' => 'DESC',
                    'dataSessao' => 'DESC'
                ]
            ]);

            $anos = $t_licitacoes->find('novo', [
                'contain' => ['Modalidade', 'StatusLicitacao'],
                'conditions' => [
                    'StatusLicitacao.id' => $id
                ]
            ])->select(['ano'])
                ->group('ano')
                ->order([
                    'ano' => 'DESC'
                ]);

            $modalidades = $t_modalidade->find('all', [
                'conditions' => [
                    'ativo' => true
                ]
            ]);

            $assuntos = $t_assuntos->find('all', [
                'conditions' => [
                    'tipo' => 'LC'
                ],
                'order' => [
                    'descricao' => 'ASC'
                ]
            ]);
        }

        $this->set('title', "Licitações");
        $this->set('licitacoes', $licitacoes->toArray());
        $this->set('destaques', $destaques == null ? [] : $destaques->toArray());
        $this->set('populares', $populares == null ? [] : $populares->toArray());
        $this->set('modalidades', $modalidades == null ? [] : $modalidades->toArray());
        $this->set('assuntos', $assuntos == null ? [] : $assuntos->toArray());
        $this->set('anos', $anos == null ? [] : $anos->toArray());
        $this->set('status', $id);
        $this->set('data', $data);
        $this->set('qtd_total', $qtd_total);
        $this->set('inicial', $inicial);
        $this->set('limit_pagination', $limite_paginacao);
        $this->set('opcao_paginacao', $opcao_paginacao);
    }

    public function ano(int $ano)
    {
        $conditions = array();
        $data = array();

        $limite_paginacao = Configure::read('Pagination.limit');

        if($this->request->is('get') && count($this->request->query) > 0)
        {
            $chave = $this->request->query('chave');
            $modalidade = $this->request->query('modalidade');
            $assunto = $this->request->query('assunto');
            $status = $this->request->query('status');

            if($chave != null)
            {
                $conditions = $this->montarBusca($chave);
            }

            $data['chave'] = $chave;
            $data['modalidade'] = $modalidade;
            $data['assunto'] = $assunto;
            $data['status'] = $status;
        }

        $conditions['Licitacao.ativo'] = true;
        $conditions['Licitacao.antigo'] = false;
        $conditions['Licitacao.ano'] = $ano;

        $data['ano'] = $ano;

        $this->request->data = $data;

        $this->paginate = [
            'limit' => $limite_paginacao,
            'conditions' => $conditions,
            'contain' => ['Modalidade', 'StatusLicitacao', 'AssuntoLicitacao'],
            'fields' => $this->getFieldsSelect(),
            'order' => [
                'dataPublicacao' => 'DESC',
                'dataSessao' => 'DESC'
            ]
        ];

        $opcao_paginacao = [
            'name' => 'licitações',
            'name_singular' => 'licitação',
            'predicate' => 'encontradas',
            'singular' => 'econtrada'
        ];

        $t_licitacoes = TableRegistry::get('Licitacao');
        $t_modalidade = TableRegistry::get('Modalidade');
        $t_assuntos = TableRegistry::get('Assunto');
        $t_status = TableRegistry::get('StatusLicitacao');

        $licitacoes = $this->paginate($t_licitacoes);
        $inicial = $this->request->query('chave') == '' && $this->request->query('page') == '';

        $qtd_total = $t_licitacoes->find('all', [
            'contain' => ['Modalidade', 'StatusLicitacao', 'AssuntoLicitacao'],
            'conditions' => $conditions])->select([
                'count' => 'COUNT(DISTINCT Licitacao.id)'
            ])->first()->count;

        $destaques = $populares = $anos = $modalidades = $assuntos = $status = null;

        if($inicial)
        {
            $destaques = $t_licitacoes->find('destaque', [
                'contain' => ['Modalidade', 'StatusLicitacao'],
                'conditions' => [
                    'ano' => $ano
                ],
                'order' => [
                    'dataPublicacao' => 'DESC',
                    'dataSessao' => 'DESC'
                ]
            ]);

            $populares = $t_licitacoes->find('novo', [
                'limit' => $limite_paginacao,
                'contain' => ['Modalidade', 'StatusLicitacao'],
                'conditions' => [
                    'visualizacoes >' => 0,
                    'ano' => $ano
                ],
                'order' => [
                    'visualizacoes' => 'DESC',
                    'dataPublicacao' => 'DESC',
                    'dataSessao' => 'DESC'
                ]
            ]);

            $modalidades = $t_modalidade->find('all', [
                'conditions' => [
                    'ativo' => true
                ]
            ]);

            $assuntos = $t_assuntos->find('all', [
                'conditions' => [
                    'tipo' => 'LC'
                ],
                'order' => [
                    'descricao' => 'ASC'
                ]
            ]);

            $status = $t_status->find('all', [
                'order' => [
                    'ordem' => 'ASC'
                ]
            ]);
        }

        $this->set('title', "Licitações");
        $this->set('licitacoes', $licitacoes->toArray());
        $this->set('destaques', $destaques == null ? [] : $destaques->toArray());
        $this->set('populares', $populares == null ? [] : $populares->toArray());
        $this->set('modalidades', $modalidades == null ? [] : $modalidades->toArray());
        $this->set('assuntos', $assuntos == null ? [] : $assuntos->toArray());
        $this->set('status', $status == null ? [] : $status->toArray());
        $this->set('ano', $ano);
        $this->set('data', $data);
        $this->set('qtd_total', $qtd_total);
        $this->set('inicial', $inicial);
        $this->set('limit_pagination', $limite_paginacao);
        $this->set('opcao_paginacao', $opcao_paginacao);
    }

    public function licitacao(string $slug)
    {
        $gate = explode('-', $slug);
        $id = end($gate);

        $t_licitacoes = TableRegistry::get('Licitacao');
        $licitacao = $t_licitacoes->get($id);

        $this->set('title', $licitacao->titulo);
        $this->set('licitacao', $licitacao);
    }

    private function montarBusca(string $chave)
    {
        $conditions = [];

        if(is_numeric($chave))
        {
            $conditions['numprocesso'] = $chave;
        }
        elseif(strstr($chave, '/'))
        {
            $processo = false;
            $pivot = explode('/', $chave);
            $numero = $pivot[0];
            $ano = $pivot[1];

            if(count($pivot) == 2)
            {
                if(is_numeric($numero))
                {
                    $numero = intval($numero);
                    $processo = true;
                }

                if(is_numeric($ano))
                {
                    if(strlen($ano) == 2)
                    {
                        $ano = intval($ano);
                        $ano = $ano + 2000;
                        $processo = true;
                    }
                    elseif(strlen($ano) == 4)
                    {
                        $ano = intval($ano);
                        $processo = true;
                    }
                }
            }

            if($processo)
            {
                $conditions['numprocesso'] = $numero;
                $conditions['ano'] = $ano;
            }
            else
            {
                $conditions['titulo LIKE'] = '%' . $chave . '%';
            }

        }
        else
        {
            $conditions['titulo LIKE'] = '%' . $chave . '%';
        }

        return $conditions;
    }

    private function getFieldsSelect()
    {
        return [
                'DISTINCT Licitacao.id',
                'Licitacao.numprocesso',
                'Licitacao.nummodalidade',
                'Licitacao.numdocumento',
                'Licitacao.ano',
                'Licitacao.titulo',
                'Licitacao.documento',
                'Licitacao.descricao',
                'Licitacao.modalidade',
                'Licitacao.dataInicio',
                'Licitacao.dataTermino',
                'Licitacao.dataPublicacao',
                'Licitacao.dataSessao',
                'Licitacao.dataAtualizacao',
                'Licitacao.status',
                'Licitacao.edital',
                'Licitacao.visualizacoes',
                'Licitacao.destaque',
                'Licitacao.retificado',
                'Licitacao.ativo',
                'Licitacao.antigo',
                'Modalidade.chave',
                'Modalidade.nome',
                'Modalidade.ordem',
                'Modalidade.ativo',
                'StatusLicitacao.id',
                'StatusLicitacao.nome',
                'StatusLicitacao.ordem',
                'StatusLicitacao.padrao'];
    }
}
