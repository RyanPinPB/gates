<?php
/**
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 09/02/16
 * Time: 5:38 PM
 */
if ( is_singular( 'houzez_agent' ) ) {
    global $post;
    $agent_email = get_post_meta( $post->ID, 'fave_agent_email', true );
    $agent_name = get_the_title();
} else if ( is_author() ){
    global $current_author;
    $agent_email = $current_author->user_email;
    $agent_name = $current_author->display_name;
}

$enable_contact_form_7_agent_detail = houzez_option('enable_contact_form_7_agent_detail');
$contact_form_agent_detail = houzez_option('contact_form_agent_detail');

$forms_terms = houzez_option('agent_forms_terms');
$forms_terms_text = houzez_option('agent_forms_terms_text');

$agent_email = is_email( $agent_email ); ?>

<div class="form-small">

    <?php
    if( $enable_contact_form_7_agent_detail != 1 ) {
        if ($agent_email) { ?>
            <p class="agent-contact-title"><?php esc_html_e('CONTACT', 'houzez'); ?> <?php echo esc_attr($agent_name); ?></p>

            <form method="post" action="" id="agent_detail_contact_form">
                <input type="hidden" id="target_email" name="target_email"
                       value="<?php echo antispambot($agent_email); ?>">
                <input type="hidden" name="agent_detail_ajax_nonce" id="agent_detail_ajax_nonce"
                       value="<?php echo wp_create_nonce('agent-contact-nonce'); ?>"/>
                <input type="hidden" name="action" value="houzez_contact_agent" />

                <div class="form-group">
                    <input type="text" name="name" id="name" placeholder="<?php esc_html_e( 'Your Name', 'houzez' ); ?>" class="form-control">
                </div>
                <div class="form-group">
                    <input type="text" name="phone" id="phone" placeholder="<?php esc_html_e( 'Phone', 'houzez' ); ?>" class="form-control">
                </div>
                <div class="form-group">
                    <input type="email" name="email" id="email" placeholder="<?php esc_html_e( 'Email', 'houzez' ); ?>" class="form-control">
                </div>
                <div class="form-group">
                    <textarea name="message" id="message" rows="3"
                              class="form-control"><?php echo sprintf(esc_html__('Hi %s, I saw your profile on %s and wanted to see if you could help me', 'houzez'), $agent_name, get_option('blogname')); ?></textarea>
                </div>

                <?php if($forms_terms != 0) { ?>
                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input name="privacy_policy" type="checkbox">
                            <?php echo $forms_terms_text; ?>
                        </label>
                    </div>
                </div>
                <?php } ?>
                
                <?php get_template_part('template-parts/google', 'reCaptcha'); ?>

                <button type="submit" id="agent_detail_contact_btn" class="btn btn-secondary btn-block">
                    <?php esc_html_e('SEND MESSAGE', 'houzez'); ?>
                </button>
            </form>
            <div id="form_messages"></div>
        <?php }
    } else {
        echo do_shortcode($contact_form_agent_detail);
    }?>

</div>
