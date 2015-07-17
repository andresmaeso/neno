<?php
/**
 * @package    Neno
 *
 * @author     Jensen Technologies S.L. <info@notwebdesign.com>
 * @copyright  Copyright (C) 2014 Jensen Technologies S.L. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

?>

<style>
	#versionbox {
		bottom: 3.1%;
		position: fixed;
		z-index: 9999;
		left: 0;
		width: 16.5%;
		border-top: 1px solid #e3e3e3;
		border-bottom: none;
		border-radius: 0 4px 0 0;
		padding-top: 15px;
		font-size: 14px;
	}

	.icon-warning, .icon-checkmark {
		margin-left: 23px;
		margin-top: 7px;
	}

	#versionbox .update-inner {
		font-size: 13px;
		margin-left: 44px;
	}
</style>

<div class="j-sidebar-container" id="versionbox">
	<div<?php echo !empty($displayData->newVersion) ? ' class="text-error"' : ''; ?>>
		<i class="icon-<?php echo !empty($displayData->newVersion) ? 'warning' : 'checkmark'; ?> <?php echo !empty($displayData->newVersion) ? '' : 'text-success'; ?>"></i>
		<?php echo JText::_('COM_NENO_VERSION_BOX_NENO_VERSION'); ?>
		<strong><?php echo !empty($displayData->newVersion) ? $displayData->newVersion : $displayData->currentVersion; ?></strong>
		<?php echo !empty($displayData->newVersion) ? JText::_('COM_NENO_VERSION_BOX_NEW_VERSION_IS_AVAILABLE') : ''; ?>
	</div>

	<?php if (!empty($displayData->newVersion)): ?>
		<div class="update-inner">
			<p><?php echo JText::_('COM_NENO_VERSION_BOX_UPDATE_P'); ?>
				<strong><?php echo $displayData->currentVersion; ?></strong></p>
			<a href="index.php?option=com_installer&view=update"><?php echo JText::_('COM_NENO_VERSION_BOX_UPDATE_LINK_TEXT'); ?>
			</a>
		</div>
	<?php endif; ?>
</div>
