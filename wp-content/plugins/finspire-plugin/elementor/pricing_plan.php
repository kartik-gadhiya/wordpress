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
use \Elementor\Group_Control_Text_Stroke;
use Elementor\Plugin;
use Finspire\Elementor\Traits\Trait_Title;
use Finspire\Elementor\Traits\Trait_Text;
use Finspire\Elementor\Traits\Trait_Button;
use Finspire\Elementor\Traits\Trait_SubTitle;

/**
 * Elementor button widget.
 * Elementor widget that displays a button with the ability to control every
 * aspect of the button design.
 *
 * @since 1.0.0
 */
class Pricing_Plan extends Widget_Base {

    /**
     * Get widget name.
     * Retrieve button widget name.
     *
     * @since  1.0.0
     * @access public
     * @return string Widget name.
     */
    public function get_name() {
        return 'finspire_pricing_plan';
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
        return esc_html__( 'Finspire Pricing Plan', 'finspire' );
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
	use Trait_Title, Trait_Text, Trait_Button, Trait_SubTitle;
    protected function register_controls() {
		$this->start_controls_section(
            'generaly_tab_yearly',
            [
                'label' => esc_html__( 'General', 'finspire' ),
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
			'sub_title',
			[
				'label'       => __( 'Sub Title', 'finspire' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'default'     => __( 'Pricing & Plan', 'finspire' ),
				'placeholder' => __( 'Enter your subtitle here', 'finspire' ),
			]
		);
		$this->add_control(
			'title',
			[
				'label'       => __( 'Title', 'finspire' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'default'     => __( 'Tailored Pricing Solutions', 'finspire' ),
				'placeholder' => __( 'Enter your title here', 'finspire' ),
			]
		);
		$this->end_controls_section();
		
		$this->start_controls_section(
            'pricing_tab_monthly',
            [
                'label' => esc_html__( 'Pricing Tabs', 'finspire' ),
            ]
        );		
		
		$this->start_controls_tabs( 'finspire_tabs_package_plans' );
			
			//Tab Control Start
			$this->start_controls_tab(
				'finspire_tab_left_panel',
				[
					'label' => __( 'Monthly Tabs', 'finspire' ),
				]
			);
			$this->add_control(
				'tab_title',
				[
					'label'       => __( 'Tab Title', 'finspire' ),
					'type'        => Controls_Manager::TEXT,
					'label_block' => true,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => __( 'Monthly', 'finspire' ),
					'placeholder' => __( 'Enter your tab title here', 'finspire' ),
				]
			);
			$repeater = new Repeater();	
			$repeater->add_control(
				'data_title',
				[
					'label'       => __( 'Title', 'finspire' ),
					'type'        => Controls_Manager::TEXT,
					'label_block' => true,
					'dynamic'     => [
						'active' => true,
					],
					'placeholder' => __( 'Enter your title here', 'finspire' ),
				]
			);	
			$repeater->add_control(
				'data_text',
				[
					'label'       => __( 'Text', 'finspire' ),
					'type'        => Controls_Manager::TEXTAREA,
					'label_block' => true,
					'dynamic'     => [
						'active' => true,
					],
					'placeholder' => __( 'Enter your text here', 'finspire' ),
				]
			);
			$repeater->add_control(
				'data_price',
				[
					'label'       => __( 'Price', 'finspire' ),
					'type'        => Controls_Manager::TEXTAREA,
					'label_block' => true,
					'dynamic'     => [
						'active' => true,
					],
					'placeholder' => __( 'Enter your tab price here', 'finspire' ),
				]
			);	
			$repeater->add_control(
				'data_month',
				[
					'label'       => __( 'Duration', 'finspire' ),
					'type'        => Controls_Manager::TEXT,
					'label_block' => true,
					'dynamic'     => [
						'active' => true,
					],
					'placeholder' => __( 'Enter your Duration here', 'finspire' ),
				]
			);	
			$repeater->add_control(
				'subtitle',
				[
					'label'       => __( 'Sub Title', 'finspire' ),
					'type'        => Controls_Manager::TEXT,
					'label_block' => true,
					'dynamic'     => [
						'active' => true,
					],
					'placeholder' => __( 'Enter your Sub Title here', 'finspire' ),
				]
			);	
			$repeater->add_control(
				'features_list',
				[
					'label'       => __( 'Feature List', 'finspire' ),
					'type'        => Controls_Manager::TEXTAREA,
					'label_block' => true,
					'dynamic'     => [
						'active' => true,
					],
					'placeholder' => __( 'Enter your feature list here', 'finspire' ),
				]
			);			
			$repeater->add_control(
				'data_btn_title',
				[
					'label'       => __( 'Button Title', 'finspire' ),
					'type'        => Controls_Manager::TEXT,
					'label_block' => true,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => __( 'Explore More', 'finspire' ),
					'placeholder' => __( 'Enter your button title here', 'finspire' ),
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
				'standard_list',
				[
					'label'                 => __('Add Monthly Item', 'finspire'),
					'type'                  => Controls_Manager::REPEATER,
					'fields'                => $repeater->get_controls(),
					'title_field' => '{{{ data_title }}}',
					'default' => [
						[
							'data_price' => esc_html__( '<sup>$</sup>6.8<sup>k</sup>', 'finspire' ),
							'data_month' => esc_html__( '/ Monthly', 'finspire' ),
							'data_title' => esc_html__( 'Temporary', 'finspire' ),							
							'data_btn_title'  => esc_html__( 'Explore More', 'finspire' ),
							'data_text'  => esc_html__( '<sup>*</sup>Highlight something here', 'finspire' ),
						],
						[
							'data_price' => esc_html__( '<sup>$</sup>9.5<sup>k</sup>', 'finspire' ),
							'data_month' => esc_html__( '/ Monthly', 'finspire' ),
							'data_title' => esc_html__( 'Contract', 'finspire' ),							
							'data_btn_title'  => esc_html__( 'Explore More', 'finspire' ),
							'data_text'  => esc_html__( '<sup>*</sup>Highlight something here', 'finspire' ),
						],
						[
							'data_price' => esc_html__( '<sup>$</sup>12<sup>k</sup>', 'finspire' ),
							'data_month' => esc_html__( '/ Monthly', 'finspire' ),
							'data_title' => esc_html__( 'Project Based', 'finspire' ),							
							'data_btn_title'  => esc_html__( 'Explore More', 'finspire' ),
							'data_text'  => esc_html__( '<sup>*</sup>Highlight something here', 'finspire' ),
						],
					],
				]
			);
			
			$this->end_controls_tab();
			
			//Tab Control Start
			$this->start_controls_tab(
				'finspire_tab_right_panel',
				[
					'label' => __( 'Yearly Tabs', 'finspire' ),
				]
			);
			$this->add_control(
				'tabs_title',
				[
					'label'       => __( 'Tab Title', 'finspire' ),
					'type'        => Controls_Manager::TEXT,
					'label_block' => true,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => __( 'Yearly', 'finspire' ),
					'placeholder' => __( 'Enter your tab title here', 'finspire' ),
				]
			);
			$repeater = new Repeater();
			$repeater->add_control(
				'data_titles',
				[
					'label'       => __( 'Title', 'finspire' ),
					'type'        => Controls_Manager::TEXT,
					'label_block' => true,
					'dynamic'     => [
						'active' => true,
					],
					'placeholder' => __( 'Enter your title here', 'finspire' ),
				]
			);	
			$repeater->add_control(
				'data_texts',
				[
					'label'       => __( 'Text', 'finspire' ),
					'type'        => Controls_Manager::TEXTAREA,
					'label_block' => true,
					'dynamic'     => [
						'active' => true,
					],
					'placeholder' => __( 'Enter your text here', 'finspire' ),
				]
			);
			$repeater->add_control(
				'data_prices',
				[
					'label'       => __( 'Price', 'finspire' ),
					'type'        => Controls_Manager::TEXTAREA,
					'label_block' => true,
					'dynamic'     => [
						'active' => true,
					],
					'placeholder' => __( 'Enter your tab price here', 'finspire' ),
				]
			);	
			$repeater->add_control(
				'data_months',
				[
					'label'       => __( 'Duration', 'finspire' ),
					'type'        => Controls_Manager::TEXT,
					'label_block' => true,
					'dynamic'     => [
						'active' => true,
					],
					'placeholder' => __( 'Enter your Duration here', 'finspire' ),
				]
			);	
			$repeater->add_control(
				'subtitles',
				[
					'label'       => __( 'Sub Title', 'finspire' ),
					'type'        => Controls_Manager::TEXT,
					'label_block' => true,
					'dynamic'     => [
						'active' => true,
					],
					'placeholder' => __( 'Enter your Sub Title here', 'finspire' ),
				]
			);
			$repeater->add_control(
				'features_lists',
				[
					'label'       => __( 'Feature List', 'finspire' ),
					'type'        => Controls_Manager::TEXTAREA,
					'label_block' => true,
					'dynamic'     => [
						'active' => true,
					],
					'placeholder' => __( 'Enter your feature list here', 'finspire' ),
				]
			);			
			$repeater->add_control(
				'data_btn_titles',
				[
					'label'       => __( 'Button Title', 'finspire' ),
					'type'        => Controls_Manager::TEXT,
					'label_block' => true,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => __( 'Explore More', 'finspire' ),
					'placeholder' => __( 'Enter your button title here', 'finspire' ),
				]
			);					
			$repeater->add_control(
				'link_options',
				[
					'label'   => esc_html__( 'Select link Option', 'finspire' ),
					'label_block' => true,
					'type'    => Controls_Manager::SELECT,
					'default' => 'extranals',
					'options' => array(
						'extranals' => esc_html__( 'Extranal ', 'finspire'),
						'pages' => esc_html__( 'Page ', 'finspire'),
					),
				]
			);		
			$repeater->add_control(
				'links',
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
						'link_options' => 'extranals'
					]
				]
			);		
			$repeater->add_control(
				'page_selects',
				[
					'label'   => esc_html__( 'Select Page', 'finspire' ),
					'label_block' => true,
					'type'    => Controls_Manager::SELECT2,
					'default' => 'extranals',
					'options' => finspire_page_list(),
					'condition'   => [
						'link_options' => 'pages'
					]
				]
			);
						
			$this->add_control(
				'premium_list',
				[
					'label'                 => __('Add Yearly Item', 'finspire'),
					'type'                  => Controls_Manager::REPEATER,
					'fields'                => $repeater->get_controls(),
					'title_field' => '{{{ data_titles }}}',
					'default' => [
						[
							'data_prices' => esc_html__( '<sup>$</sup>16.5<sup>k</sup>', 'finspire' ),
							'data_months' => esc_html__( '/ Monthly', 'finspire' ),
							'data_titles' => esc_html__( 'Temporary', 'finspire' ),							
							'data_btn_titles'  => esc_html__( 'Explore More', 'finspire' ),
							'data_texts'  => esc_html__( '<sup>*</sup>Highlight something here', 'finspire' ),
						],
						[
							'data_prices' => esc_html__( '<sup>$</sup>99<sup>k</sup>', 'finspire' ),
							'data_months' => esc_html__( '/ Monthly', 'finspire' ),
							'data_titles' => esc_html__( 'Contract', 'finspire' ),							
							'data_btn_titles'  => esc_html__( 'Explore More', 'finspire' ),
							'data_texts'  => esc_html__( '<sup>*</sup>Highlight something here', 'finspire' ),
						],
						[
							'data_prices' => esc_html__( '<sup>$</sup>35<sup>k</sup>', 'finspire' ),
							'data_months' => esc_html__( '/ Monthly', 'finspire' ),
							'data_titles' => esc_html__( 'Project Based', 'finspire' ),							
							'data_btn_titles'  => esc_html__( 'Explore More', 'finspire' ),
							'data_texts'  => esc_html__( '<sup>*</sup>Highlight something here', 'finspire' ),
						],
					],
				]
			);
			
			$this->end_controls_tab();
		
		$this->end_controls_tabs();
		
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
		
		//Image Style Start ***************
        $this->start_controls_section(
            'image_style_setting',
            [
                'label' => esc_html__( 'Button Style', 'finspire' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_button_controls();
        
        $this->end_controls_section();
		
		$this->start_controls_section(
            'image2_style_setting',
            [
                'label' => esc_html__( 'Price Style', 'finspire' ),
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
                'label' => esc_html__( 'List Style Setting', 'finspire' ),
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
        $allowed_tags = wp_kses_allowed_html('post');		
	?>

	<?php if($settings['layout_control'] == '2') : ?>

	<section class="pricing-section style-two p-0 m-0">
		<div class="tabs-box-2">
			<div class="title-box flexbox_2 mb_50">
				<?php if($settings['sub_title'] || $settings['title']) { ?>
				<div class="sec-title">
					<?php if($settings['sub_title']) { ?><span class="sub-title"><?php echo wp_kses( $settings[ 'sub_title' ], true );?></span><?php } ?>
					<?php if($settings['title']) { ?><h2><?php echo wp_kses( $settings[ 'title' ], true );?></h2><?php } ?>
				</div>
				<?php } ?>
				<?php if($settings['tab_title'] || $settings['tabs_title']) { ?>
				<ul class="tab-btns tab-buttons">
					<?php if($settings['tab_title']) { ?><li class="tab-btn active-btn" data-tab="#pric-tab-4"><?php echo wp_kses( $settings[ 'tab_title' ], true );?></li><?php } ?>
					<?php if($settings['tabs_title']) { ?><li class="tab-btn" data-tab="#pric-tab-5"><?php echo wp_kses( $settings[ 'tabs_title' ], true );?></li><?php } ?>
				</ul>
				<?php } ?>
			</div>
			<div class="tabs-content">
				<div class="tab active-tab" id="pric-tab-4">
					<?php 
						foreach( $settings[ 'standard_list' ] as $key => $item ):

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

					?>
					<div class="pricing-block-two <?php if($key == 1) echo 'active-block';?>">
						<div class="inner-box">
							<div class="title-box">
								<?php if($item['data_title']) { ?><h3 class="te-title"><?php echo wp_kses( $item[ 'data_title' ], true );?></h3><?php } ?>
								<?php if($item['data_text']) { ?><p><?php echo wp_kses( $item[ 'data_text' ], true );?></p><?php } ?>
								<?php if($item['data_price'] || $item['data_month']) { ?>
								<h2 class="te-subtitle"><?php echo wp_kses( $item[ 'data_price' ], true );?> <span><?php echo wp_kses( $item[ 'data_month' ], true );?></span></h2>
								<?php } ?>
							</div>
							<div class="feature-box">
								<?php 
								$features_list = $item['features_list'];

								if (!empty($features_list)) {
									$features_list = explode("\n", $features_list);

									// Split into two halves
									$total = count($features_list);
									$half = ceil($total / 2);

									$first_half = array_slice($features_list, 0, $half);
									$second_half = array_slice($features_list, $half);
								?>

									<ul class="feature-list mb_10">
										<?php foreach ($first_half as $feature): ?>
											<li>
												<i class="flaticon-round"></i>
												<span class="te-text"><?php echo wp_kses($feature, true); ?></span>
											</li>
										<?php endforeach; ?>
									</ul>

									<ul class="feature-list">
										<?php foreach ($second_half as $feature): ?>
											<li>
												<i class="flaticon-round"></i>
												<span class="te-text"><?php echo wp_kses($feature, true); ?></span>
											</li>
										<?php endforeach; ?>
									</ul>

								<?php } ?>
							</div>
							<?php if($item['data_btn_title']) { ?>
							<div class="btn-box"><a href="<?php echo esc_url( $mount_link );?>" <?php if( $page == 'extranal' ) echo esc_attr( $target );?> <?php if( $page == 'extranal' ) echo esc_attr( $nofollow );?> class="theme-btn <?php echo ($key == 1) ? 'light-bg' : 'dark-bg'; ?> te-btn"><div class="icon-box"><span class="static-icon"><i class="flaticon-two-lines"></i></span><span class="overlay-icon"><i class="flaticon-two-lines"></i></span></div><span class="text"><?php echo wp_kses( $item[ 'data_btn_title' ], true );?></span></a></div>
							<?php } ?>
						</div>
					</div>
					<?php endforeach;?>
				</div>
				<div class="tab" id="pric-tab-5">
					<?php 
						foreach( $settings[ 'premium_list' ] as $key => $item ):

						$pages = $item['link_options'];
						$page_selects = $item[ 'page_selects' ];
						$ext_urls = $item[ 'links' ];

						if( $pages == 'pages' ){
							$mount_links = get_page_link( $page_selects );
						}else{
							$mount_links = $ext_urls['url'];
							$targets = $ext_urls['is_external'] ? ' target="_blank"' : '';
							$nofollows = $ext_urls['nofollow'] ? ' rel="nofollow"' : '';
						}						

					?>
					<div class="pricing-block-two <?php if($key == 1) echo 'active-block';?>">
						<div class="inner-box">
							<div class="title-box">
								<?php if($item['data_titles']) { ?><h3 class="te-title"><?php echo wp_kses( $item[ 'data_titles' ], true );?></h3><?php } ?>
								<?php if($item['data_texts']) { ?><p><?php echo wp_kses( $item[ 'data_texts' ], true );?></p><?php } ?>
								<?php if($item['data_prices'] || $item['data_months']) { ?>
								<h2 class="te-subtitle"><?php echo wp_kses( $item[ 'data_prices' ], true );?> <span><?php echo wp_kses( $item[ 'data_months' ], true );?></span></h2>
								<?php } ?>
							</div>
							<div class="feature-box">
								<?php 
								$features_list = $item['features_lists'];

								if (!empty($features_list)) {
									$features_list = explode("\n", $features_list);

									// Split into two halves
									$total = count($features_list);
									$half = ceil($total / 2);

									$first_half = array_slice($features_list, 0, $half);
									$second_half = array_slice($features_list, $half);
								?>

									<ul class="feature-list mb_10">
										<?php foreach ($first_half as $feature): ?>
											<li>
												<i class="flaticon-round"></i>
												<span class="te-text"><?php echo wp_kses($feature, true); ?></span>
											</li>
										<?php endforeach; ?>
									</ul>

									<ul class="feature-list">
										<?php foreach ($second_half as $feature): ?>
											<li>
												<i class="flaticon-round"></i>
												<span class="te-text"><?php echo wp_kses($feature, true); ?></span>
											</li>
										<?php endforeach; ?>
									</ul>

								<?php } ?>
							</div>
							<?php if($item['data_btn_titles']) { ?>
							<div class="btn-box"><a href="<?php echo esc_url( $mount_links );?>" <?php if( $pages == 'extranals' ) echo esc_attr( $targets );?> <?php if( $pages == 'extranals' ) echo esc_attr( $nofollows );?> class="theme-btn <?php echo ($key == 1) ? 'light-bg' : 'dark-bg'; ?> te-btn"><div class="icon-box"><span class="static-icon"><i class="flaticon-two-lines"></i></span><span class="overlay-icon"><i class="flaticon-two-lines"></i></span></div><span class="text"><?php echo wp_kses( $item[ 'data_btn_titles' ], true );?></span></a></div>
							<?php } ?>
						</div>
					</div>
					<?php endforeach;?>
				</div>
			</div>
		</div>
	</section>

	<?php else: ?>

	<section class="pricing-section p-0 m-0">
		<div class="tabs-box-2">
			<div class="title-box flexbox_2 mb_50">
				<?php if($settings['sub_title'] || $settings['title']) { ?>
				<div class="sec-title">
					<?php if($settings['sub_title']) { ?><span class="sub-title"><?php echo wp_kses( $settings[ 'sub_title' ], true );?></span><?php } ?>
					<?php if($settings['title']) { ?><h2><?php echo wp_kses( $settings[ 'title' ], true );?></h2><?php } ?>
				</div>
				<?php } ?>
				<?php if($settings['tab_title'] || $settings['tabs_title']) { ?>
				<ul class="tab-btns tab-buttons">
					<?php if($settings['tab_title']) { ?><li class="tab-btn active-btn" data-tab="#tab-4"><?php echo wp_kses( $settings[ 'tab_title' ], true );?></li><?php } ?>
					<?php if($settings['tabs_title']) { ?><li class="tab-btn" data-tab="#tab-5"><?php echo wp_kses( $settings[ 'tabs_title' ], true );?></li><?php } ?>
				</ul>
				<?php } ?>
			</div>
			<div class="tabs-content">
				<div class="tab active-tab" id="tab-4">
					<div class="row clearfix">
						<?php 
							foreach( $settings[ 'standard_list' ] as $key => $item ):

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

						?>
						<div class="col-lg-4 col-md-6 col-sm-12 pricing-block">
							<div class="pricing-block-one <?php if($key == 1) echo 'recommend-block';?>">
								<div class="table-header">
									<?php if($item['data_title']) { ?><h3 class="te-title"><?php echo wp_kses( $item[ 'data_title' ], true );?></h3><?php } ?>
									<?php if($item['data_text']) { ?><p><?php echo wp_kses( $item[ 'data_text' ], true );?></p><?php } ?>
									<?php if($item['data_price'] || $item['data_month']) { ?>
									<h2 class="te-subtitle"><?php echo wp_kses( $item[ 'data_price' ], true );?> <span><?php echo wp_kses( $item[ 'data_month' ], true );?></span></h2>
									<?php } ?>
								</div>
								<div class="table-content">
									<?php if($item['subtitle']) { ?><h6><?php echo wp_kses( $item[ 'subtitle' ], true );?></h6><?php } ?>
									<?php $features_list = $item['features_list'];
										if(!empty($features_list)){
										$features_list = explode("\n", ($features_list)); 
									?>
									<ul class="feature-list clearfix">
										<?php foreach($features_list as $features): ?>
										<li><i class="flaticon-round"></i><span class="te-text"><?php echo wp_kses($features, true); ?></span></li>
										<?php endforeach; ?>
									</ul>
									<?php } ?>
								</div>
								<?php if($item['data_btn_title']) { ?>
								<div class="table-footer">
									<a href="<?php echo esc_url( $mount_link );?>" <?php if( $page == 'extranal' ) echo esc_attr( $target );?> <?php if( $page == 'extranal' ) echo esc_attr( $nofollow );?> class="theme-btn <?php echo ($key == 1) ? 'light-bg' : 'dark-bg'; ?> te-btn"><div class="icon-box"><span class="static-icon"><i class="flaticon-two-lines"></i></span><span class="overlay-icon"><i class="flaticon-two-lines"></i></span></div><span class="text"><?php echo wp_kses( $item[ 'data_btn_title' ], true );?></span></a>
								</div>
								<?php } ?>
							</div>
						</div>
						<?php endforeach;?>
					</div>
				</div>
				<div class="tab" id="tab-5">
					<div class="row clearfix">
						<?php 
							foreach( $settings[ 'premium_list' ] as $key => $item ):

							$pages = $item['link_options'];
							$page_selects = $item[ 'page_selects' ];
							$ext_urls = $item[ 'links' ];

							if( $pages == 'pages' ){
								$mount_links = get_page_link( $page_selects );
							}else{
								$mount_links = $ext_urls['url'];
								$targets = $ext_urls['is_external'] ? ' target="_blank"' : '';
								$nofollows = $ext_urls['nofollow'] ? ' rel="nofollow"' : '';
							}						

						?>
						<div class="col-lg-4 col-md-6 col-sm-12 pricing-block">
							<div class="pricing-block-one <?php if($key == 1) echo 'recommend-block';?>">
								<div class="table-header">
									<?php if($item['data_titles']) { ?><h3 class="te-title"><?php echo wp_kses( $item[ 'data_titles' ], true );?></h3><?php } ?>
									<?php if($item['data_texts']) { ?><p><?php echo wp_kses( $item[ 'data_texts' ], true );?></p><?php } ?>
									<?php if($item['data_prices'] || $item['data_months']) { ?>
									<h2 class="te-subtitle"><?php echo wp_kses( $item[ 'data_prices' ], true );?> <span><?php echo wp_kses( $item[ 'data_months' ], true );?></span></h2>
									<?php } ?>
								</div>
								<div class="table-content">
									<?php if($item['subtitles']) { ?><h6><?php echo wp_kses( $item[ 'subtitles' ], true );?></h6><?php } ?>
									<?php $features_list = $item['features_lists'];
										if(!empty($features_list)){
										$features_list = explode("\n", ($features_list)); 
									?>
									<ul class="feature-list clearfix">
										<?php foreach($features_list as $features): ?>
										<li><i class="flaticon-round"></i><span class="te-text"><?php echo wp_kses($features, true); ?></span></li>
										<?php endforeach; ?>
									</ul>
									<?php } ?>
								</div>
								<?php if($item['data_btn_titles']) { ?>
								<div class="table-footer">
									<a href="<?php echo esc_url( $mount_links );?>" <?php if( $pages == 'extranals' ) echo esc_attr( $targets );?> <?php if( $pages == 'extranals' ) echo esc_attr( $nofollows );?> class="theme-btn <?php echo ($key == 1) ? 'light-bg' : 'dark-bg'; ?> te-btn"><div class="icon-box"><span class="static-icon"><i class="flaticon-two-lines"></i></span><span class="overlay-icon"><i class="flaticon-two-lines"></i></span></div><span class="text"><?php echo wp_kses( $item[ 'data_btn_titles' ], true );?></span></a>
								</div>
								<?php } ?>
							</div>
						</div>
						<?php endforeach;?>
					</div>
				</div>
			</div>
		</div>
	</section>
    
    <?php endif;
    }
}
