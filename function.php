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
$devbybit = 'DevByBit';
$devbybit_link = 'https://devbybit.com';
$software = 'Soroly';
$version = '1.0';


switch (strtolower(DB_TYPE)) {
	case 'mysql':
		$connx = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_DATA, DB_USER, DB_PASSWORD);
		break;
	default:
		require_once('dbb_json.php');
		break;
}

$dbb_license = 'dbb_license';
$dbb_user = 'dbb_user';
$dbb_group = 'dbb_group';
$dbb_group_permission = 'dbb_group_permission';
$dbb_group_user = 'dbb_group_user';
$dbb_logs = 'dbb_logs';


function userInfo($query, $id) {
	require_once('config.php');
	global $dbb_user;
	$resultsArray = [];
	switch (strtolower(DB_TYPE)) {
		case 'mysql':
			global $connx;
			$docsSQL = $connx->prepare("SELECT * FROM `$dbb_user` WHERE `$query` = ?;");
			$docsSQL->execute([$id]);
			if ($docsSQL->RowCount() > 0) {
				while($doc = $docsSQL->fetch(PDO::FETCH_ASSOC)) {
					$resultsArray[] = $doc;
				}
			}
			break;
		default:
			$existing_data = json_decode(dbb_user, true);
			
			foreach ($existing_data as $key => $entry) {
				if ($entry[$query] == $id) {
					$resultsArray[] = $entry;
				}
			}
			
			break;
	}
	return $resultsArray[0];
	
}

function groupInfo($query, $id) {
	require_once('config.php');
	global $dbb_group;
	$resultsArray = [];
	switch (strtolower(DB_TYPE)) {
		case 'mysql':
			global $connx;
			$docsSQL = $connx->prepare("SELECT * FROM `$dbb_group` WHERE `$query` = ?;");
			$docsSQL->execute([$id]);
			if ($docsSQL->RowCount() > 0) {
				while($doc = $docsSQL->fetch(PDO::FETCH_ASSOC)) {
					$resultsArray[] = $doc;
				}
			}
			break;
		default:
			$existing_data = json_decode(dbb_group, true);
			
			foreach ($existing_data as $key => $entry) {
				if ($entry[$query] == $id) {
					$resultsArray[] = $entry;
				}
			}
			
			break;
	}
	return $resultsArray[0];
	
}

function groupUserInfo($query, $id, $subquery, $subid) {
	require_once('config.php');
	global $dbb_group_user;
	$resultsArray = [];
	switch (strtolower(DB_TYPE)) {
		case 'mysql':
			global $connx;
			$docsSQL = $connx->prepare("SELECT * FROM `$dbb_group_user` WHERE `$query` = ?;");
			$docsSQL->execute([$id]);
			if ($docsSQL->RowCount() > 0) {
				while($doc = $docsSQL->fetch(PDO::FETCH_ASSOC)) {
					$resultsArray[] = $doc;
				}
			}
			break;
		default:
			$existing_data = json_decode(dbb_group_user, true);
			
			foreach ($existing_data as $key => $entry) {
				if ($entry[$query] == $id && $entry[$subquery] == $subid) {
					$resultsArray[] = $entry;
				}
			}
			
			break;
	}
	return $resultsArray[0];
	
}

$user_ip = getUserIp();
function viewCountry($ip) {
    $country_api = json_decode(@file_get_contents('https://api.country.is/'. $ip));
    
    if ($country_api && isset($country_api->country)) {
        $country_dec = $country_api->country;
        
        $variable = array("A", "S", "D", "F", "G", "H", "J", "K", "L", "Q", "W", "E", "R", "T", "Y", "U", "I", "O", "P", "Z", "X", "C", "V", "B", "N", "M");
        $str_variable = array("a", "s", "d", "f", "g", "h", "j", "k", "l", "q", "w", "e", "r", "t", "y", "u", "i", "o", "p", "z", "x", "c", "v", "b", "n", "m");
        $country = str_replace($variable, $str_variable, $country_dec);
        
        return $country;
    } else {
        return "us";
    }
}


function customChar($length = 10, $chart = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ') {
    $characters = $chart;
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
$table_loader = '<div class="col-12">
                    <div class="card" style="border: 0px solid transparent !important;">
                      <ul class="list-group list-group-flush placeholder-glow">
                        <li class="list-group-item" style="border: 0px solid transparent !important;">
                          <div class="row align-items-center">
                            <div class="col-auto">
                              <div class="avatar avatar-rounded placeholder"></div>
                            </div>
                            <div class="col-7">
                              <div class="placeholder placeholder-xs col-9"></div>
                              <div class="placeholder placeholder-xs col-7"></div>
                            </div>
                            <div class="col-2 ms-auto text-end">
                              <div class="placeholder placeholder-xs col-8"></div>
                              <div class="placeholder placeholder-xs col-10"></div>
                            </div>
                          </div>
                        </li>
                        <li class="list-group-item" style="border: 0px solid transparent !important;">
                          <div class="row align-items-center">
                            <div class="col-auto">
                              <div class="avatar avatar-rounded placeholder"></div>
                            </div>
                            <div class="col-7">
                              <div class="placeholder placeholder-xs col-9"></div>
                              <div class="placeholder placeholder-xs col-7"></div>
                            </div>
                            <div class="col-2 ms-auto text-end">
                              <div class="placeholder placeholder-xs col-8"></div>
                              <div class="placeholder placeholder-xs col-10"></div>
                            </div>
                          </div>
                        </li>
                        <li class="list-group-item" style="border: 0px solid transparent !important;">
                          <div class="row align-items-center">
                            <div class="col-auto">
                              <div class="avatar avatar-rounded placeholder"></div>
                            </div>
                            <div class="col-7">
                              <div class="placeholder placeholder-xs col-9"></div>
                              <div class="placeholder placeholder-xs col-7"></div>
                            </div>
                            <div class="col-2 ms-auto text-end">
                              <div class="placeholder placeholder-xs col-8"></div>
                              <div class="placeholder placeholder-xs col-10"></div>
                            </div>
                          </div>
                        </li>
                        <li class="list-group-item" style="border: 0px solid transparent !important;">
                          <div class="row align-items-center">
                            <div class="col-auto">
                              <div class="avatar avatar-rounded placeholder"></div>
                            </div>
                            <div class="col-7">
                              <div class="placeholder placeholder-xs col-9"></div>
                              <div class="placeholder placeholder-xs col-7"></div>
                            </div>
                            <div class="col-2 ms-auto text-end">
                              <div class="placeholder placeholder-xs col-8"></div>
                              <div class="placeholder placeholder-xs col-10"></div>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>';

function randomCodes($length = 10) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function randomCode($length = 10, $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ') {
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


function dDelay($tiempoProhibicion, $mytime, $cookie) {

	$tiempoActual = time();

	$tiempoProhibicionCal = $tiempoProhibicion + $tiempoActual;

	if ($tiempoActual < $mytime) {
		return false;
	} else {
		setcookie($cookie, $tiempoProhibicionCal, time() + 3600*24*30, '/');
		return true;
	}
	
}

function getSerialNumber() {
    $hostName = php_uname('n');
    $uniqueId = $hostName;
    return $uniqueId;
}

function has($permission) {
    require_once('config.php');
	global $dbb_user;
	global $dbb_group;
	global $dbb_group_permission;
	global $dbb_group_user;
	switch (strtolower(DB_TYPE)) {
		case 'mysql':
			global $connx;
			
			$userVerify = $connx->prepare("SELECT * FROM `$dbb_user` WHERE `id` = ?;");
			$userVerify->execute([$_SESSION['dbb_user']['id']]);
			$user = $userVerify->fetch(PDO::FETCH_ASSOC);
			
			$defaultGroupSQL = $connx->prepare("SELECT * FROM `$dbb_group` WHERE `default` = '1';");
			$defaultGroupSQL->execute();
			if ($defaultGroup = $defaultGroupSQL->fetch(PDO::FETCH_ASSOC)) {
				$defhasSQL = $connx->prepare("SELECT * FROM `$dbb_group_permission` WHERE `group` = ? AND `permission` = ?;");
				$defhasSQL->bindParam(1, $defaultGroup['id']);
				$defhasSQL->bindParam(2, $permission);
				$defhasSQL->execute();
				if ($defhasSQL->fetch(PDO::FETCH_ASSOC)) return true; 
			}

			$verifyGroup = $connx->prepare("SELECT * FROM `$dbb_group_user` WHERE `user` = ?;");
			$verifyGroup->execute([$user['id']]);
			while ($group = $verifyGroup->fetch(PDO::FETCH_ASSOC)) {
				$hasAllSQL = $connx->prepare("SELECT * FROM `dbb_group_permission` WHERE `group` = ? AND `permission` = 'dbb.soroly.*';");
				$hasAllSQL->bindParam(1, $group['group']);
				$hasAllSQL->execute();
				if ($hasAllSQL->fetch(PDO::FETCH_ASSOC)) return true; 

				$hasSQL = $connx->prepare("SELECT * FROM `$dbb_group_permission` WHERE `group` = ? AND `permission` = ?;");
				$hasSQL->bindParam(1, $group['group']);
				$hasSQL->bindParam(2, $permission);
				$hasSQL->execute();
				if ($hasSQL->fetch(PDO::FETCH_ASSOC)) return true; 
			}
			
			break;
		default:
			require_once('dbb_json.php');

			$dbb_user_data = json_decode(dbb_user, true);
			$dbb_group_data = json_decode(dbb_group, true);
			$dbb_group_user_data = json_decode(dbb_group_user, true);
			$dbb_group_permission_data = json_decode(dbb_group_permission, true);
			
			$userId = $_SESSION[$dbb_user]['id'];
			$user = null;
			foreach ($dbb_user_data as $u) {
				if ($u['id'] == $userId) {
					$user = $u;
					break;
				}
			}
			if (!$user) {
				return false;
			}

			$defaultGroup = null;
			foreach ($dbb_group_data as $group) {
				if ($group['default'] == '1') {
					$defaultGroup = $group;
					break;
				}
			}
			if ($defaultGroup) {
				foreach ($dbb_group_permission_data as $perm) {
					if ($perm['group'] == $defaultGroup['id'] && $perm['permission'] == $permission) {
						return true;
					}
				}
			}

			$userGroups = [];
			foreach ($dbb_group_user_data as $groupUser) {
				if ($groupUser['user'] == $user['id']) {
					$userGroups[] = $groupUser['group'];
				}
			}

			foreach ($userGroups as $groupId) {
				foreach ($dbb_group_permission_data as $perm) {
					if ($perm['group'] == $groupId && $perm['permission'] == 'dbb.soroly.*') {
						return true;
					}
				}

				foreach ($dbb_group_permission_data as $perm) {
					if ($perm['group'] == $groupId && $perm['permission'] == $permission) {
						return true;
					}
				}
			}

			return false;
			break;
	}
    

    return false; 
}

function rank($option, $user = '') {
	require_once 'config.php';

	$users = (empty($user)) ? $_SESSION['dbb_user']['id'] : $user;
	$highestPosition = -1;
	$defaultGroup = null;
	$selectedGroup = null;
	switch (strtolower(DB_TYPE)) {
		case 'mysql':
			global $connx;

			$groupUserSQL = $connx->prepare("SELECT * FROM `dbb_group_user` WHERE `user` = ?;");
			$groupUserSQL->execute([$users]);
				
			$defaultGroupSQL = $connx->prepare("SELECT * FROM `dbb_group` WHERE `default` = '1' ORDER BY id DESC;");
			$defaultGroupSQL->execute([$groupUser['group']]);
			$defaultGroup = $defaultGroupSQL->fetch(PDO::FETCH_ASSOC);

			while ($groupUser = $groupUserSQL->fetch(PDO::FETCH_ASSOC)) {
				$verifyGroup = $connx->prepare("SELECT * FROM `dbb_group` WHERE `id` = ? ORDER BY id DESC;");
				$verifyGroup->execute([$groupUser['group']]);
				$group = $verifyGroup->fetch(PDO::FETCH_ASSOC);

				if ($group['id'] > $highestPosition) {
					$selectedGroup = $group;
				}
			}
			break;
		default:
			require_once('dbb_json.php');
			$dbb_user_data = json_decode(dbb_user, true);
			$dbb_group_data = json_decode(dbb_group, true);
			$dbb_group_user_data = json_decode(dbb_group_user, true);

			$user = null;

			foreach ($dbb_user_data as $u) {
				if ($u['id'] == $users) {
					$user = $u;
					break;
				}
			}
			if (!$user) {
				return false;
			}

			foreach ($dbb_group_data as $group) {
				if ($group['default'] == '1') {
					$defaultGroup = $group;
					break;
				}
			}

			$userGroups = [];
			foreach ($dbb_group_user_data as $groupUser) {
				if ($groupUser['user'] == $user['id']) {
					$userGroups[] = $groupUser['group'];
				}
			}

			foreach ($userGroups as $groupId) {
				foreach ($dbb_group_data as $group) {
					if ($group['id'] == $groupId && $group['id'] > $highestPosition) {
						$selectedGroup = $group;
					}
				}
			}
			break;
	}

	if ($selectedGroup !== null) {
		return $selectedGroup[$option]; 
	} else {
		return $defaultGroup[$option];
	}
}

function getUserIp() {

    $client = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote = $_SERVER['REMOTE_ADDR'];

    if (filter_var($client, FILTER_VALIDATE_IP)) {
        $ip = $client;
    } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
        $ip = $forward;
    } else {
        $ip = $remote;
    }
    return $ip;
} 

function ul_page($page, $name) {
	if ($page == $name) {
		return 'active';
	}
}
define('NO_VIEW', 0);
if (NO_VIEW) {
	$secret = '2qGQVFhUZq92Z.2QWbyH8LTrGfSaUSk7';
	$type = 'license';
	$key = LICENSE_KEY;

	$cookieName = 'license_cached';

		$url = 'https://devlicense.devbybit.com/api.php?secret=' . $secret . '&type=' . $type . '&key=' . $key . '&product=' . $software . '&version=' . $version;
		$response = file_get_contents($url);
		$data = json_decode($response, true);
		$valid = ($data['valid']) ? 1 : 0;
		$var = $data['var'];
		$custom_addons = explode('#', $data['addons']);
		$versions = $data['version'];
		
		$addons_updates = ($versions == 'W/O') ? 1 : 0;
		$new_version = ($versions == 'W/O') ? $version : $versions;
		
		$addons_bsd = (in_array('unlimited', $custom_addons)) ? 1 : 0;
		$debugg_errors = (in_array('view_errors', $custom_addons)) ? 1 : DEBUGG;
		$install_mode = (in_array('active_install_mode', $custom_addons)) ? 1 : INSTALL_MODE;
		$db_configs = (in_array('active_db_configs', $custom_addons)) ? 1 : DATABASE_CONFIG;
		
		if (!$valid) {
			$error_license = 1;
		}
		$cacheData = [
			'valid' => $valid,
			'var' => $var,
			'addons' => $custom_addons,
			'version' => $new_version,
			'timestamp' => time()
		];
	
	
	define('DEBUGG', $debugg_errors);
	define('INSTALL_MODE', $install_mode);
	define('DATABASE_CONFIG', $db_configs);
	
	
	$installation_design = '<div class="danger icon-demo-message">
			<div class="icon-demo-message-icon"><span><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-type-php" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" /><path d="M5 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" /><path d="M17 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" /><path d="M11 21v-6" /><path d="M14 15v6" /><path d="M11 18h3" /></svg></span></div>
			<div class="icon-demo-message-text">There are problems installing the blackout software. <br>Correctly check each component and you can see the <a href="https://docs.devbybit.com/blackout-license-software/" target="_BLANK">documentation</a>.</div>
			</div>';
	$old_version_design = '<div class="warning icon-demo-message">
			<div class="icon-demo-message-icon"><span><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-alert-hexagon" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19.875 6.27c.7 .398 1.13 1.143 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z" /><path d="M12 8v4" /><path d="M12 16h.01" /></svg></span></div>
			<div class="icon-demo-message-text">Oh, outdated version! We have uploaded a new version for blackout software. <br>Your version is ' . $version . '/' . $versions . ' and currently the most recent is ' . $new_version . ' <a href="https://docs.devbybit.com/blackout-license-software/version-history" target="_BLANK">Download</a></div>
			</div>';
	$database_design = '<div class="danger icon-demo-message">
			<div class="icon-demo-message-icon"><span><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-database-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 6c0 1.657 3.582 3 8 3s8 -1.343 8 -3s-3.582 -3 -8 -3s-8 1.343 -8 3" /><path d="M4 6v6c0 1.657 3.582 3 8 3c.537 0 1.062 -.02 1.57 -.058" /><path d="M20 13.5v-7.5" /><path d="M4 12v6c0 1.657 3.582 3 8 3c.384 0 .762 -.01 1.132 -.03" /><path d="M22 22l-5 -5" /><path d="M17 22l5 -5" /></svg></span></div>
			<div class="icon-demo-message-text">Blackout software detected some failure in the connection to the chosen database. <br> You can verify this problem if it exists in the <a href="https://docs.devbybit.com/blackout-license-software/" target="_BLANK">documentation</a>.</div>
			</div>';
	$discord_design = '<div class="danger icon-demo-message">
			<div class="icon-demo-message-icon"><span><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-discord" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 12a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" /><path d="M14 12a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" /><path d="M15.5 17c0 1 1.5 3 2 3c1.5 0 2.833 -1.667 3.5 -3c.667 -1.667 .5 -5.833 -1.5 -11.5c-1.457 -1.015 -3 -1.34 -4.5 -1.5l-.972 1.923a11.913 11.913 0 0 0 -4.053 0l-.975 -1.923c-1.5 .16 -3.043 .485 -4.5 1.5c-2 5.667 -2.167 9.833 -1.5 11.5c.667 1.333 2 3 3.5 3c.5 0 2 -2 2 -3" /><path d="M7 16.5c3.5 1 6.5 1 10 0" /></svg></span></div>
			<div class="icon-demo-message-text">There are problems that need to be corrected. The connection to the bot does not work. <br> Your software will not be able to support new user registrations or logins with Discord. <a href="https://docs.devbybit.com/blackout-license-software/installation/setting-up-the-bot" target="_BLANK">documentation</a>.</div>
			</div>';
	$license_design = '<div class="danger icon-demo-message">
			<div class="icon-demo-message-icon"><span><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-key-off" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.17 6.159l2.316 -2.316a2.877 2.877 0 0 1 4.069 0l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.33 2.33" /><path d="M14.931 14.948a2.863 2.863 0 0 1 -1.486 -.79l-.301 -.302l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.863 2.863 0 0 1 -.794 -1.504" /><path d="M15 9h.01" /><path d="M3 3l18 18" /></svg></span></div>
			<div class="icon-demo-message-text">Oh, The license doesn\'t work! We have detected that your key does not work from blackout software. <br>You can verify this by entering your <a href="https://devlicense.devbybit.com/" target="_BLANK">administration</a>.</div>
			</div>';
	$tebex_design = '<div class="danger icon-demo-message">
			<div class="icon-demo-message-icon"><span><img class="icon icon-tabler icon-tabler-key-off" style="width: 40px !important; height: 40px !important;" src="https://devlicense.devbybit.com/parent/img/tebex.png" alt="DevByBit"></span></div>
			<div class="icon-demo-message-text">You enabled the tebex purchase option, but it is not configured. <br>Start configuring it correctly with the blackout software <a href="https://devlicense.devbybit.com/" target="_BLANK">documentation</a>!</div>
			</div>';

	$errors = '';
	$var1_error = ["{error:install}", "{error:version}", "{error:database}", "{error:license}", "{error:discord}", "{error:tebex}"];
	$var2_error = [$installation_design, $old_version_design, $database_design, $license_design, $discord_design, $tebex_design];
	if (INSTALL_MODE) $errors .= '{error:install} ';
	if ($version != $new_version AND !$addons_updates) $errors .= '{error:version} ';
	if (!isset($connx) AND DATABASE_CONFIG) $errors .= '{error:database} ';
	if (!$valid) $errors .= '{error:license} ';
	if (empty(CLIENT_ID) OR empty(CLIENT_SECRET)) $errors .= '{error:discord} ';
	if (TEBEX_PAYMENT) {
		if (empty(TEBEX_PUBLIC_KEY) OR empty(TEBEX_WEBHOOK_SECRET)) $errors .= '{error:tebex} ';
	}
	$to_do = str_replace($var1_error, $var2_error, '<div class="icon-container">' . $errors . '</div>');
	echo ($to_do == '<div class="icon-container"></div>') ? '' : $to_do;
}


function counttime($date, $dates = 'datetime') {
	
	if ($dates == 'datetime') {
		$timestamp = strtotime($date);
	} else {
		$timestamp = $date;
	}
	
	$strTime=array('sec', 
	'min', 
	'hr', 
	'day', 
	'month', 
	'year');
	
	$strTimes=array('secs', 
	'mins', 
	'hrs', 
	'days', 
	'months', 
	'years');
	
	$length=array("60","60","24","30","12","10");
	$currentTime=time();
	if($currentTime >= $timestamp) { 
		$diff = time()- $timestamp; 
		for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) { 
			$diff = $diff / $length[$i]; 
		} 
		
		$diff = round($diff); 
		if ($diff > 1) { 
			$timeName = $strTimes[$i]; 
		} else { 
			$timeName = $strTime[$i]; 
		} 
		
		$type_lang = 2;
		if ($type_lang == 1) {
			return lang($messages, 'counttime', 'ago') . " ".$diff. " " .$timeName;
		} else if ($type_lang == 2) {
			return $diff." ".$timeName . " ago";
		}
	}
}
function counttimedown($timing, $msg, $date = 'time') {
	
	if ($date == 'time') {
		$info = date('Y-m-d H:i:s', $timing);
	} else {
		$info = $timing;
	}
	
	$end_time = new DateTime($info);
	$current_time = new DateTime();
	$interval = $current_time->diff($end_time);
	
	$textand = 'and';

	if ($interval->format("%a") == '0') {
		$timers = $interval->format("%hh, %im " . $textand . " %ss.");
	} else if ($interval->format("%h") == '0') {
		$timers = $interval->format("%im " . $textand . " %ss.");
	} else if ($interval->format("%i") == '0') {
		$timers = $interval->format("%ss.");
	} else {
		$timers = $interval->format("%ad, %hh, %im " . $textand . " %ss.");
	}
	
	if ($interval->invert) {
		$text = $msg;
	} else {
		$text = $timers;
	}
	
	return $text;
}


function countSince($date, $year = '') {
    global $messages;
	$monthNames = array(
		lang($messages, 'months', 'low', 'jan'),
		lang($messages, 'months', 'low', 'feb'),
		lang($messages, 'months', 'low', 'mar'),
		lang($messages, 'months', 'low', 'apr'),
		lang($messages, 'months', 'low', 'may'),
		lang($messages, 'months', 'low', 'jun'),
		lang($messages, 'months', 'low', 'jul'),
		lang($messages, 'months', 'low', 'aug'),
		lang($messages, 'months', 'low', 'sep'),
		lang($messages, 'months', 'low', 'oct'),
		lang($messages, 'months', 'low', 'nov'),
		lang($messages, 'months', 'low', 'dec'),
	);
	
    $timestamp = strtotime($date);
    if (empty($year)) $formattedDate = date('M j, Y', $timestamp);
    if (!empty($year)) $formattedDate = date('M j', $timestamp);
    $monthIndex = date('n', $timestamp) - 1;
    $formattedDate = str_replace(date('M', $timestamp), $monthNames[$monthIndex], $formattedDate);
    return $formattedDate;
}

function paginationButtons($TotalRegistro, $compag, $total, $action = 'updatePage') {
    $IncrimentNum = (($compag + 1) <= $TotalRegistro) ? ($compag + 1) : 1;
    $DecrementNum = (($compag - 1)) < 1 ? 1 : ($compag - 1);

    if (empty($action)) $action = 'updatePage'; else $action = $action;
	$prevClass = ($compag == 1 || $TotalRegistro < $total) ? 'disabled' : '';
	$nextClass = ($compag == $TotalRegistro || $TotalRegistro < $total) ? 'disabled' : '';
	echo '<li class="page-item ' . $prevClass . '">';
	echo '<a class="page-link" href="#" onclick="' . $action . '(\'' . $DecrementNum . '\'); event.preventDefault();">';
	echo '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>';
	echo 'prev';
	echo '</a>';
	echo '</li>';

    $Desde = max(1, $compag - floor($total / 2));
    $Hasta = min($TotalRegistro, $Desde + $total - 1);

    $maxButtons = 10;
    $halfMaxButtons = $maxButtons / 2;

    if ($TotalRegistro > $maxButtons) {
        $Offset = $compag - $halfMaxButtons;
        $Offset = max(1, $Offset);
        $Offset = min($Offset, $TotalRegistro - $maxButtons + 1);

        $Desde = $Offset;
        $Hasta = min($TotalRegistro, $Offset + $maxButtons - 1);
    }

    for ($i = $Desde; $i <= $Hasta; $i++) {
        $activeClass = ($i == $compag) ? 'active' : '';
		echo '<li class="page-item ' . $activeClass . '"><a class="page-link" href="#" onclick="' . $action . '(\'' . $i . '\'); event.preventDefault();">' . $i . '</a></li>';
    }

    $NextSet = min($TotalRegistro, $Hasta + 1 + $total);
	$nextPosition = $compag + 1;
    if ($NextSet <= $TotalRegistro) {
		
		echo '<li class="page-item ' . $nextClass . '">
				<a class="page-link" href="#" onclick="' . $action . '(\'' . $nextPosition . '\'); event.preventDefault();">
					next
					<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>
				</a>
			</li>';
	}
}
function obtenerMayorUnidad($diferencia) {
    $tiempo = array(
        'years' => $diferencia->y,
        'months' => $diferencia->m,
        'days' => $diferencia->d,
        'hours' => $diferencia->h,
        'minutes' => $diferencia->i,
        'seconds' => $diferencia->s
    );

    $orden = array('years', 'months', 'days', 'hours', 'minutes', 'seconds');

    foreach ($orden as $unidad) {
        if ($tiempo[$unidad] > 0) {
            return array('unidad' => $unidad, 'valor' => $tiempo[$unidad]);
        }
    }

    return array('unidad' => 'never', 'valor' => 0);
}


function simplyText($text) {
    $text = strtoupper(preg_replace('/[^A-Za-z0-9\s]/', '', $text));
    
    $palabras = explode(' ', $text);
    
    $iniciales = '';

    foreach ($palabras as $palabra) {
        $iniciales .= substr($palabra, 0, 1);

        if (strlen($iniciales) >= 3) {
            break;
        }
    }

    return $iniciales;
}

function linkSimplyText($text) {
    $text = strtolower(preg_replace('/[^A-Za-z0-9]+/', '-', $text));
    $text = preg_replace('/-+/', '-', $text);
    return $text;
}


$page_not_found = '<div class="container-xl d-flex flex-column justify-content-center">
            <div class="empty">
              <div class="empty-img"><img src="https://devbybit.com/demos/tablerio/static/illustrations/undraw_printing_invoices_5r4r.svg" height="128" alt="">
              </div>
              <p class="empty-title">No results found</p>
              <p class="empty-subtitle text-secondary">
                Try adjusting your search or filter to find what you\'re looking for.
              </p>
              <div class="empty-action">
                <a href="' . URI . '" class="btn btn-primary">
					<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-back" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 11l-4 4l4 4m-4 -4h11a4 4 0 0 0 0 -8h-1" /></svg>
					Back to home
                </a>
              </div>
            </div>
          </div>';


?>