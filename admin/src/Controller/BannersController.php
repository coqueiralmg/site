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
        $this->redirect(['action' => 'cadastro', 0]);
    }

    public function edit(int $id)
    {
        $this->redirect(['action' => 'cadastro', $id]);
    }

    public function cadastro(int $id)
    {
        $title = ($id > 0) ? 'Edição do Banner' : 'Novo Banner';
        $icon = ($id > 0) ? 'slideshow' : 'slideshow';

        $this->set('title', $title);
        $this->set('icon', $icon);
    }

}