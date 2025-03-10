<?php 
if (!defined('ABSPATH')) exit;
// phpcs:disable PluginCheck.CodeAnalysis.ImageFunctions.NonEnqueuedImage
?>
<div class="wrap">
    <h1 class="wp-heading-inline">
        <?php echo esc_html__('BeycanPress Plugins', 'account-switcher'); ?>
    </h1>
    <hr class="wp-header-end">
    <br>
    <div class="wrapper">
        <div class="box box-33">
            <div class="postbox">
                <div class="activity-block" style="padding: 20px; box-sizing: border-box; margin:0">
                    <ul class="product-list">
                        <?php if (isset($plugins)) :
                            foreach ($plugins as $product) : ?>
                                <li>
                                    <a href="<?php echo isset($product->landing_page) ? esc_url($product->landing_page) : esc_url($product->permalink); ?>" target="_blank">
                                        <img src="<?php echo esc_url($product->image); ?>" alt="<?php echo esc_attr($product->title) ?>">
                                        <span><?php echo esc_html($product->title) ?></span>
                                    </a>
                                </li>
                            <?php endforeach;
                        else :
                            echo esc_html__('No product found!', 'account-switcher');
                        endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
