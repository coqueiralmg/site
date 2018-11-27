<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

/**
 * Classe que faz manipulação e gerenciamento de dados de processos licitatórios, compartilhados em vários controllers.
 * @package App\Controller\Component
 */
class LicitacoesComponent extends Component
{
    /**
     * Atualiza a data de atualização do processo licitatório
     * @param int $idLicitacao Código do banco de dados de licitação
     * @return Data de atualização da licitação.
     */
    public function refresh(int $idLicitacao)
    {
        $t_licitacoes = TableRegistry::get('Licitacao');
        $licitacao = $t_licitacoes->get($idLicitacao);
        $licitacao->dataAtualizacao = $this->obterDataAtualizacao();

        $t_licitacoes->save($licitacao);

        return $licitacao->dataAtualizacao;
    }

    /**
     * Gera uma nova data de atualização para o processo licitatório
     * @return Data de atualização da licitação.
     */
    private function obterDataAtualizacao()
    {
        $postagem = null;
        $postagem = date("Y-m-d H:i:s");

        return $postagem;
    }
}
