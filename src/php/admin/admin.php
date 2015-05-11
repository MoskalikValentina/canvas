

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Панель управления</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="admin/css/style.css">

	<!--[if lt IE 9]>
   		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
   	<![endif]-->
   	<link href="img/favicon.ico" rel="shortcut icon">
</head>
<body>
	<div class="wp">
		<?php if(!$login): ?>
		<!-- LOGIN BLK -->
		<div class="login-bg">
			<div class="login-blk">
				<p class="text-danger"><?php echo $status ?></p>
				<form method="POST">
					<div class="input-group">
						<span class="input-group-addon glyphicon glyphicon-user"></span>
						<input name="login" type="text" class="form-control" placeholder="Логин" required>
					</div>
					<div class="input-group">
						<span class="input-group-addon glyphicon glyphicon-lock"></span>
						<input type="password" name="password" placeholder="Пароль" class="form-control" required>
					</div>
					<input type="hidden" name="login_form" value='1'>
					<input type="hidden" name="admin" value='1'>
					<button type="submit" class="btn btn-info">Войти</button>
				</form>
			</div>
		</div>
		<?php endif ?>
		<?php if($login): ?>
		<div class="config-blk">
			<p class="text-danger"><?php echo $status ?></p>
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
			  <div class="panel panel-default">
			    <div class="panel-heading" role="tab" id="headingOne">
			      <h4 class="panel-title">
			        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
			          Экспорт заявок
			        </a>
			      </h4>
			    </div>
			    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
			      <div class="panel-body">
			    		<button type="submit" class="btn btn-info request_export_prepear"><span class="glyphicon glyphicon-saved"></span> Подготовить файл</button>
			    		<a  href="#" class="btn btn-default disabled request_export_link"><span class="glyphicon glyphicon-download-alt"></span> Скачать файл</a>
			      </div>
			    </div>
			  </div>
			  <div class="panel panel-default">
			    <div class="panel-heading" role="tab" id="headingTwo">
			      <h4 class="panel-title">
			        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
			         Экспорт текущих данных по авто
			        </a>
			      </h4>
			    </div>
			    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
			      <div class="panel-body">
					<button type="submit" class="btn btn-info cars_export_prepear"><span class="glyphicon glyphicon-saved"></span> Подготовить файл</button>
			    	<a  href="#" class="btn btn-default disabled cars_export_link"><span class="glyphicon glyphicon-download-alt"></span> Скачать файл</a>
			      </div>
			    </div>
			  </div>
			  <div class="panel panel-default">
			    <div class="panel-heading" role="tab" id="headingAuto">
			      <h4 class="panel-title">
			        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseAuto" aria-expanded="false" aria-controls="collapseTwo">
			         Экспорт фотографий авто
			        </a>
			      </h4>
			    </div>
			    <div id="collapseAuto" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingAuto">
			      <div class="panel-body">
					<button type="submit" class="btn btn-info cars_img_export_prepear"><span class="glyphicon glyphicon-saved"></span> Подготовить архив</button>
			    	<a  href="#" class="btn btn-default disabled cars_img_export_link"><span class="glyphicon glyphicon-download-alt"></span> Скачать архив</a>
			      </div>
			    </div>
			  </div>
			  <div class="panel panel-default">
			    <div class="panel-heading" role="tab" id="headingThree">
			      <h4 class="panel-title">
			        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
			          Обновление данных по авто
			        </a>
			      </h4>
			    </div>
			    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
			      <div class="panel-body">
			       <form enctype="multipart/form-data" method="post" class="update_cars_form">
			    		<p>
			    			<input name="cars_list" type="file" class="btn btn-warning cars_list" placeholder="Выберите файл">
			    		</p>
			    		<input type="hidden" name="prod_import" value='1'>
			    		<input type="hidden" name="admin" value="true">
			    		<button class="btn btn-success refresh_cars"><span class="glyphicon glyphicon-refresh"></span>Обновить</button>
			  		</form>
			      </div>
			    </div>
			  </div>
			  <div class="panel panel-default">
			    <div class="panel-heading" role="tab" id="headingFoto">
			      <h4 class="panel-title">
			        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFoto" aria-expanded="false" aria-controls="collapseThree">
			          Обновление фото авто
			        </a>
			      </h4>
			    </div>
			    <div id="collapseFoto" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFoto">
			      <div class="panel-body">
			       <form enctype="multipart/form-data" method="post" class="update_cars_fotos_form">
			    		<p>
			    			<input name="products_fotos" type="file" class="btn btn-warning cars_fotos" placeholder="Выберите файл">
			    		</p>
			    		<input type="hidden" name="img_update" value='1'>
			    		<input type="hidden" name="admin" value="true">
			    		<button class="btn btn-success refresh_cars"><span class="glyphicon glyphicon-refresh"></span>Обновить</button>
			  		</form>
			      </div>
			    </div>
			  </div>
			</div>
		</div>
		<?php endif ?>
	</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>window.jQuery || document.write("<script src='js/libs/jquery-1.11.1.min.js'>\x3C/script>")</script>
<script src="admin/js/script.js"></script>
</body>
</html>