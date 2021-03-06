<?php

namespace App\Controller;

use App\Model\Table\BaseTable;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;
use Cake\ORM\Entity;
use \Exception;

class FaqController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $t_perguntas = TableRegistry::get('Pergunta');
        $t_categorias = TableRegistry::get('Categoria');
        $limite_paginacao = Configure::read('Pagination.limit');

        $condicoes = array();
        $data = array();

        if (count($this->request->getQueryParams()) > 1)
        {
            $questao = $this->request->query('questao');
            $categoria = $this->request->query('categoria');
            $mostrar = $this->request->query('mostrar');

            if($questao != '')
            {
                $condicoes['questao LIKE'] = '%' . $questao . '%';
            }

            if($categoria != '')
            {
                $condicoes['categoria'] = $categoria;
            }

            if ($mostrar != 'T')
            {
                $condicoes["ativo"] = ($mostrar == "A") ? "1" : "0";
            }

            $data['questao'] = $questao;
            $data['categoria'] = $categoria;
            $data['mostrar'] = $mostrar;

            $this->request->data = $data;
        }

        $this->paginate = [
            'limit' => $limite_paginacao,
            'conditions' => $condicoes,
            'contain' => ['Categoria'],
            'order' => [
                'questao' => 'ASC'
            ]
        ];

        $perguntas = $this->paginate($t_perguntas);
        $qtd_total = $t_perguntas->find('all', [
            'conditions' => $condicoes
        ])->count();

        $opcao_paginacao = [
            'name' => 'perguntas',
            'name_singular' => 'pergunta',
            'predicate' => 'encontradas',
            'singular' => 'encontrada'
        ];

        $combo_categorias = $t_categorias->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome',
            'order' => [
                'nome' => 'ASC'
            ]
        ]);

        $combo_mostra = ["T" => "Todos", "A" => "Somente ativos", "I" => "Somente inativos"];

        $this->set('title', 'Perguntas e Respostas');
        $this->set('icon', 'device_unknown');
        $this->set('perguntas', $perguntas);
        $this->set('combo_mostra', $combo_mostra);
        $this->set('combo_categorias', $combo_categorias);
        $this->set('qtd_total', $qtd_total);
        $this->set('limit_pagination', $limite_paginacao);
        $this->set('opcao_paginacao', $opcao_paginacao);
        $this->set('data', $data);
    }

    public function imprimir()
    {
        $t_perguntas = TableRegistry::get('Pergunta');

        $condicoes = array();

        if (count($this->request->getQueryParams()) > 0)
        {
            $questao = $this->request->query('questao');
            $categoria = $this->request->query('categoria');
            $mostrar = $this->request->query('mostrar');

            if($questao != '')
            {
                $condicoes['questao LIKE'] = '%' . $questao . '%';
            }

            if($categoria != '')
            {
                $condicoes['categoria'] = $categoria;
            }

            if ($mostrar != 'T')
            {
                $condicoes["ativo"] = ($mostrar == "A") ? "1" : "0";
            }
        }

        $perguntas = $t_perguntas->find('all', [
            'conditions' => $condicoes,
            'contain' => ['Categoria'],
            'order' => [
                'questao' => 'ASC'
            ]
        ]);

        $qtd_total = $perguntas->count();

         $auditoria = [
            'ocorrencia' => 9,
            'descricao' => 'O usuário solicitou a impressão da listagem de perguntas e respostas.',
            'usuario' => $this->request->session()->read('UsuarioID')
        ];

        $this->Auditoria->registrar($auditoria);

        if ($this->request->session()->read('UsuarioSuspeito'))
        {
            $this->Monitoria->monitorar($auditoria);
        }

        $this->viewBuilder()->layout('print');

        $this->set('title', 'Perguntas e Respostas');
        $this->set('icon', 'device_unknown');
        $this->set('perguntas', $perguntas);
        $this->set('qtd_total', $qtd_total);
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
        $title = ($id > 0) ? 'Edição da Pergunta' : 'Nova Pergunta';
        $t_perguntas = TableRegistry::get('Pergunta');
        $t_categorias = TableRegistry::get('Categoria');

        if($id > 0)
        {
            $pergunta = $t_perguntas->get($id);
            $this->set('pergunta', $pergunta);
        }
        else
        {
            $this->set('pergunta', null);
        }

        $combo_categorias = $t_categorias->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome',
            'order' => [
                'nome' => 'ASC'
            ]
        ]);

        $combo_ouvidoria = [
            'NN' => 'Nenhum',
            'GR' => 'Geral',
            'IP' => 'Iluminação Pública'
        ];

        $this->set('title', $title);
        $this->set('icon', 'device_unknown');
        $this->set('combo_categorias', $combo_categorias);
        $this->set('combo_ouvidoria', $combo_ouvidoria);
        $this->set('id', $id);
    }

    public function delete(int $id)
    {
        try
        {
            $t_perguntas = TableRegistry::get('Pergunta');

            $marcado = $t_perguntas->get($id);
            $questao = $marcado->questao;
            $propriedades = $marcado->getOriginalValues();

            $t_perguntas->delete($marcado);

            $this->Flash->greatSuccess('A pergunta com o título da questão ' . $questao . ' foi excluída com sucesso!');

            $auditoria = [
                'ocorrencia' => 87,
                'descricao' => 'O usuário excluiu uma pergunta.',
                'dado_adicional' => json_encode(['pergunta_excluida' => $id, 'dados_pergunta_excluida' => $propriedades]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if($this->request->session()->read('UsuarioSuspeito'))
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['action' => 'index']);
        }
        catch(Exception $ex)
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao excluir uma questão.', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['action' => 'index']);
        }
    }

    public function categorias()
    {
        $t_categorias = TableRegistry::get('Categoria');
        $limite_paginacao = Configure::read('Pagination.limit');

        $this->paginate = [
            'limit' => $limite_paginacao
        ];

        $categorias = $this->paginate($t_categorias);
        $qtd_total = $t_categorias->find('all')->count();

        $this->set('title', 'Categorias de Perguntas');
        $this->set('icon', 'device_unknown');
        $this->set('categorias', $categorias);
        $this->set('qtd_total', $qtd_total);
        $this->set('limit_pagination', $limite_paginacao);
    }

    public function lista()
    {
        $t_categorias = TableRegistry::get('Categoria');
        $categorias = $t_categorias->find();
        $qtd_total = $categorias->count();

         $auditoria = [
            'ocorrencia' => 9,
            'descricao' => 'O usuário solicitou a impressão da listagem de categoria de perguntas e respostas.',
            'usuario' => $this->request->session()->read('UsuarioID')
        ];

        $this->Auditoria->registrar($auditoria);

        if ($this->request->session()->read('UsuarioSuspeito'))
        {
            $this->Monitoria->monitorar($auditoria);
        }

        $this->viewBuilder()->layout('print');

        $this->set('title', 'Categorias de Perguntas');
        $this->set('icon', 'device_unknown');
        $this->set('categorias', $categorias);
        $this->set('qtd_total', $qtd_total);
    }

    public function insert()
    {
        $this->redirect(['action' => 'categoria', 0]);
    }

    public function editar(int $id)
    {
        $this->redirect(['action' => 'categoria', $id]);
    }

    public function save(int $id)
    {
        if ($this->request->is('post'))
        {
            $this->insertQuestion();
        }
        elseif ($this->request->is('put'))
        {
            $this->updateQuestion($id);
        }
    }

    public function relacionamentos(int $id)
    {
        $t_perguntas = TableRegistry::get('Pergunta');
        $t_categorias = TableRegistry::get('Categoria');

        $pergunta = $t_perguntas->get($id, ['contain' => ['PerguntaRelacionada']]);
        $relacionadas = $pergunta->relacionadas;
        $qtd_total = count($relacionadas);

        foreach($relacionadas as $relacionada)
        {
            $categoria = $relacionada->categoria;
            $relacionada->categoria = $t_categorias->get($categoria);
        }

        $opcao_paginacao = [
            'name' => 'relacionamentos',
            'name_singular' => 'relacionamento',
            'predicate' => 'listados',
            'singular' => 'listado'
        ];

        $this->set('title', 'Perguntas Relacionadas');
        $this->set('icon', 'device_unknown');
        $this->set('id', $id);
        $this->set('pergunta', $pergunta);
        $this->set('relacionadas', $relacionadas);
        $this->set('opcao_paginacao', $opcao_paginacao);
        $this->set('qtd_total', $qtd_total);
    }

    public function list()
    {
        $this->validationRole = false;

        if ($this->request->is('post') || $this->request->is('ajax'))
        {
            $t_perguntas = TableRegistry::get('Pergunta');
            $chave = $this->request->query('chave');

            $resultado = $t_perguntas->find('all', [
                'conditions' => [
                    'questao LIKE ' => '%' . $chave . '%'
                ],
                'contain' => ['Categoria'],
                'limit' => 15
            ]);

            $this->set([
                'resultado' => $resultado,
                '_serialize' => ['resultado']
            ]);
        }
    }

    public function link()
    {
        $this->validationRole = false;

        if ($this->request->is('post'))
        {
            $origem = $this->request->getData('origem');
            $relacionada = $this->request->getData('relacionada');

            if($origem == $relacionada)
            {
                $this->set([
                    'sucesso' => false,
                    'mensagem' => 'Não é permitido fazer relacionamento com a própria pergunta (auto-relacionamento)',
                    '_serialize' => ['sucesso', 'mensagem']
                ]);
            }
            else
            {
                $conn = ConnectionManager::get(BaseTable::defaultConnectionName());
                $query = 'select pergunta_origem, pergunta_relacionada from perguntas_relacionamento where pergunta_origem = :origem and pergunta_relacionada = :relacionada';
                $pivot = $conn->execute($query, ['origem' => $origem, 'relacionada' => $relacionada])->fetchAll('assoc');

                if(count($pivot) > 0)
                {
                     $this->set([
                        'sucesso' => false,
                        'mensagem' => 'O relacionamento já existe',
                        '_serialize' => ['sucesso', 'mensagem']
                    ]);
                }
                else
                {
                    try
                    {
                        $conn->insert('perguntas_relacionamento', [
                            'pergunta_origem' => $origem,
                            'pergunta_relacionada' => $relacionada
                        ]);

                        $conn->insert('perguntas_relacionamento', [
                            'pergunta_relacionada' => $origem,
                            'pergunta_origem' => $relacionada
                        ]);

                        $this->set([
                            'sucesso' => true,
                            'mensagem' => 'O relacionamento foi criado com sucesso.',
                            '_serialize' => ['sucesso', 'mensagem']
                        ]);

                        $auditoria = [
                            'ocorrencia' => 88,
                            'descricao' => 'Foi criada um relacionamento entre perguntas.',
                            'dado_adicional' => json_encode(['id_pergunta_origem' => $origem, 'id_pergunta_relacionada' => $relacionada]),
                            'usuario' => $this->request->session()->read('UsuarioID')
                        ];

                        $this->Auditoria->registrar($auditoria);

                        if($this->request->session()->read('UsuarioSuspeito'))
                        {
                            $this->Monitoria->monitorar($auditoria);
                        }
                    }
                    catch(Exception $ex)
                    {
                        $this->set([
                            'sucesso' => false,
                            'mensagem' => $ex->getMessage(),
                            '_serialize' => ['sucesso', 'mensagem']
                        ]);
                    }
                }
            }
        }
    }

    public function unlink()
    {
        $this->validationRole = false;

        if ($this->request->is('post'))
        {
            $origem = $this->request->getData('origem');
            $relacionada = $this->request->getData('relacionada');
            $conn = ConnectionManager::get(BaseTable::defaultConnectionName());

            try
            {
                $conn->delete('perguntas_relacionamento', [
                    'pergunta_origem' => $origem,
                    'pergunta_relacionada' => $relacionada
                ]);

                $conn->delete('perguntas_relacionamento', [
                    'pergunta_origem' => $relacionada,
                    'pergunta_relacionada' => $origem
                ]);

                $this->set([
                    'sucesso' => true,
                    'mensagem' => 'O relacionamento foi desfeito com sucesso.',
                    '_serialize' => ['sucesso', 'mensagem']
                ]);

                $auditoria = [
                    'ocorrencia' => 89,
                    'descricao' => 'Foi desfeito um relacionamento entre perguntas.',
                    'dado_adicional' => json_encode(['id_pergunta_origem' => $origem, 'id_pergunta_relacionada' => $relacionada]),
                    'usuario' => $this->request->session()->read('UsuarioID')
                ];

                $this->Auditoria->registrar($auditoria);

                if($this->request->session()->read('UsuarioSuspeito'))
                {
                    $this->Monitoria->monitorar($auditoria);
                }
            }
            catch(Exception $ex)
            {
                $this->set([
                    'sucesso' => false,
                    'mensagem' => $ex->getMessage(),
                    '_serialize' => ['sucesso', 'mensagem']
                ]);
            }
        }
    }

    public function refresh()
    {
        $destino = $this->request->query('destino');
        $codigo = $this->request->query('codigo');
        $mensagem = $this->request->query('mensagem');

        $this->Flash->greatSuccess($mensagem);

        if($codigo == "")
        {
            $this->redirect(['action' => $destino]);
        }
        else
        {
            $this->redirect(['action' => $destino, $codigo]);
        }
    }

    public function rollback()
    {
        $destino = $this->request->query('destino');
        $codigo = $this->request->query('codigo');
        $mensagem = $this->request->query('mensagem');

        $this->Flash->exception($mensagem);

        if($codigo == "")
        {
            $this->redirect(['action' => $destino]);
        }
        else
        {
            $this->redirect(['action' => $destino, $codigo]);
        }
    }

    public function categoria(int $id)
    {
        $title = ($id > 0) ? 'Edição da Categoria de Perguntas' : 'Nova Categoria de Perguntas';

        $t_categorias = TableRegistry::get('Categoria');

        if($id > 0)
        {
            $categoria = $t_categorias->get($id);
            $this->set('categoria', $categoria);
        }
        else
        {
            $this->set('categoria', null);
        }

        $this->set('title', $title);
        $this->set('icon', 'device_unknown');
        $this->set('id', $id);
    }

    public function post(int $id)
    {
        if ($this->request->is('post'))
        {
            $this->insertCategory();
        }
        else if($this->request->is('put'))
        {
            $this->updateCategory($id);
        }
    }

    public function drop(int $id)
    {
        try
        {
            $t_categorias = TableRegistry::get('Categoria');
            $t_perguntas = TableRegistry::get('Pergunta');

            $qtd_perguntas = $t_perguntas->find('all', [
                'conditions' => [
                    'categoria' => $id
                ]
            ])->count();

            if($qtd_perguntas > 0)
            {
                throw new Exception('Esta categoria de perguntas e respostas não pode ser excluída, porque existem perguntas associadas a esta. Verifique as perguntas associadas ou deixe o mesma categoria inativa.');
            }

            $marcado = $t_categorias->get($id);
            $nome = $marcado->nome;
            $propriedades = $marcado->getOriginalValues();

            $t_categorias->delete($marcado);

            $this->Flash->greatSuccess('A categoria ' . $nome . ' foi excluída com sucesso!');

            $auditoria = [
                'ocorrencia' => 84,
                'descricao' => 'O usuário excluiu uma categoria de perguntas e respostas.',
                'dado_adicional' => json_encode(['categoria_excluida' => $id, 'dados_categoria_excluida' => $propriedades]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if($this->request->session()->read('UsuarioSuspeito'))
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['action' => 'categorias']);
        }
        catch(Exception $ex)
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao excluir uma categoria de perguntas e respostas.', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['action' => 'categorias']);
        }
    }

    private function insertQuestion()
    {
        try
        {
            $t_perguntas = TableRegistry::get('Pergunta');
            $entity = $t_perguntas->newEntity($this->request->data());

            $entity->categoria = $this->request->getData('categoria');
            $entity->tipo_ouvidoria = $this->request->getData('tipo_ouvidoria');
            $entity->visualizacoes = 0;

            $t_perguntas->save($entity);
            $this->Flash->greatSuccess('A questão foi salva com sucesso.');

            $propriedades = $entity->getOriginalValues();

            $auditoria = [
                'ocorrencia' => 85,
                'descricao' => 'O usuário criou uma pergunta.',
                'dado_adicional' => json_encode(['id_nova_pergunta' => $entity->id, 'dados_pergunta' => $propriedades]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if($this->request->session()->read('UsuarioSuspeito'))
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['action' => 'cadastro', $entity->id]);
        }
        catch(Exception $ex)
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar a pergunta.', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['action' => 'cadastro', 0]);
        }
    }

    private function updateQuestion(int $id)
    {
        try
        {
            $t_perguntas = TableRegistry::get('Pergunta');
            $entity = $t_perguntas->get($id);

            $t_perguntas->patchEntity($entity, $this->request->data());

            $entity->categoria = $this->request->getData('categoria');
            $entity->tipo_ouvidoria = $this->request->getData('tipo_ouvidoria');

            $propriedades = $this->Auditoria->changedOriginalFields($entity);
            $modificadas = $this->Auditoria->changedFields($entity, $propriedades);

            $t_perguntas->save($entity);
            $this->Flash->greatSuccess('A questão foi salva com sucesso.');

            $auditoria = [
                'ocorrencia' => 86,
                'descricao' => 'O usuário editou uma pergunta.',
                'dado_adicional' => json_encode(['pergunta_modificada' => $id, 'valores_originais' => $propriedades, 'valores_modificados' => $modificadas]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if($this->request->session()->read('UsuarioSuspeito'))
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['action' => 'cadastro', $id]);
        }
        catch(Exception $ex)
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar a categoria de perguntas', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['action' => 'cadastro', $id]);
        }
    }

    private function insertCategory()
    {
        try
        {
            $t_categorias = TableRegistry::get('Categoria');
            $entity = $t_categorias->newEntity($this->request->data());

            $t_categorias->save($entity);
            $this->Flash->greatSuccess('A categoria de perguntas e respostas foi salva com sucesso.');

            $propriedades = $entity->getOriginalValues();

            $auditoria = [
                'ocorrencia' => 82,
                'descricao' => 'O usuário criou uma categoria de perguntas e respostas.',
                'dado_adicional' => json_encode(['id_nova_categoria' => $entity->id, 'dados_categoria' => $propriedades]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if($this->request->session()->read('UsuarioSuspeito'))
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['action' => 'categoria', $entity->id]);
        }
        catch(Exception $ex)
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar a categoria de perguntas', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['action' => 'categoria', 0]);
        }
    }

    private function updateCategory(int $id)
    {
        try
        {
            $t_categorias = TableRegistry::get('Categoria');
            $entity = $t_categorias->get($id);

            $t_categorias->patchEntity($entity, $this->request->data());

            $propriedades = $this->Auditoria->changedOriginalFields($entity);
            $modificadas = $this->Auditoria->changedFields($entity, $propriedades);

            $t_categorias->save($entity);
            $this->Flash->greatSuccess('A categoria de perguntas e respostas foi salva com sucesso.');

            $auditoria = [
                'ocorrencia' => 83,
                'descricao' => 'O usuário editou uma categoria de perguntas e respostas.',
                'dado_adicional' => json_encode(['categoria_modificada' => $id, 'valores_originais' => $propriedades, 'valores_modificados' => $modificadas]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if($this->request->session()->read('UsuarioSuspeito'))
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['action' => 'categoria', $id]);
        }
        catch(Exception $ex)
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar a categoria de perguntas', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['action' => 'categoria', $id]);
        }
    }
}
