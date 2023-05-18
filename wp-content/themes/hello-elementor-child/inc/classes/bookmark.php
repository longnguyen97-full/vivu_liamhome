<?php
class Bookmark
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);
        add_action('wp_ajax_bookmark', [$this, 'callbackAjax']);
        add_action('wp_ajax_nopriv_bookmark', [$this, 'callbackAjax']);
    }

    public function enqueueScripts()
    {
        wp_register_script('bookmark', get_stylesheet_directory_uri() . '/assets/js/bookmark.js', ['jquery'], get_dynamic_version());
        wp_localize_script('bookmark', 'bookmark_params', ['ajax_url' => admin_url('admin-ajax.php')]);
        wp_enqueue_script('bookmark');
    }

    public function callbackAjax()
    {
        $mark_post = (isset($_POST['markPost'])) ? $_POST['markPost'] : '';
        $post_id   = (isset($_POST['postID'])) ? $_POST['postID'] : '';

        global $wpdb;
        $table = "{$wpdb->prefix}bookmarks";
        $data = [
            'user_id' => get_current_user_id(),
            'post_id' => $post_id
        ];
        if ($mark_post == 'true') {
            $response = $this->insertBookmark($table, $data);
        } else {
            $response = $this->removeBookmark($table, $data);
        }

        wp_send_json_success($response);
        exit();
    }

    public function insertBookmark($table, $data)
    {
        global $wpdb;
        $wpdb->insert(
            $table,
            ['user_id' => $data['user_id'], 'post_id' => $data['post_id']],
            ['%s', '%s']
        );
        $insert_id = $wpdb->insert_id;
        return !empty($insert_id) ? 'Insert successfully!' : false;
    }

    public function removeBookmark($table, $data)
    {
        global $wpdb;
        $delete_id = $wpdb->delete(
            $table,
            ['user_id' => $data['user_id'], 'post_id' => $data['post_id']],
            ['%s', '%s'],
        );
        return !empty($delete_id) ? 'Delete successfully!' : false;
    }

    public function isBookmarked($user_id, $post_id)
    {
        global $wpdb;
        $table = "{$wpdb->prefix}bookmarks";
        $checkIfExists = $wpdb->get_var("SELECT ID FROM $table WHERE user_id = '$user_id' AND post_id = '$post_id'");
        return !empty($checkIfExists) ? true : false;
    }
}
$bookmark = new Bookmark();
