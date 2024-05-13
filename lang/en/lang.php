<?php

return [
    'plugin' =>[
        'name' => 'Fewoverwalter',
        'description' => 'Interface to Fewo-Verwalter'
    ],
    'global' =>[
        'stvorgaben' => 'Requirements',
        'web' => 'Web-Settings',
        'stammdaten' => 'base data',
    ],
    'languages' => [
        'language' => 'Language',
        'language_desc' => 'Language of the issue',
    ],
    'definition' => [
        'not_found' => 'Fewo -> Error 404 in Routing'
    ],
    'objekttextsearch' => [
        'postPage' => 'landing page',
        'postPage_desc' => 'landing page of hit list',
        'labels' => 'captions',
        'auswahl' => 'object selection',
    ],
    'multisearch' => [
        'postPage' => 'landing page objects',
        'postPage_desc' => 'landing page of hit list',
        'labels' => 'captions',
        'auswahl' => 'object selection',
    ],
    'preisrechner' => [
        'postPageBuchung' =>'Landing page booking mask',
        'postPageAnfrage' => 'Landing page request form',
        'preiscss' => 'CSS',
        'preiscss_desc' => 'Additional CSS (col-8)',
        'mitkaution' => 'Sum incl deposit',
        'showbuttons' => 'Buttons (booking/request)',
        'showbuttons_desc' => 'Displays the selected buttons',
    ],
    'schemaorg' => [
        'detailPage' => 'detail page',
        'detailPageDesc' => 'Select object detail page',
        'prop_name' => 'name of company',
        'prop_art' => 'Type of company',
        'prop_beschreibung' =>'Description of the company',
        'prop_str' => 'Street',
        'prop_ort' => 'City',
        'prop_plz' => 'post code',
        'prop_tel' => 'Phone',
        'prop_priceRange' => 'Prices',
        'prop_openingHours' => 'opening hours',
        'prop_image' => 'Logo as URL'

    ],
    'ausstattungset' => [
        'name' => 'Equipment',
        'update' => 'save',
        'description' => 'Assign equipment'
    ],
    'globalsettings' => [
        'label_fewoverwalter1' => 'Fewo base data',
        'globalsettings' =>'FEWO settings',
        'description' => 'access data,debug,SEO,...',
        'sidenav' => '>',
        'category' => 'FewoVerwalter ' . \Xsigns\Fewo\Classes\Fewo::getModuleCurrentVersion(),
        'username' => 'Username',
        'password' => 'Password',
        'tab1'  => 'Settings',
        'tab2'  => 'Mail settings',
        'tab3'  => 'Payments',
        'tab4' => 'Calendar/Date',
        'tab5' => 'URL/CSS',
        'tab5a' => 'Map settings',
        'tabVerwalter' => 'Manager data',
        'hobexuserid' => 'Hobex User ID',
        'hobex_anz_rest' => 'Deposit and final payment',
        'hobex_anz_rest_desc' => '<b>IMPORTANT:</b> Bitte stellen Sie im Fewo-Verwalter unter <i>Stammdaten</i> > <i>Objekte</i> > <i>Finanzen</i> > Bereich <i>Anzahlung und 1. Zahlung</i> den Zeitpunkt für die Anzahlung auf <i><b>sofort</b></i>.<br><br> Die An- und Restzahlung funktioniert nur, wenn auf Ihrem Server ein Cron-Job angelegt ist. Der Cron-Job muss folgende Domain aufrufen und muss täglich ausgeführt werden: https://www.ihreDomain.de/restzahlung<br>Bei weiteren Fragen und Details zu Cron-Jobs, wenden Sie sich bitte an Ihren Anbieter oder Administrator.',
        'hobexpassword' => 'Hobex password',
        'hobexentityId' => 'Hobex entity id',
        'hobextest'  => 'Hobex test payment',
        'paypalon'   => 'PayPal payment',
        'paypaltest'   => 'PayPal test (Sandbox)',
        'paypaluserid' => 'PayPal user',
        'paypalpassword' => 'PayPal password',
        'mformat' => ' Currency format',
        'mformat_desc' => 'Display of the prices (separator + decimal places + currency symbol), .2€ in Euro with 2 decimal ',
        'logimport'   =>'Logging',
        'logimport_desc' => 'Switches on the event log for the import (only data sent). Must be deactivated in production mode.',
        'logHobex' =>'Log Hobex remporary bookings',
        'logHobex_desc' => 'Activates logging for temporary bookings if hobex is used. Must be deactivated in production mode.',
        'logFeondiSync' => 'Log sync to Feondi',
        'logFeondiSync_desc' => 'Turn on the log mode for sync to Feondi',
        'alternativeSearch_section' => 'Alternative search for object lists',
        'alternativeSearch' => 'Show alternative objects for object lists',
        'alternativeSearchAnzahl' => 'Maximum number of alternative objects to be displayed',
        'alternativeSearchAnzahlNaechteVor' => 'Maximum number of nights backward search',
        'alternativeSearchAnzahlNaechteNach' => 'Maximum number of nights forward search',
        'alternativeSearchAnzahl_desc' => 'Sets the maximum number of objects with alternative time periods to be returned.',
        'alternativeSearchAnzahlNaechteVor_desc' => 'Sets how many nights the search period for the alternative search should be extended backwards (x nights before the searched arrival).',
        'alternativeSearchAnzahlNaechteNach_desc' => 'Sets how many nights the search period for the alternative search should be extended forwards (x nights after the searched departure).',
        'debugmodus' => 'Debug',
        'debugmodus_desc' => 'Turns on debug mode and stores all messages in the event log. Must be deactivated in production mode.',
        'debugtime' => 'Log timestamps',
        'debugtime_desc' => 'Logs detailled timestamps in the protocol to find bottlenecks. Must be deactivated in production mode.',
        'noobjektimage' => 'Default image for objects (if no image exists)',
        'nohausimage' => 'Standard picture for houses (if no image exists)',
        'nogrundrissimage' => 'Standard picture for ground plan (if no image exists)',
        'noangebotimage' => 'Standard picture for offers (if no image exists)',
        'blockieren' => 'Do not block quotes and requests',
        'blockieren_desc' => 'Offers and inquiries are not automatically blocked in the allocation plan',
        'aliasart' => 'Set the object alias in front of the alias of the object',
        'aliastyp' => 'Sets the object type before the alias of the object',
        'aliasort' => 'Sets the object place before the alias of the object',
        'seoobjekt' => 'Path to the object detail page',
        'seohaus' => 'Path to the house detail page',
        'mailSettingsSection' => 'Mail setting (booking/requests)',
        'mailuser' => 'Mail sender name',
        'mailuser_desc' => 'Sender name of the status messages',
        'mailaddr' => 'Recipient mail',
        'mailaddr_desc' => 'Mail of the recipient for status messages such as valuation receipts, booking and inquiry confirmations',
        'mailcc' => 'E-mail copy to (CC)',
        'mailcc_desc' => 'E-mail address(es) of recipients for status messages such as evaluation receipts, booking and request confirmations (specify multiple separated by ;).',
        'mailcccron' => 'Send copy for arrival and departure email',
        'mailcccron_desc' => 'If enabled, a copy of the arrival and departure email will be sent to the CC email address provided above.',
        'buchungAnCc' => 'Send booking and inquiry confirmations to CC email address',
        'buchungAnCc_desc' => 'If activated, after a request or booking, the confirmation email will additionally also be sent to the CC email address specified above.',
        'cronbefore' => 'Arrival mailing',
        'beforedays' => 'Days before arrval',
        'cronafter' => 'Departure mailing',
        'cronBeforeSection' => 'Anreise-E-Mail',
        'cronAfterSection' => 'Abreise-E-Mail',
        'afterdays' => 'Days after departure',
        'objektpath' => 'Detail page for valuation link',
        'cronBeforeDefault' => 'Arrival mailing for every booking regardless of advertising mail consent',
        'cronBeforeDefault_desc' => 'If activated, every guest of a booking will get an arrival mail regardless of advertising mail consent.',
        'cronAfterDefault' => 'Departure mailing for every booking regardless of advertising mail consent',
        'cronAfterDefault_desc' => 'If activated, every guest of a booking will get a departure mail regardless of advertising mail consent.',
        'linktext' => 'Text of the evaluation link',
        'croninfo' =>'<h4>Cron information for arrival and departure mailings</h4>Cron jobs only work if a system-cron is created on your server.<br>' .
            'E. g.: php/7.1/bin/php /var/www/vhosts/ihredomain.de/artisan schedule:run >> /dev/null 2>&1<br>execution time cron : * * * * * <br>' .
            'Please ask your administrator to set this up for you.',
        'cronstatus' => 'Send status email for arrival and departure email to CC email address.',
        'cronstatus_desc' => 'If enabled, an email with status information is sent to the CC email address specified above after the cron job is processed.',
        'cronlog' => 'Log for sending arrival and departure emails',
        'cronlog_desc' => 'If enabled, detailed status messages are written to the event log when the cron job is processed',
        'restzahlliste_label' => 'Residual payments',
        'restzahlliste_desc' => 'Overview of all payments on account and balance',
        'map_set_section' => 'Privacy settings',
        'map_activation' => 'Privacy request for maps',
        'map_activation_desc' => '<b>Hint: </b> Activation is <b>strongly recommended</b> for data protection reasons.',
        'map_hint_text' => 'Privacy hint text',
        'map_hint_btn_text' => 'Button label show map',
        'map_hint_cookie_text' => 'Checkbox label save cookie',
        'map_hint_cookie_time' => 'Storage duration for cookie in days',
        'map_hint_cookie_time_desc' => 'Specifies the duration for storing the map cookie in days. <br> If 0 days is selected, the cookie will be deleted after the browser session ends.',
        'map_allg_section' => 'Customize maps',
        'map_google_section' => 'Google Maps',
        'vorname' => 'First name',
        'nachname' => 'Last name',
        'strasse' => 'Street',
        'hausnummer' => 'Hous number',
        'plz' => 'plz',
        'ort' => 'location',
        'mail' => 'E-Mail',
        'website' => 'Website',
        'telefon' => 'phon',
        'mobil' => 'mobil',
        'selectSVGcommand' => 'Geben sie die Class <b>SVG</b> mit an um alle Styels zu übernehmen  <br>Beispiel: <div style="color: #c3c3c3; border: 1.5px solid #18191a; box-shadow: 0px 0px 3px -1px rgba(0,0,0,0.79); padding: 8px; background-color: #303136; width: min-content;"><pre style="margin-bottom: 0px!important;">&lt;svg class="svg"&gt;&lt;path d="M32,10c12.1"/&gt;&lt;/svg&gt;</pre></div>',
        'svgSection' => 'Rating stars as SVG',
        'selectSVG' => 'Specify your SVG that will be used for the rating stars.',
        'SvgColorLabel' => 'SVG stars color',
        'SVGColorComment' => 'Set a color for your SVG stars',
        'seoSection' => 'Settings for SEO links',
        'login_section' => 'Fewo-Verwalter login',
        'alias_section' => 'Object alias',
        'syncfeondi_section' => 'Sync Feondi',
        'log_section' => 'Log settings',
        'allgemein_section' => 'General',
        'cronSettingsSection' => 'Settings for arrival and departure emails',
        'titleheader' => 'META title',
        'titleheader_desc' =>'Placeholder : [ART], [ART_X_TITEL], [TITEL], [ORT], [ORT_X_TITEL], [REGION], [REGION_X_TITEL], [TYP], |KÜRZEN (if empty then object title)',
        'mformatlist' => 'Currency format in list and detail view',
        'mformatlist_desc' => 'Representation of the prices (separator + decimal places + currency sign) ,2€ in Euro with 2 bare decimal places',
        'datecompact' => 'Arrival and departure together',
        'datecompact_desc' => 'Output date field in search as a text field',
        'todayno' => 'Not eligible today',
        'todayno_desc' => 'Todays date in all calendars not selectable',
        'calstart' => 'Set booking plan to search month',
        'calstart_desc' => 'Sets the occupancy schedule to the month of the search.',
        'calclick' => 'Make booking plan clickable',
        'calclick_desc' => 'The date selection for arrival and departure is made via the occupancy plan',
        'tagein' => 'Nights in period',
        'tagein_desc' => 'Represents nights in period in the search mask and filter mask. <br> Please note that gap bookings cannot be filtered by number of nights for technical reasons!',
        'buchungsvorlauf' => 'Booking lead (Nights)',
        'buchungsvorlauf_desc' => 'Sets a booking lead in nights and always applies from the current date.',
        'calcss' => 'Alternative CSS file for calendar selection',
        'calcss_desc' => 'Alternative CSS for the dropdown calendar in price calculator and booking mask',
        'belcss' => 'Alternative CSS file for the booking plan',
        'belcss_desc' => 'Alternative CSS for the booking plan in the master data',
        'detaillink' => 'Open detail pages as target_blank',
        'detaillink_desc' => 'Opens object and house detail pages in new window',
        'map_circle' => 'Display marker as a circle',
        'map_circle_desc' => 'Does not represent a DOT, but only a circle',
        'map_circle_size' => 'Radius of the circle in pixels',
        'map_circle_size_desc' => 'Represents the circle in a fixed radius',
        'map_circle_color' => 'Circle color',
        'map_circle_color_desc' => 'Represents the color of the circle fillOpacity is always 0.5',
        'gmapMarker' => 'Marker Image (Otherwise Standard DOT)',
        'googlemapsapi' => 'Google Maps Api Key',
        'googlemapsapi_desc' => 'Google Maps Api Key is necessary as soon as Google Maps maps are to be used',
        'invoice' => 'On account',
        'hobexsection' => 'HOBEX',
        'hobexsection_desc' => 'Settings for HOBEX <br><b>This interface only works with HOBEX COPYandPAY.</b>',
        'hobexversion' => 'Hobex version',
        'hobexversion_desc' => 'Hobex version 2 from 30.03.2020',
        'hobexrequest' => 'Target page Completed',
        'hobexfehler' => 'Destination page payment error',
        'hobexvisa'=> 'Visa',
        'hobexmaster' => 'Master',
        'hobexmaestro' => 'Maestro',
        'hobexvpay' => 'V-Pay',
        'hobexsofort' => 'Instant bank transfer',
        'hobexgiropay' => 'GiroPay',
        'hobexamex' => 'American Express',
        'hobexpaypal' => 'PAYPAL',
        'hobex_kurtaxe' => 'Kurtaxe berechnen',
        'hobex_kurtaxe_desc' => 'Bei aktivierter An- und Restzahlung wir die Kurtaxe mit der Anzahlung berechnet.',
    ],
    'components' => [
        'listfilter' => 'List filter',
        'listfilter_desc' => 'Show list filter in object list',
        'objektstammdaten' => 'Object data',
        'objektstammdaten_desc' => 'Services, seasons, features, statistics, distances',
        'objektdetail' => 'Object details',
        'objektdetail_desc' => 'Represents the primitive elements of the object',
        'objektbelegungsplan' => 'Availability calendar',
        'objektbelegungsplan_desc' => 'Show calendar in object list and object detail',
        'objektbewertung' => 'Rating',
        'objektbewertung_desc' => 'Show object rating with stars',
        'objektbuttons' => 'Object Buttons',
        'objektbuttons_desc' => 'Show buttons for booking, offer and memory',
        'objektlisteteilen' => 'Share objectlist',
        'objektlisteteilen_desc' => 'Shows a share button for a filtered objectlist.',
        'bewertungen' => 'Ratings',
        'bewertungen_desc' => 'Displays all ratings',
        'objektmap' => 'Object OpenStreetMap',
        'objektmap_desc' => 'OpenStreetMap for all objects',
        'abschluss' => 'Conclusion',
        'abschluss_desc' => 'Closing component with guest data, object data and time period',
        'angebotdetail' => 'Offer detail',
        'angebotdetail_desc' => 'Detail view of an offer',
        'hausdetail' => 'House detail',
        'hausdetail_desc' => 'House detail, represents the house with objects',
        'googlemap' => 'Google Map Object List',
        'googlemap_desc' => 'Google map for list page',
        'paid' => 'Payment completed',
        'paid_desc' => 'Component for payment completed',
        'buchungsmaske' => 'Booking form',
        'buchungsmaske_desc' => 'Show the booking form',
        'multisuche' => 'Multisearch',
        'multisuche_desc' => 'Search for place, region, accommodation',
        'anzahlobjekte' => 'Number of object',
        'anzahlobjekte_desc' => 'Shows the number of objects within the places and regions',
        'image' => 'Pictures object, house',
        'image_desc' => 'Show pictures from the master data',
        'merkeranzeige' => 'Memorized objects',
        'merkeranzeige_desc' => 'Represents the number of memorized objects.',
        'objektliste' => 'Object list',
        'objektliste_desc' => 'Object list, random object list, note list',
        'hausliste' => 'House list',
        'hausliste_desc' => 'Show house list with pagination',
        'objektbewerten' => 'Rating form',
        'objektbewerten_desc' => 'show rating form in object details',
        'objektbewslider' => 'Rating list',
        'objektbewslider_desc' => 'Show ratings for objects',
        'objekttextsearch' => 'Text search',
        'objekttextsearch_desc' => 'Autofill text search for objects',
        'schemaorg' => 'Schemaorg',
        'schemaorg_desc' => 'Represents schemaorg in the header',
        'preisrechner' => 'Price calculator',
        'preisrechner_desc' => 'calculate the prices of an object',
        'gastlogin' => 'Guest login',
        'gastlogin_desc' => 'Guest login for change booking',
        'angebote' => 'Offers',
        'angebote_desc' => 'Represents a list of offers',
        'map' => 'Map',
        'map_desc' => 'Open StreaMap for objects and houses',
        'buchungslueckenfilter' => 'Booking gap filter',
        'buchungslueckenfilter_desc' => 'Represents a filter for booking gaps',
    ],
    'permissions' => [
        'tab' => 'FewoVerwalter Stammdaten',
        'bookingmasks' => 'Buchungsmasken',
        'languages' => 'Sprachen',
        'settings' => 'Einstellungen',
        'stamm' => 'Stammdaten',
        'manage_galleries' => 'Manage the galleries',
    ],
    'objektsuche' => [
        'name' => 'Search form',
        'description' => 'Search form for index page',
        'submit' => 'suchen de',
    ],
    'mailtemplates' => [
        'label_template' => 'Mail templates',
        'new' => 'new mail template',
        'create' => 'create mail template',
        'edit' => 'edit mail template',
        'language' => 'Sprache',
        'template_type' =>'Art',
        'tab_template' =>'MailVorlage',
        'template_text' => 'HTML-Mailvorlage',
        'template_subject' => 'Betreff der Mail',
        'template_subject_info' =>'Betreff mit Platzhaltern.',
        'template_text_info' => '<h4>Liste der PLatzhalter:</h4><b>Gastdaten</b><br> {{ TITEL }},  {{ ANREDE }},  {{ VORNAME }},  {{ NAME }},  {{ STRASSE }},  {{ PLZ }},  {{ ORT }},  {{ LAND }},  {{ TEL }},  {{ MOBIL }},  {{ FAX }},  {{ MAIL }},  {{ GEB }}<br>
         <b>Eigentümer</b><br> {{ E-VORNAME }},  {{ E-NAME }},  {{ E-FIRMA }},  {{ E-STRASSE }},  {{ E-PLZ }},  {{ E-ORT }},  {{ E-LAND }},  {{ E-MAIL }},  {{ E-TEL }} <br>
         <b>Objekt</b><br> {{ OBJEKT }},  {{ OBJEKT-NR }},  {{ OBJEKT-STRASSE }},  {{ OBJEKT-PLZ }},  {{ OBJEKT-ORT }}, {{ OBJEKT-BESCHREIBUNG }},  {{ OBJEKT-HTMLPREIS1 }},  {{ OBJEKT-HTMLPREIS2 }}<br>
         <b>Vorgang</b><br> {{ NR }},  {{ ANREISE }},  {{ ABREISE }},  {{ TAGE }}, {{ ERWACHSENE }},  {{ KINDER }},  {{ KLEINKINDER }}, {{ OBJEKTPREIS }},  {{ FLEISTPREIS }},  {{ GLEISTPREIS }},  {{ ZUSCHLAGPREIS }},  {{ ANZAHLUNG }},  {{ RESTBETRAG }},  {{ GEBUEHR }},  {{ SUMME }}, {{ SUMMEGESAMT }},  {{ NACHRICHT }},  {{ DATUM }},   {{ ZAHLUNGSWUNSCH }},  {{ KAUTION }},  {{ ANGEBOT }} = Angebotstitel<br>
         <b>Zahlungsangaben</b><br> {{ ZAHLART }},  {{ ZAHLTXID }} = Vorgangsnummer,  {{ ZAHLCARD }} = Zahlungsart/Kreditkarte<br>
         <b>Zuschläge</b><br> {{ ZUSCHLAEGE }}<br> 
         <b>Leistungen</b><br> {{ LEISTUNGEN }}<br>
         <b>Mitreisende</b><br> {{ MITREISENDE }}<br><br>
         <b>Betreff-Zeile</b><br>
          {{ OBJEKT }},  {{ OBJEKT-NR }},  {{ ANREISE }},  {{ ABREISE }}',
        'type' => 'Art',
        'name' => 'Mail template name',
        'manage' => 'edit Mail template',
        'name_placeholder' =>'here name of the mail template',
    ],
    'messages' => [
        'max_files' => 'Sie haben die maximale Anzahl an Bildern erreicht.',
        'ondelete' => '%s kann nicht gelöscht werden, da noch verknüpft!',
    ],
    'OpenGraphMetaTags' => [
        'name' => 'OpenGraphMetaTags',
        'description' => 'Add Meta Title',
    ],
    'bookingask' =>[
        'name' => 'Only requests possible',
        'delete' => 'delete selected',
        'id' => 'nr.',
        'deselected' => 'Remove marker(s)',
        'description' => 'Blocks date ranges for bookings',
        'new' => 'new period',
        'ask_name' => 'Name of the lock',
        'ask_name_placeholder' => 'Please enter the name here',
        'ask_from' => 'From date',
        'ask_to' => 'To date',
        'return_to_bookingask' => 'back to liste',
        'delete_selected_confirm' => 'Really delete blocking period?'
    ],
    'bookings' =>[
        'name' => 'Bookings/Requests',
        'description' => 'Received bookings and requests',
    ],
    'votings' => [
        'name' => 'Ratings',
        'description' => 'Edit ratings',
        'delete_selected_confirm' => 'Really delete selected entries?',
        'delete' => 'Delete ratings',
        'import' => 'Import ratings'
    ],
    'booking' => [
        'manage_booking' => 'Edit bookings',
        'name' => 'Bookings and requests',
        'update_booking' => 'Save booking',
        'deselected' => 'Re-enable marked for transfer',
        'delete' => 'Delete selected bookings',
        'change_selected_confirm' => 'Release selected entries again?',
        'delete_selected_confirm' => 'Really delete selected entries?',
        'sendMail' => 'Send marked booking confirmation mail',
        'sendMail_confirm' => 'Do you really want to send the booking confirmation email to the guest of the selected entries?'
    ],
    'voting' => [
        'delete' => 'Delete selected ratings',
        'delete_selected_confirm' => 'Delete the marked rating(s)?'
    ],
    'eigentuemer' => [
        'label_eigentuemer' => 'Eigentümer/Vermittler',
    ],
    'buchungsmaske' => [
        'showcalpers' => 'Buchungsdaten',
        'showcalpers_desc' =>'Welche Daten sollen abgefragt werden',
        'fehlertexte' => 'Fehlertexte',
        'fehlertexte_desc' => 'fehlertexte der Buchungsmaske als HTML',
        'maskVariant' => 'Variant of the mask',
        'maskVariant_desc' => 'Choose the variant of the booking mask/inquiry maks.'
    ],
    'slideshows' => [
        'name' => 'SildeShows',
        'description' => 'SlideShows new and edit',
    ],
    'slickslider' => [
        'name' =>'SlideShow settings',
        'description' => 'defaut settings slideshow',
        'title' => 'Slide-Show Titel',
        'slides' => 'Slides',
        'image' => 'Image',
        'slide_title' => 'Titel',
        'slide_description' => 'Beschreibung',
        'manage_slide_shows' => 'User can manage all aspects of the slide show (slides and settings)',
        'slide_shows' => 'Image-Slider',
        'settings' => 'Einstellungen',
        'slide_show_height' => 'Slide Show Height',
        'autoplay' => 'Auto Play',
        'slide_image' => 'Slide Image',
        'accessibility' => 'Accessibility',
        'autoplay_desc' => 'Enables Autoplay',
        'accessibility_desc' => 'Enables tabbing and arrow key navigation',
        'adaptive_height_desc' => 'Enables adaptive height for single slide horizontal carousels.',
        'adaptive_height' => 'Adaptive Height',
        'autoplay_speed_desc' => 'Autoplay Speed in milliseconds',
        'autoplay_speed' => 'Autoplay Speed',
        'arrows' => 'Prev/Next Arrows',
        'prev_arrow_desc' => 'Allows you to select a node or customize the HTML for the "Previous" arrow.',
        'prev_arrow' => 'Previous Arrow',
        'next_arrow_desc' => 'Allows you to select a node or customize the HTML for the "Next" arrow.',
        'next_arrow' => 'Next Arrow',
        'center_mode_desc' => 'Enables centered view with partial prev/next slides. Use with odd numbered slidesToShow counts.',
        'center_mode' => 'Center Mode',
        'center_padding_desc' => 'Side padding when in center mode (px or %)',
        'center_padding' => 'Center Padding',
        'css_ease_desc' => 'CSS3 Animation Easing',
        'css_ease' => 'CSS Ease',
        'dots_desc' => 'Show dot indicators',
        'dots' => 'Dots',
        'dots_class_desc' => 'Class for slide indicator dots container',
        'dots_class' => 'Dots Class',
        'enables_draggable' => 'Enable mouse dragging',
        'draggable' => 'Draggable',
        'fade_desc' => 'Enable fade',
        'fade' => 'Fade',
        'focus_on_select_desc' => 'Enable focus on selected element (click)',
        'focus_on_select' => 'Focus On Select',
        'easing_desc' => 'Add easing for jQuery animate. Use with easing libraries or default easing methods',
        'easing' => 'Easing',
        'edge_friction_desc' => 'Resistance when swiping edges of non-infinite carousels',
        'edge_friction' => 'Edge Friction',
        'infinite_desc' => 'Infinite loop sliding',
        'infinite' => 'Infinite',
        'initial_slide_desc' => 'Slide to start on',
        'initial_slide' => 'Initial Slide',
        'lazy_load_desc' => 'Set lazy loading technique. Accepts "ondemand" or "progressive"',
        'lazy_load' => 'Lazy Load',
        'mobile_first_desc' => 'Responsive settings use mobile first calculation',
        'mobile_first' => 'Mobile First',
        'pause_on_focus_desc' => 'Pause Autoplay On Focus',
        'pause_on_focus' => 'Pause On Focus',
        'pause_on_hover_desc' => 'Pause Autoplay On Hover',
        'pause_on_hover' => 'Pause on Hover',
        'pause_on_dots_hover_desc' => 'Pause Autoplay when a dot is hovered',
        'pause_on_dots_hover' => 'Pause on Dots Hover',
        'rows_desc' => 'Setting this to more than 1 initializes grid mode. Use slidesPerRow to set how many slides should be in each row.',
        'rows' => 'Rows',
        'slides_per_row_desc' => 'With grid mode intialized via the rows option, this sets how many slides are in each grid row. dver',
        'slides_per_row' => 'Slides Per Row',
        'slides_to_show_desc' => '# of slides to show',
        'slides_to_show' => 'Slides To Show',
        'slides_to_scroll_desc' => '# of slides to scroll',
        'slides_to_scroll' => 'Slides To Scroll',
        'speed_desc' => 'Slide/Fade animation speed',
        'speed' => 'Speed',
        'swipe_desc' => 'Enable swiping',
        'swipe' => 'Swipe',
        'swipe_to_slide_desc' => 'Allow users to drag or swipe directly to a slide irrespective of slidesToScroll',
        'swipe_to_slide' => 'Swipe To Slide',
        'touch_move_desc' => 'Enable slide motion with touch',
        'touch_move' => 'Touch Move',
        'touch_threshold_desc' => 'To advance slides, the user must swipe a length of (1/touchThreshold) * the width of the slider',
        'touch_threshold' => 'Touch Threshold',
        'use_css_desc' => 'Enable/Disable CSS Transitions',
        'use_css' => 'Use CSS',
        'use_transform_desc' => 'Enable/Disable CSS Transforms',
        'use_transform' => 'Use Transform',
        'variable_width_desc' => 'Variable width slides',
        'variable_width' => 'Variable Width',
        'vertical_desc' => 'Vertical slide mode',
        'vertical' => 'Vertical',
        'vertical_swiping_desc' => 'Vertical swipe mode',
        'vertical_swiping' => 'Vertical Swiping',
        'rtl_desc' => 'Change the slider\'s direction to become right-to-left',
        'rtl' => 'Right to Left',
        'wait_for_animate_desc' => 'Ignores requests to advance the slide while animating',
        'wait_for_animage' => 'Wait for Animate',
        'z_index_desc' => 'Set the zIndex values for slides, useful for IE9 and lower',
        'z_index' => 'z-index',
        'slide_show_height_desc' => 'Height in px, vh, vw, or %',
        'image_position' => 'Image Vertical Position',
        'responsive' => 'Responsive Break Points',
        'breakpoint' => 'Breakpoint',
        'breakpoint_desc' => 'In Pixels (px)',
        'toggle_options' => 'Toggle Options',
        'options' => 'Options',
        'breakpoints' => 'Break Points',
        'id' => 'Slide Show ID',
        'include_jquery' => 'Include jQuery',
        'include_jquery_desc' => 'This plugin requires jQuery to work properly. If you do not have jQuery already in your theme then turn this on',
        'show_title' => 'Show Image-Title',
        'show_title_desc' => 'Show Image-Title as H1-Tag',
        'show_desc' => 'Show Image-description',
        'show_desc_desc' => 'Show Image-description as H2-Tag',
        'show_asimages' => 'Show Images as IMG-TAG',
        'show_asimages_desc' =>'Change from background-image to img',
        'asimages_height' => 'Image height',
        'asimages_height_desc' => 'Image height, when show image is on',
        'include_thumb' => 'show thumb-images',
        'include_thumb_desc' => 'Show thumb-images under slider',
        'thumb_height' => 'Thumb-images height',
        'thumb_height_desc' => 'Height in px, vh, vw, or %',
        'thumb_images' => 'Number of Thumb-images to show',
        'thumb_images_desc' => 'Show (number) of images in thumb-line',
        'thumb_top' => 'Margin top',
        'thumb_top_desc' => 'Margin top in px',

        'thumb_images_1'    => '1 image',
        'thumb_images_2'    => '2 images',
        'thumb_images_3'    => '3 images',
        'thumb_images_4'    => '4 images',
        'thumb_images_5'    => '5 images',
        'thumb_images_6'    => '6 images',
        'thumb_images_7'    => '7 images',
        'thumb_images_8'    => '8 images',
        'thumb_images_9'    => '9 images',
        'thumb_images_10'    => '10 images',
        'slide_link' => 'Slide Link',
        'image_horizontal_position' => 'Image Horizontal Position',
        'manage_slides' => 'User can only manage the slides, not the settings',
        'create_slide_shows' => 'Create Slide Shows',
        'create_slide_shows_label' => 'User can create and delete slide shows',
    ],
    'galleries' => [
        'name' => 'Name',
        'plural' => 'galleries',
        'new_gallery' => 'new gallery',
        'create_galleries' => 'new galleries',
        'update_galleries' => 'Update galleries',
        'manage_galleries' => 'manage galleries',
        'preview_galleries' => 'preview gallery',
        'delete_confirm' => 'Really delete gallery?',
        'return_to_galleries' => 'back to galleries',
    ],
    'galerie' => [
        'name' => 'Image gallery',
        'description' => 'Show image gallery with fancybox',
        'choice' => 'Galerie zum Anzeigen wählen.',
    ],
    'preferences' => [
        'show_gallery_in_nav_label' => 'Zeige Galerie in der Navigation',
        'show_gallery_in_nav_comment' => 'Enabling this makes the gallery appear in the navigation menu instead of the settings page.',
    ],
    'reloadPricelevel' => [
        'preislevel_success' => 'Preislevel für Objekte erfolgreich neu berechnet.',
        'preislevel_fail' => 'Berechnen des Preislevels für Objekte nicht möglich. Es müssen mindestens drei Objekte aktiv und drei verschiedene min. Preise vorhanden sein.',
    ],
    'eigentuemerlogin' => [
        'plugin' => [
            'name' => 'Fewo Owner',
            'description' => 'Owner frontend components.',
            'settings' => 'List all owners',
            'tab' => 'Eigentümer',
            'access_users' => 'Eigentümer verwalten',
            'access_groups' => 'Eigentümergruppen verwalten',
            'access_settings' => 'Eigentümereinstellungen verwalten',
        ],

        'users' => [
            'menu_label' => 'Owner',
            'list_title' => 'Fewo Owner list'
        ],
        'settings' => [
            'users' => 'Owner',
            'menu_label' => 'Owner settings',
            'menu_description' => 'Manage owner settings.',
            'activation_tab' => 'Activation',
            'location_tab' => 'Location',
            'signin_tab' => 'Log in',
            'activate_mode' => 'Activation mode',
            'activate_mode_comment' => 'Select how a user is to be activated.',
            'activate_mode_auto' => 'Automatic',
            'activate_mode_auto_comment' => 'Automatic activation upon registration.',
            'activate_mode_user' => 'User',
            'activate_mode_user_comment' => 'The user activates his own account by e-mail.',
            'activate_mode_admin' => 'Administrator',
            'activate_mode_admin_comment' => 'Only an administrator can activate a user.',
            'require_activation' => 'Registration needed Activation',
            'require_activation_comment' => 'Users must have an activated account to log in.',
            'default_country' => 'Location preset',
            'default_country_comment' => 'If a user does not specify a location, that location is selected as the default.',
            'default_state' => 'Province preset',
            'default_state_comment' => 'If a user does not specify a location, this province is selected as the default.',
            'use_throttle' => 'Limit login attempts',
            'use_throttle_comment' => 'In case of repeated login failures, the user will be temporarily blocked.',
            'login_attribute' => 'Login attribute mapping',
            'login_attribute_comment' => 'Select which user attribute to use for logging in.',
            'registration_tab' => 'Registrations',
            'notifications_tab' => 'Notifications',
            'allow_registration' => 'Allow user registration',
            'allow_registration_comment' => 'If this is disabled, users can only be created by administrators.',
            'send_mail_to_user' => 'Send email to owner',
            'send_mail_to_user_comment' => 'Sends an e-mail with the login information to the owners e-mail address as soon as it is unlocked in the apartment manager or the login information is changed.',
            'select_maske' => 'Use owner login version 2',
            'select_maske_comment' => 'If activated, version 2 of the owner login is used. This offers some new or improved functions and can now also be displayed responsive.',
        ],
        'state' => [
            'label' => 'Provinz',
            'name' => 'Name',
            'name_comment' => 'Anzeigenamen für diese Provinz eingeben.',
            'code' => 'Code',
            'code_comment' => 'Eindeutigen Code für diese Provinz eingeben.',
        ],
        'country' => [
            'label' => 'Land',
            'name' => 'Name',
            'code' => 'Code',
            'code_comment' => 'Eindeutigen Code für dieses Land eingeben.',
            'enabled' => 'Aktiv',
        ],
        'user' => [
            'label' => 'Owner',
            'id' => 'ID',
            'eid' =>'Owner-ID',
            'username' => 'Owner name',
            'name' => 'First name',
            'surname' => 'Name',
            'company' => 'Company',
            'phone' => 'Phone',
            'mobil' => 'Mobil',
            'status_activated' => 'activated',
            'email' => 'E-Mail',
            'created_at' => 'Registered',
            'last_seen' => 'last access',
            'groups' => 'Groups',
            'empty_groups' => 'No Owner groups found.',
            'avatar' => 'Avatar',
            'details' => 'Details',
            'account' => 'Eigentümerkonto',
            'joined' => 'Zuletzt besucht am',
        ],
        'login' => [
            'attribute_email' => 'E-Mail',
            'attribute_username' => 'Owner name',
        ],
        'account' => [
            'account' => 'Owner login form',
            'account_desc' => 'Login form for owners.',
            'force_secure' => 'Sicherheit durchreichen',
            'redirect_to' => 'redirect to',
            'redirect_to_desc' => 'Page name for forwarding after update, login or registration.',
            'code_param' => 'Aktivierungscode Parameter',
            'code_param_desc' => 'Dieser URL-Parameter wird als Registrierungs-Aktivierungscode verwendet',
            'invalid_activation_code' => 'Ungültiger Aktivierungscode übermittelt',
            'invalid_user' => 'Es wurde kein Benutzer mit diesen Zugangsdaten gefunden.',
            'login_first' => 'Sie müssen sich erst einloggen!',
            'sign_in' => 'Anmelden',
            'register' => 'Registrieren',
            'full_name' => 'Name',
            'email' => 'E-Mail',
            'password' => 'Passwort',
            'login' => 'Anmelden',
            'new_password' => 'Neues Passwort',
            'new_password_confirm' => 'Neues Passwort bestätigen',
            'invalid_deactivation_pass' => 'Das eingegebene Passwort war ungültig.',
            'success_deactivation' => 'Konto erfolgreich deaktiviert. Schade, dass du gehst!',
            'registration_disabled' => 'Registrierungen sind momentan deaktiviert.',
        ],
        'session' => [
            'session' => 'Session',
            'session_desc' => 'Fügt Benutzer-Session zu Seite hinzu und kann Zugriff einschränken.',
            'security_title' => 'Erlauben',
            'security_desc' => 'Wer hat Zugriff auf die Seite?',
            'allowed_groups_title' => 'Gruppen erlauben',
            'allowed_groups_description' => 'Benutzergruppen die zugreifen dürfen',
            'all' => 'Jeder',
            'users' => 'Eigentümer',
            'guests' => 'Gäste',
            'redirect_title' => 'Weiterleiten nach',
            'redirect_desc' => 'Seitenname zum Weiterleiten bei verweigertem Zugriff.',
            'logout' => 'Sie haben sich erfolgreich ausgeloggt!',
        ],
        'daten' => [
            'daten' => 'Owner data',
            'daten_desc' => 'Represents calculations, operations and services',
        ],
        'groups' => [
            'menu_label' => 'Groups',
            'all_groups' => 'User Groups',
            'new_group' => 'New Group',
            'delete_selected_confirm' => 'Do you really want to delete the selected groups?',
            'list_title' => 'Manage Groups',
            'delete_confirm' => 'Do you really want to delete this group?',
            'delete_selected_success' => 'Selected groups successfully deleted.',
            'delete_selected_empty' => 'No groups were selected for deletion.',
            'return_to_list' => 'Back to the group list',
            'return_to_users' => 'Back to the owner list',
            'create_title' => 'Create User Group',
            'update_title' => 'Edit User Group',
            'preview_title' => 'Preview of the User Group',
        ],
    ]
];