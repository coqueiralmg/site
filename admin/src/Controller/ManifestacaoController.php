<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use \Exception;

class ManifestacaoController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->validationRole = false;
    }

    public function get(int $id)
    {
        $t_manifestacao = TableRegistry::get('Manifestacao');
        $manifestacao = $t_manifestacao->get($id, ['contain' => ['Manifestante', 'Prioridade', 'Status']]);
        
        if ($this->request->is('ajax'))
        {
            $manifestacao->texto = str_replace("<br />", "", $manifestacao->texto);
        }

        $this->set([
            'manifestacao' => $manifestacao,
            '_serialize' => ['manifestacao']
        ]);
    }

    public function aceitar()
    {
        if ($this->request->is('post'))
        {
            $t_manifestacao = TableRegistry::get('Manifestacao');
            $t_historico = TableRegistry::get('Historico');

            $id = $this->request->getData('id');
            $aceito = Configure::read('Ouvidoria.status.definicoes.aceito');

            $ultimo = $t_historico->find('all', [
                'conditions' => [
                    'manifestacao' => $id
                ],
                'order' => [
                    'data' => 'DESC'
                ]
            ])->first();

            $manifestacao = $t_manifestacao->get($id);
            $manifestacao->status = $aceito;

            $historico = $t_historico->newEntity();
            $historico->data = date("Y-m-d H:i:s");
            $historico->mensagem = 'A manifestação foi aceita e em breve será atendida e respondida.';
            $historico->manifestacao = $id;
            $historico->notificar = false;
            $historico->resposta = false;
            $historico->status = $aceito;
            $historico->prioridade = $ultimo->prioridade;

            $propriedades = $this->Auditoria->changedOriginalFields($manifestacao);
            $modificadas = $this->Auditoria->changedFields($manifestacao, $propriedades);
            
            $t_manifestacao->save($manifestacao);
            $t_historico->save($historico);

            $auditoria = [
                'ocorrencia' => 45,
                'descricao' => 'O ouvidor aceitou a manifestação da ouvidoria',
                'dado_adicional' => json_encode(['manifestacao_aceita' => $id, 'valores_originais' => $propriedades, 'valores_modificados' => $modificadas]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if($this->request->session()->read('UsuarioSuspeito'))
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->set([
                'sucesso' => true,
                '_serialize' => ['sucesso']
            ]);
        }
    }

    public function recusar()
    {
        if ($this->request->is('post'))
        {
            $t_manifestacao = TableRegistry::get('Manifestacao');
            $t_historico = TableRegistry::get('Historico');

            $id = $this->request->getData('id');
            $justificativa = $this->request->getData('justificativa');
            $recusado = Configure::read('Ouvidoria.status.definicoes.recusado');

            $ultimo = $t_historico->find('all', [
                'conditions' => [
                    'manifestacao' => $id
                ],
                'order' => [
                    'data' => 'DESC'
                ]
            ])->first();

            $manifestacao = $t_manifestacao->get($id);
            $manifestacao->status = $recusado;

            $historico = $t_historico->newEntity();
            $historico->data = date("Y-m-d H:i:s");
            $historico->mensagem = $justificativa;
            $historico->manifestacao = $id;
            $historico->notificar = false;
            $historico->resposta = false;
            $historico->status = $recusado;
            $historico->prioridade = $ultimo->prioridade;

            $propriedades = $this->Auditoria->changedOriginalFields($manifestacao);
            $modificadas = $this->Auditoria->changedFields($manifestacao, $propriedades);
            
            $t_manifestacao->save($manifestacao);
            $t_historico->save($historico);

            $auditoria = [
                'ocorrencia' => 46,
                'descricao' => 'O ouvidor recusou a manifestação da ouvidoria',
                'dado_adicional' => json_encode(['manifestacao_recusada' => $id, 'valores_originais' => $propriedades, 'valores_modificados' => $modificadas]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if($this->request->session()->read('UsuarioSuspeito'))
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->set([
                'sucesso' => true,
                '_serialize' => ['sucesso']
            ]);
        }
    }

    public function fechar()
    {
        if ($this->request->is('post'))
        {
            $t_manifestacao = TableRegistry::get('Manifestacao');
            $t_historico = TableRegistry::get('Historico');

            $id = $this->request->getData('id');
            $fechado = Configure::read('Ouvidoria.status.definicoes.fechado');

            
            $ultimo = $t_historico->find('all', [
                'conditions' => [
                    'manifestacao' => $id
                ],
                'order' => [
                    'data' => 'DESC'
                ]
            ])->first();

            $manifestacao = $t_manifestacao->get($id);
            $manifestacao->status = $fechado;

            $historico = $t_historico->newEntity();
            $historico->data = date("Y-m-d H:i:s");
            $historico->mensagem = 'A manifestação foi fechada pelo ouvidor';
            $historico->manifestacao = $id;
            $historico->notificar = false;
            $historico->resposta = false;
            $historico->status = $fechado;
            $historico->prioridade = $ultimo->prioridade;

            $propriedades = $this->Auditoria->changedOriginalFields($manifestacao);
            $modificadas = $this->Auditoria->changedFields($manifestacao, $propriedades);
            
            $t_manifestacao->save($manifestacao);
            $t_historico->save($historico);

            $auditoria = [
                'ocorrencia' => 49,
                'descricao' => 'O ouvidor fechou o chamado da manifestação de ouvidoria',
                'dado_adicional' => json_encode(['manifestacao_fechada' => $id, 'valores_originais' => $propriedades, 'valores_modificados' => $modificadas]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if($this->request->session()->read('UsuarioSuspeito'))
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->set([
                'sucesso' => true,
                '_serialize' => ['sucesso']
            ]);
        }
    }

    public function evolution()
    {
        try
        {
            $t_manifestacao = TableRegistry::get('Manifestacao');
            $dados = array();
            
            $i = 1;

            while($i <= 7)
            {
                $data = Time::now();

                $qtd = $t_manifestacao->find('all', [
                    'conditions' => [
                        'data >=' => $data->subDays($i)->i18nFormat('yyyy-MM-dd 00:00:00'),
                        'data <=' => $data->addDays(1)->i18nFormat('yyyy-MM-dd 00:00:00')
                    ],
                ])->count();

                $dados[] = $qtd;

                $i++;
            }

            $this->set([
                'sucesso' => true,
                'data' => array_reverse($dados),
                '_serialize' => ['sucesso', 'data']
            ]);
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

    public function pietipo()
    {
        try
        {
            $t_manifestacao = TableRegistry::get('Manifestacao');

            $novos = $t_manifestacao->find('novo')->count();
            $aceitos = $t_manifestacao->find('aceito')->count();
            $recusados = $t_manifestacao->find('recusado')->count();
            $atendidos = $t_manifestacao->find('atendido')->count();
            $atividades = $t_manifestacao->find('atividade')->count();
            $concluidos = $t_manifestacao->find('concluido')->count();

            $this->set([
                'sucesso' => true,
                'data' => [$novos, $aceitos, $recusados, $atendidos, $atividades, $concluidos],
                '_serialize' => ['sucesso', 'data']
            ]);
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

    public function verificar()
    {
        try
        {
            $t_manifestacao = TableRegistry::get('Manifestacao');

            $hoje = Time::now();

            if($this->Date->isWeekend($hoje))
            {
                $dia_semana = $this->Date->dayWeek($data);
                
                $this->set([
                    'sucesso' => false,
                    'mensagem' => 'Nenhuma mensagem foi enviada, porque hoje é $dia_semana.',
                    '_serialize' => ['sucesso', 'mensagem']
                ]);    
            }
            elseif($this->Date->isHoliday($hoje))
            {
                $this->set([
                    'sucesso' => false,
                    'mensagem' => 'Nenhuma mensagem foi enviada, porque hoje é feriado.',
                    '_serialize' => ['sucesso', 'mensagem']
                ]);  
            }
            else
            {
                $this->enviar();
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

    private function enviar()
    {
        $t_manifestacao = TableRegistry::get('Manifestacao');
        $t_mensagens = TableRegistry::get('Mensagem');

        $envia_copia = Configure::read('Ouvidoria.sendMail');

        $ouvidores = $this->obterOuvidores();

        $manifestacoes = $t_manifestacao->find('abertos', [
            'contain' => ['Manifestante', 'Prioridade', 'Status'],
            'order' => [
                'nivel' => 'DESC',
                'data' => 'ASC'
            ] 
        ]);

        $atrasados = $t_manifestacao->find('atrasados', [
            'contain' => ['Manifestante', 'Prioridade', 'Status'],
            'order' => [
                'nivel' => 'DESC',
                'data' => 'ASC'
            ] 
        ]);

        $dados = [
            'ouvidores' => count($ouvidores),
            'abertas' => $manifestacoes->count(),
            'atrasadas' => $atrasados->count()
        ];


        $titulo = "Relatório Diário de Manifestações da Ouvidoria";


    }

    private function obterOuvidores()
    {
        $t_usuarios = TableRegistry::get('Usuario');
        $grupoOuvidor = Configure::read('Ouvidoria.grupoOuvidor');

        $usuarios = $t_usuarios->find('all', [
            'conditions' => [
                'grupo' => $grupoOuvidor,
                'ativo' => true,
                'suspenso' => false
            ]
        ]);

        return $usuarios->toArray();
    }
   
}