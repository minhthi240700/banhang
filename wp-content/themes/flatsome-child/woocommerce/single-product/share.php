
<?php 
$avatar=get_field('avatar');
$ten_shop=get_field('ten_shop');
$link_chat_facebook=get_field('link_chat_facebook');
$so_dien_thoai=get_field('so_dien_thoai');
$mo_ta_shop=get_field('mo_ta_shop');
?>
<?php if($avatar){?>
<div class="thong-tin-shop">
    <div class="left">
        <img src="<?php echo $avatar['url']; ?>" alt="<?php echo $avatar['alt']; ?>" /> 
    </div>
    <div class="right">
        <p class="des">Được bán bởi:</p>
        <h3><?php the_field('ten_shop');?></h3>
        <p class="mo-ta-shop"><?php the_field('mo_ta_shop');?></p>
        <button class="chat-facebook"><a href="<?php the_field('link_chat_facebook')?>">Chat ngay</a></button>
        <button class="so-hotline"><a href="tel:<?php the_field('so_dien_thoai')?>">Gọi ngay</a></button>
    </div>
</div>
<?php }?>
<?php
/**
 * Single Product Share
 *
 * Sharing plugins can hook into here or you can add your own code directly.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/share.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

do_action( 'woocommerce_share' ); // Sharing plugins can hook into here.

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
