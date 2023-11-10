<?php

namespace BeycanPress\AccountSwitcher;

use \Beycan\Response;

class Api extends PluginHero\Api
{
    /**
     * @var int
     */
    private $currentUserId;

    public function __construct()
    {
        $this->currentUserId = get_current_user_id();

        $this->addRoutes([
            'as-api' => [
                'login' => [
                    'callback' => 'login',
                    'methods' => ['POST']
                ],
                'rememberLogin' => [
                    'callback' => 'rememberLogin',
                    'methods' => ['POST']
                ],
                'saveAccount' => [
                    'callback' => 'saveAccount',
                    'methods' => ['POST']
                ],
            ]
        ]);
    }

    /**
     * @param WP_REST_Request $request
     * @return void
     */
    public function login($request) : void
    {
        if (!$this->currentUserId) {
            Response::error(esc_html__('Invalid request', 'accountSwitcher'), null, 'ERR');
        }

        $username = $request->get_param('username');
        $password = $request->get_param('password');
        $rememberMe = $request->get_param('rememberMe') ? true : false;
        $redirectTo = $this->getRedirectUrl($request->get_param('redirectTo'));

        if (!$password || !$username) {
            Response::error(esc_html__('Please fill out the required fields!', 'accountSwitcher'), null, 'ERR');
        }

        if (validate_username($username) == false) {
            Response::error(esc_html__('You entered an invalid username!', 'accountSwitcher'), null, 'ERR');
        }

        if (!username_exists($username)) {
            Response::error(esc_html__('No account found for this username!', 'accountSwitcher'), null, 'ERR');
        }

        $creds = [
            'user_login' => $username,
            'user_password' => $password,
            'remember' => $rememberMe
        ];

        if (is_wp_error($user = wp_signon($creds, is_ssl()))) {
            Response::error($user->get_error_message(), null, 'ERR');
        }

        if ($rememberMe) {
            Hooks::createOrUpdateCookie($user->ID);
        }

        Response::success(esc_html__('You have successfully logged in, your session account is being change...', 'accountSiwtcher'), [
            'redirectTo' => $redirectTo
        ]);
    }

    /**
     * @param WP_REST_Request $request
     * @return void
     */
    public function rememberLogin($request) : void
    {
        if (!$this->currentUserId) {
            Response::error(esc_html__('Invalid request', 'accountSwitcher'), null, 'ERR');
        }

        $userId = $request->get_param('userId');
        $secret = $request->get_param('secret');
        $redirectTo = $this->getRedirectUrl($request->get_param('redirectTo'));
        $user = get_user_by('ID', $userId);

        if (!$user) {
            Response::error(esc_html__('No account found for this user id!', 'accountSwitcher'), null, 'ERR');
        }

        if ($userId == $this->currentUserId) {
            Response::error(esc_html__('You are already logged in with the information you entered!', 'accountSwitcher'));
        }

        if (get_user_meta($userId, 'asSecret', true) != $secret) {
            Response::error(esc_html__('Invalid request', 'accountSwitcher'), null, 'ERR');
        }

        clean_user_cache($userId);
		wp_clear_auth_cookie();

		wp_set_current_user($userId);
		wp_set_auth_cookie($userId, false);
		update_user_caches($user);

        Response::success(esc_html__('You have successfully logged in, your session account is being change...', 'accountSiwtcher'), [
            'redirectTo' => $redirectTo
        ]);
    }

    /**
     * @param WP_REST_Request $request
     * @return void
     */
    public function saveAccount($request) : void
    {
        if (!$this->currentUserId) {
            Response::error(esc_html__('Invalid request', 'accountSwitcher'), null, 'ERR');
        }

        $redirectTo = $this->getRedirectUrl($request->get_param('redirectTo'));

        Hooks::createOrUpdateCookie($this->currentUserId);
        
        Response::success(esc_html__('You have successfully logged in, your session account is being change...', 'accountSiwtcher'), [
            'redirectTo' => $redirectTo
        ]);
    }

    /**
     * @param string $redirectTo
     * @return string
     */
    private function getRedirectUrl(string $redirectTo) : string
    {
        $redirectTo = $redirectTo ? $redirectTo : admin_url();

        if ($this->setting('loginRedirect')) {
            $redirectTo = $this->setting('loginRedirect') != 'same-page' ? $this->setting('loginRedirect') : $redirectTo;
        }

        return apply_filters("AccountSwitcher/RedirectTo", $redirectTo);
    }

}
