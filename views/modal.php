<div class="as-modal" data-redirect="<?php echo esc_attr($this->setting('loginRedirect')); ?>">
    <div class="as-content">
        <div class="as-close">
            <svg aria-label="Close" class="_ab6-" color="#262626" fill="#262626" height="18" role="img" viewBox="0 0 24 24" width="18"><polyline fill="none" points="20.643 3.357 12 12 3.353 20.647" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"></polyline><line fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" x1="20.649" x2="3.354" y1="20.649" y2="3.354"></line></svg>
        </div>
        <div class="as-login <?php echo empty($users) ? 'active' : '' ?>">
            <div class="as-close">
                <svg aria-label="Close" class="_ab6-" color="#262626" fill="#262626" height="18" role="img" viewBox="0 0 24 24" width="18"><polyline fill="none" points="20.643 3.357 12 12 3.353 20.647" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"></polyline><line fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" x1="20.649" x2="3.354" y1="20.649" y2="3.354"></line></svg>
            </div>
            <form method="post" id="as-login-form">
                <input type="text" id="username" name="username" placeholder="<?php esc_attr_e('Username', 'accountSiwtcher'); ?>">
                <input type="password" id="password" name="password" placeholder="<?php esc_attr_e('Password', 'accountSiwtcher'); ?>">
                <label for="rememberMe">
                    <input type="checkbox" id="rememberMe" name="rememberMe"><?php esc_html_e('Remember me', 'accountSiwtcher'); ?>
                </label>
                <input type="submit" value="<?php esc_attr_e('Login', 'accountSiwtcher'); ?>">
            </form>
        </div>
        <div class="as-users <?php echo !empty($users) ? 'active' : '' ?>">
            <div class="as-title">
                <?php esc_html_e('Switch accounts', 'accountSwitcher'); ?>
            </div>
            <div class="as-user-list">
                <ul>
                    <?php if (!empty($users)) : ?>
                        <?php foreach ($users as $key => $user) : ?>
                            <li class="<?php echo esc_attr($user->id == get_current_user_id() ? 'current-user' : ''); ?>" data-user-id="<?php echo esc_attr($user->id); ?>" data-user-secret="<?php echo esc_attr($user->secret); ?>">
                                <span class="avatar">
                                    <img src="<?php echo esc_url($user->avatar); ?>" alt="<?php echo esc_attr($user->username); ?>">
                                </span>
                                <span class="username">
                                    <?php echo esc_html($user->username); ?>
                                </span>
                                <?php if ($user->id == get_current_user_id()) : ?>
                                    <span class="logged-in">
                                        <svg aria-label="Checkmark filled icon" class="_ab6-" color="#0095f6" fill="#0095f6" height="24" role="img" viewBox="0 0 24 24" width="24"><path d="M12.001.504a11.5 11.5 0 1 0 11.5 11.5 11.513 11.513 0 0 0-11.5-11.5Zm5.706 9.21-6.5 6.495a1 1 0 0 1-1.414-.001l-3.5-3.503a1 1 0 1 1 1.414-1.414l2.794 2.796L16.293 8.3a1 1 0 0 1 1.414 1.415Z"></path></svg>
                                    </span>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="as-login-exist-account">
                <?php esc_html_e('Login to an existing account', 'accountSwitcher'); ?>
            </div>
        </div>
    </div>
</div>