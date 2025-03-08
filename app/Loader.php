<?php

declare(strict_types=1);

namespace BeycanPress\AccountSwitcher;

use BeycanPress\AccountSwitcher\PluginHero\Plugin;

class Loader extends Plugin
{
    /**
     * Loader constructor.
     * @param string $pluginFile
     */
    public function __construct(string $pluginFile)
    {
        parent::__construct([
            'pluginFile' => $pluginFile,
            'pluginKey' => 'account-switcher',
            'textDomain' => 'account-switcher',
            'settingKey' => 'accountSwitcherSettings',
            'pluginVersion' => '1.0.0'
        ]);

        new Hooks();
    }

    /**
     * @return void
     */
    public function adminProcess(): void
    {
        add_action('init', function (): void {
            new Settings();
        }, 9);
    }
}
