<?php
// 갤러리 사이즈
remove_shortcode('gallery');
add_shortcode('gallery', 'parse_gallery_shortcode');

function parse_gallery_shortcode($atts) {

    global $post;

    if ( ! empty( $atts['ids'] ) ) {
        // 'ids' is explicitly ordered, unless you specify otherwise.
        if ( empty( $atts['orderby'] ) )
            $atts['orderby'] = 'post__in';
        $atts['include'] = $atts['ids'];
    }

    extract(shortcode_atts(array(
        'orderby' => 'menu_order ASC, ID ASC',
        'include' => '',
        'id' => $post->ID,
        'itemtag' => 'dl',
        'icontag' => 'dt',
        'captiontag' => 'dd',
        'columns' => 3,
        'size' => 'full',
        'link' => 'file'
    ), $atts));

    $args = array(
        'post_type' => 'attachment',
        'post_status' => 'inherit',
        'post_mime_type' => 'image',
        'orderby' => $orderby
    );

    if ( !empty($include) )
        $args['include'] = $include;
    else {
        $args['post_parent'] = $id;
        $args['numberposts'] = -1;
    }

    $images = get_posts($args);

    $res .= "<div class=\"colgal\"><ul class=\"sliders\">";
    foreach ( $images as $image ) {
        $caption = $image->post_excerpt;
        $description = $image->post_content;
        if($description == '') $description = $image->post_title;
        $image_alt = get_post_meta($image->ID,'_wp_attachment_image_alt', true);
        $img = wp_get_attachment_image_src($image->ID, $size);
        $homeurl = home_url();
        $imgurl = str_replace($homeurl, "", $img);
        $thumb = $image->guid;
        $res .= "<li data-thumb=\"{$thumb}\"><img src=\"{$thumb}\" ></li>";
    }
    $msg = ml_echo('Do you want to view this House?', true);
    $btn = ml_echo('Request us', true);
    $res .= "<li><div class=\"gallast\"><h1>".$msg."</h1><a href=\"/request\">".$btn."</a></div></li>";
    $res .= "</ul></div>";

    $res .= "<div class=\"colgal-carousel\"><ul class=\"sliders\">";
    foreach ( $images as $image ) {
        $caption = $image->post_excerpt;
        $description = $image->post_content;
        if($description == '') $description = $image->post_title;
        $image_alt = get_post_meta($image->ID,'_wp_attachment_image_alt', true);
        $img = wp_get_attachment_image_src($image->ID, $size);
        $homeurl = home_url();
        $imgurl = str_replace($homeurl, "", $img);
        $thumb = $image->guid;
        $res .= "<li data-thumb=\"{$thumb}\"><img src=\"{$thumb}\" ></li>";
    }
    $res .= "<li><div class=\"gallast\"><h1><img src=\"/wp-content/themes/withusrealty/assets/images/logo.png\"></h1></div></li>";
    $res .= "</ul></div>";


    return $res;
}
?>
