<?php
/**
 * Classe responsável pela implementação de rotas da versão 0.1.x
 * no endpoint v1 da API
 *
 * @author Joubert <eu@redrat.com.br>
 * @copyright Copyright (c) 2016, Acme Corporation
 * @copyright Copyright (c) 2016, Conta Mobi
 */

namespace AcmeCorp\Api\V1;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;

class Router
{
    /*
     * Prefixo da url da versão 1
     */
    const URI_PREFIX = 'v1';

    /**
     * Injeta as rotas do V1 no app do Silex
     *
     * @param Silex\Application $app
     * @return void
     */
    public static function inject(Application &$app)
    {
        $app->get(
            '/'.self::URI_PREFIX.'/ping/',
            'AcmeCorp\Api\V1\Controller\Test::ping'
        );

        self::injectAuthActions($app);
        self::injectProductActions($app);
        self::injectUserActions($app);
        self::injectLogsActions($app);

        $app->get('/'.self::URI_PREFIX.'/docs/latest/', function (Application $app, Request $request) {
            return $app->redirect(
                $request->getSchemeAndHttpHost().$request->getBaseURL().'/docs/0.1/index.html'
            );
        });
    }

    /**
     * Injeta as rotas relacionados a autenticação
     *
     * @param Silex\Application $app
     * @return void
     */
    private static function injectAuthActions(Application &$app)
    {
        $app->post(
            '/'.self::URI_PREFIX.'/auth/',
            'AcmeCorp\Api\V1\Controller\Users::login'
        );
    }

    /**
     * Injeta as rotas relacionados aos produtos
     *
     * @param Silex\Application $app
     * @return void
     */
    private static function injectProductActions(Application &$app)
    {
        $app->get(
            '/'.self::URI_PREFIX.'/products/',
            'AcmeCorp\Api\V1\Controller\Products::displayAll'
        );
        $app
            ->get(
                '/'.self::URI_PREFIX.'/products/{id}',
                'AcmeCorp\Api\V1\Controller\Products::display'
            )
            ->assert('id', '\d+')
        ;
        $app->post(
            '/'.self::URI_PREFIX.'/products/',
            'AcmeCorp\Api\V1\Controller\Products::insert'
        );
        $app
            ->patch(
                '/'.self::URI_PREFIX.'/products/{id}',
                'AcmeCorp\Api\V1\Controller\Products::update'
            )
            ->assert('id', '\d+')
        ;
        $app
            ->delete(
                '/'.self::URI_PREFIX.'/products/{id}',
                'AcmeCorp\Api\V1\Controller\Products::delete'
            )
            ->assert('id', '\d+')
        ;
    }

    /**
     * Injeta as rotas relacionados aos usuários
     *
     * @param Silex\Application $app
     * @return void
     */
    private static function injectUserActions(Application &$app)
    {
        $app->get(
            '/'.self::URI_PREFIX.'/users/',
            'AcmeCorp\Api\V1\Controller\Users::displayAll'
        );
        $app
            ->get(
                '/'.self::URI_PREFIX.'/users/{id}',
                'AcmeCorp\Api\V1\Controller\Users::display'
            )
            ->assert('id', '\d+')
        ;
        $app->post(
            '/'.self::URI_PREFIX.'/users/',
            'AcmeCorp\Api\V1\Controller\Users::insert'
        );
        $app
            ->patch(
                '/'.self::URI_PREFIX.'/users/{id}',
                'AcmeCorp\Api\V1\Controller\Users::update'
            )
            ->assert('id', '\d+')
        ;
        $app
            ->delete(
                '/'.self::URI_PREFIX.'/users/{id}',
                'AcmeCorp\Api\V1\Controller\Users::delete'
            )
            ->assert('id', '\d+')
        ;
    }

    /**
     * Injeta as rotas relacionados aos logs
     *
     * @param Silex\Application $app
     * @return void
     */
    private static function injectLogsActions(Application &$app)
    {
        $app->get(
            '/'.self::URI_PREFIX.'/logs/',
            'AcmeCorp\Api\V1\Controller\Logs::displayAll'
        );
        $app->get(
            '/'.self::URI_PREFIX.'/logs/types/',
            'AcmeCorp\Api\V1\Controller\Logs::displayTypes'
        );
    }
}
