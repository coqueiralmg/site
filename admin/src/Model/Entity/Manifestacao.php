<?php

namespace App\Model\Entity;

use Cake\Core\Configure;
use Cake\I18n\Date;
use Cake\I18n\Time;
use Cake\ORM\Entity;

class Manifestacao extends Entity
{
    protected function _getAtrasado()
    {
        $data = $this->_properties['data'];
        $prazo = Configure::read('Ouvidoria.prazo');

        return !$data->wasWithinLast($prazo);
    }
}