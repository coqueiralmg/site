<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class LegislacaoController extends AppController
{
    public function index()
    {
        $conditions = array();
        $limite_paginacao = Configure::read('Pagination.limit');

        if($this->request->is('get') && count($this->request->query) > 0)
        {
            $chave = $this->request->query('chave');

            $conditions['titulo LIKE'] = '%' . $chave . '%';

            $data = array();

            $data['chave'] = $chave;

            $this->request->data = $data;
        }

        $conditions['ativo'] = true;

        $this->paginate = [
            'limit' => $limite_paginacao,
            'conditions' => $conditions,
            'order' => [
                'data' => 'DESC'
            ]
        ];

        $t_legislacao = TableRegistry::get('Legislacao');
        $legislacao = $this->paginate($t_legislacao);
        $qtd_total = $t_legislacao->find('all', ['conditions' => $conditions])->count();

        $destaques = $t_legislacao->find('destaque', [
            'order' => [
                'data' => 'DESC'
            ]
        ]);

        $this->set('title', "Legislação");
        $this->set('legislacao', $legislacao->toArray());
        $this->set('destaques', $destaques->toArray());
        $this->set('qtd_total', $qtd_total);
        $this->set('limit_pagination', $limite_paginacao);
    }

    public function documento(int $id)
    {
        $t_legislacao = TableRegistry::get('Legislacao');
        $legislacao = $t_legislacao->get($id);

        $this->set('title', $legislacao->titulo);
        $this->set('legislacao', $legislacao);
    }
}
