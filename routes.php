<?php
/************************************************
 * Add Routes to FewoVerwalter
 * Import : import (FewoVerwalter Schnittstelle)

 */
// route zum Import
use Xsigns\Fewo\classes\FewoSitemaps;
Route::any('cron','xsigns\fewo\classes\SendCron@Mails');
Route::any('api', 'xsigns\fewo\classes\Api@import');
Route::any('feondi', 'xsigns\fewo\classes\Api@import');
Route::any('feondit','xsigns\fewo\classes\Feondi@data');
Route::any('hobex/{id}','xsigns\fewo\classes\HobexRequest@Request');
Route::any('guestbooking/{id}','xsigns\fewo\classes\Guest@Login');
Route::get('sitemap1.xml', function()
{
    try {
    } catch (ModelNotFound $e) {

        Log::info(trans('xsigns.fewo::lang.definition.not_found'));

        return App::make(Controller::class)->setStatusCode(404)->run('/404');
    }
    return Response::make(FewoSitemaps::getObjektSitemap())
        ->header("Content-Type", "application/xml");
});
Route::get('sitemap2.xml', function()
{
    try {
    } catch (ModelNotFound $e) {
        Log::info(trans('xsigns.fewo::lang.definition.not_found'));

        return App::make(Controller::class)->setStatusCode(404)->run('/404');
    }
    return Response::make(FewoSitemaps::getHausSitemap())
        ->header("Content-Type", "application/xml");
});

