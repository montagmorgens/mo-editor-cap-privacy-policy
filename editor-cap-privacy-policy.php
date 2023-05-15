<?php
/**
 * Allow Editor Access to Privacy Policy
 *
 * @category   Plugin
 * @package    Mo\EditorCapPrivacyPolicy
 * @author     Christoph Schüßler <schuessler@montagmorgens.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.txt GNU/GPLv2
 * @since      1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:       MONTAGMORGENS Allow Editor Access to Privacy Policy
 * Description:       Dieses Plugin erlaubt es Redakteuren, die Datenschutzerklärung zu bearbeiten.
 * Version:           1.0.0
 * Requires at least: 5.0.0
 * Requires PHP:      7.4
 * Author:            MONTAGMORGENS GmbH
 * Author URI:        https://www.montagmorgens.com/
 * License:           GNU General Public License v.2
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       mo-editor-cap-privacy-policy
 * Domain Path:       /languages
 * GitHub Plugin URI: montagmorgens/mo-editor-cap-privacy-policy
 */

namespace Mo\EditorCapPrivacyPolicy;

/**
 * Allow editor read /write access to privacy policy.
 *
 * @param string[] $caps Primitive capabilities required of the user.
 * @param string   $cap Capability being checked..
 * @param int      $user_id The user ID.
 * @param array    $args Adds context to the capability check, typically starting with an object ID.
 */
function manage_privacy_options( $caps, $cap, $user_id, $args ) {
	$user_meta = get_userdata( $user_id );
	if ( isset( $user_meta->roles ) && is_array( $user_meta->roles ) && array_intersect( ['editor', 'administrator'], $user_meta->roles ) ) {
		if ( 'manage_privacy_options' === $cap ) {
			$manage_name = is_multisite() ? 'manage_network' : 'manage_options';
			$caps        = array_diff( $caps, [ $manage_name ] );
		}
	}
	return $caps;
}

add_action( 'map_meta_cap', '\Mo\EditorCapPrivacyPolicy\manage_privacy_options', 1, 4 );
