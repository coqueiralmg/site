<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Assunto extends Entity
{
    protected function _getTipo()
    {
        $tipo = $this->_properties['tipo'];

        switch($tipo)
        {
            case 'LG':
                return 'Legislação';
            case 'LC':
                return 'Licitação';
            case 'PB':
                return 'Publicação';
            case 'DR':
                return 'Diária';
            case 'NT':
                return 'Notícia';
            case 'CP':
                return 'Concurso Público';
        }
    }
}
