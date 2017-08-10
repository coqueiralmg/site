<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use \Exception;

class UploadController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function imageEditor()
    {
        if($this->request->is('post'))
        {
            $this->autoRender = false;

            $diretorio = Configure::read('Files.paths.editor');
            $url_relativa = Configure::read('Files.urls.editor');

            $arquivo = $this->request->getData('upload');
            $temp = $arquivo['tmp_name'];
            $nome_arquivo = $arquivo['name'];

            $file = new File($temp);
            $pivot = new File($nome_arquivo);

            if(!$this->File->validationExtension($pivot, $this->File::TYPE_FILE_IMAGE))
            {
                $mensagem = "A extensão do arquivo é inválida.";
                
                die("A extensão do arquivo é inválida.");

                echo "<script type='text/javascript'>alert('$mensagem');</script>";
            }
            elseif(!$this->File->validationSize($file))
            {
                $maximo = $this->File->getMaxLengh($this->File::TYPE_FILE_IMAGE);
                $divisor = Configure::read('Files.misc.megabyte');

                $maximo = round($maximo / $divisor, 0);

                $mensagem = "O tamaho do arquivo enviado é muito grande. O tamanho máximo do arquivo de imagens é de $maximo MB.";

                die($mensagem);

                echo "<script type='text/javascript'>alert('$mensagem');</script>";
            }  

            $file->copy($diretorio . $nome_arquivo, true);

            echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction(1, '" . $url_relativa . $nome_arquivo . "', '');</script>";
        }
    }
}