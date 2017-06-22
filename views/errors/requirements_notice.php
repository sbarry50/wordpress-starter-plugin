<?php
namespace Vendor_Name\Plugin_Name;
?>

<div class="error">
    <p>
        <strong>Your current system environment does not meet the minimum requirements to run <?php echo PLUGIN_NAME ?>:</strong></br>
        <table style="text-align: center;">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>WordPress</th>
                    <th>PHP</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th style="text-align: left;">Minimum</th>
                    <td><?php echo PLUGIN_MIN_WP_VERSION; ?></td>
                    <td><?php echo PLUGIN_MIN_PHP_VERSION; ?></td>
                </tr>
                <tr>
                    <th style="text-align: left;">Current</th>
                    <td><?php echo WP_VERSION; ?></td>
                    <td><?php echo PHP_MAJOR_VERSION . '.' . PHP_MINOR_VERSION . '.' . PHP_RELEASE_VERSION; ?></td>
                </tr>
            </tbody>
        </table>
    </p>
    <p>
        <strong><?php echo PLUGIN_NAME ?> has been deactivated.</strong>
    </p>
    <p>
        <strong>Please update your environment to activate <?php echo PLUGIN_NAME ?>.</strong>
    </p>
</div>
