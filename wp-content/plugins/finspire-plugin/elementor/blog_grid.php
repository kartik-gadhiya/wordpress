<?php namespace FINSPIREPLUGIN\Element;

use Elementor\Controls_Manager;
use Elementor\Controls_Stack;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Group_Control_Text_Shadow;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Text_Stroke;
use Elementor\Plugin;
use Finspire\Elementor\Traits\Trait_SubTitle;
use Finspire\Elementor\Traits\Trait_Title;
use Finspire\Elementor\Traits\Trait_Text;
use Finspire\Elementor\Traits\Trait_Image;
use Finspire\Elementor\Traits\Trait_Button;
/**
 * Elementor button widget.
 * Elementor widget that displays a button with the ability to control every
 * aspect of the button design.
 *
 * @since 1.0.0
 */
class Blog_Grid extends Widget_Base {
    /**
     * Get widget name.
     * Retrieve button widget name.
     *
     * @since  1.0.0
     * @access public
     * @return string Widget name.
     */
    public function get_name() {
        return 'finspire_blog_grid';
    }
    /**
     * Get widget title.
     * Retrieve button widget title.
     *
     * @since  1.0.0
     * @access public
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Finspire Blog Grid', 'finspire' );
    }
    /**
     * Get widget icon.
     * Retrieve button widget icon.
     *
     * @since  1.0.0
     * @access public
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-post-list';
    }
    /**
     * Get widget categories.
     * Retrieve the list of categories the button widget belongs to.
     * Used to determine where to display the widget in the editor.
     *
     * @since  2.0.0
     * @access public
     * @return array Widget categories.
     */
    public function get_categories() {
        return [ 'finspire' ];
    }
    /**
     * Register button widget controls.
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.0.0
     * @access protected
     */
	use Trait_SubTitle, Trait_Title, Trait_Text, Trait_Image, Trait_Button;
    protected function register_controls() {
        $this->start_controls_section(
            'blog_grid',
            [
                'label' => esc_html__( 'Blog Grid', 'finspire' ),
            ]
        );
		
		$this->add_control(
			'layout_control',
			[
				'label'   => esc_html__( 'Layout Style', 'finspire' ),
				'label_block' => true,
				'type'    => Controls_Manager::SELECT,
				'default' => '1',
				'options' => array(
					'1' => esc_html__( 'Style One ', 'finspire'),
					'2' => esc_html__( 'Style Two ', 'finspire'),
					'3' => esc_html__( 'Style Three ', 'finspire'),
					'4' => esc_html__( 'Style Four ', 'finspire'),
				),
			]
		);
		//Author
		$this->add_control(
            'author',
            [
                'label'        => esc_html__( 'Show Author', 'finspire' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'finspire' ),
                'label_off'    => esc_html__( 'Off', 'finspire' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );
		//Date
		$this->add_control(
            'date',
            [
                'label'        => esc_html__( 'Show Date', 'finspire' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'finspire' ),
                'label_off'    => esc_html__( 'Off', 'finspire' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );
		//Comment
		$this->add_control(
            'category',
            [
                'label'        => esc_html__( 'Show Category', 'finspire' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'finspire' ),
                'label_off'    => esc_html__( 'Off', 'finspire' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );
		//Grid View
		$this->add_control(
			'col_grid',
			[
				'label'   => esc_html__( 'Choose Column', 'finspire' ),
				'condition' => [ 'layout_control' => ['1', '4'], ],
				'label_block' => true,
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => array(
					' ' => esc_html__( 'Default', 'finspire' ),
					'one' => esc_html__( 'One Column Grid ', 'finspire'),
					'two'  => esc_html__( 'Two Column Grid', 'finspire' ),
					'three'  => esc_html__( 'Three Column Grid', 'finspire' ),
					'four'  => esc_html__( 'Four Column Grid', 'finspire' ),
					'five'  => esc_html__( 'Six Column Grid', 'finspire' ),
				),
			]
		);
		$this->add_control(
            'query_number',
            [
                'label'   => esc_html__( 'Number of post', 'finspire' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 2,
                'min'     => 1,
                'max'     => 100,
                'step'    => 1,
            ]
        );
		$this->add_control(
			'btn_title',
			[
				'label' => esc_html__( 'Button Title', 'finspire' ),
				'condition' => [ 'layout_control' => ['2', '3', '4'], ],
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__( 'Enter button title', 'finspire' ),
				'default' => esc_html__( 'Read More', 'finspire' ),
			]
		);	
        $this->add_control(
            'query_orderby',
            [
                'label'   => esc_html__( 'Order By', 'finspire' ),
				'label_block' => true,
                'type'    => Controls_Manager::SELECT,
                'default' => 'date',
                'options' => array(
                    'date'       => esc_html__( 'Date', 'finspire' ),
                    'title'      => esc_html__( 'Title', 'finspire' ),
                    'menu_order' => esc_html__( 'Menu Order', 'finspire' ),
                    'rand'       => esc_html__( 'Random', 'finspire' ),
                ),
            ]
        );
        $this->add_control(
            'query_order',
            [
                'label'   => esc_html__( 'Order', 'finspire' ),
				'label_block' => true,
                'type'    => Controls_Manager::SELECT,
                'default' => 'ASC',
                'options' => array(
                    'DESC' => esc_html__( 'DESC', 'finspire' ),
                    'ASC'  => esc_html__( 'ASC', 'finspire' ),
                ),
            ]
        );
        $this->add_control(
            'query_category',
            [
                'type' => Controls_Manager::SELECT2,
                'label' => esc_html__('Category', 'finspire'),
				'multiple' => true,
				'label_block' => true,
                'options' => get_blog_categories(),
            ]
        );	
		//Pagination
		$this->add_control(
			'show_pagination',
			[
				'label'       => __( 'Enable/Disable Pagination', 'finspire' ),
				'condition' => [ 'layout_control' => ['1', '4'], ],
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'finspire' ),
				'label_off' => __( 'Hide', 'finspire' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);	
		$this->end_controls_section();	
		
		//title Style Start *****************
        $this->start_controls_section(
            'title_style_setting',
            [
                'label' => esc_html__( 'Title Style Setting', 'finspire' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_title_controls();
        
        $this->end_controls_section();
		
		
		//Feature List Style Start ***************
        $this->start_controls_section(
            'count_style_setting',
            [
                'label' => esc_html__( 'Author Style', 'finspire' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_subtitle_controls();
        
        $this->end_controls_section();
		
		//Image Style Start ***************
        $this->start_controls_section(
            'image_style_setting',
            [
                'label' => esc_html__( 'Image Style Setting', 'finspire' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_image_controls();
        
        $this->end_controls_section();
		
		//text Style Start ****************
        $this->start_controls_section(
            'text_style_setting',
            [
                'label' => esc_html__( 'Date Style Setting', 'finspire' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_text_controls();
        
        $this->end_controls_section();
		
		//Button Style Start ****************
        $this->start_controls_section(
            'button_style_setting',
            [
                'label' => esc_html__( 'Button Style Setting', 'finspire' ),
				'condition' => [ 'layout_control' => ['2', '3', '4'], ],
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_button_controls();
        
        $this->end_controls_section();
		
		//Category Style		
		$this->start_controls_section(
			'icons_style',
			[
				'label' => esc_html__( 'Category Style', 'finspire' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Category Color', 'finspire' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .te-category a' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'icon_hover_color',
			[
				'label' => esc_html__( 'Hover Color', 'finspire' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .te-category:hover a' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();
		
	}
	
	/**
	 * Render button widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since  1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$options = finspire_WSH()->option();
		$allowed_tags = wp_kses_allowed_html('post');	
		$date = $settings[ 'date' ];
		$author = $settings[ 'author' ];
		$category = $settings['category'];
		
		$paged = get_query_var('paged');
		$paged = finspire_set($_REQUEST, 'paged') ? esc_attr($_REQUEST['paged']) : $paged;

        $this->add_render_attribute( 'wrapper', 'class', 'templatepath-greenture' );
        
		$args = array(
            'post_type'      => 'post',
            'posts_per_page' => finspire_set( $settings, 'query_number' ),
            'orderby'        => finspire_set( $settings, 'query_orderby' ),
            'order'          => finspire_set( $settings, 'query_order' ),
            'paged'         => $paged
        );
        
		if( finspire_set( $settings, 'query_category' ) ) $args['category_name'] = finspire_set( $settings, 'query_category' );
        $query = new \WP_Query( $args );
		
		if ( $query->have_posts() ){ 
	?>

	<?php if($settings['layout_control'] == '4') :
			$btn_title = $settings['btn_title'];
			$grid_col = $settings[ 'col_grid' ];
			if( $grid_col == 'one' ){
				$classes = 'col-lg-12 col-md-12 col-sm-12';
			}elseif( $grid_col == 'two' ){
				$classes = 'col-lg-6 col-md-6 col-sm-12';
			}elseif( $grid_col == 'three' ){
				$classes = 'col-lg-4 col-md-6 col-sm-12';
			}elseif( $grid_col == 'four' ){
				$classes = 'col-lg-3 col-md-6 col-sm-12';
			}elseif( $grid_col == 'five' ){
				$classes = 'col-lg-2 col-md-6 col-sm-12';
			}else{
				$classes = 'col-lg-4 col-md-6 col-sm-12';
			}
	?>

	<section class="news-style-three p-0 m-0">
		<div class="row clearfix">
			<?php
				global $post;
				while ( $query->have_posts() ) : $query->the_post();
				$post_thumbnail_id = get_post_thumbnail_id($post->ID);
				$post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id ); 	
			?>
			<div class="<?php echo esc_attr( $classes );?> news-block">
				<div class="news-block-two">
					<?php if( has_post_thumbnail() ){?>
					<div class="image-box">
						<figure class="image"><a href="<?php echo esc_url( get_the_permalink( get_the_id() ) );?>"><?php the_post_thumbnail( 'finspire_530x274', array( 'class' => 'te-img' ) ); ?></a></figure>
					</div>
					<?php } ?>
					<div class="content-box pl_20 pr_20 pt_35 pb_20">
						<?php if( $settings['category'] == 'yes' ){?><span class="category te-category"><?php the_category(' '); ?></span><?php } ?>
						<h3><a class="te-title" href="<?php echo esc_url( get_the_permalink( get_the_id() ) );?>"><?php the_title(); ?></a></h3>
						<div class="lower-box">
							<div class="author-box">
								<figure class="author-image"><?php echo get_avatar(get_the_author_meta('ID'), 45); ?></figure>
								<div class="inner">
									<?php if( $settings['author'] == 'yes' ){?><span class="designation te-subtitle"><?php esc_html_e('By', 'finspire'); ?> <?php the_author(); ?></span><?php } ?>
									<?php if( $settings['date'] == 'yes' ){?><span class="date te-text"><?php echo get_the_date( '' ); ?></span><?php } ?>
								</div>
							</div>
							<?php if( !empty( $btn_title ) ):?>
							<div class="btn-box">
								<a href="<?php echo esc_url( get_the_permalink( get_the_id() ) );?>" class="theme-btn light-bg te-btn"><div class="icon-box"><span class="static-icon"><i class="flaticon-two-lines"></i></span><span class="overlay-icon"><i class="flaticon-two-lines"></i></span></div><span class="text"><?php echo wp_kses( $btn_title, true );?></span></a>
							</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
			<?php endwhile; ?>
		</div>
		<?php if($settings['show_pagination']) { ?>
		<div class="pagination-wrapper centred pt_20">
			<?php finspire_the_pagination2(array('total'=>$query->max_num_pages, 'next_text' => '<i class="flaticon-two-lines prev"></i><span>Prev</span>', 'prev_text' => '<i class="flaticon-two-lines next"></i><span>Next</span>')); ?>
		</div>
		<?php } ?>
	</section>
	<!-- news-style-three end -->

	<?php elseif($settings['layout_control'] == '3') :
			$btn_title = $settings['btn_title'];
	?>

	<div class="news-style-three p-0 m-0">
		<?php
			global $post;
			while ( $query->have_posts() ) : $query->the_post();
			$post_thumbnail_id = get_post_thumbnail_id($post->ID);
			$post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id ); 	
		?>
		<div class="news-block-two">
			<div class="content-box pl_20 pr_20 pt_15 pb_20">
				<?php if( $settings['category'] == 'yes' ){?><span class="category te-category"><?php the_category(' '); ?></span><?php } ?>
				<h3><a class="te-title" href="<?php echo esc_url( get_the_permalink( get_the_id() ) );?>"><?php the_title(); ?></a></h3>
				<div class="lower-box">
					<div class="author-box">
						<figure class="author-image"><?php echo get_avatar(get_the_author_meta('ID'), 45); ?></figure>
						<div class="inner">
							<?php if( $settings['author'] == 'yes' ){?><span class="designation te-subtitle"><?php esc_html_e('By', 'finspire'); ?> <?php the_author(); ?></span><?php } ?>
							<?php if( $settings['date'] == 'yes' ){?><span class="date te-text"><?php echo get_the_date( '' ); ?></span><?php } ?>
						</div>
					</div>
					<?php if( !empty( $btn_title ) ):?>
					<div class="btn-box">
						<a href="<?php echo esc_url( get_the_permalink( get_the_id() ) );?>" class="theme-btn light-bg te-btn"><div class="icon-box"><span class="static-icon"><i class="flaticon-two-lines"></i></span><span class="overlay-icon"><i class="flaticon-two-lines"></i></span></div><span class="text"><?php echo wp_kses( $btn_title, true );?></span></a>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php endwhile; ?>
	</div>

	<?php elseif($settings['layout_control'] == '2') :
		$btn_title = $settings['btn_title'];
	?>

	<div class="inner-container">
		<?php
			global $post;
			while ( $query->have_posts() ) : $query->the_post();
			$post_thumbnail_id = get_post_thumbnail_id($post->ID);
			$post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id ); 	
		?>
		<div class="news-block-two">
			<div class="row align-items-center">
				<div class="col-lg-6 col-md-6 col-sm-12 content-column">
					<div class="content-box pl_20">
						<?php if( $settings['category'] == 'yes' ){?><span class="category te-category"><?php the_category(' '); ?></span><?php } ?>
						<h3><a class="te-title" href="<?php echo esc_url( get_the_permalink( get_the_id() ) );?>"><?php the_title(); ?></a></h3>
						<div class="lower-box">
							<div class="author-box">
								<figure class="author-image"><?php echo get_avatar(get_the_author_meta('ID'), 45); ?></figure>
								<div class="inner">
									<?php if( $settings['author'] == 'yes' ){?><span class="designation te-subtitle"><?php esc_html_e('By', 'finspire'); ?> <?php the_author(); ?></span><?php } ?>
									<?php if( $settings['date'] == 'yes' ){?><span class="date te-text"><?php echo get_the_date( '' ); ?></span><?php } ?>
								</div>
							</div>
							<?php if( !empty( $btn_title ) ):?>
							<div class="btn-box">
								<a href="<?php echo esc_url( get_the_permalink( get_the_id() ) );?>" class="theme-btn light-bg te-btn"><div class="icon-box"><span class="static-icon"><i class="flaticon-two-lines"></i></span><span class="overlay-icon"><i class="flaticon-two-lines"></i></span></div><span class="text"><?php echo wp_kses( $btn_title, true );?></span></a>
							</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<?php if( has_post_thumbnail() ){?>
				<div class="col-lg-6 col-md-6 col-sm-12 image-column">
					<div class="image-box">
						<figure class="image"><a href="<?php echo esc_url( get_the_permalink( get_the_id() ) );?>"><?php the_post_thumbnail( 'finspire_550x224', array( 'class' => 'te-img' ) ); ?></a></figure>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
		<?php endwhile; ?>
	</div>
	
	<?php else: 
			$grid_col = $settings[ 'col_grid' ];
			if( $grid_col == 'one' ){
				$classes = 'col-lg-12 col-md-12 col-sm-12';
			}elseif( $grid_col == 'two' ){
				$classes = 'col-lg-6 col-md-6 col-sm-12';
			}elseif( $grid_col == 'three' ){
				$classes = 'col-lg-4 col-md-6 col-sm-12';
			}elseif( $grid_col == 'four' ){
				$classes = 'col-lg-3 col-md-6 col-sm-12';
			}elseif( $grid_col == 'five' ){
				$classes = 'col-lg-2 col-md-6 col-sm-12';
			}else{
				$classes = 'col-lg-4 col-md-6 col-sm-12';
			}
	?>

	<div class="row clearfix">
		<?php
			global $post;
			while ( $query->have_posts() ) : $query->the_post();
			$post_thumbnail_id = get_post_thumbnail_id($post->ID);
			$post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id ); 	
		?>
		<div class="<?php echo esc_attr( $classes );?> news-block">
			<div class="news-block-one">
				<div class="inner-box">
					<?php if( has_post_thumbnail() ){?>
					<figure class="image-box"><a href="<?php echo esc_url( get_the_permalink( get_the_id() ) );?>"><?php the_post_thumbnail( 'finspire_370x370', array( 'class' => 'te-img' ) ); ?></a></figure>
					<?php } ?>
					<div class="lower-content">
						<?php if( $settings['category'] == 'yes' ){?><span class="category te-category"><?php the_category(' '); ?></span><?php } ?>
						<h3><a class="te-title" href="<?php echo esc_url( get_the_permalink( get_the_id() ) );?>"><?php the_title(); ?></a></h3>
						<div class="lower-box">
							<div class="link-box">
								<a href="<?php echo esc_url( get_the_permalink( get_the_id() ) );?>"><i class="flaticon-two-lines"></i></a>
							</div>
							<div class="inner">
								<?php if( $settings['author'] == 'yes' ){?>
								<a class="te-subtitle" href="<?php echo esc_url(get_author_posts_url( get_the_author_meta('ID') )); ?>"><?php esc_html_e('By', 'finspire'); ?> <?php the_author(); ?></a>
								<?php } ?>
								<?php if( $settings['date'] == 'yes' ){?><span class="te-text"><?php echo get_the_date( '' ); ?></span><?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php endwhile; ?>
	</div>
	<?php if($settings['show_pagination']) { ?>
	<div class="pagination-wrapper centred pt_20">
		<?php finspire_the_pagination2(array('total'=>$query->max_num_pages, 'next_text' => '<i class="flaticon-two-lines prev"></i><span>Prev</span>', 'prev_text' => '<i class="flaticon-two-lines next"></i><span>Next</span>')); ?>
	</div>
	<?php } ?>
    
    <?php endif; ?>
   	<?php }
	wp_reset_postdata();
	}
}