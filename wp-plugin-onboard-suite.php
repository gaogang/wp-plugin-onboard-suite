<?php
/**
 * Plugin Name:     Wp Plugin Onboard Suite
 * Description:     Example block written with ESNext standard and JSX support – build step required.
 * Version:         0.1.0
 * Author:          The WordPress Contributors
 * License:         GPL-2.0-or-later
 * License URI:     https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:     wp-plugin-onboard-suite
 */

function onboard_suite_settings_init() {
    register_setting( 'onboard', 'onboard_options' );
 
    add_settings_section(
        'onboard_suitecrm_section',
        __( 'SuiteCRM Api Access', 'wp-plugin-onboard-suite' ), 
        'onboard_suitecrm_section_callback',
        'onboard'
    );
 
    /**
     * The base url of the SuiteCRM apis
     * @example https://www.yoursuitecrm.com/api
     */
    add_settings_field(
        'onboard_suitecrm_field_urlbase', 
        __( 'Url Base', 'wp-plugin-onboard-suite' ),
        'onboard_suitecrm_field_urlbase_callback',
        'onboard',
        'onboard_suitecrm_section',
        array(
            'label_for' => 'onboard_suitecrm_field_urlbase'
        )
    );

    /** SuiteCRM client Id */
    add_settings_field(
        'onboard_suitecrm_field_client_id', 
        __( 'Client Id', 'wp-plugin-onboard-suite' ),
        'onboard_suitecrm_field_client_id_callback',
        'onboard',
        'onboard_suitecrm_section',
        array(
            'label_for' => 'onboard_suitecrm_field_client_id'
        )
    );

    /** SuiteCRM client secret */
    add_settings_field(
        'onboard_suitecrm_field_client_secret', 
        __( 'Client Secret', 'wp-plugin-onboard-suite' ),
        'onboard_suitecrm_field_client_secret_callback',
        'onboard',
        'onboard_suitecrm_section',
        array(
            'label_for' => 'onboard_suitecrm_field_client_secret'
        )
    );

    /** Section for external Id module configuration. */
    add_settings_section(
        'onboard_suitecrm_external_id_section',
        __( 'External Id Module Configuration', 'wp-plugin-onboard-suite' ), 
        'onboard_suitecrm_external_id_section_callback',
        'onboard'
    );

    /** Name of the external Id Module in SuiteCRM */
    add_settings_field(
        'onboard_suitecrm_field_external_id_module', 
        __( 'Name of SutieCRM module to store user info in a 3rd party system', 'wp-plugin-onboard-suite' ),
        'onboard_suitecrm_field_external_id_module_callback',
        'onboard',
        'onboard_suitecrm_external_id_section',
        array(
            'label_for' => 'onboard_suitecrm_field_external_id_module'
        )
    );

    /** 
     * Name of the external system
     * @example Wordpress
     */
    add_settings_field(
        'onboard_suitecrm_field_system_name', 
        __( 'Name of the 3rd party system', 'wp-plugin-onboard-suite' ),
        'onboard_suitecrm_field_system_name_callback',
        'onboard',
        'onboard_suitecrm_external_id_section',
        array(
            'label_for' => 'onboard_suitecrm_field_system_name'
        )
    );

    /** Name of the attribute for external system in the external Id module */
    add_settings_field(
        'onboard_suitecrm_field_attribute_system_name', 
        __( 'Attribute in your external Id module to store 3rd party system name', 'wp-plugin-onboard-suite' ),
        'onboard_suitecrm_field_attribute_system_name_callback',
        'onboard',
        'onboard_suitecrm_external_id_section',
        array(
            'label_for' => 'onboard_suitecrm_field_attribute_system_name'
        )
    );

    /**
     * Name of the attribute for username in the external system in the external Id module 
     */
    add_settings_field(
        'onboard_suitecrm_field_attribute_username', 
        __( 'Attribute in you external Id module to store username in the 3rd party system', 'wp-plugin-onboard-suite' ),
        'onboard_suitecrm_field_attribute_username_callback',
        'onboard',
        'onboard_suitecrm_external_id_section',
        array(
            'label_for' => 'onboard_suitecrm_field_attribute_username'
        )
    );

    /**
     * Name of the attribute for user's id in the external system
     */
    add_settings_field(
        'onboard_suitecrm_field_attribute_user_id', 
        __( 'Attribute in your external Id module to store user Id in the 3rd party system', 'wp-plugin-onboard-suite' ),
        'onboard_suitecrm_field_attribute_user_id_callback',
        'onboard',
        'onboard_suitecrm_external_id_section',
        array(
            'label_for' => 'onboard_suitecrm_field_attribute_user_id'
        )
    );

    /** Name of the attribute for the user's SuiteCRM contact Id */
    add_settings_field(
        'onboard_suitecrm_field_attribute_contact_id', 
        __( 'Attribute in your external Id module to store the user\'s SutieCRM contact Id', 'wp-plugin-onboard-suite' ),
        'onboard_suitecrm_field_attribute_contact_id_callback',
        'onboard',
        'onboard_suitecrm_external_id_section',
        array(
            'label_for' => 'onboard_suitecrm_field_attribute_contact_id'
        )
    );
}

function onboard_suitecrm_section_callback( $args ) {
}

function onboard_suitecrm_external_id_section_callback( $args ) {
}

function onboard_suitecrm_field_urlbase_callback( $args ) {
    echo field_callback('onboard_suitecrm_field_urlbase', $args['label_for']);
}

function onboard_suitecrm_field_client_id_callback( $args ) {
    echo field_callback('onboard_suitecrm_field_client_id', $args['label_for']);
}

function onboard_suitecrm_field_client_secret_callback( $args ) {
    echo field_callback('onboard_suitecrm_field_client_secret', $args['label_for']);
}

function onboard_suitecrm_field_external_id_module_callback( $args ) {
    echo field_callback('onboard_suitecrm_field_external_id_module', $args['label_for']);
}

function onboard_suitecrm_field_system_name_callback( $args ) {
    echo field_callback('onboard_suitecrm_field_system_name', $args['label_for']);
}

function onboard_suitecrm_field_attribute_system_name_callback( $args ) {
    echo field_callback('onboard_suitecrm_field_attribute_system_name', $args['label_for']);
}

function onboard_suitecrm_field_attribute_username_callback( $args ) {
    echo field_callback('onboard_suitecrm_field_attribute_username', $args['label_for']);
}

function onboard_suitecrm_field_attribute_user_id_callback( $args ) {
    echo field_callback('onboard_suitecrm_field_attribute_user_id', $args['label_for']);
}

function onboard_suitecrm_field_attribute_contact_id_callback( $args ) {
    echo field_callback('onboard_suitecrm_field_attribute_contact_id', $args['label_for']);
}

function field_callback($id, $optionName) {
    $options = get_option('onboard_options');
    $value = array_key_exists($optionName, $options) ? $options[$optionName] : '';

    return sprintf(
        '<input id="%s" name="onboard_options[%s]" size="40" type="text" value="%s" />',
        $id, 
        $optionName,
        $value
    );
}

add_action('admin_init', 'onboard_suite_settings_init');

function onboard_suite_page_html() {
	if(!current_user_can('manage_options')) {
		return;
    }
    
    // getAndPersistAccessToken(get_option('onboard_options'));

	settings_errors('onboard_suite_messages');
	?>
	<div class='wrap'>
		<form action='options.php' method='post'>
			<?php
                settings_fields( 'onboard' );

                do_settings_sections( 'onboard' );

                submit_button( 'Save Settings' );
			?>
		</form>
	</div>
	<?php
    $token = get_option('suitecrm_token');
    $exp = get_option('suitecrm_token_expiry_timestamp');

    ?>
    <p> Token is <?php echo $token ?></p>
    <p> Token expiry time stamp <?php echo $exp ?></p>
    <p> Now <?php echo time() ?></p>

    <?php
}

function onboard_suite_page () {
	add_menu_page(
		'Onboard Suite',
		'Onboard Suite',
		'manage_options',
		'onboard',
		'onboard_suite_page_html'
	);
}

add_action('admin_menu', 'onboard_suite_page');


function get_access_token($options) {
    $token = get_option('suitecrm_token');
    $exp = get_option('suitecrm_token_expiry_timestamp');

    if (time() < $exp) {
        return $token;
    }

    $urlBase = '';
    $clientId = '';
    $clientSecret = '';

    if(array_key_exists('onboard_suitecrm_field_urlbase', $options)) {
        $urlBase = $options['onboard_suitecrm_field_urlbase'];
    }

    if(array_key_exists('onboard_suitecrm_field_client_id', $options)) {
        $clientId = $options['onboard_suitecrm_field_client_id'];
    }

    if(array_key_exists('onboard_suitecrm_field_client_secret', $options)) {
        $clientSecret = $options['onboard_suitecrm_field_client_secret'];
    }

    if (empty($urlBase) || 
        empty($clientId || 
        empty($clientSecret)))
    {
        return '';
    }

    $body = array(
        'grant_type' => 'client_credentials',
        'client_id' => $clientId,
        'client_secret' => $clientSecret
    );


    $url = sprintf('%s%s', $urlBase, '/access_token');

    $response = wp_remote_post($url, array(
        'body' => wp_json_encode($body),
        'headers' => array(
            'content-type' => 'application/json'
        )
    ));

    if (is_wp_error($response)) {
        throw new Exception($response->get_error_message());
    }

    $token = json_decode($response['body']);

    // Persist access token
    update_option('suitecrm_token', $token->access_token);
    update_option('suitecrm_token_expiry_timestamp', time() + $token->expires_in);

    return $token;
}

function create_contact($options, $url, $user) {
    $access_token = get_access_token($options);

    // Do nothing if the access token is not ready
    if (empty($access_token)) {
        return;
    }

    $body = array(
        'data' => array(
            'type' => 'Contacts',
            'attributes' => array(
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email1' => $user->user_email
            )
        )
    );
    
    $response = wp_remote_post($url, array(
        'timeout' => 15, 
        'headers' => array(
            'content-type' => 'application/json',
            'authorization' => sprintf('Bearer %s', $access_token)
        ),
        'body' => wp_json_encode($body)
    ));

    if (is_wp_error($response)) {
        throw new Exception($response->get_error_message());
    }

    $responseJson = json_decode($response['body']);
    return $responseJson->data;
}

function create_external_id($options, $url, $user, $userContactId) {
    $access_token = get_access_token($options);

    // Do nothing if the access token is not ready
    if (empty($access_token)) {
        return;
    }

    $externalIdModule = '';

    $system_name = '';
    $system_name_attr = '';
    $system_username_attr = '';
    $system_user_id_attr = '';
    $contact_id_attr = '';

    if(array_key_exists('onboard_suitecrm_field_external_id_module', $options)) {
        $externalIdModule = $options['onboard_suitecrm_field_external_id_module'];
    } else {
        // Do nothing if the external Id module is not set
        return;
    }

    if(array_key_exists('onboard_suitecrm_field_system_name', $options)) {
        $system_name = $options['onboard_suitecrm_field_system_name'];
    } else {
        // Do nothing if the external system name is not set
        return;
    }

    if(array_key_exists('onboard_suitecrm_field_attribute_system_name', $options)) {
        $system_name_attr = $options['onboard_suitecrm_field_attribute_system_name'];
    } else {
        // Do nothing if the external system name is not set
        return;
    }

    if(array_key_exists('onboard_suitecrm_field_attribute_username', $options)) {
        $system_username_attr = $options['onboard_suitecrm_field_attribute_username'];
    }

    if(array_key_exists('onboard_suitecrm_field_attribute_user_id', $options)) {
        $system_user_id_attr = $options['onboard_suitecrm_field_attribute_user_id'];
    } else {
        // Do nothing if the external system user id is not set
        return;
    }

    if(array_key_exists('onboard_suitecrm_field_attribute_contact_id', $options)) {
        $contact_id_attr = $options['onboard_suitecrm_field_attribute_contact_id'];
    } else {
        // Do nothing if the external system user id is not set
        return;
    }

    $body = array(
        'data' => array(
            'type' => $externalIdModule,
            'attributes' => array(
                $system_name_attr => $system_name,
                $system_username_attr => $user->user_login,
                $system_user_id_attr => $user->ID,
                $contact_id_attr => $userContactId
            )
        )
    );
    
    $response = wp_remote_post($url, array(
        'timeout' => 15, 
        'headers' => array(
            'content-type' => 'application/json',
            'authorization' => sprintf('Bearer %s', $access_token)
        ),
        'body' => wp_json_encode($body)
    ));

    if (is_wp_error($response)) {
        throw new Exception($response->get_error_message());
    }

    $responseJson = json_decode($response['body']);
    return $responseJson->data;
}

 /**
  * Create a contact for the registered user in SuiteCRM
  *
  * @param $user_id 
  */
function onboard_user($user_id) {
    $options = get_option('onboard_options');

    $urlBase = '';
    // Do nothing if the url base is not set
    if(array_key_exists('onboard_suitecrm_field_urlbase', $options)) {
        $urlBase = $options['onboard_suitecrm_field_urlbase'];
    } else {
        return;
    }

    $user = get_userdata($user_id);
    if (!$user) {
        return;
    }

    $url = sprintf('%s/V8/module', $urlBase);

    // Create contact
    $contact = create_contact($options, $url, $user);
    // Create external Id linked with the contact
    create_external_id($options, $url, $user, $contact->id);
}

add_action('user_register', 'onboard_user');
