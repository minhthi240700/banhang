<?php
	// INCLUDES FILE PHP & JS
function flatsome_child_enqueue_scripts() {
	wp_enqueue_script( 'flatsome-child-custom-js', get_stylesheet_directory_uri() . '/js/custom.js', array( 'jquery' ), '1.0', true );
}
foreach ( glob(__DIR__.'/includes/*.php') as $file ){
	include $file;
}
add_action( 'wp_enqueue_scripts', 'flatsome_child_enqueue_scripts', 999 );

// ĐỔI ĐỢN VỊ SANG PX
if ( ! function_exists( 'hiepdesign_mce_text_sizes' ) ) {
	function hiepdesign_mce_text_sizes( $initArray ){
		$initArray['fontsize_formats'] = "9px 10px 12px 13px 14px 15px 16px 17px 18px 19px 20px 21px 22px 23px 24px 26px 28px 30px 32px 34px 36px 40px 42px 44px 46px 48px 50px";
		return $initArray;
	}
	add_filter( 'tiny_mce_before_init', 'hiepdesign_mce_text_sizes', 99 );
}


// CHỈ HIỂN THỊ GIÁ KHUYẾN MÃI
// add_filter( 'woocommerce_get_price_html', 'flatsome_child_product_price_html', 100, 2 );
// function flatsome_child_product_price_html( $price, $product ) {
// 	if ( $product->is_on_sale() && $product->get_regular_price() !== $product->get_price() ) {
// 		$price_html = wc_price( $product->get_price() );
// 	} else {
// 		$price_html = '<span class="woocommerce-Price-amount amount">' . wc_price( $product->get_regular_price() ) . '</span>';
// 	}
// 	return $price_html;
// }

// THAY ĐỔI NỘI DUNG
function my_custom_translations( $strings ) {
    $text = array(
        'Tổng số phụ:' => 'Tổng tiền: ',
		'A link to set a new password will be sent to your email address.' => 'Một liên kết để đặt mật khẩu mới sẽ được gửi đến địa chỉ email của bạn.',
        "PRODUCT NAME" => 'Tên sản phẩm',
        "UNIT PRICE" => 'Giá',
		"Shopping Cart" => 'Giỏ hàng',
		"CHECKOUT DETAILS" => 'Thanh toán',
		"ORDER COMPLETE" => 'Hoàn tất',
    );
    $strings = str_ireplace( array_keys( $text ), $text, $strings );
    return $strings;
}
add_filter( 'gettext', 'my_custom_translations', 20 );


// RÚT GỌN ĐƯỜNG DẪN
add_filter('term_link', 'devvn_no_term_parents', 1000, 3);
function devvn_no_term_parents($url, $term, $taxonomy) {
	if($taxonomy == 'product_cat'){
		$term_nicename = $term->slug;
		$url = trailingslashit(get_option( 'home' )) . user_trailingslashit( $term_nicename, 'category' );
	}
	return $url;
}
// Add our custom product cat rewrite rules
function devvn_no_product_cat_parents_rewrite_rules($flash = false) {
	$terms = get_terms( array(
		'taxonomy' => 'product_cat',
		'post_type' => 'product',
		'hide_empty' => false,
	));
	if($terms && !is_wp_error($terms)){
		foreach ($terms as $term){
			$term_slug = $term->slug;
			add_rewrite_rule($term_slug.'/?$', 'index.php?product_cat='.$term_slug,'top');
			add_rewrite_rule($term_slug.'/page/([0-9]{1,})/?$', 'index.php?product_cat='.$term_slug.'&paged=$matches[1]','top');
			add_rewrite_rule($term_slug.'/(?:feed/)?(feed|rdf|rss|rss2|atom)/?$', 'index.php?product_cat='.$term_slug.'&feed=$matches[1]','top');
		}
	}
	if ($flash == true)
		flush_rewrite_rules(false);
}
add_action('init', 'devvn_no_product_cat_parents_rewrite_rules');
/*Sửa lỗi khi tạo mới taxomony bị 404*/
add_action( 'create_term', 'devvn_new_product_cat_edit_success', 10);
add_action( 'edit_terms', 'devvn_new_product_cat_edit_success', 10);
add_action( 'delete_term', 'devvn_new_product_cat_edit_success', 10);
function devvn_new_product_cat_edit_success( ) {
	devvn_no_product_cat_parents_rewrite_rules(true);
}


/*
* Code Bỏ /product/ hoặc /cua-hang/ hoặc /shop/ ... có hỗ trợ dạng %product_cat%
* Thay /cua-hang/ bằng slug hiện tại của bạn
*/
function devvn_remove_slug( $post_link, $post ) {
	if ( !in_array( get_post_type($post), array( 'product' ) ) || 'publish' != $post->post_status ) {
		return $post_link;
	}
	if('product' == $post->post_type){
		$post_link = str_replace( '/san-pham/', '/', $post_link ); //Thay cua-hang bằng slug hiện tại của bạn
	}else{
		$post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );
	}
	return $post_link;
}
add_filter( 'post_type_link', 'devvn_remove_slug', 10, 2 );
/*Sửa lỗi 404 sau khi đã remove slug product hoặc cua-hang*/
function devvn_woo_product_rewrite_rules($flash = false) {
	global $wp_post_types, $wpdb;
	$siteLink = esc_url(home_url('/'));
	foreach ($wp_post_types as $type=>$custom_post) {
		if($type == 'product'){
			if ($custom_post->_builtin == false) {
				$querystr = "SELECT {$wpdb->posts}.post_name, {$wpdb->posts}.ID
                            FROM {$wpdb->posts} 
                            WHERE {$wpdb->posts}.post_status = 'publish'
AND {$wpdb->posts}.post_type = '{$type}'";
				$posts = $wpdb->get_results($querystr, OBJECT);
				foreach ($posts as $post) {
					$current_slug = get_permalink($post->ID);
					$base_product = str_replace($siteLink,'',$current_slug);
					add_rewrite_rule($base_product.'?$', "index.php?{$custom_post->query_var}={$post->post_name}", 'top');
					add_rewrite_rule($base_product.'comment-page-([0-9]{1,})/?$', 'index.php?'.$custom_post->query_var.'='.$post->post_name.'&cpage=$matches[1]', 'top');
					add_rewrite_rule($base_product.'(?:feed/)?(feed|rdf|rss|rss2|atom)/?$', 'index.php?'.$custom_post->query_var.'='.$post->post_name.'&feed=$matches[1]','top');
				}
			}
		}
	}
	if ($flash == true)
		flush_rewrite_rules(false);
}
add_action('init', 'devvn_woo_product_rewrite_rules');
/*Fix lỗi khi tạo sản phẩm mới bị 404*/
function devvn_woo_new_product_post_save($post_id){
	global $wp_post_types;
	$post_type = get_post_type($post_id);
	foreach ($wp_post_types as $type=>$custom_post) {
		if ($custom_post->_builtin == false && $type == $post_type) {
			devvn_woo_product_rewrite_rules(true);
		}
	}
}
add_action('wp_insert_post', 'devvn_woo_new_product_post_save');


// THÊM CHỮ SỐ LƯỢNG
// add_action( 'woocommerce_before_add_to_cart_quantity', 'text_before_quantity' );
// function text_before_quantity() {
//     echo '<div class="qty-text">Số lượng: </div>';
// }

// XÓA TAB THÔNG TIN
function kenthan_remove_product_tabs( $tabs ) {
    unset( $tabs['additional_information'] );
    return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'kenthan_remove_product_tabs', 98 );

// ĐỔI TÊN TAB
add_filter( 'woocommerce_product_tabs', 'woo_rename_tabs', 98 );
function woo_rename_tabs( $tabs ) {
	$tabs['description']['title'] = __( 'Thông tin sản phẩm' );		// Rename the description tab
	return $tabs;
}

// XÓA TRƯỜNG THANH TOÁN
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
function custom_override_checkout_fields( $fields ) {
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_country']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_email']);
    unset($fields['billing']['billing_email']);
    unset($fields['billing']['billing_city']);
	unset($fields['billing']['billing_last_name']);
    return $fields;
}

// ĐẶT ĐIỀU KIỆN CHO TRƯỜNG THANH TOÁN
add_action('woocommerce_checkout_process', 'custom_checkout_field_validation');
function custom_validate_billing_phone() {
    $billing_phone = $_POST['billing_phone'];
    $billing_last_name = $_POST['billing_last_name'];
    $billing_address_1 = $_POST['billing_address_1'];

    $phone_digits = preg_replace('/[^0-9]/', '', $billing_phone);

    // Kiểm tra số điện thoại phải có đúng 10 chữ số và đầu số hợp lệ
    $valid_phone_prefixes = array('03', '05', '07', '08', '09');
    $billing_phone_prefix = substr($phone_digits, 0, 2);
    if (strlen($phone_digits) !== 10 || !in_array($billing_phone_prefix, $valid_phone_prefixes)) {
        wc_add_notice('Số điện thoại không hợp lệ.', 'error');
    }

    // Kiểm tra billing_last_name có tối thiểu 3 ký tự và không có ký tự đặc biệt
    if (strlen($billing_last_name) < 3 || preg_match('/[^a-zA-Z0-9]/', $billing_last_name)) {
        wc_add_notice('Họ phải tối thiểu 3 ký tự và không chứa ký tự đặc biệt.', 'error');
    }

    // Kiểm tra billing_address_1 phải có ít nhất 3 ký tự, trong đó có ít nhất 1 chữ và 1 số
    if (strlen($billing_address_1) < 3 || !preg_match('/[a-zA-Z]/', $billing_address_1) || !preg_match('/[0-9]/', $billing_address_1)) {
        wc_add_notice('Địa chỉ phải tối thiểu 3 ký tự và phải chứa ít nhất 1 chữ và 1 số.', 'error');
    }
}
add_action('woocommerce_checkout_process', 'custom_validate_billing_phone');

// tHAY ĐỔI STEP LỌC GIÁ
add_filter('woocommerce_price_filter_widget_step', 'devvn_woocommerce_price_filter_widget_step');
function devvn_woocommerce_price_filter_widget_step(){
    return 10000;
}

// ĐỔI VỊ TRÍ GIÁ GỐC VÀ SALE
add_filter( 'woocommerce_format_sale_price', 'invert_formatted_sale_price', 10, 3 );
function invert_formatted_sale_price( $price, $regular_price, $sale_price ) {
    return '<ins>' . ( is_numeric( $sale_price ) ? wc_price( $sale_price ) : $sale_price ) . '</ins> <del>' . ( is_numeric( $regular_price ) ? wc_price( $regular_price ) : $regular_price ) . '</del>';
}

// THÊM THƯƠNG HIỆU
function tb_product_brand_taxonomy() {

    $labels = array(
        'name'                       => _x( 'Thương hiệu', 'Taxonomy General Name', 'tb_product_brand' ),
        'singular_name'              => _x( 'Product Brand', 'Taxonomy Singular Name', 'tb_product_brand' ),
        'menu_name'                  => __( 'Thương hiệu', 'tb_product_brand' ),
        'all_items'                  => __( 'Tất cả thương hiệu', 'tb_product_brand' ),
        'parent_item'                => __( 'Parent Brand', 'tb_product_brand' ),
        'parent_item_colon'          => __( 'Parent Brand:', 'tb_product_brand' ),
        'new_item_name'              => __( 'New Item Brand', 'tb_product_brand' ),
        'add_new_item'               => __( 'Add New Brand', 'tb_product_brand' ),
        'edit_item'                  => __( 'Edit Brand', 'tb_product_brand' ),
        'update_item'                => __( 'Update Brand', 'tb_product_brand' ),
        'view_item'                  => __( 'View Brand', 'tb_product_brand' ),
        'separate_items_with_commas' => __( 'Separate brands with commas', 'tb_product_brand' ),
        'add_or_remove_items'        => __( 'Add or remove brands', 'tb_product_brand' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'tb_product_brand' ),
        'popular_items'              => __( 'Popular Brands', 'tb_product_brand' ),
        'search_items'               => __( 'Search Brand', 'tb_product_brand' ),
        'not_found'                  => __( 'Not Found', 'tb_product_brand' ),
        'no_terms'                   => __( 'No brands', 'tb_product_brand' ),
        'items_list'                 => __( 'Brandlist', 'tb_product_brand' ),
        'items_list_navigation'      => __( 'Brand list navigation', 'tb_product_brand' ),
    );
    $rewrite = array(
        'slug'                       => 'brand',
        'with_front'                 => true,
        'hierarchical'               => true,
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'rewrite'                    => $rewrite,
        'show_in_rest'               => true,
    );
    register_taxonomy( 'tb_product_brand', array( 'product' ), $args );

}
add_action( 'init', 'tb_product_brand_taxonomy', 0 );

// HIỂN THỊ THƯƠNG HIỆU, SKU

function custom_show_brand_sku() {
    global $product;
    // Lấy tên thương hiệu
    // Lấy ID của sản phẩm hiện tại
    $product_id = get_the_ID();

    // Lấy danh sách các thương hiệu của sản phẩm
    $brands = get_the_terms($product_id, 'tb_product_brand');

    // Khai báo biến để lưu tên thương hiệu và SKU
    $brand_name = '';
    $sku = '';

    // Kiểm tra xem có thương hiệu nào được tìm thấy không
    if ($brands && !is_wp_error($brands)) {
        // Lặp qua từng thương hiệu và lấy giá trị thương hiệu
        foreach ($brands as $brand) {
            $brand_name = $brand->name;
        }
    }

    // Tạo HTML để hiển thị thông tin thương hiệu và SKU
    $output = '<div class="group-status">';
    $output .= '<div class="first_status">Thương hiệu: <b class="status_name">' . ($brand_name != '' ? $brand_name : "Đang cập nhật") . '</b></div>';
    $output .= '<div class="first_status first_status-sku">Mã sản phẩm: <b class="status_name product-sku">' . ($product->get_sku() != '' ? $product->get_sku() : "(Đang cập nhật...)") . '</b></div>';
    $output .= '</div>';

    return $output;
}

add_shortcode('show_brand_sku', 'custom_show_brand_sku');

// NỘI DUNG SAU NÚT ADD TO CART SINGLE
function add_content_after_addtocart_button_func() {
    echo '<div class="product-wish">' . do_shortcode('[yith_wcwl_add_to_wishlist]') ;
    echo '<div class="btn-after-cart"><a href="/danh-sach-cua-hang">Danh sách cửa hàng</a></div></div>';
	echo '<div class="product-hotline">Gọi <a href="tel:0123456789" title="0123 456 789">0123 456 789</a> để tư vấn mua hàng</div>';
}
add_action( 'woocommerce_after_add_to_cart_button', 'add_content_after_addtocart_button_func' );

// THAY ĐỔI HIỂN THỊ GIÁ SẢN PHẨM SINGLE
/*Sale price by devvn - levantoan.com*/
function devvn_price_html($product, $is_variation = false){
    ob_start();
    if($product->is_on_sale() && ($is_variation || $product->is_type('simple') || $product->is_type('external'))) {
        $sale_price = $product->get_sale_price();
        $regular_price = $product->get_regular_price();
        if($regular_price) {
            $sale = round(((floatval($regular_price) - floatval($sale_price)) / floatval($regular_price)) * 100);
            $sale_amout = $regular_price - $sale_price;
            ?>
<div class="price-box">
    <span class="special-price">
        <span class="price product-price"><?php echo wc_price($sale_price); ?></span>
    </span> <!-- Giá Khuyến mại -->
    <span class="old-price">
        Giá niêm yết:
        <del class="price product-price-old">
            <?php echo wc_price($regular_price); ?>
        </del>
    </span> <!-- Giás gốc -->
    <span class="save-price">Tiết kiệm:
        <span class="price product-price-save"><?php echo wc_price($sale_amout); ?></span>
    </span> <!-- Tiết kiệm -->

</div>
<?php
        }
    }elseif($product->is_on_sale() && $product->is_type('variable')){
        $prices = $product->get_variation_prices( true );
        if ( empty( $prices['price'] ) ) {
            echo apply_filters( 'woocommerce_variable_empty_price_html', '', $product );
        } else {
            $min_price     = current( $prices['price'] );
            $max_price     = end( $prices['price'] );
            $min_reg_price = current( $prices['regular_price'] );
            $max_reg_price = end( $prices['regular_price'] );
            if ( $min_price !== $max_price ) {
                echo wc_format_price_range( $min_price, $max_price ) . $product->get_price_suffix();
            } elseif ( $product->is_on_sale() && $min_reg_price === $max_reg_price ) {
                $sale = round(((floatval($max_reg_price) - floatval($min_price)) / floatval($max_reg_price)) * 100);
                $sale_amout = $max_reg_price - $min_price;
                ?>
<div class="price-box">
    <span class="special-price">
        <span class="price product-price"><?php echo wc_price($min_price); ?></span>
    </span> <!-- Giá Khuyến mại -->
    <span class="old-price">
        Giá niêm yết:
        <del class="price product-price-old">
            <?php echo wc_price($max_reg_price); ?>
        </del>
    </span> <!-- Giás gốc -->
    <span class="save-price">Tiết kiệm:
        <span class="price product-price-save"><?php echo wc_price($sale_amout); ?></span>
    </span> <!-- Tiết kiệm -->

</div>
<?php
            } else {
                echo wc_price( $min_price ) . $product->get_price_suffix();
            }
        }
    }else{ ?>
<p class="<?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) );?>">
    <?php echo $product->get_price_html(); ?></p>
<?php }
    return ob_get_clean();
}
function woocommerce_template_single_price(){
    global $product;
    echo devvn_price_html($product);
}
add_filter('woocommerce_available_variation','devvn_woocommerce_available_variation', 10, 3);
function devvn_woocommerce_available_variation($args, $thisC, $variation){
    $old_price_html = $args['price_html'];
    if($old_price_html){
        $args['price_html'] = devvn_price_html($variation, true);
    }
    return $args;
}

// TĂNG ĐỘ DÀI EXCERPT
add_filter( 'excerpt_length', 'smile_prefix_excerpt_length' );
function smile_prefix_excerpt_length() {
	return 100;
}