<?php

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\Utility\Inflector;

class FileHelper extends Helper
{
    /**
     * Retorna apenas o nome do arquivo, passando o caminho completo do arquivo
     * @param string $value Caminho completo do arquivo
     * @return string Nome do arquivo
     */
    public function nameFile(string $value)
    {
        $pivot = explode('/', $value);
        $arquivo = end($pivot);

        return $arquivo;
    }

}
