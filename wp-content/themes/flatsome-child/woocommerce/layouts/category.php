<?php
/**
 * Category layout with left sidebar.
 *
 * @package          Flatsome/WooCommerce/Templates
 * @flatsome-version 3.16.0
 */

?>
<div class="row row-small category-page-row">

    <div class="col large-3 hide-for-medium <?php flatsome_sidebar_classes(); ?>">
        <?php flatsome_sticky_column_open( 'category_sticky_sidebar' ); ?>
        <div id="shop-sidebar" class="sidebar-inner col-inner">
            <?php
				  if(is_active_sidebar('shop-sidebar')) {
				  		dynamic_sidebar('shop-sidebar');
				  	} else{ echo '<p>You need to assign Widgets to <strong>"Shop Sidebar"</strong> in <a href="'.get_site_url().'/wp-admin/widgets.php">Appearance > Widgets</a> to show anything here</p>';
				  }
				?>
        </div>
        <?php flatsome_sticky_column_close( 'category_sticky_sidebar' ); ?>
    </div>

    <div class="col large-9">
        <?php
                $queried_object = get_queried_object();
				?>
        <h1 class="cate-title"><?php echo ($queried_object->name === "product") ? "Tất cả sản phẩm" : $queried_object->name; ?></h1>
        <p class="collections-des">Chúng tôi mong muốn mang đến sự nhanh chóng và tiện lợi tối đa khi mua sắm đến cho khách hàng bằng việc
            đưa hệ thống siêu thị Wolf Food phủ rộng khắp mọi khu vực kể cả vùng nông thôn. Bên cạnh đó, chúng tôi cũng
            tập trung phát triển kênh mua sắm online trên website Wolf Food để phục vụ cho mọi đối tượng, đặc biệt là
            nhóm khách hàng trẻ.
            Wolf Food cũng không ngừng tìm kiếm và mang đến sự đa dạng trong việc lựa chọn sản phẩm với hơn 12.000 sản
            phẩm đủ chủng loại, xuất xứ rõ ràng, giá cả hợp lý, minh bạch.</p>
        <?php
		echo do_shortcode('[block id="slider-trang-san-pham"]');
?>
<div class="sort-cate">
<div class="sort-cate-left-label">
                    <h3>
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="12px" height="12px" viewBox="0 0 97.761 97.762" style="enable-background:new 0 0 97.761 97.762;" xml:space="preserve">
		<path d="M42.761,65.596H34.75V2c0-1.105-0.896-2-2-2H16.62c-1.104,0-2,0.895-2,2v63.596H6.609c-0.77,0-1.472,0.443-1.804,1.137
			c-0.333,0.695-0.237,1.519,0.246,2.117l18.076,26.955c0.38,0.473,0.953,0.746,1.558,0.746s1.178-0.273,1.558-0.746L44.319,68.85
			c0.482-0.6,0.578-1.422,0.246-2.117C44.233,66.039,43.531,65.596,42.761,65.596z"></path>
                            <path d="M93.04,95.098L79.71,57.324c-0.282-0.799-1.038-1.334-1.887-1.334h-3.86c-0.107,0-0.213,0.008-0.318,0.024
			c-0.104-0.018-0.21-0.024-0.318-0.024h-3.76c-0.849,0-1.604,0.535-1.887,1.336L54.403,95.1c-0.215,0.611-0.12,1.289,0.255,1.818
			s0.983,0.844,1.633,0.844h5.773c0.88,0,1.657-0.574,1.913-1.416l2.536-8.324h14.419l2.536,8.324
			c0.256,0.842,1.033,1.416,1.913,1.416h5.771c0.649,0,1.258-0.314,1.633-0.844C93.16,96.387,93.255,95.709,93.04,95.098z
			 M68.905,80.066c2.398-7.77,4.021-13.166,4.82-16.041l4.928,16.041H68.905z"></path>
                            <path d="M87.297,34.053H69.479L88.407,6.848c0.233-0.336,0.358-0.734,0.358-1.143V2.289c0-1.104-0.896-2-2-2H60.694
			c-1.104,0-2,0.896-2,2v3.844c0,1.105,0.896,2,2,2h16.782L58.522,35.309c-0.233,0.336-0.358,0.734-0.358,1.146v3.441
			c0,1.105,0.896,2,2,2h27.135c1.104,0,2-0.895,2-2v-3.842C89.297,34.947,88.402,34.053,87.297,34.053z"></path>
</svg>
                        Xếp theo
                    </h3>
                </div>

                <ul class="quick-sort-block">
                    <li class="btn-quick-sort"><a href="/cua-hang"> <i></i>Mặc định</a></li>
                    <li class="btn-quick-sort"><a href="?orderby=date"><i></i>Mới nhất</a></li>
                    <li class="btn-quick-sort"><a href="?orderby=price"><i></i>Giá thấp đến cao</a></li>
                    <li class="btn-quick-sort"><a href="?orderby=price-desc"><i></i>Giá cao xuống thấp</a></li>
                    <li class="btn-quick-sort"><a href="?orderby=popularity"><i></i>Mức độ phổ biến</a></li>
                    <li class="btn-quick-sort"><a href="?orderby=rating"><i></i>Điểm đánh giá</a></li>
                </ul>
        </div>
<?php

		/**
		 * Hook: woocommerce_before_main_content.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20 (FL removed)
		 * @hooked WC_Structured_Data::generate_website_data() - 30
		 */
		do_action( 'woocommerce_before_main_content' );

		?>

        <?php
		/**
		 * Hook: woocommerce_archive_description.
		 *
		 * @hooked woocommerce_taxonomy_archive_description - 10
		 * @hooked woocommerce_product_archive_description - 10
		 */
		do_action( 'woocommerce_archive_description' );
		?>

        <?php

		if ( woocommerce_product_loop() ) {

			/**
			 * Hook: woocommerce_before_shop_loop.
			 *
			 * @hooked wc_print_notices - 10
			 * @hooked woocommerce_result_count - 20 (FL removed)
			 * @hooked woocommerce_catalog_ordering - 30 (FL removed)
			 */
			do_action( 'woocommerce_before_shop_loop' );

			woocommerce_product_loop_start();

			if ( wc_get_loop_prop( 'total' ) ) {
				while ( have_posts() ) {
					the_post();

					/**
					 * Hook: woocommerce_shop_loop.
					 *
					 * @hooked WC_Structured_Data::generate_product_data() - 10
					 */
					do_action( 'woocommerce_shop_loop' );

					wc_get_template_part( 'content', 'product' );
				}
			}

			woocommerce_product_loop_end();

			/**
			 * Hook: woocommerce_after_shop_loop.
			 *
			 * @hooked woocommerce_pagination - 10
			 */
			do_action( 'woocommerce_after_shop_loop' );
		} else {
			/**
			 * Hook: woocommerce_no_products_found.
			 *
			 * @hooked wc_no_products_found - 10
			 */
			do_action( 'woocommerce_no_products_found' );
		}
		?>

        <?php
			/**
			 * Hook: flatsome_products_after.
			 *
			 * @hooked flatsome_products_footer_content - 10
			 */
			do_action( 'flatsome_products_after' );
			/**
			 * Hook: woocommerce_after_main_content.
			 *
			 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
			 */
			do_action( 'woocommerce_after_main_content' );
		?>
    </div>
</div>