<?php

namespace App\Shell\Task;

use Cake\Console\Shell;
use Cake\Core\Configure;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;

/**
 * Classe complementar de manipulação de data e hora do sistema.
 * @package App\Shell\Task
 */
class DateTask extends Shell
{
    /**
     * Dias de semana traduzíveis pelo sistema, por meio de valores padrão do PHP.
     */
    private $dias_semana = [
        'Sunday' => 'Domingo',
        'Monday' => 'Segunda-Feira',
        'Tuesday' => 'Terça-Feira',
        'Wednesday' => 'Quarta-Feira',
        'Thursday' => 'Quinta-Feira',
        'Friday' => 'Sexta-Feira',
        'Saturday' => 'Sábado',
    ];

    /**
     * Verifica se a data é um fim de semana.
     *
     * @param string $date Data informada pelo sistema.
     * @return bool Se o dia informado é um fim de semana.
    */
    public function isWeekend(string $date)
    {
        return (date('N', strtotime($date)) >= 6);
    }

    /**
     * Verifica se a data é um feriado.
     * 
     * @param Time $date Data informada pelo sistema.
     * @return bool Se o dia informado é um feriado.
     */
    public function isHoliday(Time $date)
    {
        $t_feriado = TableRegistry::get('Feriado');

        $query = $t_feriado->find('all', [
            'conditions' => [
                'data' => $this->Format->formatDateDB($date) 
            ]
        ]);

       return $query->count() > 0;
    }
}