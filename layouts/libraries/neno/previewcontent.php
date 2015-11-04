<style>
	.preview-box {
		overflow-y: scroll;
		height: 250px;
		border: 2px solid #ccc;
		padding: 5px;
	}
</style>

<h1>Preview Content</h1>
<h6>Below is some random content from the table: <?php echo $displayData->tableName; ?></h6>
<div class="preview-box">
	<?php foreach ($displayData->fields as $field): ?>
		<?php if (!empty($displayData->records[0]->{$field->field_name})): ?>
			<h5>Field <?php echo $field->field_name; ?> (<?php echo $field->field_type; ?>)</h5>
			<ul>
				<?php foreach ($displayData->records as $record): ?>
					<li><?php echo htmlentities($record->{$field->field_name}); ?></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	<?php endforeach; ?>
</div>
