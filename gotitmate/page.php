<?php
if (!defined('ABSPATH')) exit;
get_header();
while (have_posts()) { the_post(); echo '<main class="gim-shell">'; the_content(); echo '</main>'; }
get_footer();
