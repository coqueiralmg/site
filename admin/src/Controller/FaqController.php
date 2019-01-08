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
        $t_categorias = TableRegistry::get('Categoria');
        $limite_paginacao = Configure::read('Pagination.limit');

        $this->paginate = [
            'limit' => $limite_paginacao
        ];

        $categorias = $this->paginate($t_categorias);
        $qtd_total = $t_categorias->find('all')->count();

        $this->set('title', 'Categorias de Perguntas');
        $this->set('icon', 'device_unknown');
        $this->set('categorias', $categorias);
        $this->set('qtd_total', $qtd_total);
        $this->set('limit_pagination', $limite_paginacao);
    }

    public function insert()
    {
        $this->redirect(['action' => 'categoria', 0]);
    }

    public function editar(int $id)
    {
        $this->redirect(['action' => 'categoria', $id]);
    }

    public function categoria(int $id)
    {
        $title = ($id > 0) ? 'Edição da Categoria de Perguntas' : 'Nova Categoria de Perguntas';

        $t_categorias = TableRegistry::get('Categoria');

        if($id > 0)
        {
            $categoria = $t_categorias->get($id);
            $this->set('categoria', $categoria);
        }
        else
        {
            $this->set('categoria', null);
        }

        $this->set('title', $title);
        $this->set('icon', 'device_unknown');
        $this->set('id', $id);
    }

    public function post(int $id)
    {
        if ($this->request->is('post'))
        {
            $this->insertCategory();
        }
        else if($this->request->is('put'))
        {
            $this->updateCategory($id);
        }
    }

    private function insertCategory()
    {

    }

    private function updateCategory(int $id)
    {

    }
}
