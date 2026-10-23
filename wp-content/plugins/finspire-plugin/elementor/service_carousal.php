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
class Service_Carousal extends Widget_Base {

    /**
     * Get widget name.
     * Retrieve button widget name.
     *
     * @since  1.0.0
     * @access public
     * @return string Widget name.
     */
    public function get_name() {
        return 'finspire_service_carousal';
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
        return esc_html__( 'Finspire Service Carousal', 'finspire' );
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
            'service_carousal',
            [
                'label' => esc_html__( 'Service Carousal', 'finspire' ),
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
			'block_img2',
			[
				'label' => __( 'Background Image 01', 'finspire' ),
				'condition' => [ 'layout_control' => ['2'], ],
				'type' => Controls_Manager::MEDIA,
				'default' => ['url' => Utils::get_placeholder_image_src(),],
			]
		);
		$this->add_control(
			'block_img3',
			[
				'label' => __( 'Background Image 02', 'finspire' ),
				'condition' => [ 'layout_control' => ['2'], ],
				'type' => Controls_Manager::MEDIA,
				'default' => ['url' => Utils::get_placeholder_image_src(),],
			]
		);
		$this->add_control(
			'p_title',
			[
				'label'       => __( 'Pagination Title 01', 'finspire' ),
				'condition' => [ 'layout_control' => ['2'], ],
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Title', 'finspire' ),
				'default' => esc_html__( 'Pagination Title', 'finspire' ),
			]
		);
		$this->add_control(
			'p_title2',
			[
				'label'       => __( 'Pagination Title 02', 'finspire' ),
				'condition' => [ 'layout_control' => ['2'], ],
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Title', 'finspire' ),
				'default' => esc_html__( 'Pagination Title', 'finspire' ),
			]
		);
		
		//Banner SLide Repeater
		$repeater = new Repeater();
		$repeater->add_control(
			'banner_image',
			[
				'label' => __( 'Image', 'finspire' ),
				'type' => Controls_Manager::MEDIA,
				'default' => ['url' => Utils::get_placeholder_image_src(),],
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
				'type'    => Controls_Manager::SELECT2,
				'default' => 'extranal',
				'options' => finspire_page_list(),
				'condition'   => [
					'link_option' => 'page'
				]
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
						'title' => esc_html__( 'Service Title', 'finspire' ),
						'text' => esc_html__( 'Add your Text Here', 'finspire' ),
						'btn_title' => esc_html__( 'Read More', 'finspire' ),
					],
					[
						'title' => esc_html__( 'Service Title', 'finspire' ),
						'text' => esc_html__( 'Add your Text Here', 'finspire' ),
						'btn_title' => esc_html__( 'Read More', 'finspire' ),
					],
					[
						'title' => esc_html__( 'Service Title', 'finspire' ),
						'text' => esc_html__( 'Add your Text Here', 'finspire' ),
						'btn_title' => esc_html__( 'Read More', 'finspire' ),
					],
				],
			]
		);
		
		$repeater = new Repeater();
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
				'type'    => Controls_Manager::SELECT2,
				'default' => 'extranal',
				'options' => finspire_page_list(),
				'condition'   => [
					'link_option2' => 'page'
				]
			]
		);	
		$repeater->add_control(
			'subtitle2',
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
			'block_img4',
			[
				'label' => __( 'Icon Image', 'finspire' ),
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
			'block_img5',
			[
				'label' => __( 'Image', 'finspire' ),
				'type' => Controls_Manager::MEDIA,
				'default' => ['url' => Utils::get_placeholder_image_src(),],
			]
		);
		$repeater->add_control(
			'icons2',
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
			'f_title',
			[
				'label'       => __( 'Feature Title', 'finspire' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Feature Title', 'finspire' ),
			]
		);
		$repeater->add_control(
			'f_text',
			[
				'label'       => __( 'Feature Text', 'finspire' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Feature Text', 'finspire' ),
			]
		);
		$repeater->add_control(
			'f_title2',
			[
				'label'       => __( 'Feature Title 02', 'finspire' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Feature Title', 'finspire' ),
			]
		);
		$repeater->add_control(
			'f_text2',
			[
				'label'       => __( 'Feature Text 02', 'finspire' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Feature Text', 'finspire' ),
			]
		);
		$this->add_control(
			'slide_v2',
			[
				'label'                 => __('Add Slide Item', 'finspire'),
				'condition' => [ 'layout_control' => ['2'], ],
				'type'                  => Controls_Manager::REPEATER,
				'fields'                => $repeater->get_controls(),
				'title_field' => '{{{ title2 }}}',
				'default' => [
					[
						'title2' => esc_html__( 'Service Title', 'finspire' ),
						'subtitle' => esc_html__( 'Add your Subtitle Here', 'finspire' ),
						'f_title' => esc_html__( 'Feature Title', 'finspire' ),
						'f_title2' => esc_html__( 'Feature Title', 'finspire' ),
						'text2' => esc_html__( 'Add your Text Here', 'finspire' ),
						'f_text' => esc_html__( 'Add your Feature Text Here', 'finspire' ),
						'f_text2' => esc_html__( 'Add your Feature Text Here', 'finspire' ),
						'btn_title2' => esc_html__( 'Read More', 'finspire' ),
					],
					[
						'title2' => esc_html__( 'Service Title', 'finspire' ),
						'subtitle' => esc_html__( 'Add your Subtitle Here', 'finspire' ),
						'f_title' => esc_html__( 'Feature Title', 'finspire' ),
						'f_title2' => esc_html__( 'Feature Title', 'finspire' ),
						'text2' => esc_html__( 'Add your Text Here', 'finspire' ),
						'f_text' => esc_html__( 'Add your Feature Text Here', 'finspire' ),
						'f_text2' => esc_html__( 'Add your Feature Text Here', 'finspire' ),
						'btn_title2' => esc_html__( 'Read More', 'finspire' ),
					],
					[
						'title2' => esc_html__( 'Service Title', 'finspire' ),
						'subtitle' => esc_html__( 'Add your Subtitle Here', 'finspire' ),
						'f_title' => esc_html__( 'Feature Title', 'finspire' ),
						'f_title2' => esc_html__( 'Feature Title', 'finspire' ),
						'text2' => esc_html__( 'Add your Text Here', 'finspire' ),
						'f_text' => esc_html__( 'Add your Feature Text Here', 'finspire' ),
						'f_text2' => esc_html__( 'Add your Feature Text Here', 'finspire' ),
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
            'subtitle_style_setting',
            [
                'label' => esc_html__( 'Count Style Setting', 'finspire' ),
				'condition' => [ 'layout_control' => ['1'], ],
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_subtitle_controls();
        
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
		
		//Icon Style Start ***************
        $this->start_controls_section(
            'icons_style_setting',
            [
                'label' => esc_html__( 'Icon Style Setting', 'finspire' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_icons_controls();
        
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

	<?php if($settings['layout_control'] == '2') : 
		// block_img 2
		$feature_img2  = $settings['block_img2'];
		if( !empty($feature_img2['id']) ){
			$mount_fimg2 = wp_get_attachment_url($feature_img2['id']);
		} else {
			$mount_fimg2 = $feature_img2['url'];
		}
		
		// block_img 3
		$feature_img3  = $settings['block_img3'];
		if( !empty($feature_img3['id']) ){
			$mount_fimg3 = wp_get_attachment_url($feature_img3['id']);
		} else {
			$mount_fimg3 = $feature_img3['url'];
		}
	?>

	<div class="service-style-two p-0 m-0">
		<div class="main-content p_relative">
			<div class="nav-btn-bg">
				<div class="bg-1" style="background-image: url(<?php echo esc_url( $mount_fimg2 );?>);"></div>
				<div class="bg-2" style="background-image: url(<?php echo esc_url( $mount_fimg3 );?>);"></div>
			</div>
			<div class="single-item-carousel">
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
						$feature_img4  = $item['block_img4'];
						if( !empty($feature_img4['id']) ){
							$mount_fimg4 = wp_get_attachment_url($feature_img4['id']);
						} else {
							$mount_fimg4 = $feature_img4['url'];
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
						<div class="upper-box p_relative">
							<?php if($item['btn_title2']) { ?>
							<div class="common-link p_absolute r_0 t_25"><a class="te-btn" href="<?php echo esc_url( $mount_link2 );?>" <?php if( $page2 == 'extranal' ) echo esc_attr( $target );?> <?php if( $page2 == 'extranal' ) echo esc_attr( $nofollow );?>><div class="icon-box"><span class="static-icon"><i class="flaticon-two-lines"></i></span><span class="overlay-icon"><i class="flaticon-two-lines"></i></span></div><span><?php echo wp_kses( $item[ 'btn_title2'], true  );?></span></a></div>
							<?php } ?>
							<div class="row clearfix">
								<div class="col-lg-4 col-md-6 col-sm-12 title-text">
									<div class="text">
										<?php if($item['subtitle2']) { ?><p><?php echo wp_kses( $item[ 'subtitle2'], true  );?></p><?php } ?>
										<img src="<?php echo esc_url( $mount_fimg4 );?>" alt="<?php bloginfo( 'name' ); ?>">
									</div>
								</div>
								<?php if($item['title2']) { ?>
								<div class="col-lg-6 col-md-6 col-sm-12 title-text">
									<h3 class="te-title"><?php echo wp_kses( $item[ 'title2'], true  );?></h3>
								</div>
								<?php } ?>
							</div>
						</div>
						<div class="lower-box">
							<div class="row clearfix">
								<div class="col-lg-4 col-md-6 col-sm-12 left-column">
									<div class="left-content">
										<?php if($item['text2']) { ?><p class="te-text"><?php echo wp_kses( $item[ 'text2'], true  );?></p><?php } ?>
										<figure class="image-box"><img class="te-img" src="<?php echo esc_url( $mount_fimg5 );?>" alt="<?php bloginfo( 'name' ); ?>"></figure>
									</div>
								</div>
								<div class="col-lg-8 col-md-6 col-sm-12 right-column">
									<div class="right-content">
										<div class="big-icon"><i class="flaticon-risk"></i></div>
										<?php if($item['f_title'] || $item['f_text']) { ?>
										<div class="single-item">
											<div class="icon-box"><i class="flaticon-check"></i></div>
											<?php if($item['f_title']) { ?><h3><?php echo wp_kses( $item[ 'f_title'], true  );?></h3><?php } ?>
											<?php if($item['f_text']) { ?><p class="te-text"><?php echo wp_kses( $item[ 'f_text'], true  );?></p><?php } ?>
										</div>
										<?php } ?>
										<?php if($item['f_title2'] || $item['f_text2']) { ?>
										<div class="single-item">
											<div class="icon-box te-icon">
												<?php if( isset( $item['icons2']['library'] ) && 'svg' === $item['icons2']['library'] ) {?>
													<?php \Elementor\Icons_Manager::render_icon( $item[ 'icons2' ] ); ?>
												<?php } else {?>
													<i class="<?php echo esc_attr( $item[ 'icons2' ][ 'value' ] );?>"></i>
												<?php };?>
											</div>
											<?php if($item['f_title2']) { ?><h3><?php echo wp_kses( $item[ 'f_title2'], true  );?></h3><?php } ?>
											<?php if($item['f_text2']) { ?><p class="te-text"><?php echo wp_kses( $item[ 'f_text2'], true  );?></p><?php } ?>
										</div>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
				<div class="pagination-box">
					<span class="text">/03</span>
					<div class="single-column-pagination"></div>
				</div>
				
				<?php if($settings[ 'p_title'] || $settings[ 'p_title2']) { ?>
				<div class="swiper-nav">
					<?php if($settings[ 'p_title']) { ?>
					<div class="swiper-prev"><i class="flaticon-right-arrow"></i> <h3><?php echo wp_kses( $settings[ 'p_title'], true  );?></h3></div>
					<?php } ?>
					<?php if($settings[ 'p_title2']) { ?>
					<div class="swiper-next"><i class="flaticon-right-arrow"></i> <h3><?php echo wp_kses( $settings[ 'p_title2'], true  );?></h3></div>
					<?php } ?>
				</div>
				<?php } ?>
				
			</div>
			
		</div>
	</div>

	<?php else: ?>

	<section class="service-section p-0 m-0">
		<div class="three-item-carousel">
			<div class="swiper-wrapper">
				<?php $jk = 1; 
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

				?>
				<div class="swiper-slide">
					<div class="service-block-one">
						<div class="static-content">
							<div class="image-box">
								<figure class="image"><img class="te-img" src="<?php echo esc_url( $mount_fimg );?>" alt="<?php bloginfo( 'name' ); ?>"></figure>
								<div class="link p_absolute b_25 r_25"><a href="<?php echo esc_url( $mount_link );?>" <?php if( $page == 'extranal' ) echo esc_attr( $target );?> <?php if( $page == 'extranal' ) echo esc_attr( $nofollow );?>><i class="flaticon-two-lines"></i></a></div>
							</div>
							<div class="content-box">
								<span class="count-text te-subtitle"><?php $jk = sprintf('%02d', $jk); echo $jk; ?></span>
								<?php if($item['title']) { ?><h3 class="te-title"><?php echo wp_kses( $item[ 'title'], true  );?></h3><?php } ?>
								<div class="icon-box te-icon">
									<?php if( isset( $item['icons']['library'] ) && 'svg' === $item['icons']['library'] ) {?>
										<?php \Elementor\Icons_Manager::render_icon( $item[ 'icons' ] ); ?>
									<?php } else {?>
										<i class="<?php echo esc_attr( $item[ 'icons' ][ 'value' ] );?>"></i>
									<?php };?>
								</div>
							</div>
						</div>
						<div class="overlay-content">
							<div class="bg-layer" style="background-image: url(<?php echo esc_url( $mount_fimg );?>);"></div>
							<span class="count-text"><?php $jk = sprintf('%02d', $jk); echo $jk; ?></span>
							<?php if($item['text']) { ?><p class="te-text"><?php echo wp_kses( $item[ 'text'], true  );?></p><?php } ?>
							<?php if($item['title']) { ?>
							<h3><a href="<?php echo esc_url( $mount_link );?>" <?php if( $page == 'extranal' ) echo esc_attr( $target );?> <?php if( $page == 'extranal' ) echo esc_attr( $nofollow );?>><?php echo wp_kses( $item[ 'title'], true  );?></a></h3>
							<?php } ?>
							<?php if($item['btn_title']) { ?>
							<div class="btn-box"><a href="<?php echo esc_url( $mount_link );?>" <?php if( $page == 'extranal' ) echo esc_attr( $target );?> <?php if( $page == 'extranal' ) echo esc_attr( $nofollow );?> class="theme-btn theme-bg te-btn"><div class="icon-box"><span class="static-icon"><i class="flaticon-two-lines"></i></span><span class="overlay-icon"><i class="flaticon-two-lines"></i></span></div><span class="text"><?php echo wp_kses( $item[ 'btn_title'], true  );?></span></a></div>
							<?php } ?>
						</div>
					</div>
				</div>
				<?php $jk++; endforeach; ?>
			</div>
			<div class="three-item-pagination dots-style-one centred"></div>
		</div>
	</section>
        
    <?php endif;
    }
}
 