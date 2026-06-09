<?php
$select_spacer = get_sub_field('select_spacer');
$padding_style = get_spacer_padding_style($select_spacer);
?>

<section class="blog-detail-section" id="simple_content">

    <div class="text-section" <?php if (!empty($padding_style))
        echo 'style="' . esc_attr($padding_style) . '"'; ?>>
        <div class="container-box">

            <?php
            if (have_rows('tab_content')):

                $index = 0;

                while (have_rows('tab_content')):
                    the_row();

                    $heading = get_sub_field('heading');
                    $content = get_sub_field('content');
                    ?>
                    <div class="text-content-section">

                        <?php if (!empty($heading)): ?>
                            <?php echo ($heading); ?>
                        <?php endif; ?>

                        <?php if (!empty($content)): ?>
                            <?php echo $content; ?>
                        <?php endif; ?>

                    </div>

                    <?php
                    $index++;
                endwhile;

            endif;
            ?>

        </div>
    </div>

</section>