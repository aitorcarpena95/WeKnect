<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
	<div class="row">
		<div class="breadmiga col-md-12">
			<?= $breadcrumb ?>
		</div>
		<div class="col-md-12">
			<div class="page-header">
				<h1><?= $forum->title ?></h1>
				<p><?= $forum->description ?></p>
			</div>
		</div>
		
		<div class="col-md-12">
			<?php if (isset($topics) && !empty($topics)) : ?>
				<table class="table table-condensed">
					<caption></caption>
					<thead>
						<tr>
							<th>Subforos</th>
							<th>Posts</th>
							<th class="hidden-xs">Último post</th>
						</tr>
					</thead>
                                        <tbody class="td1">
						<?php foreach ($topics as $topic) : ?>
							<tr>
								<td>
									<p>
										<a href="<?= base_url("index.php/"."$topic->permalink") ?>"><?= $topic->title ?></a><br>
										<small>creado por <a href="<?= base_url('index.php/user/' . $topic->author) ?>"><?= $topic->author ?></a>, <?= $topic->created_at ?></small>
									</p>
								</td>
								<td>
									<p>
										<small><?= $topic->count_posts ?></small>
									</p>
								</td>
								<td class="hidden-xs">
									<p>
										<small>por <a href="<?= base_url('index.php/user/' . $topic->latest_post->author) ?>"><?= $topic->latest_post->author ?></a><br><?= $topic->latest_post->created_at ?></small></p>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php else : ?>
				<h4>Aún no hay subforos...</h4>
			<?php endif; ?>
		</div>
		
		<?php if (isset($_SESSION['user_id'])) : ?>
			<div class="col-md-12">
				<a href="<?= base_url("index.php/"."$forum->slug" . '/create_topic') ?>" class="btn btn-default">Crear un nuevo subforo</a>
			</div>
		<?php endif; ?>
		
	</div><!-- .row -->
</div><!-- .container -->

<?php //var_dump($forum, $topics); ?>