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

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\ORM\Entity;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{

    public function home()
    {
        $t_noticia = TableRegistry::get('Noticia');
        $t_licitacoes = TableRegistry::get('Licitacao');
        $t_banners = TableRegistry::get('Banner');
        $t_publicacoes = TableRegistry::get('Publicacao');

        $noticias = $t_noticia->find('all', [
            'contain' => ['Post' => ['Usuario' => ['Pessoa']]],
            'conditions' => [
                'Post.destaque' => true,
                'Post.ativo' => true
            ],
            'order' => ['Post.datapostagem' => 'DESC'],
            'limit' => 3
        ]);

        $licitacoes = $t_licitacoes->find('novo', [
            'contain' => ['Modalidade', 'StatusLicitacao'],
            'conditions' => [
                'Licitacao.modalidade NOT IN' => ['DI', 'IN'],
                'Licitacao.status' => Configure::read('Licitacoes.Status.EmRealizacao')
            ],
            'order' => [
                'Licitacao.dataPublicacao' => 'DESC'
            ],
            'limit' => 5
        ]);

        $publicacoes = $t_publicacoes->find('all', [
            'order' => ['Publicacao.data' => 'DESC'],
            'conditions' => [
                'Publicacao.ativo' => true
            ],
            'limit' => 4
        ]);

        $banners = $t_banners->find('all', [
            'conditions' => [
                'Banner.ativo' => true,
                'OR' =>[
                    'Banner.validade >=' => date('Y-m-d'),
                    'Banner.validade IS' => null,
                ]
            ],
            'order' => [
                'Banner.ordem' => 'ASC',
                'Banner.validade' => 'DESC',
            ]
        ]);

         $this->set('noticias', $noticias);
         $this->set('licitacoes', $licitacoes);
         $this->set('publicacoes', $publicacoes);
         $this->set('banners', $banners->toArray());
    }

    public function contato()
    {
        if($this->request->is('post'))
        {
            $nome = $this->request->getData('nome');
            $email = $this->request->getData('email');
            $telefone = $this->request->getData('telefone');
            $assunto = $this->request->getData('assunto');
            $mensagem = $this->request->getData('mensagem');

            $header = array(
                'name' => $nome,
                'from' => $email,
                'to' => Configure::read("Contact.ouvidoria"),
                'subject' => 'Formulário de Contato - ' . $assunto
            );

            $params = array(
                'nome' => $nome,
                'email' => $email,
                'telefone' => $telefone,
                'mensagem' => nl2br($mensagem)
            );

            if($this->Sender->sendEmailTemplate($header, 'default', $params))
            {
                $this->redirect(['controller' => 'pages', 'action' => 'contatosucesso']);
            }
        }
    }

    public function construcao(string $parametros = "")
    {
        if($parametros != "")
        {
            $parametros = $this->Data->decrypt($parametros);

            $mensagem = isset($parametros->mensagem) ? $parametros->mensagem: "";
            $detalhes = isset($parametros->detalhes) ? $parametros->detalhes: "";
            $link = isset($parametros->link) ? $parametros->link : null;

            $this->set('title', 'Página em construção');
            $this->set('mensagem', $mensagem);
            $this->set('detalhes', $detalhes);
            $this->set('link', $link);
        }
        else
        {
            $this->set('mensagem', "");
        }
    }

    public function faleconosco()
    {
        $this->set('title', 'Fale Conosco');
    }

    public function privacidade()
    {
        $this->set('title', 'Política de privacidade');
    }

    public function notafiscal()
    {
        $this->set('title', 'Serviços fiscais');
    }

    public function contatosucesso()
    {
        $this->set('title', 'Mensagem enviada com sucesso');
    }

    public function transparencia()
    {
        $this->set('title', 'Transparência');
    }
}
