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
use Finspire\Elementor\Traits\Trait_Background;
use Finspire\Elementor\Traits\Trait_Title;
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
class Rating_Card extends Widget_Base {
	/**
	 * Get widget name.
	 * Retrieve button widget name.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'finspire_rating_card';
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
		return esc_html__( 'Finspire Rating Card', 'finspire' );
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
	use Trait_Title, Trait_Image, Trait_Image2, Trait_Text, Trait_Background;
	protected function register_controls() {
		$this->start_controls_section(
			'rating_card',
			[
				'label' => esc_html__( 'Rating Card', 'finspire' ),
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
			'block_img',
			[
				'label' => __( 'Image', 'finspire' ),
				'type' => Controls_Manager::MEDIA,
				'default' => ['url' => Utils::get_placeholder_image_src(),],
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
				'placeholder' => __( 'Enter your Title', 'finspire' ),
				'default' => esc_html__( 'Successful Clients', 'finspire' ),
			]
		);
		$this->add_control(
			'block_img2',
			[
				'label' => __( 'Author Image 01', 'finspire' ),
				'type' => Controls_Manager::MEDIA,
				'default' => ['url' => Utils::get_placeholder_image_src(),],
			]
		);
		$this->add_control(
			'block_img3',
			[
				'label' => __( 'Author Image 02', 'finspire' ),
				'type' => Controls_Manager::MEDIA,
				'default' => ['url' => Utils::get_placeholder_image_src(),],
			]
		);
		$this->add_control(
			'block_img5',
			[
				'label' => __( 'Author Image 03', 'finspire' ),
				'type' => Controls_Manager::MEDIA,
				'default' => ['url' => Utils::get_placeholder_image_src(),],
			]
		);
		$this->add_control(
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
		$this->add_control(
			'rating',
			[
				'label'   => esc_html__( 'Choose Rating', 'finspire' ),
				'condition' => [ 'layout_control' => ['2'], ],
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
		$this->add_control(
			'btn_link',
				[
				  'label' => __( 'Image Url', 'finspire' ),
				  'condition' => [ 'layout_control' => ['2'], ],
				  'type' => Controls_Manager::URL,
				  'placeholder' => __( 'https://your-link.com', 'plugin-domain' ),
				  'show_external' => true,
				  'default' => [
				    'url' => '',
				    'is_external' => true,
				    'nofollow' => true,
				  ],
			 ]
		);
		
		$this->end_controls_section();
		
		//Banner Image Style Start ***************
        $this->start_controls_section(
            'background_style_setting',
            [
                'label' => esc_html__( 'Background Style', 'finspire' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_background_controls();
        
        $this->end_controls_section();
		
		//Title Style Start *****************
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
		
		//Text Style Start *****************
        $this->start_controls_section(
            'text_style_setting',
            [
                'label' => esc_html__( 'Ratings Style Setting', 'finspire' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_text_controls();
        
        $this->end_controls_section();
		
		//Banner Image Style Start ***************
        $this->start_controls_section(
            'image_style_setting',
            [
                'label' => esc_html__( 'Image Style', 'finspire' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_image_controls();
        
        $this->end_controls_section();
		
		//Banner Image Style Start ***************
        $this->start_controls_section(
            'image2_style_setting',
            [
                'label' => esc_html__( 'Author Images Style', 'finspire' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_image2_controls();
        
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
		
		// block_img 3
		$feature_img3  = $settings['block_img3'];
		if( !empty($feature_img3['id']) ){
			$mount_fimg3 = wp_get_attachment_url($feature_img3['id']);
		} else {
			$mount_fimg3 = $feature_img3['url'];
		}
		
		// block_img 5
		$feature_img5  = $settings['block_img5'];
		if( !empty($feature_img5['id']) ){
			$mount_fimg5 = wp_get_attachment_url($feature_img5['id']);
		} else {
			$mount_fimg5 = $feature_img5['url'];
		}
		
	?>

	<?php if($settings['layout_control'] == '2') : ?>

	<div class="about-style-two p-0 m-0">
		<div class="review-box p-0 m-0">
			<div class="review-inner te-bg">
				<div class="author-box">
					<ul class="author-image">
						<li><img class="te-img2" src="<?php echo esc_url( $mount_fimg2 );?>" alt="<?php bloginfo( 'name' ); ?>"></li>
						<li><img class="te-img2" src="<?php echo esc_url( $mount_fimg3 );?>" alt="<?php bloginfo( 'name' ); ?>"></li>
						<li><img class="te-img2" src="<?php echo esc_url( $mount_fimg5 );?>" alt="<?php bloginfo( 'name' ); ?>"></li>
					</ul>
					<?php if($settings['title']) { ?><span class="te-title"><?php echo wp_kses($settings['title'], true) ;?></span><?php } ?>
				</div>
				<div class="rating-box">
					<a href="<?php echo esc_url($settings['btn_link']['url']);?>" target="_blank"><img class="te-img" src="<?php echo esc_url( $mount_fimg );?>" alt="<?php bloginfo( 'name' ); ?>"></a>
					<?php if($settings['ratings']) { ?><h3 class="te-text"><?php echo wp_kses($settings['ratings'], true) ;?></h3><?php } ?>
					<ul class="rating-list">
						<?php 
							$rating = !empty($settings['rating']) ? (int) $settings['rating'] : 0; // Use the 'rating' setting instead of meta
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
				</div>
			</div>
		</div>
	</div>

	<?php else: ?>

	<div class="testimonial-section p-0 m-0">
		<div class="rating-box">
			<div class="bg-layer te-img" style="background-image: url(<?php echo esc_url( $mount_fimg );?>);"></div>
			<div class="rating-inner te-bg">
				<div class="inner-box">
					<?php if($settings['ratings']) { ?><h2 class="te-text"><?php echo wp_kses($settings['ratings'], true) ;?></h2><?php } ?>
					<?php if($settings['title']) { ?><p class="te-title"><?php echo wp_kses($settings['title'], true) ;?></p><?php } ?>
					<ul class="clients-list">
						<li><img class="te-img2" src="<?php echo esc_url( $mount_fimg2 );?>" alt="<?php bloginfo( 'name' ); ?>"></li>
						<li><img class="te-img2" src="<?php echo esc_url( $mount_fimg3 );?>" alt="<?php bloginfo( 'name' ); ?>"></li>
						<li><img class="te-img2" src="<?php echo esc_url( $mount_fimg5 );?>" alt="<?php bloginfo( 'name' ); ?>"></li>
					</ul>
				</div>
			</div>
		</div>
	</div>

     <?php endif;
	}
}