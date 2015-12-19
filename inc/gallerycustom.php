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

        // render your gallery here
        // $img = wp_get_attachment_image($image->ID, $size);
        $img = wp_get_attachment_image_src($image->ID, $size);
        $homeurl = home_url();
        $imgurl = str_replace($homeurl, "", $img);
        // var_dump($imgurl);
        $thumb = $image->guid;
        $imgwithwm = "/wp-content/themes/totalmarble/wm.php?img=/home/hosting_users/totalmarble/www{$imgurl[0]}";
        $imgwithwm = "<img src=\"{$imgwithwm}\" />";

        // /wp-content/themes/totalmarble/wm.php?img=/home/hosting_users/totalmarble/www/wp-content/uploads/2015/01/00101.jpg

// var_dump($image);
// var_dump($thumb);

        // echo "<li><a href=\"{$thumb}\" rel=\"gallery1\"  class=\"various\">{$imgwithwm}</a></li>";
        $res .= "<li data-thumb=\"{$thumb}\"><img src=\"{$thumb}\" ></li>";
    }
    $res .= "</ul></div>";
    return $res;
}
?>
