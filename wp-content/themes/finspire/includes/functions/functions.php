<?php

/**
 * [finspire_WSH description]
 *
 * @return [type] [description]
 */
function finspire_WSH() {
	return \FINSPIRE\Includes\Classes\Base::instance();
}

/**
 * [finspire_dot description]
 *
 * @param  array $data [description]
 *
 * @return [type]       [description]
 */
function finspire_dot( $data = array() ) {
	$dn = new \FINSPIRE\Includes\Classes\DotNotation( $data );

	return $dn;
}

/**
 * [finspire_meta description].
 *
 * @param array $data [description]
 *
 * @return [type] [description]
 */
function finspire_meta( $key, $id = '' ) {
	if ( empty( $id ) ) {
		$id = get_the_ID();
	}

	return ( get_post_meta( $id, $key, true ) ) ? get_post_meta( $id, $key, true ) : '';
}

function finspirec_app( $class = 'base', $instance = true ) {
	$all   = array(
		'base' => '\FINSPIRE\Includes\Classes\Base',
		'vc'   => '\FINSPIRE\Includes\Classes\Visual_Composer',
		'ajax' => '\FINSPIRE\Includes\Classes\Ajax',
	);
	$dn    = finspire_dot( $all );
	$class = ( $dn->get( $class ) ) ? $dn->get( $class ) : 'base';
	if ( $dn->get( $class ) ) {
		if ( $instance ) {
			return new $dn->get( $class );
		} else {
			return $dn->get( $classs );
		}
	} else {
		exit( esc_html__( 'No class found', 'finspire' ) );
	}
}

/**
 * Use front-page.php when Front page displays is set to a static page.
 *
 * @since FINSPIRE 1.0
 *
 * @param string $template front-page.php.
 *
 * @return string The template to be used: blank if is_home() is true (defaults to index.php), else $template.
 */
function finspire_front_page_template( $template ) {
	return is_home() ? '' : $template;
}

add_filter( 'frontpage_template', 'finspire_front_page_template' );
if ( ! function_exists( 'printr' ) ) {
	function printr( $arr ) {
		echo '<pre>';
		print_r( $arr );
		echo '</pre>';
		exit;
	}
}

/**
 * [finspire_template_load description]
 *
 * @param  string $template [description]
 * @param  array  $args     [description]
 *
 * @return [type]           [description]
 */
function finspire_template_load( $templ = '', $args = array() ) {
	$template = get_theme_file_path( $templ );
	if ( file_exists( $template ) ) {
		extract( $args );
		unset( $args );
		include $template;
	}
}

/**
 * [finspire_get_sidebars description]
 *
 * @param  boolean $multi [description].
 *
 * @return [type]         [description]
 */
function finspire_get_sidebars( $multi = false ) {
	global $wp_registered_sidebars;
	$sidebars = ! ( $wp_registered_sidebars ) ? get_option( 'wp_registered_sidebars' ) : $wp_registered_sidebars;
	if ( $multi ) {
		$data[] = array( 'value' => '', 'label' => '' );
	}
	foreach ( (array) $sidebars as $sidebar ) {
		if ( $multi ) {
			$data[] = array( 'value' => finspire_set( $sidebar, 'id' ), 'label' => finspire_set( $sidebar, 'name' ) );
		} else {
			$data[ finspire_set( $sidebar, 'id' ) ] = finspire_set( $sidebar, 'name' );
		}
	}

	return $data;
}

add_action( 'tgmpa_register', 'finspire_register_required_plugins' );
/**
 * [my_theme_register_required_plugins description]
 *
 * @return void [description]
 */
function finspire_register_required_plugins() {
	$plugins = array(
		array(
			'name'               => esc_html__( 'Finspire Plugin', 'finspire' ),
			'slug'               => 'finspire-plugin',
			'source'             => get_template_directory() . '/includes/thirdparty/plugins/finspire-plugin.zip',
			'required'           => true,
			'force_deactivation' => false,
			'version'			 => 1.0,
			'file_path'          => ABSPATH . 'wp-content/plugins/finspire-plugin/finspire-plugin.php',
		),
		array(
			'name'     				=> esc_html__('Woocommerce', 'finspire'),
			'slug'     				=> 'woocommerce',
			'required' 				=> true,
		),
		array(
			'name'			=> esc_html__('Contact Form 7', 'finspire'),
			'slug'			=> 'contact-form-7',
			'required'		=> true,
		),
		array(
			'name'     => esc_html__( 'Elementor', 'finspire' ),
			'slug'     => 'elementor',
			'required' => true,
		),
		array(
            'name'      => esc_html__('Mailchimp for WordPress', 'finspire'),
            'slug'      => 'mailchimp-for-wp',
            'required'  => true,
		),
	);
	/*Change this to your theme text domain, used for internationalising strings.*/
	$theme_text_domain = 'finspire';
	$config            = array(
		'id'           => 'tgmpa',
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'parent_slug'  => 'themes.php',
		'capability'   => 'edit_theme_options',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => '',
	);
	FINSPIRE\Includes\Library\tgmpa( $plugins, $config );
}

/**
 * [finspire_logo description]
 *
 * @return [type] [description]
 */
function finspire_logo( $logo_type, $image_logo, $logo_dimension, $logo_text, $logo_typography ) {
	if ( $logo_type === 'text' ) {
		$logo       = $logo_text ? $logo_text : '<span>' . esc_html__( 'FINSPIRE', 'finspire' ) . '</span>';
		$logo_style = $logo_typography;
		$logo_the_style  = ( finspire_set( $logo_style, 'font-size' ) ) ? 'font-size:' . finspire_set( $logo_style, 'font-size' ) . ';' : '';
		$logo_the_style  .= ( finspire_set( $logo_style, 'font-family' ) ) ? "font-family:'" . finspire_set( $logo_style, 'font-family' ) . "';" : '';
		$logo_the_style  .= ( finspire_set( $logo_style, 'font-weight' ) ) ? 'font-weight:' . finspire_set( $logo_style, 'font-weight' ) . ';' : '';
		$logo_the_style  .= ( finspire_set( $logo_style, 'line-height' ) ) ? 'line-height:' . finspire_set( $logo_style, 'line-height' ) . ';' : '';
		$logo_the_style  .= ( finspire_set( $logo_style, 'color' ) ) ? 'color:' . finspire_set( $logo_style, 'color' ) . ';' : '';
		$logo_the_style  .= ( finspire_set( $logo_style, 'letter-spacing' ) ) ? 'letter-spacing:' . finspire_set( $logo_style, 'letter-spacing' ) . ';' : '';
		$logo_output       = '<a style="' . $logo_the_style . '" href="' . home_url( '/' ) . '" title="' . get_bloginfo( 'name' ) . '">' . wp_kses( $logo, true ) . '</a>';
	} else {
		$logo_the_style      = '';
		$logo_image_style = '';
		$logo_image_style .= finspire_set( $logo_dimension, 'width' ) ? ' width:' . finspire_set( $logo_dimension, 'width' ) . ';' : '';
		$logo_image_style .= finspire_set( $logo_dimension, 'height' ) ? ' height:' . ( finspire_set( $logo_dimension, 'height' ) ) . ';' : '';
		if ( finspire_set( $image_logo, 'url' ) ) {
			$logo_output = '<a href="' . home_url( '/' ) . '" title="' . get_bloginfo( 'name' ) . '"><img src="' . esc_url( finspire_set( $image_logo, 'url' ) ) . '" alt="'.esc_attr__('logo', 'finspire').'" style="' . $logo_image_style . '" /></a>';
		} else {
			$logo_output = '<a href="' . esc_url(home_url('/')) . '" title="' . get_bloginfo( 'name' ) . '"><img src="' . get_template_directory_uri() . '/assets/images/logo.png' . '" alt="'.esc_attr__('logo', 'finspire').'" style="' . $logo_image_style . '" /></a>';
		}
	}

	return $logo_output;
}

/**
 * [finspire_twitter description]
 *
 * @param  string  $post_type [description].
 * @param  boolean $flip      [description].
 *
 * @return [type]             [description]
 */
function finspire_twitter( $args = array() ) {
	$selector = finspire_set( $args, 'selector' );
	$data     = finspire_set( $args, 'data' );
	$count    = finspire_set( $args, 'count', 3 );
	$screen   = finspire_set( $args, 'screen_name', 'WordPress' );
	$settings = array( 'count' => $count, 'screen_name' => $screen );
	ob_start(); ?>
	jQuery(document).ready(function ($) {
	$('<?php echo esc_js( $selector ); ?>').tweets(<?php echo json_encode( $settings ); ?>);
	});
	<?php $jsOutput = ob_get_contents();
	ob_end_clean();
	wp_add_inline_script( 'twitter-tweets', $jsOutput );
}

/**
 * [finspire_the_pagination description]
 *
 * @param  array   $args [description].
 * @param  integer $echo [description].
 *
 * @return [type]        [description]
 */


function finspire_the_pagination() {
 
    if( is_singular() )
        return;
 
    global $wp_query;
 
    /** Stop execution if there's only 1 page */
    if( $wp_query->max_num_pages <= 1 )
        return;
 
    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max   = intval( $wp_query->max_num_pages );
 
    /** Add current page to the array */
    if ( $paged >= 1 )
        $links[] = $paged;
 
    /** Add the pages around the current page to the array */
    if ( $paged >= 3 ) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }
 
    if ( ( $paged + 2 ) <= $max ) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }
 
    echo '<ul class="pagination">' . "\n";
 
    /** Previous Post Link */
    if ( get_previous_posts_link() )
        printf( '<li>%s</li>' . "\n", get_previous_posts_link(__( '<i class="flaticon-two-lines"></i><span>Prev</span>', 'finspire' )) );
 
    /** Link to first page, plus ellipses if necessary */
    if ( ! in_array( 1, $links ) ) {
        $class = 1 == $paged ? ' class="active"' : '';
 
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );
 
        if ( ! in_array( 2, $links ) )
            echo '<li>…</li>';
    }
 
    /** Link to current page, plus 2 pages in either direction if necessary */
    sort( $links );
    foreach ( (array) $links as $link ) {
        $class = $paged == $link ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
    }
 
    /** Link to last page, plus ellipses if necessary */
    if ( ! in_array( $max, $links ) ) {
        if ( ! in_array( $max - 1, $links ) )
            echo '<li>…</li>' . "\n";
 
        $class = $paged == $max ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
    }
 
    /** Next Post Link */
    if ( get_next_posts_link() )
        printf( '<li>%s</li>' . "\n", get_next_posts_link(__( '<i class="flaticon-two-lines"></i><span>Next</span>', 'finspire' )) );
 
    echo '</ul>' . "\n";
 
}

function finspire_the_breadcrumb() {
	global $wp_query;
	$queried_object = get_queried_object();
	$breadcrumb     = '';
	$delimiter      = ' . ';
	$before         = '<li class="bread-item">';
	$after          = '</li>';
	if ( ! is_front_page() ) {
		$breadcrumb .= $before . '<a href="' . home_url( '/' ) . '">' . esc_html__( 'Home', 'finspire' ) . '</a>' . $after;
		/** If category or single post */
		if ( is_category() ) {
			$cat_obj       = $wp_query->get_queried_object();
			$this_category = get_category( $cat_obj->term_id );
			if ( $this_category->parent != 0 ) {
				$parent_category = get_category( $this_category->parent );
				$breadcrumb      .= get_category_parents( $parent_category, true, $delimiter );
			}
			$breadcrumb .= $before . '<a href="' . get_category_link( get_query_var( 'cat' ) ) . '">' . single_cat_title( '', false ) . '</a>' . $after;
		} elseif ( $wp_query->is_posts_page ) {
			$breadcrumb .= $before . $queried_object->post_title . $after;
		} elseif ( is_tax() ) {
			$breadcrumb .= $before . '<a href="' . get_term_link( $queried_object ) . '">' . $queried_object->name . '</a>' . $after;
		} elseif ( is_page() ) /** If WP pages */ {
			global $post;
			if ( $post->post_parent ) {
				$anc = get_post_ancestors( $post->ID );
				foreach ( $anc as $ancestor ) {
					$breadcrumb .= $before . '<a href="' . get_permalink( $ancestor ) . '">' . get_the_title( $ancestor ) . ' &nbsp;</a>' . $after;
				}
				$breadcrumb .= $before . '' . get_the_title( $post->ID ) . '' . $after;
			} else {
				$breadcrumb .= $before . '' . get_the_title() . '' . $after;
			}
		} elseif ( is_singular() ) {
			if ( $category = wp_get_object_terms( get_the_ID(), array( 'category', 'location', 'tax_feature' ) ) ) {
				if ( ! is_wp_error( $category ) ) {
					$breadcrumb .= $before . '<a href="' . get_term_link( finspire_set( $category, '0' ) ) . '">' . finspire_set( finspire_set( $category, '0' ), 'name' ) . '&nbsp;</a>' . $after;
					$breadcrumb .= $before . '' . get_the_title() . '' . $after;
				} else {
					$breadcrumb .= $before . '' . get_the_title() . '' . $after;
				}
			} else {
				$breadcrumb .= $before . '' . get_the_title() . '' . $after;
			}
		} elseif ( is_tag() ) {
			$breadcrumb .= $before . '<a href="' . get_term_link( $queried_object ) . '">' . single_tag_title( '', false ) . '</a>' . $after;
		} /**If tag template*/
		elseif ( is_day() ) {
			$breadcrumb .= $before . '<a href="#">' . esc_html__( 'Archive for ', 'finspire' ) . get_the_time( 'F jS, Y' ) . '</a>' . $after;
		} /** If daily Archives */
		elseif ( is_month() ) {
			$breadcrumb .= $before . '<a href="' . get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) . '">' . esc_html__( 'Archive for ', 'finspire' ) . get_the_time( 'F, Y' ) . '</a>' . $after;
		} /** If montly Archives */
		elseif ( is_year() ) {
			$breadcrumb .= $before . '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . esc_html__( 'Archive for ', 'finspire' ) . get_the_time( 'Y' ) . '</a>' . $after;
		} /** If year Archives */
		elseif ( is_author() ) {
			$breadcrumb .= $before . '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ) . '">' . esc_html__( 'Archive for ', 'finspire' ) . get_the_author() . '</a>' . $after;
		} /** If author Archives */
		elseif ( is_search() ) {
			$breadcrumb .= $before . '' . esc_html__( 'Search Results for ', 'finspire' ) . get_search_query() . '' . $after;
		} /** if search template */
		elseif ( is_404() ) {
			$breadcrumb .= $before . '' . esc_html__( '404 - Not Found', 'finspire' ) . '' . $after;
			/** if search template */
		} elseif ( is_post_type_archive( 'product' ) ) {
			$shop_page_id = wc_get_page_id( 'shop' );
			if ( get_option( 'page_on_front' ) !== $shop_page_id ) {
				$shop_page = get_post( $shop_page_id );
				$_name     = wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : '';
				if ( ! $_name ) {
					$product_post_type = get_post_type_object( 'product' );
					$_name             = $product_post_type->labels->singular_name;
				}
				if ( is_search() ) {
					$breadcrumb .= $before . '<a href="' . get_post_type_archive_link( 'product' ) . '">' . $_name . '</a>' . $delimiter . esc_html__( 'Search results for &ldquo;', 'finspire' ) . get_search_query() . '&rdquo;' . $after;
				} elseif ( is_paged() ) {
					$breadcrumb .= $before . '<a href="' . get_post_type_archive_link( 'product' ) . '">' . $_name . '</a>' . $after;
				} else {
					$breadcrumb .= $before . $_name . $after;
				}
			}
		} else {
			$breadcrumb .= $before . '<a href="' . get_permalink() . '">' . get_the_title() . '</a>' . $after;
		}
		/** Default value */
	}

	return $breadcrumb;
}

function finspire_the_title( $template ) {
	global $wp_query;
	$queried_object = get_queried_object();
	$title          = '';
	/** If category or single post */
	if ( $template == 'category' || $template == 'tag' || $template == 'galleryCat' ) {
		$current_obj   = $wp_query->get_queried_object();
		$this_category = get_category( $current_obj->term_id );
		$title         .= $current_obj->name;
	} elseif ( is_home() ) {
		$title .= esc_html__( 'Home Page ', 'finspire' );
	} elseif ( $template == 'page' || $template == 'post' || $template == 'VC' || $template == 'blog' || $template == 'courseDetail' || $template == 'team' || $template == 'services' || $template == 'events' || $template == 'gallery' || $template == 'shop' || $template == 'product' ) {
		$title .= get_the_title();
	} elseif ( $template == 'archive' and is_day() ) {
		$title .= esc_html__( 'Archive for ', 'finspire' ) . get_the_time( 'F jS, Y' );
	} elseif ( $template == 'archive' and is_month() ) {
		$title .= esc_html__( 'Archive for ', 'finspire' ) . get_the_time( 'F, Y' );
	} elseif ( $template == 'archive' and is_year() ) {
		$title .= esc_html__( 'Archive for ', 'finspire' ) . get_the_time( 'Y' );
	} elseif ( $template == 'author' ) {
		$title .= esc_html__( 'Archive for ', 'finspire' ) . get_the_author();
	} elseif ( $template == 'search' ) {
		$title .= esc_html__( 'Search Results for ', 'finspire' ) . '"' . get_search_query() . '"';
	} elseif ( $template == '404' ) {
		$title .= esc_html__( '404 Page Not Found', 'finspire' );
	}

	return $title;
}

/**
 * [finspire_list_comments description]
 *
 * @param  [type] $comment [description].
 * @param  [type] $args    [description].
 * @param  [type] $depth   [description].
 *
 * @return void          [description]
 */
function finspire_list_comments( $comment, $args, $depth ) {
	$allowed_html = wp_kses_allowed_html( 'post' );

	wp_enqueue_script( 'comment-reply' );
	$GLOBALS['comment'] = $comment;
	$like               = (int) get_comment_meta( $comment->comment_ID, 'like_it', true ); 
	?>
	<div class="finspire-comment-item">
    	<div <?php comment_class('comment');?> id="comment-<?php comment_ID(); ?>">
			<?php if ( get_avatar( $comment ) ) : ?>
            <figure class="comment-image"><?php echo wp_kses( get_avatar( $comment, 65 ), true ); ?></figure>
            <?php endif; ?>
			<div class="comment-content">
				<div class="title-box">
					<h5><?php echo wp_kses( get_comment_author(), true ); ?></h5>
					<span><?php echo get_comment_date( '', get_comment_ID() ); ?></span>
				</div>
				<div class="text"><?php comment_text(); ?></div>
				<?php 
                    comment_reply_link( array_merge($args, array(
                    'reply_text' => '' . esc_html( 'Reply', 'finspire' ).'',
                    'depth'      => $depth,
                    'max_depth'  => $args['max_depth'],
                    )
                )); ?> 
			</div>
        </div>
        
    <?php
}

add_filter( 'comment_reply_link', function( $link ) {
    return str_replace( 'class="comment-reply-link', 'class="comment-reply-link reply-btn mt_20 d-flex', $link );
}, 10, 1 );

/**
 * [comment_form description]
 *
 * @param  array $args [description].
 * @param  [type] $post_id [description].
 *
 * @return void          [description]
 */
function finspire_comment_form( $args = array(), $post_id = null ) {
	if ( null === $post_id ) {
		$post_id = get_the_ID();
	}
	$allowed_html = wp_kses_allowed_html( 'post' );
	$commenter     = wp_get_current_commenter();
	$user          = wp_get_current_user();
	$user_identity = $user->exists() ? $user->display_name : '';
	$args          = wp_parse_args( $args );
	if ( ! isset( $args['format'] ) ) {
		$args['format'] = current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml';
	}
	$req                 = get_option( 'require_name_email' );
	$aria_req            = ( $req ? " aria-required='true'" : '' );
	$html_req            = ( $req ? " required='required'" : '' );
	$html5               = 'html5' === $args['format'];
	$comment_field_class = is_user_logged_in() ? 'col-sm-12' : 'col-sm-6';
	$fields              = array(
		'author' => '<div class="col-lg-6 col-md-6 col-sm-12 form-group"><input id="author" name="author"  placeholder="' . esc_attr__( 'Name', 'finspire' ) . '" type="text" class="" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" maxlength="245"' . $aria_req . $html_req . ' /></div>',
		'email'  => '<div class="col-lg-6 col-md-6 col-sm-12 form-group"><input id="email" placeholder="' . esc_attr__( 'Email', 'finspire' ) . '" class="" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" maxlength="100"/></div>',
		
	);
	$required_text       = sprintf( ' ' . esc_html__( '%s', 'finspire' ), '' );
	/**
	 * Filters the default comment form fields.
	 *
	 * @since 3.0.0
	 *
	 * @param array $fields The default comment fields.
	 */
	$fields   = apply_filters( 'comment_form_default_fields', $fields );
	$defaults = array(
		'fields'               => $fields,
		'comment_field'        => '<div class="col-lg-12 col-md-12 col-sm-12 form-group"><textarea  placeholder="' . esc_attr__( 'Type Comment here', 'finspire' ) . '"  id="comment" name="comment" class="" rows="7"  required="required"></textarea></div>',
		/** This filter is documented in wp-includes/link-template.php */
		'must_log_in'          => '<div class="log-in-text"><p class="must-log-in">' . sprintf(
			/* translators: %s: login URL */
				esc_html__( 'You must be <a href="%s">logged in</a> to post a comment.', 'finspire' ),
				wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) )
			) . '</p></div>',
		/** This filter is documented in wp-includes/link-template.php */
		'logged_in_as'         => '<p class="logged-in-as">' . sprintf(
			/* translators: 1: edit user link, 2: accessibility text, 3: user name, 4: logout URL */
				'<a href="%1$s" aria-label="%2$s">' . esc_html__( 'Logged in as', 'finspire' ) . ' %3$s</a>. <a href="%4$s">' . esc_html__( 'Log out?', 'finspire' ) . '</a>',
				get_edit_user_link(),
				/* translators: %s: user name */
				esc_attr( sprintf( esc_html__( 'Logged in as %s. Edit your profile.', 'finspire' ), $user_identity ) ),
				$user_identity,
				wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) )
			) . '</p>',
		'comment_notes_before' => '',
		'comment_notes_after'  => '',
		'action'               => site_url( '/wp-comments-post.php' ),
		'id_form'              => 'add-comment-form',
		'id_submit'            => 'submit',
		'class_form'           => '',
		'class_submit'         => 'submit',
		'name_submit'          => 'submit',
		'title_reply'          => esc_html__( 'Leave A Comment', 'finspire' ),
		'title_reply_to'       => esc_html__( 'Leave a Reply to %s', 'finspire' ),
		'title_reply_before'   => '<div class="group-title mb_35"><h2>',
		'title_reply_after'    => '</h2></div>',
		'cancel_reply_before'  => ' <small>',
		'cancel_reply_after'   => '</small>',
		'cancel_reply_link'    => esc_html__( 'Cancel reply', 'finspire' ),
		'label_submit'         => esc_html__( 'Post a Comment', 'finspire' ),
		'submit_button'        => '<button name="%1$s" type="submit" id="%2$s" class="theme-btn theme-bg" value="%4$s"><span class="icon-box"><span class="static-icon"><i class="flaticon-two-lines"></i></span><span class="overlay-icon"><i class="flaticon-two-lines"></i></span></span><span class="text">Post Comment</span></button>',
		'submit_field'         => '<div class="col-lg-12 col-md-12 col-sm-12 message-btn">%1$s %2$s</div>',
		'format'               => 'xhtml',
	);
	/**
	 * Filters the comment form default arguments.
	 * Use {@see 'comment_form_default_fields'} to filter the comment fields.
	 *
	 * @since 3.0.0
	 *
	 * @param array $defaults The default comment form arguments.
	 */
	$args = wp_parse_args( $args, apply_filters( 'comment_form_defaults', $defaults ) );
	$args = array_merge( $defaults, $args );
	if ( comments_open( $post_id ) ) : ?>
		<?php
		/**
		 * Fires before the comment form.
		 *
		 * @since 3.0.0
		 */
		do_action( 'comment_form_before' );
		?>
        <div id="respond" class="comment-form-area mt_80">
			<div class="container-none">
        
				<?php
					echo wp_kses( $args['title_reply_before'], $allowed_html );
					comment_form_title( $args['title_reply'], $args['title_reply_to'] );
					echo wp_kses( $args['cancel_reply_before'], $allowed_html );
					cancel_comment_reply_link( $args['cancel_reply_link'] );
					echo wp_kses( $args['cancel_reply_after'], $allowed_html );
					echo wp_kses( $args['title_reply_after'], $allowed_html );
					if ( get_option( 'comment_registration' ) && ! is_user_logged_in() ) :
					echo wp_kses( $args['must_log_in'], $allowed_html );
					/**
					 * Fires after the HTML-formatted 'must log in after' message in the comment form.
					 *
					 * @since 3.0.0
					 */
					do_action( 'comment_form_must_log_in_after' );
				else : ?>                

				<div class="form-inner">
					<form action="<?php echo esc_url( $args['action'] ); ?>" method="post" id="<?php echo esc_attr( $args['id_form'] ); ?>" class="mt-70 lg-mt-40 form-style-one" <?php echo wp_kses( $html5, $allowed_html ) ? ' novalidate' : ''; ?>>
						<div class="row clearfix">
							<?php
							/**
							 * Fires at the top of the comment form, inside the form tag.
							 *
							 * @since 3.0.0
							 */
							do_action( 'comment_form_top' );
							if ( is_user_logged_in() ) :
								/**
								 * Filters the 'logged in' message for the comment form for display.
								 *
								 * @since 3.0.0
								 *
								 * @param string $args_logged_in The logged-in-as HTML-formatted message.
								 * @param array  $commenter      An array containing the comment author's
								 *                               username, email, and URL.
								 * @param string $user_identity  If the commenter is a registered user,
								 *                               the display name, blank otherwise.
								 */
								echo apply_filters( 'comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity );
								/**
								 * Fires after the is_user_logged_in() check in the comment form.
								 *
								 * @since 3.0.0
								 *
								 * @param array  $commenter     An array containing the comment author's
								 *                              username, email, and URL.
								 * @param string $user_identity If the commenter is a registered user,
								 *                              the display name, blank otherwise.
								 */
								do_action( 'comment_form_logged_in_after', $commenter, $user_identity );
							else :
								echo wp_kses( $args['comment_notes_before'], $allowed_html );
							endif;
							$comment_fields = (array) $args['fields'] + array( 'comment' => $args['comment_field'] );
							/**
							 * Filters the comment form fields, including the textarea.
							 *
							 * @since 4.4.0
							 *
							 * @param array $comment_fields The comment fields.
							 */
							$comment_fields     = apply_filters( 'comment_form_fields', $comment_fields );
							$comment_field_keys = array_diff( array_keys( $comment_fields ), array( 'comment' ) );
							$first_field        = reset( $comment_field_keys );
							$last_field         = end( $comment_field_keys ); ?>
							<?php foreach ( $comment_fields as $name => $field ) {
								if ( 'comment' === $name ) {
									/**
									 * Filters the content of the comment textarea field for display.
									 *
									 * @since 3.0.0
									 *
									 * @param string $args_comment_field The content of the comment textarea field.
									 */
									echo apply_filters( 'comment_form_field_comment', $field );
									echo wp_kses( $args['comment_notes_after'], $allowed_html );
								} elseif ( ! is_user_logged_in() ) {
									if ( $first_field === $name ) {
										/**
										 * Fires before the comment fields in the comment form, excluding the textarea.
										 *
										 * @since 3.0.0
										 */
										do_action( 'comment_form_before_fields' );
									}
									/**
									 * Filters a comment form field for display.
									 * The dynamic portion of the filter hook, `$name`, refers to the name
									 * of the comment form field. Such as 'author', 'email', or 'url'.
									 *
									 * @since 3.0.0
									 *
									 * @param string $field The HTML-formatted output of the comment form field.
									 */
									echo apply_filters( "comment_form_field_{$name}", $field ) . "\n";
									if ( $last_field === $name ) {
										/**
										 * Fires after the comment fields in the comment form, excluding the textarea.
										 *
										 * @since 3.0.0
										 */
										do_action( 'comment_form_after_fields' );
									}
								}
							} ?>
							<?php $submit_button = sprintf(
								$args['submit_button'],
								esc_attr( $args['name_submit'] ),
								esc_attr( $args['id_submit'] ),
								esc_attr( $args['class_submit'] ),
								esc_attr( $args['label_submit'] )
							);
							/**
							 * Filters the submit button for the comment form to display.
							 *
							 * @since 4.2.0
							 *
							 * @param string $submit_button HTML markup for the submit button.
							 * @param array  $args          Arguments passed to `comment_form()`.
							 */
							$submit_button = apply_filters( 'comment_form_submit_button', $submit_button, $args );
							$submit_field  = sprintf(
								$args['submit_field'],
								$submit_button,
								get_comment_id_fields( $post_id )
							);
							/**
							 * Filters the submit field for the comment form to display.
							 * The submit field includes the submit button, hidden fields for the
							 * comment form, and any wrapper markup.
							 *
							 * @since 4.2.0
							 *
							 * @param string $submit_field HTML markup for the submit field.
							 * @param array  $args         Arguments passed to comment_form().
							 */
							echo apply_filters( 'comment_form_submit_field', $submit_field, $args );
							/**
							 * Fires at the bottom of the comment form, inside the closing </form> tag.
							 *
							 * @since 1.5.0
							 *
							 * @param int $post_id The post ID.
							 */
							do_action( 'comment_form', $post_id );
							?>
						</div>
					</form>
				</div>

				<?php endif; ?>

			</div>
		</div>
		<?php
		/**
		 * Fires after the comment form.
		 *
		 * @since 3.0.0
		 */
		do_action( 'comment_form_after' );
	else :
		/**
		 * Fires after the comment form if comments are closed.
		 *
		 * @since 3.0.0
		 */
		do_action( 'comment_form_comments_closed' );
	endif;
}

if( ! function_exists('finspire_filesystem') ) {
	/**
	 * [fixkar_filesystem description]
	 * @return [type] [description]
	 */
	function finspire_filesystem() {
		if( ! function_exists('require_filesystem_credentials')) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}

		/* you can safely run request_filesystem_credentials() without any issues and don't need to worry about passing in a URL */
		$creds = request_filesystem_credentials(esc_url(home_url('/')), '', false, false, array());

		/* initialize the API */
		if ( ! WP_Filesystem($creds) ) {
			/* any problems and we exit */
			return false;
		}	

		global $wp_filesystem;
		/* do our file manipulations below */

		return $wp_filesystem;
	}
}


if( ! function_exists('finspire_get_server') ) {

	function finspire_get_server($key = '', $value = '') {
		if( function_exists('finspire_server') ) {
			return finspire_server($key, $value);
		}

		return [];
	}
}

function finspire_body_classes( $classes ) {
    $classes[] = 'menu-layer';
      
    return $classes;
}
add_filter( 'body_class','finspire_body_classes' );

function finspire_custom_fonts_load( $custom_font ) {

    $custom_style = '';
    
    $pathinfo = pathinfo($custom_font);
    
    if ( $filename = finspire_set( $pathinfo, 'filename' ) ) {
        $custom_style .= '@font-face{
            font-family:"'.$filename.'";';
            $extensions = array( 'eot', 'woff', 'woff2', 'ttf', 'svg' );
            $count = 0;
            foreach( $extensions as $extension ) {
                $file_path = get_template_directory() . '/assets/css/custom-fonts/' . $filename . '.' . $extension;
                $file_url = get_template_directory_uri() . '/assets/css/custom-fonts/' . $filename . '.' . $extension;
    
                if ( file_exists( $file_path ) ) {
                    $format = $extension;
                    if ( $extension === 'eot' ) {
                        $format = 'embedded-opentype';
                    }
                    if ( $extension === 'ttf' ) {
                        $format = 'truetype';
                    }
                    $terminated = ( $count > 0 ) ? ',' : '';
                    $custom_style .= $terminated . 'src:url("'.$file_url.'") format("'.$format.'")';
    
                    $count++;
                }
            }
    
            $custom_style .= ';}';
        }
    
        return $custom_style;
}


/**
 * Add Flaticon existing font library
 *
 * @since 0.0.1
 */
if( ! function_exists('finspire_el_flat_icon') ) {
	function finspire_el_flat_icon($args) {

		$args['flaticon'] =  [
			'name' 			=> 'flaticon',
			'label' 		=> esc_html__( 'Flaticon', 'finspire' ),
			'url' 			=> get_template_directory_uri() . '/assets/css/flaticon.css',
			'enqueue' 		=> [ get_template_directory_uri() . '/assets/css/flaticon.css' ],
			'prefix' 		=> '',
			'labelIcon' 	=> 'icon-packs',
			'ver' 			=> '1.0',
			'fetchJson' 	=> get_template_directory_uri() . '/assets/js/flaticon.js',
			'native' 		=> true,
		];
		
		return $args;
	}
}
add_filter( 'elementor/icons_manager/native', 'finspire_el_flat_icon' );

function finspire_trim( $text, $len, $more = null )
{
	$text = strip_shortcodes( $text );
	$text = apply_filters( 'the_content', $text );
	$text = str_replace(']]>', ']]&gt;', $text);
	$excerpt_length = apply_filters( 'excerpt_length', $len );
	$excerpt_more = apply_filters( 'excerpt_more', ' ' . '[&hellip;]' );
	$excerpt_more = ( $more ) ? $more : ' ...';
	$text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
	return $text;
}

function finspire_get_available_menus() {

	$menus = wp_get_nav_menus();

	$options = [];

	foreach ( $menus as $menu ) {
		$options[ $menu->slug ] = $menu->name;
	}

	return $options;
}

function time_ago( $type = 'post' ) {
    $d = 'comment' == $type ? 'get_comment_time' : 'get_post_time';

    return human_time_diff($d('U'), current_time('timestamp')) . " " . esc_html__('ago', 'finspire');

}

add_filter( 'document_title_parts', 'finspire_custom_document_title_parts' );
function finspire_custom_document_title_parts( $title ) {
    // Only keep the title of the page/post
    if ( is_singular() || is_page() || is_home() || is_front_page() ) {
        unset( $title['site'] ); // Remove site name
    }
    return $title;
}

// Show custom fields in Appearance > Menus
add_filter('wp_nav_menu_item_custom_fields', function ($item_id, $item, $depth, $args) {
    $enabled = get_post_meta($item_id, '_menu_item_mega_enabled', true);
    $template_id = get_post_meta($item_id, '_menu_item_mega_template', true);
    $templates = get_posts([
        'post_type' => 'mega_menu',
        'post_status' => 'publish',
        'numberposts' => -1,
    ]);
    ?>
    <p class="description-wide">
        <label>
            <input type="checkbox" name="menu-item-mega-enabled[<?php echo $item_id; ?>]" <?php checked($enabled, 'on'); ?> />
            Enable Mega Menu
        </label>
    </p>
    <p class="description-wide">
        <label for="menu-item-mega-template-<?php echo $item_id; ?>">Select Mega Menu Template</label><br>
        <select class="w-100" name="menu-item-mega-template[<?php echo $item_id; ?>]">
            <option value="">-- Select --</option>
            <?php foreach ($templates as $template): ?>
                <option value="<?php echo $template->ID; ?>" <?php selected($template_id, $template->ID); ?>>
                    <?php echo esc_html($template->post_title); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </p>
    <?php
}, 10, 4);

// Save custom fields
add_action('wp_update_nav_menu_item', function ($menu_id, $menu_item_db_id, $args) {
    update_post_meta($menu_item_db_id, '_menu_item_mega_enabled', isset($_POST['menu-item-mega-enabled'][$menu_item_db_id]) ? 'on' : '');
    update_post_meta($menu_item_db_id, '_menu_item_mega_template', intval($_POST['menu-item-mega-template'][$menu_item_db_id] ?? 0));
}, 10, 3);

// Function to display dynamic copyright year
function finspire_copyright_year() {
    // Replace this with the year your website was established
    $start_year = 2026; 
    $current_year = date('Y');

    // Display both start year and current year if they differ
    if ($start_year == $current_year) {
        return "&copy; $current_year";
    } else {
        return "&copy; $start_year - $current_year";
    }
}

