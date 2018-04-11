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
    public $tasks = ['Format'];

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
            "Este sistema foi feito para gerenciamento de ouvidoria do sistema, via Shell Console. \n" .
            "Para saber como manipular os comandos necessários, consulte a lista abaixo."
        );


        return $parser;
    }

    public function status($mode = 'simples')
    {
        $t_manifestacao = TableRegistry::get('Manifestacao');
        $t_manifestante = TableRegistry::get('Manifestante');

        $limite = Configure::read('Pagination.short.limit');
        $fechado = Configure::read('Ouvidoria.status.fechado');
        $total = $t_manifestacao->find('all')->count(); 

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
        }

        if($mode == 'completo' || $mode == 'chamados')
        {
            if($total > 0)
            {
                $data = [];
                $htable = $this->helper('Table');
                
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
            }
            else
            {
                $this->out('Não há manifestos em aberto');
            }
        }
    }
    public function verificar()
    {

    }
    
}