<?php
class FeatureButton
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);
        add_action('wp_ajax_feature_button', [$this, 'callbackAjax']);
        add_action('wp_ajax_nopriv_feature_button', [$this, 'callbackAjax']);
    }

    public function enqueueScripts()
    {
        wp_register_script('feature-button', get_stylesheet_directory_uri() . '/assets/js/feature-button.js', ['jquery'], get_dynamic_version());
        wp_localize_script('feature-button', 'ajax_object', ['ajax_url' => admin_url('admin-ajax.php')]);
        wp_enqueue_script('feature-button');
    }

    public function callbackAjax()
    {
        $postIDs = (isset($_POST['postIDs'])) ? $_POST['postIDs'] : '';
        foreach ($postIDs as $postID) {
            $class = is_bookmarked($postID) ? 'marked' : '';
            $postURL = get_permalink($postID);
            $response[] = ['postID' => $postID, 'class' => $class, 'postURL' => $postURL];
        }

        wp_send_json_success($response);
        exit();
    }
}
$feature_button = new FeatureButton();
