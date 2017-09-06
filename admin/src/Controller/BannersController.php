<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;


class BannersController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $t_banners = TableRegistry::get('Banner');
        $limite_paginacao = Configure::read('Pagination.limit');
        
        $this->paginate = [
            'limit' => $limite_paginacao,
            'order' => [
                'nome' => 'ASC'
            ]
        ];

        $banners = $this->paginate($t_banners);
        $qtd_total = $t_banners->find('all')->count();
        
        $this->set('title', 'Banners');
        $this->set('icon', 'slideshow');
        $this->set('banners', $banners);
        $this->set('qtd_total', $qtd_total);
        $this->set('limit_pagination', $limite_paginacao);
    }

    public function add()
    {
        $mensagem = '<b>Dica 1:</b> Caso necessite de um banner sem prazo de validade, basta apenas deixar o campo \'Validade\' em branco.<br/> ';
        $mensagem = $mensagem . '<b>Dica 2:</b> Também não é preciso colocar endereço completo do link de destino, caso o destno esteja no mesmo site. <br/> ';
        $mensagem = $mensagem . '<b>Dica 3:</b>  Recomenda-se ativar a opção \'Abrir em nova janela\', quando o destino leva para o outro site. <br/>';
        $mensagem = $mensagem . '<b>Dica 4:</b> A imagem do banner deve ter obrigatoriamente, o tamanho de 1400 x 730.';
        
        $this->Flash->info($mensagem);
        $this->redirect(['action' => 'cadastro', 0]);
    }

    public function edit(int $id)
    {
        $this->redirect(['action' => 'cadastro', $id]);
    }

    public function cadastro(int $id)
    {
        $title = ($id > 0) ? 'Edição do Banner' : 'Novo Banner';
        $icon = 'slideshow';

        $t_banners = TableRegistry::get('Banner');

        if($id > 0)
        {
            $banner = $t_banners->get($id);
            $this->set('banner', $banner);
        }
        else
        {
            $this->set('banner', null);
        }

        $this->set('title', $title);
        $this->set('icon', $icon);
        $this->set('id', $id);
    }
}