<?php

namespace App\Model\Entity;

use Cake\Core\Configure;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

class Concurso extends Entity
{
    protected function _getAtivado()
    {
        return $this->_properties['ativo'] ? 'Sim' : 'Não';
    }

    protected function _getSituacao()
    {
        $idConcurso = $this->_properties['id'];
        $idStatus = $this->_properties['status']['id'];
        $nome = $this->_properties['status']['nome'];
        $inscricaoInicio = $this->_properties['inscricaoInicio'];
        $inscricaoFim = $this->_properties['inscricaoFim'];
        $dataProva = $this->_properties['dataProva'];

        $inscricaoInicio = $inscricaoInicio->i18nFormat('yyyy-MM-dd');
        $inscricaoFim = $inscricaoFim->i18nFormat('yyyy-MM-dd');
        $dataProva = $dataProva->i18nFormat('yyyy-MM-dd');

        $inscricaoInicio = date_create($inscricaoInicio);
        $inscricaoFim = date_create($inscricaoFim);
        $dataProva = date_create($dataProva);
        $hoje = date_create();

        $realizacaoPivot = Configure::read('Concursos.Status.Ativo');
        $situacao = '';

        $t_documentos = TableRegistry::get('Documento');

        $qtdDocumentos = $t_documentos->find('all', [
            'conditions' => [
                'concurso' => $idConcurso,
                'ativo' => true
            ]
        ])->count();

        if($idStatus == $realizacaoPivot)
        {
            if($qtdDocumentos > 0)
            {
                if($hoje < $inscricaoInicio)
                {
                    $situacao = 'Novo';
                }
                elseif(($hoje >= $inscricaoInicio) && ($hoje <= $inscricaoFim))
                {
                    $situacao = 'Inscrições abertas';
                }
                else
                {
                    $situacao = 'Em andamento';
                }
            }
            else
            {
                if($hoje < $inscricaoInicio)
                {
                    $situacao = 'Aguardando Edital';
                }
                else
                {
                    $situacao = 'Edital ainda não publicado. Favor entrar em contato com a prefeitura';
                }
            }

        }
        else
        {
            $situacao = $nome;
        }

        return $situacao;
    }

    protected function _getSlug()
    {
         $titulo = $this->_properties['titulo'];
        $procurar = array(' ', 'ã', 'à', 'á', 'â', 'é', 'ê', 'í', 'ì', 'ó', 'ò', 'õ', 'ô', 'ú', 'ù', 'û', 'ç', ',', '.', '!', '?', ';', '/');
        $substituir = array('_', 'a', 'a', 'a', 'a', 'e', 'e', 'i', 'i', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'c', '', '', '', '', '', '_');

        return strtolower(str_replace($procurar, $substituir, $titulo));
    }
}
