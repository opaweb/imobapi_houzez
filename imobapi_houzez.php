<?php 
/**
 * Plugin Name: ImobAPI - Houzez
 * Version: 1.0.0
 * Description: Plugin para funcionalidade adicional de sincronização de imóveis através da ImobAPI.
 * Author: ImobAPI
 * Author URI: https://imobapi.com.br
 * Text Domain: imobapi
 * Domain Path: /languages/
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * GitHub Plugin URI: https://github.com/opaweb/imobapi_houzez
*/

/**
 * CHANGELOG
 * 
 * 1.0.0 - Reslease inicial.
 * 
 */

require_once dirname( __FILE__ ) . '/class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', 'imobapi_register_required_plugins' );

function imobapi_register_required_plugins() {
	
	$plugins = array(
        array(
			'name'      => 'Featured Image from URL (FIFU)',
			'slug'      => 'featured-image-from-url',
			'required'  => true,
		),
        array(
			'name'      => 'EXMAGE – WordPress Image Links',
			'slug'      => 'exmage-wp-image-links',
			'required'  => true,
		),
        array(
			'name'      => 'Git Updater',
			'slug'      => 'git-updater',
			'source'    => 'https://github.com/afragen/git-updater/releases/download/11.0.3/git-updater-11.0.3.zip',
            'required'  => true,
		),
    );

    $config = array(
		'id'           => 'imobapi',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'plugins.php',            // Parent menu slug.
		'capability'   => 'manage_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.

		/*
		'strings'      => array(
			'page_title'                      => __( 'Install Required Plugins', 'imobapi' ),
			'menu_title'                      => __( 'Install Plugins', 'imobapi' ),
			/* translators: %s: plugin name. * /
			'installing'                      => __( 'Installing Plugin: %s', 'imobapi' ),
			/* translators: %s: plugin name. * /
			'updating'                        => __( 'Updating Plugin: %s', 'imobapi' ),
			'oops'                            => __( 'Something went wrong with the plugin API.', 'imobapi' ),
			'notice_can_install_required'     => _n_noop(
				/* translators: 1: plugin name(s). * /
				'This theme requires the following plugin: %1$s.',
				'This theme requires the following plugins: %1$s.',
				'imobapi'
			),
			'notice_can_install_recommended'  => _n_noop(
				/* translators: 1: plugin name(s). * /
				'This theme recommends the following plugin: %1$s.',
				'This theme recommends the following plugins: %1$s.',
				'imobapi'
			),
			'notice_ask_to_update'            => _n_noop(
				/* translators: 1: plugin name(s). * /
				'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
				'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
				'imobapi'
			),
			'notice_ask_to_update_maybe'      => _n_noop(
				/* translators: 1: plugin name(s). * /
				'There is an update available for: %1$s.',
				'There are updates available for the following plugins: %1$s.',
				'imobapi'
			),
			'notice_can_activate_required'    => _n_noop(
				/* translators: 1: plugin name(s). * /
				'The following required plugin is currently inactive: %1$s.',
				'The following required plugins are currently inactive: %1$s.',
				'imobapi'
			),
			'notice_can_activate_recommended' => _n_noop(
				/* translators: 1: plugin name(s). * /
				'The following recommended plugin is currently inactive: %1$s.',
				'The following recommended plugins are currently inactive: %1$s.',
				'imobapi'
			),
			'install_link'                    => _n_noop(
				'Begin installing plugin',
				'Begin installing plugins',
				'imobapi'
			),
			'update_link' 					  => _n_noop(
				'Begin updating plugin',
				'Begin updating plugins',
				'imobapi'
			),
			'activate_link'                   => _n_noop(
				'Begin activating plugin',
				'Begin activating plugins',
				'imobapi'
			),
			'return'                          => __( 'Return to Required Plugins Installer', 'imobapi' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'imobapi' ),
			'activated_successfully'          => __( 'The following plugin was activated successfully:', 'imobapi' ),
			/* translators: 1: plugin name. * /
			'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'imobapi' ),
			/* translators: 1: plugin name. * /
			'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'imobapi' ),
			/* translators: 1: dashboard link. * /
			'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'imobapi' ),
			'dismiss'                         => __( 'Dismiss this notice', 'imobapi' ),
			'notice_cannot_install_activate'  => __( 'There are one or more required or recommended plugins to install, update or activate.', 'imobapi' ),
			'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'imobapi' ),

			'nag_type'                        => '', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
		),
		*/
	);

	tgmpa( $plugins, $config );
}

register_activation_hook( __FILE__,  'activate');

/**
  * Plugin Activation hook function to check for Minimum PHP and WordPress versions
  * @param string $wp Minimum version of WordPress required for this plugin
  * @param string $php Minimum version of PHP required for this plugin
  */
 function activate( $wp = '5.8', $php = '7.4.14' ) {
    global $wp_version;
    if ( version_compare( PHP_VERSION, $php, '<' ) )
        $flag = 'PHP';
    elseif
        ( version_compare( $wp_version, $wp, '<' ) )
        $flag = 'WordPress';
    else
        return;
    $version = 'PHP' == $flag ? $php : $wp;
    deactivate_plugins( basename( __FILE__ ) );
    wp_die('<p>O plugin <strong>Jetimob/strong> requer '.$flag.'  versão '.$version.' ou superior.</p>','Plugin Activation Error',  array( 'response'=>200, 'back_link'=>TRUE ) );
}

function add_support_to_property() {
    add_post_type_support( 'property', 'custom-fields' ); 
}
add_action( 'init', 'add_support_to_property' );

add_action( 'rest_api_init', function() {
    $propertyFields = [
		'fave_property_id',
		'fave_agent_display_option',
		'fave_agents',
		'fave_property_price',
		'fave_property_sec_price',
		'fave_property_location',
		'houzez_geolocation_lat',
		'houzez_geolocation_long',
		'fave_property_state',
		'fave_property_city',
		'fave_property_area',
		'fave_property_zip',
		'fave_property_bedrooms',
		'fave_property_bathrooms',
		'fave_property_garage',
		'fave_suc3adtes',
		'fave_property_size',
		'fave_property_size_prefix',
		'fave_property_land',
		'fave_property_land_postfix',
		'fave_property_map',
		'fave_property_map_address',
		'fave_virtual_tour',
		'_images',
		'_floor_plans',
		'fave_additional_features_enable',
		'fave_property_map_street_view', 
		'additional_features',
		'fave_property_images',
		'fave_prop_homeslider',
		'fave_prop_slider_image',
		'fave_floor_plans_enable',
		'floor_plans',
		'fave_video_url',       
    ];
    
    foreach($propertyFields as $propertyField){
        register_rest_field( 'property',
        $propertyField,
        array(
            'get_callback'    => 'slug_get_post_meta_imobapi',
            'update_callback' => 'slug_update_post_meta_imobapi',
            'schema'          => null,
            )
        );
        $args = array(
            //'type'=>'string',
            'single'=>true,
            'show_in_rest'=>true
        );
        register_post_meta('property', $propertyField, $args);
    } 
    
    $agentFields = [
		'fave_agent_position',
		'fave_agent_email',
		'fave_agent_mobile',
		'fave_agent_whatsapp',
		'fave_agent_facebook',
		'fave_agent_instagram',
		'fave_agent_linkedin',
		'fave_agent_twitter',
		'fave_agent_skype',
		'fave_agent_license',
		'_agent_avatar',
		'_agent_id'
	];

    foreach($agentFields as $agentField){
        register_rest_field( 'houzez_agent',
        $agentField,
        array(
            'get_callback'    => 'slug_get_post_meta_imobapi',
            'update_callback' => 'slug_update_post_meta_imobapi',
            'schema'          => null,
            )
        );
        $args = array(
            //'type'=>'string',
            'single'=>true,
            'show_in_rest'=>true
        );
        register_post_meta('houzez_agent', $agentField, $args);
    } 
});


function slug_get_post_meta_imobapi( $post, $field_name, $request ) {
    return get_post_meta( $post['id'], $field_name );
}

function slug_update_post_meta_imobapi( $value, $post, $field_name ) {
    return update_post_meta( $post->ID, $field_name, $value );
}

add_filter( 'register_post_type_args', 'property_post_type_args', 10, 2 );
 
function property_post_type_args( $args, $post_type ) {
 
    if ( 'property' === $post_type ) {
        $args['rest_controller_class'] = 'WP_REST_Posts_Controller';
        $args['capabilities'] = array(
            'create_posts' => true,
        );
    }
 
    return $args;
}

//add_filter( 'register_post_type_args', 'agent_post_type_args', 10, 2 );
 
/*function agent_post_type_args( $args, $post_type ) {
 
    if ( 'houzez_agent' === $post_type ) {
        $args['rest_controller_class'] = 'WP_REST_Posts_Controller';
        $args['capabilities'] = array(
            'create_posts' => true,
        );
    }
 
    return $args;
}*/

add_filter( 'register_taxonomy_args', 'property_type_args', 10, 2 );
 
function property_type_args( $args, $taxonomy_name ) {

    if ( 'property_type' === $taxonomy_name ) {
        $args['show_in_rest'] = true;

        // Optionally customize the rest_base or rest_controller_class
        //$args['rest_base']             = 'genres';
        //$args['rest_controller_class'] = 'WP_REST_Terms_Controller';
    }

    return $args;
}

add_filter( 'register_taxonomy_args', 'property_state_args', 10, 2 );
 
function property_state_args( $args, $taxonomy_name ) {

    if ( 'property_state' === $taxonomy_name ) {
        $args['show_in_rest'] = true;

        // Optionally customize the rest_base or rest_controller_class
        //$args['rest_base']             = 'genres';
        //$args['rest_controller_class'] = 'WP_REST_Terms_Controller';
    }

    return $args;
}

add_filter( 'register_taxonomy_args', 'property_city_args', 10, 2 );
 
function property_city_args( $args, $taxonomy_name ) {

    if ( 'property_city' === $taxonomy_name ) {
        $args['show_in_rest'] = true;

        // Optionally customize the rest_base or rest_controller_class
        //$args['rest_base']             = 'genres';
        //$args['rest_controller_class'] = 'WP_REST_Terms_Controller';
    }

    return $args;
}

add_filter( 'register_taxonomy_args', 'property_area_args', 10, 2 );
 
function property_area_args( $args, $taxonomy_name ) {

    if ( 'property_area' === $taxonomy_name ) {
        $args['show_in_rest'] = true;

        // Optionally customize the rest_base or rest_controller_class
        //$args['rest_base']             = 'genres';
        //$args['rest_controller_class'] = 'WP_REST_Terms_Controller';
    }

    return $args;
}

add_filter( 'register_taxonomy_args', 'property_feature_args', 10, 2 );
 
function property_feature_args( $args, $taxonomy_name ) {

    if ( 'property_feature' === $taxonomy_name ) {
        $args['show_in_rest'] = true;

        // Optionally customize the rest_base or rest_controller_class
        //$args['rest_base']             = 'genres';
        //$args['rest_controller_class'] = 'WP_REST_Terms_Controller';
    }

    return $args;
}

add_filter( 'register_taxonomy_args', 'property_status_args', 10, 2 );
 
function property_status_args( $args, $taxonomy_name ) {

    if ( 'property_status' === $taxonomy_name ) {
        $args['show_in_rest'] = true;

        // Optionally customize the rest_base or rest_controller_class
        //$args['rest_base']             = 'genres';
        //$args['rest_controller_class'] = 'WP_REST_Terms_Controller';
    }

    return $args;
}

/*
add_action( 'rest_api_init', function () {
    register_rest_route( 'property', '/(?P<id>\d+)', array(
      'methods' => 'DELETE',
      'callback' => 'delete_property',
      'args' => array(
        'id' => array(
          'validate_callback' => function($param, $request, $key) {
            return is_numeric( $param );
          }
        ),
      ),
    ) );
  } );
*/
wp_enqueue_script('imobapi_wprealestate_leads', plugin_dir_url(__FILE__) . 'leads.js', array('jquery'), false, true);

function imobapi_settings() {
	register_setting(
		'group_imobapi',
		'imobapi_key',
		array(
			/*'sanitize_callback' => function( $value ) {
				if ( ! preg_match( '/API-[0-9]{4}-[A-Z]{3}/', $value ) ) {
					add_settings_error(
						'imobapi_key',
						esc_attr( 'imobapi_key_error' ),
						'Chave API no formato errado.',
						'error'
					);
					return get_option( 'imobapi_key' );
				}
				return $value;
			},*/
		)
	);
 
	add_settings_section(
		'imobapi_config_section',
		'Configuração',
		function( $args ) {
			echo '<p>Coloque aqui a sua chave API.</p>';
		},
		'group_imobapi'
	);
 
	add_settings_field(
		'imobapi_key',
		'Token API de Integração',
		function( $args ) {
			$options = get_option( 'imobapi_key' );
			?>
			<input
				type="text"
				id="<?php echo esc_attr( $args['label_for'] ); ?>"
				name="imobapi_key"
				value="<?php echo esc_attr( $options ); ?>">
			<?php
		},
		'group_imobapi',
		'imobapi_config_section',
		[
			'label_for' => 'imobapi_key_html_id',
			'class'     => 'classe-html-tr',
		]
	);
}
//add_action( 'admin_init', 'imobapi_settings' );
/* 
function imobapi_menu() {
	add_options_page(
		'Configuração ImobAPI', // Título da página
		'ImobAPI', // Nome no menu do Painel
		'manage_options', // Permissões necessárias
		'imobapi', // Valor do parâmetro "page" no URL
		'imobapi_html' // Função que imprime o conteúdo da página
	);
}
*/
//add_action( 'admin_menu', 'imobapi_menu' );
/* 
function imobapi_html() {
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form action="options.php" method="post">
			<?php
			settings_fields( 'group_imobapi' );
			do_settings_sections( 'group_imobapi' );
			submit_button();
			?>
		</form>
	</div>
	<?php
}


function imobapi_settings_link_lista_plugins( $links ) {
	$settings_link = '<a href="options-general.php?page=imobapi">Configurações</a>';
	array_unshift( $links, $settings_link );
	return $links;
}
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'imobapi_settings_link_lista_plugins' );

add_filter('manage_property_posts_columns', 'imobapi_filter_posts_columns');

function imobapi_filter_posts_columns($columns){
  $columns['media'] = __('Mídia');
  return $columns;
}

add_action( 'manage_property_posts_custom_column', 'imobapi_property_column', 10, 2);
function imobapi_property_column( $column, $post_id ) {
  // Media column
  if ( 'media' === $column ) {
    echo '<button class="reloadMedia">Recarregar mídia</button>';
    echo '<script>

    	jQuery(".reloadMedia").click(function() {
			jQuery.get("/wp-content/plugins/imobapi_wprealestate/run.php?post_id='.$post_id.'", function() {
              location.reload();
            });

    	});
    </script>';
  }
}*/
?>