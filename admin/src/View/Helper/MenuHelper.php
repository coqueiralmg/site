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
        $controller = strtolower($this->request->getParam('controller'));
        $action = strtolower($this->request->getParam('action'));

        if(isset($location['action']))
        {
            if($controller == $location['controller'] && $action == $location['action'])
                $style = 'active';
        }
        else
        {
            if($controller == $location['controller'])
                $style = 'active';
        }

        return $style;
    }

     /**
     * Valida o menu ativo do sistema
     * @param array $location Localização pivot do sistema
     * @return bool Se vai retornar o menu ativo.
     */
    public function activeMenuItem(array $location)
    {
        $active = false;
        $controller = strtolower($this->request->getParam('controller'));
        $action = strtolower($this->request->getParam('action'));

        if(isset($location['action']))
        {
            if($controller == $location['controller'] && $action == $location['action'])
                $active = true;
        }
        else
        {
            if($controller == $location['controller'])
                $active = true;
        }

        return $active;
    }
}
