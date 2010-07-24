<?php  
/*
Plugin Name: noComment
Plugin URI: http://adigit.gr/archives/205
Description: The noComment Plugin. A plugin that shows you the post that noone wants to comment. :P
Version: 1.0a
Author: pasxal
Author URI: http://adigit.gr/
License: GPL2
*/


class noComment extends WP_Widget {  
    function noComment() {  
        parent::WP_Widget(false, $name = 'noComment');  
    }  
  
    //Widget
    function widget($args, $instance) {  
        extract( $args );  
	echo $before_widget;
	echo $before_title . $instance['title'] . $after_title; 
			
	
		      //Functionality
		        global $wpdb;
			$query="SELECT * FROM ".$wpdb->prefix."posts WHERE post_status='publish' AND comment_status='open' AND comment_count='0' ORDER BY post_date DESC LIMIT ".$instance['num'];
			$results = $wpdb->get_results($query);
			
				if(!empty($results))
				{
					echo "<ul>";
					foreach ($results as $res)
					{
						echo "<li><a href=\"$res->guid\">".$res->post_title."</a></li>";
					}
					echo "</ul>";
				}else{echo "No posts without comments found.";}

                  
               echo $after_widget;   
  
    }  
    
    //Options
    function form($instance) {  
        $title = esc_attr($instance['title']);  
        $num = esc_attr($instance['num']);  
	?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>  
            <p><label for="<?php echo $this->get_field_id('num'); ?>"><?php _e('Number of posts:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('num'); ?>" name="<?php echo $this->get_field_name('num'); ?>" type="text" value="<?php echo $num; ?>" /></label></p>  
            
        <?php  
    }  
    //Update
    function update($new_instance, $old_instance) {  
        return $new_instance;  
    }  
}  
//Reg it
add_action('widgets_init', create_function('', 'return register_widget("noComment");'));  
?>  