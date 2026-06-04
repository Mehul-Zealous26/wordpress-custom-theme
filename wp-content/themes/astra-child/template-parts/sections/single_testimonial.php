<?php
$testimonial_text = get_sub_field('testimonial_text');
$author_name = get_sub_field('author_name');
$author_position = get_sub_field('author_position');
$company_name = get_sub_field('company_name');
$company_industry = get_sub_field('company_industry');
$disable_avatar = get_sub_field('disable_avatar'); // true/false
$avatar = get_sub_field('avatar');
$select_spacer = get_sub_field('select_spacer');
$padding_style = get_spacer_padding_style($select_spacer);
?>

<section class="singal-testimonial-section p-124" <?php if ($padding_style)
                                                        echo 'style="' . esc_attr($padding_style) . '"'; ?>>
    <div class="container-box">
        <div class="singal-test-box">

            <?php if ($testimonial_text): ?>
                <?php echo $testimonial_text; ?>
            <?php endif; ?>

            <div class="singal-testi-author-box">

                <?php if (!$disable_avatar): ?>
                    <div class="single-testi-avatar">
                        <?php if (!empty($avatar)): ?>
                            <img src="<?php echo esc_url($avatar['url']); ?>" alt="<?php echo esc_attr($author_name); ?>">
                        <?php else: ?>
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/Image-f-2.png"
                                alt="Default Avatar">
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <div class="single-testi-author-info text-content-section">

                    <?php if ($author_name): ?>
                        <?php echo ($author_name); ?>
                    <?php endif; ?>

                    <?php if ($author_position || $company_name): ?>
                        <div>
                            <?php if ($author_position): ?>
                                <span><?php echo esc_html($author_position); ?></span>
                            <?php endif; ?>

                            <?php if ($author_position && $company_name): ?>
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/Breaks-dots.svg"
                                    alt="Break">
                            <?php endif; ?>

                            <?php if ($company_name): ?>
                                <span><?php echo esc_html($company_name); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($company_industry): ?>
                        <i><?php echo esc_html($company_industry); ?></i>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>
</section>