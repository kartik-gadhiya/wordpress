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
use Finspire\Elementor\Traits\Trait_Icons;
use Finspire\Elementor\Traits\Trait_Text;
use Finspire\Elementor\Traits\Trait_Image;
use Finspire\Elementor\Traits\Trait_Image2;

/**
 * Elementor button widget.
 * Elementor widget that displays a button with the ability to control every
 * aspect of the button design.
 *
 * @since 1.0.0
 */
class Chart_Card extends Widget_Base {
	/**
	 * Get widget name.
	 * Retrieve button widget name.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'finspire_chart_card';
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
		return esc_html__( 'Finspire Chart Card', 'finspire' );
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
	use Trait_Title, Trait_Text, Trait_Image, Trait_Image2, Trait_Icons;
	protected function register_controls() {
		$this->start_controls_section(
			'chart_card',
			[
				'label' => esc_html__( 'Chart Card', 'finspire' ),
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
				),
			]
		);
		$this->add_control(
			'block_img',
			[
				'label' => __( 'Background Image', 'finspire' ),
				'condition' => [ 'layout_control' => ['1', '2'], ],
				'type' => Controls_Manager::MEDIA,
				'default' => ['url' => Utils::get_placeholder_image_src(),],
			]
		);
		$this->add_control(
			'icons',
			[
				'label' => esc_html__('Enter icons', 'finspire'),
				'condition' => [ 'layout_control' => ['3'], ],
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'flaticon-risk',
					'library' => 'solid',
				],
			]			
		);
		$this->add_control(
			'count',
			[
				'label' => esc_html__( 'Count Value', 'finspire' ),
				'condition' => [ 'layout_control' => ['3'], ],
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__( 'Enter your Count Value', 'finspire' ),
				'default' => esc_html__( '1.5X', 'finspire' ),
			]
		);	
		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'finspire' ),
				'condition' => [ 'layout_control' => ['2', '3'], ],
				'type' => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'placeholder' => esc_html__( 'Enter your Title', 'finspire' ),
				'default' => esc_html__( 'Business Expansion with Finspire Insights', 'finspire' ),
			]
		);	
		$this->add_control(
			'count_start2',
			[
				'label' => esc_html__( 'Counter Start Value', 'finspire' ),
				'condition' => [ 'layout_control' => ['1'], ],
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__( 'Enter your Counter Start Value', 'finspire' ),
				'default' => esc_html__( '00', 'finspire' ),
			]
		);	
		$this->add_control(
			'count_stop2',
			[
				'label' => esc_html__( 'Counter Stop Value', 'finspire' ),
				'condition' => [ 'layout_control' => ['1'], ],
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__( 'Enter your Counter Stop Value', 'finspire' ),
				'default' => esc_html__( '84', 'finspire' ),
			]
		);	
		$this->add_control(
			'alphabet_letter2',
			[
				'label' => esc_html__( 'Alphabet Letter', 'finspire' ),
				'condition' => [ 'layout_control' => ['1'], ],
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__( 'Enter your Alphabet Letter', 'finspire' ),
				'default' => esc_html__( '%', 'finspire' ),
			]
		);	
		$this->add_control(
			'block_img2',
			[
				'label' => __( 'Chart Image', 'finspire' ),
				'condition' => [ 'layout_control' => ['1'], ],
				'type' => Controls_Manager::MEDIA,
				'default' => ['url' => Utils::get_placeholder_image_src(),],
			]
		);
		$repeater = new Repeater();
		$repeater->add_control(
			'btn_title',
			[
				'label'       => __( 'List Title', 'finspire' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your List Title Here', 'finspire' ),
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
			'btn_link',
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
			'sponsers',
			[
				'label'                 => __('Add List Item', 'finspire'),
				'condition' => [ 'layout_control' => ['1'], ],
				'type'                  => Controls_Manager::REPEATER,
				'fields'                => $repeater->get_controls(),
				'title_field' => '{{{ btn_title }}}',
				'default' => [
					[
						'btn_title' => esc_html__( 'List Item', 'finspire' ),
					],
					[
						'btn_title' => esc_html__( 'List Item', 'finspire' ),
					],
					[
						'btn_title' => esc_html__( 'List Item', 'finspire' ),
					],
				],
			]
		);
		$repeater = new Repeater();
		$repeater->add_control(
			'year',
			[
				'label'       => __( 'Year', 'finspire' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Year', 'finspire' ),
			]
		);
		$repeater->add_control(
			'count',
			[
				'label'       => __( 'Chart Count', 'finspire' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Chart Count', 'finspire' ),
			]
		);	
		$this->add_control(
			'sponsers2',
			[
				'label'                 => __('Add Chart Item', 'finspire'),
				'condition' => [ 'layout_control' => ['2', '3'], ],
				'type'                  => Controls_Manager::REPEATER,
				'fields'                => $repeater->get_controls(),
				'title_field' => '{{{ count }}}',
				'default' => [
					[
						'count' => esc_html__( '62', 'finspire' ),
						'year' => esc_html__( '2024:', 'finspire' ),
					],
					[
						'count' => esc_html__( '88', 'finspire' ),
						'year' => esc_html__( '2025:', 'finspire' ),
					],
				],
			]
		);
		
		$this->end_controls_section();
		
		//title Style Start *****************
        $this->start_controls_section(
            'title_style_setting',
            [
                'label' => esc_html__( 'Titles Style Setting', 'finspire' ),
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
                'label' => esc_html__( 'Background Image Style', 'finspire' ),
				'condition' => [ 'layout_control' => ['1', '2'], ],
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_image_controls();
        
        $this->end_controls_section();
		
		$this->start_controls_section(
            'image2_style_setting',
            [
                'label' => esc_html__( 'Chart Image Style', 'finspire' ),
				'condition' => [ 'layout_control' => ['1'], ],
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_image2_controls();
        
        $this->end_controls_section();
		
		//text Style Start ****************
        $this->start_controls_section(
            'text_style_setting',
            [
                'label' => esc_html__( 'Count Style Setting', 'finspire' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_text_controls();
        
        $this->end_controls_section();
		
		$this->start_controls_section(
            'subtitle_style_setting',
            [
                'label' => esc_html__( 'Icons Style', 'finspire' ),
				'condition' => [ 'layout_control' => ['3'], ],
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

	<?php if($settings['layout_control'] == '3') : ?>

	<div class="about-style-three p-0 m-0">
		<div class="left-content p-0 m-0">
			<div class="chart-box">
				<div class="progress-box mb_30">
					<?php foreach($settings['sponsers2'] as $key => $item): ?>
					<div class="single-progress-box">
						<span class="year"><?php echo wp_kses($item['year'], true); ?></span>
						<span class="count-text"><?php echo wp_kses($item['count'], true); ?></span>
						<div class="bar">
							<div class="bar-inner count-bar" data-percent="<?php echo wp_kses($item['count'], true); ?>"></div>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
				<div class="inner-box">
					<div class="icon-box te-icon">
						<?php if( isset( $settings['icons']['library'] ) && 'svg' === $settings['icons']['library'] ) {?>
							<?php \Elementor\Icons_Manager::render_icon( $settings[ 'icons' ] ); ?>
						<?php } else {?>
							<i class="<?php echo esc_attr( $settings[ 'icons' ][ 'value' ] );?>"></i>
						<?php };?>
					</div>
					<?php if($settings['count'] || $settings['title']) { ?>
					<div class="inner">
						<?php if($settings['count']) { ?><h2 class="te-text"><?php echo wp_kses($settings['count'], true); ?></h2><?php } ?>
						<?php if($settings['title']) { ?><p class="te-title"><?php echo wp_kses($settings['title'], true); ?></p><?php } ?>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>

	<?php elseif($settings['layout_control'] == '2') : 
		$feature_img  = $settings['block_img'];
		if( !empty($feature_img['id']) ){
			$mount_fimg = wp_get_attachment_url($feature_img['id']);
		} else {
			$mount_fimg = $feature_img['url'];
		}
	?>

	<div class="chooseus-style-two p-0 m-0">
		<div class="chart-content">
			<div class="shape te-img" style="background-image: url(<?php echo esc_url( $mount_fimg );?>);"></div>
			<?php if($settings['title']) { ?><h5 class="te-title"><?php echo wp_kses($settings['title'], true); ?></h5><?php } ?>
			<div class="chart-inner">
				<?php foreach($settings['sponsers2'] as $key => $item): ?>
				<div class="chart-box">
					<div class="circle" data-percent="<?php echo wp_kses($item['count'], true); ?>"></div>
					<p class="te-text"><?php echo wp_kses($item['year'], true); ?> <?php echo wp_kses($item['count'], true); ?>%</p>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>

	<?php else : 
		
		// block_img
		$feature_img  = $settings['block_img'];
		if( !empty($feature_img['id']) ){
			$mount_fimg = wp_get_attachment_url($feature_img['id']);
		} else {
			$mount_fimg = $feature_img['url'];
		}
		
		// block_img 2
		$feature_img2  = $settings['block_img2'];
		if( !empty($feature_img2['id']) ){
			$mount_fimg2 = wp_get_attachment_url($feature_img2['id']);
		} else {
			$mount_fimg2 = $feature_img2['url'];
		}
	?>

	<div class="sub-banner-section p-0 m-0">
		<div class="lower-content p-0 m-0">
			<div class="lower-box p-0 m-0">
				<div class="inner-box">
					<div class="shape te-img" style="background-image: url(<?php echo esc_url( $mount_fimg );?>);"></div>
					<div class="inner">
						<div class="text-box">
							<?php if($settings['count_stop2'] || $settings['alphabet_letter2']) { ?>
							<div class="count-box te-text"><span class="odometer relative t_5" data-count="<?php echo wp_kses($settings['count_stop2'], true) ;?>"><?php echo wp_kses($settings['count_start2'], true) ;?></span><span><?php echo wp_kses($settings['alphabet_letter2'], true) ;?></span></div>
							<?php } ?>
							<ul class="list-item">
								<?php foreach($settings['sponsers'] as $key => $item): 
									$page = $item['link_option'];
									$page_select = $item[ 'page_select' ];
									$ext_url = $item[ 'btn_link' ];

									if( $page == 'page' ){
										$mount_link = get_page_link( $page_select );
									}else{
										$mount_link = $ext_url['url'];
										$target = $ext_url['is_external'] ? ' target="_blank"' : '';
										$nofollow = $ext_url['nofollow'] ? ' rel="nofollow"' : '';
									}

								?>
								<li><a class="te-title" href="<?php echo esc_url( $mount_link );?>" <?php if( $page == 'extranal' ) echo esc_attr( $target );?> <?php if( $page == 'extranal' ) echo esc_attr( $nofollow );?>><?php echo wp_kses($item['btn_title'], true); ?></a></li>
								<?php endforeach; ?>
							</ul>
						</div>
						<figure class="chart"><img class="te-img2" src="<?php echo esc_url( $mount_fimg2 );?>" alt="<?php bloginfo( 'name' ); ?>"></figure>
					</div>
				</div>
			</div>
		</div>
	</div>

     <?php endif;
	}
}