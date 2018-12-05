<div class="error">
    <p>
        <strong>Your current system environment does not meet the minimum requirements to run <?php echo $args->plugin_name ?>:</strong></br>
        <table style="text-align: center;">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>Minimum</th>
                    <th>Current</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th style="text-align: left;">Wordpress</th>
                    <td><?php echo $args->min_wp_version; ?></td>
                    <td><?php echo $args->wp_version; ?></td>
                    <td><?php $args->renderDashicon($args->wp_version, $args->min_wp_version); ?></td>
                </tr>
                <tr>
                    <th style="text-align: left;">PHP</th>
                    <td><?php echo $args->min_php_version; ?></td>
                    <td><?php echo PHP_MAJOR_VERSION . '.' . PHP_MINOR_VERSION . '.' . PHP_RELEASE_VERSION; ?></td>
                    <td><?php $args->renderDashicon($args->php_version, $args->min_php_version); ?></td>
                </tr>
            </tbody>
        </table>
    </p>
    <p>
        <strong><?php echo $args->plugin_name ?> has been deactivated.</strong>
    </p>
    <p>
        <strong>Please update your environment to activate <?php echo $args->plugin_name ?>.</strong>
    </p>
</div>
