<?php
/**
 * Template name: Page - Full Width
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.16.0
 */

get_header(); ?>

<?php do_action( 'flatsome_before_page' ); ?>
<?php
if (!is_front_page()) {
    ?>
<div class="shop-page-title category-page-title page-title custom-breadcrumb<?php flatsome_header_title_classes() ?>">
	<div class="page-title-inner flex-row  medium-flex-wrap container">
	  <div class="flex-col flex-grow medium-text-center">
	  	<?php do_action('flatsome_category_title') ;?>
	  </div>
	  <div class="flex-col medium-text-center">
	  	<?php do_action('flatsome_category_title_alt') ;?>
	  </div>
	</div>
</div>
<?php
}
?>
<div id="content" role="main" class="content-area">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php the_content(); ?>

		<?php endwhile; // end of the loop. ?>

</div>

<?php do_action( 'flatsome_after_page' ); ?>

<?php get_footer(); ?>
