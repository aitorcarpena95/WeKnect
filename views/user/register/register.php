<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
	<div class="row">
		<?php if (validation_errors()) : ?>
			<div class="col-md-12">
				<div class="alert alert-danger" role="alert">
					<?= validation_errors() ?>
				</div>
			</div>
		<?php endif; ?>
		<?php if (isset($error)) : ?>
			<div class="col-md-12">
				<div class="alert alert-danger" role="alert">
					<?= $error ?>
				</div>
			</div>
		<?php endif; ?>
		<div class="col-md-12">
			<div class="page-header">
				<h1>Registrarse</h1>
			</div>
			<?= form_open() ?>
				<div class="form-group">
					<label for="username">Usuario</label>
					<input type="text" class="form-control" id="username" name="username" placeholder="Escribe un nombre de usuario">
					<p class="help-block">Por lo menos 4 carácteres, solo letras y números</p>
				</div>
				<div class="form-group">
					<label for="email">Email</label>
					<input type="email" class="form-control" id="email" name="email" placeholder="Escribe tu email">
					<p class="help-block">Escriba una cuenta de correo válida</p>
				</div>
				<div class="form-group">
					<label for="password">Contraseña</label>
					<input type="password" class="form-control" id="password" name="password" placeholder="Escribe una contraseña">
					<p class="help-block">Por lo menos 6 carácteres</p>
				</div>
				<div class="form-group">
					<label for="password_confirm">Confirmar contraseña</label>
					<input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Confirma tu contraseña">
					<p class="help-block">Las contraseñas deben coincidir</p>
				</div>
				<div class="form-group">
					<input type="submit" class="btn btn-default" value="Registrarse">
				</div>
			</form>
		</div>
	</div><!-- .row -->
</div><!-- .container -->