<?php

namespace App\Controller;

use App\Model\Entity\Manifestacao;
use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;

class OuvidoriaController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $t_manifestacao = TableRegistry::get('Manifestacao');
        $t_prioridade = TableRegistry::get('Prioridade');
        $t_status = TableRegistry::get('Status');

        $limite_paginacao = Configure::read('Pagination.limit');

        $condicoes = array();
        $data = array();

        if (count($this->request->getQueryParams()) > 3)
        {
            $data_inicial = $this->request->query('data_inicial');
            $data_final = $this->request->query('data_final');
            $status = $this->request->query('status');
            $prioridade = $this->request->query('prioridade');

            if ($data_inicial != "" && $data_final != "") 
            {
                $condicoes["data >="] = $this->Format->formatDateDB($data_inicial);
                $condicoes["data <="] = $this->Format->formatDateDB($data_final);
            }

            if ($status != '') 
            {
                $condicoes["status"] = $status;
            }
            else
            {
                $fechado = Configure::read('Ouvidoria.status.fechado');
                $condicoes['status <>'] = $fechado;
            }

            if ($prioridade != '') 
            {
                $condicoes["prioridade"] = $prioridade;
            }

            $data['data_inicial'] = $data_inicial;
            $data['data_final'] = $data_final;
            $data['status'] = $status;
            $data['prioridade'] = $prioridade;

            $this->request->data = $data;
        }
        else
        {
            $fechado = Configure::read('Ouvidoria.status.fechado');
            $condicoes['status <>'] = $fechado;
        }
        
        $this->paginate = [
            'limit' => $limite_paginacao,
        ];

        $config = [
            'contain' => ['Manifestante', 'Prioridade', 'Status'],
            'conditions' => $condicoes,
            'order' => [
                'nivel' => 'DESC',
                'data' => 'ASC'
            ]
        ];

        $opcao_paginacao = [
            'name' => 'manifestações',
            'name_singular' => 'manifestação',
            'predicate' => 'encontradas',
            'singular' => 'encontrada'
        ];

        $query = $t_manifestacao->find('all', $config);
        $manifestacoes = $this->paginate($query);

        $qtd_total = $t_manifestacao->find('all', [
            'contain' => ['Manifestante', 'Prioridade', 'Status'],
            'conditions' => $condicoes
        ])->count();

        $combo_status = $t_status->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome'
        ]);
        
        $combo_prioridade = $t_prioridade->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome',
            'order' => [
                'nivel' => 'ASC'
            ]
        ]);

        $this->set('title', 'Ouvidoria');
        $this->set('icon', 'hearing');
        $this->set('manifestacoes', $manifestacoes);
        $this->set('qtd_total', $qtd_total);
        $this->set('limit_pagination', $limite_paginacao);
        $this->set('opcao_paginacao', $opcao_paginacao);
        $this->set('combo_status', $combo_status);
        $this->set('combo_prioridade', $combo_prioridade);
        $this->set('data', $data);
    }

    public function imprimir()
    {
        $t_manifestacao = TableRegistry::get('Manifestacao');

        $condicoes = array();

        if (count($this->request->getQueryParams()) > 3)
        {
            $data_inicial = $this->request->query('data_inicial');
            $data_final = $this->request->query('data_final');
            $status = $this->request->query('status');
            $prioridade = $this->request->query('prioridade');

            if ($data_inicial != "" && $data_final != "") 
            {
                $condicoes["data >="] = $this->Format->formatDateDB($data_inicial);
                $condicoes["data <="] = $this->Format->formatDateDB($data_final);
            }

            if ($status != '') 
            {
                $condicoes["status"] = $status;
            }

            if ($prioridade != '') 
            {
                $condicoes["prioridade"] = $prioridade;
            }
        }

        $manifestacoes = $t_manifestacao->find('all', [
            'contain' => ['Manifestante', 'Prioridade', 'Status'],
            'conditions' => $condicoes,
            'order' => [
                'nivel' => 'DESC',
                'data' => 'ASC'
            ]
        ]);

        $qtd_total = $manifestacoes->count();

        $auditoria = [
            'ocorrencia' => 9,
            'descricao' => 'O usuário solicitou a impressão da lista de usuários.',
            'usuario' => $this->request->session()->read('UsuarioID')
        ];

        $this->Auditoria->registrar($auditoria);

        if($this->request->session()->read('UsuarioSuspeito'))
        {
            $this->Monitoria->monitorar($auditoria);
        }

        $this->viewBuilder()->layout('print');

        $this->set('title', 'Manifestos da Ouvidoria');
        $this->set('manifestacoes', $manifestacoes);
        $this->set('qtd_total', $qtd_total);
    }

    public function refresh(string $mensagem)
    {
        $this->Flash->greatSuccess($mensagem);
        $this->redirect(['action' => 'index']);
    }

    public function manifestacao(int $id)
    {
        $t_manifestacao = TableRegistry::get('Manifestacao');
        $t_historico = TableRegistry::get('Historico');
        $t_prioridade = TableRegistry::get('Prioridade');

        $manifestacao = $t_manifestacao->get($id, ['contain' => ['Manifestante', 'Prioridade', 'Status']]);
        $prioridades = $t_prioridade->find('list', [
            'keyField' => 'id',
            'valueField' => 'nome',
            'order' => [
                'nivel' => 'DESC'
            ]
        ]);

        $historico =  $t_historico->find('all', [
            'contain' => ['Prioridade', 'Status'],
            'conditions' => [
                'manifestacao' => $id
            ],
            'order' => [
                'data' => 'ASC'
            ]
        ]);

        $acoes = array();

        switch($manifestacao->status->id)
        {
            case Configure::read('Ouvidoria.status.definicoes.aceito'):
            case Configure::read('Ouvidoria.status.definicoes.atendido'):
                $acoes = [
                    'CF' => 'Concluir e fechar',
                    'CL' => 'Apenas deixar concluído',
                    'AN' => 'Deixar com status em andamento',
                    'AT' => 'Apenas ficar como status atendido'
                ];
            break;

            case Configure::read('Ouvidoria.status.definicoes.emAtividade'):
                $acoes = [
                    'CF' => 'Concluir e fechar',
                    'CL' => 'Apenas deixar concluído',
                    'AN' => 'Deixar com status em andamento',
                ];
            break;

            case Configure::read('Ouvidoria.status.definicoes.concluido'):
                $acoes = [
                    'FC' => 'Fechar a manifestação',
                    'CL' => 'Apenas deixar concluído',
                ];
            break;
        }

        $data['prioridade'] = $manifestacao->prioridade->id;

        $this->set('title', 'Manifestação da Ouvidoria');
        $this->set('icon', 'hearing');
        $this->set('manifestacao', $manifestacao);
        $this->set('historico', $historico);
        $this->set('id', $id);
        $this->set('acoes', $acoes);
        $this->set('prioridades', $prioridades);


        $this->request->data = $data;
    }

    public function resposta(int $id)
    {
        if ($this->request->is('post'))
        {
            $t_manifestacao = TableRegistry::get('Manifestacao');
            $t_historico = TableRegistry::get('Historico');

            $resposta = $this->request->getData('resposta');
            $acao = $this->request->getData('acao');
            $prioridade = $this->request->getData('prioridade');
            $enviar = $this->request->getData('enviar');

            $manifestacao = $t_manifestacao->get($id, ['contain' => ['Manifestante', 'Prioridade', 'Status']]);

            $ultimo = $t_historico->find('all', [
                'conditions' => [
                    'manifestacao' => $id
                ],
                'order' => [
                    'data' => 'DESC'
                ]
            ])->first();
            
            switch($acao)
            {
                case 'AT':
                    break;
                case 'AT':
                    break;
                case 'AT':
                    break;
                case 'AT':
                    break;
                
            }

        }        
    }

    private function definirStatusAtendido(Manifestacao $manifestacao, string $resposta, bool $enviar)
    {
        $t_manifestacao = TableRegistry::get('Manifestacao');
        $t_historico = TableRegistry::get('Historico');
        
        $atendido = Configure::read('Ouvidoria.status.definicoes.atendido');
        
        $manifestacao->status = $atendido;

        $historico = $t_historico->newEntity();
        $historico->data = date("Y-m-d H:i:s");
        $historico->mensagem = $resposta;
        $historico->manifestacao = $id;
        $historico->notificar = $enviar;
        $historico->resposta = true;
        $historico->status = $atendido;
        $historico->prioridade = $manifestacao->prioridade->id;

        if($enviar)
        {
            $this->enviarEmailManifestante($manifestacao->id, $manifestacao->manifestante->email, $resposta);
        }

        $propriedades = $this->Auditoria->changedOriginalFields($manifestacao);
        $modificadas = $this->Auditoria->changedFields($manifestacao, $propriedades);

        $t_manifestacao->save($manifestacao);
        $t_historico->save($historico);

        $auditoria = [
            'ocorrencia' => 47,
            'descricao' => 'O ouvidor respondeu a mensagem de ouvidoria',
            'dado_adicional' => json_encode(['manifestacao_respondida' => $id, 'valores_originais' => $propriedades, 'valores_modificados' => $modificadas]),
            'usuario' => $this->request->session()->read('UsuarioID')
        ];

        $this->Auditoria->registrar($auditoria);

        if($this->request->session()->read('UsuarioSuspeito'))
        {
            $this->Monitoria->monitorar($auditoria);
        }
    }

    private function definirStatusAndamento(Manifestacao $manifestacao, bool $resposta = false, string $mensagem = '', bool $enviar = false)
    {
        $t_manifestacao = TableRegistry::get('Manifestacao');
        $t_historico = TableRegistry::get('Historico');
        
        $emAtividade = Configure::read('Ouvidoria.status.definicoes.emAtividade');
        
        $manifestacao->status = $emAtividade;

        $historico = $t_historico->newEntity();
        $historico->data = date("Y-m-d H:i:s");
        $historico->mensagem = $resposta;
        $historico->manifestacao = $id;
        $historico->notificar = $enviar;
        $historico->resposta = $resposta;
        $historico->status = $emAtividade;
        $historico->prioridade = $manifestacao->prioridade->id;

        if($enviar)
        {
            $this->enviarEmailManifestante($manifestacao->id, $manifestacao->manifestante->email, $resposta);
        }

        $propriedades = $this->Auditoria->changedOriginalFields($manifestacao);
        $modificadas = $this->Auditoria->changedFields($manifestacao, $propriedades);

        $t_manifestacao->save($manifestacao);
        $t_historico->save($historico);
        $auditoria = array();

        if($resposta)
        {
            $auditoria = [
                'ocorrencia' => 47,
                'descricao' => 'O ouvidor respondeu a mensagem de ouvidoria',
                'dado_adicional' => json_encode(['manifestacao_respondida' => $id, 'valores_originais' => $propriedades, 'valores_modificados' => $modificadas]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];
        }
        else
        {
            $auditoria = [
                'ocorrencia' => 50,
                'descricao' => 'A manifestação teve seu status atualizado',
                'dado_adicional' => json_encode(['manifestacao_atualizada' => $id, 'valores_originais' => $propriedades, 'valores_modificados' => $modificadas]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];
        }

        $this->Auditoria->registrar($auditoria);

        if($this->request->session()->read('UsuarioSuspeito'))
        {
            $this->Monitoria->monitorar($auditoria);
        }
    }

    private function definirStatusConcluido(Manifestacao $manifestacao, bool $resposta = false, string $mensagem = '', bool $enviar = false)
    {
        $t_manifestacao = TableRegistry::get('Manifestacao');
        $t_historico = TableRegistry::get('Historico');
        
        $concluido = Configure::read('Ouvidoria.status.definicoes.concluido');
        
        $manifestacao->status = $concluido;

        $historico = $t_historico->newEntity();
        $historico->data = date("Y-m-d H:i:s");
        $historico->mensagem = $resposta;
        $historico->manifestacao = $id;
        $historico->notificar = $enviar;
        $historico->resposta = $resposta;
        $historico->status = $concluido;
        $historico->prioridade = $manifestacao->prioridade->id;

        if($enviar)
        {
            $this->enviarEmailManifestante($manifestacao->id, $manifestacao->manifestante->email, $resposta);
        }

        $propriedades = $this->Auditoria->changedOriginalFields($manifestacao);
        $modificadas = $this->Auditoria->changedFields($manifestacao, $propriedades);

        $t_manifestacao->save($manifestacao);
        $t_historico->save($historico);
        $auditoria = array();

        if($resposta)
        {
            $auditoria = [
                'ocorrencia' => 47,
                'descricao' => 'O ouvidor respondeu a mensagem de ouvidoria',
                'dado_adicional' => json_encode(['manifestacao_respondida' => $id, 'valores_originais' => $propriedades, 'valores_modificados' => $modificadas]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];
        }
        else
        {
            $auditoria = [
                'ocorrencia' => 50,
                'descricao' => 'A manifestação teve seu status atualizado',
                'dado_adicional' => json_encode(['manifestacao_atualizada' => $id, 'valores_originais' => $propriedades, 'valores_modificados' => $modificadas]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];
        }

        $this->Auditoria->registrar($auditoria);

        if($this->request->session()->read('UsuarioSuspeito'))
        {
            $this->Monitoria->monitorar($auditoria);
        }
    }

    private function enviarEmailManifestante(int $idManifestacao, string $email, string $resposta)
    {
        $header = array(
            'name' => 'Sistema Coqueiral',
            'from' => 'system@coqueiral.mg.gov.br',
            'to' => $email,
            'subject' => 'Resposta da Ouvidoria da Manifestação ' + $this->Format->zeroPad($idManifestacao)
        );

        $params = array(
            'mensagem' => $resposta,
            'id' => $idManifestacao,
        );

        $this->Sender->sendEmailTemplate($header, 'manifestante', $params);
    }
}