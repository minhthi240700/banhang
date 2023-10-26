<?php
/**
 * Post-entry title.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.16.0
 */

if ( is_single() ) :
	if ( get_theme_mod( 'blog_single_header_category', 1 ) ) :
		echo '<h6 class="entry-category is-xsmall">';
		echo get_the_category_list( __( ', ', 'flatsome' ) );
		echo '</h6>';
	endif;
else :
	echo '<h6 class="entry-category is-xsmall">';
	echo get_the_category_list( __( ', ', 'flatsome' ) );
	echo '</h6>';
endif;

if ( is_single() ) :
	if ( get_theme_mod( 'blog_single_header_title', 1 ) ) :
		echo '<h1 class="entry-title">' . get_the_title() . '</h1>';
	endif;
else :
	echo '<h2 class="entry-title"><a href="' . get_the_permalink() . '" rel="bookmark" class="plain">' . get_the_title() . '</a></h2>';
endif;
?>

<?php
$single_post = is_singular( 'post' );
if ( $single_post && get_theme_mod( 'blog_single_header_meta', 1 ) ) : ?>
<div class="entry-meta uppercase is-xsmall">
    <?php
$date = get_the_date(); // Lấy ngày tháng năm từ hàm get_the_date()

// Chuyển đổi ngày tháng năm thành định dạng mong muốn
$parts = date_parse_from_format('d/m/Y', $date);
$ngay = $parts['day']; // Lấy ngày
$thang = $parts['month']; // Lấy tháng
$nam = $parts['year']; // Lấy năm

// Mảng các tên tháng
$ten_thang = array(
    1 => 'một', 2 => 'hai', 3 => 'ba', 4 => 'tư', 5 => 'năm',
    6 => 'sáu', 7 => 'bảy', 8 => 'tám', 9 => 'chín', 10 => 'mười',
    11 => 'mười một', 12 => 'mười hai'
);

// Định dạng chuỗi ngày tháng năm theo yêu cầu
echo "Ngày $ngay, tháng  {$ten_thang[$thang]}, năm $nam";
?>
</div>
<?php elseif ( ! $single_post && 'post' == get_post_type() ) : ?>
<div class="entry-meta uppercase is-xsmall">
    <?php flatsome_posted_on(); ?>
</div>
<?php endif; ?>