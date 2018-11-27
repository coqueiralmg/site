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

class LicitacoesController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $t_licitacoes = TableRegistry::get('Licitacao');
        $limite_paginacao = Configure::read('Pagination.limit');

        $condicoes = array();
        $data = array();

        if (count($this->request->getQueryParams()) > 3)
        {
            $titulo = $this->request->query('titulo');
            $data_inicial = $this->request->query('data_inicial');
            $data_final = $this->request->query('data_final');
            $mostrar = $this->request->query('mostrar');

            if($titulo != "")
            {
                $condicoes['titulo LIKE'] = '%' . $titulo . '%';
            }

            if ($data_inicial != "" && $data_final != "")
            {
                $condicoes["dataInicio >="] = $this->Format->formatDateDB($data_inicial);
                $condicoes["dataInicio <="] = $this->Format->formatDateDB($data_final);
            }

            if ($mostrar != 'T')
            {
                $condicoes["ativo"] = ($mostrar == "A") ? "1" : "0";
            }

            $data['titulo'] = $titulo;
            $data['data_inicial'] = $data_inicial;
            $data['data_final'] = $data_final;
            $data['mostrar'] = $mostrar;

            $this->request->data = $data;
        }

        $this->paginate = [
            'limit' => $limite_paginacao,
            'conditions' => $condicoes,
            'order' => [
                'id' => 'DESC'
            ]
        ];

        $opcao_paginacao = [
            'name' => 'licitações',
            'name_singular' => 'licitação',
            'predicate' => 'encontradas',
            'singular' => 'encontrada'
        ];

        $licitacoes = $this->paginate($t_licitacoes);

        $qtd_total = $t_licitacoes->find('all', [
            'conditions' => $condicoes
        ])->count();

        $combo_mostra = ["T" => "Todos", "A" => "Somente ativos", "I" => "Somente inativos"];

        $this->set('title', 'Licitações');
        $this->set('icon', 'work');
        $this->set('combo_mostra', $combo_mostra);
        $this->set('licitacoes', $licitacoes);
        $this->set('qtd_total', $qtd_total);
        $this->set('limit_pagination', $limite_paginacao);
        $this->set('opcao_paginacao', $opcao_paginacao);
        $this->set('data', $data);
    }

    public function imprimir()
    {
        $t_licitacoes = TableRegistry::get('Licitacao');

        $condicoes = array();

        if (count($this->request->getQueryParams()) > 0)
        {
            $titulo = $this->request->query('titulo');
            $data_inicial = $this->request->query('data_inicial');
            $data_final = $this->request->query('data_final');
            $mostrar = $this->request->query('mostrar');

            if($titulo != "")
            {
                $condicoes['titulo LIKE'] = '%' . $titulo . '%';
            }

            if ($data_inicial != "" && $data_final != "")
            {
                $condicoes["dataInicio >="] = $this->Format->formatDateDB($data_inicial);
                $condicoes["dataInicio <="] = $this->Format->formatDateDB($data_final);
            }

            if ($mostrar != 'T')
            {
                $condicoes["ativo"] = ($mostrar == "A") ? "1" : "0";
            }
        }

        $licitacoes = $t_licitacoes->find('all', [
            'conditions' => $condicoes,
            'order' => [
                'id' => 'DESC'
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
        $this->set('qtd_total', $qtd_total);
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
            $this->Flash->greatWarning('Esta licitação encontra-se no formato antigo. Para efetuar a migração, clique em "Migrar" na barra inferior.');
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
            $licitacao->data_sessao = $licitacao->dataSessao->i18nFormat('dd/MM/yyyy');
            $licitacao->hora_sessao = $licitacao->dataSessao->i18nFormat('HH:mm');

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
            'keyField' => 'chave',
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
            $marcado = $t_licitacoes->get($id);
            $titulo = $marcado->titulo;

            $propriedades = $marcado->getOriginalValues();

            $this->removerArquivo($marcado->edital);

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
        $entity->antigo = false;
        $entity->visualizacoes = 0;

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
}
