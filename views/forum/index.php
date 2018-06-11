<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
	<div class="row">
            
           
			
		
		<div class="breadmiga col-md-12" >
			<?= $breadcrumb ?>
		</div>
		
          
            <div class="tabla col-md-12" >
                    <table id="tablaforo" class="table table-hover">
				<caption></caption>
				<thead>
					<tr>
						<th>Foros</th>
						<th>Subforos</th>
						<th>Posts</th>
						<th class="hidden-xs">Ultimo subforo</th>
					</tr>
				</thead>
                                
				<tbody>
					<?php if ($forums) : ?>
						<?php foreach ($forums as $forum) : ?>
							<tr class="td1">
                                                            <td>
									<p>
                                                                            <a href="<?= base_url("index.php/".$forum->slug) ?>"><?= $forum->title ?></a><br>
										<small><?= $forum->description ?></small>
									</p>
								</td>
								<td>
									<p>
										<small><?= $forum->count_topics ?></small>
									</p>
								</td>
								<td>
									<p>
										<small><?= $forum->count_posts ?></small>
									</p>
								</td>
								<td class="hidden-xs">
									<?php if ($forum->latest_topic->title !== null) : ?>
										<p>
                                                                                    <small><a id="ultimo-subforo" href="<?= base_url("index.php/".$forum->latest_topic->permalink) ?>"><?= $forum->latest_topic->title ?></a><br>por <a id="usuario-ultimo-subforo" href="<?= base_url('index.php/user/' . $forum->latest_topic->author) ?>"><?= $forum->latest_topic->author ?></a>, <?= $forum->latest_topic->created_at ?></small>
										</p>
									<?php else : ?>
										<p>
											<small>Aún no hay sufboros</small>
										</p>
									<?php endif; ?>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table>
			
		</div>
		
		<?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true) : ?>
			<div class="col-md-12">
				<a href="<?= base_url('index.php/create_forum') ?>" class="btn btn-default">Crear un nuevo foro</a>
			</div>
		<?php endif; ?>
		
	</div><!-- .row -->
        
</div><!-- .container -->

<?php //var_dump($forums); ?>