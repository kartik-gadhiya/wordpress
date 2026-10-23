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
use Finspire\Elementor\Traits\Trait_Text;
use Finspire\Elementor\Traits\Trait_Icons;
use Finspire\Elementor\Traits\Trait_Image;

/**
 * Elementor button widget.
 * Elementor widget that displays a button with the ability to control every
 * aspect of the button design.
 *
 * @since 1.0.0
 */
class Team_Carousal extends Widget_Base {
	/**
	 * Get widget name.
	 * Retrieve button widget name.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'finspire_team_carousal';
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
		return esc_html__( 'Finspire Team Carousal', 'finspire' );
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
	use Trait_Title, Trait_Text, Trait_Icons, Trait_Image;
	protected function register_controls() {
		$this->start_controls_section(
			'team_carousal',
			[
				'label' => esc_html__( 'Team Carousal', 'finspire' ),
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
			'block_title',
			[
				'label'       => __( 'Team Title', 'finspire' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Team Title', 'finspire' ),
			]
		);	
		$repeater->add_control(
			'designation',
			[
				'label'       => __( 'Designation', 'finspire' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your designation', 'finspire' ),
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
		$social_repeater = new Repeater();
		$social_repeater->add_control(
			'icons',
			[
				'label' => esc_html__('Enter The icons', 'finspire'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'flaticon-mail',
					'library' => 'solid',
				],
			]			
		);
		$social_repeater->add_control(
			'image_link',
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
			]
		);

		// Add social repeater field to main repeater
		$repeater->add_control(
			'socials',
			[
				'label' => __('Social Icons', 'finspire'),
				'type' => Controls_Manager::REPEATER,
				'fields' => $social_repeater->get_controls(),
				'title_field' => '{{{ icons.value }}}',
			]
		);
		$this->add_control(
			'sponsers',
			[
				'label'                 => __('Add Carousal Item', 'finspire'),
				'type'                  => Controls_Manager::REPEATER,
				'fields'                => $repeater->get_controls(),
				'title_field' => '{{{ block_title }}}',
				'default' => [
					[
						'block_title' => esc_html__( 'John Doe', 'finspire' ),
						'designation' => esc_html__( 'Senior Manager', 'finspire' ),
					],
					[
						'block_title' => esc_html__( 'Peter Jack', 'finspire' ),
						'designation' => esc_html__( 'Senior Manager', 'finspire' ),
					],
					[
						'block_title' => esc_html__( 'David Clark', 'finspire' ),
						'designation' => esc_html__( 'Senior Manager', 'finspire' ),
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
		
		
		
		//text Style Start ****************
        $this->start_controls_section(
            'text_style_setting',
            [
                'label' => esc_html__( 'Designation Style Setting', 'finspire' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_text_controls();
        
        $this->end_controls_section();
		
		//Icon Style Start ***************
        $this->start_controls_section(
            'icons_style_setting',
            [
                'label' => esc_html__( 'Social Icons Style Setting', 'finspire' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_icons_controls();
        
        $this->end_controls_section();
		
		//image Style Start *****************
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

	<section class="team-section centred p-0 m-0">
		<div class="four-item-carousel">
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
					<div class="team-block-one">
						<div class="link"><a href="<?php echo esc_url( $mount_link );?>" <?php if( $page == 'extranal' ) echo esc_attr( $target );?> <?php if( $page == 'extranal' ) echo esc_attr( $nofollow );?>><i class="flaticon-two-lines"></i></a></div>
						<div class="image-box">
							<figure class="image"><img class="te-img" src="<?php echo esc_url( $mount_fimg );?>" alt="<?php bloginfo( 'name' ); ?>" /></figure>
							<ul class="social-links">
								<?php if ( !empty($item['socials']) ) : ?>
									<?php foreach ( $item['socials'] as $social ) : ?>
										<li><a class="te-icon" href="<?php echo esc_url($social['image_link']['url']); ?>">
											<?php if( isset( $social['icons']['library'] ) && 'svg' === $social['icons']['library'] ) {?>
												<?php \Elementor\Icons_Manager::render_icon( $social[ 'icons' ] ); ?>
											<?php } else {?>
												<i class="<?php echo esc_attr( $social[ 'icons' ][ 'value' ] );?>"></i>
											<?php };?>
										</a></li>
									<?php endforeach; ?>
								<?php endif; ?>
							</ul>
						</div>
						<?php if($item['designation'] || $item['block_title']) { ?>
						<div class="lower-content">
							<?php if($item['designation']) { ?><span class="designation te-text"><?php echo wp_kses($item['designation'], true) ;?></span><?php } ?>
							<?php if($item['block_title']) { ?><h5><a class="te-title" href="<?php echo esc_url( $mount_link );?>" <?php if( $page == 'extranal' ) echo esc_attr( $target );?> <?php if( $page == 'extranal' ) echo esc_attr( $nofollow );?>><?php echo wp_kses($item['block_title'], true) ;?></a></h5><?php } ?>
						</div>
						<?php } ?>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
			<div class="dots-style-one">
				<div class="four-column-pagination"></div>
			</div>
		</div>
	</section>

     <?php 
	}
}