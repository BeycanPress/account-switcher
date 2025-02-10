<?php

declare(strict_types=1);

namespace BeycanPress\AccountSwitcher;

use BeycanPress\AccountSwitcher\PluginHero\Helpers;

class Hooks
{
    /**
     * @var null|RestAPI
     */
    private ?RestAPI $api = null;

    /**
     *
     * @var string
     */
    private string $mainJsKey;

    /**
     * Hooks constructor.
     */
    public function __construct()
    {
        $this->api = !$this->api ? new RestAPI() : $this->api;

        add_filter('auth_cookie_expiration', [$this, 'saveUsers'], 10, 3);
        if (Settings::get('wooCommerceMyAccountPage')) {
            add_filter('woocommerce_account_menu_items', [$this, 'wooCommerceMyAccountMenu'], 10, 1);
            add_filter('woocommerce_get_endpoint_url', [$this, 'wooCommerceMyAccountMenuEndpointUrl'], 10, 2);
        }

        if (is_user_logged_in()) {
            add_action('wp_footer', [$this, 'modal']);
        }
    }

    /**
     * @param integer $expiration
     * @param integer $userId
     * @param boolean $remember
     * @return integer
     */
    public function saveUsers(int $expiration, int $userId, bool $remember): int
    {
        if ($remember) {
            self::createOrUpdateCookie($userId);
        }

        return $expiration;
    }

    /**
     * @param integer $userId
     * @return void
     */
    public static function createOrUpdateCookie(int $userId): void
    {
        $secret = wp_hash($userId + time());
        update_user_meta($userId, 'asSecret', $secret);
        $userData = ['id' => $userId, 'secret' => $secret];
        if (isset($_COOKIE['asUsers'])) {
            $users = (array) json_decode(stripslashes(sanitize_text_field(wp_unslash($_COOKIE['asUsers']))));
            $users[$userId] = $userData;
            /** @disregard */
            setcookie("asUsers", wp_json_encode($users), time() + (10 * 365 * 24 * 60 * 60), COOKIEPATH, COOKIE_DOMAIN);
        } else {
            /** @disregard */
            setcookie(
                "asUsers",
                wp_json_encode([$userId => $userData]),
                time() + (10 * 365 * 24 * 60 * 60),
                COOKIEPATH,
                COOKIE_DOMAIN
            );
        }
    }

    /**
     * @return void
     */
    public function modal(): void
    {
        $this->enqueueScripts();

        if (isset($_COOKIE['asUsers'])) {
            $users = (array) json_decode(stripslashes(sanitize_text_field(wp_unslash($_COOKIE['asUsers']))));

            foreach ($users as $key => &$user) {
                $data = get_userdata($user->id);
                if ($user->id == get_current_user_id()) {
                    unset($users[$key]);
                    $currentUser = (object) [
                        'id' => $user->id,
                        'avatar' => get_avatar_url($user->id),
                        'username' => $data->user_login,
                        'secret' => $user->secret
                    ];
                } else {
                    $user = (object) [
                        'id' => $user->id,
                        'avatar' => get_avatar_url($user->id),
                        'username' => $data->user_login,
                        'secret' => $user->secret
                    ];
                }
            }

            if (isset($currentUser)) {
                array_unshift($users, $currentUser);
            }
        } else {
            $users = [];
        }

        Helpers::viewEcho('modal', compact('users'));
    }

    /**
     * @return void
     */
    public function enqueueScripts(): void
    {
        Helpers::addStyle('main.css');
        Helpers::addScript('sweetalert2.js');
        $this->mainJsKey = Helpers::addScript('main.js', ['jquery']);
        wp_localize_script($this->mainJsKey, 'AS', [
            'lang' => Lang::get(),
            'apiUrl' => $this->api->getUrl(),
        ]);
    }

    /**
     * @param array<mixed> $menuLinks
     * @return array<mixed>
     */
    public function wooCommerceMyAccountMenu(array $menuLinks): array
    {
        unset($menuLinks['customer-logout']);
        $menuLinks['account-switcher'] = esc_html__('Switch accounts', 'account-switcher');
        $menuLinks['customer-logout'] = esc_html__('Logout', 'account-switcher');

        return $menuLinks;
    }

    /**
     * @param string $url
     * @param string $endpoint
     * @return string
     */
    public function wooCommerceMyAccountMenuEndpointUrl(string $url, string $endpoint): string
    {
        if ('account-switcher' === $endpoint) {
            $url = '#account-switcher';
        }

        return $url;
    }
}
