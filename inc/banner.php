<?php
/*

메인 관리

*/

// 커스텀 포스트 등록
add_action( 'init', 'mainban_create' );
function mainban_create() {
	register_post_type( 'mainban',
		array(
			'labels' => array(
			'name' => '메인',
			'singular_name' => 'mainban',
			'add_new' => '추가하기',
			'add_new_item' => '아이템 추가',
			'edit' => '편집',
			'edit_item' => '아이템 편집',
			'new_item' => '새로운 메인',
			'view' => '보기',
			'view_item' => '메인 보기',
			'search_items' => '메인 검색',
			'not_found' => '검색결과 없음',
			'not_found_in_trash' =>
			'(휴지통)검색결과 없음',
			'parent' => '부모 메인'
			),
			'public' => true,
			'menu_position' => 20,
			'menu_icon' => 'dashicons-format-gallery',
			'supports' =>
			array(
				'title',
				'editor',
				'comments',
				'thumbnail',
				),
			'has_archive' => true,
			'rewrite' => false
		)
	);
}

// 메타 정보 추가
if (is_admin()) {
	$prefix = 'mainban_';
	$config = array(
		'id'             => 'metabox',
		'title'          => '추가정보',
		'pages'          => array('mainban'),
		'context'        => 'normal',
		'priority'       => 'high',
		'fields'         => array(),
		'local_images'   => false,
		'use_with_theme' => true
	);

	$mainban_meta =  new AT_Meta_Box($config);

	$mainban_meta->addText($prefix.'engh1',array('name'=> '영문제목'));
	$mainban_meta->addText($prefix.'engh2',array('name'=> '영문설명'));
	$mainban_meta->addText($prefix.'url',array('name'=> '링크주소'));
	$mainban_meta->addSelect($prefix.'target',array('_blank'=>'새 창','_self'=>'현재창'),array('name'=> '새창열림', 'std'=> array('_self')));


	$mainban_meta->Finish();
}

// 분류 체계 추가
add_action( 'init', 'mainban_category', 0 );
function mainban_category() {
    $labels = array(
        'name' => _x( '분류', 'taxonomy general name' ),
        'singular_name' => _x( 'mainban_cat', 'taxonomy singular name' ),
        'search_items' => __( '분류 검색' ),
        'all_items' => __( '모든 분류' ),
        'parent_item' => __( '상위 분류' ),
        'parent_item_colon' => __( '상위 분류' ),
        'edit_item' => __( '분류 편집' ),
        'update_item' => __( '분류 수정' ),
        'add_new_item' => __( '분류 추가' ),
        'new_item_name' => __( '새로운 메인' ),
        'menu_name' => __( '분류 관리' ),
    );
    register_taxonomy(
    	'mainban_cat',
    	array( 'mainban' ),
    	array(
	       	'hierarchical' => true,
	        'labels' => $labels,
	        'show_ui' => true,
	        'show_admin_column' => true,
	        'query_var' => true,
	        'rewrite' => array( 'slug' => 'mainban_cat' ),
    	)
    );
}
