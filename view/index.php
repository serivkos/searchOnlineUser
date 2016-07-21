<html>
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

	</head>
	<body>
		<div class="container">
			<div class="row">
				<table class="table table-bordered" style="width: 100%">
					<thead>
						<tr>
							<td>Id Группы</td>
							<td>Описание</td>
							<td>Online</td>
							<td>Offline</td>
						</tr>
					</thead>
					<tbody>
        			<?php foreach ($groupList as $group) { ?>
        				<tr>
    						<td><?php echo $group['group_id']?></td>
    						<td><?php echo $group['description']?></td>
    						<td class="success"><?php echo $group['usersOnline']?></td>
    						<td class="danger"><?php echo $group['usersOffline']?></td>
        				</tr>
        			<?php }?>
					</tbody>
				</table>
			</div>
		</div>
	</body>
</html>
