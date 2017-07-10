<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;


class UploadController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function image()
    {
        if($this->request->is('post'))
        {
            $diretorio = ROOT . DS . '..' . DS . 'webroot' . DS . 'public' . DS . 'editor' . DS;
            $url_relativa = '/public/editor/';
            $arquivo = $this->request->getData('upload');
            $temp = $arquivo['tmp_name'];
            $nome_arquivo = $arquivo['name'];

            $file = new File($temp);

            if($file->copy($diretorio . $nome_arquivo, true))
            {
                $this->set([
                    'uploaded' => 1,
                    'fileName' => $nome_arquivo,
                    'url' => $url_relativa . $nome_arquivo,
                    '_serialize' => ['uploaded', 'fileName', 'url']
                ]);
            }
            else
            {
                $this->set([
                    'uploaded' => 0,
                    'error' => ['message' => 'Ocorreu um erro ao subir a imagem.'],
                    '_serialize' => ['uploaded', 'error']
                ]);
            }
            
        }
    }
}