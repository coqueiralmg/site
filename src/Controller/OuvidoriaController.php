<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class OuvidoriaController extends AppController
{
    public function index()
    {
        if($this->request->is('post'))
        {
            $nome = $this->request->getData('nome');
            $email = $this->request->getData('email');
            $endereco = $this->request->getData('endereco');
            $telefone = $this->request->getData('telefone');
            $assunto = $this->request->getData('assunto');
            $mensagem = $this->request->getData('mensagem');
            $privativo = ($this->request->getData('privativo') == "1");

            $idManifestante = $this->Ouvidoria->cadastrarManifestante($nome, $email, $endereco, $telefone);
            $idManifestacao = $this->Ouvidoria->inserirManifestacao($idManifestante, $assunto, $mensagem);
    
            $this->Ouvidoria->registrarHistorico($idManifestacao, 'Nova manifestação de ouvidoria', true);
    
            $this->Ouvidoria->enviarMensagemOuvidores($idManifestante, $idManifestacao);
            $this->Ouvidoria->notificarManifestate($idManifestante, $idManifestacao);

            if($privativo)
            {
                $this->salvarDadosManifestanteCookie($mome, $email, $endereco, $telefone);
            }

            $this->redirect(['controller' => 'ouvidoria', 'action' => 'sucesso', $idManifestacao]);
        }
        else
        {
            $this->set('title', "Ouvidoria");
        }
    }

    public function sucesso(int $idManifestacao)
    {
        $this->set('title', "Sucesso");
        $this->set('manifestacao', $idManifestacao);
    }

    private function salvarDadosManifestanteCookie($nome, $email, $endereco, $telefone)
    {
        $this->Cookie->write('ouvidoria_nome', $nome);
        $this->Cookie->write('ouvidoria_email', $email);
        $this->Cookie->write('ouvidoria_endereco', $endereco);
        $this->Cookie->write('ouvidoria_telefone', $telefone);
    }

}