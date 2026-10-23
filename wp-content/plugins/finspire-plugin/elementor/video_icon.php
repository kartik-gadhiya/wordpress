<?php namespace FINSPIREPLUGIN\Element;

use Elementor\Controls_Manager;
use Elementor\Controls_Stack;
use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Plugin;
use Finspire\Elementor\Traits\Trait_Background;
use Finspire\Elementor\Traits\Trait_Icons;
/**
 * Elementor button widget.
 * Elementor widget that displays a button with the ability to control every
 * aspect of the button design.
 *
 * @since 1.0.0
 */
class Video_Icon extends Widget_Base {
    /**
     * Get widget name.
     * Retrieve button widget name.
     *
     * @since  1.0.0
     * @access public
     * @return string Widget name.
     */
    public function get_name() {
        return 'finspire_video_icon';
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
        return esc_html__( 'Finspire Video Icon', 'finspire' );
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
        return 'eicon-video-playlist';
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
	use Trait_Background, Trait_Icons;
    protected function register_controls() {
        $this->start_controls_section(
            'video_icon',
            [
                'label' => esc_html__( 'Video Icon', 'finspire' ),
            ]
        );
		$this->add_control(
			'icons',
			[
				'label' => esc_html__('Enter The icons', 'finspire'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'flaticon-play',
					'library' => 'flaticon_finspire',
				],
			]			
		);
		$this->add_control(
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
		$this->add_control(
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
		$this->add_control(
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
		$this->end_controls_section();
		
		//Icon Style Start ***************
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
		
		$video_option = $settings[ 'video_option' ];
		if( $video_option == 'src_url' ){
			$video = $settings[ 'video_source_link' ][ 'url' ];
		}elseif( $video_option == 'src_media' ){
			$video = $settings[ 'video_source_image' ]['url'];
		}else{
			$video = esc_html__( 'There is no Video', 'axtra' );
		}
	?>	
	<div class="process-style-two">
		<div class="video-box">
			<a href="<?php echo esc_url( $video );?>" class="lightbox-image te-icon te-bg" data-caption="">
				<?php if( isset( $settings['icons']['library'] ) && 'svg' === $settings['icons']['library'] ) {?>
					<?php \Elementor\Icons_Manager::render_icon( $settings[ 'icons' ] ); ?>
				<?php } else {?>
					<i class="<?php echo esc_attr( $settings[ 'icons' ][ 'value' ] );?>"></i>
				<?php };?>
			</a>
		</div>
	</div>
    
    <?php
    }
}