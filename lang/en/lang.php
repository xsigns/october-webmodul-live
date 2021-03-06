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
    'globalsettings' => [
        'label_fewoverwalter1' => 'Fewo base data',
        'globalsettings' =>'FEWO settings',
        'description' => 'access data,debug,SEO,...',
        'sidenav' => '>',
        'category' => 'FewoVerwalter',
        'username' => 'Username',
        'password' => 'Password',
        'tab1'  => 'Settings',
        'tab2'  => 'Mail settings',
        'tab3'  => 'Payments',
        'hobexuserid' => 'Hobex User ID',
        'hobex_anz_rest' => 'Deposit and final payment',
        'hobex_anz_rest_desc' => '<b>WICHTIG:</b> Bitte stellen Sie im Fewo-Verwalter unter <i>Stammdaten</i> > <i>Objekte</i> > <i>Finanzen</i> > Bereich <i>Anzahlung und 1. Zahlung</i> den Zeitpunkt f??r die Anzahlung auf <i><b>sofort</b></i>.<br><br> Die An- und Restzahlung funktioniert nur, wenn auf Ihrem Server ein Cron-Job angelegt ist. Der Cron-Job muss folgende Domain aufrufen und muss t??glich ausgef??hrt werden: https://www.ihreDomain.de/restzahlung<br>Bei weiteren Fragen und Details zu Cron-Jobs, wenden Sie sich bitte an Ihren Anbieter oder Administrator.',
        'hobexpassword' => 'Hobex password',
		'hobexentityId' => 'Hobex entity id',
        'hobextest'  => 'Hobex test payment',
        'paypalon'   => 'PayPal payment',
        'paypaltest'   => 'PayPal test (Sandbox)',
        'paypaluserid' => 'PayPal user',
        'paypalpassword' => 'PayPal password',
        'mformat' => ' Currency format',
        'mformat_desc' => 'Display of the prices (separator + decimal places + currency symbol), .2??? in Euro with 2 decimal ',
        'logimport'   =>'Logging',
        'logimport_desc' => 'Switches on the event log for the import (only data sent). Must be deactivated in production mode.',
        'logHobex' =>'Log Hobex remporary bookings',
        'logHobex_desc' => 'Activates logging for temporary bookings if hobex is used. Must be deactivated in production mode.',
        'logFeondiSync' => 'Log sync to Feondi',
        'logFeondiSync_desc' => 'Turn on the log mode for sync to Feondi',
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
        'mailuser' => 'Mail sender name',
        'mailuser_desc' => 'Sender name of the status messages',
        'mailaddr' => 'Recipient mail',
        'mailaddr_desc' => 'Mail of the recipient for status messages such as valuation receipts, booking and inquiry confirmations',
        'buchungAnCc' => 'Buchungs- und Anfragebest??tigungen an CC E-Mailadresse senden',
        'buchungAnCc_desc' => 'Wenn aktiviert wird nach einer Anfrage oder Buchungs die Best??tigungsmail zus??tzlich auch an die oben angegebene CC-E-Mailadresse gesendet.',
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
        'angebote' => 'Angebote',
        'angebote_desc' => 'Stellt eine Angebotsliste dar',
        'map' => 'Map',
        'map_desc' => 'Open StreaMap for objects and houses'
    ],
    'permissions' => [
        'tab' => 'FewoVerwalter Stammdaten',
        'bookingmasks' => 'Buchungsmasken',
        'languages' => 'Sprachen',
        'settings' => 'Einstellungen',
        'stamm' => 'Stammdaten'
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
         <b>Eigent??mer</b><br> {{ E-VORNAME }},  {{ E-NAME }},  {{ E-FIRMA }},  {{ E-STRASSE }},  {{ E-PLZ }},  {{ E-ORT }},  {{ E-LAND }},  {{ E-MAIL }},  {{ E-TEL }} <br>
         <b>Objekt</b><br> {{ OBJEKT }},  {{ OBJEKT-NR }},  {{ OBJEKT-STRASSE }},  {{ OBJEKT-PLZ }},  {{ OBJEKT-ORT }}, {{ OBJEKT-BESCHREIBUNG }},  {{ OBJEKT-HTMLPREIS1 }},  {{ OBJEKT-HTMLPREIS2 }}<br>
         <b>Vorgang</b><br> {{ NR }},  {{ ANREISE }},  {{ ABREISE }},  {{ TAGE }}, {{ ERWACHSENE }},  {{ KINDER }},  {{ KLEINKINDER }}, {{ OBJEKTPREIS }},  {{ FLEISTPREIS }},  {{ GLEISTPREIS }},  {{ ZUSCHLAGPREIS }},  {{ ANZAHLUNG }},  {{ RESTBETRAG }},  {{ GEBUEHR }},  {{ SUMME }}, {{ SUMMEGESAMT }},  {{ NACHRICHT }},  {{ DATUM }},   {{ ZAHLUNGSWUNSCH }},  {{ KAUTION }},  {{ ANGEBOT }} = Angebotstitel<br>
         <b>Zahlungsangaben</b><br> {{ ZAHLART }},  {{ ZAHLTXID }} = Vorgangsnummer,  {{ ZAHLCARD }} = Zahlungsart/Kreditkarte<br>
         <b>Zuschl??ge</b><br> {{ ZUSCHLAEGE }}<br> 
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
        'ondelete' => '%s kann nicht gel??scht werden, da noch verkn??pft!',
    ],
    'eigentuemer' => [
        'label_eigentuemer' => 'Eigent??mer/Vermittler',
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
        'choice' => 'Galerie zum Anzeigen w??hlen.',
    ],
    'preferences' => [
        'show_gallery_in_nav_label' => 'Zeige Galerie in der Navigation',
        'show_gallery_in_nav_comment' => 'Enabling this makes the gallery appear in the navigation menu instead of the settings page.',
    ],
    'permissions' => [
        'manage_galleries' => 'Manage the galleries',
    ],
    'reloadPricelevel' => [
        'preislevel_success' => 'Preislevel f??r Objekte erfolgreich neu berechnet.',
        'preislevel_fail' => 'Berechnen des Preislevels f??r Objekte nicht m??glich. Es m??ssen mindestens drei Objekte aktiv und drei verschiedene min. Preise vorhanden sein.',
    ],
    'eigentuemerlogin' => [
        'plugin' => [
            'name' => 'Fewo Owner',
            'description' => 'Owner frontend components.',
            'settings' => 'List all owners',
            'tab' => 'Eigent??mer',
            'access_users' => 'Eigent??mer verwalten',
            'access_groups' => 'Eigent??mergruppen verwalten',
            'access_settings' => 'Eigent??mereinstellungen verwalten',
        ],

        'users' => [
            'menu_label' => 'Owner',
            'list_title' => 'Fewo Owner list'
        ],
        'settings' => [
            'users' => 'Eigent??mer',
            'menu_label' => 'Eigent??mer-Einstellungen',
            'menu_description' => 'Eigent??mer-Einstellungen verwalten.',
            'activation_tab' => 'Aktivierung',
            'location_tab' => 'Standort',
            'signin_tab' => 'Einloggen',
            'activate_mode' => 'Aktivierungsmodus',
            'activate_mode_comment' => 'W??hlen Sie aus, wie ein Benutzer aktiviert werden soll.',
            'activate_mode_auto' => 'Automatisch',
            'activate_mode_auto_comment' => 'Automatische Aktivierung bei Registrierung.',
            'activate_mode_user' => 'Benutzer',
            'activate_mode_user_comment' => 'Der Benutzer aktiviert seinen eigenes Konto per E-Mail.',
            'activate_mode_admin' => 'Administrator',
            'activate_mode_admin_comment' => 'Nur ein Administrator kann einen Benutzer aktivieren.',
            'require_activation' => 'Anmeldung ben??tigt Aktivierung',
            'require_activation_comment' => 'Benutzer m??ssen zum Einloggen ein aktiviertes Konto besitzen.',
            'default_country' => 'Standort-Voreinstellung',
            'default_country_comment' => 'Wenn ein Benutzer keinen Standort angibt, wird dieser Standort als Standard gew??hlt.',
            'default_state' => 'Provinz-Voreinstellung',
            'default_state_comment' => 'Wenn ein Benutzer keinen Standort angibt, wird diese Provinz als Standard gew??hlt.',
            'use_throttle' => 'Anmeldeversuche begrenzen',
            'use_throttle_comment' => 'Bei wiederholten Anmelde-Fehlversuchen wird der Benutzer tempor??r gesperrt.',
            'login_attribute' => 'Anmelde-Attribut-Zuordnung',
            'login_attribute_comment' => 'W??hlen Sie, welches Benutzerattribut zum Anmelden verwendet werden soll.',
            'registration_tab' => 'Registrierungen',
            'notifications_tab' => 'Benachrichtigungen',
            'allow_registration' => 'Benutzerregistrierung erlauben',
            'allow_registration_comment' => 'Falls dies deaktivert ist, k??nnen Benutzer nur von Administratoren erstellt werden.',
            'send_mail_to_user' => 'E-Mail an Eigent??mer senden',
            'send_mail_to_user_comment' => 'Sendet eine E-Mail mit den Login-Informationen an die E-Mail-Adresse des Eigent??mers, sobald dieser im Fewo-Verwalter freigeschlatet oder die Login-Daten ge??ndert wurden.',
        ],
        'state' => [
            'label' => 'Provinz',
            'name' => 'Name',
            'name_comment' => 'Anzeigenamen f??r diese Provinz eingeben.',
            'code' => 'Code',
            'code_comment' => 'Eindeutigen Code f??r diese Provinz eingeben.',
        ],
        'country' => [
            'label' => 'Land',
            'name' => 'Name',
            'code' => 'Code',
            'code_comment' => 'Eindeutigen Code f??r dieses Land eingeben.',
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
            'account' => 'Eigent??merkonto',
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
            'invalid_activation_code' => 'Ung??ltiger Aktivierungscode ??bermittelt',
            'invalid_user' => 'Es wurde kein Benutzer mit diesen Zugangsdaten gefunden.',
            'login_first' => 'Sie m??ssen sich erst einloggen!',
            'sign_in' => 'Anmelden',
            'register' => 'Registrieren',
            'full_name' => 'Name',
            'email' => 'E-Mail',
            'password' => 'Passwort',
            'login' => 'Anmelden',
            'new_password' => 'Neues Passwort',
            'new_password_confirm' => 'Neues Passwort best??tigen',
            'invalid_deactivation_pass' => 'Das eingegebene Passwort war ung??ltig.',
            'success_deactivation' => 'Konto erfolgreich deaktiviert. Schade, dass du gehst!',
            'registration_disabled' => 'Registrierungen sind momentan deaktiviert.',
        ],
        'session' => [
            'session' => 'Session',
            'session_desc' => 'F??gt Benutzer-Session zu Seite hinzu und kann Zugriff einschr??nken.',
            'security_title' => 'Erlauben',
            'security_desc' => 'Wer hat Zugriff auf die Seite?',
            'allowed_groups_title' => 'Gruppen erlauben',
            'allowed_groups_description' => 'Benutzergruppen die zugreifen d??rfen',
            'all' => 'Jeder',
            'users' => 'Eigent??mer',
            'guests' => 'G??ste',
            'redirect_title' => 'Weiterleiten nach',
            'redirect_desc' => 'Seitenname zum Weiterleiten bei verweigertem Zugriff.',
            'logout' => 'Sie haben sich erfolgreich ausgeloggt!',
        ],
        'daten' => [
            'daten' => 'Owner data',
            'daten_desc' => 'Represents calculations, operations and services',
        ],
    ]
];