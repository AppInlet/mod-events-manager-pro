<?php

namespace EM\Payments\Payfast;


define('BOOKING_TIMEOUT', '_booking_timeout');
define('MERCHANT_ID', '_merchant_id');
define('MERCHANT_KEY', '_merchant_key');
define('STATUS', '_status');
define('PASSPHRASE', '_passphrase');
define('RETURN_API', '_return');
define('CANCEL_RETURN', '_cancel_return');
define('BOOKING_FEEDBACK_THANKS', '_booking_feedback_thanks');
define('MANUAL_APPROVAL', '_manual_approval');
define('BOOKING_FEEDBACK', '_booking_feedback');
define('SELECTED_SELECTED', 'selected="selected"');

/**
 * This Gateway is slightly special, because as well as providing public static functions that need to be activated,
 * there are offline payment public static functions that are always there e.g. adding manual payments.
 */
class Gateway_Admin extends \EM\Payments\Gateway_Admin
{
    public static function init()
    {
        parent::init();
    }

    public static function settings_tabs($custom_tabs = array())
    {
        $tabs = array(
            'options' => array(
                'name'     => sprintf(esc_html__emp('%s Options'), 'Payfast'),
                'callback' => array(static::class, 'mysettings'),
            ),
        );

        return parent::settings_tabs($tabs);
    }

    public static function mysettings()
    {
        global $EM_options;
        ?>
        <table class="form-table">
            <tbody>
            <tr style="vertical-align: top;">
                <th scope="row"><?php
                    _e('Redirect Message', 'em-pro') ?></th>
                <td>
                    <input type="text" name="payfast_booking_feedback" value="<?php
                    esc_attr_e(get_option('em_' . static::$gateway . BOOKING_FEEDBACK_THANKS)); ?>"
                           style='width: 40em;'/><br/>
                    <em>
                        <?php
                        _e('The message that is shown before a user is redirected to Payfast.', 'em-pro'); ?>
                    </em>
                </td>
            </tr>
            </tbody>
        </table>

        <table class="form-table">
            <caption><?php
                echo sprintf(__('%s Options', 'em-pro'), 'Payfast'); ?></caption>
            <tbody>
            <tr style="vertical-align: top;">
                <th scope="row"><?php
                    _e('Merchant ID', 'em-pro') ?></th>
                <td>
                    <input type="text" name="merchant_id" value="<?php
                    esc_attr_e(get_option('em_' . static::$gateway . MERCHANT_ID)); ?>"/>
                    <br/>
                </td>
            </tr>
            <tbody>
            <tr style="vertical-align: top;">
                <th scope="row"><?php
                    _e('Merchant Key', 'em-pro') ?></th>
                <td>
                    <input type="text" name="merchant_key" value="<?php
                    esc_attr_e(get_option('em_' . static::$gateway . MERCHANT_KEY)); ?>"/>
                    <br/>
                </td>
            </tr>
            <tr style="vertical-align: top;">
                <th scope="row"><?php
                    _e('Passphrase', 'em-pro') ?></th>
                <td><input type="text" name="passphrase" value="<?php
                    esc_attr_e(get_option('em_' . static::$gateway . PASSPHRASE)); ?>"/>
                    <br/>
                </td>
            </tr>
            <tr style="vertical-align: top;">
                <th scope="row"><?php
                    _e('Mode', 'em-pro') ?></th>
                <td>
                    <select name="payfast_status">
                        <option value="live" <?php
                        if (get_option('em_' . static::$gateway . STATUS) == 'live') {
                            echo SELECTED_SELECTED;
                        } ?>><?php
                            _e('Live', 'em-pro') ?></option>
                        <option value="test" <?php
                        if (get_option('em_' . static::$gateway . STATUS) == 'test') {
                            echo SELECTED_SELECTED;
                        } ?>><?php
                            _e('Test Mode (Sandbox)', 'em-pro') ?></option>
                    </select>
                    <br/>
                </td>
            </tr>
            <tr style="vertical-align: top;">
                <th scope="row"><?php
                    _e('Debug', 'em-pro') ?></th>
                <td>
                    <select name="payfast_debug">
                        <option value="true" <?php
                        if (get_option('em_' . static::$gateway . "_debug") == 'true') {
                            echo SELECTED_SELECTED;
                        } ?>><?php
                            _e('On', 'em-pro') ?></option>
                        <option value="false" <?php
                        if (get_option('em_' . static::$gateway . "_debug") == 'false') {
                            echo SELECTED_SELECTED;
                        } ?>><?php
                            _e('Off', 'em-pro') ?></option>
                    </select>
                    <br/>
                </td>
            </tr>
            <tr style="vertical-align: top;">
                <th scope="row"><?php
                    _e('Return URL', 'em-pro') ?></th>
                <td>
                    <input type="text" name="payfast_return" value="<?php
                    esc_attr_e(get_option('em_' . static::$gateway . RETURN_API)); ?>" style='width: 40em;'/><br/>
                    <em><?php
                        _e('The URL of the page the user is returned to after payment.', 'em-pro'); ?></em>
                </td>
            </tr>
            <tr style="vertical-align: top;">
                <th scope="row"><?php
                    _e('Cancel URL', 'em-pro') ?></th>
                <td>
                    <input type="text" name="payfast_cancel_return" value="<?php
                    esc_attr_e(get_option('em_' . static::$gateway . CANCEL_RETURN)); ?>" style='width: 40em;'/><br/>
                    <em><?php
                        _e('If a user cancels, they will be redirected to this page.', 'em-pro'); ?></em>
                </td>
            </tr>
            </tbody>
        </table>
        <?php
    }

    /*
     * Run when saving Payfast settings, saves the settings available in EM_Gateway_Paypal::mysettings()
     */
    public static function update($options = array())
    {
        $gateway_options = array(
            static::$gateway . MERCHANT_ID                => $_REQUEST['merchant_id'],
            static::$gateway . MERCHANT_KEY               => $_REQUEST['merchant_key'],
            static::$gateway . PASSPHRASE                 => $_REQUEST['passphrase'],
            static::$gateway . "_currency"                => $_REQUEST['currency'],
            static::$gateway . STATUS                     => $_REQUEST[static::$gateway . '_status'],
            static::$gateway . "_debug"                   => $_REQUEST[static::$gateway . '_debug'],
            static::$gateway . "_manual_approval"         => $_REQUEST[static::$gateway . MANUAL_APPROVAL],
            static::$gateway . BOOKING_FEEDBACK           => wp_kses_data(
                $_REQUEST[static::$gateway . '_booking_feedback']
            ),
            static::$gateway . "_booking_feedback_free"   => wp_kses_data(
                $_REQUEST[static::$gateway . '_booking_feedback_free']
            ),
            static::$gateway . "_booking_feedback_thanks" => wp_kses_data(
                $_REQUEST[static::$gateway . BOOKING_FEEDBACK_THANKS]
            ),
            static::$gateway . "_booking_timeout"         => $_REQUEST[static::$gateway . BOOKING_TIMEOUT],
            static::$gateway . RETURN_API                 => $_REQUEST[static::$gateway . '_return'],
            static::$gateway . CANCEL_RETURN              => $_REQUEST[static::$gateway . '_cancel_return'],
        );
        foreach ($gateway_options as $key => $option) {
            update_option('em_' . $key, stripslashes($option));
        }

        // Default action is to return true
        return parent::update($gateway_options);
    }
}

?>
