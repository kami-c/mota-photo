<?php foreach ($image_data as $image):
    if (isset($image) && is_array($image)) : ?>
        <div class="photo-bloc__img">
            <a
            href="<?php echo esc_url($image['url']); ?>" class="link"
            data-title="<?php esc_attr($image['title']); ?>"
            data-reference="<?php echo esc_attr($image['reference']); ?>"
            data-category="<?php echo esc_attr($image['category']); ?>"
            data-post-url="<?php echo esc_url($image['post_url']); ?>"
            data-format="<?php echo esc_url($image['format']); ?>"
            data-post-date="<?php echo esc_url($image['date']); ?>"
            >
            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" class="image"/>
            </a>
        </div>
    <?php endif;
endforeach; ?>
