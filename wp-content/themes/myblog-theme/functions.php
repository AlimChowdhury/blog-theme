<?php

function myblog_setup(){
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    register_nav_menus([
        'main_menu' => 'Main Menu'
    ]);
}

add_action('after_setup_theme', 'myblog_setup');

function myblog_assets(){
    wp_enqueue_style('main-style', get_stylesheet_uri());
}

add_action('wp_enqueue_scripts', 'myblog_assets');


add_action('init', function() {
    register_post_type('project', [
        'public' => true,
        'label' => 'Projects',
        'supports' => ['title', 'editor', 'thumbnail']
    ]);
});

// Register a shortcode: [simple_contact_form]
function myblog_simple_contact_form() {
    ob_start();
    ?>
    <form method="post">
        <p><input type="text" name="cf_name" placeholder="Your Name" required></p>
        <p><input type="email" name="cf_email" placeholder="Your Email" required></p>
        <p><textarea name="cf_message" placeholder="Your Message" required></textarea></p>
        <p><input type="submit" name="cf_submitted" value="Send"></p>
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode('simple_contact_form', 'myblog_simple_contact_form');


// Handle Form Submission
function myblog_handle_form_submission() {
    if (isset($_POST['cf_submitted'])) {
        $name = sanitize_text_field($_POST['cf_name']);
        $email = sanitize_email($_POST['cf_email']);
        $message = sanitize_textarea_field($_POST['cf_message']);

        // You can send email or save to database here
        wp_mail(get_option('admin_email'), 'Contact Form: '.$name, $message, ['Reply-To: '.$email]);

        echo "<p style='color: green;'>Thank you, your message has been sent!</p>";
    }
}
add_action('wp_head', 'myblog_handle_form_submission');



function myblog_widgets_init() {
    register_sidebar([
        'name' => 'Main Sidebar',
        'id' => 'main_sidebar',
        'before_widget' => '<div class="widget">',
        'after_widget'  => '</div>',
    ]);
}
add_action('widgets_init', 'myblog_widgets_init');


