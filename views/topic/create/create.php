<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
	<div class="row">
		<div class="breadmiga col-md-12">
			<?= $breadcrumb ?>
		</div>
		<div class="col-md-12">
			<div class="page-header">
				<h1>Crear un nuevo subforo</h1>
			</div>
		</div>
		<?php if ($login_needed) : ?>
			<div class="col-md-12">
				<div class="alert alert-danger" role="alert">
					<p>Necesitas estar logueado para crear un subforo!</p>
					<p>Porfavor <a href="<?= base_url('index.php/login') ?>">logueate</a> o <a href="<?= base_url('index.php/register') ?>">registra una nueva cuenta</a>.</p>
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
						<label for="title">Título del subforo</label>
						<input type="text" class="form-control" id="title" name="title" placeholder="Titulo del subforo" value="<?= $title ?>">
					</div>
					<div class="form-group">
						<label for="content">Contenido</label>
						<textarea rows="6" class="form-control" id="content" name="content" placeholder="Escribe el contenido del subforo"><?= $content ?></textarea>
					</div>
					<div class="form-group">
						<input type="submit" class="btn btn-default" value="Crear Subforo">
					</div>
				</form>
			</div>
		<?php endif; ?>
	</div><!-- .row -->
</div><!-- .container -->