<?php
namespace Vendor\Plugin;

use Vendor\Plugin\Constants as Constants;
?>

<div class="error">
    <p>
        <strong>Your current system environment does not meet the minimum requirements to run <?php echo Constants\PLUGIN_NAME ?>:</strong></br>
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
                    <td><?php echo $this->compatibility->minWPVersion(); ?></td>
                    <td><?php echo $this->compatibility->currentWPVersion(); ?></td>
                    <td><?php $this->compatibility->renderDashicon( $this->compatibility->currentWPVersion(), $this->compatibility->minWPVersion() ); ?></td>
                </tr>
                <tr>
                    <th style="text-align: left;">PHP</th>
                    <td><?php echo $this->compatibility->minPHPVersion(); ?></td>
                    <td><?php echo PHP_MAJOR_VERSION . '.' . PHP_MINOR_VERSION . '.' . PHP_RELEASE_VERSION; ?></td>
                    <td><?php $this->compatibility->renderDashicon( $this->compatibility->currentPHPVersion(), $this->compatibility->minPHPVersion() ); ?></td>
                </tr>
            </tbody>
        </table>
    </p>
    <p>
        <strong><?php echo Constants\PLUGIN_NAME ?> has been deactivated.</strong>
    </p>
    <p>
        <strong>Please update your environment to activate <?php echo Constants\PLUGIN_NAME ?>.</strong>
    </p>
</div>
