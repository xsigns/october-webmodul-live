<?php
/**
 * Add Routes to FewoVerwalter
 * Import : import (FewoVerwalter Schnittstelle)
 */

use Xsigns\Fewo\classes\FewoSitemaps;

Route::any('cron','xsigns\fewo\classes\SendCron@Mails');
Route::any('api', 'xsigns\fewo\classes\Api@import');
Route::any('api/versions', 'xsigns\fewo\classes\Api@getModuleVersions');
Route::any('hobex/{transactionid}/{id}','xsigns\fewo\classes\HobexRequest@Request');
Route::any('guestbooking/{id}','xsigns\fewo\classes\Guest@Login');
Route::any('restzahlung', 'xsigns\fewo\classes\RestzahlungsManager@checkRestzahlungen');
Route::any('objectranking', 'xsigns\fewo\classes\ObjektRanking@setObjRanking');
Route::any('filedownload', 'xsigns\fewo\classes\Fewo@downloadFile');
Route::get('updatepricelevel', 'xsigns\fewo\classes\Preislevel@updatepricelevelRequest');
Route::get('/{url}', 'xsigns\fewo\classes\FewoSitemaps@buildSitemap')->where(['url' => FewoSitemaps::sitemapRoutesAsString()]);
Route::get('.well-known/apple-developer-merchantid-domain-association', 'xsigns\fewo\classes\Fewo@loadAppleAssociationFile');
