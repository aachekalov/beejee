<div class="site-login">
	<h1>Вход</h1>
	<p>Пожалуйста, введите данные, чтобы войти:</p>
	<form id="login-form" class="form-horizontal" action="/site/login" method="post">
		<div class="form-group field-loginform-username required <?php if (count($model->errors)) print isset($model->errors['user']) ? 'has-error' : 'has-success'; ?>">
			<label class="col-lg-1 control-label" for="loginform-username">User</label>
			<div class="col-lg-3">
				<input type="text" id="loginform-username" class="form-control" name="user" autofocus="" aria-required="true" aria-invalid="false" <?php if (count($model->errors)) print 'value="' . $model->user . '"'; ?>>
			</div>
			<div class="col-lg-8">
				<p class="help-block help-block-error "><?php if (isset($model->errors['user'])) print $model->errors['user']; ?></p>
			</div>
		</div>
		<div class="form-group field-loginform-password required <?php if (count($model->errors)) print isset($model->errors['password']) ? 'has-error' : ''; ?>">
			<label class="col-lg-1 control-label" for="loginform-password">Пароль</label>
			<div class="col-lg-3">
				<input type="password" id="loginform-password" class="form-control" name="password" value="" aria-required="true" aria-invalid="false">
			</div>
			<div class="col-lg-8">
                <p class="help-block help-block-error "><?php if (isset($model->errors['password'])) print $model->errors['password']; ?></p>
			</div>
		</div>
		<div class="form-group">
			<div class="col-lg-offset-1 col-lg-11">
				<button type="submit" class="btn btn-primary" name="login-button">Войти</button>
			</div>
		</div>
	</form>
</div>