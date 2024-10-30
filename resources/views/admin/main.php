<?php
/** @var string $pluginName */

if (!current_user_can('manage_options')) {
    return;
}

if (isset($_GET['settings-updated'])) {
    add_settings_error(
        $pluginName . '_messages',
        $pluginName . '_message',
        __('Settings Saved', $pluginName),
        'updated'
    );
}

settings_errors($pluginName . '_messages');
?>

<div class="wrap limousinesearch">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <form action="options.php" method="post">
        <?php
            settings_fields($pluginName);
            do_settings_sections($pluginName);
            submit_button( 'Save' );
        ?>
    </form>

    <h2 class="title"><?php _e('About Company', $pluginName) ?></h2>
    <?php
        $company = get_option($pluginName . '_company');
    ?>
    <?php
        if ($company instanceof \LimousineSearch\Entities\Company) {
    ?>
        <p><?php _e('Id', $pluginName) ?>: <?php echo $company->getId(); ?></p>
        <p><?php _e('Name', $pluginName) ?>: <?php echo $company->getName(); ?></p>
        <p><?php _e('Slug', $pluginName) ?>: <?php echo $company->getSlug(); ?></p>
        <p><?php _e('Timezone', $pluginName) ?>: <?php echo $company->getTimezone(); ?></p>
        <p><?php _e('Updated AT', $pluginName) ?>: <?php echo get_option($pluginName . '_company_updated_at'); ?></p>

        <?php
            if (!$company->isMapsApiKeySet()) {
                ?>
                <div class="notification fail">
                    <p><strong><?php _e('Missing Maps Api Key in Limousine Search', $pluginName) ?></strong></p>
                </div>
                <?php
            } elseif (!$company->isActivated()) {
        ?>
                <div class="notification fail">
                    <p><strong><?php _e('This company is NOT active in Limousine Search', $pluginName) ?></strong></p>
                </div>
        <?php
            }
        ?>

        <?php
            if ($company->isActivated()) {
                ?>
                <div class="notification success">
                    <p><strong><?php _e('Everything is set', $pluginName) ?></strong></p>
                </div>
                <?php
            }
        ?>
    <?php
        } else {
    ?>
        <div class="notification fail">
            <p><strong><?php echo __('No valid Api Token set!', $pluginName) ?></strong></p>
        </div>
    <?php
        }
    ?>
</div>
