<?php
/**
 * @package     Neno
 *
 * @author      Jensen Technologies S.L. <info@notwebdesign.com>
 * @copyright   Copyright (C) 2014 Jensen Technologies S.L. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

$document = JFactory::getDocument();
$tables   = $displayData['tables'];
$files    = $displayData['files'];

$isOverlay      = isset($displayData->isOverlay);
$elements       = $displayData['state']->get('filter.element', array ());
$filesSelected  = $displayData['state']->get('filter.files', array ());
$fieldsSelected = $displayData['state']->get('filter.field', array ());
$tablesSelected = array ();

foreach ($fieldsSelected as $fieldSelected)
{
	foreach ($tables as $table)
	{
		foreach ($table->fields as $field)
		{
			if ($fieldSelected == $field->id)
			{
				if (!in_array($table->id, $tablesSelected))
				{
					$tablesSelected[] = $table->id;
					break 2;
				}
			}
		}
	}
}
?>
<?php foreach ($tables as $table): ?>
	<?php
		$classTR = 'collapsed';
		if (in_array($table->id, $tablesSelected)) {
			$classTR = 'expanded';
		} else {
			foreach ($table->fields as $field) {
				if (in_array($field->id, $fieldsSelected)) {
					$classTR = 'expanded';
					break;
				}
			}
		}
		$classTD = !empty($table->fields) ? 'cell-expand' : '';
	?>
	<tr class="row-table element-row <?php echo $classTR; ?>"
	    data-level="2"
	    data-id="table-<?php echo $table->id; ?>"
	    data-parent="group-<?php echo $table->group->id; ?>"
	    data-label="<?php echo $table->table_name; ?>">
		<td></td>
		<td class="<?php echo $classTD; ?>">
			<?php if (!empty($table->fields)): ?>
				<?php if ($classTR == 'collapsed'): ?>
					<span class="icon-arrow-right-3"></span>
				<?php else: ?>
					<span class="icon-arrow-down-3"></span>
				<?php endif; ?>
			<?php endif; ?>
		</td>
		<td class="cell-check"><input
				type="checkbox"
				id="input-table-<?php echo $table->id; ?>"
				<?php echo in_array($table->id, $elements) ? 'checked="checked"' : ''; ?>/>
		</td>
		<td colspan="3"
		    title="<?php echo $table->table_name; ?>">
			<label for="input-table-<?php echo $table->id; ?>">
				<?php echo $table->table_name; ?>
			</label>
		</td>
	</tr>
	<?php foreach ($table->fields as $field): ?>
		<tr class="row-field element-row <?php echo $classTR == 'collapsed'?'hide':'' ?>" data-level="3" data-id="field-<?php echo $field->id; ?>"
		    data-parent="table-<?php echo $table->id; ?>"
		    data-label="<?php echo $field->field_name; ?>">
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td class="cell-check">
				<input id="input-field-<?php echo $field->id; ?>"
				       type="checkbox" <?php echo in_array($field->id, $fieldsSelected) ? 'checked="checked"' : ''; ?>/>
			</td>
			<td title="<?php echo $field->field_name; ?>">
				<label for="input-field-<?php echo $field->id; ?>">
					<?php echo $field->field_name; ?>
				</label>
			</td>
		</tr>
	<?php endforeach; ?>
<?php endforeach; ?>
<?php foreach ($files as $file): ?>
	<tr class="row-table element-row collapsed" data-level="2"
	    data-id="file-<?php echo $file->id; ?>"
	    data-parent="group-<?php echo $file->group->id; ?>"
	    data-label="<?php echo $file->filename; ?>">
		<td></td>
		<td></td>
		<td class="cell-check"><input
				type="checkbox" <?php echo in_array($file->id, $filesSelected) ? 'checked="checked"' : ''; ?>/>
		</td>
		<td colspan="3"
		    title="<?php echo $file->filename; ?>"><?php echo $file->filename; ?></td>
	</tr>
<?php endforeach; ?>