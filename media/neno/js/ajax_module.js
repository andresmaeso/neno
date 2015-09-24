jQuery(document).ready(function () {
	setTimeout(function () {
		jQuery.ajax({
			url: 'index.php?option=com_neno&task=processTaskQueue'
		});
	}, 10000)

});