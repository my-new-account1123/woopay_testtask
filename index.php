<?php require_once 'DbLayer.php';
$DbLayer = new DbLayer('news');
session_start();
function regenerate() {
    $_SESSION['code'] = uniqid();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>test</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="style/style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</head>
<body>
	<div class="modal" id="createmodal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Добавить новость</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<form action="#" method="get">
						<label for="create_title">Заголовок:</label>
						<input id="create_title" type="text" name="create_title">
						<label for="textarea">Текст новости:</label>
						<textarea rows="4" cols="62" id="textarea" name="create_description"></textarea><br>
						<input type="hidden" id="status" name="status" value="1">
						<input class="btn btn-primary" type="submit" value="Submit">
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal" id="updatemodal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Изменить новость</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<form action="#" method="get">
						<label for="update_id">ID новости:</label>
						<input id="update_id" type="text" name="update_id">
						<label for="create_title">Заголовок:</label>
						<input id="update_title" type="text" name="update_title">
						<label for="textarea">Текст новости: </label>
						<textarea rows="4" cols="62" id="textarea" name="update_description"></textarea><br>
						<input type="hidden" id="status" name="status" value="2">
						<input class="btn btn-primary" type="submit" value="Submit">
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="col-md-12 flexible">
			<div class="col-md-8 news_colomn">
				<?php if(isset($_GET['find_id'])): ?>
					<?php $DbLayer->findOneById($_GET['find_id']);?>

					<?php elseif(isset($_GET['user_id'])??($_GET['status_news'])): ?>
						<?php $DbLayer->findAllByAttributes(['user_id'=>$_GET["user_id"],'status_news'=>$_GET['status_news']]);?>

						<?php else: ?>
							<?php $DbLayer->findAll();?>
						<?php endif; ?>

						<?php if(isset($_GET['delete_id'])): ?>
							<?php $DbLayer->deleteById($_GET['delete_id']);?>
						<?php endif; ?>

						<?php if(isset($_GET['create_title'])&&($_GET['create_description'])&&($_GET['status'])):?>
				<?php $DbLayer->create(['user_id'=>$_SESSION['code'],'title'=>$_GET['create_title'],'description'=>$_GET['create_description'],'status'=>$_GET['status']]);?>
					<?php endif; ?>

					<?php if(isset($_GET['update_id'])&&($_GET['update_title'])&&($_GET['update_description'])):?>
					<?php $DbLayer->updateById(['update_id'=>$_GET['update_id'],'update_title'=>$_GET['update_title'],'update_description'=>$_GET['update_description'],
					'status'=>$_GET['status']]);?>
				<?php endif; ?>
			</div>
			<div class="col-md-4">
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createmodal">Добавить новость</button>
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#updatemodal">Изменить новость</button>
				<div class="findbyid">
					<h2 class="findtitle border">Поиск</h2>
					<form action="#" method="get">
						<label for="find_id">Введите ID новости для поиска</label>
						<input id="find_id" type="text" name="find_id"><br>
						<input class="btn btn-primary" type="submit" value="Submit">
					</form>
				</div>
				<div class="findbyuser border">
					<form action="#" method="get">
						<label for="user_id">Введите ID user новости для поиска или Статус новости </label>
						<label for="user_id">Введите ID user</label>
						<input id="user_id" type="text" name="user_id"><br>
						<label for="status_news">Выберите статус новости </label>
						<select name="status_news" class="status_news">
							<option value="1">Не измененные</option>
							<option value="2">Измененные</option>
						</select><br>
						<input class="btn btn-primary" type="submit" value="Submit">
					</form>
				</div>
				<div class="deletebyid border">
					<form action="#" method="get">
						<label for="delete_id">Введите ID новости которую нужно удалить</label>
						<input id="delete_id" type="text" name="delete_id"><br>
						<input class="btn btn-primary" type="submit" value="Submit">
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
