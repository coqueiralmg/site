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
    public $components = ['Cookie', 'Sender', 'Auditoria'];
    
    /*
    * Faz o registro de monitoramento, alertando os administradores
    *
    */
    public function monitorar(array $dados)
    {
        $emails = $this->buscarEmailsAdministradores();
        
        $header = array(
            'name' => 'Segurança Coqueiral',
            'from' => 'security@coqueiral.mg.gov.br',
            'to' => $emails,
            'subject' => 'Monitoramento de Atividade do Usuário Suspeito'
        );

        $params = array(
            'usuário' => $this->Cookie->read('login_user'),
            'ip' => $_SERVER['REMOTE_ADDR'],
            'agent' => $_SERVER['HTTP_USER_AGENT'],
            'atividade' => $this->Auditoria->buscarNomeOcorrencia($dados['ocorrencia']),
            'descricao_atividade' => empty($dados['descricao']) ? 'Não informado' : $dados['descricao'],
            'chave' => $this->montaChave($this->Cookie->read('login_user'), $_SERVER['REMOTE_ADDR'])
        );

        $this->Sender->sendEmailTemplate($header, 'monitoring', $params);
        $this->Sender->sendMessage(null, $emails, 'Monitoramento de Atividade do Usuário Suspeito', 'O usuário suspeito ' . $this->Cookie->read('login_user') . ' executou a seguinte atividade: ' . $this->Auditoria->buscarNomeOcorrencia($dados['ocorrencia']) . ' - Com a seguinte descrição: ' . empty($dados['descricao']) ? 'Não informado' : $dados['descricao']);
    }

    /**
    * Envia e-mail aos administradores de que o usuário está tentando várias vezes o acesso ao sistema.
    */
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
            'agent' => $_SERVER['HTTP_USER_AGENT'],
            'chave' => $this->montaChave($this->Cookie->read('login_user'), $_SERVER['REMOTE_ADDR'])
        );

        $this->Sender->sendEmailTemplate($header, 'hacking', $params);
        $this->Sender->sendMenssage(null, $emails, 'Possível tentativa não autorizada de acesso ao Administrador do Site', 'Alguém está tentando acessar o administrador do site da Prefeitura Municipal de Coqueiral com este usuário' . $this->Cookie->read('login_user') .'. O mesmo pode ser bloqueado automaticamente, caso insista em acessar o sistema sem sucesso. O sistema poderá monitorar as atividades do usuário, caso ele consiga acessar com sucesso, enviando e-mail aos grupos administradores, em cada atividade feita. Endereço de IP: ' .  $_SERVER['REMOTE_ADDR']);
    }

    /**
    * Envia e-mail aos administradores de que o usuário está com acesso bloqueado ao sistema.
    */
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
        $this->Sender->sendMenssage(null, $emails, 'Acesso bloqueado ao Administrador da Prefeitura de Coqueiral', 'O usuário' . $this->Cookie->read('login_user') . ' encontra-se bloqueado no acesso ao sistema. Caso ele tenha tentado com usuário válido, o mesmo se encontrará suspenso.');
    }

    /**
    * Envia e-mail aos proprietário da conta de que a mesma encontra-se suspensa.
    * @param Usuario Usuário a ser avisado da conta suspensa.
    */
    public function alertarContaSuspensa(string $nome, string $email, bool $direto = false)
    {
        $header = array(
            'name' => 'Segurança Coqueiral',
            'from' => 'security@coqueiral.mg.gov.br',
            'to' => $email,
            'subject' => 'Sua conta encontra-se suspensa!'
        );

        $params = array(
            'nome' => $nome,
            'ip' => $_SERVER['REMOTE_ADDR'],
            'direto' => $direto
        );

        $this->Sender->sendEmailTemplate($header, 'suspended', $params);
    }

    /**
    * Faz uma busca de todos os e-mails de administradores do sistema ativos.
    * @return array Lista de e-mails de administradores 
    */
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

    /**
    * Monta uma chave criptografada para bloqueio direto
    * @return Chave criptografada para bloqueio
    */
    private function montaChave(string $login, string $ip)
    {
        $pivot = [
            'login' => $login,
            'ip' => $ip
        ];

        return base64_encode(json_encode($pivot));
    }
}