<?php
/**
 * WPBP functions and definitions
 *
 * @package WPBP
 */

if ( ! function_exists( 'WPBPsetup' ) ) :
	function WPBPsetup() {

		load_theme_textdomain( 'open', get_template_directory() . '/languages' );

		add_theme_support( 'automatic-feed-links' );

		add_theme_support( 'title-tag' );

		add_theme_support( 'post-thumbnails' );

		register_nav_menus( array(
			'primary' => __( 'Primary Menu', 'open' ),
			) );

		add_theme_support( 'html5', array(
			'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
			) );

	}
endif; // WPBPsetup
add_action( 'after_setup_theme', 'WPBPsetup' );

function WPBPwidgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'WPBP' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
		) );
}
add_action( 'widgets_init', 'WPBPwidgets_init' );

/**
 * Enqueue scripts and styles.
*/
function WPBPscripts() {
	wp_enqueue_style( 'WPBPstyle', get_stylesheet_uri() );
	wp_enqueue_style( 'WPBP_base_style', get_template_directory_uri() . '/assets/css/style.css','',date('ymdhms') );
	wp_enqueue_style( 'xeicon', '//cdn.jsdelivr.net/xeicon/1.0.4/xeicon.min.css' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// jQuery load from CDN
	if (!is_admin()) {
		wp_deregister_script('jquery');
		wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js", false, null);
		wp_enqueue_script('jquery');
	}

	// library load
	$libraries = array(
		'headjs'  => 'head.min.js',
		'hoverIntent'  => 'jquery.hoverIntent.js',
		'flexslider'  => 'jquery.flexslider.js'
		);
	foreach ($libraries as $key => $value) {
		wp_enqueue_script( $key, get_template_directory_uri() . '/assets/js/lib/' . $key . '/' . $value );
	}

	wp_enqueue_script( 'WPBP', get_template_directory_uri() . '/assets/js/fb.js' );
}
add_action( 'wp_enqueue_scripts', 'WPBPscripts' );

/**
 * Built-in Plugins
 */

require get_template_directory() . '/meta-box-class/my-meta-box-class.php';
require get_template_directory() . '/inc/template-tags.php';

// 태그 리스트
function taglist ($postid) {
	$tags = wp_get_post_tags($postid);
	$result .= "<ul>";
	for ($i=0; $i < count($tags); $i++) {
		$html = "<li><a href=\"/archives/tag/{$tags[$i]->name}\">{$tags[$i]->name}</a></li>";
		$result .= $html;
	}
	$result .= "</ul>";
	return $result;
}

// 최신글 노출
function idxrec( $category, $title, $number ) {
	echo "<div class=\"inner\">";
	echo "<h1 class=\"wg-tit\"><strong>{$title}</strong><a href=\"/?cat={$category}\" class=\"wg-more\"><i class=\"xe xi-plus\"></i></a></h1>";
	echo "<ul class=\"wg-list\" >";
	$args = array(
		'showposts' => $number,
		'post_type' => 'post',
		'cat' => $category,
		);

	$loopb = new WP_Query( $args );
	if( $loopb->have_posts() ) {
		while ( $loopb->have_posts() ) : $loopb->the_post();
		get_template_part( 'content', 'list' );
		endwhile;
	} else {
		echo "<li>준비중입니다.</li>";
	}
	echo "</ul>";
	echo "</div>";

}

// 텍스트 자르기
function text_cut($str, $len, $poststr="...") {
	if (mb_strlen($str) <= $len) {
	 //if (strlen($str) <= $len) {
		return $str;
	} else {
		return mb_substr($str, 0, $len, 'UTF-8') . $poststr;
		  //return substr($str, 0, $len) . $poststr;
	}
}

// 첫 이미지
function catch_that_image() {
	global $post, $posts;
	$first_img = '';
	ob_start();
	ob_end_clean();
	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
	$first_img = $matches [1] [0];

	// if(strpos($first_img, '.gif')) {
	//  return false;
	// }

	if(empty($first_img)){ //Defines a default image
		return false;
	}
	return $first_img;
}

// 첨부파일
function display_uploads($postid)
{
	$args = array(
		'post_type' => 'attachment',
		'numberposts' => null,
		'post_status' => null,
		'post_parent' => $postid
		);
	$attachments = get_posts($args);
	if ($attachments) {
		?>
	<ul>
		<?php
		foreach ($attachments as $attachment) {
			$mime = apply_filters('the_title', $attachment->post_mime_type);
			if (!preg_match('/image/',$mime)) {
				?>
				<li class="<?php echo apply_filters('the_title', $attachment->post_mime_type); ?>">
					<a href="<?php echo $attachment->guid; ?>" title="<?php echo apply_filters('the_title', $attachment->post_title); ?>">
						<?php echo apply_filters('the_title', $attachment->post_title); ?>
					</a>
				</li>
				<?php
			}
		}
		?>
	</ul>
	<?php }
}

// 요약글 길이
function custom_excerpt_length( $length ) {
	return 60;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

// 어드민 바
show_admin_bar(false);


