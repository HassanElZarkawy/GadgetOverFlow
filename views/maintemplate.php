<?php $root = 'http://gadgetoverflow.ga/'; $mq = NULL; ?>

  <!DOCTYPE html>
  <!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
  <!--[if IE 9 ]><html class="ie ie9" lang="en"> <![endif]-->
  <!--[if (gte IE 9)|!(IE)]><!-->
  <html lang="en" itemscope itemtype="http://schema.org/QAPage">
  <!--<![endif]-->

  <head>

    <!-- Basic Page Needs -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="google-site-verification" content="RshXIk6vl8UICv1qyQPJW_fOlCuQ9DNj4TCO3x2efA4" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:domain" content="gadgetoverflow.ga">
    <meta name="robots" content="index, follow" />
    <meta name="copyright" content="Gadget Overflow" />
    <?php if (statics::$question !== null) { ?>
      <meta name="twitter:title" property="og:title" itemprop="title name" content="<?php echo statics::$question->Title ?>">
      <meta name="twitter:description" property="og:description" itemprop="description" content="<?php echo substr(strip_tags(statics::$question->Body), 0, 157) . '...'?>">
      <meta property="og:url" content="<?php echo $root . 'question/' . statics::$question->Id ?>">
      <meta name="Description" content="<?php echo substr(strip_tags(statics::$question->Body), 0, 157) . '...'?>" />

      <meta name="author" content="<?php echo statics::$question->DisplayName ?>" />

    <?php } else { ?>
      <meta name="description" content="A Q&A Website dedicated to all kinds of electronics and software problems.">
      <meta name="twitter:title" property="og:title" itemprop="title name" content="Welcome | Gadget Overflow">
      <meta property="og:url" content="gadgetoverflow.ga">
    <?php } ?>
    <title>Gadget Overflow</title>
    <link rel="stylesheet" href="<?php echo $root; ?>assets/css/bootstrap.min.css">
    <script src="<?php echo $root; ?>assets/js/jquery.min.js"></script>
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Mobile Specific Metas -->
    

    <!-- Main Style -->
    <link rel="stylesheet" href="<?php echo $root; ?>assets/style.css">

    <!-- Skins -->
    <link rel="stylesheet" href="<?php echo $root; ?>assets/css/skins/skins.css">

    <!-- Responsive Style -->
    <link rel="stylesheet" href="<?php echo $root; ?>assets/css/responsive.css">

    <!-- Favicons -->
    <link rel="shortcut icon" href="">

  </head>

  <body>

    <div class="loader">
      <div class="loader_html"></div>
    </div>

    <div id="wrap">
      <div id="header-top">
        <section class="container clearfix">
          <nav class="header-top-nav">
            <ul>
              <?php if (User::Instance()->isLogged()) { ?>
                <li><a href="<?php echo $root; ?>account/logout" id="login-panel"><i class="icon-user"></i>Logout</a></li>
              <?php } else { ?>
                <li><a href="<?php echo $root; ?>account/login" id="login-panel"><i class="icon-user"></i>Login</a></li>
              <?php } ?>
            </ul>
          </nav>
          <div class="header-search">
            <form>
              <input type="text" value="Search here ..." onfocus="if(this.value=='Search here ...')this.value='';" onblur="if(this.value=='')this.value='Search here ...';">
              <button type="submit" class="search-submit"></button>
            </form>
          </div>
        </section>
        <!-- End container -->
      </div>
      <!-- End header-top -->
      <header id="header">
        <section class="container clearfix">
          <div class="logo">
            <!--<img alt="" src="images/logo.png">-->
            <a href="<?php echo $root; ?>"><strong style="font-size: 1.4em;">Gadget Overflow</strong></a>
          </div>
          <nav class="navigation">
            <ul>
              <li><a href="<?php echo $root; ?>">Home</a></li>
              <li><a href="<?php echo $root . 'questions/recent' ?>">Questions</a>
                <ul>
                  <li><a href="<?php echo $root . 'questions/recent' ?>">New Questions</a></li>
                  <li><a href="<?php echo $root . 'questions/mostViewed' ?>">Most Viewed</a></li>
                  <li><a href="<?php echo $root . 'questions/mostAnswered' ?>">Most Answered</a></li>
                </ul>
              </li>
              <li class="ask_question"><a href="<?php echo $root . 'question/ask' ?>">Ask Question</a></li>
              <li class="ask_question"><a href="<?php echo $root . 'users'; ?>">Users</a></li>
              <li class="ask_question"><a href="<?php echo $root . 'tags' ?>">Tags</a></li>
              <?php if (User::Instance()->isLogged()) { $user = User::Instance()->Current(); ?>
                <li><a href="<?php echo $root . 'me/' ?>"><?php echo $user->DisplayName; ?></a>
                  <ul>
                    <li><a href="<?php echo $root . 'me/' ?>">My Profile</a></li>
                    <li><a href="<?php echo $root . 'me/edit' ?>">Edit Profile</a></li>
                    <li><a href="<?php echo $root . 'account/logout' ?>">Logout</a></li>
                  </ul>
                </li>
              <?php } else { ?>
                <li><a href="<?php echo $root; ?>account/login">Login</a></li>
                <li><a href="<?php echo $root; ?>account/register">Register</a></li>
              <?php } ?>
            </ul>
          </nav>
        </section>
        <!-- End container -->
      </header>
      <!-- End header -->

      <?php if ($_GET['controller'] === 'home' || $_GET['controller'] === "") { ?>

        <div class="section-warp ask-me">
          <div class="container clearfix">
            <div class="box_icon box_warp box_no_border box_no_background" box_border="transparent" box_background="transparent" box_color="#FFF">
              <div class="row">
                <div class="col-md-12">
                  <h2>Welcome to <strong> Gadget Overflow </strong></h2>
                  <div class="clearfix"></div>
                  <?php if (!User::Instance()->isLogged()) { ?>
                    <a class="color button dark_button medium" href="<?php echo $root; ?>account/login">Join Now</a>
                  <?php } ?>
                  <div class="clearfix"></div>
                  <form class="form-style form-style-2">
                    <p>
                      <input type="text" id="question_title" value="Ask any question and you be sure find your answer ?" onfocus="if(this.value=='Ask any question and you be sure find your answer ?')this.value='';" onblur="if(this.value=='')this.value='Ask any question and you be sure find your answer ?';">
                      <i class="icon-pencil"></i>
                      <span class="color button small publish-question">Ask Now</span>
                    </p>
                  </form>
                </div>
              </div>
              <!-- End row -->
            </div>
            <!-- End box_icon -->
          </div>
          <!-- End container -->
        </div>
        <!-- End section-warp -->

      <?php } else { ?>

          <div class="section-warp ask-me">
            <div class="container clearfix">
            </div>
          </div>

      <?php } ?>

      <section class="container main-content">
         <?php require($this->viewFile); ?>
      </section>
      <!-- End container -->

      <footer id="footer">
        <section class="container">
          <div class="row">
            <div class="col-md-4">
              <div class="widget">
                <h3 class="widget_title">Quick Links</h3>
                <ul>
                  <li><a href="<?php echo $root; ?>">Home</a></li>
                  <li><a href="<?php echo $root . 'question/ask' ?>">Ask Question</a></li>
                  <li><a href="<?php echo $root . 'questions/mostViewed' ?>">Most Viewed</a></li>
                  <li><a href="<?php echo $root . 'questions/mostAnswered' ?>">Most Answered</a></li>
                  <li><a href="<?php echo $root . 'users' ?>">Users</a></li>
                </ul>
              </div>
            </div>
            <div class="col-md-4">
              <div class="widget">
                <h3 class="widget_title">Popular Questions</h3>
                <ul class="related-posts">
                  <?php foreach (Repository::home(3) as $item) { ?>
                  <li class="related-item">
                    <h3><a href="<?php echo $root . 'question/' . $item->qId ?>"><?php echo $item->Title ?></a></h3>
                    <p><?php echo substr(strip_tags($item->Body), 0, 100) . '...' ?></p>
                    <div class="clear"></div><span><?php echo Utility::time2str($item->CreationDate); ?></span>
                  </li>
                  <?php } ?>
                </ul>
              </div>
            </div>
            <div class="col-md-4">
              <div class="widget widget_twitter">
                <h3 class="widget_title">Latest Tweets</h3>
                <div class="tweet_1"></div>
              </div>
            </div>
          </div>
          <!-- End row -->
        </section>
        <!-- End container -->
      </footer>
      <!-- End footer -->
      <footer id="footer-bottom">
        <section class="container">
          <div class="copyrights f_left">Copyright 2012 Gadget Overflow | <a>By Global-Soft</a></div>
          <!-- End social_icons -->
        </section>
        <!-- End container -->
      </footer>
      <!-- End footer-bottom -->
    </div>
    <!-- End wrap -->

    <div class="go-up"><i class="icon-chevron-up"></i></div>

    <!-- js -->
    <script src="<?php echo $root; ?>assets/js/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="<?php echo $root; ?>assets/js/html5.js"></script>
    <script src="<?php echo $root; ?>assets/js/jquery.inview.min.js"></script>
    <script src="<?php echo $root; ?>assets/js/jquery.tipsy.js"></script>
    <script src="<?php echo $root; ?>assets/js/tabs.js"></script>
    <script src="<?php echo $root; ?>assets/js/jquery.prettyPhoto.js"></script>
    <script src="<?php echo $root; ?>assets/js/jquery.carouFredSel-6.2.1-packed.js"></script>
    <script src="<?php echo $root; ?>assets/js/jquery.scrollTo.js"></script>
    <script src="<?php echo $root; ?>assets/js/jquery.nav.js"></script>
    <script src="<?php echo $root; ?>assets/js/tags.js"></script>
    <script src="<?php echo $root; ?>assets/js/custom.js"></script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-79329807-7"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-79329807-7');
    </script>

    <!-- End js -->

  </body>

  </html>