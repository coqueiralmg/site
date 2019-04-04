<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class BuscaController extends AppController
{
    public function index()
    {
        $licitacoes = array();
        $legislacao = array();
        $publicacoes = array();
        $noticias = array();
        $concursos = array();
        $informativos = array();
        $duvidas = array();

        $total_licitacoes = 0;
        $total_legislacao = 0;
        $total_publicacoes = 0;
        $total_noticias = 0;
        $total_concursos = 0;
        $total_informativos_concursos = 0;
        $total_duvidas = 0;

        if($this->request->is('get') && count($this->request->query) > 0)
        {
            $chave = $this->request->query('chave');

            $t_licitacoes = TableRegistry::get('Licitacao');
            $t_legislacao = TableRegistry::get('Legislacao');
            $t_publicacoes = TableRegistry::get('Publicacao');
            $t_noticias = TableRegistry::get('Noticia');
            $t_concursos = TableRegistry::get('Concurso');
            $t_informativo = TableRegistry::get('Informativo');
            $t_perguntas = TableRegistry::get('Pergunta');

            $licitacoes_antigas = $t_licitacoes->find('antigo', [
                'conditions' => [
                    'Licitacao.titulo LIKE' => '%' . $chave . '%',
                ],
                'order' => [
                    'id' => 'DESC'
                ]
            ]);

            $licitacoes_novas = $t_licitacoes->find('novo', [
                'contain' => ['Modalidade', 'StatusLicitacao'],
                'conditions' => [
                    'titulo LIKE' => '%' . $chave . '%',
                ],
                'order' => [
                    'Licitacao.dataPublicacao' => 'DESC'
                ]
            ]);

            $licitacoes = array_merge($licitacoes_novas->toArray(), $licitacoes_antigas->toArray());

            $total_licitacoes = $t_licitacoes->find('all', [
                'conditions' => [
                    'titulo LIKE' => '%' . $chave . '%',
                    'ativo' => true
                ],
                'order' => [
                    'id' => 'DESC'
                ]
            ])->count();

            $legislacao = $t_legislacao->find('all', [
                'conditions' => [
                    'titulo LIKE' => '%' . $chave . '%',
                    'ativo' => true
                ],
                'order' => [
                    'data' => 'DESC'
                ]
            ]);

            $total_legislacao = $t_legislacao->find('all', [
                'conditions' => [
                    'titulo LIKE' => '%' . $chave . '%',
                    'ativo' => true
                ],
                'order' => [
                    'data' => 'DESC'
                ]
            ])->count();

            $noticias = $t_noticias->find('all', [
                'conditions' => [
                    'Post.titulo LIKE' => '%' . $chave . '%',
                    'Post.ativo' => true
                ],
                'order' => [
                    'Post.dataPostagem' => 'DESC'
                ],
                'contain' => ['Post']
            ]);

            $total_noticias = $t_noticias->find('all', [
                'conditions' => [
                    'Post.titulo LIKE' => '%' . $chave . '%',
                    'Post.ativo' => true
                ],
                'order' => [
                    'Post.dataPostagem' => 'DESC'
                ],
                'contain' => ['Post']
            ])->count();

            $concursos = $t_concursos->find('all', [
                'conditions' => [
                    'Concurso.titulo LIKE' => '%' . $chave . '%',
                    'Concurso.ativo' => true
                ],
                'order' => [
                    'Concurso.dataProva' => 'DESC'
                ],
                'contain' => ['StatusConcurso']
            ]);

            $total_concursos = $concursos->count();

            $informativos = $t_informativo->find('all', [
                'conditions' => [
                    'Informativo.titulo LIKE' => '%' . $chave . '%',
                    'Informativo.ativo' => true
                ],
                'order' => [
                    'Informativo.data' => 'DESC'
                ],
                'contain' => ['Concurso' => ['StatusConcurso']]
            ]);

            $total_informativos_concursos = $informativos->count();

            $publicacoes = $t_publicacoes->find('all', [
                'conditions' => [
                    'Publicacao.titulo LIKE' => '%' . $chave . '%',
                    'Publicacao.ativo' => true
                ],
                'order' => [
                    'Publicacao.data' => 'DESC'
                ]
            ]);

            $total_publicacoes = $publicacoes->count();

            $duvidas = $t_perguntas->find('all', [
                'contain' => ['Categoria'],
                'conditions' => [
                    'Pergunta.questao LIKE ' => '%' . $chave . '%',
                    'Pergunta.ativo' => true
                ]
            ]);

            $total_duvidas = $duvidas->count();

            $data['chave'] = $chave;
            $this->request->data = $data;
        }

        $this->set('title', "Busca");
        $this->set('licitacoes', $licitacoes);
        $this->set('legislacao', $legislacao->toArray());
        $this->set('noticias', $noticias->toArray());
        $this->set('concursos', $concursos->toArray());
        $this->set('informativos', $informativos->toArray());
        $this->set('publicacoes', $publicacoes->toArray());
        $this->set('duvidas', $duvidas->toArray());
        $this->set('total_licitacoes', $total_licitacoes);
        $this->set('total_legislacao', $total_legislacao);
        $this->set('total_noticias', $total_noticias);
        $this->set('total_concursos', $total_concursos);
        $this->set('total_publicacoes', $total_publicacoes);
        $this->set('total_duvidas', $total_duvidas);
        $this->set('total_informativos_concursos', $total_informativos_concursos);
        $this->set('total_geral', $total_licitacoes + $total_legislacao + $total_noticias + $total_concursos + $total_informativos_concursos + $total_publicacoes + $total_duvidas);
    }
}
