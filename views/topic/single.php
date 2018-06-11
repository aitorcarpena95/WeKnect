<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
	<div class="row">
		<div class="breadmiga col-md-12">
			<?= $breadcrumb ?>
		</div>
		<div class="col-md-12">
			<div class="page-header">
				<h1><?= $topic->title ?></h1>
			</div>
		</div>
		
		<?php foreach ($posts as $post) : ?>
			<div class="col-md-12">
				<article class="panel panel-default">
					<div class="panel-body">
						<header class="post-header">
							<small><a href="<?= base_url('index.php/user/' . $post->author) ?>"><?= $post->author ?></a>, <?= $post->created_at ?></small>
						</header>
						<div class="post-content">
							<?= $post->content ?>
						</div>
					</div>
				</article>
			</div>
		<?php endforeach; ?>
		
		<?php if (isset($_SESSION['user_id'])) : ?>
			<div class="col-md-12">
				<a href="<?= base_url("index.php/"."$forum->slug" . '/' . $topic->slug . '/reply') ?>" class="btn btn-default">Responder en éste subforo</a>
			</div>
		<?php endif; ?>
		
	</div><!-- .row -->
</div><!-- .container -->

<?php //var_dump($forum, $topic, $posts); ?>