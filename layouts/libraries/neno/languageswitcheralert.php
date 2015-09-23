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
$version = NenoHelperBackend::getNenoVersion();
JHtml::stylesheet('media/neno/css/admin.css?v=' . $version);
?>
<script type="text/javascript">

	jQuery(document).ready(bindEvents);

	function bindEvents() {
		//Bind the loader into the new selector
		loadMissingTranslationMethodSelectors();
		jQuery('#publish-module').off('click').on('click', function () {
			jQuery('#adminForm').attr('action', 'index.php?option=com_neno');
			jQuery("input[name='task']").val('dashboard.publishSwitcher');
			jQuery('#adminForm').submit();
		});
	}

</script>
<div class="alert">
	<form action="index.php?option=com_neno&task=dashboard.publishSwitcher&placement=module" method="POST" name="adminForm"
		id="adminForm">
		<h3><?php echo JText::_('COM_NENO_DASHBOARD_LANGUAGE_SWITCHER_NOT_PUBLISHED_H3'); ?></h3>

		<p><?php echo JText::_('COM_NENO_DASHBOARD_LANGUAGE_SWITCHER_NOT_PUBLISHED_P1'); ?></p>

		<p><?php echo JText::sprintf('COM_NENO_DASHBOARD_LANGUAGE_SWITCHER_NOT_PUBLISHED_P2', $displayData); ?></p>
		<button class="btn btn-success" type="button" id="publish-module">
			<?php echo JText::_('COM_NENO_DASHBOARD_LANGUAGE_SWITCHER_NOT_PUBLISHED_PUBLISH_BUTTON'); ?>
		</button>
		<a href="index.php?option=com_neno&task=dashboard.doNotShowWarningMessage&placement=module" class="btn">
			<?php echo JText::_('COM_NENO_DASHBOARD_LANGUAGE_SWITCHER_NOT_PUBLISHED_DO_NOT_REMIND_ME_BUTTON'); ?>
		</a>
	</form>
</div>