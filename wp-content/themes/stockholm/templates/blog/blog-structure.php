<?php
	global $wp_query;

	//var_dump($wp_query);

	global $qode_options;
    global $qode_template_name;

	$id = $wp_query->get_queried_object_id();

	if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
	elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
	else { $paged = 1; }

	$sidebar = $qode_options['category_blog_sidebar'];

	if(isset($qode_options['blog_page_range']) && $qode_options['blog_page_range'] != ""){
		$blog_page_range = $qode_options['blog_page_range'];
	} else{
		$blog_page_range = $wp_query->max_num_pages;
	}

	$filter = "no";
	if(isset($qode_options['blog_masonry_filter'])){
		$filter = $qode_options['blog_masonry_filter'];
	}
	$blog_style = $qode_options['blog_style'];
	$blog_list = "";
	$blog_loading_class = "";

	//check if we are in viajes
	$postClass = get_post_class(); 
   	//echo $postClass[1];

   	$terms = get_terms( array(
	    'taxonomy' => 'viajes_categories',
	    'hide_empty' => false,
	) );

   	$countries = '';
   	$countriesSelected = '';

	for($i = 0; $i < count(get_field('paises_repeater',280)); $i++){ 

		//get countries list
		$countries .= get_field('paises_repeater', 280)[$i]['country_code'].',';
		//get countries selected list
		$countriesSelected .= get_field('paises_repeater', 280)[$i]['country_code'].':color,';
		// echo get_field('paises_repeater', 280)[$i]['country_slug'];
		// echo get_field('paises_repeater', 280)[$i]['taxonomy']->name;
    }


   	for($i = 0; $i < count($terms); $i++)
   	{
   		//echo $terms[$i]->slug;
   		//echo '<a id="'.$terms[$i]->name.'" href="http://localhost/'.$postClass[1].'/'.$terms[$i]->slug.'">'.$terms[$i]->name.'</a>';


   	}

   		// echo '<div id="map" style="width: 100%; height: 500px;"></div>';


   //echo do_shortcode('[mapsvg id="296"]');


   	if(get_the_ID() === 274)
   	{
   		echo get_the_ID();
   		echo do_shortcode('[rvm_map mapid="297"]'); //
	}


	// var_dump($terms[0]->name);

	//echo get_query_var( 'taxonomy' );
	//echo get_query_var( 'term');

	if($qode_template_name != "") {
		if($qode_template_name == "blog-large-image.php"){
			$blog_list = "blog_large_image";
			$blog_list_class = "blog_large_image";
		}elseif($qode_template_name == "blog-masonry.php"){
			$blog_list = "blog_masonry";
			$blog_list_class = "masonry";
		}elseif($qode_template_name == "blog-masonry-full-width.php"){
			$blog_list = "blog_masonry";
			$blog_list_class = "masonry_full_width";
		}elseif($qode_template_name == "blog-pinterest-full-width.php"){
			$blog_list = "blog_pinterest";
			$blog_list_class = "masonry_full_width pinterest_full_width";
		}elseif($qode_template_name == "blog-large-image-whole-post.php"){
			$blog_list = "blog_large_image_whole_post";
			$blog_list_class = "blog_large_image";
		}elseif($qode_template_name == "blog-chequered.php"){
			$blog_list = "blog_chequered";
			$blog_list_class = "blog_chequered";
		}elseif($qode_template_name == "blog-animated.php"){
			$blog_list = "blog_animated";
			$blog_list_class = "blog_animated";
		}elseif($qode_template_name == "blog-centered.php"){
			$blog_list = "blog_centered";
			$blog_list_class = "blog_centered";
		}else{
			$blog_list = "blog_large_image";
			$blog_list_class = "blog_large_image";
		}
	} else{
		if($blog_style=="1"){
			$blog_list = "blog_large_image";
			$blog_list_class = "blog_large_image";
		}elseif($blog_style=="2"){
			$blog_list = "blog_masonry";
			$blog_list_class = "masonry";
		}elseif($blog_style=="5"){
			$blog_list = "blog_masonry";
			$blog_list_class = "masonry_full_width";
		}elseif($blog_style=="3"){
			$blog_list = "blog_large_image_whole_post";
			$blog_list_class = "blog_large_image";
		}elseif($blog_style=="4"){
			$blog_list = "blog_chequered";
			$blog_list_class = "blog_chequered";
		}elseif($blog_style=="6"){
			$blog_list = "blog_animated";
			$blog_list_class = "blog_animated";
		}elseif($blog_style=="7"){
			$blog_list = "blog_centered";
			$blog_list_class = "blog_centered";
		}elseif($blog_style=="8"){
			$blog_list = "blog_pinterest";
			$blog_list_class = "masonry_full_width pinterest_full_width";
		}else {
			$blog_list = "blog_large_image";
			$blog_list_class = "blog_large_image";
		}

	}


    $pagination_masonry = "pagination";
    if(isset($qode_options['pagination_masonry'])){
       $pagination_masonry = $qode_options['pagination_masonry'];
		if(($blog_list == "blog_masonry") || ($blog_list == "blog_pinterest")) {
			$blog_list_class .= " masonry_" . $pagination_masonry;
		}
    }

	 if(($blog_list == "blog_masonry" || $blog_list == "blog_pinterest") && $pagination_masonry != "infinite_scroll"){
		 if (isset($qode_options['blog_loading_type']) && $qode_options['blog_loading_type'] != "") {
			 $blog_loading_class = $qode_options['blog_loading_type'];
		 }
	 }
?>
<?php

	if(($blog_list == "blog_masonry" && $filter == "yes") || ($blog_list == "blog_pinterest" && $filter == "yes")) {
		get_template_part('templates/blog/masonry', 'filter');

	}

?>
<!-- INICIO BLOG MASONRY -->
<div class="blog_holder <?php echo esc_attr($blog_list_class); ?> <?php echo esc_attr($blog_loading_class); ?>">
	<?php if(have_posts()) : while ( have_posts() ) : the_post(); ?>

	<!--<?php echo post_class(); ?>-->
	<?php  
	
	// $taxonomy_names = get_post_taxonomies();
 //   	if($taxonomy_names[1] == "viajes_categories")
 //   		echo true;
 //   	else
 //   		echo false;

/* Output:
 array() {
 0 => string 'post-[ID]' (length=7)
 1 => string '[post_type]' (length=4)
 2 => string 'type-[post_type]' (length=9)
 3 => string 'status-[post_status]' (length=14)
 4 => string 'format-[post_format]' (length=15)
 5 => string 'hentry' (length=6)
 6 => string 'category-[...]'
 X => string 'tag-[...]'
 */
   	$postClass = get_post_class(); 

   	//echo $postClass[1];

   	if($postClass[1] == "viajes")
   		get_template_part('templates/blog/'.$blog_list.'map', 'loop');
   	else
   		get_template_part('templates/blog/'.$blog_list, 'loop');

   	?>
		<?php
			//get_template_part('templates/blog/'.$blog_list, 'loop');
		?>
	<?php endwhile; ?>
	<?php if(($blog_list != "blog_masonry") && ($blog_list != "blog_pinterest")) { ?>
		<?php if($qode_options['pagination'] != "0") : ?>
			<?php pagination($wp_query->max_num_pages, $blog_page_range, $paged); ?>
		<?php endif; ?>
	<?php } ?>
	<?php else: //If no posts are present ?>
	<div class="entry">
			<p><?php _e('No posts were found.', 'qode'); ?></p>
	</div>
	<?php endif; ?>
</div>
<?php if(($blog_list == "blog_masonry")  || ($blog_list == "blog_pinterest")) {
    if($pagination_masonry == "load_more") {
		if (get_next_posts_link()) { ?>
			<div class="blog_load_more_button_holder">
				<div class="blog_load_more_button"><span rel="<?php echo esc_attr($wp_query->max_num_pages); ?>"><?php echo get_next_posts_link(__('Show more', 'qode')); ?></span></div>
			</div>
		<?php } ?>
	 <?php } elseif($pagination_masonry == "infinite_scroll") { ?>
		<div class="blog_infinite_scroll_button"><span rel="<?php echo esc_attr($wp_query->max_num_pages); ?>"><?php echo get_next_posts_link(__('Show more', 'qode')); ?></span></div>
	<?php }else { ?>
		<?php if($qode_options['pagination'] != "0") : ?>
			<?php pagination($wp_query->max_num_pages, $blog_page_range, $paged); ?>
		<?php endif; ?>
	<?php } ?>
<?php } ?>
