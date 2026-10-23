<?php
namespace FINSPIREPLUGIN\Element;

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
use \Elementor\Group_Control_Image_Size;
use Elementor\Plugin;
use Finspire\Elementor\Traits\Trait_Title;
use Finspire\Elementor\Traits\Trait_SubTitle;
use Finspire\Elementor\Traits\Trait_Image;
use Finspire\Elementor\Traits\Trait_Text;

/**
 * Elementor button widget.
 * Elementor widget that displays a button with the ability to control every
 * aspect of the button design.
 *
 * @since 1.0.0
 */
class Testimonial_Tab extends Widget_Base {
	/**
	 * Get widget name.
	 * Retrieve button widget name.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'finspire_testimonial_tab';
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
		return esc_html__( 'Finspire Testimonial Tabs', 'finspire' );
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
		return 'eicon-tools';
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
	use Trait_Title, Trait_Text, Trait_Image, Trait_SubTitle;
	protected function register_controls() {
		$this->start_controls_section(
			'testimonial_tab',
			[
				'label' => esc_html__( 'Testimonial Tabs', 'finspire' ),
			]
		);
		
		$repeater = new Repeater();
		$repeater->add_control(
			'block_img',
			[
				'label' => __( 'Author Image 01', 'finspire' ),
				'type' => Controls_Manager::MEDIA,
				'default' => ['url' => Utils::get_placeholder_image_src(),],
			]
		);	
		$repeater->add_control(
			'block_img2',
			[
				'label' => __( 'Author Image 02', 'finspire' ),
				'type' => Controls_Manager::MEDIA,
				'default' => ['url' => Utils::get_placeholder_image_src(),],
			]
		);
		$repeater->add_control(
			'block_img3',
			[
				'label' => __( 'Author Image 03', 'finspire' ),
				'type' => Controls_Manager::MEDIA,
				'default' => ['url' => Utils::get_placeholder_image_src(),],
			]
		);
		$repeater->add_control(
			'block_img5',
			[
				'label' => __( 'Logo Image', 'finspire' ),
				'type' => Controls_Manager::MEDIA,
				'default' => ['url' => Utils::get_placeholder_image_src(),],
			]
		);
		$repeater->add_control(
			'ratings',
			[
				'label'       => __( 'Rating', 'finspire' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Rating', 'finspire' ),
				'default' => esc_html__( '4.9', 'finspire' ),
			]
		);
		$repeater->add_control(
			'rating',
			[
				'label'   => esc_html__( 'Choose Rating', 'finspire' ),
				'label_block' => true,
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'1' => esc_html__( '1', 'finspire'),
					'2' => esc_html__( '2', 'finspire'),
					'3' => esc_html__( '3', 'finspire'),
					'4' => esc_html__( '4', 'finspire'),
					'5' => esc_html__( '5', 'finspire'),
				),
			]
		);
		$repeater->add_control(
			'block_title',
			[
				'label'       => __( 'Title', 'finspire' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Title', 'finspire' ),
			]
		);	
		$repeater->add_control(
			'text',
			[
				'label'       => __( 'Text', 'finspire' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Text', 'finspire' ),
			]
		);

		$tabs = new Repeater();

		$tabs->add_control(
			'tab_title', 
			[
				'label' => esc_html__('Tab Title', 'finspire'),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__('Tab Title', 'finspire'),
			]
		);
		$tabs->add_control(
			'tab_subtitle', 
			[
				'label' => esc_html__('Tab Sub Title', 'finspire'),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__('Tab Sub Title', 'finspire'),
			]
		);

		$tabs->add_control(
			'tab_items', 
			[
				'label' => esc_html__('Testimonial Items', 'finspire'),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ block_title }}}',
			]
		);

		$this->add_control(
			'tabs', 
			[
				'label' => esc_html__('Tabs', 'finspire'),
				'type' => Controls_Manager::REPEATER,
				'fields' => $tabs->get_controls(),
				'title_field' => '{{{ tab_title }}}',
				'default' => [
					[
						'tab_title' => 'Tab Title',
						'tab_items' => [
							[
								'block_title' => 'Add Your Title Here', 
								'text' => 'Add Your Text Here'
							],
							[
								'block_title' => 'Add Your Title Here', 
								'text' => 'Add Your Text Here'
							],
							[
								'block_title' => 'Add Your Title Here', 
								'text' => 'Add Your Text Here'
							],
						],
					],
					[
						'tab_title' => 'Tab Title',
						'tab_items' => [
							[
								'block_title' => 'Add Your Title Here', 
								'text' => 'Add Your Text Here'
							],
							[
								'block_title' => 'Add Your Title Here', 
								'text' => 'Add Your Text Here'
							],
							[
								'block_title' => 'Add Your Title Here', 
								'text' => 'Add Your Text Here'
							],
						],
					],
					[
						'tab_title' => 'Tab Title',
						'tab_items' => [
							[
								'block_title' => 'Add Your Title Here', 
								'text' => 'Add Your Text Here'
							],
							[
								'block_title' => 'Add Your Title Here', 
								'text' => 'Add Your Text Here'
							],
							[
								'block_title' => 'Add Your Title Here', 
								'text' => 'Add Your Text Here'
							],
						],
					],
				],
			]
		);
		
		$this->end_controls_section();
		
		//image Style Start *****************
        $this->start_controls_section(
            'image_style_setting',
            [
                'label' => esc_html__( 'Author Images Style', 'finspire' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_image_controls();
        
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
		
		
		//Subtitle Style Start ***************
        $this->start_controls_section(
            'subtitle_style_setting',
            [
                'label' => esc_html__( 'Tabs Title Style', 'finspire' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_subtitle_controls();
        
        $this->end_controls_section();
		
		//Icon Style Start ***************
        $this->start_controls_section(
            'icons_style_setting',
            [
                'label' => esc_html__( 'Text Style Setting', 'finspire' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_text_controls();
        
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
	if ( empty( $settings['tabs'] ) ) return;
		
    ?>

	<section class="testimonial-style-three p-0 m-0">
		<div class="tabs-box-2">
			<div class="row clearfix">
				<div class="col-lg-4 col-md-12 col-sm-12 btn-column">
					<ul class="tab-btns tab-buttons clearfix pt_100 z_9">
						<?php foreach ( $settings['tabs'] as $index => $tab ) : 
							$active_class = ( $index === 0 ) ? 'active-btn' : '';
							$tab_id = 'activity-tab-' . $index;
						?>
						<li class="tab-btn <?php echo esc_attr( $active_class ); ?>" data-tab="#<?php echo esc_attr( $tab_id ); ?>">
							<h3 class="te-subtitle"><?php echo esc_html( $tab['tab_title'] ); ?></h3>
							<span class="designation"><?php echo esc_html( $tab['tab_subtitle'] ); ?></span>
						</li>
						<?php endforeach; ?>
					</ul>
				</div>
				<div class="col-lg-8 col-md-12 col-sm-12 content-column">
					<div class="tabs-content">
						<?php foreach ( $settings['tabs'] as $tab_index => $tab ) : 
							$active_tab = ( $tab_index === 0 ) ? 'active-tab' : '';
							$tab_id = 'activity-tab-' . $tab_index;
						?>
						<div class="tab <?php echo esc_attr( $active_tab ); ?>" id="<?php echo esc_attr( $tab_id ); ?>">
							<div class="single-item-carousel">
								<div class="swiper-wrapper">
									<?php 
									if ( ! empty( $tab['tab_items'] ) ) :
										foreach ( $tab['tab_items'] as $item ) :
										// block_img
										$feature_img  = $item['block_img'];
										if( !empty($feature_img['id']) ){
											$mount_fimg = wp_get_attachment_url($feature_img['id']);
										} else {
											$mount_fimg = $feature_img['url'];
										}

										// block_img 2
										$feature_img2  = $item['block_img2'];
										if( !empty($feature_img2['id']) ){
											$mount_fimg2 = wp_get_attachment_url($feature_img2['id']);
										} else {
											$mount_fimg2 = $feature_img2['url'];
										}

										// block_img 3
										$feature_img3  = $item['block_img3'];
										if( !empty($feature_img3['id']) ){
											$mount_fimg3 = wp_get_attachment_url($feature_img3['id']);
										} else {
											$mount_fimg3 = $feature_img3['url'];
										}
		
										// block_img 5
										$feature_img5  = $item['block_img5'];
										if( !empty($feature_img5['id']) ){
											$mount_fimg5 = wp_get_attachment_url($feature_img5['id']);
										} else {
											$mount_fimg5 = $feature_img5['url'];
										}
		
									?>
									<div class="swiper-slide">
										<div class="testimonial-block-two">
											<div class="thumb-box">
												<div class="thumb-image"><img class="te-img" src="<?php echo esc_url( $mount_fimg );?>" alt="<?php bloginfo( 'name' ); ?>"></div>
												<ul class="thumb-list">
													<li><img class="te-img" src="<?php echo esc_url( $mount_fimg2 );?>" alt="<?php bloginfo( 'name' ); ?>"></li>
													<li><img class="te-img" src="<?php echo esc_url( $mount_fimg3 );?>" alt="<?php bloginfo( 'name' ); ?>"></li>
												</ul>
											</div>
											<div class="right-content">
												<div class="clients-logo"><img src="<?php echo esc_url( $mount_fimg5 );?>" alt="<?php bloginfo( 'name' ); ?>"></div>
												<ul class="rating">
													<?php if($item['ratings']) { ?>
													<li><span><?php echo wp_kses( $item[ 'ratings'], true  );?></span></li>
													<?php } ?>
													<?php 
														$rating = !empty($item['rating']) ? (int) $item['rating'] : 0; // Use the 'rating' setting instead of meta
														if ($rating) {
															for ($x = 1; $x <= 5; $x++) {
																if ($x <= $rating) {
																	echo '<li><i class="flaticon-star"></i></li>'; // Filled star
																} else {
																	echo ''; // Empty star
																}
															}
														}
													?>
												</ul>
												<?php if($item['block_title']) { ?>
												<h3 class="te-title"><?php echo wp_kses( $item[ 'block_title'], true  );?></h3>
												<?php } ?>
												<?php if($item['text']) { ?>
												<div class="text-box">
													<p class="te-text"><?php echo wp_kses( $item[ 'text'], true  );?></p>
												</div>
												<?php } ?>
											</div>
										</div>
									</div>
									<?php endforeach; endif; ?>
								</div>
							</div>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</section>

    <?php 
	}
}