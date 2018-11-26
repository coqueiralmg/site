<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Network\Session;
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
            $licitacao = $t_licitacoes->get($id);
            $licitacao->data_inicio = $licitacao->dataInicio->i18nFormat('dd/MM/yyyy');
            $licitacao->hora_inicio = $licitacao->dataInicio->i18nFormat('HH:mm');
            $licitacao->data_termino = $licitacao->dataTermino->i18nFormat('dd/MM/yyyy');
            $licitacao->hora_termino = $licitacao->dataTermino->i18nFormat('HH:mm');

            $this->set('licitacao', $licitacao);
            $this->set('assuntos_pivot', []);
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

    protected function insert()
    {
        try
        {
            $t_licitacoes = TableRegistry::get('Licitacao');
            $entity = $t_licitacoes->newEntity($this->request->data());

            $entity->dataInicio = $this->Format->mergeDateDB($entity->data_inicio, $entity->hora_inicio);
            $entity->dataTermino = $this->Format->mergeDateDB($entity->data_termino, $entity->hora_termino);

            $arquivo = $this->request->getData('arquivo');
            $entity->edital = $this->salvarArquivo($arquivo);

            $t_licitacoes->save($entity);
            $this->Flash->greatSuccess('Licitação salva com sucesso.');

            $propriedades = $entity->getOriginalValues();

            $auditoria = [
                'ocorrencia' => 24,
                'descricao' => 'O usuário criou uma nova licitação.',
                'dado_adicional' => json_encode(['id_nova_licitacao' => $entity->id, 'dados_licitacao' => $propriedades]),
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

            $antigo_arquivo = $entity->edital;

            $t_licitacoes->patchEntity($entity, $this->request->data());

            $entity->dataInicio = $this->Format->mergeDateDB($entity->data_inicio, $entity->hora_inicio);
            $entity->dataTermino = $this->Format->mergeDateDB($entity->data_termino, $entity->hora_termino);

            $enviaArquivo = ($this->request->getData('enviaArquivo') == 'true');

            if($enviaArquivo)
            {
                $this->removerArquivo($antigo_arquivo);
                $arquivo = $this->request->getData('arquivo');
                $entity->edital = $this->salvarArquivo($arquivo);
            }

            $propriedades = $this->Auditoria->changedOriginalFields($entity);
            $modificadas = $this->Auditoria->changedFields($entity, $propriedades);

            $t_licitacoes->save($entity);
            $this->Flash->greatSuccess('Licitação salva com sucesso.');

            $auditoria = [
                'ocorrencia' => 25,
                'descricao' => 'O usuário editou uma licitação.',
                'dado_adicional' => json_encode(['licitacao_modificada' => $id, 'valores_originais' => $propriedades, 'valores_modificados' => $modificadas]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if($this->request->session()->read('UsuarioSuspeito'))
            {
                $this->Monitoria->monitorar($auditoria);
            }

            if($entity->antigo)
            {
                $this->redirect(['action' => 'edicao', $id]);
            }
            else
            {
                $this->redirect(['action' => 'cadastro', $id]);
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
}
