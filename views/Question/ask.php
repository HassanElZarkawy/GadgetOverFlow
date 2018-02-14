<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<?php if (Tokenizer::exists('ask-error')) { ?>
  <div class="alert alert-success">
    <strong>Invalid Attempt: </strong> <?php echo Tokenizer::get('ask-error'); Tokenizer::delete('ask-error'); ?>
  </div>
  <br />
<?php } ?>

<div class="col-md-12">
  <div class="page-content ask-question">
	<div class="boxedtitle page-title"><h2>Ask Question</h2></div>
	<p></p>
	<div class="form-style form-style-3" id="question-submit">
  	  <form id="askform" name="askform" method="post" action="<?php echo $root; ?>question/postquestion">
		<div class="form-inputs clearfix">
	  	  <p>
			<label class="required">Question Title<span>*</span></label>
			<input type="text" id="questionTitle" name="questionTitle">
			<span class="form-description">Please choose an appropriate title for the question to answer it even easier .</span>
		  </p>
		  <p>
			<label>Tags</label>
			<input type="text" class="input" name="question_tags" id="question_tags" data-seperator=",">
			<span class="form-description">Please choose  suitable Keywords Ex : <span class="color">question , poll</span> .</span>
		  </p>
		  
		  
		  <div class="clearfix"></div>
		  <div class="poll_options">
		  	<p class="form-submit add_poll">
		      <button id="add_poll" type="button" class="button color small submit"><i class="icon-plus"></i>Add Field</button>
			</p>
			<ul id="question_poll_item">
			  <li id="poll_li_1">
			  	<div class="poll-li">
			  	  <p><input id="ask[1][title]" class="ask" name="ask[1][title]" value="" type="text"></p>
				  <input id="ask[1][value]" name="ask[1][value]" value="" type="hidden">
				  <input id="ask[1][id]" name="ask[1][id]" value="1" type="hidden">
				  <div class="del-poll-li"><i class="icon-remove"></i></div>
				  <div class="move-poll-li"><i class="icon-fullscreen"></i></div>
				</div>
			  </li>
			</ul>
			<script> var nextli = 2;</script>
			<div class="clearfix"></div>
		  </div>
		  <label>Attachment</label>
		  <div class="fileinputs">
		  	<input type="file" class="file" name="file" id="file">
		  	<div class="fakefile">
		      <button type="button" class="button small margin_0">Select file</button>
			  <span><i class="icon-arrow-up"></i>Browse</span>
			</div>
		  </div>
		</div>
		<div id="form-textarea">
		  <p>
		  	<label class="required">Details<span>*</span></label>
		  	<!--<textarea id="question-details" aria-required="true" cols="58" rows="8"></textarea>-->
		  	<span class="form-description">Type the description thoroughly and in detail .</span>
		  </p>
			<div id="editor" name="editor" style="height: 400px;"></div>
		</div>
		<p class="form-submit">
		  <input type="submit" id="publish-question" value="Publish Your Question" class="button color small submit">
		</p>
	  </form>
	</div>
  </div>
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
   $("#askform").on("submit", function () {
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
