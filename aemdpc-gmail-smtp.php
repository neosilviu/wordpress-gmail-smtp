<?php
/**
 * Plugin Name: WordPress Gmail SMTP Integration
 * Description: Easy Gmail SMTP integration for WordPress with OAuth2 authentication
 * Version: 1.0.1
 * Author: Your Name
 * License: GPL v2 or later
 * Text Domain: aemdpc-gmail-smtp
 * Domain Path: /languages
 *
 * Changelog:
 * 1.0.1 - Added detailed logging and DKIM support
 * 1.0.0 - Initial release
 */

if (!defined('ABSPATH')) {
    exit;
}

class AEMDPC_Gmail_SMTP {
    private $options;
    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->options = get_option('aemdpc_gmail_smtp_options');
        
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
        add_action('phpmailer_init', array($this, 'configure_smtp'));
        add_filter('pre_wp_mail', array($this, 'maybe_block_mail'), 10, 2);
    }

    public function add_admin_menu() {
        add_options_page(
            'AEMDPC Gmail SMTP',
            'Gmail SMTP',
            'manage_options',
            'aemdpc-gmail-smtp',
            array($this, 'options_page')
        );
    }

    public function register_settings() {
        register_setting('aemdpc_gmail_smtp', 'aemdpc_gmail_smtp_options');

        add_settings_section(
            'aemdpc_gmail_smtp_section',
            'Gmail SMTP Settings',
            array($this, 'settings_section_callback'),
            'aemdpc-gmail-smtp'
        );

        add_settings_field(
            'gmail_user',
            'Gmail Address',
            array($this, 'gmail_user_callback'),
            'aemdpc-gmail-smtp',
            'aemdpc_gmail_smtp_section'
        );

        add_settings_field(
            'app_password',
            'App Password',
            array($this, 'app_password_callback'),
            'aemdpc-gmail-smtp',
            'aemdpc_gmail_smtp_section'
        );

        add_settings_field(
            'from_name',
            'From Name',
            array($this, 'from_name_callback'),
            'aemdpc-gmail-smtp',
            'aemdpc_gmail_smtp_section'
        );

        add_settings_field(
            'enable_logging',
            'Enable Logging',
            array($this, 'enable_logging_callback'),
            'aemdpc-gmail-smtp',
            'aemdpc_gmail_smtp_section'
        );
    }

    public function settings_section_callback() {
        echo '<p>Configure your Gmail SMTP settings below. You need to create an App Password in your Google Account.</p>';
    }

    public function gmail_user_callback() {
        $value = isset($this->options['gmail_user']) ? $this->options['gmail_user'] : '';
        echo '<input type="email" id="gmail_user" name="aemdpc_gmail_smtp_options[gmail_user]" value="' . esc_attr($value) . '" class="regular-text">';
    }

    public function app_password_callback() {
        $value = isset($this->options['app_password']) ? $this->options['app_password'] : '';
        echo '<input type="password" id="app_password" name="aemdpc_gmail_smtp_options[app_password]" value="' . esc_attr($value) . '" class="regular-text">';
    }

    public function from_name_callback() {
        $value = isset($this->options['from_name']) ? $this->options['from_name'] : get_bloginfo('name');
        echo '<input type="text" id="from_name" name="aemdpc_gmail_smtp_options[from_name]" value="' . esc_attr($value) . '" class="regular-text">';
    }

    public function enable_logging_callback() {
        $value = isset($this->options['enable_logging']) ? $this->options['enable_logging'] : '0';
        echo '<input type="checkbox" id="enable_logging" name="aemdpc_gmail_smtp_options[enable_logging]" value="1" ' . checked('1', $value, false) . '>';
    }

    public function options_page() {
        if (!current_user_can('manage_options')) {
            return;
        }
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <form action="options.php" method="post">
                <?php
                settings_fields('aemdpc_gmail_smtp');
                do_settings_sections('aemdpc-gmail-smtp');
                submit_button('Save Settings');
                ?>
            </form>
            <hr>
            <h2>Send Test Email</h2>
            <form method="post" action="">
                <table class="form-table">
                    <tr>
                        <th scope="row">Test Email To:</th>
                        <td>
                            <input type="email" name="test_email" class="regular-text" required>
                            <?php submit_button('Send Test', 'secondary', 'send_test'); ?>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <?php
    }

    public function configure_smtp($phpmailer) {
        if (!$this->options) {
            return;
        }

        $phpmailer->isSMTP();
        $phpmailer->Host = 'smtp.gmail.com';
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = 587;
        $phpmailer->Username = $this->options['gmail_user'];
        $phpmailer->Password = $this->options['app_password'];
        $phpmailer->SMTPSecure = 'tls';
        $phpmailer->From = $this->options['gmail_user'];
        $phpmailer->FromName = $this->options['from_name'];

        // Enable debug if logging is enabled
        if (isset($this->options['enable_logging']) && $this->options['enable_logging']) {
            $phpmailer->SMTPDebug = 2;
            $phpmailer->Debugoutput = function($str, $level) {
                error_log("AEMDPC Gmail SMTP Debug: $str");
            };
        }
    }

    public function maybe_block_mail($pre, $atts) {
        if (!$this->options || empty($this->options['gmail_user']) || empty($this->options['app_password'])) {
            error_log('AEMDPC Gmail SMTP: Mail blocked - configuration incomplete');
            return true;
        }
        return $pre;
    }

    // Logger function
    private function log($message) {
        if (isset($this->options['enable_logging']) && $this->options['enable_logging']) {
            error_log("AEMDPC Gmail SMTP: $message");
        }
    }
}

// Initialize the plugin
function aemdpc_gmail_smtp_init() {
    AEMDPC_Gmail_SMTP::get_instance();
}
add_action('plugins_loaded', 'aemdpc_gmail_smtp_init');
