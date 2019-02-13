<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class CidadeController extends AppController
{
    public function historico()
    {
       $socialTags = [
           'og:locale' => 'pt_BR',
           'og:type' => 'article',
           'article:publisher' => 'https://www.facebook.com/prefeituradecoqueiral',
           'og:title' => 'História de Coqueiral | Prefeitura Municipal de Coqueiral',
           'og:description' => 'A história da cidade de Coqueiral - MG.',
           'og:url' => 'https://coqueiral.mg.gov.br/cidade/historico',
           'og:site_name' => 'Prefeitura Municipal de Coqueiral',
           'og:image' => 'https://coqueiral.mg.gov.br/img/slide/slider_historico1.jpg',
           'og:image:width' => '600',
           'og:image:height' => '400'
       ];

       $this->set('title', "História de Coqueiral");
       $this->set('socialTags', $socialTags);
    }

    public function perfil()
    {
         $socialTags = [
           'og:locale' => 'pt_BR',
           'og:type' => 'article',
           'article:publisher' => 'https://www.facebook.com/prefeituradecoqueiral',
           'og:title' => 'Perfil do Município de Coqueiral | Prefeitura Municipal de Coqueiral',
           'og:description' => 'Perfil e dados gerais sobre a cidade de Coqueiral - MG.',
           'og:url' => 'https://coqueiral.mg.gov.br/cidade/perfil',
           'og:site_name' => 'Prefeitura Municipal de Coqueiral',
           'og:image' => 'https://coqueiral.mg.gov.br/img/slide/praca.jpg',
           'og:image:width' => '600',
           'og:image:height' => '400'
       ];

        $this->set('title', "O Perfil do Município");
        $this->set('socialTags', $socialTags);
    }

    public function localizacao()
    {
        $socialTags = [
           'og:locale' => 'pt_BR',
           'og:type' => 'article',
           'article:publisher' => 'https://www.facebook.com/prefeituradecoqueiral',
           'og:title' => 'Localização da Cidade | Prefeitura Municipal de Coqueiral',
           'og:description' => 'Localização da cidade de Coqueiral - MG.',
           'og:url' => 'https://coqueiral.mg.gov.br/cidade/localizacao',
           'og:site_name' => 'Prefeitura Municipal de Coqueiral',
           'og:image' => 'https://coqueiral.mg.gov.br/img/slide/praca.jpg',
           'og:image:width' => '600',
           'og:image:height' => '400'
       ];

        $this->set('title', "Localização da Cidade");
        $this->set('socialTags', $socialTags);
    }

    public function feriados()
    {
        $socialTags = [
           'og:locale' => 'pt_BR',
           'og:type' => 'article',
           'article:publisher' => 'https://www.facebook.com/prefeituradecoqueiral',
           'og:title' => 'Feriados em Coqueiral | Prefeitura Municipal de Coqueiral',
           'og:description' => 'Feriados do Município de Coqueiral - MG.',
           'og:url' => 'https://coqueiral.mg.gov.br/cidade/feriados',
           'og:site_name' => 'Prefeitura Municipal de Coqueiral',
           'og:image' => 'https://coqueiral.mg.gov.br/img/slide/praca.jpg',
           'og:image:width' => '600',
           'og:image:height' => '400'
       ];


        $ano = date('Y');
        $feriados = $this->listarFeriados($ano);
        $qtd_total = $feriados->count();

        if($qtd_total == 0)
        {
            $ano--;
            $feriados = $this->listarFeriados($ano);
            $qtd_total = $feriados->count();

            if($qtd_total == 0)
            {
                $this->render('vazio');
                $this->set('title', 'Feriados');
            }
            else
            {
                $this->set('title', 'Feriados');
                $this->set('feriados', $feriados);
                $this->set('ano', $ano);
                $this->set('socialTags', $socialTags);
            }
        }
        else
        {
            $this->set('title', 'Feriados');
            $this->set('feriados', $feriados);
            $this->set('ano', $ano);
            $this->set('socialTags', $socialTags);
        }
    }

    private function listarFeriados(int $ano)
    {
        $t_feriado = TableRegistry::get('Feriado');

        $condicoes = array();

        $data_inicial = "01/01/$ano";
        $data_final = "31/12/$ano";

        $condicoes["data >="] = $this->Format->formatDateDB($data_inicial);
        $condicoes["data <="] = $this->Format->formatDateDB($data_final);

        $feriados = $t_feriado->find('all', [
            'conditions' => $condicoes,
            'order' => [
                'data' => 'ASC'
            ]
        ]);

        return $feriados;
    }
}
