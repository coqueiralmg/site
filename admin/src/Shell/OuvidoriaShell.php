<?php

namespace App\Shell;

use Cake\Console\ConsoleOptionParser;
use Cake\Console\Shell;
use Cake\Core\Configure;
use Cake\Log\Log;
use Cake\ORM\TableRegistry;
use Cake\Utility\Xml;

/**
 * Classe para comando em console para ouvidoria.
 */
class OuvidoriaShell extends Shell
{
    public $tasks = ['Format', 'Date', 'Sender'];

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
        $t_manifestacao = TableRegistry::get('Manifestacao');

        $total = $t_manifestacao->find('all')->count();
        $abertos = $t_manifestacao->find('abertos')->count();
        $novos = $t_manifestacao->find('novo')->count();
        $atrasados = $t_manifestacao->find('atrasados')->count();
        $fechados = $t_manifestacao->find('fechados')->count();

        $estatisticas = "Total de manifestacoes:  $total \n" . 
                        "Manifestações em aberto: $abertos \n". 
                        "Manifestações novas:     $novos \n" .
                        "Manifestações atrasadas: $atrasados \n" .
                        "Manifestações fechadas:  $fechados \n" . '     ';     
    
        $this->out('Resumo Estatístico');
        $this->out($estatisticas);
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

        $parser->addSubcommand('status', [
            'help' => 'Mostra todo o andamento estatístico da ouvidoria da Prefeitura de Coqueiral, mostranto dados quantitativos e os chamados (manifestos).',
            'parser' => [
                'description' => [
                    'Mostra todo o andamento estatístico da ouvidoria da Prefeitura de Coqueiral, mostranto dados quantitativos e os chamados (manifestos).',
                    'Esta funcionalidade mostra as informaçõe necessárias para execução de dados estatísticos do sistema'
                ],
                'arguments' => [
                    'mode' => [
                        'help' => 'Modo de exibição do status do andamento da ouvidoria',
                        'default' => 'simple',
                        'choices' => ['simples', 'completo', 'chamados']
                    ]
                ],
                'options' => [
                    'email' => [
                        'short' => 'e',
                        'boolean' => true,
                        'help' => 'Envia as informações estatísticas para e-mail'
                    ],
                    'email-address' => [
                        'short' => 'd',
                        'help' => 'Envia as informações estatísticas para e-mail pré-determinado'
                    ],
                    'ocultar' => [
                        'short' => 'o',
                        'boolean' => true,
                        'help' => 'Não envia as informações no corpo do e-mail. As informações são enviadas em arquivo texto anexo.'
                    ],
                    'mesclar' => [
                        'short' => 'm',
                        'boolean' => true,
                        'help' => 'Mescla o arquivo criado, enviado e-mail como arquivo anexo. Requer que seja salvo arquivo.'
                    ],
                    'file' => [
                        'short' => 'f',
                        'boolean' => true,
                        'help' => 'Salva as informações num arquivo.'
                    ],
                    'file-save' => [
                        'short' => 's',
                        'help' => 'Salva as informações no arquivo pré-determinado.'
                    ],
                    'file-type' => [
                        'short' => 't',
                        'help' => 'Determina o formato do arquivo a ser salvo.',
                        'choices' => ['txt', 'csv', 'xml', 'json']
                    ],
                    'file-type-auto' => [
                        'short' => 'a',
                        'boolean' => true,
                        'help' => 'Faz com que o sistema escolha automaticamente o formato do arquivo a ser salvo.'
                    ]
                ]
            ]
        ]);

        return $parser;
    }

    /**
     * Mostra as estatísticas e o andamento da ouvidoria
     * @param $mode Modo de exibição de estatística do sistema.
     */
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

            $dados['estatisticas'] = [
                'total' => $total,
                'abertos' => $abertos,
                'novos' => $novos,
                'atrasados' => $atrasados,
                'fechados' => $fechados
            ];
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
                $dados['chamados'] = $data;
            }
            else
            {
                $this->out('Não há manifestos em aberto');
                $dados['chamados'] = [];
            }
        }

        if($this->params['file'])
        {
            $formato = $this->in("Em que formato quer salvar o arquivo?", ['TXT', 'CSV', 'XML', 'JSON'], 'TXT');
            $arquivo = $this->in("Digite o nome do arquivo.");

            $formato = strtolower($formato);

            $this->salvarArquivo($mode, $dados, $arquivo, $formato);
        }
        
        if(array_key_exists('file-save', $this->params))
        {
            $arquivo = $this->params['file-save'];
            $formato = null;

            if($this->params['file-type-auto'])
            {
                $formato = $this->selecionarFormatoArquivo($arquivo);
            }
            else
            {
                if(array_key_exists('file-type', $this->params))
                {
                    $formato = $this->params['file-type'];
                }
                else
                {
                    $formato = $this->in("Em que formato quer salvar o arquivo?", ['TXT', 'CSV', 'XML', 'JSON'], 'TXT');
                    $formato = strtolower($formato);
                }
            }

            $this->salvarArquivo($mode, $dados, $arquivo, $formato);
        }

        if($this->params['email'])
        {
            $email = $this->in("Para qual e-mail pretende enviar estas informações?");

            $header = [
                'name' => 'Ouvidoria da Prefeitura Municipal de Coqueiral',
                'from' => 'ouvidoria@coqueiral.mg.gov.br',
                'to' => $email,
                'subject' => 'Status da Ouvidoria da Prefeitura Municipal de Coqueiral'
            ];

            if($this->params['ocultar'])
            {
                
                
                //$this->salvarArquivo($mode, $dados, )
            }
            else
            {
                $params = [
                    'mode' => $mode,
                    'estatisticas' => (array_key_exists('estatisticas', $dados)) ? $dados['estatisticas'] : [],
                    'chamados' => (array_key_exists('chamados', $dados)) ? $dados['chamados'] : [],
                ];
    
                $this->Sender->sendEmailTemplate($header, 'stats', $params);
            }

            
            $this->out('As informações foram enviadas com sucesso');
        }
    }

    public function verificar()
    {

    }

    /**
     * Efetua a operação de salvar o arquivo no sistema, com todas as informações do andamento da ouvidoria.
     * @param string $mode Modo de exibição de estatísticas
     * @param array $dados Dados com todas as informações estatísticas da ouvidoria
     * @param string $arquivo Nome do arquivo a ser salvo no sistema
     * @param string $formato Formato do arquivo a ser salvo
     */
    private function salvarArquivo($mode, $dados, $arquivo, $formato)
    {
        switch($formato)
        {
            case "txt":
                $retorno = $this->arquivoTexto($dados);
                $this->createFile($arquivo, $retorno);
                break;
            case "csv":
                if($mode == 'chamados')
                {
                    $retorno = $this->arquivoCSV($dados);
                    $this->createFile($arquivo, $retorno);
                }
                else
                {
                    $this->abort('Não é permitido salvar arquivo CSV neste modo.');
                }
                break;
            case "xml":
                $retorno = $this->arquivoXML($dados);
                $retorno->asXML($arquivo);
                $this->out('Arquivo salvo com sucesso!');
                break;
            case "json":
                $retorno = $this->arquivoJSON($dados);
                $this->createFile($arquivo, $retorno);
                break;
        }
    }

    /**
     * Monta o arquivo de texto simples com o andamento de ouvidoria.
     * @param $dados Dados com as informações de todo o andamento da ouvidoria.
     * @return string Conteúdo a ser salvo no arquivo.
     */
    private function arquivoTexto($dados)
    {
        $retorno = "";

        if(array_key_exists('estatisticas', $dados))
        {
            $retorno = "Total de manifestacoes:  " . $dados['estatisticas']['total'] . "\r\n" . 
                       "Manifestações em aberto: " . $dados['estatisticas']['abertos'] . " \r\n". 
                       "Manifestações novas:     " . $dados['estatisticas']['novos'] . " \r\n" .
                       "Manifestações atrasadas: " . $dados['estatisticas']['atrasados'] . " \r\n" .
                       "Manifestações fechadas:  " . $dados['estatisticas']['fechados'];
        }

        if(array_key_exists('chamados', $dados))
        {
            $retorno = $retorno . "\r\n\r\n\r\n";
            
            if(count($dados['chamados']) > 0)
            {
                $retorno = $retorno . "Chamados em aberto\r\n";
                
                $chamados = $dados['chamados'];

                foreach($chamados as $chamado)
                {
                    $linha = "";

                    foreach($chamado as $dado)
                    {
                        $linha = $linha . $dado . "\t";
                    }

                    $retorno = $retorno . $linha . "\r\n";
                }
            }
            else
            {
                $retorno = $retorno . "Não há chamados em aberto";
            }
        }

        return $retorno;
    }

    /**
     * Monta o arquivo de texto, no formato CSV com o andamento de ouvidoria.
     * @param $dados Dados com as informações de todo o andamento da ouvidoria.
     * @return string Conteúdo a ser salvo no arquivo.
     */
    private function arquivoCSV($dados)
    {
        $retorno = "";

        if(array_key_exists('chamados', $dados))
        {
            if(count($dados['chamados']) > 0)
            {
                $chamados = $dados['chamados'];

                foreach($chamados as $chamado)
                {
                    $linha = "";

                    foreach($chamado as $dado)
                    {
                        $linha = $linha . $dado . ",";
                    }

                    $retorno = $retorno . $linha . "\r\n";
                }
            }
            else
            {
                $retorno = $retorno . "Não há chamados em aberto";
            }
        }

        return $retorno;
    }

    /**
     * Monta o arquivo XML com o andamento de ouvidoria.
     * @param $dados Dados com as informações de todo o andamento da ouvidoria.
     * @return string Objeto XML.
     */
    private function arquivoXML($dados)
    {
        $xml = [];
        $document = [];
        
        if(array_key_exists('estatisticas', $dados))
        {
            $document['dados'] = $dados['estatisticas'];            
        }

        if(array_key_exists('chamados', $dados))
        {
            $cdata = $dados['chamados'];
            $cabecalho = [];
            
            for($i = 0; $i < count($cdata); $i++)
            {
                $chamados = [];

                if($i == 0)
                {
                    $cabecalho = $cdata[$i];
                }
                else
                {
                    $linha = $cdata[$i];
                    $chamado = [];

                    for($j = 0; $j < count($linha); $j++)
                    {
                        $chamado[$cabecalho[$j]] = $linha[$j];
                    }

                    $chamados['chamado'] = $chamado;
                }
            }

            $document['chamados'] = $chamados;
        }

        $xml['ouvidoria'] = $document;

        return Xml::build($xml);
    }

    /**
     * Monta o arquivo JSON com o andamento de ouvidoria.
     * @param $dados Dados com as informações de todo o andamento da ouvidoria.
     * @return string Conteúdo a ser salvo no arquivo.
     */
    private function arquivoJSON($dados)
    {
        $document = [];

        if(array_key_exists('estatisticas', $dados))
        {
            $document['dados'] = $dados['estatisticas'];            
        }

        if(array_key_exists('chamados', $dados))
        {
            $cdata = $dados['chamados'];
            $cabecalho = [];
            
            for($i = 0; $i < count($cdata); $i++)
            {
                $chamados = [];

                if($i == 0)
                {
                    $cabecalho = $cdata[$i];
                }
                else
                {
                    $linha = $cdata[$i];
                    $chamado = [];

                    for($j = 0; $j < count($linha); $j++)
                    {
                        $chamado[$cabecalho[$j]] = $linha[$j];
                    }

                    $chamados['chamado'] = $chamado;
                }
            }

            $document['chamados'] = $chamados;
        }

        return json_encode($document);
    }

    /**
     * Seleciona automaticamente o formato do arquivo a ser salvo.
     * @param string $arquivo Nome do arquivo a ser salvo.
     */
    private function selecionarFormatoArquivo($arquivo)
    {
        $gate = explode('.', $arquivo);
        $extensao = end($gate);
        $formato = '';

        switch($extensao)
        {
            case 'csv':
                $formato = 'csv';
                break;

            case 'xml':
                $formato = 'xml';
                break;
            
            case 'json':
                $formato = 'json';
                break;

            default:
                $formato = 'txt';
        }

        return $formato;
    }
}