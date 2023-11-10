<?php

namespace BeycanPress\AccountSwitcher;

class Hooks 
{
    use PluginHero\Helpers;

    /**
     * @var null|Api
     */
    private $api;

    /**
     *
     * @var string
     */
    private $mainJsKey;

    public function __construct()
    {
        $this->api = !$this->api ? new Api() : $this->api;

        add_filter('auth_cookie_expiration', [$this, 'saveUsers'], 10, 3);
        if ($this->setting('wooCommerceMyAccountPage')) {
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
    public function saveUsers(int $expiration, int $userId,  bool $remember) : int
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
    public static function createOrUpdateCookie(int $userId) : void 
    {
        $secret = wp_hash($userId + time());
        update_user_meta($userId, 'asSecret', $secret);
        $userData = ['id' => $userId, 'secret' => $secret];
        if (isset($_COOKIE['asUsers'])) {
            $users = (array) json_decode(stripslashes($_COOKIE['asUsers']));
            $users[$userId] = $userData;
            setcookie("asUsers", json_encode($users), time() + (10 * 365 * 24 * 60 * 60), COOKIEPATH, COOKIE_DOMAIN);
        } else {
            setcookie("asUsers", json_encode([$userId => $userData]), time() + (10 * 365 * 24 * 60 * 60), COOKIEPATH, COOKIE_DOMAIN);
        }
    }

    public function modal() 
    {

        $this->enqueueScripts();

        if (isset($_COOKIE['asUsers'])) {
            $users = (array) json_decode(stripslashes($_COOKIE['asUsers']));

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

        $this->viewEcho('modal', compact('users'));
    }

    /**
     * @return void
     */
    public function enqueueScripts() : void
    {
        $this->addStyle('css/main.css');
        $this->addScript('js/sweetalert2.js');
        $this->mainJsKey = $this->addScript('js/main.js', ['jquery']);
        wp_localize_script($this->mainJsKey, 'AS', [
            'lang' => Lang::get(),
            'apiUrl' => $this->api->getUrl(),
        ]);
    }

    /**
     * @param array $menuLinks
     * @return array
     */
    function wooCommerceMyAccountMenu(array $menuLinks) : array
    {
		unset($menuLinks['customer-logout']);
        $menuLinks['account-switcher'] = esc_html__('Switch accounts', 'accountSwitcher');
        $menuLinks['customer-logout'] = esc_html__('Logout', 'woocommerce');
        
        return $menuLinks;
    }

    /**
     * @param string $url
     * @param string $endpoint
     * @return string
     */
    function wooCommerceMyAccountMenuEndpointUrl(string $url, string $endpoint) : string
    {
        if ('account-switcher' === $endpoint) {
            $url = '#account-switcher';
        }

        return $url;
    
    }
}
