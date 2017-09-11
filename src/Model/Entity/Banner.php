<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;


class Banner extends Entity
{
    protected function _getLink()
    {
        $destino = $this->_properties['destino'];
        
        if($destino == null || $destino == '')
        {
            $destino = 'Nenhum';
        }

        return $destino;
    }
    
    protected function _getAtivado()
    {
        return $this->_properties['ativo'] ? 'Sim' : 'Não';
    }
}