<?php
class Bookmark
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);
        add_action('wp_ajax_bookmark', [$this, 'callbackAjax']);
        add_action('wp_ajax_nopriv_bookmark', [$this, 'callbackAjax']);
        $this->registerShortcode();
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

    public function registerShortcode()
    {
        add_shortcode('bookmark', function ($atts) {
            $bookmark = new Bookmark();
            $post_ids = $bookmark->getBookmark();
            $this->showShortcode($post_ids);
        });
    }

    public function getBookmark()
    {
        global $wpdb;
        $table = "{$wpdb->prefix}bookmarks";
        $user_id = get_current_user_id();
        $query = "SELECT post_id FROM $table WHERE user_id=$user_id";
        return $wpdb->get_results($wpdb->prepare($query), ARRAY_N);
    }

    public function showShortcode($post_ids)
    {
        ?>
        <div class="container w-60 margin-x-lg" style="margin-left: 0">
            <div class="row row-cols-1 row-cols-md-2 g-4">
                <?php
                foreach ($post_ids as $post_id) :
                    $post_id = end($post_id);
                    $post = get_post($post_id);
                ?>
                    <div class="col">
                        <div class="card">
                            <?php echo get_the_post_thumbnail($post->ID); ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $post->post_title; ?></h5>
                                <p class="card-text"><?php echo $post->post_content; ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                ?>
            </div>
        </div>
        <?php
    }
}
$bookmark = new Bookmark();
