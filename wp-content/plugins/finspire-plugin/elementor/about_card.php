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
use Finspire\Elementor\Traits\Trait_SubTitle;
use Finspire\Elementor\Traits\Trait_Title;
use Finspire\Elementor\Traits\Trait_Text;
use Finspire\Elementor\Traits\Trait_Image;
use Finspire\Elementor\Traits\Trait_Icons;

/**
 * Elementor button widget.
 * Elementor widget that displays a button with the ability to control every
 * aspect of the button design.
 *
 * @since 1.0.0
 */
class About_Card extends Widget_Base {
	/**
	 * Get widget name.
	 * Retrieve button widget name.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'finspire_about_card';
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
		return esc_html__( 'Finspire About Card', 'finspire' );
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
	use Trait_Background, Trait_SubTitle, Trait_Title, Trait_Text, Trait_Image, Trait_Icons;
	protected function register_controls() {
		$this->start_controls_section(
			'about_card',
			[
				'label' => esc_html__( 'About Card', 'finspire' ),
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
				),
			]
		);
		$this->add_control(
			'block_img',
			[
				'label' => __( 'Background Image', 'finspire' ),
				'condition' => [ 'layout_control' => ['1', '3', '4'], ],
				'type' => Controls_Manager::MEDIA,
				'default' => ['url' => Utils::get_placeholder_image_src(),],
			]
		);
		$this->add_control(
			'icons',
			[
				'label' => esc_html__('Enter icons', 'finspire'),
				'condition' => [ 'layout_control' => ['1', '3', '4'], ],
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'flaticon-mozy',
					'library' => 'solid',
				],
			]			
		);
		$this->add_control(
			'years',
			[
				'label'       => __( 'Experience Years', 'finspire' ),
				'condition' => [ 'layout_control' => ['3'], ],
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Experience Years', 'finspire' ),
				'default' => esc_html__( '16+', 'finspire' ),
			]
		);
		$this->add_control(
			'y_title',
			[
				'label'       => __( 'Experience Title', 'finspire' ),
				'condition' => [ 'layout_control' => ['3'], ],
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Experience Title', 'finspire' ),
				'default' => esc_html__( 'Experience Title', 'finspire' ),
			]
		);
		$this->add_control(
			'subtitle',
			[
				'label'       => __( 'Sub Title', 'finspire' ),
				'condition' => [ 'layout_control' => ['1'], ],
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Sub Title', 'finspire' ),
				'default' => esc_html__( 'Add Your Sub Title Here', 'finspire' ),
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
				'default' => esc_html__( 'Add Your Title Here', 'finspire' ),
			]
		);
		$this->add_control(
			'block_text',
			[
				'label'       => __( 'Text', 'finspire' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Text', 'finspire' ),
				'default' => esc_html__( 'Add Your Text Here', 'finspire' ),
			]
		);
		$this->add_control(
			'block_title2',
			[
				'label'       => __( 'Block Title 02', 'finspire' ),
				'condition' => [ 'layout_control' => ['3'], ],
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Block Title', 'finspire' ),
				'default' => esc_html__( 'Add Your Title Here', 'finspire' ),
			]
		);
		$this->add_control(
			'block_text2',
			[
				'label'       => __( 'Text 02', 'finspire' ),
				'condition' => [ 'layout_control' => ['3'], ],
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Text', 'finspire' ),
				'default' => esc_html__( 'Add Your Text Here', 'finspire' ),
			]
		);
		$this->add_control(
			'features_list',
			[
				'label'       => __( 'Features List', 'finspire' ),
				'condition' => [ 'layout_control' => ['4'], ],
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Features List', 'finspire' ),
			]
		);
		$this->add_control(
			'btn_title',
			[
				'label'       => __( 'Button Title', 'finspire' ),
				'condition' => [ 'layout_control' => ['3', '4'], ],
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your Button Title', 'finspire' ),
				'default' => esc_html__( 'More About Us', 'finspire' ),
			]
		);
		$this->add_control(
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
					'link_option' => 'extranal'
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
					'link_option' => 'page'
				]
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
                'label' => esc_html__( 'Subtitle Style Setting', 'finspire' ),
				'condition' => [ 'layout_control' => ['1'], ],
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
				'condition' => [ 'layout_control' => ['1', '3', '4'], ],
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
                'label' => esc_html__( 'Icon Style Setting', 'finspire' ),
				'condition' => [ 'layout_control' => ['1', '3', '4'], ],
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

	<?php if($settings['layout_control'] == '4') : 
		// block_img
		$feature_img  = $settings['block_img'];
		if( !empty($feature_img['id']) ){
			$mount_fimg = wp_get_attachment_url($feature_img['id']);
		} else {
			$mount_fimg = $feature_img['url'];
		}
	?>
	<div class="about-style-three p-0 m-0">
		<div class="right-content p-0 m-0">
			<div class="inner-box te-bg">
				<div class="shape te-img" style="background-image: url(<?php echo esc_url( $mount_fimg );?>);"></div>
				<?php if($settings['block_title']) { ?><div class="title-text"><h3><?php echo wp_kses($settings['block_title'], true) ;?></h3></div><?php } ?>
				<?php if ( ! empty( $settings['icons']['value'] ) ) : ?>
				<div class="light-icon te-icon">
					<?php if ( isset( $settings['icons']['library'] ) && 'svg' === $settings['icons']['library'] ) : ?>
						<?php \Elementor\Icons_Manager::render_icon( $settings['icons'] ); ?>
					<?php else : ?>
						<i class="<?php echo esc_attr( $settings['icons']['value'] ); ?>"></i>
					<?php endif; ?>
				</div>
			<?php endif; ?>
				<?php if($settings['block_text']) { ?><p class="te-text"><?php echo wp_kses($settings['block_text'], true) ;?></p><?php } ?>
				<?php 
				$features_list = $settings['features_list'];
				if(!empty($features_list)){
					$features_list = explode("\n", $features_list); 
				?>
				<ul class="list-style-two clearfix">
					<?php foreach($features_list as $features): ?>
					<li><i class="flaticon-check"></i><span><?php echo wp_kses($features, true); ?></span></li>
					<?php endforeach; ?>
				</ul>
				<?php };?>
				<?php if($settings['btn_title']) { ?>
				<div class="btn-box"><a href="<?php echo esc_url( $mount_link );?>" <?php if( $page == 'extranal' ) echo esc_attr( $target );?> <?php if( $page == 'extranal' ) echo esc_attr( $nofollow );?> class="theme-btn white-bg te-btn"><div class="icon-box"><span class="static-icon"><i class="flaticon-two-lines"></i></span><span class="overlay-icon"><i class="flaticon-two-lines"></i></span></div><span class="text"><?php echo wp_kses($settings['btn_title'], true) ;?></span></a></div>
				<?php } ?>
			</div>
		</div>
	</div>

	<?php elseif($settings['layout_control'] == '3') : 
		// block_img
		$feature_img  = $settings['block_img'];
		if( !empty($feature_img['id']) ){
			$mount_fimg = wp_get_attachment_url($feature_img['id']);
		} else {
			$mount_fimg = $feature_img['url'];
		}
	?>

	<div class="about-style-three p-0 m-0">
		<div class="right-content p-0 m-0">
			<div class="inner-box te-bg">
				<div class="shape te-img" style="background-image: url(<?php echo esc_url( $mount_fimg );?>);"></div>
				<?php if($settings['block_title']) { ?><div class="title-text"><h3><?php echo wp_kses($settings['block_title'], true) ;?></h3></div><?php } ?>
				<?php if($settings['years'] || $settings['y_title']) { ?>
				<div class="count-box">
					<?php if($settings['years']) { ?><h2><?php echo wp_kses($settings['years'], true) ;?></h2><?php } ?>
					<?php if($settings['y_title']) { ?><h6><?php echo wp_kses($settings['y_title'], true) ;?></h6><?php } ?>
				</div>
				<?php } ?>
				<?php if($settings['block_text']) { ?><p class="te-text"><?php echo wp_kses($settings['block_text'], true) ;?></p><?php } ?>
				<div class="icon te-icon">
					<?php if( isset( $settings['icons']['library'] ) && 'svg' === $settings['icons']['library'] ) {?>
						<?php \Elementor\Icons_Manager::render_icon( $settings[ 'icons' ] ); ?>
					<?php } else {?>
						<i class="<?php echo esc_attr( $settings[ 'icons' ][ 'value' ] );?>"></i>
					<?php };?>
				</div>
				<?php if($settings['block_title2']) { ?><h3 class="te-title"><?php echo wp_kses($settings['block_title2'], true) ;?></h3><?php } ?>
				<?php if($settings['block_text2']) { ?><p class="te-text"><?php echo wp_kses($settings['block_text2'], true) ;?></p><?php } ?>
				<?php if($settings['btn_title']) { ?>
				<div class="btn-box"><a href="<?php echo esc_url( $mount_link );?>" <?php if( $page == 'extranal' ) echo esc_attr( $target );?> <?php if( $page == 'extranal' ) echo esc_attr( $nofollow );?> class="theme-btn white-bg te-btn"><div class="icon-box"><span class="static-icon"><i class="flaticon-two-lines"></i></span><span class="overlay-icon"><i class="flaticon-two-lines"></i></span></div><span class="text"><?php echo wp_kses($settings['btn_title'], true) ;?></span></a></div>
				<?php } ?>
			</div>
		</div>
	</div>

	<?php elseif($settings['layout_control'] == '2') : ?>

	<div class="approach-block-one te-bg">
		<div class="text-box">
			<?php if($settings['block_title']) { ?><h3><a class="te-title" href="<?php echo esc_url( $mount_link );?>" <?php if( $page == 'extranal' ) echo esc_attr( $target );?> <?php if( $page == 'extranal' ) echo esc_attr( $nofollow );?>><?php echo wp_kses($settings['block_title'], true) ;?></a></h3><?php } ?>
			<?php if($settings['block_text']) { ?><p class="te-text"><?php echo wp_kses($settings['block_text'], true) ;?></p><?php } ?>
		</div>
		<div class="link-box"><a href="<?php echo esc_url( $mount_link );?>" <?php if( $page == 'extranal' ) echo esc_attr( $target );?> <?php if( $page == 'extranal' ) echo esc_attr( $nofollow );?>><i class="flaticon-two-lines"></i></a></div>
	</div>

	<?php else : 
		// block_img
		$feature_img  = $settings['block_img'];
		if( !empty($feature_img['id']) ){
			$mount_fimg = wp_get_attachment_url($feature_img['id']);
		} else {
			$mount_fimg = $feature_img['url'];
		}
	?>

	<div class="about-block-one te-bg">
		<div class="shape te-img" style="background-image: url(<?php echo esc_url( $mount_fimg );?>);"></div>
		<div class="icon-box te-icon">
			<?php if( isset( $settings['icons']['library'] ) && 'svg' === $settings['icons']['library'] ) {?>
				<?php \Elementor\Icons_Manager::render_icon( $settings[ 'icons' ] ); ?>
			<?php } else {?>
				<i class="<?php echo esc_attr( $settings[ 'icons' ][ 'value' ] );?>"></i>
			<?php };?>
		</div>
		<?php if($settings['subtitle']) { ?><span class="decor-text te-subtitle"><?php echo wp_kses($settings['subtitle'], true) ;?></span><?php } ?>
		<?php if($settings['block_title']) { ?><h3><a class="te-title" href="<?php echo esc_url( $mount_link );?>" <?php if( $page == 'extranal' ) echo esc_attr( $target );?> <?php if( $page == 'extranal' ) echo esc_attr( $nofollow );?>><?php echo wp_kses($settings['block_title'], true) ;?></a></h3><?php } ?>
		<?php if($settings['block_text']) { ?><p class="te-text"><?php echo wp_kses($settings['block_text'], true) ;?></p><?php } ?>
		<div class="link"><a href="<?php echo esc_url( $mount_link );?>" <?php if( $page == 'extranal' ) echo esc_attr( $target );?> <?php if( $page == 'extranal' ) echo esc_attr( $nofollow );?>><i class="flaticon-two-lines"></i></a></div>
	</div>

     <?php endif;
	}
}