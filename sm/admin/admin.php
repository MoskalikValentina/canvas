<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Панель управления</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="sm/admin/css/style.css">
	<!--[if lt IE 9]>
   		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
   	<![endif]-->
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
              <?php if($config->req_export()) : ?>
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
			    		<a  href="req_export" class="btn btn-success request_export_link"><span class="glyphicon glyphicon-download-alt"></span> Скачать файл</a>
			      </div>
			    </div>
			  </div>
              <?php endif; ?>
              <?php if($config->prod_export()) : ?>
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
			    	<a  href="prod_export" class="btn btn-success cars_export_link"><span class="glyphicon glyphicon-download-alt"></span> Скачать файл</a>
			      </div>
			    </div>
			  </div>
              <?php endif ?>
              <?php if($config->prodImgExport()): ?>
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
					<a  href="img_export" class="btn btn-success cars_img_export_link"><span class="glyphicon glyphicon-download-alt"></span> Скачать архив</a>
			      </div>
			    </div>
			  </div>
              <?php endif ?>
              <?php if($config->prod_update()) : ?>
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
			       <form enctype="multipart/form-data" method="post" class="update_cars_form" action="prod_import">
			    		<p>
			    			<input name="cars_list" type="file" class="btn btn-warning cars_list" placeholder="Выберите файл">
			    		</p>
			    		<button class="btn btn-success refresh_cars"><span class="glyphicon glyphicon-refresh"></span>Обновить</button>
			  		</form>
			      </div>
			    </div>
			  </div>
              <?php endif ?>
              <?php if($config->prodImgUpdate()) : ?>
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
			       <form enctype="multipart/form-data" method="post" class="update_cars_fotos_form" action="img_update">
			    		<p>
			    			<input name="products_fotos" type="file" class="btn btn-warning cars_fotos" placeholder="Выберите файл">
			    		</p>
			    		<button class="btn btn-success refresh_cars"><span class="glyphicon glyphicon-refresh"></span>Обновить</button>
			  		</form>
			      </div>
			    </div>
			  </div>
              <?php endif; ?>
			</div>
            <p><a href="log-out" class="btn-info btn pull-right">Выйти</a></p>
            <p class="text-center small"><?php echo SM_VERSION ?></p>
		</div>
		<?php endif ?>
	</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="sm/admin/js/script.js"></script>
</body>
</html>