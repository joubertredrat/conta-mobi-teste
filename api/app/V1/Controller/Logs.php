<?php
/**
 * Controller dos logs
 *
 * @author Joubert <eu@redrat.com.br>
 * @copyright Copyright (c) 2016, Acme Corporation
 * @copyright Copyright (c) 2016, Conta Mobi
 */

namespace AcmeCorp\Api\V1\Controller;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;
use AcmeCorp\Api\V1\Model\Log;
use AcmeCorp\Api\V1\Model\User;

class Logs extends ApiController
{
    /**
     * Exibe todos os logs
     *
     * @param Silex\Application $app
     * @param Symfony\Component\HttpFoundation\Request $request
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public function displayAll(Application $app, Request $request)
    {
        $this->setApplication($app);
        $this->setRequest($request);

        $type = $this->request->get('type');
        $user_id = filter_var(
            $this->request->get('user_id'),
            FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 1]]
        );
        if ($user_id) {
            $user = new User($user_id);
        } else {
            $user = null;
        }

        $data = Log::rowsGet($type, $user, ['id', 'DESC']);
        return $this->response($data);
    }

    /**
     * Exibe todos os tipos de logs
     *
     * @param Silex\Application $app
     * @param Symfony\Component\HttpFoundation\Request $request
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public function displayTypes(Application $app, Request $request)
    {
        $this->setApplication($app);
        $this->setRequest($request);

        $data = Log::getTypes();
        return $this->response($data);
    }
}
