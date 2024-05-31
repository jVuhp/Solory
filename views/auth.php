<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (DEBUGG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

ob_start();
if (isset($codeAuth[1])) {
    parse_str($codeAuth[1], $queryParams);
    $code = $queryParams['code'];

    $redirect_uri = URI . '/auth'; 
    $token_url = 'https://accounts.google.com/o/oauth2/token';

    $token_params = array(
        'code' => $code,
        'client_id' => GOOGLE_CLIENT_ID,
        'client_secret' => GOOGLE_CLIENT_SECRET,
        'redirect_uri' => $redirect_uri,
        'grant_type' => 'authorization_code',
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $token_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($token_params));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    $token_data = json_decode($response, true);
    if (isset($token_data['access_token'])) {
        $info_url = 'https://www.googleapis.com/oauth2/v1/userinfo';
        $info_params = array(
            'access_token' => $token_data['access_token'],
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $info_url . '?' . http_build_query($info_params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $user_info = curl_exec($ch);
        curl_close($ch);

        $user_data = json_decode($user_info, true);
        
        switch (strtolower(DB_TYPE)) {
            case 'mysql':
                $verifyUserSQL = $connx->prepare("SELECT * FROM `$dbb_user` WHERE `g_id` = ?;");
                $verifyUserSQL->execute([$user_data['id']]);
                if ($verifyUserSQL->rowCount() > 0) {
                    $user = $verifyUserSQL->fetch(PDO::FETCH_ASSOC);
                    
                    if ($user['name'] != $user_data['name'] || $user['avatar'] != $user_data['picture']) {
                        $updateSQL = $connx->prepare("UPDATE `$dbb_user` SET `name` = ?, `avatar` = ? WHERE `id` = ?;");
                        $updateSQL->execute([$user_data['name'], $user_data['picture'], $user['id']]);
                    }
                    
                    $_SESSION[$dbb_user] = [
                        'id' => $user['id'],
                        'g_id' => $user['g_id'],
                        'name' => $user['name'],
                        'email' => $user['email'],
                        'avatar' => $user['avatar'],
                        'logged' => true
                    ];
                    
                    header('Location: ' . URI . '/license');
                    exit();
                    
                } else {
                    $insertSQL = $connx->prepare("INSERT INTO `$dbb_user`(`g_id`, `name`, `email`, `avatar`) VALUES (?, ?, ?, ?);");
                    $insertSQL->execute([$user_data['id'], $user_data['name'], $user_data['email'], $user_data['picture']]);
                    
                    $newUserId = $connx->lastInsertId();
                    $_SESSION[$dbb_user] = [
                        'id' => $newUserId,
                        'g_id' => $user_data['id'],
                        'name' => $user_data['name'],
                        'email' => $user_data['email'],
                        'avatar' => $user_data['picture'],
                        'logged' => true
                    ];
                    header('Location: ' . URI . '/license');
                    exit();
                }
                break;
            default:
                $filename = 'dbb_json.php';

                $configContent = file_get_contents($filename);

                $datas = json_decode(dbb_user, true);

                $user_found = false;

                foreach ($datas as &$value) {
                    if ($value['g_id'] == $user_data['id']) {
                        $value['name'] = $user_data['name'];
                        $value['avatar'] = $user_data['picture'];
                        $user_found = true;
                        break; 
                    }
                }

                if ($user_found) {
                    $new_data_json = json_encode($datas);

                    $newConfigContent = preg_replace("/define\('dbb_user',\s*.*\);/", "define('dbb_user', '" . $new_data_json . "');", $configContent);

                    file_put_contents($filename, $newConfigContent);

                    $_SESSION[$dbb_user] = [
                        'id' => $value['id'],
                        'g_id' => $value['g_id'],
                        'name' => $value['name'],
                        'email' => $value['email'],
                        'avatar' => $value['avatar'],
                        'logged' => true
                    ];
                    header('Location: ' . URI . '/license');
                    exit();
                    
                } else {
					
					if (is_array($datas)) {
						$new_id = 1;

						if (count($datas) > 0) {
							$last_item = end($datas);

							if (isset($last_item['id'])) {
								$new_id = $last_item['id'] + 1;
							}
						}
					} else {
						echo json_encode(array('type' => 'error', 'message' => 'Error on array.'));
						return;
					}
					
					$new_user_id = $new_id;
					$new_data = [
						'id' => $new_user_id,
						'g_id' => $user_data['id'],
						'name' => $user_data['name'],
						'email' => $user_data['email'],
						'avatar' => $user_data['picture'],
						'since' => date('Y-m-d H:i:s')
					];

					$datas[$new_id] = $new_data;

					$new_data_json = json_encode($datas);
					// addslashes() para agregar los \ \\ \ \ \ en el json.
					$newConfigContent = preg_replace("/define\('dbb_user',\s*'.+?'\);/s", "define('dbb_user', '" . $new_data_json . "');", $configContent);

					file_put_contents($filename, $newConfigContent);
					

                    $_SESSION[$dbb_user] = [
                        'id' => $new_user_id,
                        'g_id' => $user_data['id'],
                        'name' => $user_data['name'],
                        'email' => $user_data['email'],
                        'avatar' => $user_data['picture'],
                        'logged' => true
                    ];

                    header('Location: ' . URI . '/license');
                    exit();
                }
                break;
        }
    } else {
        header('Location: ' . URI . '/');
        exit();
    }
}
ob_end_flush();
?>
