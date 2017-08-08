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
            $diretorio = ROOT . DS . '..' . DS . 'webroot' . DS . 'public' . DS . 'editor' . DS . 'images' . DS;
            $url_relativa = '/public/editor/images/';
            $arquivo = $this->request->getData('upload');
            $temp = $arquivo['tmp_name'];
            $nome_arquivo = $arquivo['name'];
            $response = array();

            $file = new File($temp);

            var_dump($this->File::TYPE_FILE_IMAGE);

            if(!$this->File->validationExtension($file, $this->File::TYPE_FILE_IMAGE))
            {
                throw new Exception("A extensão do arquivo é inválida.");
            }
            elseif(!$this->File->validationSize($file))
            {
                throw new Exception("O tamaho do arquivo enviado é muito grande.");
            }  

            $file->copy($diretorio . $nome_arquivo, true);

            echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction(1, '" . $url_relativa . $nome_arquivo . "', '');</script>";
            
        }
    }
}