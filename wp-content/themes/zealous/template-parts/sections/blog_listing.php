<?php
$barrier_group_blog_title = get_sub_field('barrier_group_blog_title');
$blog_top_section = get_sub_field('blog_top_section'); //type=post-object
$select_spacer = get_sub_field('select_spacer');
$padding_style = get_spacer_padding_style($select_spacer);
?>

<section class="light-gray-hero">
    <?php contact_form_dynamic(); ?>
    <div class="container-box">
        <div class="breadcrumbs-box">
            <?php custom_breadcrumbs(); ?>
        </div>
        <?php if ($barrier_group_blog_title) { ?>
            <div class="sub-title-with-text f-100 text-content-section">
                <?php echo ($barrier_group_blog_title); ?>
            </div>
        <?php } ?>
        <!--display $blog_top_section here starts-->
        <?php if ($blog_top_section): ?>
            <div class="blog-top-section">
                <?php foreach ($blog_top_section as $post):
                    setup_postdata($post); ?>
                    <a href="<?php echo get_permalink(); ?>" class="blog-list-box">
                        <div class="blog-img-box">
                            <?php if (has_post_thumbnail($post->ID)): ?>
                                <img src="<?php echo get_the_post_thumbnail_url($post->ID, 'full'); ?>"
                                    alt="<?php echo get_the_title(); ?>">
                            <?php else: ?>
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/new-img.jpg"
                                    alt="<?php echo get_the_title(); ?>">
                            <?php endif; ?>
                        </div>
                        <div class="blog-list-info">
                            <div class="blog-list-date"><?php echo get_the_date('l, j F Y'); ?></div>
                            <h6><?php echo get_the_title(); ?></h6>
                            <div class="blog-list-tags">
                                <?php
                                $tags = get_the_tags();
                                if ($tags) {
                                    foreach ($tags as $tag) {
                                        echo '<span>' . esc_html($tag->name) . '</span>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </a>
                <?php endforeach;
                wp_reset_postdata(); ?>
                <div class="clr"></div>
            </div>
        <?php endif; ?>
        <!--display $blog_top_section here ends-->
    </div>
</section>

<?php
//post-type=post, taxonomy=category
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$posts_per_page = 8;

$blog_query = new WP_Query(array(
    'post_type' => 'post',
    'posts_per_page' => $posts_per_page,
    'post_status' => 'publish',
    'paged' => $paged
));

$total_posts = wp_count_posts('post')->publish;
$start_item = (($paged - 1) * $posts_per_page) + 1;
$end_item = min($paged * $posts_per_page, $total_posts);
?>
<!--All blog listing here starts-->
<section class="blog-listing-main" <?php if ($padding_style)
    echo 'style="' . esc_attr($padding_style) . '"'; ?>>
    <div class="container-box">
        <div class="product-list-filter-section filter-section-border">
            <div class="plf-section-left">
                <div class="filter-btn-main">
                    <a href="javascript:void(0)" class="btn btn-sm gray-btn blog-filter-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path
                                d="M3.125 6.87502H5.70312C5.84081 7.41278 6.15356 7.88942 6.59207 8.22979C7.03057 8.57017 7.56989 8.75492 8.125 8.75492C8.68011 8.75492 9.21943 8.57017 9.65793 8.22979C10.0964 7.88942 10.4092 7.41278 10.5469 6.87502H16.875C17.0408 6.87502 17.1997 6.80917 17.3169 6.69196C17.4342 6.57475 17.5 6.41578 17.5 6.25002C17.5 6.08426 17.4342 5.92529 17.3169 5.80808C17.1997 5.69087 17.0408 5.62502 16.875 5.62502H10.5469C10.4092 5.08726 10.0964 4.61062 9.65793 4.27024C9.21943 3.92987 8.68011 3.74512 8.125 3.74512C7.56989 3.74512 7.03057 3.92987 6.59207 4.27024C6.15356 4.61062 5.84081 5.08726 5.70312 5.62502H3.125C2.95924 5.62502 2.80027 5.69087 2.68306 5.80808C2.56585 5.92529 2.5 6.08426 2.5 6.25002C2.5 6.41578 2.56585 6.57475 2.68306 6.69196C2.80027 6.80917 2.95924 6.87502 3.125 6.87502ZM8.125 5.00002C8.37223 5.00002 8.6139 5.07333 8.81946 5.21068C9.02502 5.34803 9.18524 5.54326 9.27985 5.77167C9.37446 6.00007 9.39921 6.25141 9.35098 6.49388C9.30275 6.73636 9.1837 6.95909 9.00888 7.1339C8.83407 7.30872 8.61134 7.42777 8.36886 7.476C8.12639 7.52423 7.87505 7.49948 7.64665 7.40487C7.41824 7.31026 7.22301 7.15004 7.08566 6.94448C6.94831 6.73892 6.875 6.49725 6.875 6.25002C6.875 5.9185 7.0067 5.60056 7.24112 5.36614C7.47554 5.13172 7.79348 5.00002 8.125 5.00002ZM16.875 13.125H15.5469C15.4092 12.5873 15.0964 12.1106 14.6579 11.7702C14.2194 11.4299 13.6801 11.2451 13.125 11.2451C12.5699 11.2451 12.0306 11.4299 11.5921 11.7702C11.1536 12.1106 10.8408 12.5873 10.7031 13.125H3.125C2.95924 13.125 2.80027 13.1909 2.68306 13.3081C2.56585 13.4253 2.5 13.5843 2.5 13.75C2.5 13.9158 2.56585 14.0748 2.68306 14.192C2.80027 14.3092 2.95924 14.375 3.125 14.375H10.7031C10.8408 14.9128 11.1536 15.3894 11.5921 15.7298C12.0306 16.0702 12.5699 16.2549 13.125 16.2549C13.6801 16.2549 14.2194 16.0702 14.6579 15.7298C15.0964 15.3894 15.4092 14.9128 15.5469 14.375H16.875C17.0408 14.375 17.1997 14.3092 17.3169 14.192C17.4342 14.0748 17.5 13.9158 17.5 13.75C17.5 13.5843 17.4342 13.4253 17.3169 13.3081C17.1997 13.1909 17.0408 13.125 16.875 13.125ZM13.125 15C12.8778 15 12.6361 14.9267 12.4305 14.7894C12.225 14.652 12.0648 14.4568 11.9701 14.2284C11.8755 14 11.8508 13.7486 11.899 13.5062C11.9472 13.2637 12.0663 13.041 12.2411 12.8661C12.4159 12.6913 12.6387 12.5723 12.8811 12.524C13.1236 12.4758 13.3749 12.5006 13.6034 12.5952C13.8318 12.6898 14.027 12.85 14.1643 13.0556C14.3017 13.2611 14.375 13.5028 14.375 13.75C14.375 14.0815 14.2433 14.3995 14.0089 14.6339C13.7745 14.8683 13.4565 15 13.125 15Z"
                                fill="white"></path>
                        </svg>
                        <span class="filter-text">Show Filters</span>
                    </a>
                    <a href="javascript:void(0)" class="btn btn-xxs gray-btn reset-blog-btn" style="display: none;">
                        Reset <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/close-icon.svg"
                            alt="close Image">
                    </a>
                </div>
                <div class="item-count" id="blog-item-count"><?php echo $start_item; ?>–<?php echo $end_item; ?> of
                    <?php echo $total_posts; ?> items
                </div>
            </div>
            <div class="plf-section-right">
                <div class="sort-by-box">
                    <label id="sort_label">Sort by:</label>
                    <select id="sort_by" class="select-drop">
                        <option value="latest">Recommended</option>
                        <option value="latest">Newest First</option>
                        <option value="oldest">Oldest First</option>
                        <option value="title_asc">A → Z</option>
                        <option value="title_desc">Z → A</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="pdf-filter-box blog-filter-box">
            <div class="pdf-filter-list blog-attr">
                <div class="filter-m-title">
                    <span>Filter</span> <a href="javascript:void(0)" class="pdf-filter-close icon-box icon-box-xs"><img
                            src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/close-icon.svg"
                            alt="close icon"></a>
                </div>
                <div class="pdf-filter-accordion-main">
                    <div class="pdf-filter-accordion-box">
                        <div class="pdf-filter-accordion-head">
                            Applications <span class="applications-count">[0]</span> <i><img
                                    src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/accordion-arrow.svg"
                                    alt="Accordion Arrow"></i>
                        </div>
                        <div class="pdf-filter-accordion-body">
                            <div class="pdf-filter-accordion-inner" id="blog-applications-filter">
                                <!-- Applications will be loaded here -->
                            </div>
                        </div>
                    </div>
                    <div class="pdf-filter-accordion-box">
                        <div class="pdf-filter-accordion-head">
                            Categories <span class="categories-count">[0]</span> <i><img
                                    src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/accordion-arrow.svg"
                                    alt="Accordion Arrow"></i>
                        </div>
                        <div class="pdf-filter-accordion-body">
                            <div class="pdf-filter-accordion-inner" id="categories-filter" data-show-all="true">
                                <!-- Categories will be loaded here -->
                            </div>
                        </div>
                    </div>
                    <div class="pdf-filter-accordion-box">
                        <div class="pdf-filter-accordion-head">
                            Tags <span class="tags-count">[0]</span> <i><img
                                    src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/accordion-arrow.svg"
                                    alt="Accordion Arrow"></i>
                        </div>
                        <div class="pdf-filter-accordion-body">
                            <div class="pdf-filter-accordion-inner" id="tags-filter">
                                <!-- Tags will be loaded here -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="reset-btn-mobile-wrapper">
                    <a href="javascript:void(0)" class="btn secondary-btn" id="clear-blog-btn-mobile">
                        Clear filters
                    </a>
                    <a href="javascript:void(0)" class="pdf-filter-close btn primary-btn">Show Results</a>
                </div>
            </div>
            <div id="blog-listing-container">
                <h3>All blog posts</h3>
                <div class="blog-listing-row" id="blog-listing-row">
                    <?php
                    if ($blog_query->have_posts()):
                        while ($blog_query->have_posts()):
                            $blog_query->the_post();
                            ?>
                            <a href="<?php echo get_permalink(); ?>" class="blog-listing-col">
                                <div class="blog-listing-img">
                                    <?php if (has_post_thumbnail(get_the_ID())): ?>
                                        <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>"
                                            alt="<?php echo get_the_title(); ?>">
                                    <?php else: ?>
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/default-image.jpeg"
                                            alt="<?php echo get_the_title(); ?>">
                                    <?php endif; ?>
                                </div>
                                <div class="blog-list-info">
                                    <div class="blog-list-date"><?php echo get_the_date('l, j F Y'); ?></div>
                                    <h6><?php echo get_the_title(); ?></h6>
                                    <hr>
                                    <div class="blog-list-tags">
                                        <?php
                                        $tags = get_the_tags();
                                        if ($tags) {
                                            foreach ($tags as $tag) {
                                                echo '<span>' . esc_html($tag->name) . '</span>';
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </a>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>
        </div>
        <div class="blog-pagination-container" id="blog-pagination-container">
            <!-- Pagination will be loaded here via AJAX -->
        </div>
    </div>
</section>
<!--All blog listing here ends-->