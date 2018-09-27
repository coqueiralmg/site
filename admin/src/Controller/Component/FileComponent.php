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

    /**
    * Faz a validação geral no arquivo. A função retorna os seguintes valores:
    * 1 = Arquivo válido;
    * 0 = Arquivo com extensão inválida;
    * -1 = Arquivo com tamanho inválido
    * @param File $file Arquivo a ser validado
    * @return 1 = Arquivo válido; 0 = Arquivo com extensão inválida; -1 = Arquivo com tamanho inválido
    */
    public function validation(File $file)
    {
        $valido = 1;

        if(!$this->validationExtension($file)) $valido = 0;
        if(!$this->validationSize($file)) $valido = -1;

        return $valido;
    }

    /**
    * Valida o arquivo de acordo com a extensão determinada no arquivo de configuração file.
    * @param File $file Arquivo a ser validado
    * @param string $tipo Tipo de arquivo analisado. Caso não seja declarado, o método irá detectar o tipo de arquivo automaticamente.
    * @return Retorna se o arquivo possui uma extensão válida.
    */
    public function validationExtension(File $file, string $tipo = null)
    {
        $valido = false;
        $mime = $file->mime();
        $extensao = $file->ext();
        $extensoes = array();

        if($tipo == null)
        {
            $extensoes = (strpos($mime, 'image') !== false) ? Configure::read('Files.validation.image.types') : Configure::read('Files.validation.document.types');
        }
        else
        {
            $extensoes = $this->getExtensions($tipo);
        }

        foreach ($extensoes as $tipo) {
            if(strtolower($extensao) == $tipo)
            {
                $valido = true;
                break;
            }
        }

        return $valido;
    }

    /**
    * Valida o arquivo de acordo com o tamanho do arquivo, determinada no arquivo de configuração file.
    * @param File $file Arquivo a ser validado
    * @return Retorna se o arquivo possui uma tamanho de arquivo válido.
    */
    public function validationSize(File $file)
    {
        $mime = $file->mime();
        $tamanho = $file->size();

        $maximo = (strpos($mime, 'image') !== false) ? Configure::read('Files.validation.image.maxLength') : Configure::read('Files.validation.document.maxLength');

        return ($tamanho <= $maximo);
    }

    /**
    * Obtém a lista de extensões de arquivo válido, por tipo de arquivo.
    * @param string $tipo Tipo de arquivo para validação
    * @return Tamanho máximo de arquivo, de acordo com o tipo do arquivo.
    */
    public function getExtensions(string $tipo)
    {
        $extensoes = 0;

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

        return $extensoes;
    }

    /**
    * Obtém o tamanho máximo de tamanho de arquivo válido, por tipo de arquivo.
    * @param string $tipo Tipo de arquivo para validação
    * @return Tamanho máximo de arquivo, de acordo com o tipo do arquivo.
    */
    public function getMaxLengh(string $tipo)
    {
        $maximo = 0;

        switch ($tipo) {
            case 'document':
                $maximo = Configure::read('Files.validation.document.maxLength');
                break;

            case 'image':
                $maximo = Configure::read('Files.validation.image.maxLength');
                break;

            default:
                $maximo = 0;
                break;
        }

        return $maximo;
    }

    /**
    * Verifica que o arquivo existe em um determinado diretório
    * @param string $directory Diretório de arquivos a ser verificado e validado.
    * @param string $nameFile Nome do arquivo a ser validado.
    * @return Se o arquivo existe no diretório.
    */
    public function fileNameExists(string $directory, string $nameFile)
    {
        $dir = new Folder($directory);
        $files = $dir->find();
        $exist = false;

        foreach ($files as $file) {
            if($file == $nameFile)
            {
                $exist = true;
                break;
            }
        }

        return $exist;
    }
}
