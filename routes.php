<?php
/**
 * Add Routes to FewoVerwalter
 * Import : import (FewoVerwalter Schnittstelle)
 */

use Xsigns\Fewo\classes\FewoSitemaps;
use Xsigns\Fewo\Classes\Preislevel;

Route::any('cron','xsigns\fewo\classes\SendCron@Mails');
Route::any('api', 'xsigns\fewo\classes\Api@import');
Route::any('api/versions', 'xsigns\fewo\classes\Api@getModuleVersions');
Route::any('hobex/{id}','xsigns\fewo\classes\HobexRequest@Request');
Route::any('guestbooking/{id}','xsigns\fewo\classes\Guest@Login');
Route::any('restzahlung', 'xsigns\fewo\classes\RestzahlungsManager@checkRestzahlungen');
Route::any('objectranking', 'xsigns\fewo\classes\ObjektRanking@setObjRanking');

Route::get('updatepricelevel', function () {
    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'GET')
    {
        if (isset($_GET['u']) && $_GET['u'] === 'tarvelfeondi' && isset($_GET['p']) && $_GET['p'] === 'srfgEDFRGsebSEbYASGRwaXasfdAWSa4fg3')
        {
            Preislevel::berechnePreisLevel();
        }
        else
        {
            http_response_code(401);
            die('Unauthorized');
        }
    }
    else
    {
        http_response_code(401);
        die('Unauthorized');
    }
});

Route::get('sitemap1.xml', function()
{
    try {
    } catch (ModelNotFound $e)
    {
        Log::info(trans('xsigns.fewo::lang.definition.not_found'));

        return App::make(Controller::class)->setStatusCode(404)->run('/404');
    }

    return Response::make(FewoSitemaps::getObjektSitemap())->header("Content-Type", "application/xml");
});

Route::get('sitemap2.xml', function()
{
    try {
    } catch (ModelNotFound $e)
    {
        Log::info(trans('xsigns.fewo::lang.definition.not_found'));

        return App::make(Controller::class)->setStatusCode(404)->run('/404');
    }

    return Response::make(FewoSitemaps::getHausSitemap())->header("Content-Type", "application/xml");
});
