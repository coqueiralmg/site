<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

/**
 * Classe que representa o componente de controle e gerenciamento de arquivos dentro do sistema.
 * @package App\Controller\Component
 */
class FileComponent extends Component
{
    const TYPE_FILE_DOCUMENT = 'document';
    const TYPE_FILE_IMAGE = 'image';
    
    public function validation(File $file)
    {   
        $valido = 1;

        if(!$this->validationExtension($file)) $valido = 0;
        if(!$this->validationSize($file)) $valido = -1;

        return $valido;
    }

    public function validationExtension(File $file, string $tipo = null)
    {
        $valido = false;
        $mime = $file->mime();
        $extensao = $file->ext();
        $extensoes = array();

        if(tipo == null)
        {
            $extensoes = (strpos($mime, 'image') !== false) ? Configure::read('Files.validation.document.types') : Configure::read('Files.validation.image.types');
        }
        else
        {
            switch ($tipo) {
                case 'document':
                    $extensoes = Configure::read('Files.validation.document.types');
                    break;
                
                case 'image':
                    $extensoes = Configure::read('Files.validation.image.types');
                    break;
                
                default:
                    $extensoes = array();
                    break;
            }
        }
        
        var_dump($extensoes);
        var_dump($extensao);

        foreach ($extensoes as $tipo) {
            if($extensao == $tipo)
            {
                $valido = true;
                break;
            }
        }

        return $valido;
    }

    public function validationSize(File $file)
    {
        $mime = $file->mime();
        $tamanho = $file->size();
        $maximo = (strpos($mime, 'image') !== false) ? Configure::read('Files.validation.document.maxLength') : Configure::read('Files.validation.image.maxLength');

        return ($tamanho <= $maximo);
    }
}