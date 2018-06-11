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
		<div class="col-md-10">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Editar usuario <?= $user->username ?></h3>
                                </div>
			</div>
		</div>
	</div><!-- .row -->
</div><!-- .container -->

<?php //var_dump($users); ?>