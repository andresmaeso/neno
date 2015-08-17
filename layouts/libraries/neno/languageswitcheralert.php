<?php
/**
 * @package     Neno
 * @subpackage  Helpers
 *
 * @author      Jensen Technologies S.L. <info@notwebdesign.com>
 * @copyright   Copyright (C) 2014 Jensen Technologies S.L. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

// Include the CSS file
JHtml::stylesheet('media/neno/css/admin.css');
?>
<div class="alert">
    <form action="index.php?option=com_neno&task=dashboard.publishSwitcher" method="POST">
        <h3><?php echo JText::_('COM_NENO_DASHBOARD_LANGUAGE_SWITCHER_NOT_PUBLISHED_H3'); ?></h3>

        <p><?php echo JText::_('COM_NENO_DASHBOARD_LANGUAGE_SWITCHER_NOT_PUBLISHED_P1'); ?></p>

        <p><?php echo JText::sprintf('COM_NENO_DASHBOARD_LANGUAGE_SWITCHER_NOT_PUBLISHED_P2', $displayData); ?></p>
        <button class="btn btn-success" type="button" id="publish-module">
            <?php echo JText::_('COM_NENO_DASHBOARD_LANGUAGE_SWITCHER_NOT_PUBLISHED_PUBLISH_BUTTON'); ?>
        </button>
        <a href="index.php?option=com_neno&task=dashboard.doNotShowWarningMessage" class="btn">
            <?php echo JText::_('COM_NENO_DASHBOARD_LANGUAGE_SWITCHER_NOT_PUBLISHED_DO_NOT_REMIND_ME_BUTTON'); ?>
        </a>
    </form>
</div>