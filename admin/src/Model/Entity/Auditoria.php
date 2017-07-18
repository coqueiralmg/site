<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;


class Auditoria extends Entity
{
    protected function _getAcaoLoginSistema()
    {
        return 1;
    }
}