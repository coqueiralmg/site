<?php

namespace App\Model\Entity;

use Cake\Core\Configure;
use Cake\ORM\Entity;

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
        $modalidade = $this->_properties['modalidade']['chave'];
        $status = $this->_properties['status']['id'];

        $realizacao = Configure::read('Licitacoes.Status.EmRealizacao');
        $situacao = '';

        $dataSessao = $this->_properties['dataSessao'];
        $dataFim = $this->_properties['dataFim'];

        $dataSessao = $dataSessao->i18nFormat('yyyy-MM-dd');
        $dataFim = $dataFim->i18nFormat('yyyy-MM-dd');

        $dataSessao = date_create($dataSessao);
        $dataFim = date_create($dataFim);
        $hoje = date_create();

        if($status == $realizacao)
        {
            if($modalidade == 'PP' ||
               $modalidade == 'TP')
            {

            }
        }
        else
        {
            $situacao = $status;
        }

        return $situacao;
    }
}
