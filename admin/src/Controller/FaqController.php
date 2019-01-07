<?php

namespace App\Controller;

use App\Model\Table\BaseTable;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;
use Cake\ORM\Entity;
use \Exception;

class FaqController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $this->set('title', 'Perguntas e Respostas');
        $this->set('icon', 'device_unknown');
    }

    public function categorias()
    {
        $t_categoria = TableRegistry::get('Categoria');
        $limite_paginacao = Configure::read('Pagination.limit');

        $this->set('title', 'Categorias de Perguntas');
        $this->set('icon', 'device_unknown');
    }
}
