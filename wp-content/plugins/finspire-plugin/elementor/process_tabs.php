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
use Finspire\Elementor\Traits\Trait_Icons;
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
class Process_Tabs extends Widget_Base {
    /**
     * Get widget name.
     * Retrieve button widget name.
     *
     * @since  1.0.0
     * @access public
     * @return string Widget name.
     */
    public function get_name() {
        return 'finspire_process_tabs';
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
        return esc_html__( 'Finspire Process Tabs', 'finspire' );
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
        return 'eicon-icon-box';
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
	use Trait_Icons, Trait_SubTitle, Trait_Title, Trait_Text, Trait_Image, Trait_Button;
    protected function register_controls() {
        $this->start_controls_section(
            'process_tabs',
            [
                'label' => esc_html__( 'Process Tabs', 'finspire' ),
            ]
        );
		$this->add_control(
			's_subtitle',
			[
				'label'       => __( 'Section Sub Title', 'finspire' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Section Sub Title', 'finspire' ),
				'default' => esc_html__( 'Process', 'finspire' ),
			]
		);
		$this->add_control(
			's_title',
			[
				'label'       => __( 'Section Title', 'finspire' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Section Title', 'finspire' ),
				'default' => esc_html__( 'Our Structured Process for Lasting Results', 'finspire' ),
			]
		);
			
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
			'count',
			[
				'label'       => __( 'Count', 'finspire' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
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
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Count Title', 'finspire' ),
			]
		);
		$repeater->add_control(
			'block_img2',
			[
				'label' => __( 'Video Icon Image', 'finspire' ),
				'type' => Controls_Manager::MEDIA,
				'default' => ['url' => Utils::get_placeholder_image_src(),],
			]
		);
		$repeater->add_control(
			'video_option',
			[
				'label' => __( 'Select Video Type', 'finspire' ),
				'label_block' => true, 
				'type' => Controls_Manager::SELECT,
				'default' => 'src_url',
				'options' => array(
					'src_url'       => esc_html__( 'Source URL', 'finspire' ),
					'src_media'      => esc_html__( 'Source Media', 'finspire' ),
				),
			]
		);
		$repeater->add_control(
            'video_source_link',
			[
				'label' => __( 'Video Source Url', 'finspire' ),
				'type' => Controls_Manager::URL,
				'label_block' => true, 
				'placeholder' => __( 'https://your-link.com', 'plugin-domain' ),
				'show_external' => true,
				'default' => [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
				'condition' => [
					'video_option'      => 'src_url'
				],
			]
		);
		$repeater->add_control(
			'video_source_image',
			[
				'label' => __( 'Video Source Media', 'finspire' ),
				'type' => Controls_Manager::MEDIA,
				'media_types' => ['video'],
				'condition' => [
					'video_option'      => 'src_media'
				],
			]
		);
		$repeater->add_control(
			'v_title',
			[
				'label'       => __( 'Video Title', 'finspire' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Video Title', 'finspire' ),
			]
		);
		$repeater->add_control(
			'btn_title',
			[
				'label'       => __( 'Button Title', 'finspire' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
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
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Title', 'finspire' ),
			]
		);
		$repeater->add_control(
			'subtitle',
			[
				'label'       => __( 'Sub Title', 'finspire' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Sub Title', 'finspire' ),
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
			'features_list',
			[
				'label'       => __( 'Features List', 'finspire' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Features List', 'finspire' ),
			]
		);
		
		
		$this->add_control(
			'slide_v2',
			[
				'label'                 => __('Add Tab Item', 'finspire'),
				'type'                  => Controls_Manager::REPEATER,
				'fields'                => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
				'default' => [
					[
						'title' => esc_html__( 'Add Your Title Here', 'finspire' ),
						'text' => esc_html__( 'Add Your Text Here', 'finspire' ),
						'count' => esc_html__( '4', 'finspire' ),
						'c_title' => esc_html__( 'Simple, Proven,Innovative Steps.', 'finspire' ),
						'v_title' => esc_html__( 'Learn how we guide clients.', 'finspire' ),
						'subtitle' => esc_html__( 'Add Your Sub Title Here', 'finspire' ),
						'btn_title' => esc_html__( 'Lets Start', 'finspire' ),
					],
					[
						'title' => esc_html__( 'Add Your Title Here', 'finspire' ),
						'text' => esc_html__( 'Add Your Text Here', 'finspire' ),
						'count' => esc_html__( '4', 'finspire' ),
						'c_title' => esc_html__( 'Simple, Proven,Innovative Steps.', 'finspire' ),
						'v_title' => esc_html__( 'Learn how we guide clients.', 'finspire' ),
						'subtitle' => esc_html__( 'Add Your Sub Title Here', 'finspire' ),
						'btn_title' => esc_html__( 'Lets Start', 'finspire' ),
					],
					[
						'title' => esc_html__( 'Add Your Title Here', 'finspire' ),
						'text' => esc_html__( 'Add Your Text Here', 'finspire' ),
						'count' => esc_html__( '4', 'finspire' ),
						'c_title' => esc_html__( 'Simple, Proven,Innovative Steps.', 'finspire' ),
						'v_title' => esc_html__( 'Learn how we guide clients.', 'finspire' ),
						'subtitle' => esc_html__( 'Add Your Sub Title Here', 'finspire' ),
						'btn_title' => esc_html__( 'Lets Start', 'finspire' ),
					],
					[
						'title' => esc_html__( 'Add Your Title Here', 'finspire' ),
						'text' => esc_html__( 'Add Your Text Here', 'finspire' ),
						'count' => esc_html__( '4', 'finspire' ),
						'c_title' => esc_html__( 'Simple, Proven,Innovative Steps.', 'finspire' ),
						'v_title' => esc_html__( 'Learn how we guide clients.', 'finspire' ),
						'subtitle' => esc_html__( 'Add Your Sub Title Here', 'finspire' ),
						'btn_title' => esc_html__( 'Lets Start', 'finspire' ),
					],
				],
			]
		);
		
		$this->end_controls_section();
		
		//icons Style Start *****************
        $this->start_controls_section(
            'icons_style_setting',
            [
                'label' => esc_html__( 'Icons Style Setting', 'finspire' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_icons_controls();
        
        $this->end_controls_section();
		
		//title Style Start *****************
        $this->start_controls_section(
            'title_style_setting',
            [
                'label' => esc_html__( 'Section Title Style', 'finspire' ),
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
                'label' => esc_html__( 'Title Style', 'finspire' ),
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

	<section class="process-section p-0 m-0">
		<div class="tabs-box-2">
			<div class="row clearfix">
				<div class="col-lg-6 col-md-12 col-sm-12 content-column">
					<div class="tabs-content p_relative z_5">
						<?php foreach($settings['slide_v2'] as $key => $item): 
							$tab_id = 'ttab-' . $key; // same ID as button
							$page = $item['link_option'];
							$page_select = $item['page_select'];
							$ext_url = $item['link'];

							if( $page == 'page' ){
								$mount_link = get_page_link($page_select);
							} else {
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
							$feature_img2  = $item['block_img2'];
							if( !empty($feature_img2['id']) ){
								$mount_fimg2 = wp_get_attachment_url($feature_img2['id']);
							} else {
								$mount_fimg2 = $feature_img2['url'];
							}
		
							$video_option = $item[ 'video_option' ];
							if( $video_option == 'src_url' ){
								$video = $item[ 'video_source_link' ][ 'url' ];
							}elseif( $video_option == 'src_media' ){
								$video = $item[ 'video_source_image' ]['url'];
							}else{
								$video = esc_html__( 'There is no Video', 'axtra' );
							}
		
						?>
						<div class="tab <?php if($key == 0) echo 'active-tab';?>" id="<?php echo esc_attr($tab_id); ?>">
							<div class="content-box">
								<div class="step-box">
									<div class="bg-layer te-img" style="background-image: url(<?php echo esc_url( $mount_fimg );?>);"></div>
									<?php if($item['count'] || $item['c_title']) { ?>
									<div class="inner">
										<?php if($item['count']) { ?><h2><?php echo wp_kses($item['count'], true); ?></h2><?php } ?>
										<?php if($item['c_title']) { ?><h3><?php echo wp_kses($item['c_title'], true); ?></h3><?php } ?>
									</div>
									<?php } ?>
								</div>
								<div class="video-box pl_20">
									<a href="<?php echo esc_url( $video );?>" class="lightbox-image" data-caption=""><img src="<?php echo esc_url( $mount_fimg2 );?>" alt="<?php bloginfo( 'name' ); ?>"></a>
									<?php if($item['v_title']) { ?><h6><?php echo wp_kses($item['v_title'], true); ?></h6><?php } ?>
								</div>
								<?php if($item['btn_title']) { ?>
								<div class="btn-box pl_20"><a href="<?php echo esc_url($mount_link); ?>" <?php if($page == 'extranal') echo esc_attr($target); ?> <?php if($page == 'extranal') echo esc_attr($nofollow); ?> class="theme-btn dark-bg te-btn"><div class="icon-box"><span class="static-icon"><i class="flaticon-two-lines"></i></span><span class="overlay-icon"><i class="flaticon-two-lines"></i></span></div><span class="text"><?php echo wp_kses($item['btn_title'], true); ?></span></a></div>
								<?php } ?>
							</div>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="col-lg-6 col-md-12 col-sm-12 btn-column">
					<div class="inner-box">
						<?php if($settings['s_subtitle'] || $settings['s_title']) { ?>
						<div class="sec-title light mb_50">
							<?php if($settings['s_subtitle']) { ?><span class="sub-title"><?php echo wp_kses($settings['s_subtitle'], true); ?></span><?php } ?>
							<?php if($settings['s_title']) { ?><h2 class="te-title"><?php echo wp_kses($settings['s_title'], true); ?></h2><?php } ?>
						</div>
						<?php } ?>
						<div class="tab-btns tab-buttons clearfix">
							<?php $jk = 1; foreach($settings['slide_v2'] as $key => $item): 
								$tab_id = 'ttab-' . $key; // same ID as button

							?>
							<div class="tab-btn <?php if($key == 0) echo 'active-btn';?>" data-tab="#<?php echo esc_attr($tab_id); ?>">
								<span class="count-text"><?php $jk = sprintf('%02d', $jk); echo $jk; ?></span>
								<div class="btn-title">
									<div class="icon-box te-icon">
										<?php if( isset( $item['icons']['library'] ) && 'svg' === $item['icons']['library'] ) {?>
											<?php \Elementor\Icons_Manager::render_icon( $item[ 'icons' ] ); ?>
										<?php } else {?>
											<i class="<?php echo esc_attr( $item[ 'icons' ][ 'value' ] );?>"></i>
										<?php };?>
									</div>
									<?php if($item['title'] || $item['subtitle']) { ?>
									<div class="inner">
										<?php if($item['title']) { ?><h3 class="te-subtitle"><?php echo wp_kses($item['title'], true); ?></h3><?php } ?>
										<?php if($item['subtitle']) { ?><span class="te-text"><?php echo wp_kses($item['subtitle'], true); ?></span><?php } ?>
									</div>
									<?php } ?>
								</div>
								<div class="text-box">
									<?php if($item['text']) { ?><p class="te-text"><?php echo wp_kses($item['text'], true) ;?></p><?php } ?>
									<?php 
									$features_list = $item['features_list'];
									if(!empty($features_list)){
										$features_list = explode("\n", $features_list); 
									?>
									<ul class="list-style-one clearfix">  
										<?php foreach($features_list as $features): ?>
										<li><i class="flaticon-play"></i><span><?php echo wp_kses($features, true); ?></span></li>
										<?php endforeach; ?>
									</ul>
									<?php } ?>
								</div>
							</div>
							<?php $jk++; endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

    <?php 
    }
}