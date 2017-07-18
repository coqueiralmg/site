<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

/**
 * Classe que representa o componente de controle de acesso ao usuário
 * @package App\Controller\Component
 */
class MembershipComponent extends Component
{
    public $roles;
    protected $history;

    public function initialize(array $config)
    {
        $this->roles = $this->actionRoles();
    }

    /**
     * Faz tratamento de permissão de usuário por meio de um controle e de ação selecionada.
     * @param array $url Endereço montado pelo array de controller e action
     * @param int $userID ID do usuário
     * @return bool Se o mesmo usuário tem a permissão de acessar a tela.
     */
    public function handleRole(array $url, int $userID)
    {
        $funcoes = $this->getFunctions($url);
        $autorizado = false;

        if(count($funcoes) > 0)
        {
            foreach($funcoes as $funcao)
            {
                $user_functions = $this->request->session()->check('USER_FUNCTIONS') ? $this->request->session()->read('USER_FUNCTIONS') : $this->getFunctionsUser($userID);

                foreach($user_functions as $chave => $nome)
                {
                    if($chave == $funcao)
                    {
                        $autorizado = true;
                        break 2;
                    }
                }
            }
        }

        return $autorizado;
    }

    /**
     * Obtém a chave da função de acordo com o controller e action selecionado.
     * @param array $url Endereço montado pelo array de controller e action
     * @return array Chave da função cadastrada no sistema ou nulo, se o sistema não encontrar.
     */
    public function getFunctions(array $url)
    {
        $funcoes = array();

        foreach ($this->roles as $key => $values)
        {
            foreach($values as $value)
            {
                if (($url["controller"] == $value["controller"]) && ($url["action"] == $value["action"]))
                {
                    array_push($funcoes, $key);
                }
            }
        }

        return $funcoes;
    }

    /**
     * Obtem a roles do usuário de acorodo com o controller e action selecionado.
     * @param array $url Endereço montado pelo array de controller e action
     * @return array Roles da funções selecionada ou nulo, caso se o sistema não encontrar.
     */
    public function getRoles(array $url)
    {
        $roles = array();

        foreach ($this->roles as $key => $values)
        {
            foreach($values as $value)
            {
                if (($url["controller"] == $value["controller"]) && ($url["action"] == $value["action"])) {
                    $roles[$key] = $value;
                }
            }
        }

        return $roles;
    }

    /**
     * Obtém a lista de funções de usuário cadastrado no banco
     * @param int $userID ID de um usuário do sistema.
     * @return array Lista de funções do usuário.
     */
    private function getFunctionsUser(int $userID)
    {
        $usuarios = TableRegistry::get('Usuario');
        $grupos = TableRegistry::get('GrupoUsuario');

        $usuario = $usuarios->get($userID);
        $grupo = $grupos->get($usuario->grupo, ['contain' => ['Funcao']]);
        $fs = array();

        foreach($grupo->Funcoes as $func)
        {
            $fs[$func->chave] = $func->nome;
        }

        $this->request->session()->write('USER_FUNCTIONS', $fs);

        return $fs;
    }


    /**
     * Obtém a lista de roles padrão
     * @return array Lista de roles padrão do sistema.
     */
    private function actionRoles()
    {
        return [
            "LISTA_USUARIOS" => [
                ["controller" => "usuario", "action" => "index"]
            ],
            "ADICIONAR_USUARIOS" => [
                ["controller" => "usuario", "action" => "add"],
                ["controller" => "usuario", "action" => "cadastro"]
            ],
            "EDITAR_USUARIOS" => [
                ["controller" => "usuario", "action" => "edit"],
                ["controller" => "usuario", "action" => "cadastro"]
            ],
            "EXCLUIR_USUARIOS" => [
                ["controller" => "usuario", "action" => "delete"]
            ],
            "LISTAR_GRUPOS_USUARIOS" => [
                ["controller" => "grupousuario", "action" => "index"]
            ],
            "ADICIONAR_GRUPOS_USUARIOS" => [
                ["controller" => "grupousuario", "action" => "add"],
                ["controller" => "grupousuario", "action" => "cadastro"]
            ],
            "EDITAR_GRUPOS_USUARIOS" => [
                ["controller" => "grupousuario", "action" => "edit"],
                ["controller" => "grupousuario", "action" => "cadastro"]
            ],
            "EXCLUIR_GRUPOS_USUARIOS" => [
                ["controller" => "grupousuario", "action" => "delete"]
            ],
            "LISTAR_TRANSACAO" => [
                ["controller" => "transacao", "action" => "index"]
            ],
            "VISUALIZAR_TRANSACAO" => [
                ["controller" => "transacao", "action" => "documento"]
            ],
            "ADICIONAR_TRANSACAO" => [
                ["controller" => "transacao", "action" => "add"],
                ["controller" => "transacao", "action" => "cadastro"]
            ],
            "EDITAR_TRANSACAO" => [
                ["controller" => "transacao", "action" => "edit"],
                ["controller" => "transacao", "action" => "cadastro"]
            ],
            "EXCLUIR_TRANSACAO" => [
                ["controller" => "transacao", "action" => "delete"]
            ],
            "CONSULTAR_AUDITORIA" => [
                ["controller" => "auditoria", "action" => "index"]
            ],
            "VISUALIZAR_DETALHE_AUDITORIA" => [
                ["controller" => "auditoria", "action" => "detalhe"]
            ],
            "EXCLUIR_AUDITORIA" => [
                ["controller" => "auditoria", "action" => "delete"]
            ]
        ];
    }
}
