<?php

//Footer Widgets
//About Widget
class Finspire_About_Widget extends WP_Widget
{
	
	/** constructor */
	function __construct()
	{
		parent::__construct( /* Base ID */'Finspire_About_Widget', /* Name */esc_html__('Finspire About Widget','finspire'), array( 'description' => esc_html__('Show About Widget', 'finspire' )) );
	}

	/** @see WP_Widget::widget */
	function widget($args, $instance)
	{
		extract( $args );
		
		echo wp_kses($before_widget, true);?>

		<div class="address-widget">
			<?php if($instance['blog_swidget_title']){?><h5><?php echo wp_kses($instance['blog_swidget_title'], true); ?></h5><?php } ?>
			<?php if($instance['blog_swidget_text']){?>
            <p><?php echo wp_kses($instance['blog_swidget_text'], true); ?></p>
            <?php } ?>
			<?php if($instance['blog_swidget_btn_title']){?>
			<a href="<?php echo esc_url($instance['blog_swidget_btn_link']); ?>" target="_blank" class="theme-btn white-bg"><div class="icon-box"><span class="static-icon"><i class="flaticon-two-lines"></i></span><span class="overlay-icon"><i class="flaticon-two-lines"></i></span></div><span class="text"><?php echo wp_kses($instance['blog_swidget_btn_title'], true); ?></span></a>
			<?php } ?>
		</div>
            
        <?php
		
		echo wp_kses($after_widget, true);
	}
	
	
	/** @see WP_Widget::update */
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		$instance['blog_swidget_title'] = strip_tags($new_instance['blog_swidget_title']);
		$instance['blog_swidget_text'] = $new_instance['blog_swidget_text'];
		$instance['blog_swidget_btn_title'] = $new_instance['blog_swidget_btn_title'];
		$instance['blog_swidget_btn_link'] = $new_instance['blog_swidget_btn_link'];
		return $instance;
	}

	/** @see WP_Widget::form */
	function form($instance)
	{
		$blog_swidget_title = ($instance) ? esc_attr($instance['blog_swidget_title']) : 'Growing with Smart Ideas';
		$blog_swidget_text = ($instance) ? esc_attr($instance['blog_swidget_text']) : 'Contact an expert Advanced Business analytics';
		$blog_swidget_btn_title = ($instance) ? esc_attr($instance['blog_swidget_btn_title']) : 'Support Now';
		$blog_swidget_btn_link = ($instance) ? esc_attr($instance['blog_swidget_btn_link']) : '#';
		
		?>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('blog_swidget_title')); ?>"><?php esc_html_e('Title:', 'finspire'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('blog_swidget_title')); ?>" name="<?php echo esc_attr($this->get_field_name('blog_swidget_title')); ?>" type="text" value="<?php echo esc_attr($blog_swidget_title); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('blog_swidget_text')); ?>"><?php esc_html_e('Text:', 'finspire'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('blog_swidget_text')); ?>" name="<?php echo esc_attr($this->get_field_name('blog_swidget_text')); ?>" type="text" value="<?php echo esc_attr($blog_swidget_text); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('blog_swidget_btn_title')); ?>"><?php esc_html_e('Button Title:', 'finspire'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('blog_swidget_btn_title')); ?>" name="<?php echo esc_attr($this->get_field_name('blog_swidget_btn_title')); ?>" type="text" value="<?php echo esc_attr($blog_swidget_btn_title); ?>" />
        </p> 
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('blog_swidget_btn_link')); ?>"><?php esc_html_e('Button Link:', 'finspire'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('blog_swidget_btn_link')); ?>" name="<?php echo esc_attr($this->get_field_name('blog_swidget_btn_link')); ?>" type="text" value="<?php echo esc_attr($blog_swidget_btn_link); ?>" />
        </p>
                
		<?php 
	}
	
}

//Contact Widget
class Finspire_Contact_Widget extends WP_Widget
{
	
	/** constructor */
	function __construct()
	{
		parent::__construct( /* Base ID */'Finspire_Contact_Widget', /* Name */esc_html__('Finspire Contact Widget','finspire'), array( 'description' => esc_html__('Show Contact Widget', 'finspire' )) );
	}

	/** @see WP_Widget::widget */
	function widget($args, $instance)
	{
		extract( $args );
		
		echo wp_kses($before_widget, true);?>

		<div class="contact-widget footer-widget">
			<ul class="info-list clearfix">
				<?php if($instance['phone_title'] || $instance['phone']){?>
				<li>
					<div class="icon-box"><i class="flaticon-call"></i></div>
					<div class="inner">
						<?php if($instance['phone_title']){?><span><?php echo wp_kses( $instance['phone_title'], true );?></span><?php };?>
						<?php if($instance['phone']){?>
						<p><a href="tel:<?php echo esc_attr( $instance['phone'] );?>"><?php echo wp_kses( $instance['phone'], true );?></a></p>
						<?php };?>
					</div>
				</li>
				<?php };?>
				<?php if($instance['email_title'] || $instance['email']){?>
				<li>
					<div class="icon-box"><i class="flaticon-email"></i></div>
					<div class="inner">
						<?php if($instance['email_title']){?><span><?php echo wp_kses( $instance['email_title'], true );?></span><?php };?>
						<?php if($instance['email']){?>
						<p><a href="mailto:<?php echo esc_attr( $instance['email'] );?>"><?php echo wp_kses( $instance['email'], true );?></a></p>
						<?php };?>
					</div>
				</li>
				<?php };?>
				<?php if($instance['opening_title'] || $instance['opening_hours']){?>
				<li>
					<div class="icon-box"><i class="flaticon-alarm"></i></div>
					<div class="inner">
						<?php if($instance['opening_title']){?><span><?php echo wp_kses( $instance['opening_title'], true );?></span><?php };?>
						<?php if($instance['opening_hours']){?><p><?php echo wp_kses( $instance['opening_hours'], true );?></p><?php };?>
					</div>
				</li>
				<?php };?>
			</ul>
		</div>		
            
        <?php
		
		echo wp_kses($after_widget, true);
	}
	
	
	/** @see WP_Widget::update */
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		$instance['phone_title'] = strip_tags($new_instance['phone_title']);
		$instance['phone'] = $new_instance['phone'];
		$instance['email_title'] = $new_instance['email_title'];
		$instance['email'] = $new_instance['email'];
		$instance['opening_title'] = $new_instance['opening_title'];
		$instance['opening_hours'] = $new_instance['opening_hours'];
		return $instance;
	}

	/** @see WP_Widget::form */
	function form($instance)
	{
		$phone_title = ($instance) ? esc_attr($instance['phone_title']) : 'Our Office';
		$phone = ($instance) ? esc_attr($instance['phone']) : '(+88) 10.11.44.574';
		$email_title = ($instance) ? esc_attr($instance['email_title']) : 'Suite 130 1200 Saint-Martin West Blvd. Laval, Quebec USA';
		$email = ($instance) ? esc_attr($instance['email']) : 'support@example.com';
		$opening_title = ($instance) ? esc_attr($instance['opening_title']) : 'Our Office';
		$opening_hours = ($instance) ? esc_attr($instance['opening_hours']) : 'Openign Hours';
		
		?>
       
       	<p>
            <label for="<?php echo esc_attr($this->get_field_id('phone_title')); ?>"><?php esc_html_e('Phone Title:', 'finspire'); ?></label>
            <input placeholder="<?php esc_attr_e('Title here', 'finspire');?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('phone_title')); ?>" name="<?php echo esc_attr($this->get_field_name('phone_title')); ?>" type="text" value="<?php echo esc_attr($phone_title); ?>" />
        </p>  
		<p>
            <label for="<?php echo esc_attr($this->get_field_id('phone')); ?>"><?php esc_html_e('Phone:', 'finspire'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('phone')); ?>" name="<?php echo esc_attr($this->get_field_name('phone')); ?>" type="text" value="<?php echo esc_attr($phone); ?>" />
        </p>
		<p>
            <label for="<?php echo esc_attr($this->get_field_id('email_title')); ?>"><?php esc_html_e('Email Title:', 'finspire'); ?></label>
            <textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('email_title')); ?>" name="<?php echo esc_attr($this->get_field_name('email_title')); ?>" ><?php echo wp_kses_post($email_title); ?></textarea>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('email')); ?>"><?php esc_html_e('Email:', 'finspire'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('email')); ?>" name="<?php echo esc_attr($this->get_field_name('email')); ?>" type="text" value="<?php echo esc_attr($email); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('opening_title')); ?>"><?php esc_html_e('Opening Hours Title:', 'finspire'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('opening_title')); ?>" name="<?php echo esc_attr($this->get_field_name('opening_title')); ?>" type="text" value="<?php echo esc_attr($opening_title); ?>" />
        </p>
		<p>
            <label for="<?php echo esc_attr($this->get_field_id('opening_hours')); ?>"><?php esc_html_e('Opening Hours:', 'finspire'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('opening_hours')); ?>" name="<?php echo esc_attr($this->get_field_name('opening_hours')); ?>" type="text" value="<?php echo esc_attr($opening_hours); ?>" />
        </p>
                
		<?php 
	}
	
}

//Blog Widgets
//Popular Post
class Finspire_Popular_Post extends WP_Widget
{
    /** constructor */
    public function __construct()
    {
        parent::__construct( /* Base ID */'Finspire_Popular_Post', /* Name */esc_html__('Finspire Blog Popular Post', 'finspire'), array( 'description' => esc_html__('Show Blog Popular Post', 'finspire')));
    }


    /** @see WP_Widget::widget */
    public function widget($args, $instance)
    {
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);

        echo wp_kses($before_widget, true); ?>
        
		<div class="post-widget">
			<?php echo wp_kses($before_title.$title.$after_title, true); ?>
			<div class="post-inner">
				<?php $query_string = array('showposts'=>$instance['number']);
					if ($instance['cat']) {
						$query_string['tax_query'] = array(array('taxonomy' => 'category','field' => 'id','terms' => (array)$instance['cat']));
					}
					$this->posts($query_string); 
				?>
			</div>
		</div>
        
        <?php echo wp_kses($after_widget, true);
    }


    /** @see WP_Widget::update */
    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;

        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = $new_instance['number'];
        $instance['cat'] = $new_instance['cat'];

        return $instance;
    }

    /** @see WP_Widget::form */
    public function form($instance)
    {
        $title = ($instance) ? esc_attr($instance['title']) : esc_html__('Popular Post', 'finspire');
        $number = ($instance) ? esc_attr($instance['number']) : 3;
        $cat = ($instance) ? esc_attr($instance['cat']) : ''; ?>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title: ', 'finspire'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e('No. of Posts:', 'finspire'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="text" value="<?php echo esc_attr($number); ?>" />
        </p>
		<p>
            <label for="<?php echo esc_attr($this->get_field_id('categories')); ?>"><?php esc_html_e('Category', 'finspire'); ?></label>
            <?php wp_dropdown_categories(array('show_option_all'=>esc_html__('All Categories', 'finspire'), 'taxonomy' => 'category', 'selected'=>$cat, 'class'=>'widefat', 'name'=>$this->get_field_name('cat'))); ?>
        </p>

        <?php
    }

    public function posts($query_string)
    {
        $query = new WP_Query($query_string);
        if ($query->have_posts()):?>

            <!-- Title -->
            <?php
                global $post;
				while ($query->have_posts()): $query->the_post();
				$post_thumbnail_id = get_post_thumbnail_id($post->ID);
				$post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id );
			?>
			<div class="post">
				<?php if(has_post_thumbnail()){ ?>
				<figure class="post-thumb"><a href="<?php echo esc_url( get_the_permalink( get_the_id() ) );?>"><?php the_post_thumbnail('finspire_100x100'); ?></a></figure>
				<?php } ?>
				<h5><a href="<?php echo esc_url( get_the_permalink( get_the_id() ) );?>"><?php the_title();?></a></h5>
			</div>
			<?php endwhile; ?>

        <?php endif;
        wp_reset_postdata();
    }
}
