<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Log\Log;
use Cake\Network\Exception\ForbiddenException;
use Cake\ORM\TableRegistry;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->registerAccessLog();        

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Sender');
        $this->loadComponent('Firewall');

        $this->configurarAcesso();
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Network\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }

        $this->carregarSecretarias();
        $this->mobileConfig();

        
    }

    /**
    *  Verifica se o usuário possui o acesso ao sistema, caso o seu endereço de IP não esteja na lista negra
    */
    protected function configurarAcesso()
    {
        if(!$this->Firewall->verificar())
        {
            throw new ForbiddenException();
        }
    }

    /**
    *  Verifica se o acesso ao site é móvel
    */
    protected function isMobile()
    {
        return $this->request->is('mobile') || $this->request->is('wap');
    }

    /**
    *  Carrega lista de secretarias a serem carregadas nas páginas do site
    */
    private function carregarSecretarias()
    {
        $t_secretarias = TableRegistry::get('Secretaria');

        $secretarias = $t_secretarias->find('all', [
            'conditions' => [
                'ativo' => true
            ],
            'order' => [
                'nome' => 'ASC'
            ]
        ]);

        $this->set('secretarias', $secretarias);
    }

    private function mobileConfig()
    {
        $movel = $this->isMobile();
        $this->set('movel', $movel);
    }

    private function registerAccessLog()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $method = $this->request->method();
        $scheme = $this->request->scheme();
        $host = $this->request->host();
        $here = $this->request->here();
        $agent = $_SERVER['HTTP_USER_AGENT'];

        $registro = "$ip    $method   $scheme://$host$here    $agent";
        
        Log::write('info', $registro, ['scope' => 'register']);
    }
}
