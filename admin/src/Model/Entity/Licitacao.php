<?php

namespace App\Model\Entity;

use Cake\Core\Configure;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

class Licitacao extends Entity
{
    protected function _getSlug()
    {
        $titulo = $this->_properties['titulo'];
        $procurar = array(' ', 'ã', 'à', 'á', 'â', 'é', 'ê', 'í', 'ì', 'ó', 'ò', 'õ', 'ô', 'ú', 'ù', 'û', 'ç', ',', '.', '!', '?', ';', '/');
        $substituir = array('_', 'a', 'a', 'a', 'a', 'e', 'e', 'i', 'i', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'c', '', '', '', '', '', '_');

        return strtolower(str_replace($procurar, $substituir, $titulo));
    }

    protected function _getAtivado()
    {
        return $this->_properties['ativo'] ? 'Sim' : 'Não';
    }

    protected function _getSituacao()
    {
        $t_anexos = TableRegistry::get('Anexo');

        $id = $this->_properties['id'];
        $modalidade = $this->_properties['modalidade']['chave'];
        $status = $this->_properties['status']['id'];
        $nomeStatus = $this->_properties['status']['nome'];
        $dataSessao = (isset($this->_properties['dataSessao']) ? $this->_properties['dataSessao'] : null);
        $dataFim = (isset($this->_properties['dataFim']) ? $this->_properties['dataFim'] : null);

        $realizacao = Configure::read('Licitacoes.Status.EmRealizacao');
        $situacao = null;

        if($dataSessao == null || $dataSessao == '')
        {
            $dataSessao = '';
        }
        else
        {
            $dataSessao = $dataSessao->i18nFormat('yyyy-MM-dd HH:mm:ss');
            $dataSessao = date_create($dataSessao);
        }

        if($dataFim == null || $dataFim == '')
        {
            if($modalidade == 'PP' ||
               $modalidade == 'CO' ||
               $modalidade == 'TP' ||
               ($modalidade == 'IN' && $dataSessao != "") ||
               ($modalidade == 'DI' && $dataSessao != ""))
            {
                $dataFim = $this->_properties['dataSessao'];
                $dataFim = $dataFim->modify('+8 hours');

                $dataFim = $dataFim->i18nFormat('yyyy-MM-dd HH:mm:ss');
                $dataFim = date_create($dataFim);
            }
            else
            {
                $dataFim = '';
            }
        }
        else
        {
            $dataFim = $dataFim->i18nFormat('yyyy-MM-dd HH:mm:ss');
            $dataFim = date_create($dataFim);
        }

        $hoje = date_create();

        $qtd_anexos = $t_anexos->find('all', [
            'conditions' => [
                'licitacao' => $id,
                'ativo' => true
            ]
        ])->count();

        if($status == $realizacao)
        {
            if($qtd_anexos == 0)
            {
                $situacao = 'Aguardando o Edital';
            }
            else
            {
                if($hoje < $dataSessao)
                {
                    $situacao = 'Novo';
                }
                elseif($hoje >= $dataSessao && $hoje <= $dataFim)
                {
                    $situacao = $nomeStatus;
                }
                else
                {
                    $situacao = 'Em Análise';
                }
            }
        }
        else
        {
            $situacao = $nomeStatus;
        }

        return $situacao;
    }
}
