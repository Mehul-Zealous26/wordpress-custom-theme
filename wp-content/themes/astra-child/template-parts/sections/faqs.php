<?php
$pretitle = get_sub_field('pretitle'); //type=text
$title = get_sub_field('title'); //type=text
$description = get_sub_field('description'); //type=wyswig

$faq_items = get_sub_field('faq_items'); //type=post-object
$content_alignment = get_sub_field('content_alignment');
$select_spacer = get_sub_field('select_spacer');
$padding_style = get_spacer_padding_style($select_spacer);

$enable_global_content = get_sub_field('enable_global_content');

if ($enable_global_content) {
    // TRUE → fetch from global options page
    $more_questions = get_field('more_questions_g', 'option'); //type=text
    $subtitle       = get_field('subtitle_g', 'option');
    $contact_button = get_field('contact_button_g', 'option');
} else {
    // FALSE → fetch from local sub field
    $more_questions = get_sub_field('more_questions');
    $subtitle       = get_sub_field('subtitle');
    $contact_button = get_sub_field('contact_button');
}
?>


<?php if ($faq_items): ?>
    <section class="product-f-video product-f-text" id="faqs" <?php if ($padding_style)
        echo 'style="' . esc_attr($padding_style) . '"'; ?>>
        <div class="container-box">
            <div class="product-f-video-left <?php echo esc_attr($content_alignment) ?> text-content-section">
                <div class="sub-heading">
                    <?php echo esc_html($pretitle) ?>
                </div>
                <?php echo ($title) ?>
                <div>
                    <?php echo $description ?>
                </div>
                <?php if ($faq_items): ?>
                    <div class="accordion-main">
                        <?php
                        // Handle both single post and array of posts
                        $posts_array = is_array($faq_items) ? $faq_items : [$faq_items];
                        $counter = 0;
                        foreach ($posts_array as $faq_post):
                            $counter++;
                            $faq_title = get_the_title($faq_post);
                            $faq_content = get_the_content(null, false, $faq_post);
                            $faq_permalink = get_permalink($faq_post);
                            ?>
                            <div class="accordion-box<?php echo ($counter == 1) ? ' active' : ''; ?>">
                                <div class="accordion-title"><i></i><?php echo esc_html($faq_title); ?></div>
                                <div class="accordion-desc" <?php if ($counter == 1)
                                    echo ' style="display: block;"';
                                else
                                    echo ' style="display: none;"'; ?>>
                                    <?php echo apply_filters('the_content', $faq_content); ?>
                                    <a href="<?php echo esc_url($faq_permalink); ?>" class="btn secondary-btn btn-xs">Continue
                                        reading about this topic</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <div class="accordion-bottom">
                            <div class="accordion-bottom-text text-content-section">
                                <?php echo ($more_questions); ?>
                                <?php echo ($subtitle); ?>
                            </div>
                            <?php if (!empty($contact_button)) {
                                $target = !empty($contact_button['target']) ? $contact_button['target'] : '_self';
                                ?>
                                <a href="<?php echo esc_url($contact_button['url']); ?>" target="<?php echo esc_attr($target); ?>"
                                    rel="<?php echo ($target === '_blank') ? 'noopener noreferrer' : ''; ?>"
                                    class="btn secondary-btn">
                                    <?php echo esc_html($contact_button['title']); ?>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>