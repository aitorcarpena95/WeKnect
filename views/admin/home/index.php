<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
	<div class="row">
		<div class="col-md-2">
			<ul class="nav nav-pills nav-stacked">
				<li role="presentation" class="active"><a href="#">Home</a></li>
				<li role="presentation"><a href="<?= base_url('index.php/admin/users') ?>">Usuarios</a></li>
				<li role="presentation"><a href="<?= base_url('index.php/admin/forums_and_topics') ?>">Foros y Subforos</a></li>
				<li role="presentation"><a href="<?= base_url('index.php/admin/options') ?>">Opciones</a></li>
				<li role="presentation"><a href="<?= base_url('index.php/admin/emails') ?>">Emails</a></li>
			</ul>
		</div>
		<div class="breadmiga col-md-10">
			<div class=" panel panel-default" align="center">
				<div class="panel-heading">
					<h3 class="panel-title">Home Administrador</h3>
				</div>
				
                            <h3 style="color: black" >Bienvenido Administrador, que deseas hacer?</h3>
					
				</div>
			</div>
		</div>
	</div><!-- .row -->
</div><!-- .container -->