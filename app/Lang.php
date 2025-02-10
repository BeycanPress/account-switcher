<?php

declare(strict_types=1);

// @phpcs:disable Generic.Files.LineLength

namespace BeycanPress\AccountSwitcher;

class Lang
{
    /**
     * @return array<mixed>
     */
    public static function get(): array
    {
        return [
            "somethingWentWrong" => esc_html__('Something went wrong', 'account-switcher'),
            "loggingIn" => esc_html__('Logging in...', 'account-switcher'),
            "pleaseWait" => esc_html__('Please wait...', 'account-switcher'),
            "login" => esc_html__('Login', 'account-switcher'),
            "save" => esc_html__('Save', 'account-switcher'),
            "dontSave" => esc_html__('Don\'t save', 'account-switcher'),
            "saveAccount" => esc_html__('Do you want to save your account for future logins?', 'account-switcher'),
            "successLogin" => esc_html__('You have successfully logged in, your session account is being change...', 'account-switcher'),
        ];
    }
}
