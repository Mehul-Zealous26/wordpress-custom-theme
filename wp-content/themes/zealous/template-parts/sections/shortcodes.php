<?php
$all_shortcodes = get_sub_field('all_shortcodes');
if($all_shortcodes) {
        echo do_shortcode($all_shortcodes);
}
?>