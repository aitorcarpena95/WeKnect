<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
	<div class="row">
		<div class="col-md-2">
			<ul class="nav nav-pills nav-stacked">
				<li role="presentation"><a href="<?= base_url('index.php/admin') ?>">Home</a></li>
				<li role="presentation" class="active"><a href="<?= base_url('index.php/admin/users') ?>">Volver a Usuarios</a></li>
				<li role="presentation"><a href="<?= base_url('index.php/admin/forums_and_topics') ?>">Foros y Subforos</a></li>
				<li role="presentation"><a href="<?= base_url('index.php/admin/options') ?>">Opciones</a></li>
				<li role="presentation"><a href="<?= base_url('index.php/admin/emails') ?>">Emails</a></li>
			</ul>
		</div>
		<div class="breadmiga col-md-10">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Editar usuario <?= $user->username ?></h3>
				</div>
				<div class="panel-body">
					<?php if (validation_errors()) : ?>
						<div class="alert alert-danger" role="alert">
							<p><?= validation_errors() ?></p>
						</div>
					<?php endif; ?>
					<?php if (isset($error)) : ?>
						<div class="alert alert-danger" role="alert">
							<p><?= $error ?></p>
						</div>
					<?php endif; ?>
					<?php if (isset($success)) : ?>
						<div class="alert alert-success" role="alert">
							<p><?= $success ?></p>
						</div>
					<?php endif; ?>
					<?= form_open() ?>	
						<div class="form-group">	
							<label for="user_rights">Seleccionar permisos de usuario</label>	
							<select class="form-control" name="user_rights" id="user_rights">
								<?= $options ?>
							</select>
						</div>
						<input type="submit" class="btn btn-default" value="Update rights">
						<?php if ($user->updated_at !== null) : ?>
							<small>(last update by <?= $user->updated_by ?>, <?= $user->updated_at ?>)</small>
							<?php endif; ?>
					</form>
				</div>
			</div>
		</div>
	</div><!-- .row -->
</div><!-- .container -->

<?php //var_dump($users); ?>