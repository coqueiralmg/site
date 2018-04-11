<?php

namespace App\Shell\Task;

use Cake\Console\Shell;

/**
 * Classe de formatação em geral para exibição ao usuário
 */
class FormatTask extends Shell
{
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
     * Converte o HTML Special Char em caractere propriamente dito.
     */
    public function charDecode($valor)
    {
        $procurar = array('&aacute;', '&atilde;', '&agrave;', '&acirc;', '&ccedil;', '&eacute;', '&ecirc;', '&iacute;', '&oacute;', '&otilde;', '&uacute;');
        $substituir = array('á', 'ã', 'à', 'â', 'ç', 'é', 'ê', 'í', 'ó', 'õ', 'ú');

        return str_replace($procurar, $substituir, $valor);
    }
}
