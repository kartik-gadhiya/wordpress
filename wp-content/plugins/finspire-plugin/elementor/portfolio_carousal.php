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
use Finspire\Elementor\Traits\Trait_Title;
use Finspire\Elementor\Traits\Trait_Text;
use Finspire\Elementor\Traits\Trait_Image;

/**
 * Elementor button widget.
 * Elementor widget that displays a button with the ability to control every
 * aspect of the button design.
 *
 * @since 1.0.0
 */
class Portfolio_Carousal extends Widget_Base {
	/**
	 * Get widget name.
	 * Retrieve button widget name.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'finspire_portfolio_carousal';
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
		return esc_html__( 'Finspire Portfolio Carousal', 'finspire' );
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
	use Trait_Title, Trait_Text, Trait_Image;
	protected function register_controls() {
		$this->start_controls_section(
			'portfolio_carousal',
			[
				'label' => esc_html__( 'Portfolio Carousal', 'finspire' ),
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
		
		$repeater = new Repeater();
		$repeater->add_control(
			'block_img',
			[
				'label' => __( 'Image', 'finspire' ),
				'type' => Controls_Manager::MEDIA,
				'default' => ['url' => Utils::get_placeholder_image_src(),],
			]
		);
		$repeater->add_control(
			'title',
			[
				'label'       => __( 'Industry Title', 'finspire' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Industry Title', 'finspire' ),
			]
		);
		$repeater->add_control(
			'category',
			[
				'label'       => __( 'Category', 'finspire' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your category', 'finspire' ),
			]
		);	
		$repeater->add_control(
			'block_title',
			[
				'label'       => __( 'Block Title', 'finspire' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Block Title', 'finspire' ),
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
			'sponsers',
			[
				'label'                 => __('Add Carousal Item', 'finspire'),
				'condition' => [ 'layout_control' => ['1'], ],
				'type'                  => Controls_Manager::REPEATER,
				'fields'                => $repeater->get_controls(),
				'title_field' => '{{{ block_title }}}',
				'default' => [
					[
						'title' => esc_html__( 'Industry:', 'finspire' ),
						'block_title' => esc_html__( 'Portfolio Title', 'finspire' ),
						'category' => esc_html__( 'Portfolio Category', 'finspire' ),
					],
					[
						'title' => esc_html__( 'Industry:', 'finspire' ),
						'block_title' => esc_html__( 'Portfolio Title', 'finspire' ),
						'category' => esc_html__( 'Portfolio Category', 'finspire' ),
					],
					[
						'title' => esc_html__( 'Industry:', 'finspire' ),
						'block_title' => esc_html__( 'Portfolio Title', 'finspire' ),
						'category' => esc_html__( 'Portfolio Category', 'finspire' ),
					],
					[
						'title' => esc_html__( 'Industry:', 'finspire' ),
						'block_title' => esc_html__( 'Portfolio Title', 'finspire' ),
						'category' => esc_html__( 'Portfolio Category', 'finspire' ),
					],
				],
			]
		);
		
		$repeater = new Repeater();
		$repeater->add_control(
			'block_img4',
			[
				'label' => __( 'Portfolio Image', 'finspire' ),
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
			'list_items',
			[
				'label'       => __( 'Features List', 'finspire' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Features List', 'finspire' ),
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
				'type'    => Controls_Manager::SELECT2,
				'default' => 'extranal',
				'options' => finspire_page_list(),
				'condition'   => [
					'link_option2' => 'page'
				]
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
						'btn_title2' => esc_html__( 'Read More', 'finspire' ),
					],
					[
						'title2' => esc_html__( 'Service Title', 'finspire' ),
						'btn_title2' => esc_html__( 'Read More', 'finspire' ),
					],
					[
						'title2' => esc_html__( 'Service Title', 'finspire' ),
						'btn_title2' => esc_html__( 'Read More', 'finspire' ),
					],
				],
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
		
		//Image Style Start *****************
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
                'label' => esc_html__( 'Category/Features Style', 'finspire' ),
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

	<section class="project-style-three p-0 m-0">
		<div class="single-item-carousel p_relative">
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
					<div class="project-block-three">
						<div class="bg-layer te-img" style="background-image: url(<?php echo esc_url( $mount_fimg4 );?>);"></div>
						<div class="left-content">
							<figure class="client-logo"><img src="<?php echo esc_url( $mount_fimg5 );?>" alt="<?php bloginfo( 'name' ); ?>"></figure>
							<?php if($item['title2']) { ?><h3 class="te-title"><?php echo wp_kses( $item[ 'title2'], true  );?></h3><?php } ?>
							<?php 
							$list_items = $item['list_items'];

							if(!empty($list_items)){
								$list_items = explode("\n", ($list_items)); 
							?>
							<ul class="list-item clearfix">
								<?php foreach($list_items as $list): 
									$parts = explode(":", $list, 2); // Split label and value
									$label = isset($parts[0]) ? trim($parts[0]) : '';
									$value = isset($parts[1]) ? trim($parts[1]) : '';
								?>
								<li>
									<span><?php echo esc_html($label); ?>:</span>
									<p class="te-text"><?php echo esc_html($value); ?></p>
								</li>
								<?php endforeach; ?>
							</ul>
							<?php } ?>
						</div>
						<?php if($item['btn_title2']) { ?>
						<div class="right-content">
							<div class="link-box">
								<a class="te-btn" href="<?php echo esc_url( $mount_link2 );?>" <?php if( $page2 == 'extranal' ) echo esc_attr( $target );?> <?php if( $page2 == 'extranal' ) echo esc_attr( $nofollow );?>><i class="flaticon-two-lines"></i><span><?php echo wp_kses( $item[ 'btn_title2'], true  );?></span></a>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
			<div class="pagination-box">
				<span class="text">/03</span>
				<div class="single-column-pagination"></div>
			</div>
			<div class="swiper-nav">
				<div class="swiper-prev"><i class="flaticon-two-lines"></i><span>Prev</span></div>
				<div class="swiper-next"><span>Next</span><i class="flaticon-two-lines"></i></div>
			</div>
		</div>
	</section>

	<?php else: ?>

	<section class="project-style-two p-0 m-0">
		<div class="five-item-carousel">
			<div class="swiper-wrapper">
				<?php foreach($settings['sponsers'] as $key => $item): 
		
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
				$feature_img  = $item['block_img'];
				if( !empty($feature_img['id']) ){
					$mount_fimg = wp_get_attachment_url($feature_img['id']);
				} else {
					$mount_fimg = $feature_img['url'];
				}

				?>
				<div class="swiper-slide">
					<div class="project-block-two">
						<div class="inner-box">
							<div class="image-box">
								<figure class="image"><img class="te-img" src="<?php echo esc_url( $mount_fimg );?>" alt="<?php bloginfo( 'name' ); ?>"></figure>
								<div class="link"><a href="<?php echo esc_url( $mount_link );?>" <?php if( $page == 'extranal' ) echo esc_attr( $target );?> <?php if( $page == 'extranal' ) echo esc_attr( $nofollow );?>><i class="flaticon-two-lines"></i></a></div>
							</div>
							<div class="lower-content">
								<?php if($item['title'] || $item['category']) { ?>
								<p><?php echo wp_kses($item['title'], true) ;?> <span class="te-text"><?php echo wp_kses($item['category'], true) ;?></span></p>
								<?php } ?>
								<?php if($item['block_title']) { ?>
								<h3><a class="te-title" href="<?php echo esc_url( $mount_link );?>" <?php if( $page == 'extranal' ) echo esc_attr( $target );?> <?php if( $page == 'extranal' ) echo esc_attr( $nofollow );?>><?php echo wp_kses($item['block_title'], true) ;?></a></h3>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	
     <?php endif;
	}
}