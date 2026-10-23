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
use \Elementor\Group_Control_Image_Size;
use Elementor\Plugin;
use Finspire\Elementor\Traits\Trait_Background;
use Finspire\Elementor\Traits\Trait_Icons;
use Finspire\Elementor\Traits\Trait_Image;
/**
 * Elementor button widget.
 * Elementor widget that displays a button with the ability to control every
 * aspect of the button design.
 *
 * @since 1.0.0
 */
class Search_Icon extends Widget_Base {
    /**
     * Get widget name.
     * Retrieve button widget name.
     *
     * @since  1.0.0
     * @access public
     * @return string Widget name.
     */
    public function get_name() {
        return 'finspire_search_icon';
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
        return esc_html__( 'Finspire Search Icon', 'finspire' );
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
	use Trait_Icons, Trait_Background, Trait_Image;
    protected function register_controls() {
        $this->start_controls_section(
            'search_icon',
            [
                'label' => esc_html__( 'Search Icon', 'finspire' ),
            ]
        );
		$this->add_control(
			'icons',
			[
				'label' => esc_html__('Enter Search Icon', 'finspire'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'flaticon-search',
					'library' => 'solid',
				],
			]			
		);
		$this->add_control(
			'logo_image',
			[
				'label' => esc_html__( 'Choose Logo Image', 'finspire' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);
		$this->end_controls_section();
		
		//Background Style Start *****************
        $this->start_controls_section(
            'background_style_setting',
            [
                'label' => esc_html__( 'Background Style Setting', 'finspire' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_background_controls();
        
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
		
		//Image Style Start ***************
        $this->start_controls_section(
            'image_style_setting',
            [
                'label' => esc_html__( 'Logo Style Setting', 'finspire' ),
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
		
		$feature_img = $settings[ 'logo_image' ];
		if( $feature_img[ 'id' ] ){
			$mount_fimg = wp_get_attachment_url( $feature_img[ 'id' ] );
		} else {
			$mount_fimg = $feature_img[ 'url' ];
		}
		
	?>

	<div class="search-toggler te-icon">
		<?php if( isset( $settings['icons']['library'] ) && 'svg' === $settings['icons']['library'] ) {?>
			<?php \Elementor\Icons_Manager::render_icon( $settings[ 'icons' ] ); ?>
		<?php } else {?>
			<i class="<?php echo esc_attr( $settings[ 'icons' ][ 'value' ] );?>"></i>
		<?php };?>
	</div>

	<!--Search Popup-->
	<div id="search-popup" class="search-popup te-bg">
		<div class="popup-inner">
			<div class="upper-box">
				<figure class="logo-box">
					<a href="<?php echo esc_url( home_url( '/' ) );?>">
						<img class="te-img" src="<?php echo esc_url( $mount_fimg );?>" alt="<?php bloginfo( 'name' );?>">
					</a>
				</figure>
				<div class="close-search">X</div>
			</div>
			<div class="search-form">
				<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
					<div class="form-group">
						<input name="s" value="<?php echo get_search_query(); ?>" placeholder="<?php echo esc_attr__( 'Search Here', 'finspire' ); ?>" type="search" required />
						<button type="submit">
							<?php if( isset( $settings['icons']['library'] ) && 'svg' === $settings['icons']['library'] ) {?>
								<?php \Elementor\Icons_Manager::render_icon( $settings[ 'icons' ] ); ?>
							<?php } else {?>
								<i class="<?php echo esc_attr( $settings[ 'icons' ][ 'value' ] );?>"></i>
							<?php };?>
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

    <?php 
    }
}