<?php

namespace App\Shell;

use Cake\Console\ConsoleOptionParser;
use Cake\Console\Shell;
use Cake\Log\Log;
use Cake\ORM\TableRegistry;

/**
 * Classe para comando em console para ouvidoria.
 */
class OuvidoriaShell extends Shell
{
    
    public function startup()
    {
        $this->out(' ');
        $this->out(' ');
        $this->out(' ');
        $this->out('Ouvidoria da Prefeitura Municipal de Coqueiral');
        $this->out('..............................................');
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
       
        $this->out('Estatísticas Gerais');
        $this->out(' ');
        $this->out('Total de manifestacoes: ' . $total);
        $this->out('Manifestações em aberto: ' . $abertos);
        $this->out('Manifestações novas: ' . $novos);
        $this->out('Manifestações atrasadas: ' . $atrasados);
        $this->out('Manifestações fechadas: ' . $fechados);
    }

    /**
     * Mostra ajuda do Shell de Ouvidoria
     */
    public function ajuda()
    {
        $this->out('Ajuda do recurso');
        $this->out(' ');

        
        $this->out(
            'Este recurso tem a função de executar as tarefas relativas a administração e gerenciamento de ouvidoria ' .
            'with your application in an interactive fashion. You can use ' .
            'it to run adhoc queries with your models, or experiment ' .
            'and explore the features of CakePHP and your application.' .
            "\n\n" .
            'You will need to have psysh installed for this Shell to work.'
        );
    }
}