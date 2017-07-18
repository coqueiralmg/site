<?php

namespace App\Controller\Component;

use Cake\Controller\Component;

class FormatComponent extends Component
{
    protected $charMask = ['.', '(', ')', '-', '/'];

    /**
     * Limpa a máscara de uma String
     * @param string $masked String com máscara.
     * @return string String sem máscara.
     */
    public function clearMask($masked)
    {
        return str_replace($this->charMask, '', $masked);
    }

    /**
     * Converte a data no formato local, para o formato aceito do banco de dados.
     * @param string $data A data usada na tela, reconhecida pelo usuário
     * @return string A data no formato reconhecido pelo banco de dados.
     */
    public function formatDateDB($data)
    {
        $result = null;

        if ($data != '')
        {
            $result = date('Y-m-d', strtotime(str_replace('/', '-', $data)));
        }

        return $result;
    }

    /**
     * Converte a data no formato de banco para o formato da data compreensível ao usuário.
     * @param string $data A data usada no formato do banco de dados.
     * @return string A data no formato do usuário.
     */
    public function formatDateView($data)
    {
        $result = null;

        if ($data == null)
        {
            $result = '';
        }
        else
        {
            $result = date('d/m/Y', strtotime($data));
        }

        return $result;
    }
}