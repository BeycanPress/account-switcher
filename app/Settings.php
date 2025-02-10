<?php

declare(strict_types=1);

// @phpcs:disable Generic.Files.LineLength

namespace BeycanPress\AccountSwitcher;

use BeycanPress\AccountSwitcher\PluginHero\Setting;

class Settings extends Setting
{
    /**
     * Settings constructor.
     */
    public function __construct()
    {
        parent::__construct(esc_html__('Account Switcher', 'account-switcher'));

        self::createSection([
            'id'     => 'generalOptions',
            'title'  => esc_html__('General options', 'account-switcher'),
            'icon'   => 'fa fa-cog',
            'fields' => [
                [
                    'id'      => 'dds',
                    'title'   => esc_html__('Data deletion status', 'account-switcher'),
                    'type'    => 'switcher',
                    'default' => false,
                    'help'    => esc_html__('This setting is passive come by default. You enable this setting. All data created by the plug-in will be deleted while removing the plug-in.', 'account-switcher')
                ],
                [
                    'id' => 'wooCommerceMyAccountPage',
                    'type'    => 'switcher',
                    'title' => esc_html__('WooCommerce My Account Page Button', 'account-switcher'),
                    'default' => true,
                    'help'  => esc_html__('Adds switch accounts button to WooCommerce my account page', 'account-switcher')
                ],
                [
                    'id' => 'loginRedirect',
                    'type'  => 'text',
                    'title' => esc_html__('Login redirect url', 'account-switcher'),
                    'help'  => esc_html__('After logging in, which address do you want to be forwarded to? If you type "same-page" it will redirect to the current page.', 'account-switcher'),
                    'sanitize' => function ($val) {
                        return sanitize_text_field($val);
                    }
                ],
            ]
        ]);

        self::createSection([
            'id'     => 'backup',
            'title'  => esc_html__('Backup', 'account-switcher'),
            'icon'   => 'fa fa-shield',
            'fields' => [
                [
                    'type'  => 'backup',
                    'title' => esc_html__('Backup', 'account-switcher')
                ],
            ]
        ]);
    }
}
