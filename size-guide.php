<?php
/**
 * Size Guide Shortcodes
 */

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
// Solo in modo manuale, del tipo attributo nuovo e nuovo gildan_hoodie, per ognuna
function register_size_guide_shortcodes() {
    add_shortcode('size_guide_gildan_hoodie', 'custom_size_guide_hoodie_gildan');
    add_shortcode('size_guide_jhk', 'custom_size_guide_hoodie_jhk');
    add_shortcode('size_guide_tshirts', 'custom_size_guide_tshirts');
}
add_action('init', 'register_size_guide_shortcodes');

/**
 * Display Size Guide Based on Product Attribute
 */
add_filter('woocommerce_product_tabs', 'add_size_guide_tab');
function add_size_guide_tab($tabs) {
    global $product;
    
    // Method 1: Check for global attribute
    $guide_id = $product->get_attribute('size_guide'); // Use slug here
    
    // Method 2: Fallback to custom attribute (old method)
    if (empty($guide_id)) {
        $attributes = $product->get_attributes();
        if (isset($attributes['size_guide_id'])) {
            $guide_id = $attributes['size_guide_id']->get_options()[0];
        }
    }
    
    // Clean the ID
    $guide_id = sanitize_title($guide_id);
    error_log('Detected size guide: ' . $guide_id); // Debug
    
    if (!empty($guide_id)) {
        $shortcode = "size_guide_{$guide_id}";
        
        if (shortcode_exists($shortcode)) {
            $tabs['size_guide'] = array(
                'title'    => 'Size Guide',
                'priority' => 50,
                'callback' => function() use ($shortcode) {
                    echo do_shortcode("[$shortcode]");
                }
            );
        }
    }
    
    return $tabs;
}


// END OF THE PHP
?>
