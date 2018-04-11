<?php

namespace App\Shell;

use Cake\Console\ConsoleOptionParser;
use Cake\Console\Shell;
use Cake\Core\Configure;
use Cake\Log\Log;
use Cake\ORM\TableRegistry;

/**
 * Classe para comando em console para ouvidoria.
 */
class OuvidoriaShell extends Shell
{
    public $tasks = ['Format', 'Date'];

    public function startup()
    {
        $this->out('Ouvidoria da Prefeitura Municipal de Coqueiral');
        $this->hr();
    }
    
    /**
     * Função principal de console para ouvidoria. Mostra o andamento da ouvidoria do sistema.
     */
    public function main()
    {
        $this->status();
    }

    /**
     * Exibe a ajuda da ouvidoria.
     * @return \Cake\Console\ConsoleOptionParser
     */
    public function getOptionParser()
    {
        $parser = new ConsoleOptionParser('ouvidoria');
        $parser->setDescription(
            "Este sistema foi feito para gerenciamento de ouvidoria do sistema, via Shell Console. " .
            "Para saber como manipular os comandos necessários, consulte a lista abaixo."
        );

        $parser->addOption('file', [
            'short' => 'f',
            'boolean' => true,
            'help' => 'Salva todas as informações da tela num arquivo.'
        ]);

        $parser->addOption('email', [
            'short' => 'e',
            'boolean' => true,
            'help' => 'Envia os dados informados para e-mail'
        ]);

        return $parser;
    }

    public function status($mode = 'simples')
    {
        $t_manifestacao = TableRegistry::get('Manifestacao');
        $t_manifestante = TableRegistry::get('Manifestante');

        $limite = Configure::read('Pagination.short.limit');
        $fechado = Configure::read('Ouvidoria.status.fechado');
        $total = $t_manifestacao->find('all')->count();
        $dados = [];

        if($mode == 'simples' || $mode == 'completo')
        {
            $abertos = $t_manifestacao->find('abertos')->count();
            $novos = $t_manifestacao->find('novo')->count();
            $atrasados = $t_manifestacao->find('atrasados')->count();
            $fechados = $t_manifestacao->find('fechados')->count();

            $estatisticas = "Total de manifestacoes:  $total \n" . 
                            "Manifestações em aberto: $abertos \n". 
                            "Manifestações novas:     $novos \n" .
                            "Manifestações atrasadas: $atrasados \n" .
                            "Manifestações fechadas:  $fechados \n" . '     ';     
        
            $this->out('Estatísticas Gerais');
            $this->out($estatisticas);

            if($this->params['file'] || $this->params['email'])
            {
                $dados['estatisticas'] = [
                    'total' => $total,
                    'abertos' => $abertos,
                    'novos' => $novos,
                    'atrasados' => $atrasados,
                    'fechados' => $fechados
                ];
            }
        }

        if($mode == 'completo' || $mode == 'chamados')
        {
            if($total > 0)
            {
                $data = [];
                $htable = $this->helper('Table');
                $manifestacoes = [];
                
                if($mode == 'completo')
                {
                    $manifestacoes = $t_manifestacao->find('all', [
                        'contain' => ['Manifestante', 'Prioridade', 'Status'],
                        'conditions' => [
                            'status <>' => $fechado
                        ],
                        'order' => [
                            'nivel' => 'DESC',
                            'data' => 'ASC'
                        ],
                        'limit' => $limite
                    ])->all();

                    $this->out('Últimos Manifestos');
                }
                elseif($mode == 'chamados')
                {
                    $manifestacoes = $t_manifestacao->find('all', [
                        'contain' => ['Manifestante', 'Prioridade', 'Status'],
                        'conditions' => [
                            'status <>' => $fechado
                        ],
                        'order' => [
                            'nivel' => 'DESC',
                            'data' => 'ASC'
                        ]
                    ])->all();


                    $this->out('Manifestos em Aberto');
                }

                $data[] = ['Número', 'Data', 'Manifestante', 'Assunto', 'Status', 'Prioridade'];

                foreach ($manifestacoes as $manifestacao)
                {
                    $registro = [
                        $this->Format->zeroPad($manifestacao->id),
                        $this->Format->date($manifestacao->data, true),
                        $manifestacao->manifestante->nome,
                        $manifestacao->assunto,
                        $this->Format->charDecode($manifestacao->status->nome),
                        $manifestacao->prioridade->nome
                    ];

                    $data[] = $registro;
                }

                $htable->output($data);

                if($this->params['file'] || $this->params['email'])
                {
                    $dados['chamados'] = $data;
                }
            }
            else
            {
                $this->out('Não há manifestos em aberto');

                if($this->params['file'] || $this->params['email'])
                {
                    $dados['chamados'] = [];
                }
            }
        }

        if($this->params['file'])
        {
            $formato = $this->in("Em que formato quer salvar o arquivo?", ['TXT', 'CSV', 'XML', 'JSON'], 'TXT');
            $arquivo = $this->in("Digite o nome do arquivo.");

            $formato = strtolower($formato);
            $retorno = "";

            switch($formato)
            {
                case "txt":
                    $retorno = $this->arquivoTexto($dados);
                    break;
            }
        }   
    }
    public function verificar()
    {

    }

    private function arquivoTexto($dados)
    {
        $retorno = "";

        if(array_key_exists('estatisticas', $dados))
        {
            
        }
    }
}