<?php declare(strict_types=1);
/**
 * This class set default settings 
 * on plugins activation.
 */

namespace Am\APIPlugin;

defined( 'ABSPATH' ) || exit;

final class Installer
{
    use Singleton;

    public function init() {
        $defaultSettings = json_encode([
            'numrows'   => 5,
            'humandate' => true,
            'emails'    => [ 
                get_option( 'admin_email', 'admin@email.com' )
            ]
        ]);

        update_option( APIPlugin::SETTINGS_OPTION_KEY, $defaultSettings );
    }
}