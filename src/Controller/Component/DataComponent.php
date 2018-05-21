<?php

namespace App\Controller\Component;

use Cake\Controller\Component;

/**
 * Componente de manipulação de dados, metadados e informações de sistema
 */
class DataComponent extends Component
{
    /**
     * Codifica um dado ou uma coleção de dados
     * @param string $data String chave com as informações criptografadas de dados.
     * @return Informação decriptografada de banco de dados.
     */
    public function decrypt(string $data)
    {
        return json_decode(base64_decode($data));
    }
}
