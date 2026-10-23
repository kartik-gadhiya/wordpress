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
use \Elementor\Group_Control_Image_Size;
use Elementor\Plugin;
use Finspire\Elementor\Traits\Trait_Image;
use Finspire\Elementor\Traits\Trait_SubTitle;
use Finspire\Elementor\Traits\Trait_Title;
use Finspire\Elementor\Traits\Trait_Text;
use Finspire\Elementor\Traits\Trait_Button;
use Finspire\Elementor\Traits\Trait_Icons;

/**
 * Elementor button widget.
 * Elementor widget that displays a button with the ability to control every
 * aspect of the button design.
 *
 * @since 1.0.0
 */
class Main_Slider extends Widget_Base {

    /**
     * Get widget name.
     * Retrieve button widget name.
     *
     * @since  1.0.0
     * @access public
     * @return string Widget name.
     */
    public function get_name() {
        return 'finspire_main_slider';
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
        return esc_html__( 'Finspire Main Slider', 'finspire' );
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
        return 'eicon-banner';
    }

    
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
	use Trait_SubTitle, Trait_Image, Trait_Title, Trait_Text, Trait_Button, Trait_Icons;
    protected function register_controls() {
        $this->start_controls_section(
            'main_slider',
            [
                'label' => esc_html__( 'Main Slider', 'finspire' ),
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
				),
			]
		);
		$this->add_control(
			'image',
			[
				'label' => __( 'Shape Image', 'finspire' ),
				'condition' => [ 'layout_control' => ['1'], ],
				'type' => Controls_Manager::MEDIA,
				'default' => ['url' => Utils::get_placeholder_image_src(),],
			]
		);
		
		//Banner SLide Repeater
		$repeater = new Repeater();
		$repeater->add_control(
			'banner_image',
			[
				'label' => __( 'Shape Image', 'finspire' ),
				'type' => Controls_Manager::MEDIA,
				'default' => ['url' => Utils::get_placeholder_image_src(),],
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
			'subtitle',
			[
				'label'       => __( 'Sub Title', 'finspire' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Sub Title', 'finspire' ),
			]
		);
		$repeater->add_control(
			'title',
			[
				'label'       => __( 'Title', 'finspire' ),
				'type'        => Controls_Manager::TEXTAREA,
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
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Text', 'finspire' ),
			]
		);
		$repeater->add_control(
			'icons',
			[
				'label' => esc_html__('Enter icons', 'finspire'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'flaticon-mozy',
					'library' => 'solid',
				],
			]			
		);
		$repeater->add_control(
			'count',
			[
				'label'       => __( 'Count', 'finspire' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Count', 'finspire' ),
			]
		);
		$repeater->add_control(
			'c_title',
			[
				'label'       => __( 'Count Title', 'finspire' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Count Title', 'finspire' ),
			]
		);
		$repeater->add_control(
			'btn_title',
			[
				'label'       => __( 'Button Title', 'finspire' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Button Title', 'finspire' ),
			]
		);
		$repeater->add_control(
			'link_option',
			[
				'label'   => esc_html__( 'Select link Option', 'finspire' ),
				'label_block' => true,
				'type'    => Controls_Manager::SELECT,
				'default' => 'extranal',
				'options' => array(
					'extranal' => esc_html__( 'Extranal ', 'finspire'),
					'page' => esc_html__( 'Page ', 'finspire'),
				),
			]
		);
		$repeater->add_control(
			'link',
			[
				'label' => __( 'External Link', 'finspire' ),
				'type' => Controls_Manager::URL,
				'label_block' => true, 
				'placeholder' => __( 'https://your-link.com', 'finspire' ),
				'show_external' => true,
				'default' => [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
				'condition'   => [
					'link_option' => 'extranal'
				]
			]
		);
		$repeater->add_control(
			'page_select',
			[
				'label'   => esc_html__( 'Select Page', 'finspire' ),
				'label_block' => true,
				'type'    => Controls_Manager::SELECT,
				'default' => 'extranal',
				'options' => finspire_page_list(),
				'condition'   => [
					'link_option' => 'page'
				]
			]
		);	
		$repeater->add_control(
			'banner_image2',
			[
				'label' => __( 'Slider Image', 'finspire' ),
				'type' => Controls_Manager::MEDIA,
				'default' => ['url' => Utils::get_placeholder_image_src(),],
			]
		);
		
		$this->add_control(
			'slide',
			[
				'label'                 => __('Add Slide Item', 'finspire'),
				'condition' => [ 'layout_control' => ['1'], ],
				'type'                  => Controls_Manager::REPEATER,
				'fields'                => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
				'default' => [
					[
						'subtitle' => esc_html__( 'Add your subtitle', 'finspire' ),
						'title' => esc_html__( 'Matching Talent with Ideal<br> Opportunities.', 'finspire' ),
						'text' => esc_html__( 'Trouble that are bound to ensue and equal that<br> shrinking from toil and pain.', 'finspire' ),
						'count' => esc_html__( '100+', 'finspire' ),
						'c_title' => esc_html__( 'Trusted Clients and Counting', 'finspire' ),
						'btn_title' => esc_html__( 'Read More', 'finspire' ),
					],
					[
						'subtitle' => esc_html__( 'Add your subtitle', 'finspire' ),
						'title' => esc_html__( 'Matching Talent with Ideal<br> Opportunities.', 'finspire' ),
						'text' => esc_html__( 'Trouble that are bound to ensue and equal that<br> shrinking from toil and pain.', 'finspire' ),
						'count' => esc_html__( '100+', 'finspire' ),
						'c_title' => esc_html__( 'Trusted Clients and Counting', 'finspire' ),
						'btn_title' => esc_html__( 'Read More', 'finspire' ),
					],
					[
						'subtitle' => esc_html__( 'Add your subtitle', 'finspire' ),
						'title' => esc_html__( 'Matching Talent with Ideal<br> Opportunities.', 'finspire' ),
						'text' => esc_html__( 'Trouble that are bound to ensue and equal that<br> shrinking from toil and pain.', 'finspire' ),
						'count' => esc_html__( '100+', 'finspire' ),
						'c_title' => esc_html__( 'Trusted Clients and Counting', 'finspire' ),
						'btn_title' => esc_html__( 'Read More', 'finspire' ),
					],
				],
			]
		);	
		
		$repeater = new Repeater();
		$repeater->add_control(
			'images',
			[
				'label' => __( 'Banner Image', 'finspire' ),
				'type' => Controls_Manager::MEDIA,
				'default' => ['url' => Utils::get_placeholder_image_src(),],
			]
		);
		$repeater->add_control(
			'title2',
			[
				'label'       => __( 'Title', 'finspire' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Title', 'finspire' ),
			]
		);
		$repeater->add_control(
			'btn_title2',
			[
				'label'       => __( 'Button Title', 'finspire' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Button Title', 'finspire' ),
			]
		);
		$repeater->add_control(
			'link_option2',
			[
				'label'   => esc_html__( 'Select link Option', 'finspire' ),
				'label_block' => true,
				'type'    => Controls_Manager::SELECT,
				'default' => 'extranal',
				'options' => array(
					'extranal' => esc_html__( 'Extranal ', 'finspire'),
					'page' => esc_html__( 'Page ', 'finspire'),
				),
			]
		);
		$repeater->add_control(
			'link2',
			[
				'label' => __( 'External Link', 'finspire' ),
				'type' => Controls_Manager::URL,
				'label_block' => true, 
				'placeholder' => __( 'https://your-link.com', 'finspire' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
				'condition'   => [
					'link_option2' => 'extranal'
				]
			]
		);
		$repeater->add_control(
			'page_select2',
			[
				'label'   => esc_html__( 'Select Page', 'finspire' ),
				'label_block' => true,
				'type'    => Controls_Manager::SELECT,
				'default' => 'extranal',
				'options' => finspire_page_list(),
				'condition'   => [
					'link_option2' => 'page'
				]
			]
		);
		$repeater->add_control(
			'text2',
			[
				'label'       => __( 'Text', 'finspire' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Text', 'finspire' ),
			]
		);
		$repeater->add_control(
			'image2',
			[
				'label' => __( 'Author Image 01', 'finspire' ),
				'type' => Controls_Manager::MEDIA,
				'default' => ['url' => Utils::get_placeholder_image_src(),],
			]
		);
		$repeater->add_control(
			'image3',
			[
				'label' => __( 'Author Image 02', 'finspire' ),
				'type' => Controls_Manager::MEDIA,
				'default' => ['url' => Utils::get_placeholder_image_src(),],
			]
		);
		$repeater->add_control(
			'image4',
			[
				'label' => __( 'Author Image 03', 'finspire' ),
				'type' => Controls_Manager::MEDIA,
				'default' => ['url' => Utils::get_placeholder_image_src(),],
			]
		);
		$repeater->add_control(
			'text3',
			[
				'label'       => __( 'Text 02', 'finspire' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Text', 'finspire' ),
			]
		);
		
				
		$this->add_control(
			'slide_v2',
			[
				'label'                 => __('Add Slide Item', 'finspire'),
				'type'                  => Controls_Manager::REPEATER,
				'fields'                => $repeater->get_controls(),
				'condition'   => [
					'layout_control' => '2'
				],
				'title_field' => '{{{ title2 }}}',
				'default' => [
					[
						'subtitle2' => esc_html__( 'Solutions we provide', 'finspire' ),
						'title2' => esc_html__( 'Looking for the<br>best employees? We<br>have them.', 'finspire' ),
						'text2' => esc_html__( 'Trouble that are bound to ensue and equal that shrinking.', 'finspire' ),
						'btn_title2' => esc_html__( 'Read More', 'finspire' ),
					],
					[
						'subtitle2' => esc_html__( 'Solutions we provide', 'finspire' ),
						'title2' => esc_html__( 'Find the right<br> employer for you<br> to thrive.', 'finspire' ),
						'text2' => esc_html__( 'Some advantage from it? But who has any right to find.', 'finspire' ),
						'btn_title2' => esc_html__( 'Read More', 'finspire' ),
					],
					[
						'subtitle2' => esc_html__( 'Solutions we provide', 'finspire' ),
						'title2' => esc_html__( 'End the search<br> for a new job, We<br> are hiring.', 'finspire' ),
						'text2' => esc_html__( 'Some advantage from it? But who has any right to find.', 'finspire' ),
						'btn_title2' => esc_html__( 'Read More', 'finspire' ),
					],
				],
			]
		);
		
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
            'icons_style_setting',
            [
                'label' => esc_html__( 'Subtitle Style Setting', 'finspire' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_subtitle_controls();
        
        $this->end_controls_section();
		
		//text Style Start ****************
        $this->start_controls_section(
            'icons_style_setting',
            [
                'label' => esc_html__( 'Icon Style Setting', 'finspire' ),
				'condition' => [ 'layout_control' => ['1'], ],
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_icons_controls();
        
        $this->end_controls_section();
		
		//text Style Start ****************
        $this->start_controls_section(
            'text_style_setting',
            [
                'label' => esc_html__( 'Text Style Setting', 'finspire' ),
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
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_button_controls();
        
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
        $allowed_tags = wp_kses_allowed_html('post');
		
	?>

	<?php if($settings['layout_control'] == '2') : ?>

	<section class="banner-style-four pl_100 pr_100">
		<div class="outer-container">
			<div class="banner-carousel p_relative">
				<div class="swiper-wrapper">
					<?php 
						foreach($settings['slide_v2'] as $key => $item): 

						$page2 = $item['link_option2'];
						$page_select2 = $item[ 'page_select2' ];
						$ext_url2 = $item[ 'link2' ];

						if( $page2 == 'page' ){
							$mount_link2 = get_page_link( $page_select2 );
						}else{
							$mount_link2 = $ext_url2['url'];
							$target = $ext_url2['is_external'] ? ' target="_blank"' : '';
							$nofollow = $ext_url2['nofollow'] ? ' rel="nofollow"' : '';
						}
		
						// block_img 4
						$feature_img4  = $item['images']; 
						if( !empty($feature_img4['id']) ){
							$mount_fimg4 = wp_get_attachment_url($feature_img4['id']);
						} else {
							$mount_fimg4 = $feature_img4['url'];
						}

						// block_img 5
						$feature_img5  = $item['image2']; 
						if( !empty($feature_img5['id']) ){
							$mount_fimg5 = wp_get_attachment_url($feature_img5['id']);
						} else {
							$mount_fimg5 = $feature_img5['url'];
						}

						// block_img 6
						$feature_img6  = $item['image3']; 
						if( !empty($feature_img6['id']) ){
							$mount_fimg6 = wp_get_attachment_url($feature_img6['id']);
						} else {
							$mount_fimg6 = $feature_img6['url'];
						}

						// block_img 7
						$feature_img7  = $item['image4']; 
						if( !empty($feature_img7['id']) ){
							$mount_fimg7 = wp_get_attachment_url($feature_img7['id']);
						} else {
							$mount_fimg7 = $feature_img7['url'];
						}
		
					?>
					<div class="swiper-slide">
						<div class="slide-box">
							<div class="bg-layer te-img" style="background-image: url(<?php echo esc_url( $mount_fimg4 );?>);"></div>
							<div class="slider-content">
								<?php if($item['title2']) { ?><h2 class="te-title"><?php echo wp_kses( $item[ 'title2'], true  );?></h2><?php } ?>
								<div class="inner-box">
									<?php if($item['btn_title2']) { ?>
									<div class="link-box">
										<a class="te-btn" href="<?php echo esc_url( $mount_link2 );?>" <?php if( $page2 == 'extranal' ) echo esc_attr( $target );?> <?php if( $page2 == 'extranal' ) echo esc_attr( $nofollow );?>><i class="flaticon-two-lines"></i><span><?php echo wp_kses( $item[ 'btn_title2'], true  );?></span></a>
									</div>
									<?php } ?>
									<div class="inner">
										<?php if($item['text2']) { ?><p class="te-text"><?php echo wp_kses( $item[ 'text2'], true  );?></p><?php } ?>
										<div class="author-box">
											<ul class="clients-list">
												<li><img src="<?php echo esc_url( $mount_fimg5 );?>" alt="<?php bloginfo( 'name' ); ?>"></li>
												<li><img src="<?php echo esc_url( $mount_fimg6 );?>" alt="<?php bloginfo( 'name' ); ?>"></li>
												<li><img src="<?php echo esc_url( $mount_fimg7 );?>" alt="<?php bloginfo( 'name' ); ?>"></li>
											</ul>
											<?php if($item['text3']) { ?><p class="te-subtitle"><?php echo wp_kses( $item[ 'text3'], true  );?></p><?php } ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
				<div class="swiper-nav">
					<div class="swiper-prev"><i class="flaticon-two-lines"></i></div>
					<div class="swiper-next"><i class="flaticon-two-lines"></i></div>
				</div>
			</div>
		</div>
	</section>

	<?php else: 
		// block_img 3
		$feature_img3  = $settings['image'];
		if( !empty($feature_img3['id']) ){
			$mount_fimg3 = wp_get_attachment_url($feature_img3['id']);
		} else {
			$mount_fimg3 = $feature_img3['url'];
		}
	?>

	<section class="banner-style-three">
		<div class="outer-container">
			<div class="pattern-layer" style="background-image: url(<?php echo esc_url( $mount_fimg3 );?>);"></div>
			<div class="single-item-carousel p_relative">
				<div class="swiper-wrapper">
					<?php 
						foreach($settings['slide'] as $key => $item): 

						$page = $item['link_option'];
						$page_select = $item[ 'page_select' ];
						$ext_url = $item[ 'link' ];

						if( $page == 'page' ){
							$mount_link = get_page_link( $page_select );
						}else{
							$mount_link = $ext_url['url'];
							$target = $ext_url['is_external'] ? ' target="_blank"' : '';
							$nofollow = $ext_url['nofollow'] ? ' rel="nofollow"' : '';
						}

						// block_img
						$feature_img  = $item['banner_image'];
						if( !empty($feature_img['id']) ){
							$mount_fimg = wp_get_attachment_url($feature_img['id']);
						} else {
							$mount_fimg = $feature_img['url'];
						}

						// block_img 2
						$feature_img2  = $item['banner_image2'];
						if( !empty($feature_img2['id']) ){
							$mount_fimg2 = wp_get_attachment_url($feature_img2['id']);
						} else {
							$mount_fimg2 = $feature_img2['url'];
						}

					?>
					<div class="swiper-slide">
						<div class="row clearfix">
							<div class="col-lg-6 col-md-12 col-sm-12 content-column">
								<div class="content-box">
									<div class="shape" style="background-image: url(<?php echo esc_url( $mount_fimg );?>);"></div>
									<ul class="rating">
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
									<?php if($item['subtitle']) { ?><h6 class="te-subtitle"><?php echo wp_kses( $item[ 'subtitle'], true  );?></h6><?php } ?>
									<?php if($item['title']) { ?><h2 class="te-title"><?php echo wp_kses( $item[ 'title'], true  );?></h2><?php } ?>
									<div class="inner-box">
										<?php if($item['text']) { ?>
										<div class="text-box">
											<p class="te-text"><?php echo wp_kses( $item[ 'text'], true  );?></p>
										</div>
										<?php } ?>
										<div class="clients-box">
											<div class="icon-box te-icon">
												<?php if( isset( $item['icons']['library'] ) && 'svg' === $item['icons']['library'] ) {?>
													<?php \Elementor\Icons_Manager::render_icon( $item[ 'icons' ] ); ?>
												<?php } else {?>
													<i class="<?php echo esc_attr( $item[ 'icons' ][ 'value' ] );?>"></i>
												<?php };?>
											</div>
											<?php if($item['count'] || $item['c_title']) { ?>
											<div class="inner">
												<?php if($item['title']) { ?><div class="count-box"><?php echo wp_kses( $item[ 'count'], true  );?></div><?php } ?>
												<?php if($item['c_title']) { ?><h5><?php echo wp_kses( $item[ 'c_title'], true  );?></h5><?php } ?>
											</div>
											<?php } ?>
										</div>
									</div>
									<?php if($item['btn_title']) { ?>
									<div class="btn-box">
										<a href="<?php echo esc_url( $mount_link );?>" <?php if( $page == 'extranal' ) echo esc_attr( $target );?> <?php if( $page == 'extranal' ) echo esc_attr( $nofollow );?> class="theme-btn dark-bg te-btn"><div class="icon-box"><span class="static-icon"><i class="flaticon-two-lines"></i></span><span class="overlay-icon"><i class="flaticon-two-lines"></i></span></div><span class="text"><?php echo wp_kses( $item[ 'btn_title'], true  );?></span></a>
									</div>
									<?php } ?>
								</div>
							</div>
							<div class="col-lg-6 col-md-12 col-sm-12 image-column">
								<div class="image-box">
									<figure class="image"><img class="te-img" src="<?php echo esc_url( $mount_fimg2 );?>" alt="<?php bloginfo( 'name' ); ?>"></figure>
								</div>
							</div>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
				<div class="swiper-nav">
					<div class="swiper-prev"><i class="flaticon-two-lines"></i><span>Prev</span></div>
					<div class="swiper-next"><span>Next</span><i class="flaticon-two-lines"></i></div>
				</div>
			</div>
		</div>
	</section>
        
    <?php endif;
    }
}
 