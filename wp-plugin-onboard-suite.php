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
        __( 'Onboarding SuiteCRM', 'wp-plugin-onboard-suite' ), 
        'onboard_suitecrm_section_callback',
        'onboard'
    );
 
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
}

function onboard_suitecrm_section_callback( $args ) {
    ?>
    <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Follow the white rabbit.', 'wp-plugin-onboard-suite' ); ?></p>
    <?php
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

    if (empty($urlBase) || empty($clientId || empty($clientSecret)))
    {
        return 'empty something';
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
        return $response->get_error_message();
    }

    $token = json_decode($response['body']);

    // Persist access token
    update_option('suitecrm_token', $token->access_token);
    update_option('suitecrm_token_expiry_timestamp', time() + $token->expires_in);

    return $token;
}

 /**
  * Create a contact for the registered user in SuiteCRM
  *
  * @param $user_id 
  */
function onboard_user($user_id) {
    $user = get_userdata($user_id);

    if ($user) {
        $options = get_option('onboard_options');
        $access_token = get_access_token($options);

        $urlBase = '';

        if(array_key_exists('onboard_suitecrm_field_urlbase', $options)) {
            $urlBase = $options['onboard_suitecrm_field_urlbase'];
        } else {
            return;
        }

        $url =sprintf('%s/V8/module', $urlBase);
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
        // Create a new contact
        $response = wp_remote_post($url, array(
            'headers' => array(
                'content-type' => 'application/json',
                'authorization' => sprintf('Bearer %s', $access_token)
            ),
            'body' => wp_json_encode($body)
        ));

        if (is_wp_error($response)) {
            throw new Exception($response->get_error_message());
        }
    }
}

add_action('user_register', 'onboard_user');
