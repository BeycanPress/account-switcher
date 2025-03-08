<?php

declare(strict_types=1);

namespace BeycanPress\AccountSwitcher\PluginHero\Helpers;

trait Redirect
{
    /**
     * @param string $url
     * @return void
     */
    public static function redirect(string $url): void
    {
        wp_redirect($url);
        exit();
    }

    /**
     * @param string $url
     * @return void
     */
    public static function adminRedirect(string $url): void
    {
        add_action('admin_init', function () use ($url): void {
            wp_redirect($url);
            exit();
        });
    }

    /**
     * @param string $url
     * @return void
     */
    public static function templateRedirect(string $url): void
    {
        add_action('template_redirect', function () use ($url): void {
            wp_redirect($url);
            exit();
        });
    }
}
