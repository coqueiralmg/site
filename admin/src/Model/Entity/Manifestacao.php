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
        $status = $this->_properties['status'];
        $prazo = Configure::read('Ouvidoria.prazo');

        $nao_atendido = ($status->id == Configure::read('Ouvidoria.status.definicoes.novo') || $status->id == Configure::read('Ouvidoria.status.definicoes.aceito'));

        return !$data->wasWithinLast($prazo) && $nao_atendido;
    }
}