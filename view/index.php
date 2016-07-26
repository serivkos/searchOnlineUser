<html>
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<script src="/js/jquery.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<h1 id="forms" class="page-header">Статистика
					<a href="/addGroup" type="submit" class="btn btn-success pull-right">Добавить группу</a>
				</h1>
				<table class="table table-bordered" style="width: 100%">
					<thead>
						<tr>
							<td>Id Группы</td>
							<td>Описание</td>
							<td>Online</td>
							<td>Offline</td>
							<td>All</td>
							<td>Action</td>
						</tr>
					</thead>
					<tbody>
        			<?php foreach ($groupList as $group) {?>
        				<tr>
    						<td><?php echo $group['group_id']?></td>
    						<td><?php echo $group['description']?></td>
    						<td class="success"><?php echo $group['count_user_online']?></td>
    						<td class="danger"><?php echo $group['count_user_offline']?></td>
    						<td class="info"><?php echo $group['count_user']?></td>
    						<td><button type="submit" class="btn btn-danger deleteButton" data-id="<?php echo $group['group_id']?>">Удалить Группу</button></td>
        				</tr>
        			<?php }?>
					</tbody>
				</table>
			</div>
		</div>
		<script type="text/javascript">
			$('.deleteButton').click(function(){
				var groupId = $(this).attr('data-id');

				$.post('/deleteGroup', {groupId: groupId}, function(data){
					window.location.reload()
				})
			})
		</script>
	</body>
</html>
