<?php get_header(); ?>
<div class="container w-60 margin-x-lg">
    <div class="row row-cols-1 row-cols-md-2 g-4">
        <?php
        if (have_posts()) :
            while (have_posts()) :
                the_post();
                $class = is_bookmarked(get_the_ID()) ? 'marked' : '';
                ?>
                <div class="col">
                    <div class="card">
                        <?php the_post_thumbnail(); ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php the_title(); ?></h5>
                            <p class="card-text"><?php the_content(); ?></p>
                            <span class="bookmark"><a href="#" class="btn btn-primary shadow-none <?php echo $class; ?>">Lưu lại</a></span>
                            <input type="hidden" value="<?php the_ID(); ?>" class="bookmark-post_id">
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