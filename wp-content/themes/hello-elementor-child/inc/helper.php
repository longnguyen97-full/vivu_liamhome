<?php
if (!function_exists('arr_dump')) {
    function arr_dump($array)
    {
        echo '<pre>';
        print_r($array);
        echo '</pre>';
    }
}
if (!function_exists('get_dynamic_version')) {
    function get_dynamic_version($version = '')
    {
        return !empty($version) ? $version . '.' . strtotime('now') : strtotime('now');
    }
}
if (!function_exists('is_bookmarked')) {
    function is_bookmarked($post_id)
    {
        $bookmark = new Bookmark();
        $user_id  = get_current_user_id();
        return $bookmark->isBookmarked($user_id, $post_id) ? true : false;
    }
}
