<?php session_start(); ?>

<!DOCTYPE HTML>

<?php
/*
===========================================================================

	Powered by: DevByBit
	Site: devbybit.com
	Date: 2/18/2024 22:31 PM
	Author: Vuhp
	Documentation: docs.devbybit.com

===========================================================================
*/

require_once('config.php');
require_once('function.php');

if (DEBUGG) {
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
}
$uri = $_SERVER['REQUEST_URI'];
$uri = str_replace('/test/', '', $uri);
$uri = ltrim($uri, '/');
$page = explode('/', $uri);
$codeAuth = explode('?', $uri);
$subpage = explode('/', $codeAuth[0]);

if (isset($_SESSION[$dbb_user]) AND !isset($_COOKIE[$dbb_user])) {
	setcookie('dbb_user', $_SESSION[$dbb_user]['g_id'], time() + 3600*24*30, '/');
    setcookie('dbb_user_name', $_SESSION[$dbb_user]['name'], time() + 3600*24*30, '/');
    setcookie('dbb_user_email', $_SESSION[$dbb_user]['email'], time() + 3600*24*30, '/');
    setcookie('dbb_user_avatar', $_SESSION[$dbb_user]['avatar'], time() + 3600*24*30, '/');
} else if (isset($_SESSION[$dbb_user]) AND $_SESSION[$dbb_user]['g_id'] != $_COOKIE[$dbb_user]) {
	setcookie('dbb_user', $_SESSION[$dbb_user]['g_id'], time() + 3600*24*30, '/');
    setcookie('dbb_user_name', $_SESSION[$dbb_user]['name'], time() + 3600*24*30, '/');
    setcookie('dbb_user_email', $_SESSION[$dbb_user]['email'], time() + 3600*24*30, '/');
    setcookie('dbb_user_avatar', $_SESSION[$dbb_user]['avatar'], time() + 3600*24*30, '/');
}


if ($uri === '' || substr($uri, -1) === '/') {
    $archivo = __DIR__ . '/views/index.php';

	if (isset($_SESSION[$dbb_user])) {
		echo '<script> location.href="' . URI . '/license"; </script>';
	}
} else {
    $archivo = __DIR__ . '/views/' . $uri . '.php';
	
	if (!isset($_SESSION[$dbb_user]) AND $page[0] != '' AND $subpage[0] != '') {
		echo '<script> location.href="' . URI . '"; </script>';
	}
}

if ($uri === '' || substr($uri, -1) === '/' OR $subpage[0] === '') {
	$page_title = 'Auth';
} else if ($page[0] == 'license' OR $subpage[0] == 'license') {
	$license_id_tab = (!empty($page[1]) AND $page[1] != 'new') ? '#' . $subpage[1] : '';
	$page_title = ($page[1] == 'new' OR $subpage[1] == 'new') ? 'New License' : (($page[2] == 'edit' OR $subpage[2] == 'edit') ? 'Edit License ' . $license_id_tab : (($page[2] == 'delete' OR $subpage[2] == 'delete') ? 'Deleting License ' . $license_id_tab : 'License ' . $license_id_tab));
} else if ($page[0] == 'group' OR $subpage[0] == 'group') {
	$group_id_tab = (!empty($page[1]) AND $page[1] != 'new') ? '#' . $subpage[1] : '';
	$page_title = ($page[1] == 'new' OR $subpage[1] == 'new') ? 'New Group' : (($page[2] == 'edit' OR $subpage[2] == 'edit') ? 'Edit Group ' . $group_id_tab : (($page[2] == 'delete' OR $subpage[2] == 'delete') ? 'Deleting Group ' . $group_id_tab : 'Group ' . $group_id_tab));
} else if ($page[0] == 'user' OR $subpage[0] == 'user') {
	$user_id_tab = (!empty($page[1]) AND $page[1] != 'new') ? '#' . $subpage[1] : '';
	$page_title = ($page[2] == 'delete' OR $subpage[2] == 'delete') ? 'Deleting User ' . $user_id_tab : (($page[1] != 'new' OR $subpage[1] != 'new') ? 'User ' . $user_id_tab : 'User');
} else {
	$page_title = '404';
}
    ?>
<html lang="en">
    <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
	<meta content="DevByBit" name="basetitle">
	<title><?php echo SOFTWARE; ?> | <?php echo $page_title; ?></title>
	<meta name="title" content="DevByBit - Mito Software" />
	<meta name="description" content="A professional licensing system aims to protect all your products and provide you with ease of use. Exactly Mito Software" />

	<meta property="og:type" content="website" />
	<meta property="og:url" content="<?php echo URI; ?>" />
	<meta property="og:title" content="DevByBit - Mito Software" />
	<meta property="og:description" content="A professional licensing system aims to protect all your products and provide you with ease of use. Exactly Mito Software" />
	<meta property="og:image" content="https://devbybit.com/img/logo.png" />
	<meta property="twitter:card" content="summary_large_image" />
	<meta property="twitter:url" content="<?php echo URI; ?>" />
	<meta property="twitter:title" content="DevByBit - Mito Software" />
	<meta property="twitter:description" content="A professional licensing system aims to protect all your products and provide you with ease of use. Exactly Mito Software" />
	<meta property="twitter:image" content="https://devbybit.com/img/logo.png" />

    <link rel="icon" href="https://devbybit.com/img/logo.png" type="image/x-icon" />
	
    <link href="https://devbybit.com/demos/tablerio/dist/css/tabler.min.css?1684106062" rel="stylesheet"/>
    <link href="https://devbybit.com/demos/tablerio/dist/css/tabler-flags.min.css?1684106062" rel="stylesheet"/>
    <link href="https://devbybit.com/demos/tablerio/dist/css/tabler-payments.min.css?1684106062" rel="stylesheet"/>
    <link href="https://devbybit.com/demos/tablerio/dist/css/tabler-vendors.min.css?1684106062" rel="stylesheet"/>
    <link href="https://devbybit.com/demos/tablerio/dist/css/demo.min.css?1684106062" rel="stylesheet"/>
    <link href="https://devbybit.com/demos/tablerio/dist/libs/dropzone/dist/dropzone.css?1684106062" rel="stylesheet"/>
    <script src="https://devbybit.com/demos/tablerio/dist/libs/dropzone/dist/dropzone-min.js?1684106062" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
	<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
	<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
	
	<script src="https://apis.google.com/js/platform.js" async defer></script>
	<meta name="google-signin-client_id" content="<?php echo GOOGLE_CLIENT_ID; ?>">
	
	<script>
	var site_domain = '<?php echo URI; ?>';
	var URI = '<?php echo URI; ?>';
	document.addEventListener('DOMContentLoaded', function() {
	
		window.dropAccount = function() {
			$.ajax({
				type: "POST",
				url: site_domain + '/execute/action.php',
				data: { result: 'logout' },
				success: function(response) {
					location.reload();
				}
			});
		}
	});
	function str_replace(var1, var2, text) {
		var regex = new RegExp(var1, 'g');
		var newText = text.replace(regex, var2);
		return newText;
	}
	function str_replaces(var1, var2, text) {
		for (var i = 0; i < var1.length; i++) {
			var regex = new RegExp(var1[i], 'g');
			text = text.replace(regex, var2[i]);
		}
		return text;
	}
	
	function copyText(text) {
		var input = document.createElement('input');
		input.setAttribute('value', text);
		document.body.appendChild(input);
		input.select();
		var result = document.execCommand('copy');
		document.body.removeChild(input);
		swal('Copied correctly!', '', 'success');
		return result;
	}
	</script>
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
	  
.search-container {
  position: relative;
}

[data-bs-theme="dark"] .search-results {
	background: #000 !important;
}
.search-results {
  list-style-type: none;
  padding: 0;
  margin: 0;
  position: absolute;
  top: 100%;
  width: 100%;
  box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
  display: none;
  background: #fff;
  z-index: 99;
  max-height: 200px; 
  overflow-y: auto;
}

.search-results li {
  margin: 5px;
  padding: 10px;
  border: 1px solid rgba(153, 153, 153, 1) 75%;
  cursor: pointer;
}

.search-results li:hover {
  background: linear-gradient(225deg, #2e4cb01f, #2f74dc36);
}
</style>
    </head>
    <body>

    <script src="https://devbybit.com/demos/tablerio/dist/js/demo-theme.min.js?1684106062"></script>
    <div class="page">
		<?php if (isset($_SESSION[$dbb_user])) { ?>
      <header class="navbar navbar-expand-md d-print-none" >
        <div class="container-xl">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <a href="<?php echo URI; ?>">
              <img src="https://devbybit.com/img/logo.png" width="32" height="32" alt="DevByBit">
            </a>
          </h1>
          <div class="navbar-nav flex-row order-md-last">
            <div class="nav-item d-none d-md-flex me-3">
              <div class="btn-list">
                <a href="https://docs.devbybit.com/license-softwares/soroly" class="btn" target="_blank" rel="noreferrer">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-type-doc" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" /><path d="M5 15v6h1a2 2 0 0 0 2 -2v-2a2 2 0 0 0 -2 -2h-1z" /><path d="M20 16.5a1.5 1.5 0 0 0 -3 0v3a1.5 1.5 0 0 0 3 0" /><path d="M12.5 15a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1 -3 0v-3a1.5 1.5 0 0 1 1.5 -1.5z" /></svg>
                  Docs
                </a>
              </div>
            </div>
            <div class="d-none d-md-flex me-3">
              <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Enable dark mode" data-bs-toggle="tooltip" data-bs-placement="bottom">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" /></svg>
              </a>
              <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode" data-bs-toggle="tooltip" data-bs-placement="bottom">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" /></svg>
              </a>
            </div>
			
            <div class="nav-item dropdown">
              <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                <span class="avatar avatar-sm" style="background-image: url(<?php echo $_SESSION[$dbb_user]['avatar']; ?>)"></span>
                <div class="d-none d-xl-block ps-2">
                  <div><?php echo $_SESSION[$dbb_user]['name']; ?></div>
                  <div class="mt-1 small text-muted"><?php echo rank('name'); ?></div>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
			  
					<h6 class="dropdown-header">Signed in as</h6>
					<a href="<?php echo URI; ?>/user/<?php echo $_SESSION[$dbb_user]['id']; ?>" class="dropdown-item <?php echo ($page[0] == 'user' AND $page[1] == $_SESSION[$dbb_user]['id']) ? 'active' : ''; ?>">
						<span class="avatar avatar-xs rounded me-2" style="background-image: url(<?php echo $_SESSION[$dbb_user]['avatar']; ?>)"></span> <?php echo $_SESSION[$dbb_user]['name']; ?>
					</a>
					<div class="dropdown-divider"></div>
					<h6 class="dropdown-header">Actions</h6>
					<a href="?theme=dark" class="dropdown-item d-md-none hide-theme-dark">Switch Theme</a>
					<a href="?theme=light" class="dropdown-item d-md-none hide-theme-light">Switch Theme</a>
					<a href="#" onClick="dropAccount();" class="dropdown-item">Logout</a>
              </div>
            </div>
          </div>
		  <div class="collapse navbar-collapse" id="navbar-menu">
            <div class="d-flex flex-column flex-md-row flex-fill align-items-stretch align-items-md-center">
                <ul class="navbar-nav">
					
                    <li class="nav-item <?php echo ul_page($page[0], 'license'); ?> <?php echo ul_page($codeAuth[0], 'license'); ?>">
                        <a class="nav-link" href="<?php echo URI; ?>/license">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
								<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-key" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16.555 3.843l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.643 2.643a2.877 2.877 0 0 1 -4.069 0l-.301 -.301l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.877 2.877 0 0 1 0 -4.069l2.643 -2.643a2.877 2.877 0 0 1 4.069 0z" /><path d="M15 9h.01" /></svg>
                            </span>
							<span class="nav-link-title">License</span>
                        </a>
                    </li>
					<?php if (has('dbb.soroly.group.*') OR has('dbb.soroly.group')) { ?>
                    <li class="nav-item <?php echo ul_page($page[0], 'group'); ?> <?php echo ul_page($codeAuth[0], 'group'); ?>">
                        <a class="nav-link" href="<?php echo URI; ?>/group">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
								<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 7v13h-10v-13l5 -3z" /><path d="M10 13l2 -1l2 1" /><path d="M10 17l2 -1l2 1" /><path d="M10 9l2 -1l2 1" /></svg>
                            </span>
							<span class="nav-link-title">Group</span>
                        </a>
                    </li>
					<?php } ?>
					<?php if (has('dbb.soroly.user.*') OR has('dbb.soroly.user')) { ?>
                    <li class="nav-item <?php echo ul_page($page[0], 'user'); ?> <?php echo ul_page($codeAuth[0], 'user'); ?>">
                        <a class="nav-link" href="<?php echo URI; ?>/user">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
								<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg>
                            </span>
							<span class="nav-link-title">User</span>
                        </a>
                    </li>
					<?php } ?>
					
                </ul>
            </div>
          </div>
        </div>
      </header>
	  <?php if ($page[0] != 'user' AND $codeAuth[0] != 'user') { ?>
      <header class="navbar-expand-md">
        <div class="collapse navbar-collapse" id="navbar-menu">
          <div class="navbar">
            <div class="container-xl">
              <ul class="navbar-nav">
				<?php if ($page[0] == 'license' OR $codeAuth[0] == 'license') { ?>
                <li class="nav-item <?php echo ul_page($page[1], ''); ?> <?php echo ul_page($codeAuth[0], ''); ?>">
                  <a class="nav-link" href="<?php echo URI; ?>/license" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
						<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 5a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-14z" /><path d="M3 10h18" /><path d="M10 3v18" /></svg>
                    </span>
                    <span class="nav-link-title">Table</span>
                  </a>
                </li>
				<?php if (has('dbb.soroly.license.*') OR has('dbb.soroly.license.new')) { ?>
                <li class="nav-item <?php echo ul_page($page[1], 'new'); ?> <?php echo ul_page($codeAuth[0], 'license/new'); ?>">
                  <a class="nav-link" href="<?php echo URI; ?>/license/new">
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
						<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 12h6" /><path d="M12 9v6" /><path d="M6 19a2 2 0 0 1 -2 -2v-4l-1 -1l1 -1v-4a2 2 0 0 1 2 -2" /><path d="M18 19a2 2 0 0 0 2 -2v-4l1 -1l-1 -1v-4a2 2 0 0 0 -2 -2" /></svg>
                    </span>
					<span class="nav-link-title">New Key</span>
                  </a>
                </li>
				<?php } ?>
				
				<?php if (has('dbb.soroly.license.*') OR has('dbb.soroly.license')) { ?>
                <li class="nav-item <?php echo ul_page($page[1], 'admin'); ?> <?php echo ul_page($codeAuth[0], 'license/admin'); ?>">
                  <a class="nav-link" href="<?php echo URI; ?>/license/admin">
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
						<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 6l4 6l5 -4l-2 10h-14l-2 -10l5 4z" /></svg>
                    </span>
					<span class="nav-link-title">Admin Mode</span>
                  </a>
                </li>
				<?php } ?>
				<?php if ($page[1] != '' AND ($subpage[1] != 'admin' AND $subpage[1] != 'new')) { ?>
                <li class="nav-item active">
                  <a class="nav-link" href="<?php echo URI; ?>/license/<?php echo $page[1]; ?>">
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
						<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16.555 3.843l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.643 2.643a2.877 2.877 0 0 1 -4.069 0l-.301 -.301l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.877 2.877 0 0 1 0 -4.069l2.643 -2.643a2.877 2.877 0 0 1 4.069 0z" /><path d="M15 9h.01" /></svg>
                    </span>
					<span class="nav-link-title">License #<?php echo $subpage[1]; ?></span>
                  </a>
                </li>
				<?php } ?>
				
				<?php } ?>
				<?php if ($page[0] == 'group' OR $codeAuth[0] == 'group') { ?>
                <li class="nav-item <?php echo ul_page($page[1], ''); ?> <?php echo ul_page($codeAuth[0], ''); ?>">
                  <a class="nav-link" href="<?php echo URI; ?>/group" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
						<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 5a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-14z" /><path d="M3 10h18" /><path d="M10 3v18" /></svg>
                    </span>
                    <span class="nav-link-title">Table</span>
                  </a>
                </li>
				<?php if (has('dbb.soroly.group.*') OR has('dbb.soroly.group.new')) { ?>
                <li class="nav-item <?php echo ul_page($page[1], 'new'); ?> <?php echo ul_page($codeAuth[0], 'group/new'); ?>">
                  <a class="nav-link" href="<?php echo URI; ?>/group/new">
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
						<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 12h6" /><path d="M12 9v6" /><path d="M6 19a2 2 0 0 1 -2 -2v-4l-1 -1l1 -1v-4a2 2 0 0 1 2 -2" /><path d="M18 19a2 2 0 0 0 2 -2v-4l1 -1l-1 -1v-4a2 2 0 0 0 -2 -2" /></svg>
                    </span>
					<span class="nav-link-title">New Group</span>
                  </a>
                </li>
				<?php } ?>
				<?php if ($page[1] != '' AND ($subpage[1] != 'admin' AND $subpage[1] != 'new' AND $subpage[1] != 'add')) { ?>
                <li class="nav-item active">
                  <a class="nav-link" href="<?php echo URI; ?>/group/<?php echo $page[1]; ?>">
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
						<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 7v13h-10v-13l5 -3z" /><path d="M10 13l2 -1l2 1" /><path d="M10 17l2 -1l2 1" /><path d="M10 9l2 -1l2 1" /></svg>
                    </span>
					<span class="nav-link-title">Group #<?php echo $subpage[1]; ?></span>
                  </a>
                </li>
				<?php } ?>
				<?php } ?>
				<?php if ($page[0] == '' AND $codeAuth[0] == '') { ?>
                <li class="nav-item <?php echo ul_page($pagename, 'home'); ?> <?php echo ul_page($codeAuth[0], 'home'); ?>">
                  <a class="nav-link" href="<?php echo URI; ?>" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l-2 0l9 -9l9 9l-2 0" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
                    </span>
                    <span class="nav-link-title">
                      Home
                    </span>
                  </a>
                </li>
				
				<?php } ?>
              </ul>
            </div>
          </div>
        </div>
      </header>	
	  <?php } ?>
		<?php } ?>
	<div class="page-wrapper">
		<div class="container-xl">
			<?php
				$subpages = ($subpage[0] == '') ? 'index' : $subpage[0];
				if (file_exists($archivo)) {
					require_once($archivo);
				} else if (file_exists(__DIR__ . '/views/' . $page[0] . '.php')) {
					require_once(__DIR__ . '/views/' . $page[0] . '.php');
				} else if (file_exists(__DIR__ . '/views/' . $subpages . '.php')) {
					require_once(__DIR__ . '/views/' . $subpages . '.php');
				} else {
					echo $page_not_found;
				}
			?>
			
		</div>
	</div>

	

        <footer class="footer footer-transparent d-print-none">
          <div class="container-xl">
            <div class="row text-center align-items-center flex-row-reverse">
              <div class="col-lg-auto ms-lg-auto">
                <ul class="list-inline list-inline-dots mb-0">
                  <li class="list-inline-item">
					  <a href="https://docs.devbybit.com/license-softwares/soroly" target="_blank" class="link-secondary" rel="noopener">
						<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-file-type-doc"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" /><path d="M5 15v6h1a2 2 0 0 0 2 -2v-2a2 2 0 0 0 -2 -2h-1z" /><path d="M20 16.5a1.5 1.5 0 0 0 -3 0v3a1.5 1.5 0 0 0 3 0" /><path d="M12.5 15a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1 -3 0v-3a1.5 1.5 0 0 1 1.5 -1.5z" /></svg>
						Documentation
					  </a>
				  </li>
                  <li class="list-inline-item">
					<a href="https://devbybit.com/discord" target="_blank" class="link-secondary" rel="noopener">
						<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-brand-discord"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 12a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" /><path d="M14 12a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" /><path d="M15.5 17c0 1 1.5 3 2 3c1.5 0 2.833 -1.667 3.5 -3c.667 -1.667 .5 -5.833 -1.5 -11.5c-1.457 -1.015 -3 -1.34 -4.5 -1.5l-.972 1.923a11.913 11.913 0 0 0 -4.053 0l-.975 -1.923c-1.5 .16 -3.043 .485 -4.5 1.5c-2 5.667 -2.167 9.833 -1.5 11.5c.667 1.333 2 3 3.5 3c.5 0 2 -2 2 -3" /><path d="M7 16.5c3.5 1 6.5 1 10 0" /></svg>
						Discord
					</a>
				  </li>
                </ul>
              </div>
              <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                <ul class="list-inline list-inline-dots mb-0">
                  <li class="list-inline-item">
                    Copyright &copy; 2024
                    <a href="https://devbybit.com/" class="link-secondary">DevByBit</a>.
                    All rights reserved.
                  </li>
                  <li class="list-inline-item">v<?php echo $version; ?></li>
                </ul>
              </div>
            </div>
          </div>
        </footer>
    </div>

    <script src="https://devbybit.com/demos/tablerio/dist/libs/apexcharts/dist/apexcharts.min.js?1684106062" defer></script>
    <script src="https://devbybit.com/demos/tablerio/dist/libs/jsvectormap/dist/js/jsvectormap.min.js?1684106062" defer></script>
    <script src="https://devbybit.com/demos/tablerio/dist/libs/jsvectormap/dist/maps/world.js?1684106062" defer></script>
    <script src="https://devbybit.com/demos/tablerio/dist/libs/jsvectormap/dist/maps/world-merc.js?1684106062" defer></script>
    <script src="https://devbybit.com/demos/tablerio/dist/js/tabler.min.js?1684106062" defer></script>
    <script src="https://devbybit.com/demos/tablerio/dist/js/demo.min.js?1684106062" defer></script>
  </body>
</html>
