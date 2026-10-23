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
use Finspire\Elementor\Traits\Trait_SubTitle;
use Finspire\Elementor\Traits\Trait_Text;
use Finspire\Elementor\Traits\Trait_Icons;

/**
 * Elementor button widget.
 * Elementor widget that displays a button with the ability to control every
 * aspect of the button design.
 *
 * @since 1.0.0
 */
class Asset_Card extends Widget_Base {
	/**
	 * Get widget name.
	 * Retrieve button widget name.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'finspire_asset_card';
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
		return esc_html__( 'Finspire Asset Card', 'finspire' );
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
	use Trait_Background, Trait_Title, Trait_Text, Trait_Icons, Trait_SubTitle;
	protected function register_controls() {
		$this->start_controls_section(
			'asset_card',
			[
				'label' => esc_html__( 'Asset Card', 'finspire' ),
			]
		);
		$this->add_control(
			'icons',
			[
				'label' => esc_html__('Enter icons', 'finspire'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'flaticon-asset-management',
					'library' => 'solid',
				],
			]			
		);
		$this->add_control(
			'block_title',
			[
				'label'       => __( 'Block Title', 'finspire' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Block Title', 'finspire' ),
				'default' => esc_html__( 'Building Growth Through Lasting Partnerships', 'finspire' ),
			]
		);
		$this->add_control(
			'amount',
			[
				'label'       => __( 'Amount', 'finspire' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Amount', 'finspire' ),
				'default' => esc_html__( '+$1.2', 'finspire' ),
			]
		);
		$this->add_control(
			'text',
			[
				'label'       => __( 'Unit', 'finspire' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Unit', 'finspire' ),
				'default' => esc_html__( 'Billion', 'finspire' ),
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
                'label' => esc_html__( 'Amount Style Setting', 'finspire' ),
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
                'label' => esc_html__( 'Unit Style Setting', 'finspire' ),
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

	<div class="about-style-two p-0 m-0">
		<div class="assets-box te-bg">
			<?php if($settings['block_title']) { ?><h5 class="te-title"><?php echo wp_kses($settings['block_title'], true) ;?></h5><?php };?>
			<div class="inner-box">
				<?php if($settings['amount'] || $settings['text']) { ?>
				<h2 class="te-subtitle"><?php echo wp_kses($settings['amount'], true) ;?> <span class="te-text"><?php echo wp_kses($settings['text'], true) ;?></span></h2>
				<?php };?>
				<div class="icon-box te-icon">
					<?php if( isset( $settings['icons']['library'] ) && 'svg' === $settings['icons']['library'] ) {?>
						<?php \Elementor\Icons_Manager::render_icon( $settings[ 'icons' ] ); ?>
					<?php } else {?>
						<i class="<?php echo esc_attr( $settings[ 'icons' ][ 'value' ] );?>"></i>
					<?php };?>
				</div>
			</div>
		</div>
	</div>

     <?php 
	}
}