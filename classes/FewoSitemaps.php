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
        $pagesInTheme = $this->getThemePages();
        $page = array_filter($pagesInTheme->all(), function ($page) use ($seoobjekte) {
            return $page->url == $seoobjekte;
        });
        $page = array_values($page);
        $page = $page[0];

        $resObjekte = DB::select("select id, obj_alias, obj_ort, obj_regionid from xsigns_fewo_obj where obj_aktiv = 1");

        if (count($resObjekte) == 0)
            return $dom;

        foreach ($resObjekte as $item)
        {
            $strUrl = $this->buildObjstringUrl($item, $this->getAppUrl()->defaultLangUrl, $seoobjekte, $this->lang);
            $this->buildDom($dom, $xml, $strUrl);

            if (is_null($page->localeUrl))
                continue;

            foreach ($page->localeUrl as $lang => $localeUrl)
            {
                if ($localeUrl == '')
                    continue;

                $localeUrl = '/' . strtolower($lang) . $this->checkStringUrl($localeUrl);
                $strUrl = $this->buildObjstringUrl($item, $this->getAppUrl()->url, $localeUrl, $lang);
                $this->buildDom($dom, $xml, $strUrl);
            }
        }

        return $dom;
    }

    /**
     * @param $item
     * @param $appUrl
     * @param $localeUrl
     * @param $lang
     * @return array|string|string[]
     */
    private function buildObjstringUrl($item, $appUrl, $localeUrl, $lang)
    {
        $strUrl = str_replace(':alias', '', $appUrl . $localeUrl . $item->obj_alias);
        $strUrl = str_replace(':ort', Fewo::standardize($item->obj_ort), $strUrl);
        $region = Region::bildeRegionstext(null, $this->modulename, $item->obj_regionid, strtoupper($lang), '');

        return str_replace(':region', Fewo::standardize($region), $strUrl);
    }

    /**
     * @param $dom
     * @param $xml
     * @return false|string|void
     */
    private function getHausSitemap($dom, $xml)
    {
        $seohaus = GlobalSettings::get('seohaus');
        $pagesInTheme = $this->getThemePages();
        $page = array_filter($pagesInTheme->all(), function ($page) use ($seohaus) {
            return $page->url == $seohaus;
        });
        $page = array_values($page);
        $page = $page[0];

        $resHaus = DB::select("select id, haus_alias from xsigns_fewo_ha left join xsigns_fewo_halang on (hausid = id) where lang = " . Database::escape($this->lang));

        if (count($resHaus) == 0)
            return $dom;

        foreach ($resHaus as $item)
        {
            $strUrl = str_replace(':alias', '', $this->getAppUrl()->defaultLangUrl . $this->checkStringUrl($seohaus) . $item->haus_alias);
            $this->buildDom($dom, $xml, $strUrl);

            if (is_null($page->localeUrl))
                continue;

            foreach ($page->localeUrl as $lang => $localeUrl)
            {
                if ($localeUrl == '')
                    continue;

                $localeUrl = '/' . strtolower($lang) . $this->checkStringUrl($localeUrl);
                $strUrl = str_replace(':alias', '', $this->getAppUrl()->url . $localeUrl . $item->haus_alias);
                $this->buildDom($dom, $xml, $strUrl);
            }
        }

        return $dom;
    }

    /**
     * @param $dom
     * @param $xml
     * @return mixed
     */
    private function getPagesSitemap($dom, $xml)
    {
        $pagesForSitemap = GlobalSettings::get('pagessitemap');

        if (empty($pagesForSitemap))
            return $dom;

        $pages = $this->getThemePages();

        foreach ($pages as $page)
        {
            if (str_contains($page['url'], ':'))
                continue;

            $filename = substr($page['fileName'], 0, -4);

            if (!in_array($filename, $pagesForSitemap) && $page['is_hidden'] != 0)
                continue;

            $strUrl = $this->getAppUrl()->defaultLangUrl . $page['url'];
            if ($page['url'] == '/')
                $strUrl = $this->getAppUrl()->defaultLangUrl;

            $this->buildDom($dom, $xml, $strUrl);

            if (is_null($page['localeUrl']))
                continue;

            foreach ($page['localeUrl'] as $lang => $localePage)
            {
                if ($localePage == '')
                    continue;

                $strUrl = $this->getAppUrl()->url . '/' . $lang . $this->checkStringUrl($localePage);
                if ($localePage == '/')
                    $strUrl = $this->getAppUrl()->url . '/' . $lang;

                $this->buildDom($dom, $xml, $strUrl);
            }
        }

        return $dom;
    }

    /**
     * @param $url
     * @return mixed|string
     */
    private function checkStringUrl($url)
    {
        return substr($url, 0, 1) != '/' ? '/' . $url : $url;
    }

    /**
     * @return object
     */
    private function getAppUrl(): object
    {
        $appUrl = Config::get('app.url');
        $appUrl = substr($appUrl, -1) == '/' ? substr_replace($appUrl, '', -1) : $appUrl;
        $defaultLangUrl = $appUrl . Language::checkLangPath($this->lang);

        return (object) [
            'url' => $appUrl,
            'defaultLangUrl' => $defaultLangUrl
        ];
    }

    /**
     * @param $dom
     * @param $xml
     * @param $strUrl
     * @return void
     */
    private function buildDom($dom, $xml, $strUrl)
    {
        $url = $xml->appendChild($dom->createElement('url'));

        // add loc
        $loc = $url->appendChild($dom->createElement('loc'));
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
            'seiten/sitemap.xml' => 'page',
        );
    }

    /**
     * @return \Cms\Classes\Collection
     */
    private function getThemePages()
    {
        $theme = Theme::getEditTheme();

        if ($theme == '')
            $theme = Theme::load('fewo');

        return Page::listInTheme($theme, true);
    }
}
