<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\Http\Client;

/**
 * Classe que faz a manipulação de componentes, respostas e validação de ações sobre ferramentas de Captcha.
 */
class CaptchaComponent extends Component
{
    /**
     * Faz a validação do Captcha utilizando as ferramentas do Google Recaptcha, para prevenir de ataques de Spammers.
     * @param string $captcha_response Código único de identificação do response do usuário, usado para validar se o mesmo é Spammer.
     * @param bool $invisible Tipo de Recaptcha (visível ou invisível).
     * @return bool Se o retorno de Catpcha do usuário é válido, ou seja, o usuário não é Spammer.
     */
    public function validate(string $captcha_response, bool $invisible)
    {
        $params = null;
        
        if($invisible)
        {
            $params = [
                'secret' => Configure::read('Security.reCaptcha.invisible.secretKey'),
                'response' => $captcha_response,
                'remoteip' => $_SERVER['REMOTE_ADDR']
            ];
        }
        else
        {
            $params = [
                'secret' => Configure::read('Security.reCaptcha.default.secretKey'),
                'response' => $captcha_response,
                'remoteip' => $_SERVER['REMOTE_ADDR']
            ];
        }

        $url = Configure::read('Security.reCaptcha.urlVerify');
        $http = new Client();
        $response = $http->post($url, $params);
        $result = $response->json;

        return $result['success'];
    }
}