<?php

namespace BeycanPress\AccountSwitcher;

use BeycanPress\AccountSwitcher\PluginHero\Plugin;

class Loader extends Plugin
{
    public function __construct($pluginFile)
    {
        parent::__construct([
            'pluginFile' => $pluginFile,
            'pluginKey' => 'accountSwitcher',
            'textDomain' => 'accountSwitcher',
            'settingKey' => 'accountSwitcherSettings',
            'pluginVersion' => '1.0.0'
        ]);

        add_action('init', function() {
            new Hooks();
        });
    }

    public function adminProcess()
    {
        new OtherPlugins($this->pluginFile);
        add_action('init', function(){
            new Settings();
        }, 9);
    }
}
