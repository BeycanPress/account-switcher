<?php

namespace BeycanPress\AccountSwitcher;

class Lang
{
    public static function get()
    {
        return [
            "somethingWentWrong" => esc_html__('Something went wrong', 'accountSwitcher'),
            "loggingIn" => esc_html__('Logging in...', 'accountSwitcher'),
            "pleaseWait" => esc_html__('Please wait...', 'accountSwitcher'),
            "login" => esc_html__('Login', 'accountSwitcher'),
            "save" => esc_html__('Save', 'accountSwitcher'),
            "dontSave" => esc_html__('Don\'t save', 'accountSwitcher'),
            "saveAccount" => esc_html__('Do you want to save your account for future logins?', 'accountSwitcher'),
            "successLogin" => esc_html__('You have successfully logged in, your session account is being change...', 'accountSwitcher'),
        ];
    }

}