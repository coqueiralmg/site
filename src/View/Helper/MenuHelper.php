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
     * Valida um conjunto de menus ativos do sistema. Usado para validar em submenus
     * @param array $argumentos Uma coletânea de controles e ações a serem validados pela função
     * @return bool Se o menu deve ficar ativo.
     */
    public function activeMenus()
    {
        $qtd_args = func_num_args();
        $args = func_get_args();
        $ativo = false;

        for($i = 0; $i < $qtd_args && !$ativo; $i++)
        {
            $chave = $args[$i];
            $estilo = $this->activeMenu($chave);
            $ativo = ($estilo == 'active');
        }

        return $ativo;
    }
}
