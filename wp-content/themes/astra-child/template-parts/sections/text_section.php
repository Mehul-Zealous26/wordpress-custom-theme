<?php
$select_spacer = get_sub_field('select_spacer');
$padding_style = get_spacer_padding_style($select_spacer);
if(have_rows('tab_content')) :
?>
<div class="text-section"  <?php if ($padding_style) echo 'style="' . esc_attr($padding_style) . '"'; ?> id="text_section">
    <div class="container-box">
        <div class="table-tab-heading">
            <label>Table Of Contents:</label>
            <ul class="tab-navigation">
                <?php while (have_rows('tab_content')): the_row();
                    $heading = get_sub_field('heading');
                    if ($heading):
                        $anchor = sanitize_title($heading);
                ?>
                <li><a href="#<?php echo $anchor; ?>" class="active-<?php echo $anchor; ?>"><?php echo esc_html($heading); ?></a></li>
                <?php endif; endwhile; ?>
            </ul>
        </div>
        <div class="tab-content">
            <?php while (have_rows('tab_content')): the_row();
                $heading = get_sub_field('heading');
                $content = get_sub_field('content');
                if ($heading):
                    $anchor = sanitize_title($heading);
            ?>
            <div class="content-section" id="<?php echo $anchor; ?>">
                <h2><?php echo esc_html($heading) ?></h2>
                <?php if ($content): ?><?php echo $content ?><?php endif; ?>
            </div>
            <?php endif; endwhile; ?>
        </div>
    </div>
</div>
<?php endif; ?> 