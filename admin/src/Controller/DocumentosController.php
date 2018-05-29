<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;
use \Exception;

class DocumentosController extends AppController
{
    public function initialize()
    {
        parent::initialize();
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
        $t_documentos = TableRegistry::get('Documento');

        $marcado = $t_documentos->get($id);
        $descricao = $marcado->descricao;
        $concurso = $marcado->concurso;

        $propriedades = $marcado->getOriginalValues();

        $t_documentos->delete($marcado);

        $this->Flash->greatSuccess('O documento ' . $descricao . ' foi excluído com sucesso!');

        $auditoria = [
            'ocorrencia' => 62,
            'descricao' => 'O usuário excluiu um documento anexo de concurso ou um processo seletivo.',
            'dado_adicional' => json_encode(['dado_excluido' => $id, 'dados_registro_excluido' => $propriedades]),
            'usuario' => $this->request->session()->read('UsuarioID')
        ];

        $this->Auditoria->registrar($auditoria);

        if($this->request->session()->read('UsuarioSuspeito'))
        {
            $this->Monitoria->monitorar($auditoria);
        }

        $this->redirect(['controller' => 'concursos', 'action' => 'anexos', $concurso]);
    }

    protected function insert()
    {
        $idConcurso = $this->request->getData('concurso');

        try
        {
            $t_documentos = TableRegistry::get('Documento');
            $entity = $t_documentos->newEntity($this->request->data());

            $entity->data = $this->Format->formatDateDB($entity->data);
            $entity->concurso = $idConcurso;

            $arquivo = $this->request->getData('arquivo');
            $entity->arquivo = $this->salvarArquivo($arquivo);

            $t_documentos->save($entity);
            $this->Flash->greatSuccess('O anexo do concurso foi inserido com sucesso.');

            $propriedades = $entity->getOriginalValues();

            $auditoria = [
                'ocorrencia' => 60,
                'descricao' => 'O usuário adicionou o anexo do concurso ou processo seletivo.',
                'dado_adicional' => json_encode(['id_novo_documento_concurso' => $entity->id, 'dados_anexo_concurso' => $propriedades]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if($this->request->session()->read('UsuarioSuspeito'))
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['controller' => 'concursos', 'action' => 'anexo', $entity->id, '?' => ['idConcurso' => $entity->concurso]]);
        }
        catch(Exception $ex)
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao efetuar cadastro do concurso público ou processo seletivo.', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);


            $this->redirect(['controller' => 'concursos', 'action' => 'anexo', 0, '?' => ['idConcurso' => $idConcurso]]);
        }
    }

    protected function update(int $id)
    {
        $idConcurso = $this->request->getData('concurso');

        try
        {
            $t_documentos = TableRegistry::get('Documento');
            $entity = $t_documentos->get($id);

            $antigo_arquivo = $entity->arquivo;

            $t_documentos->patchEntity($entity, $this->request->data());

            $entity->data = $this->Format->formatDateDB($entity->data);
            $entity->concurso = $idConcurso;

            $enviaArquivo = ($this->request->getData('enviaArquivo') == 'true');

            if($enviaArquivo)
            {
                $this->removerArquivo($antigo_arquivo);
                $arquivo = $this->request->getData('arquivo');
                $entity->arquivo = $this->salvarArquivo($arquivo);
            }

            $propriedades = $this->Auditoria->changedOriginalFields($entity);
            $modificadas = $this->Auditoria->changedFields($entity, $propriedades);

            $t_documentos->save($entity);
            $this->Flash->greatSuccess('O anexo do concurso foi salvo com sucesso.');

            $auditoria = [
                'ocorrencia' => 61,
                'descricao' => 'O usuário editou o anexo do concurso ou processo seletivo.',
                'dado_adicional' => json_encode(['documento_anexo_modificado' => $id, 'valores_originais' => $propriedades, 'valores_modificados' => $modificadas]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if($this->request->session()->read('UsuarioSuspeito'))
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['controller' => 'concursos', 'action' => 'anexo', $id, '?' => ['idConcurso' => $idConcurso]]);
        }
        catch(Exception $ex)
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar os dados do concurso público ou processo seletivo.', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['controller' => 'concursos', 'action' => 'anexo', $id, '?' => ['idConcurso' => $idConcurso]]);
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
        $diretorio = Configure::read('Files.paths.concursos');
        $url_relativa = Configure::read('Files.urls.concursos');

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
