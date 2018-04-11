<?php

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\I18n\Date;

/**
 * Classe de formatação em geral para exibição ao usuário
 */
class FormatHelper extends Helper
{
    /**
     * Dias de semana traduzíveis pelo sistema, por meio de valores padrão do PHP.
     */
    private $dias_semana = [
        'Sunday' => 'Domingo',
        'Monday' => 'Segunda-Feira',
        'Tuesday' => 'Terça-Feira',
        'Wednesday' => 'Quarta-Feira',
        'Thursday' => 'Quinta-Feira',
        'Friday' => 'Sexta-Feira',
        'Saturday' => 'Sábado',
    ];
    
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

    /**
     * Retorna a data formatada visível para usuário.
     * @param $data Data em formato padrão.
     * @param bool $complete Se é possível exibir o formato completo.
     * @return string Data em formato visível para usuário.
     */
    public function date($data, bool $complete = false)
    {
        if ($data == null) {
            $data = '';
        } else {

            if ($complete) {
                $data = date_format($data, 'd/m/Y H:i:s');
            } else {
                $data = date_format($data, 'd/m/Y');
            }
        }

        return $data;
    }

    /**
     * Retorna o nome do dia de semana, com a data informada.
     * @param $data Data informada
     * @return string Nome do dia de semana nominal.
     */
    public function dayWeek($data)
    {
        return $this->dias_semana[date_format($data, 'l')];
    }

}