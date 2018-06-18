<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Cargo extends Entity
{
    protected function _getAtivado()
    {
        return $this->_properties['ativo'] ? 'Sim' : 'Não';
    }

    protected function _getVagas()
    {
        $reserva = $this->_properties['reserva'];
        $total = $this->_properties['vagasTotal'];

        return ($reserva) ? 'CR' : $total;
    }

    protected function _getPCD()
    {
        $reserva = $this->_properties['reserva'];
        $vagas = $this->_properties['vagaspcd'];

        return ($reserva) ? 'CR' : ($vagas == null || $vagas == 0 ? '-' : $vagas);
    }
}
