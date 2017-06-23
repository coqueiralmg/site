<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class BuscaController extends AppController
{
    public function index()
    {
        $licitacoes = array();
        $publicacoes = array();
        $noticias = array();

        $total_licitacoes = 0;
        $total_publicacoes = 0;
        $total_noticias = 0;
        
        if($this->request->is('get') && count($this->request->query) > 0)
        {
            $chave = $this->request->query('chave');
            
            $t_licitacoes = TableRegistry::get('Licitacao');
            $t_publicacoes = TableRegistry::get('Publicacao');
            $t_noticias = TableRegistry::get('Noticia');

            $licitacoes = $t_licitacoes->find('all', [
                'conditions' => [
                    'titulo LIKE' => '%' . $chave . '%'
                ],
                'order' => [
                    'id' => 'DESC'
                ]
            ]);

            $total_licitacoes = $t_licitacoes->find('all', [
                'conditions' => [
                    'titulo LIKE' => '%' . $chave . '%'
                ],
                'order' => [
                    'id' => 'DESC'
                ]
            ])->count();

            $publicacoes = $t_publicacoes->find('all', [
                'conditions' => [
                    'titulo LIKE' => '%' . $chave . '%'
                ],
                'order' => [
                    'data' => 'DESC'
                ]
            ]);

            $total_publicacoes = $t_publicacoes->find('all', [
                'conditions' => [
                    'titulo LIKE' => '%' . $chave . '%'
                ],
                'order' => [
                    'data' => 'DESC'
                ]
            ])->count();

            $noticias = $t_noticias->find('all', [
                'conditions' => [
                    'Post.titulo LIKE' => '%' . $chave . '%'
                ],
                'order' => [
                    'Post.dataPostagem' => 'DESC'
                ],
                'contain' => ['Post']
            ]);

            $total_noticias = $t_noticias->find('all', [
                'conditions' => [
                    'Post.titulo LIKE' => '%' . $chave . '%'
                ],
                'order' => [
                    'Post.dataPostagem' => 'DESC'
                ],
                'contain' => ['Post']
            ])->count();

             $data['chave'] = $chave;

            $this->request->data = $data;
        }
        
        $this->set('title', "Busca");
        $this->set('licitacoes', $licitacoes);
        $this->set('publicacoes', $publicacoes);
        $this->set('noticias', $noticias);
        $this->set('total_licitacoes', $total_licitacoes);
        $this->set('total_publicacoes', $total_publicacoes);
        $this->set('total_noticias', $total_noticias);
        $this->set('total_geral', $total_licitacoes + $total_publicacoes + $total_noticias);
    }
}