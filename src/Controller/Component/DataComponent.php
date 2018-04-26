<?php

namespace App\Controller\Component;

use Cake\Controller\Component;

class DataComponent extends Component
{
    public function decrypt(string $data)
    {
        return json_decode(base64_decode($data));
    }
}
