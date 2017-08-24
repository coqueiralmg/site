<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class NoticiasController extends AppController
{
    public function index()
    {
        $conditions = array();
        $limite_paginacao = 5;

        if($this->request->is('get') && count($this->request->query) > 0)
        {
            $chave = $this->request->query('chave');

            $conditions['Post.titulo LIKE'] = '%' . $chave . '%';

            $data = array();

            $data['chave'] = $chave;

            $this->request->data = $data;
        }

        $joins = ['Post' => ['Usuario' => ['Pessoa']]];
        
        $this->paginate = [
            'limit' => $limite_paginacao,
            'conditions' => $conditions,
            'contain' => $joins,
            'order' => [
                'Noticia.post.dataPostagem' => 'DESC'
            ]
        ];

        $t_noticias = TableRegistry::get('Noticia');
        $noticias = $this->paginate($t_noticias);
        $qtd_total = $t_noticias->find('all', ['conditions' => $conditions, 'contain' => $joins])->count();

        $this->set('title', "Notícias");
        $this->set('noticias', $noticias);
        $this->set('qtd_total', $qtd_total);
        $this->set('limit_pagination', $limite_paginacao);
    }

    public function noticia(string $slug)
    {
        $gate = explode('-', $slug);
        $id = end($gate);

        $t_noticias = TableRegistry::get('Noticia');
        $t_posts = TableRegistry::get('Post');

        $noticia = $t_noticias->find('all', [
            'contain' => ['Post' => ['Usuario' => ['Pessoa']]],
            'conditions' => [
                'Noticia.id' => $id
            ]
        ])->first();

        $post = $t_posts->get($noticia->post->id);

        $post->visualizacoes = $post->visualizacoes + 1;

        $t_posts->save($post);
        
        $socialTags = [
           'og:locale' => 'pt_BR',
           'og:type' => 'article',
           'article:publisher' => 'https://www.facebook.com/prefeituradecoqueiral',
           'og:title' => $noticia->post->titulo . ' | Prefeitura Municipal de Coqueiral',
           'og:description' => $noticia->resumo,
           'og:url' => 'http://coqueiral.mg.gov.br/noticias/noticia' . $noticia->post->slug . '-' . $noticia->id,
           'og:site_name' => 'Prefeitura Municipal de Coqueiral',
           'og:image' => 'http://coqueiral.mg.gov.br/' . $noticia->foto,
           'og:image:width' => '600',
           'og:image:height' => '400'
       ];

        $this->set('title', $noticia->post->titulo);
        $this->set('socialTags', $socialTags);
        $this->set('noticia', $noticia);
    }
}