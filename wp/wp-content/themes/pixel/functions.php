<?php
function login_logo() {
  echo '<style type="text/css">
    #login h1 a {
      background: url('.get_template_directory_uri().'/img/logo.png) no-repeat center;
      background-size: contain;
      width: 135px;
      height: 61px;
    }
  </style>';
}
add_action('login_head', 'login_logo');

