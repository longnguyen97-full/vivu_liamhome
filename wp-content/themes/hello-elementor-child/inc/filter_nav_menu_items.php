<?php
add_filter('wp_nav_menu_objects', 'wpseo_filter_wp_nav_menu_items', 10, 2);
function wpseo_filter_wp_nav_menu_items($menu_items, $args)
{
    foreach ($menu_items as $menu_item) {
        if (is_user_logged_in() && in_array($menu_item->post_name, ['dang-nhap', 'dang-ki'])) {
            array_push($menu_item->classes, 'hide');
        }
        if (!is_user_logged_in() && in_array($menu_item->post_name, ['ca-nhan', 'dang-xuat'])) {
            array_push($menu_item->classes, 'hide');
        }
    }
    return $menu_items;
};
