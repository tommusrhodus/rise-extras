<?php 

/*-----------------------------------------------------------------------------------*/
/*	CUSTOM POST TYPES
/*-----------------------------------------------------------------------------------*/
// Set-up Action and Filter Hooks
register_uninstall_hook(__FILE__, 'ebor_cpt_delete_plugin_options');
add_action('admin_init', 'ebor_cpt_init' );
add_action('admin_menu', 'ebor_cpt_add_options_page');
//RUN ON THEME ACTIVATION
register_activation_hook( __FILE__, 'ebor_cpt_activation' );

// Delete options table entries ONLY when plugin deactivated AND deleted
function ebor_cpt_delete_plugin_options() {
	delete_option('ebor_cpt_display_options');
}

// Flush rewrite rules on activation
function ebor_cpt_activation() {
	flush_rewrite_rules(true);
}

// Init plugin options to white list our options
function ebor_cpt_init(){
	register_setting( 'ebor_cpt_plugin_display_options', 'ebor_cpt_display_options', 'ebor_cpt_validate_display_options' );
}

// Add menu page
function ebor_cpt_add_options_page() {
	add_utility_page('ebor CPT Options Page', 'ebor CPT', 'manage_options', __FILE__, 'ebor_cpt_render_form');
}

add_action( 'init', 'register_portfolio' );
add_action( 'init', 'create_portfolio_taxonomies' );
add_action( 'init', 'register_team' );

// Render the Plugin options form
function ebor_cpt_render_form() { ?>
	
	<div class="wrap">
	
		<!-- Display Plugin Icon, Header, and Description -->
		<?php screen_icon('ebor-cpt'); ?>
		<h2><?php _e('ebor CPT Settings','ebor'); ?></h2>
		<?php echo '<p>' . __('Welcome to <b>ebor Custom Post Types</b>, our custom post type plugin letting you take your content everywhere.','ebor') . '</p>'; ?>
		<b>When you make any changes in this plugin, be sure to visit <a href="options-permalink.php">Your Permalink Settings</a> & click the 'save changes' button to refresh & re-write your permalinks, otherwise your changes will not take effect properly.</b>
		
		<div class="wrap">
		
				<!-- Beginning of the Plugin Options Form -->
				<form method="post" action="options.php">
					<?php settings_fields('ebor_cpt_plugin_display_options'); ?>
					<?php $displays = get_option('ebor_cpt_display_options'); ?>
					
					<table class="form-table">
					<!-- Checkbox Buttons -->
						<tr valign="top">
							<th scope="row">Register Post Types</th>
							<td>
	
								<label><b>Enter the URL slug you want to use for this post type. DO-NOT: use numbers, spaces, capital letters or special characters.</b><br />
								<input type="text" size="30" name="ebor_cpt_display_options[portfolio_slug]" value="<?php echo $displays['portfolio_slug']; ?>" placeholder="portfolio" />
								 <br />e.g Entering 'portfolio' will result in www.website.com/portfolio becoming the URL to your portfolio.<br />
								 <b>If you change this setting, be sure to visit <a href="options-permalink.php">Your Permalink Settings</a> & click the 'save changes' button to refresh & re-write your permalinks.</b></label>
								 
								 <hr />
	
								<label><b>Enter the URL slug you want to use for this post type. DO-NOT: use numbers, spaces, capital letters or special characters.</b><br />
								<input type="text" size="30" name="ebor_cpt_display_options[team_slug]" value="<?php echo $displays['team_slug']; ?>" placeholder="team" />
								 <br />e.g Entering 'team' will result in www.website.com/team becoming the URL to your team.<br />
								 <b>If you change this setting, be sure to visit <a href="options-permalink.php">Your Permalink Settings</a> & click the 'save changes' button to refresh & re-write your permalinks.</b></label>
								 
								 <hr />
								 
							</td>
						</tr>
					</table>
					
					<?php submit_button('Save Options'); ?>
					
				</form>
		
		</div>

	</div>
<?php }

//VALIDATE POST TYPE INPUTS
function ebor_cpt_validate_display_options($input) {
	if( get_option('ebor_cpt_display_options') ){
		$displays = get_option('ebor_cpt_display_options');
	foreach ($displays as $key => $value) {
		if(isset($input[$key])){
			$input[$key] = wp_filter_nohtml_kses($input[$key]);
		}
	}
	}
	return $input;
}

function register_portfolio() {

$displays = get_option('ebor_cpt_display_options');

if( $displays['portfolio_slug'] ){ $slug = $displays['portfolio_slug']; } else { $slug = 'portfolio'; }

//HERE'S AN ARRAY OF LABELS FOR PORTFOLIOS
    $labels = array( 
        'name' => __( 'Portfolio', 'ebor' ),
        'singular_name' => __( 'Portfolio', 'ebor' ),
        'add_new' => __( 'Add New', 'ebor' ),
        'add_new_item' => __( 'Add New Portfolio', 'ebor' ),
        'edit_item' => __( 'Edit Portfolio', 'ebor' ),
        'new_item' => __( 'New Portfolio', 'ebor' ),
        'view_item' => __( 'View Portfolio', 'ebor' ),
        'search_items' => __( 'Search Portfolios', 'ebor' ),
        'not_found' => __( 'No portfolios found', 'ebor' ),
        'not_found_in_trash' => __( 'No portfolios found in Trash', 'ebor' ),
        'parent_item_colon' => __( 'Parent Portfolio:', 'ebor' ),
        'menu_name' => __( 'Portfolio', 'ebor' ),
    );

//AND HERE'S AN ARRAY OF ARGUMENTS TO DEFINE PORTFOLIOS FUNCTIONALITY
    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => __('Portfolio entries for the ebor Theme.', 'ebor'),
        'supports' => array( 'title', 'editor', 'thumbnail', 'post-formats', 'comments' ),
        'taxonomies' => array( 'portfolio-category' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => array( 'slug' => $slug ),
        'capability_type' => 'post'
    );

    register_post_type( 'portfolio', $args );
}

//ADD PORTFOLIO TAXONOMY
function create_portfolio_taxonomies(){
	$labels = array(
	    'name' => _x( 'Portfolio Categories','ebor' ),
	    'singular_name' => _x( 'Portfolio Category','ebor' ),
	    'search_items' =>  __( 'Search Portfolio Categories','ebor' ),
	    'all_items' => __( 'All Portfolio Categories','ebor' ),
	    'parent_item' => __( 'Parent Portfolio Category','ebor' ),
	    'parent_item_colon' => __( 'Parent Portfolio Category:','ebor' ),
	    'edit_item' => __( 'Edit Portfolio Category','ebor' ), 
	    'update_item' => __( 'Update Portfolio Category','ebor' ),
	    'add_new_item' => __( 'Add New Portfolio Category','ebor' ),
	    'new_item_name' => __( 'New Portfolio Category Name','ebor' ),
	    'menu_name' => __( 'Portfolio Categories','ebor' ),
	  ); 	
	
	// Now register the taxonomy
	
	  register_taxonomy('portfolio-category', array('portfolio'), array(
	    'hierarchical' => true,
	    'labels' => $labels,
	    'show_ui' => true,
	    'show_admin_column' => true,
	    'query_var' => true,
	    'rewrite' => true,
	  ));
}



function register_team() {

$displays = get_option('ebor_cpt_display_options');

if( $displays['team_slug'] ){ $slug = $displays['team_slug']; } else { $slug = 'team'; }

//HERE'S AN ARRAY OF LABELS FOR TEAM MEMBERS
    $labels = array( 
        'name' => __( 'Team Members', 'ebor' ),
        'singular_name' => __( 'Team Member', 'ebor' ),
        'add_new' => __( 'Add New', 'ebor' ),
        'add_new_item' => __( 'Add New Team Member', 'ebor' ),
        'edit_item' => __( 'Edit Team Member', 'ebor' ),
        'new_item' => __( 'New Team Member', 'ebor' ),
        'view_item' => __( 'View Team Member', 'ebor' ),
        'search_items' => __( 'Search Team Members', 'ebor' ),
        'not_found' => __( 'No Team Members found', 'ebor' ),
        'not_found_in_trash' => __( 'No Team Members found in Trash', 'ebor' ),
        'parent_item_colon' => __( 'Parent Team Member:', 'ebor' ),
        'menu_name' => __( 'Team Members', 'ebor' ),
    );

//AND HERE'S AN ARRAY OF ARGUMENTS TO DEFINE TEAM MEMBERS FUNCTIONALITY
    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => __('Team Member entries for the ebor Theme.', 'ebor'),
        'supports' => array( 'title', 'thumbnail', 'editor' ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        
        'show_in_nav_menus' => false,
        'publicly_queryable' => false,
        'exclude_from_search' => true,
        'has_archive' => false,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => false,
        'capability_type' => 'post'
    );

    register_post_type( 'team', $args );
}
/*-----------------------------------------------------------------------------------*/
/*	END CUSTOM POST TYPES
/*-----------------------------------------------------------------------------------*/