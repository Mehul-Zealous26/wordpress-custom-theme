<?php
$pre_title = get_sub_field('pre_title');
$title = get_sub_field('title');
$description = get_sub_field('description');
$select_spacer = get_sub_field('select_spacer');
$padding_style = get_spacer_padding_style($select_spacer);
?>

<div class="office-section" <?php if ($padding_style)
    echo 'style="' . esc_attr($padding_style) . '"'; ?>
    id="office_locations">
    <div class="container-box">
        <div class="sub-title-with-text w-600 text-content-section">
            <?php if ($pre_title): ?>
                <div class="sub-heading"><?php echo esc_html($pre_title); ?></div>
            <?php endif ?>
            <?php if ($title): ?>
                <?php echo ($title); ?>
            <?php endif ?>
            <?php if ($description): ?>
                <?php echo $description; ?>
            <?php endif ?>
        </div>
        <div class="office-row">
            <?php if (have_rows('locations')): ?>
                <?php while (have_rows('locations')):
                    the_row();
                    $google_map_embed_url = get_sub_field('google_map_embed_url');
                    $office_title = get_sub_field('office_title');
                    $office_address = get_sub_field('office_address');
                    $google_maps_link = get_sub_field('google_maps_link');
                    ?>
                    <div class="office-col">
                        <div class="office-location">
                            <?php if ($google_map_embed_url): ?>
                                <?php echo $google_map_embed_url; ?>
                            <?php endif ?>
                        </div>
                        <div class="office-info text-content-section">
                            <?php if ($office_title): ?>
                                <?php echo ($office_title); ?>
                            <?php endif ?>
                            <?php if ($office_address): ?>
                                <?php echo $office_address; ?>
                            <?php endif ?>
                            <?php if ($google_maps_link):
                                $target = !empty($google_maps_link['target']) ? $google_maps_link['target'] : '_self';
                                ?>
                                <a href="<?php echo esc_url($google_maps_link['url']); ?>" target="<?php echo esc_attr($target); ?>"
                                    rel="<?php echo ($target === '_blank') ? 'noopener noreferrer' : ''; ?>"
                                    class="btn btn-sm secondary-btn">
                                    <?php echo esc_html($google_maps_link['title']); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</div>