<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Utility\Text;


class Post extends Entity
{
    protected function _getSlug()
    {
        $titulo = $this->_properties['titulo'];
        $procurar = array(' ', 'ã', 'à', 'á', 'â', 'é', 'ê', 'í', 'ì', 'ó', 'ò', 'õ', 'ô', 'ú', 'ù', 'û', 'ç', ',', '.', '!', '?', ';', '/');
        $substituir = array('_', 'a', 'a', 'a', 'a', 'e', 'e', 'i', 'i', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'c', '', '', '', '', '', '_');
        
        return strtolower(str_replace($procurar, $substituir, $titulo));
    }

    protected function _getDestacado()
    {
        return $this->_properties['destaque'] ? 'Sim' : 'Não';
    }

    protected function _getAtivado()
    {
        return $this->_properties['ativo'] ? 'Sim' : 'Não';
    }

    protected function _getTruncado()
    {
        $limiteCaracteres = 45;
        $titulo = $this->_properties['titulo'];
        $reticences = "";

        if (strlen($titulo) > $limiteCaracteres){
            $reticences = "...";
            $limite = substr($titulo, 0, $limiteCaracteres);
            $posicaoString = strrpos($limite, " ");
            $cortaTexto = ($posicaoString > 0) ? $posicaoString : strlen($limite);
            $titulo = substr($limite, 0, $cortaTexto);
        }

        return $titulo . $reticences;
    }
}