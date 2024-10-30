<?php
    /** @var string $pluginName */
    /** @var string $name */
    /** @var string $description */

    $option = $pluginName . '_settings';
    $options = get_option($option);
    $value = !is_array($options) ? '' : ($options[$name] ?? '');
?>
<input
    type="text"
    name="<?php echo $option; ?>[<?php echo $name; ?>]"
    value="<?php echo $value; ?>"
    class="regular-text"
/>
<?php
    if (isset($description)) {
?>
    <p class="description">
        <?php echo $description; ?>
    </p>
<?php
    }
?>
