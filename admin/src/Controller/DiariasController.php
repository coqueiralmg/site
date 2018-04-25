<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\I18n\Number;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;
use \Exception;
use \DateTime;

class DiariasController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $t_diarias = TableRegistry::get('Diaria');
        $limite_paginacao = Configure::read('Pagination.limit');

        $condicoes = array();
        $data = array();

        if (count($this->request->getQueryParams()) > 3)
        {
            $beneficiario = $this->request->query('beneficiario');
            $data_inicial = $this->request->query('data_inicial');
            $data_final = $this->request->query('data_final');
            $destino = $this->request->query('destino');
            $placa = $this->request->query('placa');
            $mostrar = $this->request->query('mostrar');

            if($beneficiario != "")
            {
                $condicoes['beneficiario LIKE'] = '%' . $beneficiario . '%';
            }

            if ($data_inicial != "" && $data_final != "")
            {
                $condicoes["periodoInicio >="] = $this->Format->formatDateDB($data_inicial);
                $condicoes["periodoFim <="] = $this->Format->formatDateDB($data_final);
            }

            if($destino != "")
            {
                $condicoes['destino LIKE'] = '%' . $destino . '%';
            }

            if($placa != "")
            {
                $condicoes['placa LIKE'] = '%' . $placa . '%';
            }

            if ($mostrar != 'T')
            {
                $condicoes["ativo"] = ($mostrar == "A") ? "1" : "0";
            }

            $data['beneficiario'] = $beneficiario;
            $data['data_inicial'] = $data_inicial;
            $data['data_final'] = $data_final;
            $data['destino'] = $destino;
            $data['placa'] = $placa;
            $data['mostrar'] = $mostrar;

            $this->request->data = $data;
        }

        $this->paginate = [
            'limit' => $limite_paginacao,
            'conditions' => $condicoes,
            'order' => [
                'dataAutorizacao' => 'DESC'
            ]
        ];

        $diarias = $this->paginate($t_diarias);

        $qtd_total = $t_diarias->find('all', [
            'conditions' => $condicoes
        ])->count();

        $combo_mostra = ["T" => "Todos", "A" => "Somente ativos", "I" => "Somente inativos"];

        $this->set('title', 'Diárias de Viagem');
        $this->set('icon', 'directions_car');
        $this->set('diarias', $diarias);
        $this->set('qtd_total', $qtd_total);
        $this->set('combo_mostra', $combo_mostra);
        $this->set('limit_pagination', $limite_paginacao);
        $this->set('data', $data);
    }

    public function imprimir()
    {
        $t_diarias = TableRegistry::get('Diaria');

        $condicoes = array();

        if (count($this->request->getQueryParams()) > 3)
        {
            $beneficiario = $this->request->query('beneficiario');
            $data_inicial = $this->request->query('data_inicial');
            $data_final = $this->request->query('data_final');
            $destino = $this->request->query('destino');
            $placa = $this->request->query('placa');
            $mostrar = $this->request->query('mostrar');

            if($beneficiario != "")
            {
                $condicoes['beneficiario LIKE'] = '%' . $beneficiario . '%';
            }

            if ($data_inicial != "" && $data_final != "")
            {
                $condicoes["periodoInicio >="] = $this->Format->formatDateDB($data_inicial);
                $condicoes["periodoFim <="] = $this->Format->formatDateDB($data_final);
            }

            if($destino != "")
            {
                $condicoes['destino LIKE'] = '%' . $destino . '%';
            }

            if($placa != "")
            {
                $condicoes['placa LIKE'] = '%' . $placa . '%';
            }

            if ($mostrar != 'T')
            {
                $condicoes["ativo"] = ($mostrar == "A") ? "1" : "0";
            }
        }

        $diarias = $t_diarias->find('all', [
            'conditions' => $condicoes,
            'order' => [
                'dataAutorizacao' => 'DESC'
            ]
        ]);

        $qtd_total = $diarias->count();

        $auditoria = [
            'ocorrencia' => 9,
            'descricao' => 'O usuário solicitou a impressão da lista de relatórios de diárias.',
            'usuario' => $this->request->session()->read('UsuarioID')
        ];

        $this->Auditoria->registrar($auditoria);

        if ($this->request->session()->read('UsuarioSuspeito'))
        {
            $this->Monitoria->monitorar($auditoria);
        }

        $this->viewBuilder()->layout('print');

        $this->set('title', 'Diárias de Viagem');
        $this->set('diarias', $diarias);
        $this->set('qtd_total', $qtd_total);
    }

    public function add()
    {
        $this->Flash->info('Dica: A data de autorização será preenchida automaticamente com a data corrente, caso seja deixada em branco.');
        $this->redirect(['action' => 'cadastro', 0]);
    }

    public function edit(int $id)
    {
        $this->redirect(['action' => 'cadastro', $id]);
    }

    public function cadastro(int $id)
    {
        $title = ($id > 0) ? 'Edição da Diária' : 'Novo Relatório de Diária';
        $icon = 'work';

        $t_diarias = TableRegistry::get('Diaria');

        if($id > 0)
        {
            $diaria = $t_diarias->get($id);

            $diaria->valor = Number::precision($diaria->valor, 2);
            $diaria->dataAutorizacao = $diaria->dataAutorizacao->i18nFormat('dd/MM/yyyy');
            $diaria->periodoInicio = $diaria->periodoInicio->i18nFormat('dd/MM/yyyy');
            $diaria->periodoFim = $diaria->periodoFim->i18nFormat('dd/MM/yyyy');

            $this->set('diaria', $diaria);
        }
        else
        {
            $this->set('diaria', null);
        }

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
            $t_diarias = TableRegistry::get('Diaria');
            $marcado = $t_diarias->get($id);

            $beneficiario = $marcado->beneficiario;

            $propriedades = $marcado->getOriginalValues();

            $this->removerArquivo($marcado->documento);

            $t_diarias->delete($marcado);

            $this->Flash->greatSuccess('O relatório de diárias para o beneficiário ' . $beneficiario . ' foi excluído com sucesso!');

            $auditoria = [
                'ocorrencia' => 56,
                'descricao' => 'O usuário excluiu um relatório de diárias.',
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
            $this->Flash->exception('Ocorreu um erro no sistema ao excluir o relatório de diárias.', [
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
            $t_diarias = TableRegistry::get('Diaria');
            $entity = $t_diarias->newEntity($this->request->data());

            $entity->dataAutorizacao = $this->obterDataAutorizacao($entity->dataAutorizacao);
            $entity->periodoInicio = $this->Format->formatDateDB($entity->periodoInicio);
            $entity->periodoFim = $this->Format->formatDateDB($entity->periodoFim);

            $arquivo = $this->request->getData('arquivo');
            $entity->documento = $this->salvarArquivo($arquivo);

            $t_diarias->save($entity);
            $this->Flash->greatSuccess('Relatório de diárias salvo com sucesso.');

            $propriedades = $entity->getOriginalValues();

            $auditoria = [
                'ocorrencia' => 54,
                'descricao' => 'O usuário criou um novo relatório de diárias.',
                'dado_adicional' => json_encode(['id_nova_diaria' => $entity->id, 'dados_diaria' => $propriedades]),
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
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar o relatório de diárias.', [
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
            $t_diarias = TableRegistry::get('Diaria');
            $entity = $t_diarias->get($id);

            $antigo_arquivo = $entity->documento;

            $t_diarias->patchEntity($entity, $this->request->data());

            $entity->dataAutorizacao = $this->Format->formatDateDB($entity->dataAutorizacao);
            $entity->periodoInicio = $this->Format->formatDateDB($entity->periodoInicio);
            $entity->periodoFim = $this->Format->formatDateDB($entity->periodoFim);

            $enviaArquivo = ($this->request->getData('enviaArquivo') == 'true');

            if($enviaArquivo)
            {
                $this->removerArquivo($antigo_arquivo);
                $arquivo = $this->request->getData('arquivo');
                $entity->documento = $this->salvarArquivo($arquivo);
            }

            $propriedades = $this->Auditoria->changedOriginalFields($entity);
            $modificadas = $this->Auditoria->changedFields($entity, $propriedades);

            $t_diarias->save($entity);
            $this->Flash->greatSuccess('Relatório de diárias salvo com sucesso.');

            $auditoria = [
                'ocorrencia' => 55,
                'descricao' => 'O usuário editou um relatório de diárias.',
                'dado_adicional' => json_encode(['diaria_modificada' => $id, 'valores_originais' => $propriedades, 'valores_modificados' => $modificadas]),
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
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar o relatório de diárias.', [
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
        $diretorio = Configure::read('Files.paths.diarias');
        $url_relativa = Configure::read('Files.urls.diarias');

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

    private function obterDataAutorizacao($data)
    {
        $pivot = null;

        if($data == "")
        {
            $pivot = date("Y-m-d");
        }
        else
        {
            $pivot = $this->Format->formatDateDB($data);
        }

        return $pivot;
    }
}
