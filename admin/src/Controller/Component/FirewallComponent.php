<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

/**
 * Classe que representa o componente de acesso e bloqueio ao sistema, a partir de uma determinada máquina (Firewall).
 * @package App\Controller\Component
 */
class FirewallComponent extends Component
{
    /**
     * Bloqueia um determinado endereço de IP do sistema
     *
     * @param string $motivo Motivo do bloqueio ter sido ocorrido.
     * @return int|mixed Código do registro de bloqueio, se salvo com sucesso.
     */
    public function bloquear(string $motivo = 'Não definido')
    {
        $id = 0;
        $table = TableRegistry::get('Bloqueado');
        $bloqueado = $table->newEntity();

        $bloqueado->ip = $_SERVER['REMOTE_ADDR'];
        $bloqueado->data_bloqueio = date("Y-m-d H:i:s");
        $bloqueado->motivo = $motivo;

        if($table->save())
        {
            $id = $bloqueado->id;
        }

        return $id;
    }
}