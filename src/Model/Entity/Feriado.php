<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;


class Feriado extends Entity
{
    protected function _getTipo()
    {
        $nivel = $this->_properties['nivel'];
        
        switch($nivel)
        {
            case 'I':
                return 'Internacional';
            case 'N':
                return 'Nacional';
            case 'E':
                return 'Estadual';
            case 'M':
                return 'Municipal';
        }

    }
    
    protected function _getOpcional()
    {
        return $this->_properties['facultativo'] ? 'Sim' : 'Não';
    }
}