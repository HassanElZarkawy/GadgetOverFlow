<?php $top = $viewModel->get('top'); $user = $viewModel->get('me'); $stats = $viewModel->get('stats'); $tags = $viewModel->get('tags'); $recent = $viewModel->get('recent'); ?>
<?php if (Tokenizer::exists('update-error')) { ?>
  <div class="alert alert-danger">
    <strong>Invalid Attempt: </strong> <?php echo Tokenizer::get('update-error'); Tokenizer::delete('update-error'); ?>
  </div>
  <br />
<?php } ?>
<div class="row">
			<div class="col-md-9">
				<div class="page-content">
					<div class="boxedtitle page-title"><h2>Edit Your Profile</h2></div>
					
					<div class="form-style form-style-4">
						<form method="post" action="<?php echo $root . 'me/update' ?>">
							<div class="form-inputs clearfix">
								<p>
									<label>Display Name</label>
									<input id="DisplayName" name="DisplayName" type="text" value="<?php echo $user->DisplayName ?>">
								</p>
								<p>
									<label class="required">E-Mail<span>*</span></label>
									<input id="Email" name="Email" type="email" value="<?php echo $user->Email ?>">
								</p>
								<p>
									<label>Website</label>
									<input id="Website" Name="Website" type="text" value="<?php echo $user->Website ?>">
								</p>
								<p>
									<label>Country</label>
									<input id="Country" Name="Country" type="text" value="<?php echo $user->Country ?>">
								</p>
							</div>
							<div class="form-style form-style-2">
								<div class="user-profile-img"><img src="<?php echo $user->UserImage ?>" alt="<?php echo $user->DisplayName ?>"></div>
								<p class="user-profile-p">
									<label>Profile Picture</label>
									<div class="fileinputs">
										<input type="file" class="file">
										<div class="fakefile">
											<button type="button" class="button small margin_0">Select file</button>
											<span><i class="icon-arrow-up"></i>Browse</span>
										</div>
									</div>
								<p></p>
								<div class="clearfix"></div>
								<p>
									<label>About Yourself</label>
									<textarea id="Discreption" Name="Discreption" cols="58" rows="8"><?php echo $user->Discreption ?></textarea>
								</p>
							</div>>
							<p class="form-submit">
								<input type="submit" value="Update" class="button color small login-submit submit">
							</p>
						</form>
					</div>
				</div><!-- End page-content -->
			</div><!-- End main -->

			<aside class="col-md-3 sidebar">
				<div class="widget widget_stats">
					<h3 class="widget_title">Stats</h3>
					<div class="ul_list ul_list-icon-ok">
						<ul>
							<li><i class="icon-question-sign"></i>Questions (<span><?php echo number_format($stats->totalQuestions); ?></span>)</li>
            				<li><i class="icon-comment"></i>Answers (<span><?php echo number_format($stats->totalAnswers); ?></span>)</li>
						</ul>
					</div>
				</div>
				
				<div class="widget widget_highest_points">
					<h3 class="widget_title">Highest points</h3>
					<ul>
						<?php foreach ($top as $item) { ?>
							<li>
								<div class="author-img">
									<a href="<?php echo $root . 'user/' . $item->UserId; ?>"><img width="60" height="60" src="<?php echo $item->UserImage ?>" alt="<?php echo $item->DisplayName ?>"></a>
								</div> 
								<h6><a href="<?php echo $root . 'user/' . $item->UserId; ?>"><?php echo $item->DisplayName ?></a></h6>
								<span class="comment"><?php echo number_format($item->Points) . ' Points' ?></span>
							</li>
						<?php } ?>
					</ul>
				</div>
				
				<div class="widget widget_tag_cloud">
					<h3 class="widget_title">Tags</h3>
					<?php $tags = $viewModel->get('tags'); ?>
					<?php foreach ($tags as $tag) { ?>
						<a href="#"><?php echo $tag->Name; ?></a>
					<?php } ?>
				</div>
				
				<div class="widget">
					<h3 class="widget_title">Recent Questions</h3>
					<ul class="related-posts">
					<?php foreach (array_slice($recent, 0, 3) as $item) { ?>
						<li class="related-item">
						<h3><a href="#"><?php echo $item->Title; ?></a></h3>
						<p><?php echo substr(strip_tags($item->Body), 0, 100) . '...'; ?></p>
						<div class="clear"></div><span><?php echo Utility::time2str($item->CreationDate); ?></span>
						</li>
					<?php } ?>
					</ul>
				</div>
				
			</aside>
		</div>