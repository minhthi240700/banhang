<?php
/**
 * Posts layout.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.16.0
 */

do_action('flatsome_before_blog');
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
<div class="container">
    <?php
        $queried_object = get_queried_object();
				?>
    <h1 class="cate-title">
        <?php echo ($queried_object->name === "") ? "Tất cả tin tức" : $queried_object->name; ?>
    </h1>
</div>
<?php if(!is_single() && get_theme_mod('blog_featured', '') == 'top'){ get_template_part('template-parts/posts/featured-posts'); } ?>
<div class="row align-center archive-post-custom">
    <div class="large-12 col">
        <?php if(!is_single() && get_theme_mod('blog_featured', '') == 'content'){ get_template_part('template-parts/posts/featured-posts'); } ?>

        <?php
		if(is_single()){
			get_template_part( 'template-parts/posts/single');
			comments_template();
		} elseif(get_theme_mod('blog_style_archive', '') && (is_archive() || is_search())){
			get_template_part( 'template-parts/posts/archive', get_theme_mod('blog_style_archive', '') );
		} else{
			get_template_part( 'template-parts/posts/archive', get_theme_mod('blog_style', 'normal') );
		}
	?>
    </div>

</div>

<?php do_action('flatsome_after_blog');