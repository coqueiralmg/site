<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;


class Manifestante extends Entity
{
    protected function _getImpedido()
    {
        return $this->_properties['bloqueado'] ? 'Sim' : 'Não';
    }
}