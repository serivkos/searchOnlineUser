<html>
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

	</head>
	<body>
		<div class="container">
			<div class="row">
			<h1 id="forms" class="page-header">Добавление новой группы</h1>
<?php  if ($_SERVER['REQUEST_METHOD'] != 'POST') { ?>
                <form method="post">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Id группы</label>
                      <input name="groupId" type="text" class="form-control" placeholder="id группы">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Описание</label>
                      <input name="descripption" type="text" class="form-control" placeholder="Описание">
                    </div>
                    <button type="submit" class="btn btn-success">Отправить</button>
                </form>
<?php } else {?>
				<div class="well"><p><?php echo !empty($status['error']) ? $status['error'] : 'Группа успешно добавленна, в течении 30 минут подтянутся данные о ней' ;?></p></div>
				<a href="/" type="submit" class="btn btn-success">Назад</a>
<?php } ?>
			</div>
		</div>

	</body>
</html>
