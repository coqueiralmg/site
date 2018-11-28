<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;


class AnexosController extends AppController
{

    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Licitacoes');
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
        $idLicitacao = $this->request->getData('licitacao');

        try
        {
            $t_anexos = TableRegistry::get('Anexo');
            $entity = $t_anexos->newEntity($this->request->data());

            $entity->data = $this->Format->formatDateDB($entity->data);
            $entity->licitacao = $idLicitacao;

            $arquivo = $this->request->getData('arquivo');
            $entity->arquivo = $this->salvarArquivo($arquivo);

            $t_anexos->save($entity);

            $this->Licitacoes->refresh($idLicitacao);
            $this->Flash->greatSuccess('O anexo da licitação foi salvo com sucesso.');

            $propriedades = $entity->getOriginalValues();

            $auditoria = [
                'ocorrencia' => 77,
                'descricao' => 'O usuário adicionou o anexo da licitação.',
                'dado_adicional' => json_encode(['id_novo_documento_licitacao' => $entity->id, 'dados_anexo_licitacao' => $propriedades]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if($this->request->session()->read('UsuarioSuspeito'))
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['controller' => 'licitacoes', 'action' => 'anexo', $entity->id, '?' => ['idLicitacao' => $idLicitacao]]);
        }
        catch(Exception $ex)
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao efetuar cadastro da licitação.', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['controller' => 'licitacoes', 'action' => 'anexo', 0, '?' => ['idLicitacao' => $idLicitacao]]);
        }
    }

    protected function update(int $id)
    {
        $idLicitacao = $this->request->getData('licitacao');

        try
        {
            $t_anexos = TableRegistry::get('Anexo');
            $entity = $t_anexos->get($id);

            $antigo_arquivo = $entity->arquivo;

            $t_anexos->patchEntity($entity, $this->request->data());

            $entity->data = $this->Format->formatDateDB($entity->data);
            $entity->licitacao = $idLicitacao;

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

            $t_anexos->save($entity);

            $this->Licitacoes->refresh($idLicitacao);
            $this->Flash->greatSuccess('O anexo da licitação foi salvo com sucesso.');

            $propriedades = $entity->getOriginalValues();

            $auditoria = [
                'ocorrencia' => 78,
                'descricao' => 'O usuário modificou o anexo da licitação.',
                'dado_adicional' => json_encode(['documento_anexo_modificado' => $id, 'valores_originais' => $propriedades, 'valores_modificados' => $modificadas]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if($this->request->session()->read('UsuarioSuspeito'))
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['controller' => 'licitacoes', 'action' => 'anexo', $entity->id, '?' => ['idLicitacao' => $idLicitacao]]);
        }
        catch(Exception $ex)
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao efetuar cadastro da licitação.', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['controller' => 'licitacoes', 'action' => 'anexo', 0, '?' => ['idLicitacao' => $idLicitacao]]);
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
