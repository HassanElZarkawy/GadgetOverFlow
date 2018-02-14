<?php $top = $viewModel->get('top'); $user = $viewModel->get('user'); $stats = $viewModel->get('stats'); $tags = $viewModel->get('tags'); $recent = $viewModel->get('recent'); ?>
<div class="row">
			<div class="col-md-9">
				<div class="row">
					<div class="user-profile">
						<div class="col-md-12">
							<div class="page-content">
								<h2>About <?php echo $user->DisplayName; ?></h2>
								<div class="user-profile-img"><img width="60" height="60" src="<?php echo $user->UserImage ?>" alt="<?php echo $user->DisplayName ?>"></div>
								<div class="ul_list ul_list-icon-ok about-user">
									<ul>
										<li><i class="icon-plus"></i>Registerd : <span><?php echo date('d/m/Y', strtotime($user->Joined)); ?></span></li>
										<li><i class="icon-map-marker"></i>Country : <span><?php echo $user->Country; ?></span></li>
										<li><i class="icon-globe"></i>Website : <a target="_blank" href="<?php echo $user->Website; ?>"><?php echo $user->Website; ?></a></li>
									</ul>
								</div>
								<p><?php $user->Description; ?></p>
								<div class="clearfix"></div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="page-content page-content-user-profile">
								<div class="user-profile-widget">
									<h2>User Stats</h2>
									<div class="ul_list ul_list-icon-ok">
										<ul>
											<li><i class="icon-question-sign"></i><a href="user_questions.html">Questions<span> ( <span><?php echo $user->TotalQuestions; ?></span> ) </span></a></li>
											<li><i class="icon-comment"></i><a href="user_answers.html">Answers<span> ( <span><?php echo $user->TotalAnswers; ?></span> ) </span></a></li>
											<li><i class="icon-heart"></i><a href="user_points.html">Points<span> ( <span><?php echo $user->Points; ?></span> ) </span></a></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>

				<div id="related-posts">
					<h2>Recent questions</h2>
					<ul class="related-posts">
					  <?php if (count($user->questions) > 1) { ?>
						<?php foreach ($user->questions as $related) { ?>
							<li class="related-item">
							<h3><a href="<?php echo $root . 'question/' . $related->Id ?>"><i class="icon-double-angle-right"></i><?php echo $related->Title; ?></a></h3>
							</li>
						<?php } ?>
					  <?php } else { ?>
					  	<h3><?php echo $user->DisplayName . " hasn't asked any questions yet"; ?></h3>
					  <?php } ?>
					</ul>
				</div>
			</div>
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
				
				<div class="widget widget_login">
					<h3 class="widget_title">Login</h3>
					<div class="form-style form-style-2">
						<form method="post" action="<?php echo $root . 'account/loguser' ?>">
							<div class="form-inputs clearfix">
								<p class="login-text">
									<input id="Username" name="Username" type="text" value="Username" onfocus="if (this.value == 'Username') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Username';}">
									<i class="icon-user"></i>
								</p>
								<p class="login-password">
									<input id="Password" name="Password" type="password" value="Password" onfocus="if (this.value == 'Password') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Password';}">
									<i class="icon-lock"></i>
								</p>
							</div>
							<p class="form-submit login-submit">
								<input type="submit" value="Log in" class="button color small login-submit submit">
							</p>
							<div class="rememberme">
								<label><input type="checkbox" checked="checked"> Remember Me</label>
							</div>
						</form>
						<ul class="login-links login-links-r">
							<li><a href="#">Register</a></li>
						</ul>
						<div class="clearfix"></div>
					</div>
				</div>
				
				<div class="widget widget_highest_points">
					<h3 class="widget_title">Highest points</h3>
					<ul>
						<?php foreach ($top as $item) { ?>
							<li>
								<div class="author-img">
									<a href="<?php echo $root . 'users/profile/' . $item->UserId; ?>"><img width="60" height="60" src="<?php echo $item->UserImage ?>" alt="<?php echo $item->DisplayName ?>"></a>
								</div> 
								<h6><a href="<?php echo $root . 'users/profile/' . $item->UserId; ?>"><?php echo $item->DisplayName ?></a></h6>
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