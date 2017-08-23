<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;


class NoticiasController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $t_noticias = TableRegistry::get('Noticia');
        $limite_paginacao = Configure::read('Pagination.limit');
        
        $condicoes = array();
        $data = array();

        if (count($this->request->getQueryParams()) > 3) 
        {
            $titulo = $this->request->query('titulo');
            $data_inicial = $this->request->query('data_inicial');
            $data_final = $this->request->query('data_final');
            $mostrar = $this->request->query('mostrar');

            if($titulo != "")
            {
                $condicoes['Post.titulo LIKE'] = '%' . $titulo . '%';
            }

            if ($data_inicial != "" && $data_final != "") 
            {
                $condicoes["Post.dataPostagem >="] = $this->Format->formatDateDB($data_inicial);
                $condicoes["Post.dataPostagem <="] = $this->Format->formatDateDB($data_final);
            }

            if ($mostrar != 'T') 
            {
                $condicoes["Post.ativo"] = ($mostrar == "A") ? "1" : "0";
            }

            $data['titulo'] = $titulo;
            $data['data_inicial'] = $data_inicial;
            $data['data_final'] = $data_final;
            $data['mostrar'] = $mostrar;

            $this->request->data = $data;   
        }

        $joins = ['Post' => ['Usuario' => ['Pessoa']]];

        $this->paginate = [
            'limit' => $limite_paginacao,
            'conditions' => $condicoes,
            'contain' => $joins,
            'order' => [
                'id' => 'DESC'
            ]
        ];

        $opcao_paginacao = [
            'name' => 'notícias',
            'name_singular' => 'notícia',
            'predicate' => 'encontradas',
            'singular' => 'encontrada'
        ];

        $noticias = $this->paginate($t_noticias);

        $qtd_total = $t_noticias->find('all', [
            'contain' => $joins,
            'conditions' => $condicoes
        ])->count();

        $combo_mostra = ["T" => "Todos", "A" => "Somente ativos", "I" => "Somente inativos"];
        
        $this->set('title', 'Notícias');
        $this->set('icon', 'style');
        $this->set('combo_mostra', $combo_mostra);
        $this->set('noticias', $noticias);
        $this->set('qtd_total', $qtd_total);
        $this->set('limit_pagination', $limite_paginacao);
        $this->set('opcao_paginacao', $opcao_paginacao);
        $this->set('data', $data);
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
        $title = ($id > 0) ? 'Edição da Notícia' : 'Nova Notícia';
        $icon = 'style';

        $this->set('title', $title);
        $this->set('icon', $icon);
    }

}