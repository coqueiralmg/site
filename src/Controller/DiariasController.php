<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class DiariasController extends AppController
{
    public function index()
    {
        $t_diarias = TableRegistry::get('Diaria');
        $limite_paginacao = Configure::read('Pagination.limit');

        $this->paginate = [
            'limit' => $limite_paginacao,
            'conditions' => [
                'ativo' => true
            ],
            'order' => [
                'dataAutorizacao' => 'DESC'
            ]
        ];

        $diarias = $this->paginate($t_diarias);
        $qtd_total = $t_diarias->find('all', ['conditions' => ['ativo' => true]])->count();

        $this->set('title', "Relatórios de Diárias de Viagens");
        $this->set('diarias', $diarias->toArray());
        $this->set('qtd_total', $qtd_total);
        $this->set('limit_pagination', $limite_paginacao);
    }
}
