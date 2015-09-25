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

$step = $displayData;

?>

<table class="table">
	<tr>
		<th>Field</th>
		<th>Comparaison Operator</th>
		<th>Value</th>
		<th></th>
	</tr>
	<tr>
		<td><?php echo $displayData->fieldsSelect; ?></td>
		<td><?php echo $displayData->operatorsSelect; ?></td>
		<td><input type="text" name="" value="" /></td>
		<td>
			<button type="button" class="btn btn-primary btn-small"><i class="icon-plus"></i></button>
		</td>
	</tr>
</table>