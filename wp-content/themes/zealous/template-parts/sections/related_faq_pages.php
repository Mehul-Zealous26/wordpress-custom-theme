<?php
$title = get_sub_field('title');
$related_faq = get_sub_field('related_faq'); //type=post-object, post-type=faq
$select_spacer = get_sub_field('select_spacer');
$padding_style = get_spacer_padding_style($select_spacer);
?>
<section class="faq-section-main" id="related_faq_pages" <?php if ($padding_style)
    echo 'style="' . esc_attr($padding_style) . '"'; ?>>
    <div class="faq-right-s-box">
        <div class="faq-section-center b-0 text-content-section">
            <?php if (!empty($title)) { ?>
                <?php echo ($title); ?>
            <?php } ?>
            <?php if ($related_faq):
                $posts_array = is_array($related_faq) ? $related_faq : [$related_faq];
                foreach ($posts_array as $faq_post): ?>
                    <a href="<?php echo get_permalink($faq_post); ?>"><?php echo get_the_title($faq_post); ?></a>
                <?php endforeach;
            endif; ?>
        </div>
    </div>
</section>