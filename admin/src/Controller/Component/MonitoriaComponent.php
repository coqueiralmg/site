<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

/**
 * Classe que representa o componente monitoramento de atividade de usuários suspeitos.
 * @package App\Controller\Component
 */
class MonitoriaComponent extends Component
{
    public $components = ['Cookie', 'Sender'];
    
    /*
    * Faz o registro de monitoramento, alertando os administradores
    *
    */
    public function registrar(array $dados)
    {

    }

    public function alertarTentativasIntermitentes()
    {
        $emails = $this->buscarEmailsAdministradores();
        
        $header = array(
            'name' => 'Segurança Coqueiral',
            'from' => 'security@coqueiral.mg.gov.br',
            'to' => $emails,
            'subject' => 'Possível tentativa não autorizada de acesso ao Administrador do Site'
        );

        $params = array(
            'usuário' => $this->Cookie->read('login_user'),
            'ip' => $_SERVER['REMOTE_ADDR'],
            'agent' => $_SERVER['HTTP_USER_AGENT']
        );

        $this->Sender->sendEmailTemplate($header, 'hacking', $params);
    }

    public function alertarUsuarioBloqueado()
    {
        $emails = $this->buscarEmailsAdministradores();
        
        $header = array(
            'name' => 'Segurança Coqueiral',
            'from' => 'security@coqueiral.mg.gov.br',
            'to' => $emails,
            'subject' => 'Acesso bloqueado ao Administrador da Prefeitura de Coqueiral'
        );

        $params = array(
            'usuário' => $this->Cookie->read('login_user'),
            'ip' => $_SERVER['REMOTE_ADDR'],
            'agent' => $_SERVER['HTTP_USER_AGENT']
        );

        $this->Sender->sendEmailTemplate($header, 'blocked', $params);
    }

    private function buscarEmailsAdministradores()
    {
        $t_usuario = TableRegistry::get('Usuario');
        $query = $t_usuario->find('all', [
            'contain' => ['GrupoUsuario'],
            'conditions' => [
                'GrupoUsuario.administrativo' => true,
                'Usuario.ativo' => true
            ]
        ])->select(['email']);

        $resultado = $query->all();
        $emails = array();

        foreach($resultado as $item)
        {
            array_push($emails, $item->email);
        }

        return $emails;
    }
}