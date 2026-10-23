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
use Finspire\Elementor\Traits\Trait_Button;
/**
 * Elementor button widget.
 * Elementor widget that displays a button with the ability to control every
 * aspect of the button design.
 *
 * @since 1.0.0
 */
class Info_Box extends Widget_Base {
    /**
     * Get widget name.
     * Retrieve button widget name.
     *
     * @since  1.0.0
     * @access public
     * @return string Widget name.
     */
    public function get_name() {
        return 'finspire_info_box';
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
        return esc_html__( 'Finspire Info Box', 'finspire' );
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
	use Trait_Icons, Trait_Title, Trait_Text, Trait_Button;
    protected function register_controls() {
        $this->start_controls_section(
            'info_box',
            [
                'label' => esc_html__( 'Info Box', 'finspire' ),
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
					'4' => esc_html__( 'Style Four ', 'finspire'),
					'5' => esc_html__( 'Style Five ', 'finspire'),
				),
			]
		);
		$this->add_control(
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
		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'finspire' ),
				'condition' => [ 'layout_control' => ['1', '2', '3', '5'], ],
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__( 'Enter your Title', 'finspire' ),
				'default' => esc_html__( 'Add Your Title Here', 'finspire' ),
			]
		);
		$this->add_control(
			'info',
			[
				'label' => esc_html__( 'Info', 'finspire' ),
				'condition' => [ 'layout_control' => ['1', '2', '3', '5'], ],
				'type' => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'placeholder' => esc_html__( 'Enter your Info', 'finspire' ),
				'default' => esc_html__( 'Add Your Info Here', 'finspire' ),
			]
		);	
		$this->add_control(
			'btn_title',
			[
				'label'       => __( 'Button Title', 'finspire' ),
				'condition' => [ 'layout_control' => ['2'], ],
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Button Title Here', 'finspire' ),
				'default' => esc_html__( 'Read More', 'finspire' ),
			]
		);	
		$this->add_control(
			'link_option',
			[
				'label'   => esc_html__( 'Select link Option', 'finspire' ),
				'condition' => [ 'layout_control' => ['2', '4'], ],
				'label_block' => true,
				'type'    => Controls_Manager::SELECT,
				'default' => 'extranal',
				'options' => array(
					'extranal' => esc_html__( 'Extranal ', 'finspire'),
					'page' => esc_html__( 'Page ', 'finspire'),
				),
			]
		);		
		$this->add_control(
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
					'link_option' => 'extranal',
					'layout_control' => ['2', '4'],
				]
			]
		);		
		$this->add_control(
			'page_select',
			[
				'label'   => esc_html__( 'Select Page', 'finspire' ),
				'label_block' => true,
				'type'    => Controls_Manager::SELECT2,
				'default' => 'extranal',
				'options' => finspire_page_list(),
				'condition'   => [
					'link_option' => 'page',
					'layout_control' => ['2', '4'],
				]
			]
		);	
		$this->end_controls_section();
		
		//title Style Start *****************
        $this->start_controls_section(
            'titles_style_setting',
            [
                'label' => esc_html__( 'Title Style Setting', 'finspire' ),
				'condition' => [ 'layout_control' => ['1', '2', '3', '5'], ],
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            // Trait se call
            $this->register_text_controls();
        
        $this->end_controls_section();
		
		//title Style Start *****************
        $this->start_controls_section(
            'title_style_setting',
            [
                'label' => esc_html__( 'Info Style Setting', 'finspire' ),
				'condition' => [ 'layout_control' => ['1', '2', '3', '5'], ],
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
		
		//Button Style Start ****************
        $this->start_controls_section(
            'button_style_setting',
            [
                'label' => esc_html__( 'Button Style Setting', 'finspire' ),
				'condition' => [ 'layout_control' => ['2'], ],
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

	<?php if($settings['layout_control'] == '5') : ?>

	<div class="footer-style-four p-0 m-0">
		<div class="contact-widget p-0 m-0">
			<ul class="info-list clearfix">
				<li class="p-0 m-0">
					<div class="icon-box te-icon">
						<?php if( isset( $settings['icons']['library'] ) && 'svg' === $settings['icons']['library'] ) {?>
							<?php \Elementor\Icons_Manager::render_icon( $settings[ 'icons' ] ); ?>
						<?php } else {?>
							<i class="<?php echo esc_attr( $settings[ 'icons' ][ 'value' ] );?>"></i>
						<?php };?>
					</div>
					<?php if($settings['title'] || $settings['info']) { ?>
					<div class="inner">
						<?php if($settings['title']) { ?><span class="te-text"><?php echo wp_kses($settings['title'], true) ;?></span><?php } ?>
						<?php if($settings['info']) { ?><p class="te-title"><?php echo wp_kses($settings['info'], true) ;?></p><?php } ?>
					</div>
					<?php } ?>
				</li>
			</ul>
		</div>
	</div>

	<?php elseif($settings['layout_control'] == '4') : 
		$page = $settings['link_option'];
		$page_select = $settings[ 'page_select' ];
		$ext_url = $settings[ 'btn_link' ];
		
		if( $page == 'page' ){
			$mount_link = get_page_link( $page_select );
		}else{
			$mount_link = $ext_url['url'];
			$target = $ext_url['is_external'] ? ' target="_blank"' : '';
			$nofollow = $ext_url['nofollow'] ? ' rel="nofollow"' : '';
		}
	?>

	<div class="footer-style-two p-0 m-0">
		<div class="footer-lower p-0 m-0">
			<ul class="download-list p-0 m-0">
				<li>
					<a class="te-icon" href="<?php echo esc_url( $mount_link );?>" <?php if( $page == 'extranal' ) echo esc_attr( $target );?> <?php if( $page == 'extranal' ) echo esc_attr( $nofollow );?>>
						<?php if( isset( $settings['icons']['library'] ) && 'svg' === $settings['icons']['library'] ) {?>
							<?php \Elementor\Icons_Manager::render_icon( $settings[ 'icons' ] ); ?>
						<?php } else {?>
							<i class="<?php echo esc_attr( $settings[ 'icons' ][ 'value' ] );?>"></i>
						<?php };?>
					</a>
				</li>
			</ul>
		</div>
	</div>

	<?php elseif($settings['layout_control'] == '3') : ?>

	<div class="testimonial-style-two p-0 m-0">
		<div class="left-content p-0 m-0">
			<ul class="info-list clearfix p-0 m-0">
				<li>
					<div class="icon-box te-icon">
						<?php if( isset( $settings['icons']['library'] ) && 'svg' === $settings['icons']['library'] ) {?>
							<?php \Elementor\Icons_Manager::render_icon( $settings[ 'icons' ] ); ?>
						<?php } else {?>
							<i class="<?php echo esc_attr( $settings[ 'icons' ][ 'value' ] );?>"></i>
						<?php };?>
					</div>
					<?php if($settings['title'] || $settings['info']) { ?>
					<div class="inner">
						<?php if($settings['title']) { ?><span class="te-text"><?php echo wp_kses($settings['title'], true) ;?></span><?php } ?>
						<?php if($settings['info']) { ?><p class="te-title"><?php echo wp_kses($settings['info'], true) ;?></p><?php } ?>
					</div>
					<?php } ?>
				</li>
			</ul>
		</div>
	</div>

	<?php elseif($settings['layout_control'] == '2') : 
		$page = $settings['link_option'];
		$page_select = $settings[ 'page_select' ];
		$ext_url = $settings[ 'btn_link' ];
		
		if( $page == 'page' ){
			$mount_link = get_page_link( $page_select );
		}else{
			$mount_link = $ext_url['url'];
			$target = $ext_url['is_external'] ? ' target="_blank"' : '';
			$nofollow = $ext_url['nofollow'] ? ' rel="nofollow"' : '';
		}
	?>

	<div class="te-cus-info2">
		<div class="info-inner">
			<div class="inner">
				<div class="icon-box te-icon">
					<?php if( isset( $settings['icons']['library'] ) && 'svg' === $settings['icons']['library'] ) {?>
						<?php \Elementor\Icons_Manager::render_icon( $settings[ 'icons' ] ); ?>
					<?php } else {?>
						<i class="<?php echo esc_attr( $settings[ 'icons' ][ 'value' ] );?>"></i>
					<?php };?>
				</div>
				<?php if($settings['title'] || $settings['info']) { ?>
				<div class="info-text">
					<?php if($settings['title']) { ?><p class="te-text"><?php echo wp_kses($settings['title'], true) ;?></p><?php } ?>
					<?php if($settings['info']) { ?>
					<span class="te-title"><?php echo wp_kses($settings['info'], true) ;?></span>
					<?php } ?>
				</div>
				<?php } ?>
			</div>
			<?php if($settings['btn_title']) { ?>
			<div class="link-box">
				<a class="te-btn" href="<?php echo esc_url( $mount_link );?>" <?php if( $page == 'extranal' ) echo esc_attr( $target );?> <?php if( $page == 'extranal' ) echo esc_attr( $nofollow );?>><i class="flaticon-two-lines"></i><span><?php echo wp_kses($settings['btn_title'], true) ;?></span></a>
			</div>
			<?php } ?>
		</div>
	</div>

	<?php else : ?>

	<div class="te-cus-info te-icon">
		<?php if( isset( $settings['icons']['library'] ) && 'svg' === $settings['icons']['library'] ) {?>
			<?php \Elementor\Icons_Manager::render_icon( $settings[ 'icons' ] ); ?>
		<?php } else {?>
			<i class="<?php echo esc_attr( $settings[ 'icons' ][ 'value' ] );?>"></i>
		<?php };?>
		<p class="te-title"><span class="te-text"><?php echo wp_kses($settings['title'], true) ;?></span> <?php echo wp_kses($settings['info'], true) ;?></p>
	</div>

	<?php endif; ?>
    <?php 
    }
}