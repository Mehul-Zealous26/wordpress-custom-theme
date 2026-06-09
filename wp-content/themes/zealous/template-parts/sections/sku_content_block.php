<?php
$pre_title = get_sub_field('pre_title'); //type=Text
$title = get_sub_field('title'); //type=Text
$description = get_sub_field('description'); //type=Text
$materials = get_sub_field('materials'); //type=Text
$finish = get_sub_field('finish'); //type=Taxonomy
$example_heading = get_sub_field('example_heading');
$warranty = get_sub_field('warranty'); //type=Text
$year = get_sub_field('year'); //type=Text
$depth = get_sub_field('depth'); //type=Number
$application = get_sub_field('application'); //type=post-object
$solutions = get_sub_field('solutions'); //type=Taxonomy
$select_spacer = get_sub_field('select_spacer');
$padding_style = get_spacer_padding_style($select_spacer);
?>
<section class="product-f-video p-f-video-md v-top" id="sku_content_block" <?php if ($padding_style)
    echo 'style="' . esc_attr($padding_style) . '"'; ?>>
    <div class="container-box">
        <div class="product-f-video-left sub-title-with-text text-content-section">
            <?php if ($pre_title): ?>
                <div class="sub-heading">
                    <?php echo esc_html($pre_title); ?>
                </div>
            <?php endif; ?>
            <?php if ($title): ?>
                <?php echo ($title); ?>
            <?php endif; ?>
            <?php if ($description): ?>
                <div>
                    <?php echo ($description); ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="product-f-video-right">
            <div class="product-des-var-main">
                <?php if ($materials): ?>
                    <div class="product-des-var-box">
                        <div class="product-des-var-left">
                            Materials
                        </div>
                        <div class="product-des-var-right">
                            <?php echo esc_html($materials); ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($finish): ?>
                    <div class="product-des-var-box">
                        <div class="product-des-var-left">
                            Finish
                        </div>
                        <div class="product-des-var-right">
                            <div class="pdv-color">
                                <?php foreach ($finish as $term):
                                    // Get color from ACF (same as your table logic)
                                    $color_hex = get_field('color_palette', $term) ?: '#cccccc';
                                    ?>
                                    <i style="background-color: <?php echo esc_attr($color_hex); ?>;"></i>
                                    <?php echo esc_html($term->name); ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($example_heading): ?>
                    <div class="product-des-var-box">
                        <div class="product-des-var-left">
                            Example Heading
                        </div>
                        <div class="product-des-var-right">
                            <?php echo esc_html($example_heading); ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($warranty): ?>
                    <div class="product-des-var-box">
                        <div class="product-des-var-left">
                            Warranty
                        </div>
                        <div class="product-des-var-right">
                            <?php echo esc_html($warranty); ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($year): ?>
                    <div class="product-des-var-box">
                        <div class="product-des-var-left">
                            Year
                        </div>
                        <div class="product-des-var-right">
                            <?php echo esc_html($year); ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($depth): ?>
                    <div class="product-des-var-box">
                        <div class="product-des-var-left">
                            Depth
                            <span>(Depth below ground)</span>
                        </div>
                        <div class="product-des-var-right">
                            <?php echo esc_html($depth); ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($application): ?>
                    <div class="product-des-var-box">
                        <div class="product-des-var-left">
                            Application
                        </div>
                        <div class="product-des-var-right">
                            <?php
                            if (is_array($application)) {
                                $total = count($application);
                                $i = 0;

                                foreach ($application as $app_post) {
                                    $i++;
                                    echo '<a href="' . esc_url(get_permalink($app_post->ID)) . '">' . esc_html(get_the_title($app_post->ID)) . '</a>';

                                    // Add comma if not last item
                                    if ($i < $total) {
                                        echo ', ';
                                    }
                                }
                            } else {
                                echo '<a href="' . esc_url(get_permalink($application->ID)) . '">' . esc_html(get_the_title($application->ID)) . '</a>';
                            }
                            ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($solutions): ?>
                    <div class="product-des-var-box">
                        <div class="product-des-var-left">
                            Solutions
                        </div>
                        <div class="product-des-var-right">
                            <div class="pdv-tag-box">
                                <?php foreach ($solutions as $term): ?>
                                    <span><?php echo esc_html($term->name); ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <!-- Text repeater fields -->
                <?php if (have_rows('specifications')): ?>
                    <?php while (have_rows('specifications')):
                        the_row();
                        $heading = get_sub_field('label');
                        $content = get_sub_field('content');
                        ?>
                        <div class="product-des-var-box text-content-section">
                            <div class="product-des-var-left">
                                <?php echo ($heading); ?>
                            </div>
                            <div class="product-des-var-right">
                                <?php echo ($content); ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>


            </div>
        </div>
    </div>
</section>