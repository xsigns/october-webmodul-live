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
        {
            return 'true';
        }
        else
        {
            return 'false';
        }
    }

    public static function checkFileExists($file_path)
    {
        if (file_exists($file_path))
        {
            return true;
        }
        else
        {
            return false;
        }
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
            '\xsigns\fewo\Components\schemaorg' => 'SchemaOrg',
            '\xsigns\fewo\Components\objektliste' => 'Objektliste',
            '\xsigns\fewo\Components\objektlisteteilen' => 'ObjektisteTeilen',
            '\xsigns\fewo\Components\hausliste' => 'Hausliste',
            '\xsigns\fewo\Components\hausdetail' => 'HausDetail',
            '\xsigns\fewo\Components\objektsuche' => 'ObjektSuche',
            '\xsigns\fewo\Components\listfilter' => 'ListenFilter',
            '\xsigns\fewo\Components\objektstammdaten' => 'Objektstammdaten',
            '\xsigns\fewo\Components\objektdetail' => 'Objektdetail',
            '\xsigns\fewo\Components\belegungsplan' => 'Belegungsplan',
            '\xsigns\fewo\Components\objektbewertung' => 'Objektbewertung',
            '\xsigns\fewo\Components\bewertungen' => 'Bewertungen',
            '\xsigns\fewo\Components\objektbuttons' => 'Objektbuttons',
            '\xsigns\fewo\Components\map' => 'Maps',
            '\xsigns\fewo\Components\googlemap' => 'GoogleMaps',
            '\xsigns\fewo\Components\objektmap' => 'ObjektMap',
            '\xsigns\fewo\Components\buchungsmaske' => 'Buchungsmaske',
            '\xsigns\fewo\Components\abschluss' => 'Abschluss',
            '\xsigns\fewo\Components\image' => 'Image',
            '\xsigns\fewo\Components\merkeranzeige' => 'Merkeranzeige',
            '\xsigns\fewo\Components\objektbewerten' => 'Objektbewerten',
            '\xsigns\fewo\Components\objektbewslider' => 'ObjektBewertungen',
            '\xsigns\fewo\Components\objekttextsearch' => 'ObjektTextfeldsuche',
            '\xsigns\fewo\Components\preisrechner' => 'Preisrechner',
            '\xsigns\fewo\Components\gastlogin' => 'Gastlogin',
            '\xsigns\fewo\Components\Slider' => 'slider',
            '\xsigns\fewo\Components\galerie' => 'galerie',
            '\xsigns\fewo\Components\angebotdetail' => 'AngebotDetail',
            '\xsigns\fewo\Components\angebote' => 'Angebote',
            '\xsigns\fewo\Components\paid' => 'Paid',
            '\xsigns\fewo\Components\multisuche' => 'Multisuche',
            '\xsigns\fewo\Components\anzahlobjekte' => 'AnzahlObjekte',
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
            'xsigns.fewo::mail.rating' => 'Bewertungsmail an Seitenbetreiber',
            'xsigns.fewo::mail.cronstatus' => 'Status-E-Mail an Seitenbetreiber',
            'xsigns.fewo::mail.zahlungsStatus' => 'Status-E-Mail für Restzahlungen an Seitenbetreiber',
            'xsigns.fewo::mail.buchung_de' => 'DE Buchungsbestätigung an Gast',
            'xsigns.fewo::mail.anfrage_de' => 'DE Anfragebestätigung an Gast',
            'xsigns.fewo::mail.zahlung_de' => 'DE Zahlungsbestätigung an Gast',
            'xsigns.fewo::mail.invoice_de' => 'DE Rechnungsmail an Gast',
            'xsigns.fewo::mail.before_de' => 'DE Anreise-Erinnerung an Gast',
            'xsigns.fewo::mail.voting_de' => 'DE Bewertungs-Erinnerung an Gast',
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
                'order' => 11,
            ],
            'bookingask' => [
                'label' => 'xsigns.fewo::lang.bookingask.name',
                'description' => 'xsigns.fewo::lang.bookingask.description',
                'category' => 'xsigns.fewo::lang.globalsettings.category',
                'icon' => 'oc-icon-times-circle-o',
                'url' => Backend::url('xsigns/fewo/bookingask'),
                'permissions' => ['xsigns.fewo.*'],
                'order' => 12,
            ],
            'bookinglist' => [
                'label' => 'xsigns.fewo::lang.bookings.name',
                'description' => 'xsigns.fewo::lang.bookings.description',
                'category' => 'xsigns.fewo::lang.globalsettings.category',
                'icon' => 'oc-icon-calendar-o',
                'url' => Backend::url('xsigns/fewo/bookinglist'),
                'permissions' => ['xsigns.fewo.*'],
                'order' => 12,
            ],
            'restzahlungenlist' => [
                'label' => 'xsigns.fewo::lang.globalsettings.restzahlliste_label',
                'description' => 'xsigns.fewo::lang.globalsettings.restzahlliste_desc',
                'category' => 'xsigns.fewo::lang.globalsettings.category',
                'icon' => 'icon-credit-card',
                'url' => Backend::url('xsigns/fewo/restzahlungenlist'),
                'order' => 13
            ],
            'votings' => [
                'label' => 'xsigns.fewo::lang.votings.name',
                'description' => 'xsigns.fewo::lang.votings.description',
                'category' => 'xsigns.fewo::lang.globalsettings.category',
                'icon' => 'oc-icon-star-o',
                'url' => Backend::url('xsigns/fewo/votings'),
                'permissions' => ['xsigns.fewo.*'],
                'order' => 14,
            ],
            'settings' => [
                'label' => 'xsigns.fewo::lang.slickslider.name',
                'description' => 'xsigns.fewo::lang.slickslider.description',
                'category' => 'xsigns.fewo::lang.globalsettings.category',
                'icon' => 'icon-cog',
                'class' => 'xsigns\fewo\Models\Settings',
                'order' => 500,
                'keywords' => 'slide show settings',
                'permissions' => ['xsigns.fewo.*'],
                'size' => 'adaptive'
            ],
            'slideshows' => [
                'label' => 'xsigns.fewo::lang.slideshows.name',
                'description' => 'xsigns.fewo::lang.slideshows.description',
                'category' => 'xsigns.fewo::lang.globalsettings.category',
                'icon' => 'oc-icon-smile-o',
                'url' => Backend::url('xsigns/fewo/slideshows'),
                'order' => 500,
                'keywords' => 'slideshows',
                'permissions' => ['xsigns.fewo.*'],
            ],
            'galleries' => [
                'label' => 'xsigns.fewo::lang.galerie.name',
                'url' => Backend::url('xsigns/fewo/galleries'),
                'description' => 'xsigns.fewo::lang.galerie.description',
                'category' => 'xsigns.fewo::lang.globalsettings.category',
                'icon' => 'icon-film',
                'keywords' => 'galleries',
                'permissions' => ['xsigns.fewo.*'],
                'order' => 500,
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

    public function registerNavigation()
    {
    }

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
        {
            return 'n/a';
        }
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
        {
            return 'n/a';
        }
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
        {
            return;
        }

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
