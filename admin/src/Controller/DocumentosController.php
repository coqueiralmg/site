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
        try
        {
            $t_concursos = TableRegistry::get('Concurso');
            $entity = $t_concursos->get($id);

            $t_concursos->patchEntity($entity, $this->request->data());

            $entity->inscricaoInicio = $this->Format->formatDateDB($entity->inscricao_inicio);
            $entity->inscricaoFim = $this->Format->formatDateDB($entity->inscricao_fim);
            $entity->dataProva = $this->Format->formatDateDB($entity->data_prova);

            $propriedades = $this->Auditoria->changedOriginalFields($entity);
            $modificadas = $this->Auditoria->changedFields($entity, $propriedades);

            $t_concursos->save($entity);
            $this->Flash->greatSuccess('O concurso ou processo seletivo foi salvo com sucesso.');

            $auditoria = [
                'ocorrencia' => 58,
                'descricao' => 'O usuário editou uma concurso ou um processo seletivo.',
                'dado_adicional' => json_encode(['concurso_modificado' => $id, 'valores_originais' => $propriedades, 'valores_modificados' => $modificadas]),
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
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar os dados do concurso público ou processo seletivo.', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['action' => 'cadastro', 0]);
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
