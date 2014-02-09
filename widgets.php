<?php 

/*-----------------------------------------------------------------------------------*/
/*	CONTACT WIDGET
/*-----------------------------------------------------------------------------------*/
add_action('widgets_init', 'ebor_contact_load_widgets');
function ebor_contact_load_widgets()
{
	register_widget('ebor_contact_Widget');
}

class ebor_contact_Widget extends WP_Widget {
	
	function ebor_contact_Widget()
	{
		$widget_ops = array('classname' => 'ebor_contact', 'description' => '');

		$control_ops = array('id_base' => 'ebor_contact-widget');

		$this->WP_Widget('ebor_contact-widget', 'Rise: Contact Details', $widget_ops, $control_ops);
	}
	
	function widget($args, $instance)
	{
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$subtitle = $instance['subtitle'];
		
		$icons = array(
			$instance['social_icon_1'],
			$instance['social_icon_2'],
			$instance['social_icon_3'],
			$instance['social_icon_4'],
			$instance['social_icon_5'],
		);
		
		$links = array(
			$instance['social_icon_link_1'],
			$instance['social_icon_link_2'],
			$instance['social_icon_link_3'],
			$instance['social_icon_link_4'],
			$instance['social_icon_link_5'],
		);
		
		$links = array_filter(array_map(NULL, $links)); 

		echo $before_widget;

		echo '<section class="row heading">';
			
		if($title)
			echo '<h4 class="section-title widget-title">'. $title .'</h4>';
			
		if($subtitle)
			echo '<h5 class="centered grey-text">'. $subtitle .'</h5>';
		
		echo '</section>';
	?>
    	
		<ul class="ring-list">
			<?php 
				if( $instance['phone'] || $instance['email'] )
					echo '<li class="fade"><a href="#" class="switch" gumby-trigger="#phone-info"><i class="icon-phone"></i></a></li>';
				foreach( $links as $index => $link ){
					echo '<li><a href="'. $link .'" target="_blank"><i class="'. $icons[$index] .'"></i></a></li>';
				}
			?>
		</ul>

    	<div class="modal" id="phone-info">
    		<div class="content white">
    			<a class="close switch" gumby-trigger="|#phone-info"><i class="white-text icon-remove"></i></a>
    			<div class="row">
    				<?php
    					if( $title )
    						echo '<h4 class="s-bold">'. strtoupper($title) .'</h4>';
    					if( $instance['modal_subtitle'] )
    					 echo wpautop($instance['modal_subtitle']);

    					if( $instance['phone'] )
    						echo '<h3 class="grey-label">'. $instance['phone'] .'</h3>';
    						
    					if( $instance['email'] )
    						echo '<h3 class="grey-label">'. $instance['email'] .'</h3>';
    				?>
    			</div>
    		</div>
    	</div>
		
	<?php 
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['subtitle'] = esc_textarea($new_instance['subtitle']);
		$instance['modal_subtitle'] = esc_textarea($new_instance['modal_subtitle']);
		$instance['social_icon_1'] = strip_tags($new_instance['social_icon_1']);
		$instance['social_icon_2'] = strip_tags($new_instance['social_icon_2']);
		$instance['social_icon_3'] = strip_tags($new_instance['social_icon_3']);
		$instance['social_icon_4'] = strip_tags($new_instance['social_icon_4']);
		$instance['social_icon_5'] = strip_tags($new_instance['social_icon_5']);
		$instance['social_icon_link_1'] = esc_url($new_instance['social_icon_link_1']);
		$instance['social_icon_link_2'] = esc_url($new_instance['social_icon_link_2']);
		$instance['social_icon_link_3'] = esc_url($new_instance['social_icon_link_3']);
		$instance['social_icon_link_4'] = esc_url($new_instance['social_icon_link_4']);
		$instance['social_icon_link_5'] = esc_url($new_instance['social_icon_link_5']);
		$instance['phone'] = strip_tags($new_instance['phone']);
		$instance['email'] = strip_tags($new_instance['email']);

		return $instance;
	}

	function form($instance)
	{
		$defaults = array(
			'title' => 'Come Find Me', 
			'subtitle' => 'I am usually cooking something up at one of these social networks. Lets be friends.',
			'social_icon_1' => 'none',
			'social_icon_2' => 'none',
			'social_icon_3' => 'none',
			'social_icon_4' => 'none',
			'social_icon_5' => 'none',
			'social_icon_link_1' => '',
			'social_icon_link_2' => '',
			'social_icon_link_3' => '',
			'social_icon_link_4' => '',
			'social_icon_link_5' => '',
			'phone' => '',
			'email' => '',
			'modal_subtitle' => ''
		);
		
		$social_options = array(
				array( 'value' => 'none', 'name' => 'None'),
				array( 'value' => 'icon-bitbucket', 'name' => 'Bitbucket Social Link'),
				array( 'value' => 'icon-bitbucket-sign', 'name' => 'Bitbucket Social Link (alt)'),
				array( 'value' => 'icon-dribbble', 'name' => 'Dribbble Social Link'),
				array( 'value' => 'icon-dropbox', 'name' => 'Dropbox Social Link'),
				array( 'value' => 'icon-facebook', 'name' => 'Facebook Social Link'),
				array( 'value' => 'icon-facebook-sign', 'name' => 'Facebook Social Link (alt)'),
				array( 'value' => 'icon-flickr', 'name' => 'Flickr Social Link'),
				array( 'value' => 'icon-foursquare', 'name' => 'Foursquare Social Link'),
				array( 'value' => 'icon-github', 'name' => 'Github Social Link'),
				array( 'value' => 'icon-github-alt', 'name' => 'Github Social Link (alt)'),
				array( 'value' => 'icon-github-sign', 'name' => 'Github Social Link (alt 2)'),
				array( 'value' => 'icon-google-plus', 'name' => 'Google+ Social Link'),
				array( 'value' => 'icon-google-plus-sign', 'name' => 'Google+ Social Link (alt)'),
				array( 'value' => 'icon-instagram', 'name' => 'Instagram Social Link'),
				array( 'value' => 'icon-linkedin', 'name' => 'LinkedIn Social Link'),
				array( 'value' => 'icon-linkedin-sign', 'name' => 'LinkedIn Social Link (alt)'),
				array( 'value' => 'icon-pinterest', 'name' => 'Pinterest Social Link'),
				array( 'value' => 'icon-pinterest-sign', 'name' => 'Pinterest Social Link (alt)'),
				array( 'value' => 'icon-skype', 'name' => 'Skype Social Link'),
				array( 'value' => 'icon-stackexchange', 'name' => 'Stackexchange Social Link'),
				array( 'value' => 'icon-tumblr', 'name' => 'Tumblr Social Link'),
				array( 'value' => 'icon-tumblr-sign', 'name' => 'Tumblr Social Link (alt)'),
				array( 'value' => 'icon-twitter', 'name' => 'Twitter Social Link'),
				array( 'value' => 'icon-twitter-sign', 'name' => 'Twitter Social Link (alt)'),
				array( 'value' => 'icon-xing', 'name' => 'Xing Social Link'),
				array( 'value' => 'icon-xing-sign', 'name' => 'Xing Social Link (alt)'),
				array( 'value' => 'icon-youtube', 'name' => 'Youtube Social Link'),
				array( 'value' => 'icon-youtube-play', 'name' => 'Youtube Social Link (alt)'),
				array( 'value' => 'icon-youtube-sign', 'name' => 'Youtube Social Link (alt 2)')
		);
		
		$instance = wp_parse_args((array) $instance, $defaults); 
	?>
		
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('subtitle'); ?>">Subtitle:</label>
			<textarea class="widefat" style="width: 100%;" id="<?php echo $this->get_field_id('subtitle'); ?>" name="<?php echo $this->get_field_name('subtitle'); ?>"><?php echo $instance['subtitle']; ?></textarea>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('modal_subtitle'); ?>">Modal Subtitle:</label>
			<textarea class="widefat" style="width: 100%;" id="<?php echo $this->get_field_id('modal_subtitle'); ?>" name="<?php echo $this->get_field_name('modal_subtitle'); ?>"><?php echo $instance['modal_subtitle']; ?></textarea>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('phone'); ?>">Phone No:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('phone'); ?>" name="<?php echo $this->get_field_name('phone'); ?>" value="<?php echo $instance['phone']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('email'); ?>">Email:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" value="<?php echo $instance['email']; ?>" />
		</p>
		
		<?php
			$i = 1;
			while( $i < 6 ) :
		?>
			<p>
				<label for="<?php echo $this->get_field_id('social_icon_' . $i); ?>">Social Icon <?php echo $i; ?>:</label>
				<select name="<?php echo $this->get_field_name('social_icon_' . $i); ?>" id="<?php echo $this->get_field_id('social_icon_' . $i); ?>" class="widefat">
					<?php
						foreach ($social_options as $option) {
							echo '<option value="' . $option['value'] . '" id="' . $option['value'] . '"', $instance['social_icon_' . $i] == $option['value'] ? ' selected="selected"' : '', '>', $option['name'], '</option>';
						}
					?>
				</select>
				
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('social_icon_link_' . $i); ?>">Social Icon <?php echo $i; ?> Link:</label>
				<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('social_icon_link_' . $i); ?>" name="<?php echo $this->get_field_name('social_icon_link_' . $i); ?>" value="<?php echo $instance['social_icon_link_' . $i]; ?>" />
			</p>
		<?php 
			$i++;
			endwhile;
		?>

	<?php
	}
}
/*-----------------------------------------------------------------------------------*/
/*	END CONTACT WIDGET
/*-----------------------------------------------------------------------------------*/