<?php

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\Core\Configure;

class DataHelper extends Helper
{
    /**
     * Informa o ano de lançamento do sistema
     * @return string Ano de lançamento do sistema
     */
    public function release()
    {
        $result = '';
        $yearCreation = Configure::read('System.yearCreation');
        $yearRelease = Configure::read('System.yearRelease');

        if($yearCreation == $yearRelease)
        {
            $result = $yearCreation;
        }
        else
        {
            $result = $yearCreation . ' - ' . $yearRelease;
        }

        return $result;
    }
}