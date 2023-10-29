<?php
/**
 * Posts single.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.16.0
 */

if ( have_posts() ) : ?>

<?php /* Start the Loop */ ?>

<?php while ( have_posts() ) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="article-inner <?php flatsome_blog_article_classes(); ?>">
        <?php
			if(flatsome_option('blog_post_style') == 'default' || flatsome_option('blog_post_style') == 'inline'){
				get_template_part('template-parts/posts/partials/entry-header', flatsome_option('blog_posts_header_style') );
			}
		?>
        <?php get_template_part( 'template-parts/posts/content', 'single' ); ?>
    </div>
</article>

<?php endwhile; ?>

<?php else : ?>

<?php get_template_part( 'no-results', 'index' ); ?>

<?php endif; ?>
<?php
/*
 * Code hiển thị bài viết liên quan trong cùng 1 category
 * Code by levantoan.com
 */
$categories = get_the_category(get_the_ID());
if ($categories){
	echo '<h2 class="container-width posts-section-title-related pt-half pb-half uppercase"> Bài viết liên quan </h2>';
    echo '<div class="relatedcat row large-columns-3 medium-columns- small-columns-1">';
    $category_ids = array();
    foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
    $args=array(
        'category__in' => $category_ids,
        'post__not_in' => array(get_the_ID()),
        'posts_per_page' => 4, // So bai viet dc hien thi
    );
    $my_query = new wp_query($args);
    if( $my_query->have_posts() ):
        while ($my_query->have_posts()):$my_query->the_post();
            ?>
<div class="col post-item">
    <div class="col-inner">
        <a href="<?php the_permalink() ?>" class="plain">
            <div class="box box-text-bottom box-blog-post has-hover">
                <div class="box-image">
                    <div class="image-cover" style="padding-top:70%;">
					<?php the_post_thumbnail(); ?>
                    </div>
                </div>
                <div class="box-text text-left">
                    <div class="box-text-inner blog-post-inner">
                        <h5 class="post-title is-large "><?php the_title(); ?></h5>
                        <p class="from_the_blog_excerpt "><?php echo get_the_excerpt() ?></p>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
<?php
        endwhile;
    endif; wp_reset_query();
    echo '</div>';
}
?>