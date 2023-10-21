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
© ECO LOCAL PRINT<?php echo get_bloginfo('name' ) . ' ' . get_the_date( 'Y' ); ?>
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
			<h2>Your Cart Is Currently Empty!</h2>
			<p> Looks like you have not made your choice yet. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
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

// END OF THE PHP
?>