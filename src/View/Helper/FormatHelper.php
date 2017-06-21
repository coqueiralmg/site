<?php

namespace App\View\Helper;

use Cake\View\Helper;

class FormatHelper extends Helper
{
    /**
     * Formata para o número de telefone
     * @param string $value Valor original do telefone
     * @return string Telefone formatado
     */
    public function phone(string $value)
    {
        $pattern = strlen($value) == 10 ? '/(\d{2})(\d{4})(\d*)/' : '/(\d{2})(\d{5})(\d*)/';
        $result = preg_replace($pattern, '($1) $2-$3', $value);

        return $result;
    }

    /**
     * Fora para CEP.
     * @param string $value Valor original cep
     * @return string CEP Formatado
     */
    public function zipCode(string $value)
    {
        $pattern = '/^(\d{5})(\d{3})$/';
        $result = preg_replace($pattern, '\\1-\\2', $value);

        return $result;
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

    /**
     * Retorna o primeiro nome da pessoa.
     * @param string $name Nome completo da pessoa.
     * @return string Primeiro nome da pessoa.
     */
    public function firstName(string $name)
    {
        return explode(" ", $name)[0];
    }

    public function date(string $data, bool $complete = false)
    {
        if ($data == null) {
            $data = '';
        } else {

            if ($complete) {
                $data = date('d/m/Y H:i:s', strtotime($data));
            } else {
                $data = date('d/m/Y', strtotime($data));
            }
        }

        return $data;
    }

}