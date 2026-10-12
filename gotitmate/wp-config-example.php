<?php
// Add these lines to the real wp-config.php. Do not put real secrets inside the theme.
define('GIM_ENVIRONMENT', 'development'); // change to 'production' only after staging passes
define('GIM_STRIPE_SECRET_KEY', 'sk_test_REPLACE_ME');
define('GIM_STRIPE_PUBLISHABLE_KEY', 'pk_test_REPLACE_ME');
define('GIM_STRIPE_WEBHOOK_SECRET', 'whsec_REPLACE_ME');
define('GIM_COMMISSION_BPS', 1000); // 10% of service/labour only
define('GIM_PRIVATE_FILE_ROOT', WP_CONTENT_DIR . '/gim-private');
// Optional JSON benchmark file for material-price comparison:
// define('GIM_UK_MATERIAL_BENCHMARK_FILE', '/absolute/private/path/uk-material-benchmarks.json');
