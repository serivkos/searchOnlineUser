<html>
	<head>
	  <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
      <script type="text/javascript" src="js/moment-with-locales.min.js"></script>
      <script type="text/javascript" src="js/bootstrap.min.js"></script>
      <script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link rel="stylesheet" href="/css/bootstrap-datetimepicker.min.css" />
	</head>
	<body>
		<div class="container">
			<div class="row">
				<h1 id="forms" class="page-header">Статистика
					<a href="/addGroup" type="submit" class="btn btn-success pull-right">Добавить группу</a>
				</h1>
				<form method="get">
					<div class="form-group">
                    	<label for="dateStart">dateStart</label>
                    	<input name="dateStart" type="text" class="form-control" id="dateStart" placeholder="Начальная дата отслеживаемого периода" data-format="yyyy-MM-dd">
                  	</div>
					<div class="form-group">
                    	<label for="dateStart">dateEnd</label>
                    	<input name="dateEnd" type="text" class="form-control" id="dateEnd" placeholder="Конечная дата отслеживаемого периода" data-format="yyyy-MM-dd hh:mm:ss">
                  	</div>
					<div class="form-group">
                    	<button type="submit">Получить</button>
                  	</div>

                </form>

				<?php foreach ($groupList as $key => $group) {?>
				<div class="well">
				<div>
					<h3 class="pull-left"><?php echo $key?></h3>
					<button class="btn btn-danger deleteButton pull-right" data-id="<?php echo $key?>">Удалить Группу</button>
				</div>
				<table class="table table-bordered" style="width: 100%">
					<thead>
						<tr>
							<td>Дата Синхранизации</td>
							<td>Online</td>
							<td>Offline</td>
							<td>All</td>
						</tr>
					</thead>
					<tbody>
        			<?php foreach ($group as $groupValue) { ?>
        				<tr>
    						<td><?php echo $groupValue['date_insert']?></td>
    						<td class="success"><?php echo $groupValue['count_user_online']?></td>
    						<td class="danger"><?php echo $groupValue['count_user_offline']?></td>
    						<td class="info"><?php echo $groupValue['count_user']?></td>
        				</tr>
        			<?php }?>
					</tbody>
				</table>
				</div>
    			<?php }?>


			</div>
		</div>
		<script type="text/javascript">
			$('.deleteButton').click(function(){
				var groupId = $(this).attr('data-id');

				$.post('/deleteGroup', {groupId: groupId}, function(data){
					window.location.reload()
				})
			})

			$(document).ready(function(){
    			$('#dateStart').datetimepicker({
        			language: 'ru',
        			inline: true,
        			sideBySide: true,
        			pick12HourFormat: false,
        			pickSeconds: true,
        			format: 'YYYY-MM-DD HH:mm:00',
    			});
    			$('#dateEnd').datetimepicker({
        			language: 'ru',
        			inline: true,
        			sideBySide: true,
        			pick12HourFormat: false,
        			pickSeconds: true,
        			format: 'YYYY-MM-DD HH:mm:00',
    			});
			})
		</script>
	</body>
</html>
