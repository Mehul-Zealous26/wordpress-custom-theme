<?php
$title = get_sub_field('title');
$parent_products = get_sub_field('parent_products');
$products_per_page = 10;
$total_products = count($parent_products);
$total_pages = ceil($total_products / $products_per_page);
$select_spacer = get_sub_field('select_spacer');
$padding_style = get_spacer_padding_style($select_spacer);
?>

<section class="project-section" id="public-products" <?php if ($padding_style)
    echo 'style="' . esc_attr($padding_style) . '"'; ?> id="public_space_products">
    <div class="container-box">
        <div class="sub-title-with-text w-600 text-content-section">
            <?php echo ($title); ?>
        </div>
        <!-- <div class="product-list-filter-section filter-section-border">
        </div> -->
        <!-- <div class="product-list-filter-section">
            <div class="plf-section-left">
                <div class="filter-btn-main">
                    <a href="javascript:void(0)" class="btn btn-sm gray-btn filter-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M3.125 6.87502H5.70312C5.84081 7.41278 6.15356 7.88942 6.59207 8.22979C7.03057 8.57017 7.56989 8.75492 8.125 8.75492C8.68011 8.75492 9.21943 8.57017 9.65793 8.22979C10.0964 7.88942 10.4092 7.41278 10.5469 6.87502H16.875C17.0408 6.87502 17.1997 6.80917 17.3169 6.69196C17.4342 6.57475 17.5 6.41578 17.5 6.25002C17.5 6.08426 17.4342 5.92529 17.3169 5.80808C17.1997 5.69087 17.0408 5.62502 16.875 5.62502H10.5469C10.4092 5.08726 10.0964 4.61062 9.65793 4.27024C9.21943 3.92987 8.68011 3.74512 8.125 3.74512C7.56989 3.74512 7.03057 3.92987 6.59207 4.27024C6.15356 4.61062 5.84081 5.08726 5.70312 5.62502H3.125C2.95924 5.62502 2.80027 5.69087 2.68306 5.80808C2.56585 5.92529 2.5 6.08426 2.5 6.25002C2.5 6.41578 2.56585 6.57475 2.68306 6.69196C2.80027 6.80917 2.95924 6.87502 3.125 6.87502ZM8.125 5.00002C8.37223 5.00002 8.6139 5.07333 8.81946 5.21068C9.02502 5.34803 9.18524 5.54326 9.27985 5.77167C9.37446 6.00007 9.39921 6.25141 9.35098 6.49388C9.30275 6.73636 9.1837 6.95909 9.00888 7.1339C8.83407 7.30872 8.61134 7.42777 8.36886 7.476C8.12639 7.52423 7.87505 7.49948 7.64665 7.40487C7.41824 7.31026 7.22301 7.15004 7.08566 6.94448C6.94831 6.73892 6.875 6.49725 6.875 6.25002C6.875 5.9185 7.0067 5.60056 7.24112 5.36614C7.47554 5.13172 7.79348 5.00002 8.125 5.00002ZM16.875 13.125H15.5469C15.4092 12.5873 15.0964 12.1106 14.6579 11.7702C14.2194 11.4299 13.6801 11.2451 13.125 11.2451C12.5699 11.2451 12.0306 11.4299 11.5921 11.7702C11.1536 12.1106 10.8408 12.5873 10.7031 13.125H3.125C2.95924 13.125 2.80027 13.1909 2.68306 13.3081C2.56585 13.4253 2.5 13.5843 2.5 13.75C2.5 13.9158 2.56585 14.0748 2.68306 14.192C2.80027 14.3092 2.95924 14.375 3.125 14.375H10.7031C10.8408 14.9128 11.1536 15.3894 11.5921 15.7298C12.0306 16.0702 12.5699 16.2549 13.125 16.2549C13.6801 16.2549 14.2194 16.0702 14.6579 15.7298C15.0964 15.3894 15.4092 14.9128 15.5469 14.375H16.875C17.0408 14.375 17.1997 14.3092 17.3169 14.192C17.4342 14.0748 17.5 13.9158 17.5 13.75C17.5 13.5843 17.4342 13.4253 17.3169 13.3081C17.1997 13.1909 17.0408 13.125 16.875 13.125ZM13.125 15C12.8778 15 12.6361 14.9267 12.4305 14.7894C12.225 14.652 12.0648 14.4568 11.9701 14.2284C11.8755 14 11.8508 13.7486 11.899 13.5062C11.9472 13.2637 12.0663 13.041 12.2411 12.8661C12.4159 12.6913 12.6387 12.5723 12.8811 12.524C13.1236 12.4758 13.3749 12.5006 13.6034 12.5952C13.8318 12.6898 14.027 12.85 14.1643 13.0556C14.3017 13.2611 14.375 13.5028 14.375 13.75C14.375 14.0815 14.2433 14.3995 14.0089 14.6339C13.7745 14.8683 13.4565 15 13.125 15Z" fill="white"></path>
                        </svg>
                        <span class="filter-text">Show Filters</span>
                    </a>
                    <a href="javascript:void(0)" class="btn btn-xxs gray-btn reset-btn">
                        Reset <img src="http://barrier-group.local/wp-content/themes/barrier-group/assets/images/close-icon.svg" alt="close Image">
                    </a>
                </div>
                <div class="item-count">
                    1–12 of 235 items
                </div>
            </div>
            <div class="plf-section-right">
                <div class="table-grid-box">
                    <label class="table-grid-container">
                        <input type="radio" checked="checked" name="radio">
                        <span class="table-grid-checkmark">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M17.475 5.16792L10.6 1.4062C10.4163 1.3047 10.2099 1.25146 10 1.25146C9.79013 1.25146 9.58369 1.3047 9.4 1.4062L2.525 5.16948C2.32866 5.27691 2.16477 5.43508 2.05043 5.62747C1.93609 5.81987 1.87551 6.03943 1.875 6.26323V13.7351C1.87551 13.9589 1.93609 14.1785 2.05043 14.3709C2.16477 14.5633 2.32866 14.7214 2.525 14.8289L9.4 18.5921C9.58369 18.6936 9.79013 18.7469 10 18.7469C10.2099 18.7469 10.4163 18.6936 10.6 18.5921L17.475 14.8289C17.6713 14.7214 17.8352 14.5633 17.9496 14.3709C18.0639 14.1785 18.1245 13.9589 18.125 13.7351V6.26401C18.1249 6.03981 18.0645 5.81976 17.9502 5.62692C17.8358 5.43407 17.6717 5.27554 17.475 5.16792ZM10 2.49995L16.2766 5.93745L10 9.37495L3.72344 5.93745L10 2.49995ZM3.125 7.0312L9.375 10.4515V17.1539L3.125 13.7359V7.0312ZM10.625 17.1539V10.4546L16.875 7.0312V13.7328L10.625 17.1539Z" fill="#444748"></path>
                            </svg>
                            <b>Products</b>
                        </span>
                    </label>
                    <label class="table-grid-container">
                        <input type="radio" name="radio">
                        <span class="table-grid-checkmark">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M16.25 2.5H3.75C3.41848 2.5 3.10054 2.6317 2.86612 2.86612C2.6317 3.10054 2.5 3.41848 2.5 3.75V16.25C2.5 16.5815 2.6317 16.8995 2.86612 17.1339C3.10054 17.3683 3.41848 17.5 3.75 17.5H16.25C16.5815 17.5 16.8995 17.3683 17.1339 17.1339C17.3683 16.8995 17.5 16.5815 17.5 16.25V3.75C17.5 3.41848 17.3683 3.10054 17.1339 2.86612C16.8995 2.6317 16.5815 2.5 16.25 2.5ZM3.75 3.75H16.25V9.79531L14.3211 7.86562C14.0867 7.63138 13.7689 7.4998 13.4375 7.4998C13.1061 7.4998 12.7883 7.63138 12.5539 7.86562L4.16953 16.25H3.75V3.75ZM16.25 16.25H5.9375L13.4375 8.75L16.25 11.5625V16.25ZM7.5 9.375C7.87084 9.375 8.23335 9.26503 8.54169 9.05901C8.85004 8.85298 9.09036 8.56014 9.23227 8.21753C9.37419 7.87492 9.41132 7.49792 9.33897 7.13421C9.26663 6.77049 9.08805 6.4364 8.82583 6.17417C8.5636 5.91195 8.22951 5.73337 7.86579 5.66103C7.50208 5.58868 7.12508 5.62581 6.78247 5.76773C6.43986 5.90964 6.14702 6.14996 5.94099 6.45831C5.73497 6.76665 5.625 7.12916 5.625 7.5C5.625 7.99728 5.82254 8.47419 6.17417 8.82583C6.52581 9.17746 7.00272 9.375 7.5 9.375ZM7.5 6.875C7.62361 6.875 7.74445 6.91166 7.84723 6.98033C7.95001 7.04901 8.03012 7.14662 8.07743 7.26082C8.12473 7.37503 8.13711 7.50069 8.11299 7.62193C8.08888 7.74317 8.02935 7.85453 7.94194 7.94194C7.85453 8.02935 7.74317 8.08888 7.62193 8.11299C7.50069 8.13711 7.37503 8.12473 7.26082 8.07743C7.14662 8.03012 7.04901 7.95001 6.98033 7.84723C6.91166 7.74445 6.875 7.62361 6.875 7.5C6.875 7.33424 6.94085 7.17527 7.05806 7.05806C7.17527 6.94085 7.33424 6.875 7.5 6.875Z" fill="#444748"></path>
                            </svg>
                            <b>In - Situ</b>
                        </span>
                    </label>
                </div>
            </div>
        </div> -->
        <!-- <div class="pdf-filter-box"> -->
        <div class="pdf-filter-list">
            <div class="filter-m-title">
                <span>Filter</span> <a href="javascript:void(0)" class="pdf-filter-close icon-box icon-box-xs"><img
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/close-icon.svg"
                        alt="close icon"></a>
            </div>
            <div class="pdf-filter-accordion-main">
                <div class="pdf-filter-accordion-box">
                    <div class="pdf-filter-accordion-head">
                        Category <span>[1]</span> <i><img
                                src="http://barrier-group.local/wp-content/themes/barrier-group/assets/images/accordion-arrow.svg"
                                alt="Accordion Arrow"></i>
                    </div>
                    <div class="pdf-filter-accordion-body">
                        <div class="pdf-filter-accordion-inner">
                            <label class="pdf-filter-check">
                                <input type="checkbox">
                                <span class="pdf-filter-checkmark">Galvanised and Powder Coated</span>
                            </label>
                            <label class="pdf-filter-check">
                                <input type="checkbox">
                                <span class="pdf-filter-checkmark">Galvanised and Powder Coated</span>
                            </label>
                            <label class="pdf-filter-check">
                                <input type="checkbox">
                                <span class="pdf-filter-checkmark">Galvanised and Powder Coated</span>
                            </label>
                            <label class="pdf-filter-check" style="display: none;">
                                <input type="checkbox">
                                <span class="pdf-filter-checkmark">Galvanised and Powder Coated</span>
                            </label>
                            <label class="pdf-filter-check" style="display: none;">
                                <input type="checkbox">
                                <span class="pdf-filter-checkmark">Galvanised and Powder Coated</span>
                            </label>
                            <label class="pdf-filter-check" style="display: none;">
                                <input type="checkbox">
                                <span class="pdf-filter-checkmark">Galvanised and Powder Coated</span>
                            </label>

                            <a href="#" class="show-more-box">Show More</a>
                        </div>
                    </div>

                </div>
                <div class="pdf-filter-accordion-box">
                    <div class="pdf-filter-accordion-head">
                        Colour <span>[1]</span> <i><img
                                src="http://barrier-group.local/wp-content/themes/barrier-group/assets/images/accordion-arrow.svg"
                                alt="Accordion Arrow"></i>
                    </div>
                    <div class="pdf-filter-accordion-body">
                        <div class="pdf-filter-accordion-inner color-select">
                            <label class="pdf-filter-check">
                                <input type="checkbox">
                                <span class="pdf-filter-checkmark"><i style="background:#F5BD55"></i>Galvanised</span>
                            </label>
                            <label class="pdf-filter-check">
                                <input type="checkbox">
                                <span class="pdf-filter-checkmark"><i style="background:#C14651"></i>Galvanised</span>
                            </label>
                            <label class="pdf-filter-check">
                                <input type="checkbox">
                                <span class="pdf-filter-checkmark"><i style="background:#FFE456"></i>Powder Coat Yellow
                                    &amp; Red</span>
                            </label>
                            <label class="pdf-filter-check" style="display: none;">
                                <input type="checkbox">
                                <span class="pdf-filter-checkmark"><i style="background:#F5BD55"></i>Galvanised</span>
                            </label>
                            <label class="pdf-filter-check" style="display: none;">
                                <input type="checkbox">
                                <span class="pdf-filter-checkmark"><i style="background:#F5BD55"></i>Powder Coat Yellow
                                    &amp; Red</span>
                            </label>
                            <label class="pdf-filter-check" style="display: none;">
                                <input type="checkbox">
                                <span class="pdf-filter-checkmark"><i style="background:#F5BD55"></i>Galvanised</span>
                            </label>

                            <a href="#" class="show-more-box">Show More</a>
                        </div>
                    </div>
                </div>
                <div class="pdf-filter-accordion-box">
                    <div class="pdf-filter-accordion-head">
                        Size <span>[1]</span> <i><img
                                src="http://barrier-group.local/wp-content/themes/barrier-group/assets/images/accordion-arrow.svg"
                                alt="Accordion Arrow"></i>
                    </div>
                    <div class="pdf-filter-accordion-body">
                        <div class="pdf-filter-accordion-inner">
                            <label class="pdf-filter-check">
                                <input type="checkbox">
                                <span class="pdf-filter-checkmark">160 cm x 200 cm</span>
                            </label>
                            <label class="pdf-filter-check">
                                <input type="checkbox">
                                <span class="pdf-filter-checkmark">160 cm x 200 cm</span>
                            </label>
                            <label class="pdf-filter-check">
                                <input type="checkbox">
                                <span class="pdf-filter-checkmark">160 cm x 200 cm</span>
                            </label>
                            <label class="pdf-filter-check" style="display: none;">
                                <input type="checkbox">
                                <span class="pdf-filter-checkmark">160 cm x 200 cm</span>
                            </label>
                            <label class="pdf-filter-check" style="display: none;">
                                <input type="checkbox">
                                <span class="pdf-filter-checkmark">160 cm x 200 cm</span>
                            </label>
                            <label class="pdf-filter-check" style="display: none;">
                                <input type="checkbox">
                                <span class="pdf-filter-checkmark">160 cm x 200 cm</span>
                            </label>

                            <a href="#" class="show-more-box">Show More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="prodct-cat-list product-list-box" id="category_products_list">
            <?php if ($parent_products): ?>
                <?php foreach ($parent_products as $index => $product): ?>
                    <?php $page_number = floor($index / $products_per_page) + 1; ?>
                    <?php
                    $product_id = $product->ID;
                    $product_title = get_the_title($product_id);
                    $product_url = get_permalink($product_id);
                    $product_excerpt = get_the_excerpt($product_id);
                    $wc_product = wc_get_product($product_id);
                    $featured_image = wp_get_attachment_image_url($wc_product->get_image_id(), 'full');
                    if (!$featured_image) {
                        $featured_image = get_template_directory_uri() . '/assets/images/default-image.jpeg';
                    }

                    // Get hover image with fallback priority: gallery > feature > default
                    $hover_image = '';
                    $gallery_ids = $wc_product->get_gallery_image_ids();

                    if (!empty($gallery_ids)) {
                        // Use first gallery image
                        $hover_image = wp_get_attachment_image_url($gallery_ids[0], 'full');
                    } else {
                        // No gallery - use feature image
                        $feature_image = wp_get_attachment_image_url($wc_product->get_image_id(), 'full');
                        if ($feature_image) {
                            $hover_image = $feature_image;
                        } else {
                            // No feature image - use default
                            $hover_image = get_template_directory_uri() . '/assets/images/default-image.jpeg';
                        }
                    }

                    $is_new = get_field('is_new_product', $product_id);
                    // $models_count = get_field('models_count', $product_id) ?: 0;
                    // $accessories_count = get_field('accessories_count', $product_id) ?: 0;
                    $models_count = $wc_product->is_type('woosg') ? count(get_post_meta($product_id, 'woosg_ids', true) ?: []) : count($wc_product->get_children());
                    $accessories_count = 0;
                    if (have_rows('page_sections', $product_id)) {
                        while (have_rows('page_sections', $product_id)) {
                            the_row();
                            if (get_row_layout() == 'related_accessories_section') {
                                $accessories_product = get_sub_field('accessories_product_1');
                                if ($accessories_product) {
                                    $accessories_count += is_array($accessories_product) ? count($accessories_product) : 1;
                                }
                            }
                        }
                    }
                    $default_image = get_template_directory_uri() . '/assets/images/default-image.jpeg';
                    ?>
                    <div class="product-box" data-page="<?php echo $page_number; ?>"
                        style="<?php echo $page_number > 1 ? 'display: none;' : ''; ?>">
                        <a href="<?php echo esc_url($product_url); ?>">
                            <div class="product-rang-img product-box-img js-square-ready" style="height: 313px;">
                                <?php if ($is_new): ?>
                                    <div class="product-tag new-tag">New</div>
                                    <?php
                                endif; ?>
                                <img class="product-d-img" src="<?php echo esc_url($featured_image); ?>"
                                    alt="<?php echo esc_attr($product_title); ?>">
                                <?php if ($hover_image): ?>
                                    <img class="product-hover-img" src="<?php echo esc_url($hover_image); ?>"
                                        alt="<?php echo esc_attr($product_title); ?>">
                                    <?php
                                endif; ?>
                            </div>
                            <div class="Product-box-desc">
                                <h5>
                                    <div class="product-custom-title"><?php echo esc_html($product_title); ?></div>
                                </h5>
                                <hr>
                                <p class="product-excerpt">
                                    <?php echo esc_html(!empty(trim($product_excerpt)) ? $product_excerpt : 'No Content Available'); ?>
                                </p>
                                <hr>
                                <div class="product-box-available">
                                    <label>available</label>
                                    <div class="available-tags">
                                        <span><?php echo esc_html($models_count); ?> Models</span>
                                        <span><?php echo esc_html($accessories_count); ?> Accessories</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php
                endforeach; ?>
                <?php
            endif; ?>
            <div id="product_pagination" class="product-pagination"></div>
        </div>
    </div>
    </div>
    <?php if ($total_pages > 1): ?>
        <div class="pagi-main">
            <div class="pagi-row" id="public-space-pagination">
                <span class="prev disabled" id="public-prev-btn"><img
                        src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow-left.svg"
                        alt="pagi Arrow"></span>
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <span class="<?php echo $i === 1 ? 'current' : ''; ?>"
                        data-page="<?php echo $i; ?>"><?php echo $i; ?></span>
                    <?php
                endfor; ?>
                <span class="next <?php echo $total_pages === 1 ? 'disabled' : ''; ?>" id="public-next-btn"><img
                        src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow-right.svg"
                        alt="pagi Arrow"></span>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const totalPages = <?php echo $total_pages; ?>;
                let currentPage = 1;

                function showPage(page) {
                    document.querySelectorAll('.product-box[data-page]').forEach(box => {
                        box.style.display = box.getAttribute('data-page') == page ? 'block' : 'none';
                    });

                    document.querySelectorAll('#public-space-pagination span[data-page]').forEach(btn => {
                        btn.classList.remove('current');
                    });
                    document.querySelector(`#public-space-pagination span[data-page="${page}"]`).classList.add('current');

                    document.getElementById('public-prev-btn').classList.toggle('disabled', page === 1);
                    document.getElementById('public-next-btn').classList.toggle('disabled', page === totalPages);

                    // Scroll to title
                    document.getElementById('public-products').scrollIntoView({
                        behavior: 'smooth'
                    });

                    currentPage = page;
                }

                document.querySelectorAll('#public-space-pagination span[data-page]').forEach(btn => {
                    btn.addEventListener('click', function () {
                        showPage(parseInt(this.getAttribute('data-page')));
                    });
                });

                document.getElementById('public-prev-btn').addEventListener('click', function () {
                    if (currentPage > 1) showPage(currentPage - 1);
                });

                document.getElementById('public-next-btn').addEventListener('click', function () {
                    if (currentPage < totalPages) showPage(currentPage + 1);
                });
            });
        </script>
        <?php
    endif; ?>
</section>