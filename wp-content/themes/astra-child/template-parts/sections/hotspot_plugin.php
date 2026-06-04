<?php
// Robust unique ID generation to prevent duplicate ID conflicts on the same page
static $hotspot_plugin_instance = 0;
$hotspot_plugin_instance++;
$hotspot_plugin_unique_id = 'hotspot-plugin-' . $hotspot_plugin_instance . '-' . rand(100, 999);
?>
<section class="product-f-video sport-md ligth-bg"> <!-- sport-lg -->
    <div class="container-box">
        <div class="product-f-video-left sub-title-with-text">
            <div>
                <div class="sub-heading">
                    Industries & Solutions
                </div>
                <h4>Fantastic new warehouse<br />solutions for your business</h4>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum.</p>
                <div class="sport-number-text">
                    <div class="sport-number-box">
                        <h6><span>01</span>Bollard</h6>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique. <a href="#">Learn More</a></p>
                    </div>
                    <div class="sport-number-box">
                        <h6><span>02</span>Road Railing</h6>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique. Learn More</p>
                    </div>
                    <div class="sport-number-box">
                        <h6><span>3</span>Truck Wheels</h6>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique. Learn More</p>
                    </div>
                    <div class="sport-number-box">
                        <h6><span>4</span>Lamp Post</h6>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique. Learn More</p>
                    </div>
                    <div class="sport-number-box">
                        <h6><span>4</span>Air-conditioner Unit</h6>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique. Learn More</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-f-video-right hotspot-img-box">

            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/img-89.png" alt="Product Image">
            <div class="sport-number-count">
                <div class="sport-number-count-box" style="left: 20px; top:50px">1</div>
                <div class="sport-number-count-box" style="left: 280px; top:150px">2</div>
                <div class="sport-number-count-box" style="right: 20px; left:auto; top:350px">3</div>
                <div class="sport-number-count-box" style="left: 390px; top:420px">4</div>
                <div class="sport-number-count-box" style="left: 40px; top:280px">5</div>
            </div>
        </div>
    </div>
</section>

<section class="product-f-video">
    <div class="container-box">
        <div class="product-f-video-left sub-title-with-text">
            <div class="sub-heading">
                Video
            </div>
            <h3>Medium length heading goes here</h3>
            <div>
                <p>Placeholder Text Example Here ie: Transform your company with a digital first approach with Melbourne’s best award winning digital agency servicing clients Australia-wide.</p>
            </div>
            <ul>
                <li>Full suite of digital marketing services.</li>
                <li>The best digital transformations to power your company. The best digital transformations to power your company.</li>
                <li>eCommerce, website design and development.</li>
            </ul>
            <div class="button-box">
                <a href="#" class="btn secondary-btn">View Now</a>
                <a href="#" class="btn primary-btn">View Now</a>
            </div>
        </div>
        <div class="product-f-video-right hotspot-img-box">
            <img src="http://barrier-group.local/wp-content/themes/barrier-group/assets/images/full-img.png" alt="Img">
            <div class="hotspot-dot" style="left: 50px; top:50px;">
                <div class="hotspot-dot-box"></div>
            </div>
        </div>
    </div>
</section>

<section class="hotspot-sider hotspot-sider-1" id="<?php echo esc_attr($hotspot_plugin_unique_id); ?>">
    <div class="hotspot-sider-box swiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/new-img.jpg" alt="Product Image">
            </div>
            <div class="swiper-slide">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/new-img.jpg" alt="Product Image">
            </div>
            <div class="swiper-slide">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/new-img.jpg" alt="Product Image">
            </div>
            <div class="swiper-slide">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/new-img.jpg" alt="Product Image">
            </div>
        </div>
        <div class="slider-bottom-cont hotspot-slider">
            <div class="swiper-pagination plugin-swiper-pagination-<?php echo esc_attr($hotspot_plugin_unique_id); ?>"></div>
            <div class="sider-arrow-box">
                <div class="swiper-button-prev plugin-slider-prev-<?php echo esc_attr($hotspot_plugin_unique_id); ?> slider-arrow"></div>
                <div class="swiper-button-next plugin-slider-next-<?php echo esc_attr($hotspot_plugin_unique_id); ?> slider-arrow"></div>
            </div>
        </div>
    </div>
</section>

<script>
    (function () {
        var sliderId = '<?php echo esc_js($hotspot_plugin_unique_id); ?>';

        function initHotspotPluginSwiper() {
            var section = document.getElementById(sliderId);
            if (!section) return;

            var swiperEl = section.querySelector('.hotspot-sider-box');
            if (!swiperEl) return;
            if (swiperEl.classList.contains('swiper-initialized')) return;

            var nextEl = section.querySelector('.plugin-slider-next-' + sliderId);
            var prevEl = section.querySelector('.plugin-slider-prev-' + sliderId);
            var paginationEl = section.querySelector('.plugin-swiper-pagination-' + sliderId);

            new Swiper(swiperEl, {
                slidesPerView: 1,
                centeredSlides: false,
                grabCursor: true,
                loop: false,
                spaceBetween: 0,

                navigation: {
                    nextEl: nextEl,
                    prevEl: prevEl,
                },

                pagination: {
                    el: paginationEl,
                    clickable: true,
                },

                breakpoints: {
                    768: {
                        slidesPerView: 1.5,
                        spaceBetween: 0,
                    }
                },

                speed: 800
            });
        }

        if (typeof Swiper !== 'undefined') {
            initHotspotPluginSwiper();
        } else {
            window.addEventListener('load', initHotspotPluginSwiper);
        }
    })();
</script>