<?php
/**
 * Add Routes to FewoVerwalter
 * Import : import (FewoVerwalter Schnittstelle)
 */

use Xsigns\Fewo\classes\FewoSitemaps;
use Xsigns\Fewo\Classes\Logger;
use Xsigns\Fewo\Classes\Preislevel;

Route::any('cron','xsigns\fewo\classes\SendCron@Mails');
Route::any('api', 'xsigns\fewo\classes\Api@import');
Route::any('api/versions', 'xsigns\fewo\classes\Api@getModuleVersions');
Route::any('hobex/{id}','xsigns\fewo\classes\HobexRequest@Request');
Route::any('guestbooking/{id}','xsigns\fewo\classes\Guest@Login');
Route::any('restzahlung', 'xsigns\fewo\classes\RestzahlungsManager@checkRestzahlungen');
Route::any('objectranking', 'xsigns\fewo\classes\ObjektRanking@setObjRanking');


$sitemapRoutes = FewoSitemaps::defineRoutes();
array_walk($sitemapRoutes, function (&$value, $key) {$value = $key;});
$sitemapRoutes = implode('|', $sitemapRoutes);

Route::get('/{url}', 'xsigns\fewo\classes\FewoSitemaps@buildSitemap')->where(['url' => $sitemapRoutes]);

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
