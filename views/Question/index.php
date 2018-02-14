<?php $doc = new DOMDocument(); $question = $viewModel->get('question'); $stats = $viewModel->get('stats'); $tags = $viewModel->get('tags'); $recent = $viewModel->get('recent'); ?>
  <div class="row">
    <div class="col-md-9">

      <div class="about-author clearfix">
        <div class="author-image">
          <a href="<?php echo $root . 'user/' . $question->UserId ?>" original-title="<?php echo $question->DisplayName ?>" class="tooltip-n"><img itemprop="image" alt="<?php echo $question->DisplayName ?>" src="<?php echo $question->UserImage; ?>"></a>
        </div>
        <div class="author-bio">
          <h4><a itemprop="creator" href="<?php echo $root . 'user/' . $question->UserId ?>" original-title="<?php echo $question->DisplayName ?>" class="tooltip-n"><?php echo $question->DisplayName; ?></a></h4>
          <div class="question-details">
            <span class="question-answered question-answered-done"><i class="icon-ok"></i><?php echo 'Questions Asked: ' . $question->TotalQuestions ?></span>
            <span class="question-favorite"><i class="icon-star"></i><?php echo 'points: ' . $question->Points; ?></span>
            <span class="question-comment"><a href="#respond"><i class="icon-comment"></i><?php echo $question->TotalAnswers; ?> Answer</a></span>
          </div>
          <?php  ?>
        </div>
      </div>

      <article class="question single-question question-type-normal" itemtype="http://schema.org/Article">
        <h2 itemprop="name">
          <?php echo $question->Title; ?>
        </h2>
        <a class="question-report">Report</a>
        <div class="question-type-main"><i class="icon-question-sign"></i>Question</div>
        <div class="question-inner">
          <div class="clearfix"></div>
          <div class="question-desc text">
            <?php echo $question->Body; ?>
          </div>
          <div class="question-details">
            <span class="question-answered question-answered-done"><i class="icon-ok"></i>solved</span>
            <span class="question-favorite"><i class="icon-star"></i>5</span>
          </div>
          <span itemprop="dateCreated" class="question-date"><i class="icon-time"></i><?php echo Utility::time2str($question->CreationDate); ?></span>
          <span class="question-comment"><a href="#respond"><i class="icon-comment"></i><?php echo $question->AnswerCount; ?> Answer</a></span>
          <span class="question-view"><i class="icon-user"></i><?php echo $question->ViewCount; ?> views</span>
          <span class="single-question-vote-result"><?php echo $question->UpVotes - $question->DownVotes; ?></span>
          <ul class="single-question-vote">
            <li><a href="#" class="single-question-vote-down" title="Dislike"><i class="icon-thumbs-down"></i></a></li>
            <li><a href="#" class="single-question-vote-up" title="Like"><i class="icon-thumbs-up"></i></a></li>
          </ul>
          <div class="clearfix"></div>
        </div>
      </article>

      <div id="related-posts">
        <h2>Related questions</h2>
        <ul class="related-posts">
          <?php foreach ($recent as $related) { ?>
            <li class="related-item">
              <h3><a href="<?php echo $root . 'question/' . $related->Id ?>"><i class="icon-double-angle-right"></i><?php echo $related->Title; ?></a></h3>
            </li>
          <?php } ?>
        </ul>
      </div>

      <div id="commentlist" class="page-content">
        <div class="boxedtitle page-title">
          <h2>Answers ( <span class="color"><?php echo $question->AnswerCount; ?></span> )</h2></div>
        <ol class="commentlist clearfix">
          <?php foreach($question->Answers as $item) { ?>
            <li class="comment">
              <div class="comment-body clearfix">
                <div class="avatar"><img alt="<?php echo $item->DisplayName ?>" src="<?php echo $item->UserImage ?>"></div>
                <div class="comment-text">
                  <div class="author clearfix">
                    <div class="comment-author"><a href="<?php echo $root . 'user/' . $item->UserId ?>"><?php echo $item->DisplayName ?></a></div>
                    <div class="comment-vote">
                      <ul class="question-vote">
                        <li>
                          <a href="#" class="question-vote-up" title="Like"></a>
                        </li>
                        <li>
                          <a href="#respond" class="question-vote-down" title="Dislike"></a>
                        </li>
                      </ul>
                    </div>
                    <span class="question-vote-result"><?php echo $item->UpVoteCount ?></span>
                    <div class="comment-meta">
                      <div class="date"><i class="icon-time"></i>
                        <?php echo Utility::time2str($item->CreationDate); ?>
                      </div>
                    </div>
                    <a class="comment-reply" href="#respond"><i class="icon-reply"></i>Reply</a>
                  </div>
                  <div class="text" itemprop="articleBody">
                    
                    <?php
                    
                      
                      $doc->loadHTML($item->Body);
                      echo $doc->saveHTML();
                    
                    ?>
                  </div>
                </div>
              </div>
            </li>
            <?php } ?>
        </ol>
      </div>

      <div id="respond" class="comment-respond page-content clearfix">
        <div class="boxedtitle page-title">
          <h2>Leave an answer</h2></div>
        <form action="<?php echo $root . 'question/postanswer/' . $question->Id; ?>" method="post" id="answerform" class="comment-form">
          
          <div id="respond-textarea">
            <p>
              <label class="required" for="comment">Comment<span>*</span></label>
              <!--<textarea id="comment" name="comment" aria-required="true" cols="58" rows="8"></textarea>-->
         			<div id="editor" name="editor" style="height: 400px;"></div>
            </p>
          </div>
          <p class="form-submit">
            <input name="submit" type="submit" id="submit" value="Post your answer" class="button small color">
          </p>
        </form>
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

      <div class="widget">
        <h3 class="widget_title">Recent Questions</h3>
        <ul class="related-posts">
          <?php foreach ($recent as $related) { ?>
          <li class="related-item">
            <h3><a href="<?php echo $root . 'question/' . $related->qId; ?>"><?php echo strip_tags($related->Title); ?></a></h3>
            <p><?php echo substr(strip_tags($related->Body), 0, 100) . '...' ?></p>
            <div class="clear"></div><span><?php echo Utility::time2str($related->CreationDate); ?></span>
          </li>
          <?php } ?>
        </ul>
      </div>
      <?php if (!User::Instance()->isLogged()) { ?>
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
              <ul class="login-links">
                <li><a href="<?php echo $root . 'account/register'; ?>">Register</a></li>
              </ul>
              <div class="clearfix"></div>
            </div>
        </div>
      <?php } ?>

      <div class="widget widget_tag_cloud">
        <h3 class="widget_title">Tags</h3>
        <?php $tags = $viewModel->get('tags'); ?>
        <?php foreach ($tags as $tag) { ?>
          <a href="<?php echo $root . 'tags/all/' . $tag->Id; ?>"><?php echo $tag->Name; ?></a>
        <?php } ?>
      </div>

      

    </aside>
  </div>
  <link href="https://cdn.quilljs.com/1.0.0/quill.snow.css" rel="stylesheet">
<link href="//cdn.quilljs.com/1.0.0/quill.bubble.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.0.0/quill.js"></script>

<script>
	var toolbarOptions = [
		['bold', 'italic', 'underline', 'strike'],        // toggled buttons
		['blockquote', 'code-block'],

		[{ 'header': 1 }, { 'header': 2 }],               // custom button values
		[{ 'list': 'ordered'}, { 'list': 'bullet' }],
		[{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
		[{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
		[{ 'direction': 'rtl' }],                         // text direction

		[{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
		[{ 'header': [1, 2, 3, 4, 5, 6, false] }],

		[{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
		[{ 'font': [] }],
		[{ 'align': [] }],

		['clean', 'image']                                         // remove formatting button
	];
  var editor = new Quill('#editor', {
    modules: {	
 	   toolbar: toolbarOptions,
  	},
		placeholder: 'Type the description thoroughly and in detail...',
		theme: 'snow'  // or 'bubble'
  });

	$(document).ready(function(){
   $("#answerform").on("submit", function () {
        var html = $('.ql-editor').html();
				var escapedHtml = html.replace(/&/g, '&amp;')
                      .replace(/>/g, '&gt;')
                      .replace(/</g, '&lt;')
                      .replace(/"/g, '&quot;')
                      .replace(/'/g, '&apos;');
        $(this).append("<input type='hidden' name='body' value=' " + escapedHtml + " '/>");
    });
	});
</script>
  <script>
    $(".text").children().each(function(i, elm) {
      if (elm.tagName.toLowerCase() === "pre") {
        elm.className += " computerGreen";
      }
    });
  </script>
  <style>
    pre {
    white-space: pre-wrap;
    white-space: -moz-pre-wrap;
    white-space: -o-pre-wrap;
    word-wrap: break-word;}

    code {
    font-family: Courier, 'New Courier', monospace !important;
    font-size: 12px !important;}

    #codeStyler {
    border-radius: 5px;
    -moz-border-radius: 5px;
    -webkit-border-radius: 5px;
    margin: 1em 0;}

    .computerGreen {
    background-color: #000000 !important;
    color: green !important;}
  </style>