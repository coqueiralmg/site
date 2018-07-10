<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Network\Session;
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

        $combo_tipo = $t_tipo_legislacao->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome',
            'conditions' => [
                'ativo' => true
        ]]);

        if ($id > 0)
        {
            $legislacao = $t_legislacao->get($id);
            $legislacao->hora = $legislacao->data->i18nFormat('HH:mm');

            $this->set('legislacao', $legislacao);
        }
        else
        {
            $this->set('legislacao', null);
        }

        $this->set('title', $title);
        $this->set('icon', $icon);
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

            $arquivo = $this->request->getData('arquivo');
            $entity->arquivo = $this->salvarArquivo($arquivo);

            $t_legislacao->save($entity);
            $this->Flash->greatSuccess('O documento da legislação foi salvo com sucesso.');

            $propriedades = $entity->getOriginalValues();

            $auditoria = [
                'ocorrencia' => 21,
                'descricao' => 'O usuário criou um novo documento da legislação.',
                'dado_adicional' => json_encode(['id_nova_legislacao' => $entity->id, 'dados_legislacao' => $propriedades]),
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
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar a publicação', [
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
            $enviaArquivo = ($this->request->getData('enviaArquivo') == 'true');

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
            $this->Flash->greatSuccess('O documento da legislação foi salvo com sucesso.');

            $auditoria = [
                'ocorrencia' => 22,
                'descricao' => 'O usuário editou um documento da legislação.',
                'dado_adicional' => json_encode(['legislacao_modificada' => $id, 'valores_originais' => $propriedades, 'valores_modificados' => $modificadas]),
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
}
