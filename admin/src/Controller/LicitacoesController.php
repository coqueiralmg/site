<?php

namespace App\Controller;

use App\Model\Table\BaseTable;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Network\Session;
use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use \Exception;
use \DateTime;
use \DOMDocument;
use \DOMXPath;

class LicitacoesController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $t_licitacoes = TableRegistry::get('Licitacao');
        $t_modalidade = TableRegistry::get('Modalidade');
        $t_assuntos = TableRegistry::get('Assunto');
        $t_status = TableRegistry::get('StatusLicitacao');

        $limite_paginacao = Configure::read('Pagination.limit');

        $condicoes = array();
        $data = array();

        if (count($this->request->getQueryParams()) > 3)
        {
            $numprocesso = $this->request->query('numprocesso');
            $titulo = $this->request->query('titulo');
            $modalidade = $this->request->query('modalidade');
            $status = $this->request->query('status');
            $data_publicacao_inicial = $this->request->query('data_publicacao_inicial');
            $data_publicacao_final = $this->request->query('data_publicacao_final');
            $data_sessao_inicial = $this->request->query('data_sessao_inicial');
            $data_sessao_final = $this->request->query('data_sessao_final');
            $formato = $this->request->query('formato');
            $mostrar = $this->request->query('mostrar');

            if($numprocesso != "")
            {
                if($formato == 'A')
                {
                    $condicoes['titulo LIKE'] = '%' . $numprocesso . '%';
                }
                else
                {
                    $pp = explode('/', $numprocesso);

                    if(count($pp) == 1)
                    {
                        $condicoes['numprocesso'] = $numprocesso;
                    }
                    elseif(count($pp) == 2)
                    {
                        $numprocesso = intval($pp[0]);
                        $ano = $pp[1];

                        $condicoes['numprocesso'] = $numprocesso;

                        if(strlen($ano) == 4)
                        {
                            $condicoes['ano'] = $ano;
                        }
                    }
                }
            }

            if($titulo != "")
            {
                $condicoes['titulo LIKE'] = '%' . $titulo . '%';
            }

            if ($modalidade != '')
            {
                $condicoes["modalidade"] = $modalidade;
            }

            if ($status != '')
            {
                $condicoes["status"] = $status;
            }

            if ($data_publicacao_inicial != "" && $data_publicacao_final != "")
            {
                $condicoes["dataPublicacao >="] = $this->Format->formatDateDB($data_publicacao_inicial);
                $condicoes["dataPublicacao <="] = $this->Format->formatDateDB($data_publicacao_final);
            }

            if ($data_sessao_inicial != "" && $data_sessao_final != "")
            {
                $condicoes["dataSessao >="] = $this->Format->formatDateDB($data_sessao_inicial);
                $condicoes["dataSessao <="] = $this->Format->formatDateDB($data_sessao_final);
            }

            if ($formato != 'T')
            {
                $condicoes["antigo"] = ($formato == "A") ? "1" : "0";
            }

            if ($mostrar != 'T')
            {
                $condicoes["ativo"] = ($mostrar == "A") ? "1" : "0";
            }

            $data['numprocesso'] = $numprocesso;
            $data['titulo'] = $titulo;
            $data['modalidade'] = $modalidade;
            $data['status'] = $status;
            $data['data_publicacao_inicial'] = $data_publicacao_inicial;
            $data['data_publicacao_final'] = $data_publicacao_final;
            $data['data_sessao_inicial'] = $data_sessao_inicial;
            $data['data_sessao_final'] = $data_sessao_final;
            $data['formato'] = $formato;
            $data['mostrar'] = $mostrar;

            $this->request->data = $data;
        }

        $this->paginate = [
            'limit' => $limite_paginacao,
            'conditions' => $condicoes,
            'order' => [
                'dataPublicacao' => 'DESC',
                'id' => 'DESC'
            ]
        ];

        $opcao_paginacao = [
            'name' => 'licitações',
            'name_singular' => 'licitação',
            'predicate' => 'encontradas',
            'singular' => 'encontrada'
        ];

        $assuntos = $t_assuntos->find('list', [
            'keyField' => 'id',
            'valueField' => 'descricao',
            'conditions' => [
                'tipo' => 'LC'
            ],
            'order' => [
                'descricao' => 'ASC'
            ]
        ]);

        $modalidades = $t_modalidade->find('list', [
            'keyField' => 'chave',
            'valueField' => 'nome',
            'conditions' => [
                'ativo' => true
            ],
            'order' => [
                'ordem' => 'ASC'
            ]
        ]);

        $status = $t_status->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome',
            'order' => [
                'ordem' => 'ASC'
            ]
        ]);

        $licitacoes = $this->paginate($t_licitacoes);

        $qtd_total = $t_licitacoes->find('all', [
            'conditions' => $condicoes
        ])->count();

        $combo_mostra = ["T" => "Todos", "A" => "Somente ativos", "I" => "Somente inativos"];
        $combo_formatos = ["T" => "Todos os formatos", "A" => "Formatos Antigos", "N" => "Formatos Novos"];

        $this->set('title', 'Licitações');
        $this->set('icon', 'work');
        $this->set('combo_mostra', $combo_mostra);
        $this->set('licitacoes', $licitacoes);
        $this->set('qtd_total', $qtd_total);
        $this->set('limit_pagination', $limite_paginacao);
        $this->set('opcao_paginacao', $opcao_paginacao);
        $this->set('combo_modalidade', $modalidades->toArray());
        $this->set('combo_status', $status);
        $this->set('combo_assuntos', $assuntos);
        $this->set('combo_formatos', $combo_formatos);
        $this->set('formato_exibicao', (isset($data['formato'])) ? $data['formato'] : 'T');
        $this->set('data', $data);
    }

    public function imprimir()
    {
        $t_licitacoes = TableRegistry::get('Licitacao');
        $t_modalidade = TableRegistry::get('Modalidade');

        $condicoes = array();
        $formato_exibicao = 'T';

        if (count($this->request->getQueryParams()) > 0)
        {
            $numprocesso = $this->request->query('numprocesso');
            $titulo = $this->request->query('titulo');
            $modalidade = $this->request->query('modalidade');
            $status = $this->request->query('status');
            $data_publicacao_inicial = $this->request->query('data_publicacao_inicial');
            $data_publicacao_final = $this->request->query('data_publicacao_final');
            $data_sessao_inicial = $this->request->query('data_sessao_inicial');
            $data_sessao_final = $this->request->query('data_sessao_final');
            $formato = $this->request->query('formato');
            $mostrar = $this->request->query('mostrar');

            if($numprocesso != "")
            {
                if($formato == 'A')
                {
                    $condicoes['titulo LIKE'] = '%' . $numprocesso . '%';
                }
                else
                {
                    $pp = explode('/', $numprocesso);

                    if(count($pp) == 1)
                    {
                        $condicoes['numprocesso'] = $numprocesso;
                    }
                    elseif(count($pp) == 2)
                    {
                        $numprocesso = intval($pp[0]);
                        $ano = $pp[1];

                        $condicoes['numprocesso'] = $numprocesso;

                        if(strlen($ano) == 4)
                        {
                            $condicoes['ano'] = $ano;
                        }
                    }
                }
            }

            if($titulo != "")
            {
                $condicoes['titulo LIKE'] = '%' . $titulo . '%';
            }

            if ($modalidade != '')
            {
                $condicoes["modalidade"] = $modalidade;
            }

            if ($status != '')
            {
                $condicoes["status"] = $status;
            }

            if ($data_publicacao_inicial != "" && $data_publicacao_final != "")
            {
                $condicoes["dataPublicacao >="] = $this->Format->formatDateDB($data_publicacao_inicial);
                $condicoes["dataPublicacao <="] = $this->Format->formatDateDB($data_publicacao_final);
            }

            if ($data_sessao_inicial != "" && $data_sessao_final != "")
            {
                $condicoes["dataSessao >="] = $this->Format->formatDateDB($data_sessao_inicial);
                $condicoes["dataSessao <="] = $this->Format->formatDateDB($data_sessao_final);
            }

            if ($formato != 'T')
            {
                $condicoes["antigo"] = ($formato == "A") ? "1" : "0";
                $formato_exibicao = $formato;
            }

            if ($mostrar != 'T')
            {
                $condicoes["ativo"] = ($mostrar == "A") ? "1" : "0";
            }
        }

        $licitacoes = $t_licitacoes->find('all', [
            'conditions' => $condicoes,
            'order' => [
                'dataPublicacao' => 'DESC',
                'Licitacao.id' => 'DESC'
            ]
        ]);

        $modalidades = $t_modalidade->find('list', [
            'keyField' => 'chave',
            'valueField' => 'nome',
            'conditions' => [
                'ativo' => true
            ],
            'order' => [
                'ordem' => 'ASC'
            ]
        ]);

        $qtd_total = $licitacoes->count();

        $auditoria = [
            'ocorrencia' => 9,
            'descricao' => 'O usuário solicitou a impressão da lista de licitações.',
            'usuario' => $this->request->session()->read('UsuarioID')
        ];

        $this->Auditoria->registrar($auditoria);

        if ($this->request->session()->read('UsuarioSuspeito'))
        {
            $this->Monitoria->monitorar($auditoria);
        }

        $this->viewBuilder()->layout('print');

        $this->set('title', 'Licitações');
        $this->set('licitacoes', $licitacoes);
        $this->set('formato_exibicao', $formato_exibicao);
        $this->set('qtd_total', $qtd_total);
        $this->set('modalidades', $modalidades->toArray());
    }

    public function add()
    {
        $this->Flash->info('Para adicionar informações como editais, anexos, retificações, entre outros, primeiramente informe dados cadastrais sobre a licitação e em seguida, clique em Salvar.');
        $this->redirect(['action' => 'cadastro', 0]);
    }

    public function edit(int $id)
    {
        $t_licitacoes = TableRegistry::get('Licitacao');
        $licitacao = $t_licitacoes->get($id);

        if($licitacao->antigo)
        {
            $this->Flash->greatWarning('Esta licitação encontra-se no formato antigo. Para efetuar a migração para o novo formato, clique em "Migrar" na barra inferior. Caso não consiga encontrar o botão, entre em contato com o administrador do sistema ou com suporte técnico.');
            $this->redirect(['action' => 'edicao', $id]);
        }
        else
        {
            $this->redirect(['action' => 'cadastro', $id]);
        }
    }

    public function cadastro(int $id)
    {
        $title = ($id > 0) ? 'Edição da Licitação' : 'Nova Licitação';
        $icon = 'work';

        $t_licitacoes = TableRegistry::get('Licitacao');
        $t_modalidade = TableRegistry::get('Modalidade');
        $t_assuntos = TableRegistry::get('Assunto');
        $t_status = TableRegistry::get('StatusLicitacao');

        if ($id > 0)
        {
            $licitacao = $t_licitacoes->get($id, ['contain' => ['Assunto']]);
            $ap = array();

            $licitacao->data_publicacao = $licitacao->dataPublicacao->i18nFormat('dd/MM/yyyy');
            $licitacao->hora_publicacao = $licitacao->dataPublicacao->i18nFormat('HH:mm');

            if($licitacao->dataSessao != null)
            {
                $licitacao->data_sessao = $licitacao->dataSessao->i18nFormat('dd/MM/yyyy');
                $licitacao->hora_sessao = $licitacao->dataSessao->i18nFormat('HH:mm');
            }

            if($licitacao->dataTermino != null)
            {
                $licitacao->data_fim = $licitacao->dataTermino->i18nFormat('dd/MM/yyyy');
                $licitacao->hora_fim = $licitacao->dataTermino->i18nFormat('HH:mm');
            }

            foreach($licitacao->assuntos as $assunto)
            {
                $ap[] = $assunto->id;
            }

            $this->set('licitacao', $licitacao);
            $this->set('assuntos_pivot', $ap);
        }
        else
        {
            $this->set('licitacao', null);
            $this->set('assuntos_pivot', []);
        }

        $assuntos = $t_assuntos->find('list', [
            'keyField' => 'id',
            'valueField' => 'descricao',
            'conditions' => [
                'tipo' => 'LC'
            ],
            'order' => [
                'descricao' => 'ASC'
            ]
        ]);

        $modalidades = $t_modalidade->find('list', [
            'keyField' => 'chave',
            'valueField' => 'nome',
            'conditions' => [
                'ativo' => true
            ],
            'order' => [
                'ordem' => 'ASC'
            ]
        ]);

        $status = $t_status->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome',
            'order' => [
                'ordem' => 'ASC'
            ]
        ]);

        $this->set('title', $title);
        $this->set('combo_modalidade', $modalidades);
        $this->set('combo_status', $status);
        $this->set('assuntos', $assuntos);
        $this->set('icon', $icon);
        $this->set('id', $id);
    }

    public function edicao(int $id)
    {
        $title = 'Edição da Licitação';
        $icon = 'work';

        $t_licitacoes = TableRegistry::get('Licitacao');

        $licitacao = $t_licitacoes->get($id);
        $licitacao->data_inicio = $licitacao->dataInicio->i18nFormat('dd/MM/yyyy');
        $licitacao->hora_inicio = $licitacao->dataInicio->i18nFormat('HH:mm');
        $licitacao->data_termino = $licitacao->dataTermino->i18nFormat('dd/MM/yyyy');
        $licitacao->hora_termino = $licitacao->dataTermino->i18nFormat('HH:mm');

        $this->set('licitacao', $licitacao);
        $this->set('title', $title);
        $this->set('icon', $icon);
        $this->set('id', $id);
    }

    public function save(int $id)
    {
        if ($this->request->is('post'))
        {
            $this->insert();
        }
        elseif ($this->request->is('put'))
        {
            $this->update($id);
        }
    }

    public function delete(int $id)
    {
        try
        {
            $t_licitacoes = TableRegistry::get('Licitacao');
            $t_atualizacoes = TableRegistry::get('Atualizacao');
            $t_anexos = TableRegistry::get('Anexo');

            $marcado = $t_licitacoes->get($id);
            $titulo = $marcado->titulo;
            $opcoes = ['licitacao' => $id];

            $propriedades = $marcado->getOriginalValues();

            $this->removerArquivo($marcado->edital);

            $t_atualizacoes->deleteAll($opcoes);
            $t_anexos->deleteAll($opcoes);

            $t_licitacoes->delete($marcado);

            $this->Flash->greatSuccess('A licitação ' . $titulo . ' foi excluída com sucesso!');

            $auditoria = [
                'ocorrencia' => 26,
                'descricao' => 'O usuário excluiu uma licitação.',
                'dado_adicional' => json_encode(['dado_excluido' => $id, 'dados_registro_excluido' => $propriedades]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if($this->request->session()->read('UsuarioSuspeito'))
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['action' => 'index']);
        }
        catch(Exception $ex)
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao excluir a licitação.', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['action' => 'index']);
        }
    }

    public function informativos(int $id)
    {
        $t_licitacoes = TableRegistry::get('Licitacao');
        $t_atualizacoes = TableRegistry::get('Atualizacao');

        $limite_paginacao = Configure::read('Pagination.limit');
        $licitacao = $t_licitacoes->get($id, ['contain' => ['Modalidade']]);
        $titulo = $subtitulo = '';

        $condicoes = [
            'licitacao' => $id
        ];

        $titulo = "Extratos e Atualizações da Licitação";
        $subtitulo = "Extratos, atualizações e informativos relativos a processo licitatório " . $licitacao->numprocesso . '/' . $licitacao->ano . ' da modalidade ' . $licitacao->modalidade->nome . ' sob o assunto ' . $licitacao->titulo;

        $this->paginate = [
            'limit' => $limite_paginacao,
            'conditions' => $condicoes,
            'order' => [
                'data' => 'DESC'
            ]
        ];

        $atualizacoes = $this->paginate($t_atualizacoes);

        $qtd_total = $t_atualizacoes->find('all', [
            'conditions' => $condicoes
        ])->count();

        $this->set('title', $titulo);
        $this->set('subtitle', $subtitulo);
        $this->set('icon', 'work');
        $this->set('id', $id);
        $this->set('atualizacoes', $atualizacoes);
        $this->set('licitacao', $licitacao);
        $this->set('qtd_total', $qtd_total);
    }

    public function informativo(int $id)
    {
        $title = ($id > 0) ? 'Edição de Atualização' : 'Nova Atualização';

        $t_licitacoes = TableRegistry::get('Licitacao');
        $t_atualizacoes = TableRegistry::get('Atualizacao');

        $idLicitacao = $this->request->query('idLicitacao');

        $licitacao = $t_licitacoes->get($idLicitacao, ['contain' => ['Modalidade']]);

        if($id > 0)
        {
            $atualizacao = $t_atualizacoes->get($id);

            $data = $atualizacao->data;

            $atualizacao->data = $data->i18nFormat('dd/MM/yyyy');
            $atualizacao->hora = $data->i18nFormat('HH:mm');

            $this->set('atualizacao', $atualizacao);
        }
        else
        {
            $this->set('atualizacao', null);
        }

        $this->set('title', $title);
        $this->set('icon', 'work');
        $this->set('id', $id);
        $this->set('licitacao', $licitacao);
    }

    public function anexos(int $id)
    {
        $t_licitacoes = TableRegistry::get('Licitacao');
        $t_anexos = TableRegistry::get('Anexo');

        $limite_paginacao = Configure::read('Pagination.limit');

        $licitacao = $t_licitacoes->get($id, ['contain' => ['Modalidade']]);
        $titulo = $subtitulo = '';

        $titulo = "Documentos e Anexos da Licitação";
        $subtitulo = "Documentos e anexos relativos a processo licitatório " . $licitacao->numprocesso . '/' . $licitacao->ano . ' da modalidade ' . $licitacao->modalidade->nome . ' sob o assunto ' . $licitacao->titulo;

        $condicoes = [
            'licitacao' => $id
        ];

        $this->paginate = [
            'limit' => $limite_paginacao,
            'conditions' => $condicoes,
            'order' => [
                'data' => 'DESC',
                'numero' => 'ASC',
                'nome' => 'ASC'
            ]
        ];

        $anexos = $this->paginate($t_anexos);

        $qtd_total = $t_anexos->find('all', [
            'conditions' => $condicoes
        ])->count();

        $this->set('title', $titulo);
        $this->set('subtitle', $subtitulo);
        $this->set('icon', 'work');
        $this->set('licitacao', $licitacao);
        $this->set('anexos', $anexos);
        $this->set('qtd_total', $qtd_total);
        $this->set('id', $id);
    }

    /**
     * @deprecated 1.2.0 Não é necessário o agrupamento de documentos anexos
     */
    public function anexar(int $id)
    {
        $this->set('title', 'Anexar novo documento a licitação');
        $this->set('icon', 'work');
        $this->set('id', $id);
    }

    public function anexo(int $id)
    {
        $title = ($id > 0) ? 'Edição de Anexo' : 'Novo Anexo';

        $t_licitacoes = TableRegistry::get('Licitacao');
        $t_anexos = TableRegistry::get('Anexo');

        $idLicitacao = $this->request->query('idLicitacao');

        $licitacao = $t_licitacoes->get($idLicitacao, ['contain' => ['Modalidade']]);

        if($id > 0)
        {
            $anexo = $t_anexos->get($id);

            $anexo->data = $anexo->data->i18nFormat('dd/MM/yyyy');

            $this->set('anexo', $anexo);
        }
        else
        {
            $this->set('anexo', null);
        }

        $this->set('title', $title);
        $this->set('icon', 'work');
        $this->set('id', $id);
        $this->set('licitacao', $licitacao);
    }

    public function visualizar(int $id)
    {
        $t_licitacoes = TableRegistry::get('Licitacao');
        $t_atualizacoes = TableRegistry::get('Atualizacao');
        $t_anexos = TableRegistry::get('Anexo');

        $licitacao = $t_licitacoes->get($id, ['contain' => ['Modalidade', 'StatusLicitacao']]);

        $condicoes = [
            'licitacao' => $id
        ];

        $atualizacoes = $t_atualizacoes->find('all', [
            'conditions' => $condicoes,
            'order' => [
                'data' => 'DESC'
            ]
        ]);

        $anexos = $t_anexos->find('all', [
            'conditions' => $condicoes,
            'order' => [
                'data' => 'DESC',
                'numero' => 'ASC',
                'nome' => 'ASC'
            ]
        ]);

        $this->set('title', 'Visualização de Dados da Licitação');
        $this->set('icon', 'work');
        $this->set('licitacao', $licitacao);
        $this->set('atualizacoes', $atualizacoes);
        $this->set('anexos', $anexos);
        $this->set('id', $id);
    }

    public function documento(int $id)
    {
        $t_licitacoes = TableRegistry::get('Licitacao');
        $t_atualizacoes = TableRegistry::get('Atualizacao');
        $t_anexos = TableRegistry::get('Anexo');

        $licitacao = $t_licitacoes->get($id, ['contain' => ['Modalidade', 'StatusLicitacao']]);

        $condicoes = [
            'licitacao' => $id
        ];

        $atualizacoes = $t_atualizacoes->find('all', [
            'conditions' => $condicoes,
            'order' => [
                'data' => 'DESC'
            ]
        ]);

        $anexos = $t_anexos->find('all', [
            'conditions' => $condicoes,
            'order' => [
                'data' => 'DESC',
                'numero' => 'ASC',
                'nome' => 'ASC'
            ]
        ]);

        $this->viewBuilder()->layout('print');

        $this->set('title', 'Visualização de Dados da Licitação');
        $this->set('icon', 'work');
        $this->set('licitacao', $licitacao);
        $this->set('atualizacoes', $atualizacoes);
        $this->set('anexos', $anexos);
        $this->set('id', $id);
    }

    public function migracao(int $id)
    {
        $t_licitacoes = TableRegistry::get('Licitacao');
        $t_modalidade = TableRegistry::get('Modalidade');
        $t_assuntos = TableRegistry::get('Assunto');
        $t_status = TableRegistry::get('StatusLicitacao');

        $licitacao = $t_licitacoes->get($id, ['contain' => ['Assunto']]);
        $ap = array();

        $licitacao->data_sessao = $licitacao->dataInicio->i18nFormat('dd/MM/yyyy');
        $licitacao->hora_sessao = $licitacao->dataInicio->i18nFormat('HH:mm');

        if($licitacao->dataTermino != null)
        {
            $licitacao->data_fim = $licitacao->dataTermino->i18nFormat('dd/MM/yyyy');
            $licitacao->hora_fim = $licitacao->dataTermino->i18nFormat('HH:mm');
        }

        try
        {
            if(stristr($licitacao->titulo, 'processo'))
            {
                $sp = substr($licitacao->titulo, strpos(strtolower($licitacao->titulo), 'processo'), 18);
                $sp = substr($sp, -8);
                $sp = str_replace(['-', ' '], '', $sp);
                $sp = explode('/', $sp);

                $licitacao->numprocesso = $sp[0];
                $licitacao->ano = $sp[1];
            }

            $licitacao->modalidade = $this->definirModalidade($licitacao->titulo);
            $arquivos = $this->obterArquivos($licitacao);

            $this->set('pre_migracao', true);
            $this->set('arquivos', $arquivos);
        }
        catch(Exception $ex)
        {
            $this->set('pre_migracao', false);
            $this->set('arquivos', []);
        }

        $assuntos = $t_assuntos->find('list', [
            'keyField' => 'id',
            'valueField' => 'descricao',
            'conditions' => [
                'tipo' => 'LC'
            ],
            'order' => [
                'descricao' => 'ASC'
            ]
        ]);

        $modalidades = $t_modalidade->find('list', [
            'keyField' => 'chave',
            'valueField' => 'nome',
            'conditions' => [
                'ativo' => true
            ],
            'order' => [
                'ordem' => 'ASC'
            ]
        ]);

        $status = $t_status->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome',
            'order' => [
                'ordem' => 'ASC'
            ]
        ]);

        $this->set('title', 'Migração da Licitação');
        $this->set('icon', 'work');
        $this->set('combo_modalidade', $modalidades);
        $this->set('combo_status', $status);
        $this->set('assuntos', $assuntos);
        $this->set('id', $id);
        $this->set('licitacao', $licitacao);
        $this->set('assuntos_pivot', []);
    }

    public function migrar(int $id)
    {
        $t_licitacoes = TableRegistry::get('Licitacao');
        $t_anexos = TableRegistry::get('Anexo');

        $this->autoRender = false;
        $this->validationRole = false;

        if($this->request->is('post') || $this->request->is('put'))
        {
            //Entidade Licitação
            $entity = $t_licitacoes->get($id);
            $t_licitacoes->patchEntity($entity, $this->request->data());

            $entity->dataPublicacao = $this->obterDataPublicacao($entity->data_publicacao, $entity->hora_publicacao);
            $entity->dataAtualizacao = $this->obterDataPublicacao(null, null);
            $entity->ano = ($entity->ano == "") ? date("Y") : $entity->ano;

            if($entity->data_sessao != "")
            {
                $entity->dataSessao = $this->Format->mergeDateDB($entity->data_sessao, $entity->hora_sessao);
            }

            if($entity->data_fim != "")
            {
                $entity->dataTermino = $this->Format->mergeDateDB($entity->data_fim, $entity->hora_fim);
            }

            $entity->modalidade = $this->request->getData('modalidade');
            $entity->status = $this->request->getData('status');
            $entity->antigo = false;
            $entity->visualizacoes = 0;

            $assuntos = json_decode($entity->lassuntos);

            $propriedades = $this->Auditoria->changedOriginalFields($entity);
            $modificadas = $this->Auditoria->changedFields($entity, $propriedades);

            $t_licitacoes->save($entity);

            $auditoria_assuntos = $this->atualizarAssuntosLicitacao($entity, $assuntos, true);

            //Arquivos de Licitação
            $arquivo_data = $this->request->getData("arquivo_data");
            $arquivo_numero = $this->request->getData("arquivo_numero");
            $arquivo_nome = $this->request->getData("arquivo_nome");
            $arquivo_tipo = $this->request->getData("arquivo_tipo");
            $arquivo_arquivo = $this->request->getData("arquivo_arquivo");
            $arquivo_valido = $this->request->getData("arquivo_valido");
            $arquivos_modificados = array();

            $arquivo_total = count($arquivo_data);

            for($i = 0; $i < $arquivo_total; $i++)
            {
                $data = $arquivo_data[$i];
                $numero = $arquivo_numero[$i];
                $nome = $arquivo_nome[$i];
                $tipo = $arquivo_tipo[$i];
                $arquivo = $arquivo_arquivo[$i];
                $valido = $arquivo_valido[$i] == "1";

                if($valido)
                {
                    $entarquivo = $t_anexos->newEntity();
                    $entarquivo->data = $this->Format->formatDateDB($data);
                    $entarquivo->numero = $numero;
                    $entarquivo->nome = $nome;
                    $entarquivo->licitacao = $entity->id;
                    $entarquivo->ativo = true;

                    if($tipo == 'edital')
                    {
                        $entarquivo->arquivo = $arquivo;
                    }
                    elseif($tipo == 'anexo')
                    {
                        $diretorio = Configure::read('Files.paths.files');
                        $novodir = Configure::read('Files.paths.licitacoes');
                        $url_relativa = Configure::read('Files.urls.licitacoes');

                        $pivot = explode('/', $arquivo);
                        $pivot = end($pivot);
                        $local = $diretorio . $pivot;
                        $file = new File($local);

                        $novo_nome = uniqid() . '.' . $file->ext();

                        $file->copy($novodir . $novo_nome, true);

                        $entarquivo->arquivo = $url_relativa . $novo_nome;

                        $file->close();
                    }

                    $arquivos_modificados[] = $entarquivo->getOriginalValues();
                    $t_anexos->save($entarquivo);
                }
            }

            $this->Flash->greatSuccess('A migração da licitação ' . $entity->titulo . ' foi realizada com sucesso. Favor, fazer conferência dos dados migrados.');

            $auditoria = [
                'ocorrencia' => 80,
                'descricao' => 'O efetou a migração de uma licitação.',
                'dado_adicional' => json_encode(['id_nova_licitacao' => $entity->id,
                                                 'dados_licitacao' => $propriedades,
                                                 'assuntos_associados' => $auditoria_assuntos,
                                                 'arquivos_modificados' => $arquivos_modificados]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if($this->request->session()->read('UsuarioSuspeito'))
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['action' => 'cadastro', $entity->id]);
        }
    }

    protected function insert()
    {
        try
        {
            $t_licitacoes = TableRegistry::get('Licitacao');
            $entity = $t_licitacoes->newEntity($this->request->data());

            $entity->dataPublicacao = $this->obterDataPublicacao($entity->data_publicacao, $entity->hora_publicacao);
            $entity->ano = ($entity->ano == "") ? date("Y") : $entity->ano;

            if($entity->data_sessao != "")
            {
                $entity->dataSessao = $this->Format->mergeDateDB($entity->data_sessao, $entity->hora_sessao);
            }

            if($entity->data_fim != "")
            {
                $entity->dataTermino = $this->Format->mergeDateDB($entity->data_fim, $entity->hora_fim);
            }

            $entity->modalidade = $this->request->getData('modalidade');
            $entity->status = $this->request->getData('status');
            $entity->antigo = false;
            $entity->visualizacoes = 0;

            $assuntos = json_decode($entity->lassuntos);

            $t_licitacoes->save($entity);
            $auditoria_assuntos = $this->atualizarAssuntosLicitacao($entity, $assuntos, false);

            $this->Flash->greatSuccess('Licitação salva com sucesso.');

            $propriedades = $entity->getOriginalValues();

            $auditoria = [
                'ocorrencia' => 24,
                'descricao' => 'O usuário criou uma nova licitação.',
                'dado_adicional' => json_encode(['id_nova_licitacao' => $entity->id,
                                                 'dados_licitacao' => $propriedades,
                                                 'assuntos_associados' => $auditoria_assuntos]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if($this->request->session()->read('UsuarioSuspeito'))
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['action' => 'cadastro', $entity->id]);
        }
        catch(Exception $ex)
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar a licitação', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['action' => 'cadastro', 0]);
        }
    }

    protected function update(int $id)
    {
        try
        {
            $t_licitacoes = TableRegistry::get('Licitacao');
            $entity = $t_licitacoes->get($id);

            if($entity->antigo)
            {
                $this->oldUpdate($t_licitacoes, $entity);
            }
            else
            {
                $this->newUpdate($t_licitacoes, $entity);
            }
        }
        catch(Exception $ex)
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar a licitação', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['action' => 'cadastro', $id]);
        }
    }

    private function oldUpdate(Table $table, Entity $entity)
    {
        $antigo_arquivo = $entity->edital;

        $table->patchEntity($entity, $this->request->data());

        $entity->dataInicio = $this->Format->mergeDateDB($entity->data_inicio, $entity->hora_inicio);
        $entity->dataTermino = $this->Format->mergeDateDB($entity->data_termino, $entity->hora_termino);
        $entity->dataAtualizacao = $this->obterDataPublicacao(null, null);
        $entity->antigo = true;

        $enviaArquivo = ($this->request->getData('enviaArquivo') == 'true');

        if($enviaArquivo)
        {
            $this->removerArquivo($antigo_arquivo);
            $arquivo = $this->request->getData('arquivo');
            $entity->edital = $this->salvarArquivo($arquivo);
        }

        $propriedades = $this->Auditoria->changedOriginalFields($entity);
        $modificadas = $this->Auditoria->changedFields($entity, $propriedades);

        $table->save($entity);
        $this->Flash->greatSuccess('Licitação salva com sucesso.');

        $auditoria = [
            'ocorrencia' => 25,
            'descricao' => 'O usuário editou uma licitação.',
            'dado_adicional' => json_encode(['licitacao_modificada' => $entity->id,
                                             'valores_originais' => $propriedades,
                                             'valores_modificados' => $modificadas]),
            'usuario' => $this->request->session()->read('UsuarioID')
        ];

        $this->Auditoria->registrar($auditoria);

        if($this->request->session()->read('UsuarioSuspeito'))
        {
            $this->Monitoria->monitorar($auditoria);
        }

        $this->redirect(['action' => 'edicao', $entity->id]);
    }

    private function newUpdate(Table $table, Entity $entity)
    {
        $table->patchEntity($entity, $this->request->data());

        $entity->dataPublicacao = $this->obterDataPublicacao($entity->data_publicacao, $entity->hora_publicacao);
        $entity->dataAtualizacao = $this->obterDataPublicacao(null, null);
        $entity->ano = ($entity->ano == "") ? date("Y") : $entity->ano;

        if($entity->data_sessao != "")
        {
            $entity->dataSessao = $this->Format->mergeDateDB($entity->data_sessao, $entity->hora_sessao);
        }

        if($entity->data_fim != "")
        {
            $entity->dataTermino = $this->Format->mergeDateDB($entity->data_fim, $entity->hora_fim);
        }

        $entity->modalidade = $this->request->getData('modalidade');
        $entity->status = $this->request->getData('status');
        $entity->antigo = false;

        $assuntos = json_decode($entity->lassuntos);

        $propriedades = $this->Auditoria->changedOriginalFields($entity);
        $modificadas = $this->Auditoria->changedFields($entity, $propriedades);

        $table->save($entity);

        $auditoria_assuntos = $this->atualizarAssuntosLicitacao($entity, $assuntos, true);

        $this->Flash->greatSuccess('Licitação salva com sucesso.');

        $auditoria = [
            'ocorrencia' => 25,
            'descricao' => 'O usuário editou uma licitação.',
            'dado_adicional' => json_encode(['licitacao_modificada' => $entity->id,
                                             'valores_originais' => $propriedades,
                                             'valores_modificados' => $modificadas,
                                             'assuntos_relacionados' => $auditoria_assuntos]),
            'usuario' => $this->request->session()->read('UsuarioID')
        ];

        $this->Auditoria->registrar($auditoria);

        if($this->request->session()->read('UsuarioSuspeito'))
        {
            $this->Monitoria->monitorar($auditoria);
        }

        $this->redirect(['action' => 'cadastro', $entity->id]);
    }

    private function removerArquivo($arquivo)
    {
        $diretorio = Configure::read('Files.paths.public');
        $arquivo = $diretorio . $arquivo;

        $file = new File($arquivo);

        if($file->exists())
        {
            $file->delete();
        }
    }

    private function salvarArquivo($arquivo)
    {
        $diretorio = Configure::read('Files.paths.licitacoes');
        $url_relativa = Configure::read('Files.urls.licitacoes');

        $file_temp = $arquivo['tmp_name'];
        $nome_arquivo = $arquivo['name'];

        $file = new File($file_temp);
        $pivot = new File($nome_arquivo);

        $novo_nome = uniqid() . '.' . $pivot->ext();

        if(!$this->File->validationExtension($pivot, $this->File::TYPE_FILE_DOCUMENT))
        {
            throw new Exception("A extensão do arquivo é inválida.");
        }
        elseif(!$this->File->validationSize($file))
        {
            $maximo = $this->File->getMaxLengh($this->File::TYPE_FILE_DOCUMENT);
            $divisor = Configure::read('Files.misc.megabyte');

            $maximo = round($maximo / $divisor, 0);

            $mensagem = "O tamaho do arquivo enviado é muito grande. O tamanho máximo do arquivo é de $maximo MB.";

            throw new Exception($mensagem);
        }

        $file->copy($diretorio . $novo_nome, true);

        return $url_relativa . $novo_nome;
    }

    private function atualizarAssuntosLicitacao(Entity $entity, array $assuntos, bool $clear = false)
    {
        $t_assunto = TableRegistry::get('Assunto');
        $t_licitacao = TableRegistry::get('Licitacao');
        $id_licitacao = $entity->id;

        $conn = ConnectionManager::get(BaseTable::defaultConnectionName());

        $a_antigos = array();
        $a_novos = array();

        if($clear)
        {
            $e = $t_licitacao->get($id_licitacao, [
                'contain' => ['Assunto']
            ]);

            foreach($e->assuntos as $assunto)
            {
                $a_antigos[$assunto->id] = $assunto->descricao;
            }

            $conn->delete('assunto_licitacao', [
                'licitacao' => $id_licitacao
            ]);
        }

        foreach($assuntos as $assunto)
        {
            $qtd = $t_assunto->find('all', [
                'conditions' => [
                    'descricao' => $assunto->nome,
                    'tipo' => 'LC'
                ]
            ])->count();

            if($qtd == 0)
            {
                $na = $t_assunto->newEntity();
                $na->descricao = $assunto->nome;
                $na->tipo = 'LC';

                $t_assunto->save($na);

                $assunto->id = $na->id;
            }

            $conn->insert('assunto_licitacao', [
                'licitacao' => $id_licitacao,
                'assunto' => $assunto->id
            ]);

            $a_novos[$assunto->id] = $assunto->nome;
        }

        $auditoria_assuntos = [
            'assuntos_antigos' => $a_antigos,
            'assuntos_novos' => $a_novos
        ];

        return $auditoria_assuntos;
    }

    private function obterDataPublicacao($data, $hora)
    {
        $postagem = null;

        if($data == "" && $hora == "")
        {
            $postagem = date("Y-m-d H:i:s");
        }
        elseif($data == "" && $hora != "")
        {
            $postagem = date("Y-m-d") . ' ' . $hora . ':00';
        }
        elseif(($data != "" && $hora == ""))
        {
            $pivot = $this->Format->formatDateDB($data);
            $postagem = $pivot . ' ' . date('H:i:s');
        }
        else
        {
            $postagem = $this->Format->mergeDateDB($data, $hora);
        }

        return $postagem;
    }

    private function definirModalidade(string $titulo)
    {
        $modalidade = null;
        $chaves = $this->obterListaChaves();

        foreach($chaves as $codigo => $termos)
        {
            foreach($termos as $termo)
            {
                if(stristr($titulo, $termo))
                {
                    $modalidade = $codigo;
                    break 2;
                }
            }
        }

        return $modalidade;
    }

    private function obterArquivos(Entity $entity)
    {
        $arquivos = array();

        if($this->existeEdital($entity->edital))
        {
            $arquivos[] = [
                'nome' => 'Edital',
                'arquivo' => $entity->edital,
                'tipo' => 'edital',
                'status' => [
                    'sucesso' => true,
                    'mensagem' => null
                ]
            ];
        }
        else
        {
            $arquivos[] = [
                'nome' => 'Edital',
                'arquivo' => $entity->edital,
                'tipo' => 'edital',
                'status' => [
                    'sucesso' => false,
                    'mensagem' => 'Não foi possível encontrar este arquivo. Favor, verifique se foi linkado corretamente, ou se o mesmo foi movido ou corrompido.'
                ]
            ];
        }

        $document = new DOMDocument();
        $document->loadHTML($entity->descricao);
        $links = $document->getElementsByTagName('a');

        foreach($links as $link)
        {
            $arquivo = $link->getAttribute('href');
            $arquivo = urldecode($arquivo);

            if($arquivo != "")
            {
                if(stristr($arquivo, 'public/editor/files'))
                {
                    $pivot = explode('/', $arquivo);
                    $pivot = end($pivot);
                    $teste = new File($pivot);

                    if($this->File->validationExtension($teste, $this->File::TYPE_FILE_DOCUMENT))
                    {
                        $diretorio = Configure::read('Files.paths.files');
                        $local = $diretorio . $pivot;
                        $file = new File($local);

                        if($file->exists())
                        {
                            $arquivos[] = [
                                'nome' => $link->nodeValue,
                                'arquivo' => $arquivo,
                                'tipo' => 'anexo',
                                'status' => [
                                    'sucesso' => true,
                                    'mensagem' => null
                                ]
                            ];
                        }
                        else
                        {
                            $arquivos[] = [
                                'nome' => $link->nodeValue,
                                'arquivo' => $arquivo,
                                'tipo' => 'anexo',
                                'status' => [
                                    'sucesso' => false,
                                    'mensagem' => 'Não foi possível encontrar este arquivo. Favor, verifique se foi linkado corretamente, ou se o mesmo foi movido ou corrompido.'
                                ]
                            ];
                        }
                    }
                    else
                    {
                        $arquivos[] = [
                            'nome' => $link->nodeValue,
                            'arquivo' => $arquivo,
                            'tipo' => 'anexo',
                            'status' => [
                                'sucesso' => false,
                                'mensagem' => 'O tipo do arquivo é inválido. Favor, verifique se foi linkado corretamente, ou se o mesmo foi movido ou corrompido.'
                            ]
                        ];
                    }
                }
            }
        }

        return $arquivos;
    }

    private function existeEdital(string $edital)
    {
        $diretorio = Configure::read('Files.paths.licitacoes');
        $pivot = explode('/', $edital);
        $arquivo = end($pivot);
        $caminho = $diretorio . $arquivo;
        $file = new File($caminho);

        return $file->exists();
    }

    private function obterListaChaves()
    {
        return [
            'PP' => [
                'pregão presencial',
                'pregao presencial',
                'preg. presencial',
                'preg presencial',
                'pregão pres',
                'pregao pres',
                'pp'
            ],
            'PE' => [
                'pregão eletrônico',
                'pregao eletrônico',
                'preg. eletrônico',
                'preg eletrônico',
                'pregão eletronico',
                'pregao eletronico',
                'preg. eletronico',
                'preg eletronico',
                'pregão eletr',
                'pregao eletr',
                'pp'
            ],
            'TP' => [
                'tomada de preços',
                'tom. de preços',
                'tom de preços',
                'tomada preços',
                'tom. preços',
                'tom preços',
                'tp'
            ],
            'CO' => [
                'concorrência',
                'concorrencia',
            ],
            'CN' => [
                'convite',
                'conv'
            ],
            'DI' => [
                'dispensa',
                'disp',
            ],
            'IN' => [
                'inexigibilidade'
            ],
            'CC' => [
                'concurso',
                'conc'
            ],
            'LE' => [
                'leilão',
                'leilao'
            ],
            'CR' => [
                'credenciamento',
                'credenciament',
                'credenc',
                'cr'
            ]
        ];
    }
}
