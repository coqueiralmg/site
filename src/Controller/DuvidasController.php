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
        $pergunta = $t_perguntas->get($id, ['contain' => ['Categoria']]);

        $this->set('title', $pergunta->questao);
        $this->set('pergunta', $pergunta);
    }
}
