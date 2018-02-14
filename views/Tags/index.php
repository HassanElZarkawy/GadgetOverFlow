<?php $tags = $viewModel->get('tags'); ?>
<div class="page-content page-content-user-profile">
    <div class="user-profile-widget">
      <h2>Tags</h2>
      <div class="ul_list ul_list-icon-ok">
          <ul>
            <?php foreach ($tags as $tag) { ?>
              <div class="col-md-3">
                <li> 
                  <i class="icon-question-sign"></i> 
                  <div class="tooltip">
                      <a href="<?php echo $root . 'tags/all/' . $tag->Id; ?>"><?php echo $tag->Name ?></a>
                      <span class="tooltiptext"><?php echo number_format($tag->Has) . ' questions' ?></span>
                  </div>
                  
                </li>
              </div>
            <?php } ?>
          </ul>
      </div>
    </div>
</div>

<style>
.user-profile-widget li, .user-profile-widget li a {
     color: #ff7361 !important; 
}

.user-profile-widget .ul_list li {
    width: 100% !important;
}

.tooltip {
    position: relative;
    display: inline-block;
    /*border-bottom: 1px dotted black;*/
}

.tooltip .tooltiptext {
    visibility: hidden;
    width: 120px;
    background-color: #555;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 5px 0;
    position: absolute;
    z-index: 1;
    bottom: 125%;
    left: 50%;
    margin-left: -60px;
    opacity: 0;
    transition: opacity 1s;
}

.tooltip .tooltiptext::after {
    content: "";
    position: absolute;
    top: 100%;
    left: 50%;
    margin-left: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: #555 transparent transparent transparent;
}

.tooltip:hover .tooltiptext {
    visibility: visible;
    opacity: 1;
}
</style>