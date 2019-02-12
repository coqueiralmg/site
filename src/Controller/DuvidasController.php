<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class DuvidasController extends AppController
{
    public function index()
    {
        $t_perguntas = TableRegistry::get('Pergunta');
        $t_categorias = TableRegistry::get('Categoria');

        $total = $t_perguntas->find('ativo')->count();

        if($total > 0)
        {
            $destaques = $t_perguntas->find('destaque', [
                'order' => [
                    'visualizacoes' => 'DESC'
                ]
            ]);

            $limit = $destaques->count() > 0 ? $destaques->count() : 5;

            $populares = $t_perguntas->find('ativo', [
                'limit' => $limit,
                'order' => [
                    'visualizacoes' => 'DESC'
                ]
            ]);

            $categorias = $t_categorias->find('ativo', [
                'contain' => ['Pergunta'],
                'order' => [
                    'nome' => 'ASC'
                ]
            ]);

            $this->set('title', "Dúvidas e Perguntas");
            $this->set('destaques', $destaques->toArray());
            $this->set('populares', $populares->toArray());
            $this->set('categorias', $categorias);
            $this->set('total', $total);
        }
        else
        {
            $this->render('vazio');
            $this->set('title', "Dúvidas e Perguntas");
        }
    }

    public function duvida(string $slug)
    {
        $gate = explode('-', $slug);
        $id = end($gate);

        $t_perguntas = TableRegistry::get('Pergunta');
        $pergunta = $t_perguntas->get($id, ['contain' => ['Categoria', 'PerguntaRelacionada' => ['Categoria']]]);
        $gatilho = null;

        switch ($pergunta->tipo_ouvidoria) {
            case 'GR':
                $gatilho = ['controller' => 'ouvidoria', 'action' => 'index'];
                break;

            case 'IP':
                $gatilho = ['controller' => 'ouvidoria', 'action' => 'iluminacao'];
                break;

            case 'NN':
                $gatilho = ['controller' => 'pages', 'action' => 'faleconosco'];
                break;
        }

        $this->set('title', $pergunta->questao);
        $this->set('pergunta', $pergunta);
        $this->set('gatilho', $gatilho);
    }

    public function busca()
    {
        $chave = $this->request->query('chave');
        $limite_paginacao = Configure::read('Pagination.limit');

        $t_perguntas = TableRegistry::get('Pergunta');
        $condicoes = [
            'Pergunta.questao LIKE ' => '%' . $chave . '%',
            'Pergunta.ativo' => true
        ];

        $this->paginate = [
            'limit' => $limite_paginacao,
            'conditions' => $condicoes,
            'contain' => ['Categoria'],
            'order' => [
                'questao' => 'ASC',
            ]
        ];

        $opcao_paginacao = [
            'name' => 'dúvidas',
            'name_singular' => 'dúvida',
            'predicate' => 'encontradas',
            'singular' => 'econtrada'
        ];

        $perguntas = $this->paginate($t_perguntas);

        $total = $t_perguntas->find('all', ['conditions' => $condicoes])->count();

        $data['chave'] = $chave;
        $this->request->data = $data;

        $this->set('title', "Dúvidas e Perguntas");
        $this->set('perguntas', $perguntas->toArray());
        $this->set('qtd_total', $total);
        $this->set('limit_pagination', $limite_paginacao);
        $this->set('opcao_paginacao', $opcao_paginacao);
    }
}
