<?php

namespace Xsigns\Fewo;

use Backend\Facades\Backend;
use Backend\Facades\BackendMenu;
use DateTime;
use Event;
use System\Classes\PluginBase;
use Xsigns\Fewo\Classes\Database;
use Xsigns\Fewo\Classes\DatabaseCache;
use Xsigns\Fewo\Classes\Language;
use Xsigns\Fewo\Classes\Logger;
use Xsigns\Fewo\classes\Objektbewertung;
use Xsigns\Fewo\Classes\ObjektSuchindex;
use Xsigns\Fewo\Classes\OwnerHelper;
use Xsigns\Fewo\Classes\Preislevel;
use Xsigns\Fewo\classes\SendCron;
use System\Models;
use Xsigns\Fewo\Models\GlobalSettings;
use App;
use Auth;
use Illuminate\Foundation\AliasLoader;
use RainLab\Notify\Classes\Notifier;
use System\Behaviours\SettingsModel;
use Illuminate\Support\Facades\DB;

class Plugin extends PluginBase
{
    public $elevated = true;

    protected $controller = null;

    protected $modulename = "boot plugin";

    /**
     * @throws \Exception
     */
    public function boot()
    {
        ini_set('session.cookie_lifetime', 3600 * 24 * 3);
        ini_set('session.gc_maxlifetime', 3600 * 24 * 3);

        DB::statement("SET SESSION group_concat_max_len = 20480");

        //check if we need to delete demo license file
        $licFile = 'fewo.lic';
        if (file_exists('plugins/xsigns/fewo/fewo.lic'))
        {
            if (file_exists($licFile))
                unlink('plugins/xsigns/fewo/fewo.lic');
        }

        Event::listen('cms.page.beforeDisplay', function ($controller, $url, $page)
        {
            $this->beforeDisplay($controller, $url, $page);
        });

        Event::listen('backend.page.beforeDisplay', function ($controller, $url, $page)
        {
            $this->beforeDisplay($controller, $url, $page);
        });

        if (empty(ini_get('date.timezone')))
            date_default_timezone_set('Europe/Berlin');
        else
            date_default_timezone_set(ini_get('date.timezone'));

        ObjektSuchindex::updateZeitleistenAlleObjekteYearly($this->controller, $this->modulename);
    }

    private function beforeDisplay($controller, $url, $page)
    {
        $this->controller = $controller;

        $controller->vars['database_cache'] = new DatabaseCache();

        //prepare time logging
        $controller->vars['xsigns_fewo_starttime'] = microtime(true);
        $controller->vars['xsigns_fewo_time_correction'] = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]; //this is the time the server needed to give the request to us and boot the first part of october
        $controller->vars['xsigns_fewo_lastime'] = microtime(true);

        if (GlobalSettings::get('debugtime'))
            Models\EventLog::add('Timelog: Time server needed to start: ' . round($controller->vars['xsigns_fewo_time_correction'], 3) . ' s');

        $controller->vars['xsigns_fewo_languages'] = Language::getLanguages($controller, $this->modulename);
    }

    public function registerMarkupTags()
    {
        return [
            'functions' => [
                // Using an inline closure
                'numberRound' => [$this, 'numberRound'],
                'numberToBoolean' => [$this, 'numberToBoolean'],
                'checkFileExists' => [$this, 'checkFileExists'],
            ],
        ];
    }

    public function numberRound($number, $komma)
    {
        return round($number, $komma);
    }

    public function numberToBoolean($number)
    {
        if ($number == 1)
            return 'true';
        else
            return 'false';
    }

    public static function checkFileExists($file_path)
    {
        if (file_exists($file_path))
            return true;
        else
            return false;
    }

    public function pluginDetails()
    {
        return [
            'name' => 'xsigns.fewo::lang.plugin.name',
            'description' => 'xsigns.fewo::lang.plugin.description',
            'author' => 'xsigns',
            'icon' => 'icon-home',
        ];
    }

    public function registerComponents()
    {
        $components = [
            '\Xsigns\Fewo\Components\schemaorg' => 'SchemaOrg',
            '\Xsigns\Fewo\Components\objektliste' => 'Objektliste',
            '\Xsigns\Fewo\Components\objektlisteteilen' => 'ObjektisteTeilen',
            '\Xsigns\Fewo\Components\hausliste' => 'Hausliste',
            '\Xsigns\Fewo\Components\hausdetail' => 'HausDetail',
            '\Xsigns\Fewo\Components\objektsuche' => 'ObjektSuche',
            '\Xsigns\Fewo\Components\listfilter' => 'ListenFilter',
            '\Xsigns\Fewo\Components\objektstammdaten' => 'Objektstammdaten',
            '\Xsigns\Fewo\Components\objektdetail' => 'Objektdetail',
            '\Xsigns\Fewo\Components\belegungsplan' => 'Belegungsplan',
            '\Xsigns\Fewo\Components\objektbewertung' => 'Objektbewertung',
            '\Xsigns\Fewo\Components\bewertungen' => 'Bewertungen',
            '\Xsigns\Fewo\Components\objektbuttons' => 'Objektbuttons',
            '\Xsigns\Fewo\Components\map' => 'Maps',
            '\Xsigns\Fewo\Components\googlemap' => 'GoogleMaps',
            '\Xsigns\Fewo\Components\objektmap' => 'ObjektMap',
            '\Xsigns\Fewo\Components\buchungsmaske' => 'Buchungsmaske',
            '\Xsigns\Fewo\Components\abschluss' => 'Abschluss',
            '\Xsigns\Fewo\Components\image' => 'Image',
            '\Xsigns\Fewo\Components\merkeranzeige' => 'Merkeranzeige',
            '\Xsigns\Fewo\Components\objektbewerten' => 'Objektbewerten',
            '\Xsigns\Fewo\Components\objektbewslider' => 'ObjektBewertungen',
            '\Xsigns\Fewo\Components\objekttextsearch' => 'ObjektTextfeldsuche',
            '\Xsigns\Fewo\Components\preisrechner' => 'Preisrechner',
            '\Xsigns\Fewo\Components\Slider' => 'slider',
            '\Xsigns\Fewo\Components\galerie' => 'galerie',
            '\Xsigns\Fewo\Components\angebotdetail' => 'AngebotDetail',
            '\Xsigns\Fewo\Components\angebote' => 'Angebote',
            '\Xsigns\Fewo\Components\paid' => 'Paid',
            '\Xsigns\Fewo\Components\multisuche' => 'Multisuche',
            '\Xsigns\Fewo\Components\anzahlobjekte' => 'AnzahlObjekte',
            '\Xsigns\Fewo\Components\OpenGraphMetaTags' => 'OpenGraphMetaTags',
            '\Xsigns\Fewo\Components\buchungslueckenfilter' => 'Buchungslueckenfilter'
        ];

        $owner = OwnerHelper::getOwnerComponents();

        if ($owner != null)
            $components = array_merge($components, $owner);

        return $components;
    }

    public function registerPageSnippets()
    {
        return [
            'xsigns\fewo\Components\Slider' => 'slider',
        ];
    }

    public function registerMailTemplates()
    {
        $return = [
            'xsigns.fewo::mail.rating',
            'xsigns.fewo::mail.cronstatus',
            'xsigns.fewo::mail.zahlungsStatus',
            'xsigns.fewo::mail.buchung_de',
            'xsigns.fewo::mail.anfrage_de',
            'xsigns.fewo::mail.zahlung_de',
            'xsigns.fewo::mail.invoice_de',
            'xsigns.fewo::mail.before_de',
            'xsigns.fewo::mail.voting_de',
        ];

        $owner = OwnerHelper::getMailTemplate();

        if ($owner != null)
            $return = array_merge($return, $owner);

        return $return;
    }

    public function registerMailLayouts()
    {
        return [
            'statusbericht' => 'xsigns.fewo::layouts.statusbericht',
        ];
    }

    public function registerSettings()
    {
        $settings = [
            'GlobalSettings' => [
                'label' => 'xsigns.fewo::lang.globalsettings.globalsettings',
                'description' => 'xsigns.fewo::lang.globalsettings.description',
                'category' => 'xsigns.fewo::lang.globalsettings.category',
                'icon' => 'icon-home',
                'order' => 10,
                'class' => 'xsigns\fewo\Models\GlobalSettings',
                'size' => 'adaptive'
            ],
            'AusstattungSet' => [
                'label' => 'xsigns.fewo::lang.ausstattungset.name',
                'description' => 'xsigns.fewo::lang.ausstattungset.description',
                'category' => 'xsigns.fewo::lang.globalsettings.category',
                'icon' => 'oc-icon-check-circle-o',
                'url' => Backend::url('xsigns/fewo/ausstattungset'),
                'permissions' => ['xsigns.fewo.*'],
                'order' => 13,
            ],
            'bookingask' => [
                'label' => 'xsigns.fewo::lang.bookingask.name',
                'description' => 'xsigns.fewo::lang.bookingask.description',
                'category' => 'xsigns.fewo::lang.globalsettings.category',
                'icon' => 'oc-icon-times-circle-o',
                'url' => Backend::url('xsigns/fewo/bookingask'),
                'permissions' => ['xsigns.fewo.*'],
                'order' => 14,
            ],
            'bookinglist' => [
                'label' => 'xsigns.fewo::lang.bookings.name',
                'description' => 'xsigns.fewo::lang.bookings.description',
                'category' => 'xsigns.fewo::lang.globalsettings.category',
                'icon' => 'oc-icon-calendar-o',
                'url' => Backend::url('xsigns/fewo/bookinglist'),
                'permissions' => ['xsigns.fewo.*'],
                'order' => 15,
            ],
            'restzahlungenlist' => [
                'label' => 'xsigns.fewo::lang.globalsettings.restzahlliste_label',
                'description' => 'xsigns.fewo::lang.globalsettings.restzahlliste_desc',
                'category' => 'xsigns.fewo::lang.globalsettings.category',
                'icon' => 'icon-credit-card',
                'url' => Backend::url('xsigns/fewo/restzahlungenlist'),
                'order' => 16,
            ],
            'votings' => [
                'label' => 'xsigns.fewo::lang.votings.name',
                'description' => 'xsigns.fewo::lang.votings.description',
                'category' => 'xsigns.fewo::lang.globalsettings.category',
                'icon' => 'oc-icon-star-o',
                'url' => Backend::url('xsigns/fewo/votings'),
                'permissions' => ['xsigns.fewo.*'],
                'order' => 17,
            ],
            'settings' => [
                'label' => 'xsigns.fewo::lang.slickslider.name',
                'description' => 'xsigns.fewo::lang.slickslider.description',
                'category' => 'xsigns.fewo::lang.globalsettings.category',
                'icon' => 'icon-cog',
                'class' => 'xsigns\fewo\Models\Settings',
                'keywords' => 'slide show settings',
                'permissions' => ['xsigns.fewo.*'],
                'size' => 'adaptive',
                'order' => 18,
            ],
            'slideshows' => [
                'label' => 'xsigns.fewo::lang.slideshows.name',
                'description' => 'xsigns.fewo::lang.slideshows.description',
                'category' => 'xsigns.fewo::lang.globalsettings.category',
                'icon' => 'oc-icon-smile-o',
                'url' => Backend::url('xsigns/fewo/slideshows'),
                'keywords' => 'slideshows',
                'permissions' => ['xsigns.fewo.*'],
                'order' => 19,
            ],
            'galleries' => [
                'label' => 'xsigns.fewo::lang.galerie.name',
                'url' => Backend::url('xsigns/fewo/galleries'),
                'description' => 'xsigns.fewo::lang.galerie.description',
                'category' => 'xsigns.fewo::lang.globalsettings.category',
                'icon' => 'icon-film',
                'keywords' => 'galleries',
                'permissions' => ['xsigns.fewo.*'],
                'order' => 20,
            ],
        ];

        $owner = OwnerHelper::getOwnerSettings();

        if ($owner != null)
            $settings = array_merge($settings, $owner);

        return $settings;
    }

    public function registerFormWidgets()
    {
        return [
            'Xsigns\Fewo\FormWidgets\SyncFeondiActivation' => [
                'label' => 'Sync Feondi activation',
                'code' => 'syncfeondiactivation',
            ],
            'Xsigns\Fewo\FormWidgets\ReloadPricelevel' => [
                'label' => 'Preislevel neu berechnen',
                'code' => 'reloadPricelevel',
            ],
            'Xsigns\Fewo\FormWidgets\ReloadObjSuchindex' => [
                'label' => 'Cache leeren fuer die Objektsuche',
                'code' => 'reloadObjSuchindex',
            ]
        ];
    }

    public function registerPermissions()
    {
        $permissions = [
            'xsigns.fewo.access_globalsettings' => [
                'tab' => 'xsigns.fewo::lang.plugin.name',
                'label' => 'xsigns.fewo::lang.plugin.globalsettings',
            ],
            'xsigns.fewo.access_ausstattungen' => [
                'tab' => 'xsigns.fewo::lang.plugin.name',
                'label' => 'xsigns.fewo::lang.plugin.manage_ausstattungen',
            ],
            'xsigns.fewo.manage_slides' => [
                'label' => 'xsigns.fewo::lang.plugin.manage_slides',
                'tab' => 'xsigns.fewo::lang.plugin.name',
            ],
            'xsigns.fewo.create_slide_shows' => [
                'tab' => 'xsigns.fewo::lang.plugin.name',
                'label' => 'xsigns.fewo::lang.plugin.create_slide_shows_label',
            ],
            'xsigns.fewo.manage_galleries' => [
                'label' => 'xsigns.fewo::lang.plugin.manage_galleries',
                'tab' => 'xsigns.fewo::lang.plugin.name',
            ],
            'xsigns.fewo.access_bookinglist' => [
                'label' => 'xsigns.fewo::lang.plugin.manage_bookinglist',
                'tab' => 'xsigns.fewo::lang.plugin.name',
            ],
            'xsigns.fewo.access_restzahlungenlist' => [
                'label' => 'xsigns.fewo::lang.plugin.manage_bookinglist',
                'tab' => 'xsigns.fewo::lang.plugin.name',
            ],
            'xsigns.fewo.access_votings' => [
                'label' => 'xsigns.fewo::lang.plugin.manage_votings',
                'tab' => 'xsigns.fewo::lang.plugin.name',
            ],
        ];

        $owner = OwnerHelper::getPermissions();

        if ($owner != null)
            $permissions = array_merge($permissions, $owner);

        return $permissions;
    }

    public function registerNavigation() {}

    public function register()
    {
        /*
         * Register the image tag processing callback
         */
        //BackendMenu::registerContextSidenavPartial('xsigns.fewo', 'fewo', '$/xsigns/fewo/partials/_sidenav.htm');

        $alias = AliasLoader::getInstance();
        $alias->alias('Auth', 'Xsigns\Fewo\Facades\Auth');

        App::singleton('fewo.auth', function ()
        {
            return \xsigns\fewo\Classes\AuthManager::instance();
        });

        /*
         * Compatability with RainLab.Notify
         */
        $this->bindNotificationEvents();
    }

    public function registerListColumnTypes()
    {
        return [
            'objekt_name' => [$this, 'evalPropertyDetailsListColumn'],
            'objekt_bew' => [$this, 'evalPropertyDetailsBewColumn'],
            'bew_punkte' => [$this, 'evalPropertyDetailsBewPunkte'],
            'bew_antwort' => [$this, 'evalPropertyDetailsBewAntwort'],
        ];
    }

    public function evalPropertyDetailsBewAntwort($value, $column, $record)
    {
        if ($record->id > 0)
        {
            $resAntwort = Database::select($this->controller, $this->modulename, "select antwort from xsigns_fewo_bew where id = :bewid", false, [
                'bewid' => $record->id
            ]);
            if ($resAntwort[0]->antwort != '')
                return 'Ja';
            else
                return 'Nein';
        }
        else
        {
            return 'Nein';
        }

    }

    public function evalPropertyDetailsBewPunkte($value, $column, $record)
    {
        list($intWert, $intAll, $intCount) = Objektbewertung::getBewertungPunkte($this->controller, $this->modulename, $record->obj_id, 1, $record->id, true);
        return $intWert;
    }

    public function evalPropertyDetailsBewColumn($value, $column, $record)
    {
        if ($record->obj_id > 0)
        {
            $resObjekt = Database::select($this->controller, $this->modulename, "select titel from xsigns_fewo_objlang where objid = " . $record->obj_id);

            if (count($resObjekt) > 0)
                return $resObjekt[0]->titel;
            else
                return 'n/a';
        }
        else
            return 'n/a';
    }

    public function evalPropertyDetailsListColumn($value, $column, $record)
    {
        if ($record->objektid > 0)
        {
            $resObjekt = Database::select($this->controller, $this->modulename, "select titel from xsigns_fewo_objlang where objid = :objid", false, [
                'objid' => $record->objektid
            ]);

            if (count($resObjekt) > 0)
                return $resObjekt[0]->titel;
            else
                return 'n/a';
        }
        else
            return 'n/a';
    }

    public function registerSchedule($schedule)
    {
        $schedule->call(function ()
        {
            SendCron::Mails();
        })->everyFiveMinutes(); //twiceDaily(1, 13); everyFiveMinutes() //everyMinute(); //->daily();  //->everyMinute(); //->daily();
    }

    public function onRender()
    {
        $settings = GlobalSettings::instance();
        $this->page['code'] = $settings->code;
    }

    public function registerNotificationRules()
    {
        return [
            'groups' => [
                'user' => [
                    'label' => 'User',
                    'icon' => 'icon-user',
                ],
            ],
            'events' => [
                \xsigns\Eigentuemer\NotifyRules\UserActivatedEvent::class,
                \xsigns\Eigentuemer\NotifyRules\UserRegisteredEvent::class,
            ],
            'actions' => [],
            'conditions' => [
                \xsigns\fewo\NotifyRules\UserAttributeCondition::class,
            ],
        ];
    }

    protected function bindNotificationEvents()
    {
        if (!class_exists(Notifier::class))
            return;

        Notifier::bindEvents([
            'xsigns.fewo.activate' => \xsigns\fewo\NotifyRules\UserActivatedEvent::class,
        ]);

        Notifier::instance()->registerCallback(function ($manager)
        {
            $manager->registerGlobalParams([
                'user' => Auth::getUser(),
            ]);
        });
    }
}
