<?php
/**
 * @package    Neno
 *
 * @author     Jensen Technologies S.L. <info@notwebdesign.com>
 * @copyright  Copyright (C) 2014 Jensen Technologies S.L. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

//No direct access
defined('_JEXEC') or die;

JHtml::_('bootstrap.tooltip');

?>
<style>
	#task-messages {
		height           : 200px;
		background-color : #f5f5f5;
		padding          : 20px;
		color            : #808080;
		overflow         : auto;
	}

	.log-level-2 {
		margin-left : 20px;
		font-weight : bold;
		margin-top  : 16px;
	}

	.log-level-3 {
		margin-left : 40px;
	}

	#proceed-button {
		margin-top : 15px;
	}
</style>

<div class="installation-step">
	<div class="installation-body span12">
		<div class="error-messages"></div>
		<h1><?php echo JText::_('Database Tables'); ?></h1>

		<p><?php echo JText::_('Please select the database tables that contain content that you need translated. After installation you can configure this in more detail including which fields from each table should be translated'); ?></p>
		<table class="table">
			<?php foreach ($displayData->groups as $group): ?>
				<tr>
					<td colspan="5"><h3><?php echo $group->group_name; ?></h3></td>
				</tr>
				<?php foreach ($group->tables as $table): ?>
					<tr>
						<td><h6><?php echo $table->table_name; ?></h6></td>
						<td>
							<button class="btn btn-mini preview-btn" type="button"
								data-table-id="<?php echo $table->id; ?>">
								<i class="icon-eye"></i>
							</button>
						</td>
						<td><?php echo $table->record_count; ?> rows</td>
						<td colspan="2">
							<div class="pull-right">
								<?php echo JLayoutHelper::render('translatewidget', $table, JPATH_NENO_LAYOUTS); ?>
							</div>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php endforeach; ?>
		</table>
	</div>

	<?php echo JLayoutHelper::render('installationbottom', 4, JPATH_NENO_LAYOUTS); ?>
</div>

<div class="modal hide fade" id="preview-modal">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3>Content Preview</h3>
	</div>
	<div class="modal-body"></div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Close</a>
	</div>
</div>

<script>
	jQuery('#proceed-button').off('click').on('click', function () {
		if (jQuery('#backup-created-checkbox').prop('checked')) {
			jQuery('#warning-message').slideToggle(400, function () {
				jQuery('#installation-wrapper').slideToggle();
			});

			interval = setInterval(checkStatus, 2000);

			Notification.requestPermission(function (perm) {
				if (perm == 'granted') {
					notifications = true;
				}
			});
		}

		jQuery.installation = false;

		sendDiscoveringStep();
	});

	jQuery('#backup-created-checkbox').off('click').on('click', function () {
		jQuery('#proceed-button').attr('disabled', !jQuery(this).prop('checked'));
	});

	jQuery('.preview-btn').off('click').on('click', previewContent);

	function previewContent() {
		var button = jQuery(this);
		jQuery.post(
			'index.php?option=com_neno&task=installation.previewContentFromTable&r=' + Math.random(),
			{
				tableId: button.data('table-id')
			},
			function (html) {
				var modal = jQuery('#preview-modal');
				modal.find('.modal-body').empty().append(html);
				modal.modal('show');
			}
		)
	}

</script>

<div class="hidden">
	<!-- Different HTML to show depending on log level -->
	<div id="installation-status-1" class="alert"></div>
	<div id="installation-status-2" class="log-level-2"></div>
	<div id="installation-status-3" class="log-level-3"></div>
</div>
