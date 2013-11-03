<div id="TagsTableContainer" style="width: 600px;"></div>
	<script type="text/javascript">

		$(document).ready(function () {

		    //Prepare jTable
			$('#TagsTableContainer').jtable({
				title: 'Tags',
				actions: {
					listAction: 'includes/tagsActions.php?action=list',
					createAction: 'includes/tagsActions.php?action=create',
					updateAction: 'includes/tagsActions.php?action=update',
					deleteAction: 'includes/tagsActions.php?action=delete'
				},
				fields: {
					id: {
						key: true,
						create: false,
						edit: false,
						list: false
					},
					tagname: {
						title: 'Tag Name',
						width: '40%'
					},
					tagslug: {
						title: 'Slug',
						width: '30%'
					},
					inmenu: {
						title: 'In Menu',
						width: '10%'
					},
					menuorder: {
						title: 'Order',
						width: '10%'
					}
				}
			});

			//Load person list from server
			$('#TagsTableContainer').jtable('load');

		});

	</script>

