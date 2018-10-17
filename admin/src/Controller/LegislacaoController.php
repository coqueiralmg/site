<?php

namespace App\Controller;

use App\Model\Table\BaseTable;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Network\Session;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use \Exception;
use \DateTime;

class LegislacaoController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $t_legislacao = TableRegistry::get('Legislacao');
        $t_tipo_legislacao = TableRegistry::get('TipoLegislacao');
        $limite_paginacao = Configure::read('Pagination.limit');

        $condicoes = array();
        $data = array();

        if (count($this->request->getQueryParams()) > 3)
        {
            $numero = $this->request->query('numero');
            $titulo = $this->request->query('titulo');
            $data_inicial = $this->request->query('data_inicial');
            $data_final = $this->request->query('data_final');
            $mostrar = $this->request->query('mostrar');

            if($numero != "")
            {
                $condicoes['numero LIKE'] = '%' . $numero . '%';
            }

            if($titulo != "")
            {
                $condicoes['titulo LIKE'] = '%' . $titulo . '%';
            }

            if ($data_inicial != "" && $data_final != "")
            {
                $condicoes["data >="] = $this->Format->formatDateDB($data_inicial);
                $condicoes["data <="] = $this->Format->formatDateDB($data_final);
            }

            if ($mostrar != 'T')
            {
                $condicoes["ativo"] = ($mostrar == "A") ? "1" : "0";
            }

            $data['numero'] = $numero;
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
                'data' => 'DESC'
            ]
        ];

        $legislacao = $this->paginate($t_legislacao);

        $qtd_total = $t_legislacao->find('all', [
            'conditions' => $condicoes]
        )->count();

        $combo_mostra = ["T" => "Todos", "A" => "Somente ativos", "I" => "Somente inativos"];
        $combo_tipo = $t_tipo_legislacao->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome',
            'conditions' => [
                'ativo' => true
        ]]);

        $this->set('title', 'Legislação');
        $this->set('icon', 'gavel');
        $this->set('combo_mostra', $combo_mostra);
        $this->set('combo_tipo', $combo_tipo);
        $this->set('legislacao', $legislacao);
        $this->set('qtd_total', $qtd_total);
        $this->set('limit_pagination', $limite_paginacao);
        $this->set('data', $data);
    }

    public function imprimir()
    {
        $t_legislacao = TableRegistry::get('Legislacao');

        $condicoes = array();

        if (count($this->request->getQueryParams()) > 0)
        {
            $numero = $this->request->query('numero');
            $titulo = $this->request->query('titulo');
            $data_inicial = $this->request->query('data_inicial');
            $data_final = $this->request->query('data_final');
            $mostrar = $this->request->query('mostrar');

            $condicoes['numero LIKE'] = '%' . $numero . '%';
            $condicoes['titulo LIKE'] = '%' . $titulo . '%';

            if ($data_inicial != "" && $data_final != "")
            {
                $condicoes["data >="] = $this->Format->formatDateDB($data_inicial);
                $condicoes["data <="] = $this->Format->formatDateDB($data_final);
            }

            if ($mostrar != 'T')
            {
                $condicoes["ativo"] = ($mostrar == "A") ? "1" : "0";
            }
        }

        $legislacao = $t_legislacao->find('all', [
            'conditions' => $condicoes,
            'order' => [
                'id' => 'DESC'
            ]
        ]);

        $qtd_total = $legislacao->count();

        $auditoria = [
            'ocorrencia' => 9,
            'descricao' => 'O usuário solicitou a impressão da listagem de legislação municipal.',
            'usuario' => $this->request->session()->read('UsuarioID')
        ];

        $this->Auditoria->registrar($auditoria);

        if ($this->request->session()->read('UsuarioSuspeito'))
        {
            $this->Monitoria->monitorar($auditoria);
        }

        $this->viewBuilder()->layout('print');

        $this->set('title', 'Legislação');
        $this->set('legislacao', $legislacao);
        $this->set('qtd_total', $qtd_total);
    }

    public function add()
    {
        $this->redirect(['action' => 'cadastro', 0]);
    }

    public function edit(int $id)
    {
        $this->redirect(['action' => 'cadastro', $id]);
    }

    public function cadastro(int $id)
    {
        $title = ($id > 0) ? 'Edição do Documento Legislação' : 'Novo Documento da Legislação';
        $icon = 'gavel';

        $t_legislacao = TableRegistry::get('Legislacao');
        $t_tipo_legislacao = TableRegistry::get('TipoLegislacao');
        $t_assuntos = TableRegistry::get('Assunto');

        $combo_tipo = $t_tipo_legislacao->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome',
            'conditions' => [
                'ativo' => true
        ]]);

        $assuntos = $t_assuntos->find('list', [
            'keyField' => 'id',
            'valueField' => 'descricao',
            'conditions' => [
                'tipo' => 'LG'
            ],
            'order' => [
                'descricao' => 'ASC'
            ]
        ]);

        if ($id > 0)
        {
            $legislacao = $t_legislacao->get($id, ['contain' => ['Assunto']]);
            $legislacao->hora = $legislacao->data->i18nFormat('HH:mm');

            $ap = array();

            foreach($legislacao->assuntos as $assunto)
            {
                $ap[] = $assunto->id;
            }


            $this->set('legislacao', $legislacao);
            $this->set('assuntos_pivot', $ap);
        }
        else
        {
            $this->set('legislacao', null);
            $this->set('assuntos_pivot', []);
        }

        $this->set('title', $title);
        $this->set('icon', $icon);
        $this->set('assuntos', $assuntos);
        $this->set('tipos', $combo_tipo);
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

    public function relacionamentos(int $id)
    {
        $this->set('title', 'Legislação Relacionada');
        $this->set('icon', 'gavel');
        $this->set('id', $id);
    }

    public function list()
    {
        $this->validationRole = false;

        if ($this->request->is('post') || $this->request->is('ajax'))
        {
            $chave = $this->request->query('chave');
            $t_legislacao = TableRegistry::get('Legislacao');

            $resultado = $t_legislacao->find('all', [
                'conditions' => [
                    'numero LIKE ' => '%' . $chave . '%'
                ],
                'limit' => 15
            ])->orWhere([
                'titulo LIKE ' => '%' . $chave . '%'
            ]);

            $this->set([
                'resultado' => $resultado,
                '_serialize' => ['resultado']
            ]);
        }
    }

    public function delete(int $id)
    {
        try
        {
            $t_legislacao = TableRegistry::get('Legislacao');
            $marcado = $t_legislacao->get($id);

            $propriedades = $marcado->getOriginalValues();

            $this->removerArquivo($marcado->arquivo);

            $t_legislacao->delete($marcado);

            $this->Flash->greatSuccess('O documento da legislação foi excluído com sucesso!');

            $auditoria = [
                'ocorrencia' => 23,
                'descricao' => 'O usuário excluiu um documento da legislação.',
                'dado_adicional' => json_encode(['legislacao_excluida' => $id, 'dados_legislacao_excluida' => $propriedades]),
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
            $this->Flash->exception('Ocorreu um erro no sistema ao excluir um documento da legislação.', [
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
            $t_legislacao = TableRegistry::get('Legislacao');
            $entity = $t_legislacao->newEntity($this->request->data());

            if($entity->hora == '')
            {
                $pivot = new DateTime();
                $hora = $pivot->format('H:i:s');
            }
            else
            {
                $hora = $entity->hora;
            }

            $entity->data = $this->Format->mergeDateDB($entity->data, $hora);
            $entity->tipo = $this->request->getData('tipo');

            $assuntos = json_decode($entity->lassuntos);

            $arquivo = $this->request->getData('arquivo');
            $entity->arquivo = $this->salvarArquivo($arquivo);

            $t_legislacao->save($entity);
            $auditoria_assuntos = $this->atualizarAssuntosLegislacao($entity, $assuntos, false);

            $this->Flash->greatSuccess('O documento da legislação foi salvo com sucesso.');

            $propriedades = $entity->getOriginalValues();

            $auditoria = [
                'ocorrencia' => 21,
                'descricao' => 'O usuário criou um novo documento da legislação.',
                'dado_adicional' => json_encode([
                    'id_nova_legislacao' => $entity->id,
                    'dados_legislacao' => $propriedades,
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
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar o documento da legislação.', [
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
            $t_legislacao = TableRegistry::get('Legislacao');
            $entity = $t_legislacao->get($id);

            $antigo_arquivo = $entity->arquivo;

            $t_legislacao->patchEntity($entity, $this->request->data());

            $entity->data = $this->Format->mergeDateDB($entity->data, $entity->hora);
            $entity->tipo = $this->request->getData('tipo');
            $enviaArquivo = ($this->request->getData('enviaArquivo') == 'true');

            $assuntos = json_decode($entity->lassuntos);

            if($enviaArquivo)
            {
                $this->removerArquivo($antigo_arquivo);
                $arquivo = $this->request->getData('arquivo');
                $entity->arquivo = $this->salvarArquivo($arquivo);
            }
            else
            {
                $entity->arquivo = $antigo_arquivo;
            }

            $propriedades = $this->Auditoria->changedOriginalFields($entity);
            $modificadas = $this->Auditoria->changedFields($entity, $propriedades);

            $t_legislacao->save($entity);
            $auditoria_assuntos = $this->atualizarAssuntosLegislacao($entity, $assuntos, true);

            $this->Flash->greatSuccess('O documento da legislação foi salvo com sucesso.');

            $auditoria = [
                'ocorrencia' => 22,
                'descricao' => 'O usuário editou um documento da legislação.',
                'dado_adicional' => json_encode([
                    'legislacao_modificada' => $id,
                    'valores_originais' => $propriedades,
                    'valores_modificados' => $modificadas,
                    'assuntos_associados' => $auditoria_assuntos]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if($this->request->session()->read('UsuarioSuspeito'))
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['action' => 'cadastro', $id]);
        }
        catch(Exception $ex)
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar o documento da legislação', [
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
        $diretorio = Configure::read('Files.paths.legislacao');
        $url_relativa = Configure::read('Files.urls.legislacao');

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

    private function atualizarAssuntosLegislacao(Entity $entity, array $assuntos, bool $clear = false)
    {
        $t_assunto = TableRegistry::get('Assunto');
        $t_legislacao = TableRegistry::get('Legislacao');
        $id_legislacao = $entity->id;

        $conn = ConnectionManager::get(BaseTable::defaultConnectionName());

        $a_antigos = array();
        $a_novos = array();

        if($clear)
        {
            $e = $t_legislacao->get($id_legislacao, [
                'contain' => ['Assunto']
            ]);

            foreach($e->assuntos as $assunto)
            {
                $a_antigos[$assunto->id] = $assunto->descricao;
            }

            $conn->delete('assuntos_legislacao', [
                'legislacao' => $id_legislacao
            ]);
        }

        foreach($assuntos as $assunto)
        {
            $qtd = $t_assunto->find('all', [
                'conditions' => [
                    'descricao' => $assunto->nome,
                    'tipo' => 'LG'
                ]
            ])->count();

            if($qtd == 0)
            {
                $na = $t_assunto->newEntity();
                $na->descricao = $assunto->nome;
                $na->tipo = 'LG';

                $t_assunto->save($na);

                $assunto->id = $na->id;
            }

            $conn->insert('assuntos_legislacao', [
                'legislacao' => $id_legislacao,
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
}
