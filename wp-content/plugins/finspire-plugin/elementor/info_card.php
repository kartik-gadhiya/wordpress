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
use Finspire\Elementor\Traits\Trait_Icons;
use Finspire\Elementor\Traits\Trait_Title;
use Finspire\Elementor\Traits\Trait_Text;
use Finspire\Elementor\Traits\Trait_SubTitle;
/**
 * Elementor button widget.
 * Elementor widget that displays a button with the ability to control every
 * aspect of the button design.
 *
 * @since 1.0.0
 */
class Info_Card extends Widget_Base {
    /**
     * Get widget name.
     * Retrieve button widget name.
     *
     * @since  1.0.0
     * @access public
     * @return string Widget name.
     */
    public function get_name() {
        return 'finspire_info_card';
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
        return esc_html__( 'Finspire Info Card', 'finspire' );
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
	use Trait_Icons, Trait_Title, Trait_Text, Trait_SubTitle;
    protected function register_controls() {
        $this->start_controls_section(
            'info_card',
            [
                'label' => esc_html__( 'Info Card', 'finspire' ),
            ]
        );
		$this->add_control(
			't_title',
			[
				'label' => esc_html__( 'Title', 'finspire' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__( 'Enter your Title', 'finspire' ),
				'default' => esc_html__( 'Add Your Title Here', 'finspire' ),
			]
		);
		$repeater = new Repeater();
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
				'label' => esc_html__( 'Title', 'finspire' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__( 'Enter your Title', 'finspire' ),
				'default' => esc_html__( 'Add Your Title Here', 'finspire' ),
			]
		);
		$repeater->add_control(
			'info',
			[
				'label' => esc_html__( 'Info', 'finspire' ),
				'type' => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'placeholder' => esc_html__( 'Enter your Info', 'finspire' ),
				'default' => esc_html__( 'Add Your Info Here', 'finspire' ),
			]
		);	
		$this->add_control(
			'slide_v2',
			[
				'label'                 => __('Add Info Item', 'finspire'),
				'type'                  => Controls_Manager::REPEATER,
				'fields'                => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
				'default' => [
					[
						'title' => esc_html__( 'Info Title', 'finspire' ),
						'info' => esc_html__( 'Add Your Info Here', 'finspire' ),
					],
					[
						'title' => esc_html__( 'Info Title', 'finspire' ),
						'info' => esc_html__( 'Add Your Info Here', 'finspire' ),
					],
				],
			]
		);
		$this->end_controls_section();
		
		//title Style Start *****************
        $this->start_controls_section(
            'titles_style_setting',
            [
                'label' => esc_html__( 'Title Style Setting', 'finspire' ),
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
                'label' => esc_html__( 'Info Title Style', 'finspire' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_subtitle_controls();
        
        $this->end_controls_section();
		
		//title Style Start *****************
        $this->start_controls_section(
            'title_style_setting',
            [
                'label' => esc_html__( 'Info Style Setting', 'finspire' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_title_controls();
        
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

	<div class="faq-section p-0 m-0">
		<div class="left-content p-0 m-0">
			<div class="info-box">
				<?php if($settings['t_title']) { ?><h3 class="te-text"><?php echo wp_kses($settings['t_title'], true) ;?></h3><?php } ?>
				<ul class="info-list clear">
					<?php foreach($settings['slide_v2'] as $key => $item): ?>
					<li>
						<div class="icon-box te-icon">
							<?php if( isset( $item['icons']['library'] ) && 'svg' === $item['icons']['library'] ) {?>
								<?php \Elementor\Icons_Manager::render_icon( $item[ 'icons' ] ); ?>
							<?php } else {?>
								<i class="<?php echo esc_attr( $item[ 'icons' ][ 'value' ] );?>"></i>
							<?php };?>
						</div>
						<?php if($item['title'] || $item['info']) { ?>
						<div class="inner te-title">
							<span class="te-subtitle"><?php echo wp_kses($item['title'], true) ;?></span>
							<?php echo wp_kses($item['info'], true) ;?>
						</div>
						<?php } ?>
					</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>

    <?php 
    }
}