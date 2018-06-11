<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
	<div class="row">
		<div class="breadmiga col-md-12">
			<?= $breadcrumb ?>
		</div>
		<div class="col-md-12">
			<div class="page-header">
				<h1>Editar tu perfil <small><?= $user->username ?></small></h1>
			</div>
		</div>
		<?php if (validation_errors()) : ?>
			<div class="col-md-12">
				<div class="alert alert-danger" role="alert">
					<p><?= validation_errors() ?></p>
				</div>
			</div>
		<?php endif; ?>
		<?php if (isset($success)) : ?>
			<div class="col-md-12">
				<div class="alert alert-success" role="alert">
					<p><?= $success ?></p>
				</div>
			</div>
		<?php endif; ?>
		<?php if (isset($_SESSION['flash'])) : ?>
			<div class="col-md-12">
				<div class="alert alert-success" role="alert">
					<p><?= $_SESSION['flash'] ?></p>
					<?php unset($_SESSION['flash']); ?>
				</div>
			</div>
		<?php endif; ?>
		<div class="col-md-12">
                    <div class="row" >
				<?= form_open_multipart() ?>
					<div class="col-md-8" >
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">Administrar tu cuenta</h3>
							</div>
							<div class="panel-body">
								<div class="row">
									<div class="col-sm-3 text-center">
										<img class="avatar" src="<?= base_url('index.php/uploads/avatars/' . $user->avatar) ?>">
										<br><br>
										<div class="form-group">
											<label for="avatar">Cambiar tu foto de perfil</label>
											<input type="file" id="avatar" name="userfile" style="word-wrap: break-word">
										</div>
									</div>
									<div class="col-sm-7 col-sm-offset-2">
										<div class="form-group">
											<label for="username">Usuario</label>
											<input type="text" class="form-control" id="username" name="username" placeholder="<?= $user->username ?>">
										</div>
										<div class="form-group">
											<label for="email">Email</label>
											<input type="email" class="form-control" id="email" name="email" placeholder="<?= $user->email ?>">
										</div>
										<div class="form-group">
											<label for="current_password">Contraseña actual</label>
											<input type="password" class="form-control" id="current_password" name="current_password" placeholder="Escriba la contraseña si desea cambiarla">
										</div>
										<div class="form-group">
											<label for="password">Nueva contraseña</label>
											<input type="password" class="form-control" id="password" name="password" placeholder="Escriba una nueva contraseña">
										</div>
										<div class="form-group">
											<label for="password_confirm">Confirmar nueva contraseña</label>
											<input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Confirma tu nueva contraseña">
										</div>
										<input type="submit" class="btn btn-primary" value="Actualizar perfil">
									</div>
								</div><!-- .row -->
							</div>
						</div>
					</div>			
					<div class="col-md-4">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">Borrar tu cuenta</h3>
							</div>
							<div class="panel-body">
								<p>Si quieres borrar tu cuenta, pulsa el botón que hay acontinuación.</p>
								<p><strong>ATENCIÓN! Si lo pulsas, tu cuenta sera borrada permanentemente. Recuerda que no hay vuelta atrás!</strong></p>
								<a href="<?= base_url('index.php/user/' . $user->username . 'index.php//delete') ?>" class="btn btn-danger btn-block btn-sm" onclick="return confirm('Estás seguro de que quieres borrar tu cuenta? Si pulsas OK, tu cuentas sera permanentemente borrada.')">Borrar tu cuenta</a>
							</div>
						</div>	
					</div>
				</form>
			</div><!-- .row -->
		</div>
	</div><!-- .row -->
</div><!-- .container -->

<?php //var_dump($user); ?>