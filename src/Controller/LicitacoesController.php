<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class LicitacoesController extends AppController
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

        $conditions['Licitacao.ativo'] = true;
        $conditions['Licitacao.antigo'] = false;

        $this->paginate = [
            'limit' => $limite_paginacao,
            'conditions' => $conditions,
            'contain' => ['Modalidade', 'StatusLicitacao'],
            'order' => [
                'dataPublicacao' => 'DESC',
                'dataSessao' => 'DESC'
            ]
        ];

        $opcao_paginacao = [
            'name' => 'licitações',
            'name_singular' => 'licitação',
            'predicate' => 'encontradas',
            'singular' => 'econtrada'
        ];

        $t_licitacoes = TableRegistry::get('Licitacao');
        $t_modalidade = TableRegistry::get('Modalidade');
        $t_assuntos = TableRegistry::get('Assunto');
        $t_status = TableRegistry::get('StatusLicitacao');

        $licitacoes = $this->paginate($t_licitacoes);
        $inicial = count($this->request->query) == 0;
        $qtd_total = $t_licitacoes->find('all', ['conditions' => $conditions])->count();

        if($inicial)
        {
            $destaques = $t_licitacoes->find('destaque', [
                'contain' => ['Modalidade', 'StatusLicitacao'],
                'order' => [
                    'dataPublicacao' => 'DESC',
                    'dataSessao' => 'DESC'
                ]
            ]);

            $populares = $t_licitacoes->find('novo', [
                'limit' => $limite_paginacao,
                'contain' => ['Modalidade', 'StatusLicitacao'],
                'conditions' => [
                    'visualizacoes >' => 0
                ],
                'order' => [
                    'visualizacoes' => 'DESC',
                    'dataPublicacao' => 'DESC',
                    'dataSessao' => 'DESC'
                ]
            ]);

            $anos = $t_licitacoes->find('novo')
                    ->select(['ano'])
                    ->group('ano')
                    ->order([
                        'ano' => 'DESC'
                    ]);

            $modalidades = $t_modalidade->find('all', [
                'conditions' => [
                    'ativo' => true
                ]
            ]);

            $assuntos = $t_assuntos->find('all', [
                'conditions' => [
                    'tipo' => 'LC'
                ],
                'order' => [
                    'descricao' => 'ASC'
                ]
            ]);

            $status = $t_status->find('all', [
                'order' => [
                    'ordem' => 'ASC'
                ]
            ]);
        }

        $this->set('title', "Licitações");
        $this->set('licitacoes', $licitacoes->toArray());
        $this->set('destaques', $destaques == null ? [] : $destaques->toArray());
        $this->set('populares', $populares == null ? [] : $populares->toArray());
        $this->set('modalidades', $modalidades == null ? [] : $modalidades->toArray());
        $this->set('assuntos', $assuntos == null ? [] : $assuntos->toArray());
        $this->set('status', $status == null ? [] : $status->toArray());
        $this->set('anos', $anos == null ? [] : $anos->toArray());
        $this->set('qtd_total', $qtd_total);
        $this->set('inicial', $inicial);
        $this->set('limit_pagination', $limite_paginacao);
        $this->set('opcao_paginacao', $opcao_paginacao);
    }

    public function licitacao(string $slug)
    {
        $gate = explode('-', $slug);
        $id = end($gate);

        $t_licitacoes = TableRegistry::get('Licitacao');
        $licitacao = $t_licitacoes->get($id);

        $this->set('title', $licitacao->titulo);
        $this->set('licitacao', $licitacao);
    }
}
