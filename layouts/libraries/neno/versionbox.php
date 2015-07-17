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

	#versionbox .update-inner {
		font-size: 11px;
		margin-left: 44px;
	}
</style>

<div class="j-sidebar-container" id="versionbox">
	<i class="icon-checkmark text-success"></i> Neno version
	<strong><?php echo !empty($displayData->newVersion) ? $displayData->newVersion : $displayData->currentVersion; ?></strong>

	<?php if (!empty($displayData->newVersion)): ?>
		<div class="update-inner">
			<p>Currently installed Neno version: <?php echo $displayData->currentVersion; ?></p>
			<a href="index.php?option=com_installer&view=update">Please update</a>
		</div>
	<?php endif; ?>
</div>
