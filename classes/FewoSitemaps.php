<?php namespace Xsigns\Fewo\Classes;

use Cms\Classes\Page;
use Cms\Classes\Theme;
use DOMException;
use Illuminate\Http\Request;
use Session;
use Xsigns\Fewo\Models\GlobalSettings;
use DOMDocument;
use Db;
use October\Rain\Support\Facades\Config;
use Response;

class FewoSitemaps
{
    protected string $modulename = 'sitemap';
    protected string $lang = 'DE';

    /**
     * @return false|string|void
     * @throws DOMException
     */
    private function getObjektSitemap($dom, $xml)
    {
        $seoobjekte = GlobalSettings::get('seoobjekte');

        $appUrl = Config::get('app.url');
        $appUrl = substr($appUrl, -1) == '/' ? substr_replace($appUrl, '', -1) : $appUrl;
        $currentUrl = $appUrl . Language::checkLangPath($this->lang);

        $resObjekte = DB::select("select id, obj_alias, obj_ort, obj_regionid from xsigns_fewo_obj left join xsigns_fewo_objlang on (objid = id) where obj_aktiv = 1 and lang = " . Database::escape($this->lang));

        if (count($resObjekte) > 0)
        {
            foreach ($resObjekte as $item)
            {
                // add url container node
                $url = $xml->appendChild($dom->createElement('url'));

                // add loc
                $loc = $url->appendChild($dom->createElement('loc'));
                $strUrl = str_replace(':alias', '', $currentUrl . $seoobjekte . $item->obj_alias);
                $strUrl = str_replace(':ort', Fewo::standardize($item->obj_ort), $strUrl);
                $region = Region::bildeRegionstext(null, $this->modulename, $item->obj_regionid, strtoupper($this->lang), '');
                $strUrl = str_replace(':region', Fewo::standardize($region), $strUrl);
                $loc->appendChild($dom->createTextNode($strUrl));

                // add lastmod
                $lastmod = $url->appendChild($dom->createElement('lastmod'));
                $lastmod->appendChild($dom->createTextNode(date('Y-m-d')));

                // add changefreq
                $changefreq = $url->appendChild($dom->createElement('changefreq'));
                $changefreq->appendChild($dom->createTextNode('daily'));

                // add priority
                $priority = $url->appendChild($dom->createElement('priority'));
                $priority->appendChild($dom->createTextNode('0.5'));
            }
        }

        return $dom;
    }

    /**
     * @return false|string|void
     * @throws DOMException
     */
    private function getHausSitemap($dom, $xml)
    {
        $seohaus = GlobalSettings::get('seohaus');

        $appUrl = Config::get('app.url');
        $appUrl = substr($appUrl, -1) == '/' ? substr_replace($appUrl, '', -1) : $appUrl;
        $currentUrl = $appUrl . Language::checkLangPath($this->lang);

        $resHaus = DB::select("select id, haus_alias from xsigns_fewo_ha left join xsigns_fewo_halang on (hausid = id) where lang = " . Database::escape($this->lang));

        if (count($resHaus) > 0)
        {
            foreach ($resHaus as $item)
            {
                // add url container node
                $url = $xml->appendChild($dom->createElement('url'));

                // add loc
                $loc = $url->appendChild($dom->createElement('loc'));
                $strUrl = str_replace(':alias', '', $currentUrl . $seohaus . $item->haus_alias);
                $loc->appendChild($dom->createTextNode($strUrl));

                // add lastmod
                $lastmod = $url->appendChild($dom->createElement('lastmod'));
                $lastmod->appendChild($dom->createTextNode(date('Y-m-d')));

                // add changefreq
                $changefreq = $url->appendChild($dom->createElement('changefreq'));
                $changefreq->appendChild($dom->createTextNode('daily'));

                // add priority
                $priority = $url->appendChild($dom->createElement('priority'));
                $priority->appendChild($dom->createTextNode('0.5'));
            }
        }

        return $dom;
    }

    private function getPagesSitemap($dom, $xml)
    {
        $pagesForSitemap = GlobalSettings::get('pagessitemap');

        if (!empty($pagesForSitemap))
        {
            $theme = Theme::getEditTheme();
            $pages = Page::listInTheme($theme, true);

            foreach ($pages as $page)
            {
                $filename = substr($page['fileName'], 0, -4);

                if (in_array($filename, $pagesForSitemap) && $page['is_hidden'] == 0)
                {
                    // add url container node
                    $url = $xml->appendChild($dom->createElement('url'));

                    // add loc
                    $loc = $url->appendChild($dom->createElement('loc'));
                    $currentUrl = substr_replace(Config::get('app.url'), '', -1) . Language::checkLangPath($this->lang);
                    $loc->appendChild($dom->createTextNode($currentUrl . $page['url']));

                    // add lastmod
                    $lastmod = $url->appendChild($dom->createElement('lastmod'));
                    $lastmod->appendChild($dom->createTextNode(date('Y-m-d')));

                    // add changefreq
                    $changefreq = $url->appendChild($dom->createElement('changefreq'));
                    $changefreq->appendChild($dom->createTextNode('daily'));

                    // add priority
                    $priority = $url->appendChild($dom->createElement('priority'));
                    $priority->appendChild($dom->createTextNode('0.5'));
                }
            }
        }

        return $dom;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws DOMException
     */
    public function buildSitemap(Request $request): \Illuminate\Http\Response
    {
        if (session::has('rainlab.translate.locale'))
            $this->lang = session::get('rainlab.translate.locale');

        $uriRequest = $request->getRequestUri();
        $uri = $uriRequest[0] == '/' ? substr($uriRequest, 1) : $uriRequest;

        // Logger::quickLog($this->modulename, 'Url', $uriRequest);

        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;

        $xml = $dom->appendChild($dom->createElement('urlset'));
        $xml->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        $xml->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
        $xml->setAttribute('xsi:schemaLocation', 'http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd');

        $routes = self::defineRoutes();
        $mode = 'all';

        if (array_key_exists($uri, $routes))
            $mode = $routes[$uri];

        try
        {
            switch ($mode) {
                case 'all':
                default:
                    $dom = $this->getPagesSitemap($dom, $xml);

                    if (GlobalSettings::get('seoobjekte'))
                        $dom = $this->getObjektSitemap($dom, $xml);

                    if (GlobalSettings::get('seohaus'))
                        $dom = $this->getHausSitemap($dom, $xml);

                    break;
                case 'object':
                    if (GlobalSettings::get('seoobjekte'))
                        $dom = $this->getObjektSitemap($dom, $xml);

                    break;
                case 'house':
                    if (GlobalSettings::get('seohaus'))
                        $dom = $this->getHausSitemap($dom, $xml);

                    break;
                case 'page':
                    $dom = $this->getPagesSitemap($dom, $xml);
                    break;
            }

            $sitemap = $dom->saveXML();
        }
        catch (DOMException $e)
        {
            Logger::quickLog($this->modulename, 'DOM Exception', $e);

            return Response::make('404 Not Found', 404);
        }

        return Response::make($sitemap)->header('Content-Type', 'application/xml');
    }

    /**
     * @return string[]
     */
    public static function defineRoutes(): array
    {
        // array key = uri for sitemap
        // array value = sitemap mode
        return array(
            'sitemap.xml' => 'all',
            'sitemap1.xml' => 'object',
            'sitemap2.xml' => 'house',
            'sitemap3.xml' => 'page',
            'objekte/sitemap.xml' => 'object',
            'haeuser/sitemap.xml' => 'house',
            'seiten/sitemap.xml' => 'page'
        );
    }
}
