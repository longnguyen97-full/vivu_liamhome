<?php
// http://vivu.liamhome.wsl/updatedb.php?code=18052023
// https://vivu.liamhome.link/updatedb.php?code=18052023
require('./wp-blog-header.php');
if (!isset($_GET['code']) || $_GET['code'] != '18052023') {
    exit();
}

$table_name = $wpdb->prefix . 'bookmarks';
$charset_collate = $wpdb->get_charset_collate();
$sql = "CREATE TABLE $table_name (
    ID bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    user_id varchar(255) NOT NULL,
    post_id varchar(255) NOT NULL,
    PRIMARY KEY (ID)
) $charset_collate;";
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
if ($wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") != $table_name) {
    dbDelta($sql);
    echo "<span style='color: green'>Table {$table_name} is created successfully!</span>";
}
