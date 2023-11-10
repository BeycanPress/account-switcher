<?php

namespace BeycanPress\AccountSwitcher;

use \BeycanPress\AccountSwitcher\PluginHero\Setting;

class Settings extends Setting
{
    use PluginHero\Helpers;

    public function __construct()
    {
        parent::__construct(esc_html__('Account Switcher', 'accountSwitcher'));

        self::createSection(array(
            'id'     => 'generalOptions', 
            'title'  => esc_html__('General options', 'accountSwitcher'),
            'icon'   => 'fa fa-cog',
            'fields' => array(
                array(
                    'id'      => 'dds',
                    'title'   => esc_html__('Data deletion status', 'accountSwitcher'),
                    'type'    => 'switcher',
                    'default' => false,
                    'help'    => esc_html__('This setting is passive come by default. You enable this setting. All data created by the plug-in will be deleted while removing the plug-in.', 'accountSwitcher')
                ),
                array(
                    'id' => 'wooCommerceMyAccountPage',
                    'type'    => 'switcher',
                    'title' => esc_html__('WooCommerce My Account Page Buton', 'accountSwitcher'),
                    'default' => true,
                    'help'  => esc_html__('Adds switch accounts button to WooCommerce my account page', 'accountSwitcher')
                ),
                array(
                    'id' => 'loginRedirect',
                    'type'  => 'text',
                    'title' => esc_html__('Login redirect url', 'accountSwitcher'),
                    'help'  => esc_html__('After logging in, which address do you want to be forwarded to? If you type "same-page" it will redirect to the current page.', 'accountSwitcher'),
                    'sanitize' => function($val) {
                        return sanitize_text_field($val);
                    }
                ),
            )
        ));

        self::createSection(array(
            'id'     => 'backup', 
            'title'  => esc_html__('Backup', 'accountSwitcher'),
            'icon'   => 'fa fa-shield',
            'fields' => array(
                array(
                    'type'  => 'backup',
                    'title' => esc_html__('Backup', 'accountSwitcher')
                ),
            ) 
        ));
    }
    
}