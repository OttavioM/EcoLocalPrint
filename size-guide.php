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

// Creando un attributo size_guide_id in WP e mettendolo nelle felpe e magliette
// della gildan in automatico la sua taglia e cosi con le altre, questo pero deve
// avere un altro attributo che si chiami brand
function dynamic_size_guide_shortcode() {
    global $product;
    
    ob_start();
    
    // Get the brand attribute
    $brand = $product->get_attribute('pa_brand'); // 'pa_' prefix for WooCommerce attributes
    
    // Check the brand and display the appropriate size guide
    if (stripos($brand, 'gildan') !== false) {
        add_shortcode('size_guide_gildan_hoodie', 'custom_size_guide_hoodie_gildan');
    } elseif (stripos($brand, 'jhk') !== false) {
        echo custom_size_guide_hoodie_jhk();
    } else {
        // Default size guide if no specific brand is matched
        echo custom_size_guide_tshirts();
    }
    
    return ob_get_clean();
}
add_shortcode('dynamic_size_guide', 'dynamic_size_guide_shortcode');
add_action('init', 'dynamic_size_guide_shortcode');