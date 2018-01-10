<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\I18n\Date;
use \DateTime;

class FormatComponent extends Component
{
    protected $charMask = ['.', '(', ')', '-', '/'];

    /**
     * Limpa a máscara de uma String
     * @param string $masked String com máscara.
     * @return string String sem máscara.
     */
    public function clearMask(string $masked)
    {
        return str_replace($this->charMask, '', $masked);
    }

    /**
     * Converte a data no formato local, para o formato aceito do banco de dados.
     * @param string $data A data usada na tela, reconhecida pelo usuário
     * @return string A data no formato reconhecido pelo banco de dados.
     */
    public function formatDateDB(string $data)
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
        var_dump($data);
        $pivot = new Date($data);
        
        return $pivot->format('d/m/Y');
    }

    /**
    * Mescla data e hora e retorna em um formato de banco de dados
    * @param $data Data
    * @param $data Hora
    * @return string A data no formato reconhecido pelo banco de dados.
    */
    public function mergeDateDB($data, $hora)
    {
        $merge = new DateTime($this->formatDateDB($data) . ' ' . $hora);
        return $merge->format('Y-m-d H:i:s');
    }

    /**
     * Formata um número colocando zeros a esquerda
     * @param string $value O valor a ser formatado
     * @param int $lenght A quantidade de zeros a ser adicionada. Por padrão, será 7.
     * @return string O valor formatado.
     */
    public function zeroPad(string $value, int $lenght = 7)
    {
        return str_pad($value, $lenght, '0', STR_PAD_LEFT);
    }
}