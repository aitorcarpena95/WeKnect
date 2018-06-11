<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
	<div class="row">
		<div class="breadmiga col-md-12">
			<?= $breadcrumb ?>
		</div>
		<div class="col-md-12">
			<div class="page-header">
				<h1>Crear un nuevo Foro</h1>
			</div>
		</div>
		<?php if ($login_as_admin_needed) : ?>
			<div class="col-md-12">
				<div class="alert alert-danger" role="alert">
					<p>Necesitas estar logueado como Admin para crear un nuevo foro!</p>
					<p>Please <a href="<?= base_url('index.php/login') ?>">login</a>.</p>
				</div>
			</div>
		<?php else : ?>
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
				<?= form_open() ?>
					<div class="form-group">
						<label for="title">Título</label>
						<input type="text" class="form-control" id="title" name="title" placeholder="Escriba el título del foro" value="<?= $title ?>">
					</div>
					<div class="form-group">
						<label for="description">Descripción</label>
						<textarea rows="6" class="form-control" id="description" name="description" placeholder="Escriba una pequeña descripción del foro (max 80 carácteres)"><?= $description ?></textarea>
					</div>
					<div class="form-group">
						<input type="submit" class="btn btn-default" value="Crear foro">
					</div>
				</form>
			</div>
		<?php endif; ?>
	</div><!-- .row -->
</div><!-- .container -->