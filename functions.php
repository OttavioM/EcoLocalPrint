<?php
add_action('wp_enqueue_scripts', 'add_child_theme_style');
function add_child_theme_style() {
wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}
// your code goes right below this

function ecolocal_scripts() {
	wp_enqueue_style( 'boostrap-icons', "https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css");

	// Popper and Bootstrap JavaScript
	wp_enqueue_script( 'bootstrap-script', 'https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js', array('jquery'));
	wp_enqueue_script( 'bootstrap-popper', 'https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js', array('jquery'));
	// User defined JavaScript
	wp_enqueue_script( 'boostrap-script', get_template_directory_uri() .'/js/script.js', array('jquery'));
    // You can find the current URL for the latest version here: https://fontawesome.com/start
    wp_enqueue_style( 'font-awesome-free', '//use.fontawesome.com/releases/v6.7.2/css/all.css' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ecolocal_scripts' );

add_action( 'init', 'custom_remove_footer_credit', 10 );
function custom_remove_footer_credit () {
    remove_action( 'storefront_footer', 'storefront_credit', 20 );
    add_action( 'storefront_footer', 'custom_storefront_credit', 20 );
}

function custom_storefront_credit() {
?>
<div class=”site-info”>
© ECO LOCAL PRINT<?php echo get_bloginfo('name' ) . ' ' . '2022-'.date( 'Y' ); ?>
</div><!– .site-info –>
<?php
}

?>

<?php
add_filter( 'woocommerce_cart_item_removed_title', 'removed_from_cart_title', 12, 2);
function removed_from_cart_title( $message, $cart_item ) {
    $product = wc_get_product( $cart_item['product_id'] );

    if( $product )
        $message = sprintf( __('"%s" has been'), $product->get_name() );

    return $message;
}

add_filter('gettext', 'cart_undo_translation', 35, 3 );
function cart_undo_translation( $translation, $text, $domain ) {

    if( $text === 'Undo?' ) {
        $translation =  __( 'Undo', $domain );
    }
    return $translation;
}
?>

<?php

// empty woocommerce cart text personalized
function ds_custom_wc_empty_cart_text()
{
   echo '<div class="cart-empty">
		<div class="empty-cart-header">';
    woocommerce_breadcrumb();
   echo '</div>
        <div class = "empty-cart-icon-div">
            <p align="center" class="empty-cart-icon"><i class="bi bi-cart"></i></p>
        </div>
		<div class="empty-cart">
			<h2>👕Naked cart alert! </h2>
            <h3> Time to dress it up with some cool fashion. </h3>
			<p> Did you know? Every purchase helps restore habitats  <i class="fa-solid fa-otter"></i>.</p>
            <p> Your cart is waiting to do some good! </p>
		</div>
	</div>';
}
remove_action( 'woocommerce_cart_is_empty', 'wc_empty_cart_message', 10 );
add_filter('woocommerce_cart_is_empty', 'ds_custom_wc_empty_cart_text', 20 );


/**ADDING SHORTCODES */

// $time_zone = getTimeZoneFromIpAddress();
// echo 'Your Time Zone is '.$time_zone;

// take the timezone from the ip of the user
// I also use geoplugin api
function getTimeZoneFromIpAddress(){
    $clientsIpAddress = get_client_ip();

    $clientInformation = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$clientsIpAddress));

    $clientsLatitude = $clientInformation['geoplugin_latitude'];
    $clientsLongitude = $clientInformation['geoplugin_longitude'];
    $clientsCountryCode = $clientInformation['geoplugin_countryCode'];

    $timeZone = get_nearest_timezone($clientsLatitude, $clientsLongitude, $clientsCountryCode) ;

    return $timeZone;

}

// take the ip client from the pc or the server
function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

// get the timezone of the user from ip and lon lat to then greet the user the correct hour
function get_nearest_timezone($cur_lat, $cur_long, $country_code = '') {
    $timezone_ids = ($country_code) ? DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $country_code)
        : DateTimeZone::listIdentifiers();

    if($timezone_ids && is_array($timezone_ids) && isset($timezone_ids[0])) {

        $time_zone = '';
        $tz_distance = 0;

        //only one identifier?
        if (count($timezone_ids) == 1) {
            $time_zone = $timezone_ids[0];
        } else {

            foreach($timezone_ids as $timezone_id) {
                $timezone = new DateTimeZone($timezone_id);
                $location = $timezone->getLocation();
                $tz_lat   = $location['latitude'];
                $tz_long  = $location['longitude'];

                $theta    = $cur_long - $tz_long;
                $distance = (sin(deg2rad($cur_lat)) * sin(deg2rad($tz_lat)))
                    + (cos(deg2rad($cur_lat)) * cos(deg2rad($tz_lat)) * cos(deg2rad($theta)));
                $distance = acos($distance);
                $distance = abs(rad2deg($distance));
                // echo '<br />'.$timezone_id.' '.$distance;

                if (!$time_zone || $tz_distance > $distance) {
                    $time_zone   = $timezone_id;
                    $tz_distance = $distance;
                }

            }
        }
        return  $time_zone;
    }
    return 'unknown';
}

// greetings to the user
function greet_user( $atts ) {
    // Extract the shortcode attributes
    extract( shortcode_atts( array(
        'name' => 'Guest',
    ), $atts ) );
    
    $user = wp_get_current_user();
    if ( ! is_user_logged_in() ) {
        $name = 'Guest';
    } else {
        $name = $user->display_name;
    }

    $time_zone = getTimeZoneFromIpAddress();

    // change timezone
    date_default_timezone_set($time_zone);

    // Get the current hour in 24-hour format
    $current_hour = date('G');

    // TODO: Add greeting in variuos languages
    // ita, esp, port, french, german at least

    // Set the greeting message based on the current hour
    if ( $current_hour >= 5 && $current_hour < 12 ) {
        $greeting = 'Good morning';
    } elseif ( $current_hour >= 12 && $current_hour < 18 ) {
        $greeting = 'Good afternoon';
	} elseif ( $current_hour >= 23 || $current_hour < 5 ) {
        $greeting = 'Good night';
	} elseif ( $current_hour >= 18 && $current_hour < 23 ) {
        $greeting = 'Good evening';
    } else {
        $greeting = 'Hellooo';
    }

    // Output the greeting message
    $output = '<span class="greeting-message">' . $greeting  . ' <span style="color:darkolivegreen;font-weight:bold;">, ' .  $name . '</span>!</span>';

    // Apply custom CSS styles
    $output .= '<style>';
    $output .= '.greeting-message { color: ' . $atts['color'] . '; font-size: ' . $atts['font_size'] . '; display: flex; justify-content:center; }';
    $output .= '</style>';

    return $output;
}
add_shortcode( 'greet_user', 'greet_user' );

function my_custom_scripts() {
    //DEFEATED
    // wp_enqueue_script( 'carousel_hommepage_products', get_stylesheet_directory_uri() . '/js/carousel_hommepage_products.js', array( 'jquery' ),'',true );
}
add_action( 'wp_enqueue_scripts', 'my_custom_scripts' );

// HIDE WIDGET IN NOT WOOCOMMERCE PAGES
// IT SHOULD HAVE BE WITH WIDGET AREA, BUT I DO NOT KNOW
function display_widget_on_woocommerce_pages() {
    if (is_woocommerce()) {
       // Get the current page's URL
       $current_page_url = home_url(add_query_arg(array(), $wp->request));

       // Output the URL to the JavaScript console
    //    echo '<script>console.log("Current Page URL: ' . esc_url($current_page_url) . '");</script>';
    } else {
        echo '<style>.header-widget-region .widget { display: none; }</style>';
    }
}
add_action('wp_head', 'display_widget_on_woocommerce_pages');

// Customize search plugin to search wider in tags also
function storefront_product_search() {
    if ( function_exists('storefront_is_woocommerce_activated') && storefront_is_woocommerce_activated() ) { 
        ?>
        <div class="site-search">
            <?php the_widget( 'WC_Widget_Product_Search', 'title=' ); ?>
        </div>
        <?php 
    }
}

// Function to modify the search query to include product tags
function custom_product_search_include_tags( $query ) {
    if ( ! is_admin() && $query->is_search() && $query->is_main_query() && isset($_GET['s']) && isset($_GET['post_type']) && 'product' === $_GET['post_type'] ) {
        
        // Join term_relationships and term_taxonomy to include product tags
        add_filter( 'posts_join', function( $join ) {
            global $wpdb;
            return $join . " LEFT JOIN {$wpdb->term_relationships} tr ON tr.object_id = {$wpdb->posts}.ID
                             LEFT JOIN {$wpdb->term_taxonomy} tt ON tt.term_taxonomy_id = tr.term_taxonomy_id
                             LEFT JOIN {$wpdb->terms} t ON t.term_id = tt.term_id";
        });

        // Modify the search query to include product tags in the search
        add_filter( 'posts_where', function( $where ) {
            global $wpdb;

            // Ensure the search term is safe for SQL
            $search_term = esc_sql( like_escape( $_GET['s'] ) );

            // Extend the search query to include products with matching tags
            $where .= $wpdb->prepare(" OR (tt.taxonomy = %s AND t.name LIKE %s)", 'product_tag', '%' . $search_term . '%');

            return $where;
        });
    }
}
add_action( 'pre_get_posts', 'custom_product_search_include_tags' );

// LOAD THE SIZE GUIDE
// Load size guide functions
// 
// Gildan Hoodie
function custom_size_guide_hoodie_gildan() {
    ob_start(); ?>
    <div id="hoodies-gildan" class="size-guide-content active" style="overflow-x: auto;">
        <h2>Hoodies Gildan Size Guide</h2>
        <div class="container-gildan">
            <img src="https://ecolocalprint.com/wp-content/uploads/2025/04/Gildan-Hoodie-18500-size-guide.png">
        </div>
        <table>
            <thead>
                <tr>
                    <th></th>
                    <th>S</th>
                    <th>M</th>
                    <th>L</th>
                    <th>XL</th>
                    <th>2XL</th>
                    <th>3XL</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th colspan="7">
                        CENTIMETERS
                    </th>
                </tr>
                <tr>
                    <td><strong>A) Length (cm)</strong></td>
                    <td>69</td>
                    <td>71</td>
                    <td>74</td>
                    <td>76</td>
                    <td>79</td>
                    <td>81</td>
                </tr>
                <tr>
                    <td><strong>B) Chest Width (cm)</strong></td>
                    <td>51</td>
                    <td>56</td>
                    <td>61</td>
                    <td>66</td>
                    <td>71</td>
                    <td>76</td>
                </tr>
                <tr>
                    <td><strong>C) Sleeve Length (cm)</strong></td>
                    <td>85</td>
                    <td>88</td>
                    <td>90</td>
                    <td>93</td>
                    <td>95</td>
                    <td>98</td>
                </tr>
                <tr>
                    <th colspan="7">
                        INCHES
                    </th>
                </tr>
                <tr>
                    <td><strong>A) Length (inches)</strong></td>
                    <td>27 ⅙</td>
                    <td>27 ⅞</td>
                    <td>29 ⅛</td>
                    <td>29 ⅞</td>
                    <td>31 ⅑</td>
                    <td>31 ⅞</td>
                </tr>
                <tr>
                    <td><strong>B) Chest Width (inches)</strong></td>
                    <td>20</td>
                    <td>22</td>
                    <td>24</td>
                    <td>25 ⅞</td>
                    <td>27 ⅞</td>
                    <td>29 ⅞</td>
                </tr>
                <tr>
                    <td><strong>C) Sleeve Length (inches)</strong></td>
                    <td>33 ⅜</td>
                    <td>34 ⅝</td>
                    <td>35 ⅖</td>
                    <td>36 ⅝</td>
                    <td>37 ⅖</td>
                    <td>38 ½</td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php
    return ob_get_clean();
}

// JHK Hoodie
function custom_size_guide_hoodie_jhk() {
    ob_start(); ?>
    <div id="hoodies-jhk" class="size-guide-content">
        <h2>Hoodies JHK Size Guide</h2>
        <!-- Insert JHK table HTML here -->
    </div>
    <?php
    return ob_get_clean();
}

// T-Shirts
function custom_size_guide_tshirts() {
    ob_start(); ?>
    <div id="tshirts" class="size-guide-content">
        <h2>T-Shirts Size Guide</h2>
        <!-- Insert T-Shirt table HTML here -->
    </div>
    <?php
    return ob_get_clean();
}

// Register all shortcodes
function register_size_guide_shortcodes() {
    add_shortcode('size_guide_gildan', 'custom_size_guide_hoodie_gildan');
    add_shortcode('size_guide_jhk', 'custom_size_guide_hoodie_jhk');
    add_shortcode('size_guide_tshirts', 'custom_size_guide_tshirts');
}
add_action('init', 'register_size_guide_shortcodes');
// END OF THE PHP
?>
