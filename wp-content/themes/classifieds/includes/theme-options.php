<?php
/**
 * ReduxFramework Sample Config File
 * For full documentation, please visit: https://docs.reduxframework.com
 * */

global $classifieds_opts;

if (!class_exists('Classifieds_Options')) {

    class Classifieds_Options
    {

        public $args = array();
        public $sections = array();
        public $theme;
        public $ReduxFramework;

        public function __construct()
        {

            if (!class_exists('ReduxFramework')) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if (true == Redux_Helpers::isTheme(__FILE__)) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array(
                    $this,
                    'initSettings'
                ), 10);
            }

        }

        public function initSettings()
        {

            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            // If Redux is running as a plugin, this will remove the demo notice and links
            //add_action( 'redux/loaded', array( $this, 'remove_demo' ) );

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo()
        {

            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(
                    ReduxFrameworkPlugin::instance(),
                    'plugin_metalinks'
                ), null, 2);

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(
                    ReduxFrameworkPlugin::instance(),
                    'admin_notices'
                ));
            }
        }

        public function setSections()
        {

            /**
             * Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns      = array();

            if (is_dir($sample_patterns_path)):
                if ($sample_patterns_dir = opendir($sample_patterns_path)):
                    $sample_patterns = array();
                    while (($sample_patterns_file = readdir($sample_patterns_dir)) !== false) {

                        if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                            $name              = explode('.', $sample_patterns_file);
                            $name              = str_replace('.' . end($name), '', $sample_patterns_file);
                            $sample_patterns[] = array(
                                'alt' => $name,
                                'img' => $sample_patterns_url . $sample_patterns_file
                            );
                        }
                    }
                endif;
            endif;

            /////////////////////////////////////////////////////////////////////////////// 1. OVERALL //

            $this->sections[] = array(
                'title' => esc_html__('Overall Setup', 'classifieds'),
                'desc' => esc_html__('Here in overall setup section you can edit basic settings related to overall website.', 'classifieds'),
                'icon' => 'el-icon-cogs',
                'indent' => true,
                'fields' => array(

                )
            );

            // Logo //
            $this->sections[] = array(
                'title' => esc_html__('Logo', 'classifieds'),
                'desc' => esc_html__('Upload logo for website.', 'classifieds'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(

                    array(
                        'id' => 'site_logo',
                        'type' => 'media',
                        'title' => esc_html__('Site Logo', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Upload site logo.', 'classifieds')
                    ),
                    array(
                        'id' => 'site_logo_padding',
                        'type' => 'text',
                        'title' => esc_html__('Logo Padding', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Set padding for logo if needed ( set 0 if not ).', 'classifieds')
                    )


                )
            );

            // Navigation //
            $this->sections[] = array(
                'title' => esc_html__('Navigation', 'classifieds'),
                'desc' => esc_html__('Set up basic things for navigation.', 'classifieds'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(

                    array(
                        'id' => 'site_navigation_padding',
                        'type' => 'text',
                        'title' => esc_html__('Navigation Padding', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Set padding for navigation as needed ( leave 0 if not ).', 'classifieds')
                    ),

                    array(
                        'id' => 'enable_sticky',
                        'type' => 'select',
                        'title' => esc_html__( 'Enable Sticky Navigation', 'classifieds' ),
                        'compiler' => 'true',
                        'options' => array(
                            'yes' => esc_html__( 'Yes', 'classifieds' ),
                            'no' => esc_html__( 'No', 'classifieds' ),
                        ),
                        'desc' => esc_html__( 'Show or hide sticky navigation.', 'classifieds' ),
                        'std' => 'no'
                    ),
                    array(
                        'id' => 'my_profile_looks',
                        'type' => 'text',
                        'title' => esc_html__('"My Profile" link', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Input text or HTML icon for the My Profile link.', 'classifieds'),
                        'default' => esc_html__( 'My Profile', 'classifieds' )
                    ),
                    array(
                        'id' => 'login_looks',
                        'type' => 'text',
                        'title' => esc_html__('"Login" link', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Input text or HTML icon for the Login link.', 'classifieds'),
                        'default' => esc_html__( 'Login', 'classifieds' )
                    ),
                )
            );

            // Direction //
            $this->sections[] = array(
                'title' => esc_html__('Content Direction', 'classifieds'),
                'desc' => esc_html__('Choose overall website text direction which can be RTL (right to left) or LTR (left to right).', 'classifieds'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(
                    array(
                        'id' => 'direction',
                        'type' => 'select',
                        'options' => array(
                            'ltr' => esc_html__('LTR', 'classifieds'),
                            'rtl' => esc_html__('RTL', 'classifieds')
                        ),
                        'title' => esc_html__('Site Content Direction', 'classifieds'),
                        'desc' => esc_html__('Choose overall website text direction which can be RTL (right to left) or LTR (left to right).', 'classifieds'),
                        'default' => 'ltr'
                    )

                )
            );

            // Theme Usage //
            $this->sections[] = array(
                'title' => esc_html__('Permalinks', 'classifieds'),
                'desc' => esc_html__('Translate permalinks.', 'classifieds'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(
                    array(
                        'id' => 'trans_ad',
                        'type' => 'text',
                        'title' => esc_html__('Ad Slug', 'classifieds'),
                        'desc' => esc_html__('Input custom slug for ads.', 'classifieds'),
                        'default' => 'ad'
                    ),
                    array(
                        'id' => 'trans_ad_category',
                        'type' => 'text',
                        'title' => esc_html__('Ad Category Slug', 'classifieds'),
                        'desc' => esc_html__('Input custom slug for ad category.', 'classifieds'),
                        'default' => 'ad-category'
                    ),
                    array(
                        'id' => 'trans_ad_tag',
                        'type' => 'text',
                        'title' => esc_html__('Ad Tag Slug', 'classifieds'),
                        'desc' => esc_html__('Input custom slug for ad tag.', 'classifieds'),
                        'default' => 'ad-tag'
                    ),                    
                    array(
                        'id' => 'trans_category',
                        'type' => 'text',
                        'title' => esc_html__('Category Slug ( Search )', 'classifieds'),
                        'desc' => esc_html__('Input custom slug for search by category.', 'classifieds'),
                        'default' => 'category'
                    ),
                    array(
                        'id' => 'trans_tag',
                        'type' => 'text',
                        'title' => esc_html__('Tag Slug ( Search )', 'classifieds'),
                        'desc' => esc_html__('Input custom slug for search by tag.', 'classifieds'),
                        'default' => 'tag'
                    ),                    
                    array(
                        'id' => 'trans_keyword',
                        'type' => 'text',
                        'title' => esc_html__('Keyword Slug ( Search )', 'classifieds'),
                        'desc' => esc_html__('Input custom slug for search by keyword.', 'classifieds'),
                        'default' => 'keyword'
                    ),
                    array(
                        'id' => 'trans_location',
                        'type' => 'text',
                        'title' => esc_html__('Location Slug ( Search )', 'classifieds'),
                        'desc' => esc_html__('Input custom slug for search by location.', 'classifieds'),
                        'default' => 'location'
                    ),
                    array(
                        'id' => 'trans_longitude',
                        'type' => 'text',
                        'title' => esc_html__('Longitude Slug ( Search )', 'classifieds'),
                        'desc' => esc_html__('Input custom slug for search by longitude.', 'classifieds'),
                        'default' => 'longitude'
                    ),
                    array(
                        'id' => 'trans_latitude',
                        'type' => 'text',
                        'title' => esc_html__('Latitude Slug ( Search )', 'classifieds'),
                        'desc' => esc_html__('Input custom slug for search by latitude.', 'classifieds'),
                        'default' => 'latitude'
                    ),
                    array(
                        'id' => 'trans_radius',
                        'type' => 'text',
                        'title' => esc_html__('Radius Slug ( Search )', 'classifieds'),
                        'desc' => esc_html__('Input custom slug for search by radius.', 'classifieds'),
                        'default' => 'radius'
                    ),
                    array(
                        'id' => 'trans_view',
                        'type' => 'text',
                        'title' => esc_html__('View Slug ( Search )', 'classifieds'),
                        'desc' => esc_html__('Input custom slug for display as grid or list.', 'classifieds'),
                        'default' => 'view'
                    ),
                    array(
                        'id' => 'trans_sortby',
                        'type' => 'text',
                        'title' => esc_html__('Sort By Slug ( Search )', 'classifieds'),
                        'desc' => esc_html__('Input custom slug for sorting on search', 'classifieds'),
                        'default' => 'sortby'
                    ),
                    array(
                        'id' => 'trans_subpage',
                        'type' => 'text',
                        'title' => esc_html__('Subpage Slug ( Profile )', 'classifieds'),
                        'desc' => esc_html__('Input custom slug for subpage on profile pages', 'classifieds'),
                        'default' => 'subpage'
                    ),
                )
            );

            // Search Bar //
            $this->sections[] = array(
                'title' => esc_html__('Search Bar', 'classifieds'),
                'desc' => esc_html__('Select search bar options.', 'classifieds'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(

                    array(
                        'id' => 'restrict_country',
                        'type' => 'text',
                        'title' => esc_html__('Autocomplete Country Restriction', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Input country ISO CODE (you can find it on this address: countrycode.org) to limit google auto complete to those places only. Google do not allow more than one country limitation at the moment.', 'classifieds'),
                        'default' => ''
                    ),

                    array(
                        'id' => 'show_search_bar',
                        'type' => 'select',
                        'title' => esc_html__('Enable Search Bar', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Show or hide search bar.', 'classifieds'),
                        'options' => array(
                            'yes' => esc_html__( 'Yes', 'classifieds' ),
                            'no' => esc_html__( 'No', 'classifieds' )
                        ),
                        'default' => 'no'
                    ),

                    array(
                        'id' => 'radius_search_units',
                        'type' => 'select',
                        'title' => esc_html__('Radius Search Units', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Select radius units.', 'classifieds'),
                        'options' => array(
                            'km' => esc_html__( 'Kilometers ( km )', 'classifieds' ),
                            'mi' => esc_html__( 'Miles ( mi )', 'classifieds' )
                        ),
                        'default' => 'km'
                    ),  

                    array(
                        'id' => 'radius_default',
                        'type' => 'text',
                        'title' => esc_html__('Radius Search Deafult', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Input value for the default radius ( number only ) if none is selected.', 'classifieds'),
                        'default' => '300'
                    ),

                    array(
                        'id' => 'radius_options',
                        'type' => 'textarea',
                        'title' => esc_html__('Radius Options', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Input possible values for the radius ( one per row ).', 'classifieds'),
                        'default' => ''
                    ),                    
                )
            );

            $this->sections[] = array(
                'title' => esc_html__('Map', 'classifieds'),
                'desc' => esc_html__('Select map options.', 'classifieds'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(
                    array(
                        'id' => 'empty_search_location',
                        'type' => 'text',
                        'title' => esc_html__('Google Map Default Location', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Input latitude and longitude for the google map when there is no results ( form LATITUDE,LONGITUDE ). You can find them on latlong.net.', 'classifieds'),
                    ),
                )
            );            

            // Mega Menu //
            $this->sections[] = array(
                'title' => esc_html__('Mega Menu', 'classifieds'),
                'desc' => esc_html__('Set up mega menu.', 'classifieds'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(

                    array(
                        'id' => 'mega_menu_sidebars',
                        'type' => 'text',
                        'title' => esc_html__('Mega Menu Sidebars', 'classifieds'),
                        'desc' => esc_html__('Input number of mega menu sidebars you wish to use.', 'classifieds'),
                        'default' => '5'
                    ),
                    array(
                        'id' => 'mega_menu_min_height',
                        'type' => 'text',
                        'title' => esc_html__('Mega Menu Minimum Height', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Input minimum height of the mega menu based on the content you are adding to it.', 'classifieds')
                    )

                )
            );

            /* CLIENTS */
            $this->sections[] = array(
                'title' => esc_html__('Clients', 'classifieds'),
                'desc' => esc_html__('Clients settings', 'classifieds'),
                'icon' => '',
                'fields' => array(
                    array(
                        'id' => 'show_clients',
                        'type' => 'select',
                        'title' => esc_html__('Show Clients', 'classifieds'),
                        'desc' => esc_html__('Enable or disable clients section.', 'classifieds'),
                        'options' => array(
                            'yes' => esc_html__('Yes', 'classifieds'),
                            'no' => esc_html__('No', 'classifieds')
                        ),
                        'default' => 'no'
                    ),
                )
            ); 

            /* COPYRIGHTS */
            $this->sections[] = array(
                'title' => esc_html__('Copyrights', 'classifieds'),
                'desc' => esc_html__('Copyrights settings', 'classifieds'),
                'icon' => '',
                'fields' => array(
                    array(
                        'id' => 'footer_copyrights',
                        'type' => 'text',
                        'title' => esc_html__('Copyrights', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Input copyrights.', 'classifieds')
                    ),                  
                )
            ); 

            /* NEWSLETTER */                   
            $this->sections[] = array(
                'title' => esc_html__('Newsletter', 'classifieds'),
                'desc' => esc_html__('Newsletter settings', 'classifieds'),
                'icon' => '',
                'fields' => array(
                    array(
                        'id' => 'show_subscribe',
                        'type' => 'select',
                        'title' => esc_html__('Show Subscribe Bar', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Show subscribe section in the footer.', 'classifieds'),
                        'options' => array(
                            'yes' => esc_html__('Yes', 'classifieds'),
                            'no' => esc_html__('No', 'classifieds')
                        ),
                        'default' => 'no'
                    ),
                    array(
                        'id' => 'footer_subscribe_text',
                        'type' => 'text',
                        'title' => esc_html__('Subscribe Title', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Input subscribe title.', 'classifieds')
                    ),
                    array(
                        'id' => 'footer_subscribe_subtext',
                        'type' => 'text',
                        'title' => esc_html__('Subscribe Subtitle', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Input subscribe subtitle.', 'classifieds')
                    ),                    
                )
            );

            // WooCommerce //
            $this->sections[] = array(
                'title' => esc_html__('WooCommerce', 'classifieds'),
                'desc' => esc_html__('Set up basic things for woocommerce.', 'classifieds'),
                'icon' => '',
                'fields' => array(

                    array(
                        'id' => 'show_woocommerce_sidebar',
                        'type' => 'select',
                        'options' => array(
                            'yes' => esc_html__( 'Yes', 'classifieds' ),
                            'no' => esc_html__( 'No', 'classifieds' )
                        ),
                        'title' => esc_html__('WooCommerce Sidebar', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Enable or disable woocommerce sidebar.', 'classifieds'),
                        'default' => 'yes'
                    ),
                    array(
                        'id' => 'products_per_page',
                        'type' => 'text',
                        'title' => esc_html__('Products Per Page', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Input number of products you wish to show per page.', 'classifieds'),
                        'default' => '9'
                    ),                    

                )
            );


            // PAGES //
            $this->sections[] = array(
                'title' => esc_html__('Pages', 'classifieds'),
                'desc' => esc_html__('Setup contact page details here.', 'classifieds'),
                'icon' => '',
                'fields' => array(
                     
                )
            );
            // Contact Details //
            $this->sections[] = array(
                'title' => esc_html__('Contact Page', 'classifieds'),
                'desc' => esc_html__('Setup contact page details here.', 'classifieds'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(

                    array(
                        'id' => 'contact_mail',
                        'type' => 'text',
                        'title' => esc_html__('Mail', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Input email where sent messages will arrive.', 'classifieds')
                    ),
                    array(
                        'id' => 'contact_form_subject',
                        'type' => 'text',
                        'title' => esc_html__('Mail Subject', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Input subject for the message.', 'classifieds')
                    ),
                    array(
                        'id' => 'contact_map',
                        'type' => 'multi_text',
                        'title' => esc_html__('Google Map Markers', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Input longitudes and latitudes separated by comma for example (format LONGITUDE,LATITUDE). <You can find them at latlong.net.', 'classifieds')
                    ),
                    array(
                        'id' => 'contact_map_scroll_zoom',
                        'type' => 'select',
                        'title' => esc_html__('Disable Scroll Zoom', 'classifieds'),
                        'compiler' => 'true',
                        'options' => array(
                            'no' => esc_html__('No', 'classifieds'),
                            'yes' => esc_html__('Yes', 'classifieds')
                        ),
                        'desc' => esc_html__('Enable or disable zoom on scroll of the contact map.', 'classifieds'),
                        'default' => 'no'
                    ),
                    array(
                        'id' => 'contact_map_zoom',
                        'type' => 'text',
                        'title' => esc_html__('Google Map Zoom', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Set map zoom ( 0 - 19 ).', 'classifieds'),
                        'default' => '5'
                    ),                      

                )
            );

            // All Categories Page //
            $this->sections[] = array(
                'title' => esc_html__('All Categories', 'classifieds'),
                'desc' => esc_html__('Set options for the all categories page.', 'classifieds'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(
                    array(
                        'id' => 'all_categories_sortby',
                        'type' => 'select',
                        'options' => array(
                            'name' => esc_html__( 'Name', 'classifieds' ),
                            'count' => esc_html__( 'Count', 'classifieds' ),
                            'slug' => esc_html__( 'Slug', 'classifieds' ),
                        ),
                        'title' => esc_html__('Sort By', 'classifieds'),
                        'desc' => esc_html__('Select field by which to sort the all categories listing.', 'classifieds'),
                        'default' => 'name'
                    ),
                    array(
                        'id' => 'all_categories_sort',
                        'type' => 'select',
                        'options' => array(
                            'desc' => esc_html__( 'Descending', 'classifieds' ),
                            'asc' => esc_html__( 'Ascending', 'classifieds' ),
                        ),
                        'title' => esc_html__('Sort Order', 'classifieds'),
                        'desc' => esc_html__('Select sort order for the all categories page.', 'classifieds'),
                        'default' => 'asc'
                    ),
                    array(
                        'id' => 'all_categories_count',
                        'type' => 'select',
                        'options' => array(
                            'no' => esc_html__( 'No', 'classifieds' ),
                            'yes' => esc_html__( 'Yes', 'classifieds' ),
                        ),
                        'title' => esc_html__('Show Count', 'classifieds'),
                        'desc' => esc_html__('Show or hide count of ads per category.', 'classifieds'),
                        'default' => 'no'
                    ),
                )
            );

            // Home Page //
            $this->sections[] = array(
                'title' => esc_html__('Home Page', 'classifieds'),
                'desc' => esc_html__('Set options for the home page.', 'classifieds'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(
                    array(
                        'id' => 'show_map_on_home',
                        'type' => 'select',
                        'title' => esc_html__('Enable Map On Home', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Show or hide map on home page.', 'classifieds'),
                        'options' => array(
                            'yes' => esc_html__( 'Yes', 'classifieds' ),
                            'no' => esc_html__( 'No', 'classifieds' )
                        ),
                        'default' => 'no'
                    ),
                    array(
                        'id' => 'home_map_cache',
                        'type' => 'select',
                        'title' => esc_html__('Enable Home Map Cache', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Enable or disable caching of the markers for the home page map.', 'classifieds'),
                        'options' => array(
                            'yes' => esc_html__( 'Yes', 'classifieds' ),
                            'no' => esc_html__( 'No', 'classifieds' )
                        ),
                        'default' => 'yes'
                    ),
                    array(
                        'id' => 'home_map_cache_interval',
                        'type' => 'text',
                        'title' => esc_html__('Home Map Cache Interval', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Input caching interval in hours.', 'classifieds'),
                        'default' => '3'
                    ),                    
                    array(
                        'id' => 'home_map_ads',
                        'type' => 'text',
                        'title' => esc_html__('Home Page Markers', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Input number of markers to show on home page or leave empty to display them all.', 'classifieds'),
                    ),
                    array(
                        'id' => 'home_map_show_price',
                        'type' => 'select',
                        'title' => esc_html__('Show Price On Map', 'classifieds'),
                        'compiler' => 'true',
                        'options' => array(
                            'yes' => esc_html__( 'Yes', 'classifieds' ),
                            'no' => esc_html__( 'No', 'classifieds' ),
                        ),
                        'desc' => esc_html__('Show or hide price information on info window of the marker.', 'classifieds'),
                        'default' => 'yes'
                    ),                    
                    array(
                        'id' => 'home_map_ads_source',
                        'type' => 'select',
                        'title' => esc_html__('Home Page Markers Source', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Select source of the markers to be displayed on the home map.', 'classifieds'),
                        'options' => array(
                            'all' => esc_html__( 'All', 'classifieds' ),
                            'yes' => esc_html__( 'Featured', 'classifieds' ),
                            'no' => esc_html__( 'Not Featured', 'classifieds' ),
                        ),
                        'default' => 'all'
                    ),                    
                    array(
                        'id' => 'home_map_zoom',
                        'type' => 'text',
                        'title' => esc_html__('Google Map Zoom', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Set map zoom ( 0 - 19 ).', 'classifieds'),
                        'default' => ''
                    ),
                    array(
                        'id' => 'home_map_geolocation',
                        'type' => 'select',
                        'title' => esc_html__('Home Page Geo Location', 'classifieds'),
                        'compiler' => 'true',
                        'options' => array(
                            'no' => esc_html__( 'No', 'classifieds' ),
                            'yes' => esc_html__( 'Yes', 'classifieds' ),
                        ),
                        'desc' => esc_html__('On landing to home set map to users location.', 'classifieds'),
                        'default' => 'no'
                    ),
                    array(
                        'id' => 'home_map_geo_zoom',
                        'type' => 'text',
                        'title' => esc_html__('Home Page Geo Location Zoom', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Set zoom level of the geolocation.', 'classifieds'),
                        'default' => '6'
                    ),
                    array(
                        'id' => 'home_slider',
                        'type' => 'text',
                        'title' => esc_html__('Slider Shortcode', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Input slider shortcode which will be displayed instead of map.', 'classifieds'),
                        'default' => ''
                    ),
                )
            );

            /////////////////////////////////////////////////////////////////////////////////// 8. OFFERS //
            $this->sections[] = array(
                'title' => esc_html__('Ads', 'classifieds'),
                'desc' => esc_html__('Ads setup.', 'classifieds'),
                'icon' => '',
                'fields' => array(
                    array(
                        'id' => 'ads_per_page',
                        'type' => 'text',
                        'title' => esc_html__('Ads Per Page', 'classifieds'),
                        'desc' => esc_html__('Input how many ads to show per page.', 'classifieds'),
                        'default' => '12'
                    ),                 
                    array(
                        'id' => 'author_ads_per_page',
                        'type' => 'text',
                        'title' => esc_html__('Author Ads Per Page', 'classifieds'),
                        'desc' => esc_html__('Input how many ads to show on author profile page for all users.', 'classifieds'),
                        'default' => '12'
                    ),
                    array(
                        'id' => 'author_profile_ads_per_page',
                        'type' => 'text',
                        'title' => esc_html__('Author Profile Ads Per Page', 'classifieds'),
                        'desc' => esc_html__('Input how many ads to show on author profile page for user.', 'classifieds'),
                        'default' => '12'
                    ),                    
                    array(
                        'id' => 'ads_for_verified',
                        'type' => 'text',
                        'title' => esc_html__('Ads For Verified', 'classifieds'),
                        'desc' => esc_html__('Input how many ads to have in order to be verified.', 'classifieds'),
                        'default' => '10'
                    ),
                    array(
                        'id' => 'similar_ads',
                        'type' => 'text',
                        'title' => esc_html__('Similar Ads', 'classifieds'),
                        'desc' => esc_html__('Input how many similar ads to show on ad single. Leave empty to disable.', 'classifieds'),
                        'default' => '2'
                    ),
                    array(
                        'id' => 'ads_default_view',
                        'type' => 'select',
                        'title' => esc_html__('Ads Default Listing', 'classifieds'),
                        'desc' => esc_html__('Select default layout of the ad boxes for the search page and author listing.', 'classifieds'),
                        'options' => array(
                            'grid' => esc_html__( 'Grid', 'classifieds' ),
                            'list' => esc_html__( 'List', 'classifieds' ),
                        ),
                        'default' => 'grid'
                    ),
                    array(
                        'id' => 'video_image',
                        'type' => 'media',
                        'title' => esc_html__('Video Placeholder', 'classifieds'),
                        'desc' => esc_html__('Select which image to use as video placeholder on ad single.', 'classifieds'),
                    ),
                    array(
                        'id' => 'ads_search_layout',
                        'type' => 'select',
                        'title' => esc_html__('Ads Search Layout', 'classifieds'),
                        'desc' => esc_html__('Select layout of the search page.', 'classifieds'),
                        'options' => array(
                            'style-top' => esc_html__( 'Top Map', 'classifieds' ),
                            'style-left' => esc_html__( 'Left Map', 'classifieds' ),
                        ),
                        'default' => 'style-top'
                    ),
                    array(
                        'id' => 'ads_advanced_search',
                        'type' => 'select',
                        'title' => esc_html__('Ads Advanced Search', 'classifieds'),
                        'desc' => esc_html__('Enable or disable advanced search.', 'classifieds'),
                        'options' => array(
                            'yes' => esc_html__( 'Yes', 'classifieds' ),
                            'no' => esc_html__( 'No', 'classifieds' ),
                        ),
                        'default' => 'yes'
                    ),                    
                    array(
                        'id' => 'ads_max_videos',
                        'type' => 'text',
                        'title' => esc_html__('Ads Videos', 'classifieds'),
                        'desc' => esc_html__('Input how many videos can user add on submit ad.', 'classifieds'),
                        'default' => '10'
                    ),
                    array(
                        'id' => 'ads_max_images',
                        'type' => 'text',
                        'title' => esc_html__('Ads Images', 'classifieds'),
                        'desc' => esc_html__('Input how many images can user add on submit ad.', 'classifieds'),
                        'default' => '10'
                    ),
                    array(
                        'id' => 'image_placeholder',
                        'type' => 'media',
                        'title' => esc_html__('Image Placeholder', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Upload image for the palcehodler if no featured iamge is assigned to the ad.', 'classifieds')
                    ),
                    array(
                        'id' => 'single_ad_side_position',
                        'type' => 'select',
                        'title' => esc_html__('Single Ad Sidebar Position', 'classifieds'),
                        'options' => array(
                            'pos-1' => esc_html__( 'Before "Posted By" Block', 'classifieds' ),
                            'pos-2' => esc_html__( 'Before "On Map" Block', 'classifieds' ),
                            'pos-3' => esc_html__( 'Before "Similar Ads" Block', 'classifieds' ),
                            'pos-4' => esc_html__( 'After All', 'classifieds' ),
                        ),
                        'compiler' => 'true',
                        'desc' => esc_html__('Select position of the single ad sidebar.', 'classifieds'),
                        'default' => 'pos-4'
                    ), 
                )
            );

            // Terms //
            $this->sections[] = array(
                'title' => esc_html__('Terms', 'classifieds'),
                'desc' => esc_html__('Show terms and conditions on submit page.', 'classifieds'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(

                    array(
                        'id' => 'ad_terms',
                        'type' => 'editor',
                        'title' => esc_html__('Terms & Conditions', 'classifieds'),
                        'desc' => esc_html__('Input terms and conditions which users must accept in order to submit offer or leave empty to disable.', 'classifieds'),
                        'default' => ''
                    )

                )
            );

            // Listing //
            $this->sections[] = array(
                'title' => esc_html__('Pricing', 'classifieds'),
                'desc' => esc_html__('Setup pricings.', 'classifieds'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(

                    array(
                        'id' => 'basic_ad_price',
                        'type' => 'text',
                        'title' => esc_html__('Basic Ad Price', 'classifieds'),
                        'desc' => esc_html__('Input price of the basic ad as number only and dot (.) as decimal separator if needed.', 'classifieds'),
                        'default' => '0'
                    ),

                    array(
                        'id' => 'basic_ad_title',
                        'type' => 'text',
                        'title' => esc_html__('Basic Ad Title', 'classifieds'),
                        'desc' => esc_html__('Input title for the pricing table for the basic ad.', 'classifieds'),
                        'default' => ''
                    ),

                    array(
                        'id' => 'basic_ad_subtitle',
                        'type' => 'text',
                        'title' => esc_html__('Basic Ad Subitle', 'classifieds'),
                        'desc' => esc_html__('Input subtitle for the pricing table for the basic ad.', 'classifieds'),
                        'default' => ''
                    ),                    

                    array(
                        'id' => 'featured_ad_price',
                        'type' => 'text',
                        'title' => esc_html__('Featured Ad Price', 'classifieds'),
                        'desc' => esc_html__('Input price of the featured ad as number only and dot (.) as decimal separator if needed.', 'classifieds'),
                        'default' => '5'
                    ),

                    array(
                        'id' => 'featured_ad_title',
                        'type' => 'text',
                        'title' => esc_html__('Featured Ad Title', 'classifieds'),
                        'desc' => esc_html__('Input title for the pricing table for the featured ad.', 'classifieds'),
                        'default' => ''
                    ),

                    array(
                        'id' => 'featured_ad_subtitle',
                        'type' => 'text',
                        'title' => esc_html__('Featured Ad Subtitle', 'classifieds'),
                        'desc' => esc_html__('Input subtitle for the pricing table for the featured ad.', 'classifieds'),
                        'default' => ''
                    ),

                    array(
                        'id' => 'ad_lasts_for',
                        'type' => 'text',
                        'title' => esc_html__('How Many Days Ad Lasts?', 'classifieds'),
                        'desc' => esc_html__('Input how many days to display ads.', 'classifieds'),
                        'default' => '30'
                    ),                    
                )
            );

            ///////////////////////////////////////////////////////////////////////////////////////// 9. MESSAGING //



            $this->sections[] = array(
                'title' => esc_html__('Emails', 'classifieds'),
                'desc' => esc_html__('Interaction trough emails settings.', 'classifieds'),
                'icon' => '',
                'fields' => array(
                    array(
                        'id' => 'email_sender',
                        'type' => 'text',
                        'title' => esc_html__('Email Of Sender', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Input email address you wish to show on the email messages.', 'classifieds')
                    ),
                    array(
                        'id' => 'name_sender',
                        'type' => 'text',
                        'title' => esc_html__('Name Of Sender', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Input name you wish to show on the email messages.', 'classifieds')
                    )
                )
            );
            // Ad Submission //
            $this->sections[] = array(
                'title' => esc_html__('Ads', 'classifieds'),
                'desc' => esc_html__('Ad messaging basic settings.', 'classifieds'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(

                    array(
                        'id' => 'new_offer_email',
                        'type' => 'text',
                        'title' => esc_html__('New Ad Email', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Input email address on which information about new submission will arrive.', 'classifieds')
                    ),
                    array(
                        'id' => 'ad_messaging',
                        'type' => 'select',
                        'options' => array(
                            'yes' => esc_html__( 'Yes', 'classifieds' ),
                            'no' => esc_html__( 'No', 'classifieds' ),
                        ),
                        'title' => esc_html__('Send Ad Messages', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Enable or disable sending messages on aprove/decline ads.', 'classifieds'),
                        'default' => 'yes'
                    ),
                    array(
                        'id' => 'ad_approve_message',
                        'type' => 'textarea',
                        'title' => esc_html__('Ad Approve Message', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Input ad approve message message which will be sent to the users once the ad is approved ( use %AD_NAME% where you wish to place ad name and %AD_LINK% where you wish to place the link to the ad ).', 'classifieds')
                    ),
                    array(
                        'id' => 'ad_decline_message',
                        'type' => 'textarea',
                        'title' => esc_html__('Ad Decline Message', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Input ad appdeclinerove message message which will be sent to the users once the ad is approved ( use %AD_NAME% where you wish to place ad name ).', 'classifieds')
                    ),

                )
            );                    
            // Registration //
            $this->sections[] = array(
                'title' => esc_html__('Registration', 'classifieds'),
                'desc' => esc_html__('Registration basic settings setup.', 'classifieds'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(

                    array(
                        'id' => 'registration_message',
                        'type' => 'textarea',
                        'title' => esc_html__('Registration Message', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Input registration message which will be sent to the users to verify their email address. Put %LINK% in the place you want to show confirmation link.', 'classifieds')
                    ),
                    array(
                        'id' => 'registration_subject',
                        'type' => 'text',
                        'title' => esc_html__('Registration Message Subject', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Input registration message subject.', 'classifieds')
                    ),
                )
            );


            // Lost Password //
            $this->sections[] = array(
                'title' => esc_html__('Lost Password', 'classifieds'),
                'desc' => esc_html__('Lost password basic settings setup.', 'classifieds'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(

                    array(
                        'id' => 'lost_password_message',
                        'type' => 'textarea',
                        'title' => esc_html__('Lost Password Message', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Input lost password message which will be sent to the users to change their password. Put %PASSWORD% in the place you want to show new password and put %USERNAME% where to place username.', 'classifieds')
                    ),
                    array(
                        'id' => 'lost_password_subject',
                        'type' => 'text',
                        'title' => esc_html__('Lost Password Message Subject', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Input lost password message subject.', 'classifieds')
                    ),
                )
            );

            // Ad Submission //
            $this->sections[] = array(
                'title' => esc_html__('Ads Expired', 'classifieds'),
                'desc' => esc_html__('Ad expired reminder mail.', 'classifieds'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(

                    array(
                        'id' => 'send_expire_notice',
                        'type' => 'select',
                        'options' => array(
                            'yes' => esc_html__( 'Yes', 'classifieds' ),
                            'no' => esc_html__( 'No', 'classifieds' ),
                        ),
                        'title' => esc_html__('Send Expire Reminder Emails?', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Enable or disable sending messages when ads have been expired ( This is done once daily ).', 'classifieds'),
                        'default' => 'yes'
                    ),
                    array(
                        'id' => 'expire_template',
                        'type' => 'textarea',
                        'title' => esc_html__('Ad Expire Message', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Input ad approve message message which will be sent to the users once the ad is expired ( use %USERNAME% to place user username, %AD_NAME% where you wish to place ad name ).', 'classifieds')
                    ),
                    array(
                        'id' => 'ad_expire_subject',
                        'type' => 'text',
                        'title' => esc_html__('Ad Expire Message Subject', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Input ad expire message subject.', 'classifieds')
                    ),                    
                )
            ); 

            ///////////////////////////////////////////////////////////////////////////////////////// 10. API //



            $this->sections[] = array(
                'title' => esc_html__('Payments API', 'classifieds'),
                'desc' => esc_html__('Setup external API needed for different website services.', 'classifieds'),
                'icon' => '',
                'fields' => array(
                    array(
                        'id' => 'unit',
                        'type' => 'text',
                        'title' => esc_html__('Main Currency Unit', 'classifieds'),
                        'desc' => esc_html__('Input main currency unit. ($, £, €, руб).', 'classifieds')
                    ),
                    array(
                        'id' => 'main_unit_abbr',
                        'type' => 'text',
                        'title' => esc_html__('Main Currency Unit Abbreviation', 'classifieds'),
                        'desc' => esc_html__('Input main currency unit abbreviation.  (USD, EUR, RUB, AUD, GBP...).', 'classifieds')
                    ),
                    array(
                        'id' => 'unit_position',
                        'title' => esc_html__('Unit Position', 'classifieds'),
                        'desc' => esc_html__('Select position of the unit.', 'classifieds'),
                        'type' => 'select',
                        'options' => array(
                            'front' => esc_html__('Front', 'classifieds'),
                            'back' => esc_html__('Back', 'classifieds')
                        )
                    ),
                )
            );

            // PayPal API //
            $this->sections[] = array(
                'title' => esc_html__('PayPal', 'classifieds'),
                'desc' => esc_html__('Important PayPal Settings.', 'classifieds'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(

                    array(
                        'id' => 'paypal_mode',
                        'type' => 'select',
                        'title' => esc_html__('PayPal Mode', 'classifieds'),
                        'compiler' => 'true',
                        'options' => array(
                            '' => esc_html__('Live mode', 'classifieds'),
                            '.sandbox' => esc_html__('Testing mode', 'classifieds')
                        ),
                        'desc' => esc_html__('Select mode for the PayPal.', 'classifieds')
                    ),
                    array(
                        'id' => 'paypal_username',
                        'type' => 'text',
                        'title' => esc_html__('Paypal API Username', 'classifieds'),
                        'desc' => esc_html__('Input paypal API username here.', 'classifieds')
                    ),
                    array(
                        'id' => 'paypal_password',
                        'type' => 'text',
                        'title' => esc_html__('Paypal API Password', 'classifieds'),
                        'desc' => esc_html__('Input paypal API password here.', 'classifieds')
                    ),
                    array(
                        'id' => 'paypal_signature',
                        'type' => 'text',
                        'title' => esc_html__('Paypal API Signature', 'classifieds'),
                        'desc' => esc_html__('Input paypal API signature here.', 'classifieds')
                    )

                )
            );

            // Stripe API //
            $this->sections[] = array(
                'title' => esc_html__('Stripe', 'classifieds'),
                'desc' => esc_html__('Important Stripe Settings.', 'classifieds'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(
                    array(
                        'id' => 'stripe_pk_client_id',
                        'type' => 'text',
                        'title' => esc_html__('Public Client ID', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Input your stripe public client ID.', 'classifieds')
                    ),
                    array(
                        'id' => 'stripe_sk_client_id',
                        'type' => 'text',
                        'title' => esc_html__('Secret Client ID', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Input your stripe secret client ID.', 'classifieds')
                    ),

                )
            );

            // Skrill API //
            $this->sections[] = array(
                'title' => esc_html__('Skrill', 'classifieds'),
                'desc' => esc_html__('Important Skrill Settings.', 'classifieds'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(
                    array(
                        'id' => 'skrill_owner_mail',
                        'type' => 'text',
                        'title' => esc_html__('You skrill mail', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Input your email which is connected with your skrill account.', 'classifieds')
                    ),
                    array(
                        'id' => 'skrill_secret_word',
                        'type' => 'text',
                        'title' => esc_html__('You skrill secret word', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Input your scrill secret word.', 'classifieds')
                    ),                  
                )
            );

            // BANK TRANSFER //
            $this->sections[] = array(
                'title' => esc_html__('Bank', 'classifieds'),
                'desc' => esc_html__('Important Bank Transfer Settings.', 'classifieds'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(
                    array(
                        'id' => 'bank_account_name',
                        'type' => 'text',
                        'title' => esc_html__('Bank Account Name', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Input your bank account name.', 'classifieds')
                    ),                    
                    array(
                        'id' => 'bank_name',
                        'type' => 'text',
                        'title' => esc_html__('Bank Name', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Input your bank name.', 'classifieds')
                    ),
                    array(
                        'id' => 'bank_account_number',
                        'type' => 'text',
                        'title' => esc_html__('Bank Account Number', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Input your bank account number.', 'classifieds')
                    ),
                    array(
                        'id' => 'bank_sort_number',
                        'type' => 'text',
                        'title' => esc_html__('Sort Number', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Input your sort number.', 'classifieds')
                    ),
                    array(
                        'id' => 'bank_iban_number',
                        'type' => 'text',
                        'title' => esc_html__('IBAN Code', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Input your IBAN code.', 'classifieds')
                    ),
                    array(
                        'id' => 'bank_bic_swift_number',
                        'type' => 'text',
                        'title' => esc_html__('BIC / Swift Code', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Input your BIC / Swift code.', 'classifieds')
                    ),                    
                )
            );

            // MOLLIE //
            $this->sections[] = array(
                'title' => esc_html__('iDEAL', 'classifieds'),
                'desc' => esc_html__('Important Mollie iDEAL Settings.', 'classifieds'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(
                    array(
                        'id' => 'mollie_id',
                        'type' => 'text',
                        'title' => esc_html__('Mollie ID', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Input your mollie ID.', 'classifieds')
                    ),
                array(
                    'id' => 'ideal_mode',
                    'type' => 'select',
                    'title' => esc_html__('iDEAL Mode', 'couponxxl'),
                    'compiler' => 'true',
                    'options' => array(
                        'live' => esc_html__( 'Live Mode', 'couponxxl' ),
                        'test' => esc_html__( 'Test Mode', 'couponxxl' )
                    ),
                    'desc' => esc_html__('Select iDEAL mode', 'couponxxl'),
                    'default' => 'live'
                ),
                )
            );

            // PayUMoney API //
            $this->sections[] = array(
                'title' => esc_html__('PayUMoney', 'classifieds'),
                'desc' => esc_html__('Important PayUMoney Settings.', 'classifieds'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(
                    array(
                        'id' => 'payu_merchant_key',
                        'type' => 'text',
                        'title' => esc_html__('Merchant Key', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Input your merchant key to connect to PayUMoney.', 'classifieds')
                    ),
                    array(
                        'id' => 'payu_merchant_salt',
                        'type' => 'text',
                        'title' => esc_html__('Merchant Salt', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Input your merchant salt to connect to PayUMoney.', 'classifieds')
                    ),
                    array(
                        'id' => 'payu_mode',
                        'type' => 'select',
                        'title' => esc_html__('PayUMoney Model', 'classifieds'),
                        'compiler' => 'true',
                        'options' => array(
                            'secure' => esc_html__( 'Live Mode', 'classifieds' ),
                            'test' => esc_html__( 'Test Mode', 'classifieds' )
                        ),
                        'desc' => esc_html__('Select PayUMoney mode.', 'classifieds'),
                        'default' => 'secure'
                    ),                    
                )
            );            

            // Mailchimp API //
            $this->sections[] = array(
                'title' => esc_html__('MailChimp API', 'classifieds'),
                'desc' => esc_html__('Important PayPal Settings.', 'classifieds'),
                'icon' => '',
                'fields' => array(

                    array(
                        'id' => 'mail_chimp_api',
                        'type' => 'text',
                        'title' => esc_html__('Mail Chimp API', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Input API key of your MailChimp. More <a href="http://kb.mailchimp.com/accounts/management/about-api-keys" target="_blank">here</a>.', 'classifieds')
                    ),
                    array(
                        'id' => 'mail_chimp_list_id',
                        'type' => 'text',
                        'title' => esc_html__('Mail Chimp List ID', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Input ID of the ailchimp list on which the users will subscribe. More <a href="http://kb.mailchimp.com/lists/managing-subscribers/find-your-list-id" target="_blank">here</a>.', 'classifieds')
                    )

                )
            );

            // Appearance //
            $this->sections[] = array(
                'title' => esc_html__('Appearance', 'classifieds'),
                'desc' => esc_html__('Set up the looks of the site.', 'classifieds'),
                'icon' => '',
                'fields' => array(

                    array(
                        'id' => 'body_links_color',
                        'type' => 'color',
                        'title' => esc_html__('Body Links Color', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Select color for all links in the body.', 'classifieds'),
                        'transparent' => false,
                        'default' => '#208ee6'
                    ),                  
                    array(
                        'id' => 'theme_font',
                        'type' => 'select',
                        'title' => esc_html__('Theme Font', 'classifieds'),
                        'compiler' => 'true',
                        'options' => classifieds_google_fonts(),
                        'desc' => esc_html__('Select font for the theme.', 'classifieds'),
                        'default' => 'Montserrat'
                    ),
                )
            );

            // HEADER //
            $this->sections[] = array(
                'title' => esc_html__('Header', 'classifieds'),
                'desc' => esc_html__('Change header appearance.', 'classifieds'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(

                    array(
                        'id' => 'header_bg_color',
                        'type' => 'color',
                        'title' => esc_html__('Header Background Color', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Select background color of the header.', 'classifieds'),
                        'transparent' => false,
                        'default' => '#1e3843'
                    ),

                )
            );
            // NAVIGATION //
            $this->sections[] = array(
                'title' => esc_html__('Navigation', 'classifieds'),
                'desc' => esc_html__('Change navigation appearance.', 'classifieds'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(

                    array(
                        'id' => 'navigation_font_color',
                        'type' => 'color',
                        'title' => esc_html__('Navigation Font Color', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Select font color of the navigation.', 'classifieds'),
                        'transparent' => false,
                        'default' => '#fff'
                    ),
                    array(
                        'id' => 'navigation_font_color_hvr',
                        'type' => 'color',
                        'title' => esc_html__('Navigation Active / Hover Font Color', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Select font color of the navigation items on hover / active state.', 'classifieds'),
                        'transparent' => false,
                        'default' => '#7dcffb'
                    ),
                    array(
                        'id' => 'submit_btn_bg_color',
                        'type' => 'color',
                        'title' => esc_html__('Submit Button Background Color', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Select background color of the submit button in the header.', 'classifieds'),
                        'transparent' => false,
                        'default' => '#208ee6'
                    ),
                    array(
                        'id' => 'submit_btn_font_color',
                        'type' => 'color',
                        'title' => esc_html__('Submit Button Font Color', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Select font color of the submit button in the header.', 'classifieds'),
                        'transparent' => false,
                        'default' => '#fff'
                    ),
                    array(
                        'id' => 'submit_btn_bg_color_hvr',
                        'type' => 'color',
                        'title' => esc_html__('Submit Button Background Color On Hover', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Select background color of the submit button on hover in the header.', 'classifieds'),
                        'transparent' => false,
                        'default' => '#177ed0'
                    ),
                    array(
                        'id' => 'submit_btn_font_color_hvr',
                        'type' => 'color',
                        'title' => esc_html__('Submit Button Font Color On Hover', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Select font color of the submit button on hover in the header.', 'classifieds'),
                        'transparent' => false,
                        'default' => '#fff'
                    ),

                )
            );


            // FOOTER //
            $this->sections[] = array(
                'title' => esc_html__('Footer', 'classifieds'),
                'desc' => esc_html__('Change footer appearance.', 'classifieds'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(

                    array(
                        'id' => 'footer_bg_color',
                        'type' => 'color',
                        'title' => esc_html__('Footer Background Color', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Select background color for the footer.', 'classifieds'),
                        'transparent' => false,
                        'default' => '#273642'
                    ), 
                    array(
                        'id' => 'footer_font_color',
                        'type' => 'color',
                        'title' => esc_html__('Footer Font Color', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Select font color for the footer', 'classifieds'),
                        'transparent' => false,
                        'default' => '#fff'
                    ),
                    array(
                        'id' => 'footer_link_color',
                        'type' => 'color',
                        'title' => esc_html__('Footer Link Color', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Select link color for the footer.', 'classifieds'),
                        'transparent' => false,
                        'default' => '#fff'
                    ),
                    array(
                        'id' => 'footer_link_color_hvr',
                        'type' => 'color',
                        'title' => esc_html__('Footer Link On Hover Color', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Select link on hover color for the footer.', 'classifieds'),
                        'transparent' => false,
                        'default' => '#59b453'
                    ),

                )
            );

            // COPYRIGHTS //
            $this->sections[] = array(
                'title' => esc_html__('Copyright', 'classifieds'),
                'desc' => esc_html__('Change copyright appearance.', 'classifieds'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(

                    array(
                        'id' => 'copyright_bg_color',
                        'type' => 'color',
                        'title' => esc_html__('Copyright Background Color', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Select background color for the copyright.', 'classifieds'),
                        'transparent' => false,
                        'default' => '#1d2a34'
                    ), 
                    array(
                        'id' => 'copyright_font_color',
                        'type' => 'color',
                        'title' => esc_html__('Copyright Font Color', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Select font color for the copyright.', 'classifieds'),
                        'transparent' => false,
                        'default' => '#49535b'
                    ),
                    array(
                        'id' => 'copyright_link_color',
                        'type' => 'color',
                        'title' => esc_html__('Copyright Link Color', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Select link color for the copyright.', 'classifieds'),
                        'transparent' => false,
                        'default' => '#fff'
                    ),
                    array(
                        'id' => 'copyright_link_color_hvr',
                        'type' => 'color',
                        'title' => esc_html__('Copyright Link On Hover Color', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Select link on hover color for the copyright.', 'classifieds'),
                        'transparent' => false,
                        'default' => '#59b453'
                    ),

                )
            );

            // BUTTONS //
            $this->sections[] = array(
                'title' => esc_html__('Buttons', 'classifieds'),
                'desc' => esc_html__('Change buttons appearance.', 'classifieds'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(

                    array(
                        'id' => 'btn1_bg_color',
                        'type' => 'color',
                        'title' => esc_html__('Button 1 Background Color', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Select background color for the button 1 ( initially green one ).', 'classifieds'),
                        'transparent' => false,
                        'default' => '#59b453'
                    ),
                    array(
                        'id' => 'btn1_font_color',
                        'type' => 'color',
                        'title' => esc_html__('Button 1 Font Color', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Select font color for the button 1 ( initially green one ).', 'classifieds'),
                        'transparent' => false,
                        'default' => '#fff'
                    ),
                    array(
                        'id' => 'btn1_bg_color_hvr',
                        'type' => 'color',
                        'title' => esc_html__('Button 1 Background Color On Hover', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Select background color on hover for the button 1 ( initially green one ).', 'classifieds'),
                        'transparent' => false,
                        'default' => '#4ca247'
                    ),
                    array(
                        'id' => 'btn1_font_color_hvr',
                        'type' => 'color',
                        'title' => esc_html__('Button 1 Font Color On Hover', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Select font color on hover for the button 1 ( initially green one ).', 'classifieds'),
                        'transparent' => false,
                        'default' => '#fff'
                    ),
                    array(
                        'id' => 'btn2_bg_color',
                        'type' => 'color',
                        'title' => esc_html__('Button 2 Background Color', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Select background color for the button 2 ( initially blue one ).', 'classifieds'),
                        'transparent' => false,
                        'default' => '#208ee6'
                    ),
                    array(
                        'id' => 'btn2_font_color',
                        'type' => 'color',
                        'title' => esc_html__('Button 2 Font Color', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Select font color for the button 2 ( initially blue one ).', 'classifieds'),
                        'transparent' => false,
                        'default' => '#fff'
                    ),
                    array(
                        'id' => 'btn2_bg_color_hvr',
                        'type' => 'color',
                        'title' => esc_html__('Button 2 Background Color On Hover', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Select background color on hover for the button 2 ( initially blue one ).', 'classifieds'),
                        'transparent' => false,
                        'default' => '#177ed0'
                    ),
                    array(
                        'id' => 'btn2_font_color_hvr',
                        'type' => 'color',
                        'title' => esc_html__('Button 2 Font Color On Hover', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Select font color on hover for the button 2 ( initially blue one ).', 'classifieds'),
                        'transparent' => false,
                        'default' => '#fff'
                    ),

                )
            );

            // PROFILE //
            $this->sections[] = array(
                'title' => esc_html__('Profile', 'classifieds'),
                'desc' => esc_html__('Change profile appearance.', 'classifieds'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(

                    array(
                        'id' => 'expired_badge_bg_color',
                        'type' => 'color',
                        'title' => esc_html__('Expired Badge Background Color', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Select background color for the expire badge.', 'classifieds'),
                        'transparent' => false,
                        'default' => '#ebb243'
                    ),
                    array(
                        'id' => 'expired_badge_font_color',
                        'type' => 'color',
                        'title' => esc_html__('Expired Badge Font Color', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Select font color for the expire badge.', 'classifieds'),
                        'transparent' => false,
                        'default' => '#fff'
                    ),
                    array(
                        'id' => 'pending_badge_bg_color',
                        'type' => 'color',
                        'title' => esc_html__('Pending Badge Background Color', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Select background color for the pending badge.', 'classifieds'),
                        'transparent' => false,
                        'default' => '#49a3eb'
                    ),
                    array(
                        'id' => 'pending_badge_font_color',
                        'type' => 'color',
                        'title' => esc_html__('Pending Badge Font Color', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Select font color for the pending badge.', 'classifieds'),
                        'transparent' => false,
                        'default' => '#fff'
                    ),
                    array(
                        'id' => 'live_badge_bg_color',
                        'type' => 'color',
                        'title' => esc_html__('Live Badge Background Color', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Select background color for the live badge.', 'classifieds'),
                        'transparent' => false,
                        'default' => '#78c273'
                    ),
                    array(
                        'id' => 'live_badge_font_color',
                        'type' => 'color',
                        'title' => esc_html__('Live Badge Font Color', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Select font color for the live badge.', 'classifieds'),
                        'transparent' => false,
                        'default' => '#fff'
                    ),
                    array(
                        'id' => 'not_paid_badge_bg_color',
                        'type' => 'color',
                        'title' => esc_html__('Not Paid Badge Background Color', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Select background color for the not paid badge.', 'classifieds'),
                        'transparent' => false,
                        'default' => '#f66a45'
                    ),
                    array(
                        'id' => 'not_paid_badge_font_color',
                        'type' => 'color',
                        'title' => esc_html__('Not Paid Badge Font Color', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Select font color for the not paid badge.', 'classifieds'),
                        'transparent' => false,
                        'default' => '#fff'
                    ),
                    array(
                        'id' => 'off_badge_bg_color',
                        'type' => 'color',
                        'title' => esc_html__('Off Badge Background Color', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Select background color for the off badge.', 'classifieds'),
                        'transparent' => false,
                        'default' => '#bbc4cb'
                    ),
                    array(
                        'id' => 'off_badge_font_color',
                        'type' => 'color',
                        'title' => esc_html__('Off Badge Font Color', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Select font color for the off badge.', 'classifieds'),
                        'transparent' => false,
                        'default' => '#fff'
                    ),
                    array(
                        'id' => 'ad_form_btn_bg_color',
                        'type' => 'color',
                        'title' => esc_html__('Ad Form Button Background Color', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Select background color for the live badge.', 'classifieds'),
                        'transparent' => false,
                        'default' => '#7dcffb'
                    ),
                    array(
                        'id' => 'ad_form_btn_font_color',
                        'type' => 'color',
                        'title' => esc_html__('Ad Form Button Font Color', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Select font color for the live badge.', 'classifieds'),
                        'transparent' => false,
                        'default' => '#fff'
                    ),
                    array(
                        'id' => 'ad_form_btn_bg_color_hvr',
                        'type' => 'color',
                        'title' => esc_html__('Ad Form Button Background Color On Hover', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Select background color for the live badge on hover.', 'classifieds'),
                        'transparent' => false,
                        'default' => '#5fc4fa'
                    ),
                    array(
                        'id' => 'ad_form_btn_font_color_hvr',
                        'type' => 'color',
                        'title' => esc_html__('Ad Form Button Font Color On Hover', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Select font color for the live badge on hover.', 'classifieds'),
                        'transparent' => false,
                        'default' => '#fff'
                    ),  

                )
            );

            // COPYRIGHTS //
            $this->sections[] = array(
                'title' => esc_html__('Single Ad', 'classifieds'),
                'desc' => esc_html__('Change single ad appearance.', 'classifieds'),
                'icon' => '',
                'subsection' => true,
                'fields' => array(

                    array(
                        'id' => 'single_ad_price_size',
                        'type' => 'text',
                        'title' => esc_html__('Font Size on Single Ad', 'classifieds'),
                        'compiler' => 'true',
                        'desc' => esc_html__('Set font size for the price information on the single ad page.', 'classifieds'),
                        'default' => '26px'
                    ),  

                )
            );
        }

        /**
         * All the possible arguments for Redux.
         * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
         * */
        public function setArguments()
        {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name' => 'classifieds_options',
                // This is where your data is stored in the database and also becomes your global variable name.
                'display_name' => $theme->get('Name'),
                // Name that appears at the top of your panel
                'display_version' => $theme->get('Version'),
                // Version that appears at the top of your panel
                'menu_type' => 'menu',
                //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu' => true,
                // Show the sections below the admin menu item or not
                'menu_title' => esc_html__('Classifieds', 'redux-framework-demo'),
                'page_title' => esc_html__('Classifieds', 'redux-framework-demo'),
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => '',
                // Set it you want google fonts to update weekly. A google_api_key value is required.
                'google_update_weekly' => false,
                // Must be defined to add google fonts to the typography module
                'async_typography' => true,
                // Use a asynchronous font on the front end or font string
                //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
                'admin_bar' => true,
                // Show the panel pages on the admin bar
                'admin_bar_icon' => 'dashicons-portfolio',
                // Choose an icon for the admin bar menu
                'admin_bar_priority' => 50,
                // Choose an priority for the admin bar menu
                'global_variable' => '',
                // Set a different name for your global variable other than the opt_name
                'dev_mode' => false,
                // Show the time the page took to load, etc
                'update_notice' => true,
                // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
                'customizer' => true,
                // Enable basic customizer support
                //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                // OPTIONAL -> Give you extra features
                'page_priority' => null,
                // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent' => 'themes.php',
                // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions' => 'manage_options',
                // Permissions needed to access the options panel.
                //'menu_icon'            => get_template_directory_uri().'/images/icon.png',
                // Specify a custom URL to an icon
                'last_tab' => '',
                // Force your panel to always open to a specific tab (by id)
                'page_icon' => 'icon-themes',
                // Icon displayed in the admin panel next to your menu_title
                'page_slug' => '_options',
                // Page slug used to denote the panel
                'save_defaults' => true,
                // On load save the defaults to DB before user clicks save or not
                'default_show' => false,
                // If true, shows the default value next to each field that is not the default value.
                'default_mark' => '',
                // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export' => true,
                // Shows the Import/Export panel when not used as a field.

                // CAREFUL -> These options are for advanced use only
                'transient_time' => 60 * MINUTE_IN_SECONDS,
                'output' => true,
                // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag' => true,
                // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database' => '',
                // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info' => false,
                // REMOVE

                // HINTS
                'hints' => array(
                    'icon' => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color' => 'lightgray',
                    'icon_size' => 'normal',
                    'tip_style' => array(
                        'color' => 'light',
                        'shadow' => true,
                        'rounded' => false,
                        'style' => ''
                    ),
                    'tip_position' => array(
                        'my' => 'top left',
                        'at' => 'bottom right'
                    ),
                    'tip_effect' => array(
                        'show' => array(
                            'effect' => 'slide',
                            'duration' => '500',
                            'event' => 'mouseover'
                        ),
                        'hide' => array(
                            'effect' => 'slide',
                            'duration' => '500',
                            'event' => 'click mouseleave'
                        )
                    )
                )
            );


        }

    }

    global $classifieds_opts;
    $classifieds_opts = new Classifieds_Options();
} else {
    echo "The class named Classifieds_Options has already been called. <strong>Developers, you need to prefix this class with your company name or you'll run into problems!</strong>";
}