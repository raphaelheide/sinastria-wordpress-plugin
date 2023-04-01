<?php

/*
Plugin Name: Meu Astro Sinastria
Plugin URI: 
Description: Sinastria do Amor - Zodíaco
Version: 1.1.2
Author: Raphael Heide
License: GPL2
Copyright 2020 Raphael Heide (email : contato@agenciadesigno.com)
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

*/



function sinastria_funcao($showlink, $language) {
	$request = wp_remote_get('https://meuastro.com.br/sinastria-app/index3.php');
	$response = wp_remote_retrieve_body( $request );
	echo $response;

}

add_shortcode('sinastria', 'sinastria_funcao');



class sinastriaWidget extends WP_Widget
{
	function __construct()
	{
		parent::__construct('sinastriaWidget', __('Sinastria', 'sinastria' ), array ('description' => __( 'Este plugin mostra em seu site a Sisnatria do amor.', 'sinastria')));
	}
	function form($instance)
	{
		$instance = wp_parse_args( (array) $instance, array( 'title' => 'Sinastria', 'showlink' => '1', 'language' => 'pt' ) );
		$title = $instance['title'];
		$showlink = $instance['showlink'];
		$language = $instance['language'];
?>
<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="vdd_widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo
$this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>



<?php
	}
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		if($new_instance['showlink'] == '1')
		{
			$instance['showlink'] = '1';
		}
		else
		{
			$instance['showlink'] = '0';
		}
		$instance['language'] = $new_instance['language'];
		return $instance;
	}
	function widget($args, $instance)
	{
		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		if (!empty($title))
			echo $before_title . $title . $after_title;;
		$showlink = $instance['showlink'];
		$language = $instance['language'];
		echo sinastria_funcao($showlink, $language);
		echo $after_widget;
	}
}

// STOPS on 8.0
// add_action( 'widgets_init', create_function('', 'return register_widget("sinastriaWidget");') );

add_action( 'widgets_init', function() { return register_widget("sinastriaWidget"); } );

?>