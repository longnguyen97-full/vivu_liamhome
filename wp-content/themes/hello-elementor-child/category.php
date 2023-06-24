<?php get_header(); ?>
<div class="container w-60 margin-x-lg">
    <div class="row row-cols-1 row-cols-md-2 g-4">
        <?php
        if (have_posts()) :
            while (have_posts()) :
                the_post();
                $post_id = get_the_ID();
                $class = is_bookmarked($post_id) ? 'marked' : '';
                ?>
                <div class="col">
                    <div class="card card-border">
                        <div class="card-thumbnail"><?php the_post_thumbnail(); ?></div>
                        <div class="card-body">
                            <h4 class="card-title"><?php the_title(); ?></h4>
                            <?php
                            // 1. create a variable called information store fields
                            $information = "";
                            $website = get_field('website', $post_id);
                            $phone_number = get_field('phone_number', $post_id);
                            $address = get_field('address', $post_id);
                            $opening_hours = get_field('opening_hours', $post_id);
                            $closing_hours = get_field('closing_hours', $post_id);
                            $reference_price = get_field('reference_price', $post_id);
                            // 2. add fields that has value to information
                            if (!empty($website)) {
                                $information .= "<span>Website: {$website}</span><br>";
                            }
                            if (!empty($phone_number)) {
                                $information .= "<span>Số diện thoại: {$phone_number}</span><br>";
                            }
                            if (!empty($address)) {
                                $information .= "<span>Địa chỉ:: {$address}</span><br>";
                            }
                            if (!empty($opening_hours)) {
                                $information .= "<span>Giờ mở cửa: {$opening_hours}</span><br>";
                            }
                            if (!empty($closing_hours)) {
                                $information .= "<span>Giờ đóng cửa: {$closing_hours}</span><br>";
                            }
                            if (!empty($reference_price)) {
                                $information .= "<span>Giá tham khảo: {$reference_price}</span><br>";
                            }
                            ?>
                            <div class="card-text">
                                <?php
                                // 3. display information
                                echo $information;
                                ?>
                            </div>
                            <a href="<?php echo get_permalink($post_id); ?>" class="btn btn-primary shadow-none">Chi tiết</a>
                            <?php if (is_user_logged_in()) : ?>
                                <span class="bookmark"><a href="#" class="btn btn-primary shadow-none <?php echo $class; ?>">Lưu lại</a></span>
                                <input type="hidden" value="<?php $post_id; ?>" class="bookmark-post_id">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php
            endwhile;
        endif;
        ?>
    </div>
</div>
<?php get_footer(); ?>