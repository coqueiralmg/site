<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;
use \Exception;
use \DateTime;

class PublicacoesController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $t_publicacoes = TableRegistry::get('Publicacao');
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

        $opcao_paginacao = [
            'name' => 'publicações',
            'name_singular' => 'publicação',
            'predicate' => 'encontradas',
            'singular' => 'encontrada'
        ];

        $combo_mostra = ["T" => "Todos", "A" => "Somente ativos", "I" => "Somente inativos"];

        $publicacoes = $this->paginate($t_publicacoes);

        $qtd_total = $t_publicacoes->find('all', [
            'conditions' => $condicoes]
        )->count();

        $this->set('title', 'Publicações');
        $this->set('icon', 'insert_drive_file');
        $this->set('combo_mostra', $combo_mostra);
        $this->set('publicacoes', $publicacoes);
        $this->set('qtd_total', $qtd_total);
        $this->set('limit_pagination', $limite_paginacao);
        $this->set('opcao_paginacao', $opcao_paginacao);
        $this->set('data', $data);
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
        $title = ($id > 0) ? 'Edição de Publicação' : 'Nova Publicação';
        $t_publicacoes = TableRegistry::get('Publicacao');

        if($id > 0)
        {
            $publicacao = $t_publicacoes->get($id);
            $publicacao->hora = $publicacao->data->i18nFormat('HH:mm');

            $this->set('publicacao', $publicacao);
        }
        else
        {
            $this->set('publicacao', null);
        }

        $this->set('title', $title);
        $this->set('icon', 'insert_drive_file');
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

    protected function insert()
    {
        try
        {
            $t_publicacoes = TableRegistry::get('Publicacao');
            $entity = $t_publicacoes->newEntity($this->request->data());

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

            $t_publicacoes->save($entity);
            $this->Flash->greatSuccess('A publicação foi salva com sucesso.');

            $propriedades = $entity->getOriginalValues();

            $auditoria = [
                'ocorrencia' => 21,
                'descricao' => 'O usuário criou uma nova publicação.',
                'dado_adicional' => json_encode(['id_nova_publicacao' => $entity->id, 'dados_publicacao' => $propriedades]),
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
            $t_publicacoes = TableRegistry::get('Publicacao');
            $entity = $t_publicacoes->get($id);

            $antigo_arquivo = $entity->arquivo;

            $t_publicacoes->patchEntity($entity, $this->request->data());

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

            $t_publicacoes->save($entity);
            $this->Flash->greatSuccess('A publicação foi salva com sucesso.');

            $auditoria = [
                'ocorrencia' => 22,
                'descricao' => 'O usuário editou uma publicação.',
                'dado_adicional' => json_encode(['publicacao_modificada' => $id, 'valores_originais' => $propriedades, 'valores_modificados' => $modificadas]),
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
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar a publicação', [
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
        $diretorio = Configure::read('Files.paths.publicacao');
        $url_relativa = Configure::read('Files.urls.publicacao');

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
