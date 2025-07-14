<?php get_header(); ?>

<?php
    /*Template Name: Registration Page Template */
?>

<div class="container">
    <div class="ai-max-custom-auth-column dt-sc-full-width  wdt-registration-form">
        <div class="ai-max-custom-auth-sc-border-title"> <h2><span><?php esc_html_e('Register Form', 'netlink-pro');?></span> </h2></div>
        <div class="ai-max-custom-auth-register-alert"></div>

        <p> <strong><?php esc_html_e('Do not have an account?', 'netlink-pro');?></strong> </p>

        <form name="loginform" id="loginform" action="<?php echo wp_registration_url(); ?>" method="post">

            <p>
                <input type="text" name="first_name"  id="first_name" class="input" value="" size="20" required="required" placeholder="<?php esc_html_e('Firstname *', 'netlink-pro');?>" />
            </p>
            <p>
                <input type="text" name="last_name" id="last_name"  class="input" value="" size="20" placeholder="<?php esc_html_e('Lastname', 'netlink-pro');?>" />
            </p>
            <p>
                <input type="text" name="user_name" id="user_name"  class="input" value="" size="20" required="required" placeholder="<?php esc_html_e('Username *', 'netlink-pro');?>" />
            </p>
            <p>
                <input type="email" name="user_email" id="user_email"  class="input" value="" size="20" required="required" placeholder="<?php esc_html_e('Email Id *', 'netlink-pro');?>" />
            </p>
            <p>
                <input type="password" name="password" id="password"  class="input" value="" size="20" required="required" placeholder="<?php esc_html_e('Password *', 'netlink-pro');?>" />
            </p>
            <p>
                <input type="password" name="cpassword" id="cpassword"  class="input" value="" size="20" required="required" placeholder="<?php esc_html_e('Confirm Password *', 'netlink-pro');?>"/>
                <span class="password-alert"></span>
            </p>
            <?php do_action( 'anr_captcha_form_field' ); ?>
            <p> <?php  echo apply_filters('dt_sc_reg_form_elements', '', array () ); ?> </p>
            <p class="submit">
                <input type="submit" class="button-primary ai-max-custom-auth-register-button" id="ai-max-custom-auth-register-button" value="<?php esc_attr_e('Register', 'netlink-pro');?>" />
            </p>
            <p>
                <?php echo esc_html__('Already have an account.?', 'netlink-pro'); ?> 
                <a href="#" title=<?php echo esc_html__('Login', 'netlink-pro'); ?> class="netlink-pro-login-link" onclick="return false"><?php echo esc_html__('Login', 'netlink-pro'); ?></a>
            </p>
        </form>
    </div><!-- Registration Form End -->
</div>

<?php get_footer(); ?>