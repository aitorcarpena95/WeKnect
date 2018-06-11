<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
	<div class="row">
		<div class="breadmiga col-md-12">
			<?= $breadcrumb ?>
		</div>
		<div class="col-md-12">
			<div class="page-header">
				<h1>Borrar usuario <small><?= $user->username ?></small></h1>
			</div>
		</div>
		<?php if (isset($success)) : ?>
			<div class="col-md-12">
				<div class="alert alert-success" role="alert">
					<p><?= $success ?></p>
					<p>Volver al <a href="<?= base_url() ?>">Home</a></p>
				</div>
			</div>
		<?php endif; ?>
	</div><!-- .row -->
</div><!-- .container -->

<?php session_destroy() ?>