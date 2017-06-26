<?php

namespace App\View\Helper;


use Cake\View\Helper;

class MenuHelper extends Helper
{
    /**
     * Valida o menu ativo do sistema
     * @param array $location Localização pivot do sistema
     * @return string Se vai retornar o menu ativo.
     */
    public function activeMenu(array $location)
    {
        $style = '';
        $controller = $this->request->params['controller'];
        //$action = $this->request->params['action'];

        if($controller == $location['controller'])
            $style = 'active';

        return $style;
    }
}