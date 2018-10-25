<div class="wrap">
    <h1>Starter Plugin Options</h1>
    <?php settings_errors(); ?>

    <form method="POST" action="options.php">
        <?php settings_fields('starter-plugin'); ?>
        <?php do_settings_sections('starter-plugin'); ?>
        <?php submit_button(); ?>
    </form>
</div>
