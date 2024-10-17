<?php

/*-----------------------------------------------------------------------------------*/
/* Enqueue script and styles */
/*-----------------------------------------------------------------------------------*/

function grocery_shopping_enqueue_google_fonts() {

	require_once get_theme_file_path( 'core/includes/wptt-webfont-loader.php' );
	
	wp_enqueue_style( 'google-fonts-overpass', 'https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap' );
}
add_action( 'wp_enqueue_scripts', 'grocery_shopping_enqueue_google_fonts' );

if (!function_exists('grocery_shopping_enqueue_scripts')) {

	function grocery_shopping_enqueue_scripts() {

		wp_enqueue_style(
			'bootstrap-css',
			esc_url( get_template_directory_uri() ) . '/css/bootstrap.css',
			array(),'4.5.0'
		);

		wp_enqueue_style(
			'fontawesome-css',
			esc_url( get_template_directory_uri() ) . '/css/fontawesome-all.css',
			array(),'4.5.0'
		);

		wp_enqueue_style(
			'owl.carousel-css',
			esc_url( get_template_directory_uri() ) . '/css/owl.carousel.css',
			array(),'2.3.4'
		);

		wp_enqueue_style('grocery-shopping-style', get_stylesheet_uri(), array() );

		wp_enqueue_style(
			'grocery-shopping-media-css',
			esc_url( get_template_directory_uri() ) . '/css/media.css',
			array(),'2.3.4'
		);

		wp_enqueue_style(
			'grocery-shopping-woocommerce-css',
			esc_url( get_template_directory_uri() ) . '/css/woocommerce.css',
			array(),'2.3.4'
		);

		wp_enqueue_style('dashicons');

		wp_enqueue_script(
			'grocery-shopping-navigation',
			esc_url( get_template_directory_uri() ) . '/js/navigation.js',
			FALSE,
			'1.0',
			TRUE
		);

		wp_enqueue_script(
			'owl.carousel-js',
			esc_url( get_template_directory_uri() ) . '/js/owl.carousel.js',
			array('jquery'),
			'2.3.4',
			TRUE
		);

		wp_enqueue_script(
			'grocery-shopping-script',
			esc_url( get_template_directory_uri() ) . '/js/script.js',
			array('jquery'),
			'1.0',
			TRUE
		);

		if ( is_singular() ) wp_enqueue_script( 'comment-reply' );

		$css = '';

		if ( get_header_image() ) :

			$css .=  '
				#site-navigation,.page-template-frontpage #site-navigation{
					background-image: url('.esc_url(get_header_image()).');
					-webkit-background-size: cover !important;
					-moz-background-size: cover !important;
					-o-background-size: cover !important;
					background-size: cover !important;
				}';

		endif;

		wp_add_inline_style( 'grocery-shopping-style', $css );

		// Theme Customize CSS.
		require get_template_directory(). '/core/includes/inline.php';
		wp_add_inline_style( 'grocery-shopping-style',$grocery_shopping_custom_css );

	}

	add_action( 'wp_enqueue_scripts', 'grocery_shopping_enqueue_scripts' );

}

/*-----------------------------------------------------------------------------------*/
/* Setup theme */
/*-----------------------------------------------------------------------------------*/

if (!function_exists('grocery_shopping_after_setup_theme')) {

	function grocery_shopping_after_setup_theme() {

		load_theme_textdomain( 'grocery-shopping-center', get_stylesheet_directory() . '/languages' );

		if ( ! isset( $content_width ) ) $content_width = 900;

		register_nav_menus( array(
			'main-menu' => esc_html__( 'Main menu', 'grocery-shopping' ),
		));

		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'woocommerce' );
		add_theme_support( 'align-wide' );
		add_theme_support('title-tag');
		add_theme_support('automatic-feed-links');
		add_theme_support( 'wp-block-styles' );
		add_theme_support('post-thumbnails');
		add_theme_support( 'custom-background', array(
		  'default-color' => 'f3f3f3'
		));

		add_theme_support( 'custom-logo', array(
			'height'      => 70,
			'width'       => 70,
		) );

		add_theme_support( 'custom-header', array(
			'header-text' => false,
			'width' => 1920,
			'height' => 100
		));

		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		add_theme_support( 'post-formats', array('image','video','gallery','audio',) );

		add_editor_style( array( '/css/editor-style.css' ) );
	}

	add_action( 'after_setup_theme', 'grocery_shopping_after_setup_theme', 999 );

}

require get_template_directory() .'/core/includes/customizer-notice/grocery-shopping-customizer-notify.php';
require get_template_directory() .'/core/includes/main.php';
require get_template_directory() .'/core/includes/theme-breadcrumb.php';
require get_template_directory() .'/core/includes/tgm.php';
require get_template_directory() . '/core/includes/customizer.php';
load_template( trailingslashit( get_template_directory() ) . '/core/includes/class-upgrade-pro.php' );

/*-----------------------------------------------------------------------------------*/
/* Enqueue theme logo style */
/*-----------------------------------------------------------------------------------*/
function grocery_shopping_logo_resizer() {

    $grocery_shopping_theme_logo_size_css = '';
    $grocery_shopping_logo_resizer = get_theme_mod('grocery_shopping_logo_resizer');

	$grocery_shopping_theme_logo_size_css = '
		.custom-logo{
			height: '.esc_attr($grocery_shopping_logo_resizer).'px !important;
			width: '.esc_attr($grocery_shopping_logo_resizer).'px !important;
		}
	';
    wp_add_inline_style( 'grocery-shopping-style',$grocery_shopping_theme_logo_size_css );

}
add_action( 'wp_enqueue_scripts', 'grocery_shopping_logo_resizer' );

/*-----------------------------------------------------------------------------------*/
/* Enqueue Global color style */
/*-----------------------------------------------------------------------------------*/
function grocery_shopping_global_color() {

    $grocery_shopping_theme_color_css = '';
    $grocery_shopping_global_color = get_theme_mod('grocery_shopping_global_color');
    $grocery_shopping_copyright_bg = get_theme_mod('grocery_shopping_copyright_bg');

	$grocery_shopping_theme_color_css = '
		nav.woocommerce-MyAccount-navigation ul li,.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt,.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button,.woocommerce a.added_to_cart,.wp-block-button__link,.topheader,#main-menu ul.children li a:hover,#main-menu ul.sub-menu li a:hover,.blog_box h4,p.slider-button a,.slider button.owl-prev i, .slider button.owl-next i,#deal-of-day .box .box-content,#deal-of-day .box-content a.added_to_cart.wc-forward,#deal-of-day span.onsale,.wp-block-woocommerce-cart .wc-block-cart__submit-button, .wc-block-components-checkout-place-order-button, .wc-block-components-totals-coupon__button,.wp-block-woocommerce-cart .wc-block-components-product-badge,.scroll-up a,.pagination .nav-links a:hover,.pagination .nav-links a:focus,.pagination .nav-links span.current,.grocery-shopping-pagination span.current,.grocery-shopping-pagination span.current:hover,.grocery-shopping-pagination span.current:focus,.grocery-shopping-pagination a span:hover,.grocery-shopping-pagination a span:focus,.woocommerce nav.woocommerce-pagination ul li span.current,.comment-respond input#submit,.comment-reply a,.sidebar-area h4.title, .sidebar-area h1.wp-block-heading,.sidebar-area h2.wp-block-heading,.sidebar-area h3.wp-block-heading,.sidebar-area h4.wp-block-heading,.sidebar-area h5.wp-block-heading,.sidebar-area h6.wp-block-heading,.sidebar-area .wp-block-search__label,.footer-area .tagcloud a, p.wp-block-tag-cloud a,.searchform input[type=submit], .sidebar-area .wp-block-search__button{
		background: '.esc_attr($grocery_shopping_global_color).';
		}
		@media screen and (min-width: 320px) and (max-width: 767px) {
		    .menu-toggle, .dropdown-toggle,button.close-menu {
		        background: '.esc_attr($grocery_shopping_global_color).';
		    }
		}
		#deal-of-day button.owl-dot.active{
		background: '.esc_attr($grocery_shopping_global_color).'!important;
		}
		.searchform input[type=submit]:hover,.searchform input[type=submit]:focus{
		background-color: '.esc_attr($grocery_shopping_global_color).';
		}
		a:hover,a:focus,a.cart-customlocation i,#main-menu a:hover,#main-menu ul li a:hover,#main-menu li:hover > a,#main-menu a:focus,#main-menu ul li a:focus,#main-menu li.focus > a,#main-menu li:focus > a,#main-menu ul li.current-menu-item > a,#main-menu ul li.current_page_item > a,#main-menu ul li.current-menu-parent > a,#main-menu ul li.current_page_ancestor > a,#main-menu ul li.current-menu-ancestor > a,.post-meta i,.bread_crumb a:hover,.bread_crumb span,.woocommerce ul.products li.product .price,.woocommerce div.product p.price, .woocommerce div.product span.price,.post-meta i{
			color: '.esc_attr($grocery_shopping_global_color).';
		}
    	.copyright {
			background: '.esc_attr($grocery_shopping_copyright_bg).';
		}
	';
    wp_add_inline_style( 'grocery-shopping-style',$grocery_shopping_theme_color_css );
    wp_add_inline_style( 'grocery-shopping-woocommerce-css',$grocery_shopping_theme_color_css );

}
add_action( 'wp_enqueue_scripts', 'grocery_shopping_global_color' );

/*-----------------------------------------------------------------------------------*/
/* Get post comments */
/*-----------------------------------------------------------------------------------*/

if (!function_exists('grocery_shopping_comment')) :
    /**
     * Template for comments and pingbacks.
     *
     * Used as a callback by wp_list_comments() for displaying the comments.
     */
    function grocery_shopping_comment($comment, $args, $depth){

        if ('pingback' == $comment->comment_type || 'trackback' == $comment->comment_type) : ?>

            <li id="comment-<?php comment_ID(); ?>" <?php comment_class('media'); ?>>
            <div class="comment-body">
                <?php esc_html_e('Pingback:', 'grocery-shopping');
                comment_author_link(); ?><?php edit_comment_link(__('Edit', 'grocery-shopping'), '<span class="edit-link">', '</span>'); ?>
            </div>

        <?php else : ?>

        <li id="comment-<?php comment_ID(); ?>" <?php comment_class(empty($args['has_children']) ? '' : 'parent'); ?>>
            <article id="div-comment-<?php comment_ID(); ?>" class="comment-body media mb-4">
                <a class="pull-left" href="#">
                    <?php if (0 != $args['avatar_size']) echo get_avatar($comment, $args['avatar_size']); ?>
                </a>
                <div class="media-body">
                    <div class="media-body-wrap card">
                        <div class="card-header">
                            <h5 class="mt-0"><?php /* translators: %s: author */ printf('<cite class="fn">%s</cite>', get_comment_author_link() ); ?></h5>
                            <div class="comment-meta">
                                <a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
                                    <time datetime="<?php comment_time('c'); ?>">
                                        <?php /* translators: %s: Date */ printf( esc_attr('%1$s at %2$s', '1: date, 2: time', 'grocery-shopping'), esc_attr( get_comment_date() ), esc_attr( get_comment_time() ) ); ?>
                                    </time>
                                </a>
                                <?php edit_comment_link( __( 'Edit', 'grocery-shopping' ), '<span class="edit-link">', '</span>' ); ?>
                            </div>
                        </div>

                        <?php if ('0' == $comment->comment_approved) : ?>
                            <p class="comment-awaiting-moderation"><?php esc_html_e('Your comment is awaiting moderation.', 'grocery-shopping'); ?></p>
                        <?php endif; ?>

                        <div class="comment-content card-block">
                            <?php comment_text(); ?>
                        </div>

                        <?php comment_reply_link(
                            array_merge(
                                $args, array(
                                    'add_below' => 'div-comment',
                                    'depth' => $depth,
                                    'max_depth' => $args['max_depth'],
                                    'before' => '<footer class="reply comment-reply card-footer">',
                                    'after' => '</footer><!-- .reply -->'
                                )
                            )
                        ); ?>
                    </div>
                </div>
            </article>

            <?php
        endif;
    }
endif; // ends check for grocery_shopping_comment()

if (!function_exists('grocery_shopping_widgets_init')) {

	function grocery_shopping_widgets_init() {

		register_sidebar(array(

			'name' => esc_html__('Sidebar','grocery-shopping'),
			'id'   => 'grocery-shopping-sidebar',
			'description'   => esc_html__('This sidebar will be shown next to the content.', 'grocery-shopping'),
			'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="title">',
			'after_title'   => '</h4>'

		));

		register_sidebar(array(

			'name' => esc_html__('Sidebar 2','grocery-shopping'),
			'id'   => 'grocery-shopping-sidebar-2',
			'description'   => esc_html__('This sidebar will be shown next to the content.', 'grocery-shopping'),
			'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="title">',
			'after_title'   => '</h4>'

		));

		register_sidebar(array(

			'name' => esc_html__('Sidebar 3','grocery-shopping'),
			'id'   => 'grocery-shopping-sidebar-3',
			'description'   => esc_html__('This sidebar will be shown next to the content.', 'grocery-shopping'),
			'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="title">',
			'after_title'   => '</h4>'

		));

		register_sidebar(array(

			'name' => esc_html__('Footer sidebar','grocery-shopping'),
			'id'   => 'grocery-shopping-footer-sidebar',
			'description'   => esc_html__('This sidebar will be shown next at the bottom of your content.', 'grocery-shopping'),
			'before_widget' => '<div id="%1$s" class="col-lg-3 col-md-3 %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="title">',
			'after_title'   => '</h4>'

		));

	}

	add_action( 'widgets_init', 'grocery_shopping_widgets_init' );

}

function grocery_shopping_get_categories_select() {
	$teh_cats = get_categories();
	$results = array();
	$count = count($teh_cats);
	for ($i=0; $i < $count; $i++) {
	if (isset($teh_cats[$i]))
  		$results[$teh_cats[$i]->slug] = $teh_cats[$i]->name;
	else
  		$count++;
	}
	return $results;
}

function grocery_shopping_sanitize_select( $input, $setting ) {
	// Ensure input is a slug
	$input = sanitize_key( $input );

	// Get list of choices from the control
	// associated with the setting
	$choices = $setting->manager->get_control( $setting->id )->choices;

	// If the input is a valid key, return it;
	// otherwise, return the default
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

// Change number or products per row to 3
add_filter('loop_shop_columns', 'grocery_shopping_loop_columns');
if (!function_exists('grocery_shopping_loop_columns')) {
	function grocery_shopping_loop_columns() {
		$grocery_shopping_columns = get_theme_mod( 'grocery_shopping_per_columns', 3 );
		return $grocery_shopping_columns;
	}
}

//Change number of products that are displayed per page (shop page)
add_filter( 'loop_shop_per_page', 'grocery_shopping_per_page', 20 );
function grocery_shopping_per_page( $grocery_shopping_cols ) {
  	$grocery_shopping_cols = get_theme_mod( 'grocery_shopping_product_per_page', 9 );
	return $grocery_shopping_cols;
}

// Add filter to modify the number of related products
add_filter( 'woocommerce_output_related_products_args', 'grocery_shopping_products_args' );
function grocery_shopping_products_args( $args ) {
    $args['posts_per_page'] = get_theme_mod( 'custom_related_products_number', 6 );
    $args['columns'] = get_theme_mod( 'custom_related_products_number_per_row', 3 );
    return $args;
}

function grocery_shopping_sanitize_phone_number( $phone ) {
	return preg_replace( '/[^\d+]/', '', $phone );
}

add_action('after_switch_theme', 'grocery_shopping_setup_options');
function grocery_shopping_setup_options () {
    update_option('dismissed-get_started', FALSE );
}?>