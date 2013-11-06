<div id="WidgetsTableContainer" style="width: 600px;"></div>
	<script type="text/javascript">

		$(document).ready(function () {

		    //Prepare jTable
			$('#WidgetsTableContainer').jtable({
				title: 'Tags',
				actions: {
					listAction: 'includes/widgetsActions.php?action=list',
					createAction: 'includes/widgetsActions.php?action=create',
					updateAction: 'includes/widgetsActions.php?action=update',
					deleteAction: 'includes/widgetsActions.php?action=delete'
				},
				fields: {
					id: {
						key: true,
						create: false,
						edit: false,
						list: false
					},
					title: {
						title: 'Title',
						width: '40%'
					},
					content: {
						title: 'Content',
						width: '30%',
						type:"textarea"
					},
					sidebarorder: {
						title: 'Order',
						width: '10%'
					}
				}
			});

			//Load person list from server
			$('#WidgetsTableContainer').jtable('load');

		});

	</script>
<p>
<h4>Shortcodes:</h4>
<ul>
<li>[taglist] : Tags List</li>
<li>[tagcloud] : Tag Cloud</li>
<li>[facebook] : Facebook Like Page</li>
<li>[instagram] : Instagram Widget</li>
<li>[twitter] : Twitter Widget</li>
<li>[search] : Search widget</li>
</ul>
</p>
