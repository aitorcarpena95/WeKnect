<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
	<div class="row">
		<div class="breadmiga col-md-12">
			<?= $breadcrumb ?>
		</div>
		<div class="col-md-12">
			<div class="page-header">
				<h1>Perfil de usuario <small><?= $user->username ?></small> <?= $edit_button ?></h1>
			</div>
		</div>
		<div class="col-md-12">
			<div class="row">
				<div class="col-sm-2 text-center">
					<!--<img class="avatar" src="<?= base_url('knect.asir6.enganxat.net/index.php/uploads/avatars/' . $user->avatar) ?>">-->
                                    <img class="avatar" src="http://sitelcity.com/wp-content/uploads/2015/04/default-user-image-300x300.png">
					<h2><?= $user->username ?></h2>
				</div>
				<div class="col-sm-4 col-sm-offset-1">
					<p>Se unió: <?= $user->created_at ?></p>
					<p>Última vez activo: <?= $user->latest_post->created_at ?></p>
					<p>Subforo empezado: <?= $user->count_topics ?></p>
					<p>Posts: <?= $user->count_posts ?></p>
				</div>
				<div class="col-sm-5">
					<?php if (isset($user->latest_topic->permalink)) : ?>
						<p>Último subforo: <a href="<?= $user->latest_topic->permalink ?>"><?= $user->latest_topic->title ?></a></p>
					<?php else : ?>
						<p>Último subforo: <?= $user->latest_topic->title ?></p>
					<?php endif; ?>
					<?php if (isset($user->latest_post->topic->permalink)) : ?>
						<p>Último post: <a href="<?= $user->latest_post->topic->permalink ?>"><?= $user->latest_post->topic->title ?></a></p>
					<?php else : ?>
						<p>Último post: <?= $user->username ?> aún no ha posteado nada</p>
					<?php endif; ?>
				</div>
			</div><!-- .row -->
		</div>
	</div><!-- .row -->
</div><!-- .container -->

<?php //var_dump($user); ?>