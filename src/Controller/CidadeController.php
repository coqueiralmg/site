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
           'og:url' => 'http://coqueiral.mg.gov.br/cidade/historico',
           'og:site_name' => 'Prefeitura Municipal de Coqueiral',
           'og:image' => '../img/slide/slider_historico1.jpg',
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
           'og:url' => 'http://coqueiral.mg.gov.br/cidade/perfil',
           'og:site_name' => 'Prefeitura Municipal de Coqueiral',
           'og:image' => '../img/slide/praca.jpg',
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
           'og:url' => 'http://coqueiral.mg.gov.br/cidade/localizacao',
           'og:site_name' => 'Prefeitura Municipal de Coqueiral',
           'og:image' => '../img/slide/praca.jpg',
           'og:image:width' => '600',
           'og:image:height' => '400'
       ];
        
        $this->set('title', "Localização da Cidade");
        $this->set('socialTags', $socialTags);
    }
}