<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class PublicacoesController extends AppController
{
    public function index()
    {
        $conditions = array();
        $limite_paginacao = Configure::read('limitPagination');

        if($this->request->is('get') && count($this->request->query) > 0)
        {
            $chave = $this->request->query('chave');

            $conditions['titulo LIKE'] = '%' . $chave . '%';

            $data = array();

            $data['chave'] = $chave;

            $this->request->data = $data;
        }

        $this->paginate = [
            'limit' => $limite_paginacao,
            'conditions' => $conditions,
            'order' => [
                'data' => 'DESC'
            ]
        ];

        $opcao_paginacao = [
            'name' => 'publicações',
            'name_singular' => 'publicação',
            'predicate' => 'encontradas',
            'singular' => 'econtrada'
        ];

        $t_publicacoes = TableRegistry::get('Publicacao');
        $publicacoes = $this->paginate($t_publicacoes);
        $qtd_total = $t_publicacoes->find('all', ['conditions' => $conditions])->count();

        $this->set('title', "Publicações");
        $this->set('publicacoes', $publicacoes);
        $this->set('qtd_total', $qtd_total);
        $this->set('limit_pagination', $limite_paginacao);
        $this->set('opcao_paginacao', $opcao_paginacao);
    }

    public function publicacao(int $id)
    {

    }
}