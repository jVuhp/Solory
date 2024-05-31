<?php
session_start();
require_once('../config.php');
require_once('../function.php');
$request = $_POST['result'];


if ($request == 'logout') {
	session_destroy();
}



if ($request == 'delete_user') {
	$license_id = str_replace("'", "", $_POST['dataid']);

	try {
		switch (strtolower(DB_TYPE)) {
			case 'mysql':
				$deleteSQL = $connx->prepare("DELETE FROM `dbb_user` WHERE `id` = ?");
				$deleteSQL->execute([$license_id]);
				break;
			default:
				$filename = '../dbb_json.php';
				$configContent = file_get_contents($filename);
				$license_data = json_decode(dbb_user, true);

				if (isset($license_data[$license_id])) {
					unset($license_data[$license_id]);
				}

				$new_data_json = json_encode($license_data);

				$newConfigContent = preg_replace("/define\('dbb_user',\s*.*\);/", "define('dbb_user', '" . $new_data_json . "');", $configContent);

				file_put_contents($filename, $newConfigContent);
				break;
		}

		echo json_encode(array('type' => 'success', 'message' => 'User deleted successfully!'));
		return;
	} catch (Exception $e) {
		echo json_encode(array('type' => 'error', 'message' => $e->getMessage()));
		return;
	}
}


if ($request == 'delete_license') {
	$license_id = str_replace("'", "", $_POST['dataid']);

	try {
		switch (strtolower(DB_TYPE)) {
			case 'mysql':
				$deleteSQL = $connx->prepare("DELETE FROM `dbb_license` WHERE `id` = ?");
				$deleteSQL->execute([$license_id]);
				break;
			default:
				$filename = '../dbb_json.php';
				$configContent = file_get_contents($filename);
				$license_data = json_decode(dbb_license, true);

				if (isset($license_data[$license_id])) {
					unset($license_data[$license_id]);
				}

				$new_data_json = json_encode($license_data);

				$newConfigContent = preg_replace("/define\('dbb_license',\s*.*\);/", "define('dbb_license', '" . $new_data_json . "');", $configContent);

				file_put_contents($filename, $newConfigContent);
				break;
		}

		echo json_encode(array('type' => 'success', 'message' => 'License deleted successfully!'));
		return;
	} catch (Exception $e) {
		echo json_encode(array('type' => 'error', 'message' => $e->getMessage()));
		return;
	}
}
if ($request == 'edit_license') {
	
	$license_id = str_replace("'", "", $_POST['dataid']);
	$keys = str_replace("'", "", $_POST['license_key']);
	$client = str_replace("'", "", $_POST['client_id']);
	$product = str_replace("'", "", $_POST['product']);
	$product_bound = ($_POST['bound']) ? 1 : 0;
	$expire = (empty($_POST['expire'])) ? 30 : $_POST['expire'];
	$expiration = $_POST['expiration'];
	$ip_cap = ($_POST['ip_cap'] >= 1) ? $_POST['ip_cap'] : 0;
	$note = (empty($_POST['note'])) ? '' : str_replace("'", "", $_POST['note']);
	
	$expire = ($expiration == 'Never') ? '-1' : strtotime('+' . $expire . ' ' . $expiration);
	
	try {
		
		switch (strtolower(DB_TYPE)) {
			case 'mysql':
				$insertSQL = $connx->prepare("UPDATE `dbb_license` SET 
					`client`= ?,
					`key`= ?,
					`scope`= ?,
					`expire`= ?,
					`bound`= ?,
					`ips`= ?,
					`note`= ? WHERE `id` = ?;");
				$insertSQL->execute([$client, $keys, $product, $expire, $product_bound, $ip_cap, $note, $license_id]);
				
				$license_id = $connx->lastInsertId();
				break;
			default:
				
				$filename = '../dbb_json.php';

				$configContent = file_get_contents($filename);

				preg_match("/define\('dbb_license',\s*([^)]+)\);/", $configContent, $matches);
				$license_data = json_decode(dbb_license, true);

				if (isset($license_data[$license_id])) {
					$license_data[$license_id]['client'] = $client;
					$license_data[$license_id]['key'] = $keys;
					$license_data[$license_id]['scope'] = $product;
					$license_data[$license_id]['expire'] = $expire;
					$license_data[$license_id]['bound'] = $product_bound;
					$license_data[$license_id]['ips'] = $ip_cap;
					$license_data[$license_id]['note'] = $note;
				}

				$new_data_json = json_encode($license_data);

				$newConfigContent = preg_replace("/define\('dbb_license',\s*.*\);/", "define('dbb_license', '" . $new_data_json . "');", $configContent);

				file_put_contents($filename, $newConfigContent);
				break;
		}
		
		echo json_encode(array('type' => 'success', 'message' => 'You edited the license correctly!', 'id' => $license_id));
		return;
    } catch (Exception $e) {
		echo json_encode(array('type' => 'error', 'message' => $e));
        return;
    }
}
if ($request == 'create_license') {
	
	$keys = str_replace("'", "", $_POST['license_key']);
	$client = str_replace("'", "", $_POST['client_id']);
	$product = str_replace("'", "", $_POST['product']);
	$product_bound = ($_POST['bound']) ? 1 : 0;
	$expire = (empty($_POST['expire'])) ? 30 : $_POST['expire'];
	$expiration = $_POST['expiration'];
	$ip_cap = ($_POST['ip_cap'] >= 1) ? $_POST['ip_cap'] : 0;
	$note = (empty($_POST['note'])) ? '' : str_replace("'", "", $_POST['note']);
	
	$expire = ($expiration == 'Never') ? '-1' : strtotime('+' . $expire . ' ' . $expiration);
	
	try {
		
		switch (strtolower(DB_TYPE)) {
			case 'mysql':
				$insertSQL = $connx->prepare("INSERT INTO `dbb_license`(`client`, `key`, `scope`, `expire`, `bound`, `ips`, `note`, `creator`) 
				VALUES (?, ?, ?, ?, ?, ?, ?, ?);");
				$insertSQL->execute([$client, $keys, $product, $expire, $product_bound, $ip_cap, $note, $_SESSION[$dbb_user]['id']]);
				
				$license_id = $connx->lastInsertId();
				break;
			default:
				
				$filename = '../dbb_json.php';
				$configContent = file_get_contents($filename);

				$existing_data = json_decode(dbb_license, true);

				if (is_array($existing_data)) {
					$new_id = 1;

					if (count($existing_data) > 0) {
						$last_item = end($existing_data);

						if (isset($last_item['id'])) {
							$new_id = $last_item['id'] + 1;
						}
					}
				} else {
					echo json_encode(array('type' => 'error', 'message' => 'Error on array.'));
					return;
				}
				
				$new_data = [
					'id' => $new_id,
					'client' => $client,
					'key' => $keys,
					'scope' => $product,
					'expire' => $expire,
					'ip_cap' => '',
					'time_cap' => '',
					'bound' => $product_bound,
					'ips' => $ip_cap,
					'note' => $note,
					'creator' => $_SESSION[$dbb_user]['id'],
					'since' => date('Y-m-d H:i:s')
				];
				
				$existing_data[$new_id] = $new_data;

				$new_data_json = json_encode($existing_data);

				$newConfigContent = preg_replace("/define\('dbb_license',\s*.*\);/", "define('dbb_license', '" . $new_data_json . "');", $configContent);

				file_put_contents($filename, $newConfigContent);
				$license_id = $new_id;
				break;
		}
		
		echo json_encode(array('type' => 'success', 'message' => 'You created the license correctly!', 'id' => $license_id));
		return;
    } catch (Exception $e) {
		echo json_encode(array('type' => 'error', 'message' => $e));
        return;
    }
}

if ($request == 'create_group') {
	
	$group = str_replace("'", "", $_POST['name']);
	$default = ($_POST['default']) ? 1 : 0;
	$color = $_POST['color'];
	$creator = $_SESSION[$dbb_user]['id'];
	
	try {
		
		switch (strtolower(DB_TYPE)) {
			case 'mysql':
				$insertSQL = $connx->prepare("INSERT INTO `dbb_group`(`name`, `default`, `color`, `creator`) 
				VALUES (?, ?, ?, ?);");
				$insertSQL->execute([$group, $default, $color, $creator]);
				
				$license_id = $connx->lastInsertId();
				break;
			default:
				
				$filename = '../dbb_json.php';
				$configContent = file_get_contents($filename);

				$existing_data = json_decode(dbb_group, true);

				if (is_array($existing_data)) {
					$new_id = 1;

					if (count($existing_data) > 0) {
						$last_item = end($existing_data);

						if (isset($last_item['id'])) {
							$new_id = $last_item['id'] + 1;
						}
					}
				} else {
					echo json_encode(array('type' => 'error', 'message' => 'Error on array.'));
					return;
				}
				
				$new_data = [
					'id' => $new_id,
					'name' => $group,
					'default' => $default,
					'color' => $color,
					'creator' => $creator,
					'since' => date('Y-m-d H:i:s')
				];
				
				$existing_data[$new_id] = $new_data;

				$new_data_json = json_encode($existing_data);

				$newConfigContent = preg_replace("/define\('dbb_group',\s*.*\);/", "define('dbb_group', '" . $new_data_json . "');", $configContent);

				file_put_contents($filename, $newConfigContent);
				$license_id = $new_id;
				break;
		}
		
		echo json_encode(array('type' => 'success', 'message' => 'You created the group correctly!', 'id' => $license_id));
		return;
    } catch (Exception $e) {
		echo json_encode(array('type' => 'error', 'message' => $e));
        return;
    }
}

if ($request == 'delete_group') {
	$license_id = str_replace("'", "", $_POST['dataid']);

	try {
		switch (strtolower(DB_TYPE)) {
			case 'mysql':
				$deleteSQL = $connx->prepare("DELETE FROM `dbb_group` WHERE `id` = ?");
				$deleteSQL->execute([$license_id]);
				break;
			default:
				$filename = '../dbb_json.php';
				$configContent = file_get_contents($filename);
				$license_data = json_decode(dbb_group, true);

				if (isset($license_data[$license_id])) {
					unset($license_data[$license_id]);
				}

				$new_data_json = json_encode($license_data);

				$newConfigContent = preg_replace("/define\('dbb_group',\s*.*\);/", "define('dbb_group', '" . $new_data_json . "');", $configContent);

				file_put_contents($filename, $newConfigContent);
				break;
		}

		echo json_encode(array('type' => 'success', 'message' => 'Group deleted successfully!'));
		return;
	} catch (Exception $e) {
		echo json_encode(array('type' => 'error', 'message' => $e->getMessage()));
		return;
	}
}

if ($request == 'edit_group') {
	
	$license_id = str_replace("'", "", $_POST['group']);
	$name = str_replace("'", "", $_POST['name']);
	$default = ($_POST['default']) ? 1 : 0;
	$color = $_POST['color'];
	$creator = $_SESSION[$dbb_user]['id'];
	
	$expire = ($expiration == 'Never') ? '-1' : strtotime('+' . $expire . ' ' . $expiration);
	
	try {
		
		switch (strtolower(DB_TYPE)) {
			case 'mysql':
				$insertSQL = $connx->prepare("UPDATE `dbb_group` SET 
					`name`= ?, `default` = ?, `color` = ? WHERE `id` = ?;");
				$insertSQL->execute([$name, $default, $color, $license_id]);
				
				break;
			default:
				
				$filename = '../dbb_json.php';

				$configContent = file_get_contents($filename);

				preg_match("/define\('dbb_group',\s*([^)]+)\);/", $configContent, $matches);
				$license_data = json_decode(dbb_group, true);

				if (isset($license_data[$license_id])) {
					$license_data[$license_id]['name'] = $name;
					$license_data[$license_id]['default'] = $default;
					$license_data[$license_id]['color'] = $color;
				}

				$new_data_json = json_encode($license_data);

				$newConfigContent = preg_replace("/define\('dbb_group',\s*.*\);/", "define('dbb_group', '" . $new_data_json . "');", $configContent);

				file_put_contents($filename, $newConfigContent);
				break;
		}
		
		echo json_encode(array('type' => 'success', 'message' => 'You edited the group correctly!', 'id' => $license_id));
		return;
    } catch (Exception $e) {
		echo json_encode(array('type' => 'error', 'message' => $e));
        return;
    }
}

if ($request == 'delete_permission_to_group') {
	$license_id = str_replace("'", "", $_POST['dataid']);

	try {
		switch (strtolower(DB_TYPE)) {
			case 'mysql':
				$deleteSQL = $connx->prepare("DELETE FROM `dbb_group_permission` WHERE `id` = ?");
				$deleteSQL->execute([$license_id]);
				break;
			default:
				$filename = '../dbb_json.php';
				$configContent = file_get_contents($filename);
				$license_data = json_decode(dbb_group_permission, true);

				if (isset($license_data[$license_id])) {
					unset($license_data[$license_id]);
				}

				$new_data_json = json_encode($license_data);

				$newConfigContent = preg_replace("/define\('dbb_group_permission',\s*.*\);/", "define('dbb_group_permission', '" . $new_data_json . "');", $configContent);

				file_put_contents($filename, $newConfigContent);
				break;
		}

		echo json_encode(array('type' => 'success', 'message' => 'Permission deleted successfully!'));
		return;
	} catch (Exception $e) {
		echo json_encode(array('type' => 'error', 'message' => $e->getMessage()));
		return;
	}
}

if ($request == 'add_permission_to_group') {
	
	$group = str_replace("'", "", $_POST['group']);
	$perm = str_replace("'", "", $_POST['name']);
	$creator = $_SESSION[$dbb_user]['id'];
	
	try {
		
		switch (strtolower(DB_TYPE)) {
			case 'mysql':
				$insertSQL = $connx->prepare("INSERT INTO `dbb_group_permission`(`group`, `permission`) 
				VALUES (?, ?);");
				$insertSQL->execute([$group, $perm]);
				
				$license_id = $connx->lastInsertId();
				break;
			default:
				
				$filename = '../dbb_json.php';
				$configContent = file_get_contents($filename);

				$existing_data = json_decode(dbb_group_permission, true);

				if (is_array($existing_data)) {
					$new_id = 1;

					if (count($existing_data) > 0) {
						$last_item = end($existing_data);

						if (isset($last_item['id'])) {
							$new_id = $last_item['id'] + 1;
						}
					}
				} else {
					echo json_encode(array('type' => 'error', 'message' => 'Error on array.'));
					return;
				}

				$new_data = [
					'id' => $new_id,
					'group' => $group,
					'permission' => $perm,
					'since' => date('Y-m-d H:i:s')
				];
				
				$existing_data[$new_id] = $new_data;

				$new_data_json = json_encode($existing_data);

				$newConfigContent = preg_replace("/define\('dbb_group_permission',\s*.*\);/", "define('dbb_group_permission', '" . $new_data_json . "');", $configContent);

				file_put_contents($filename, $newConfigContent);
				$license_id = $new_id;
				break;
		}
		
		echo json_encode(array('type' => 'success', 'message' => 'Permission has been added successfully!', 'id' => $license_id));
		return;
    } catch (Exception $e) {
		echo json_encode(array('type' => 'error', 'message' => $e));
        return;
    }
}

if ($request == 'delete_user_in_group') {
	$license_id = str_replace("'", "", $_POST['dataid']);

	try {
		switch (strtolower(DB_TYPE)) {
			case 'mysql':
				$deleteSQL = $connx->prepare("DELETE FROM `dbb_group_user` WHERE `id` = ?");
				$deleteSQL->execute([$license_id]);
				break;
			default:
				$filename = '../dbb_json.php';
				$configContent = file_get_contents($filename);
				$license_data = json_decode(dbb_group_user, true);

				if (isset($license_data[$license_id])) {
					unset($license_data[$license_id]);
				}

				$new_data_json = json_encode($license_data);

				$newConfigContent = preg_replace("/define\('dbb_group_user',\s*.*\);/", "define('dbb_group_user', '" . $new_data_json . "');", $configContent);

				file_put_contents($filename, $newConfigContent);
				break;
		}

		echo json_encode(array('type' => 'success', 'message' => 'User group deleted successfully!'));
		return;
	} catch (Exception $e) {
		echo json_encode(array('type' => 'error', 'message' => $e->getMessage()));
		return;
	}
}

if ($request == 'add_user_in_group') {
	
	$group = str_replace("'", "", $_POST['dataid']);
	$user = str_replace("'", "", $_POST['user']);
	$creator = $_SESSION[$dbb_user]['id'];
	
	try {
		
		switch (strtolower(DB_TYPE)) {
			case 'mysql':
				$insertSQL = $connx->prepare("INSERT INTO `dbb_group_user`(`group`, `user`) 
				VALUES (?, ?);");
				$insertSQL->execute([$group, $user]);
				
				$license_id = $connx->lastInsertId();
				break;
			default:
				
				$filename = '../dbb_json.php';
				$configContent = file_get_contents($filename);

				$existing_data = json_decode(dbb_group_user, true);

				if (is_array($existing_data)) {
					$new_id = 1;

					if (count($existing_data) > 0) {
						$last_item = end($existing_data);

						if (isset($last_item['id'])) {
							$new_id = $last_item['id'] + 1;
						}
					}
				} else {
					echo json_encode(array('type' => 'error', 'message' => 'Error on array.'));
					return;
				}

				$new_data = [
					'id' => $new_id,
					'group' => $group,
					'user' => $user,
					'since' => date('Y-m-d H:i:s')
				];
				
				$existing_data[$new_id] = $new_data;

				$new_data_json = json_encode($existing_data);

				$newConfigContent = preg_replace("/define\('dbb_group_user',\s*.*\);/", "define('dbb_group_user', '" . $new_data_json . "');", $configContent);

				file_put_contents($filename, $newConfigContent);
				$license_id = $new_id;
				break;
		}
		
		echo json_encode(array('type' => 'success', 'message' => 'User has been added successfully!'));
		return;
    } catch (Exception $e) {
		echo json_encode(array('type' => 'error', 'message' => $e));
        return;
    }
}

if ($request == 'removethisip') {
	try {
		if (isset($_POST['dataid'])) {
			$license_id = $_POST['dataid'];
		} else {
			echo json_encode(array('type' => 'error', 'message' => 'Dataid not provided.'));
			return;
		}
		
		if (isset($_POST['index'])) {
			$indexToRemove = $_POST['index'];
		} else {
			echo json_encode(array('type' => 'error', 'message' => 'Index not provided.'));
			return;
		}

		if (isset($_POST['ip'])) {
			$ipToRemove = $_POST['ip'];
		} else {
			echo json_encode(array('type' => 'error', 'message' => 'IP not provided.'));
			return;
		}

		switch (strtolower(DB_TYPE)) {
			case 'mysql':
				$removeIpAndTimeSQL = $connx->prepare("UPDATE `dbb_license` SET `ip_cap` = TRIM(BOTH '#' FROM REPLACE(CONCAT('#', `ip_cap`, '#'), CONCAT('#', ?, '#'), '#')), `time_cap` = TRIM(BOTH '#' FROM REPLACE(CONCAT('#', `time_cap`, '#'), CONCAT('#', ?, '#'), '#')) WHERE `id` = ?");
				$removeIpAndTimeSQL->execute([$ipToRemove, $indexToRemove, $license_id]);
				break;
			default:
				$filename = '../dbb_json.php';
				$configContent = file_get_contents($filename);
				$existingData = json_decode(dbb_license, true);

				if (isset($existingData[$license_id])) {
					$licenseEntry = $existingData[$license_id];
					
					$ips = explode('#', $licenseEntry['ip_cap']);
					$ipIndex = array_search($ipToRemove, $ips);
					if ($ipIndex !== false) {
						unset($ips[$ipIndex]);
					}
					$licenseEntry['ip_cap'] = implode('#', $ips);
					
					$times = explode('#', $licenseEntry['time_cap']);
					if (isset($times[$indexToRemove])) {
						unset($times[$indexToRemove]);
					}
					$licenseEntry['time_cap'] = implode('#', $times);
					
					$existingData[$license_id] = $licenseEntry;
				}

				$newDataJson = json_encode($existingData);
				$newConfigContent = preg_replace("/define\('dbb_license',\s*.*\);/", "define('dbb_license', '" . $newDataJson . "');", $configContent);
				file_put_contents($filename, $newConfigContent);
				break;
		}
		

		echo json_encode(array('type' => 'success', 'message' => 'IP and activity removed successfully.'));
		return;
	} catch (Exception $e) {
		echo json_encode(array('type' => 'error', 'message' => $e->getMessage()));
		return;
	}
}

if ($request == 'remove_group_user') {
	try {
		if (isset($_POST['dataid'])) {
			$license_id = $_POST['dataid'];
		} else {
			echo json_encode(array('type' => 'error', 'message' => 'Dataid not provided.'));
			return;
		}

		switch (strtolower(DB_TYPE)) {
			case 'mysql':
				$deleteSQL = $connx->prepare("DELETE FROM `dbb_group_user` WHERE `id` = ?");
				$deleteSQL->execute([$license_id]);
				break;
			default:
				$filename = '../dbb_json.php';
				$configContent = file_get_contents($filename);
				$license_data = json_decode(dbb_group_user, true);

				if (isset($license_data[$license_id])) {
					unset($license_data[$license_id]);
				}

				$new_data_json = json_encode($license_data);

				$newConfigContent = preg_replace("/define\('dbb_group_user',\s*.*\);/", "define('dbb_group_user', '" . $new_data_json . "');", $configContent);

				file_put_contents($filename, $newConfigContent);
				break;
				break;
		}
		

		echo json_encode(array('type' => 'success', 'message' => 'Group removed successfully.'));
		return;
	} catch (Exception $e) {
		echo json_encode(array('type' => 'error', 'message' => $e->getMessage()));
		return;
	}
}

if ($request == 'sub_search_client') {
	try {
		$userData = [];
		$query = isset($_POST['query']) ? $_POST['query'] : '';
		switch (strtolower(DB_TYPE)) {
			case 'mysql':
				$userSQL = $connx->prepare("SELECT * FROM `dbb_user`;");
				$userSQL->execute();
				
				while ($user = $userSQL->fetch(PDO::FETCH_ASSOC)) {
					$name = $user['name'];
					if (!isset($userData[$name])) {
						$userListData = ['gid' => $user['g_id'], 'name' => $name];
						$userData[$name] = $userListData;
					}
				}
				
				$filteredResults = array_filter($userData, function($item) use ($query) {
					$nameMatch = stripos($item['name'], $query) !== false;
					$totalMatch = stripos($item['gid'], $query) !== false;
					
					return $nameMatch || $totalMatch;
				});
				break;
			default:
				$filename = '../dbb_json.php';

				$configContent = file_get_contents($filename);

				$datas = json_decode(dbb_user, true);
				
				foreach ($datas as $key => $value) {
					$g_id_prefix = substr($value['g_id'], 0, strlen($query));
					$name = $value['name'];
					if ($g_id_prefix === $query) {
						$userListData = ['gid' => $value['g_id'], 'name' => $name];
						$userData[$name] = $userListData;
					}
				}
				
				$filteredResults = array_filter($userData, function($item) use ($query) {
					$nameMatch = stripos($item['name'], $query) !== false;
					$totalMatch = stripos($item['gid'], $query) !== false;
					
					return $nameMatch || $totalMatch;
				});
				break;
		}
		
		header('Content-Type: application/json');
		echo json_encode(array_values($filteredResults));
	} catch (Exception $e) {
		header('HTTP/1.1 500 Internal Server Error');
		echo json_encode(array('error' => $e->getMessage()));
	}
}


if ($request == 'sub_search_scope') {
    try {
        $userData = [];
        $query = isset($_POST['query']) ? $_POST['query'] : '';

        switch (strtolower(DB_TYPE)) {
            case 'mysql':
                $userSQL = $connx->prepare("SELECT * FROM `dbb_license` WHERE `scope` LIKE :query;");
                $userSQL->execute(['query' => $query . '%']);

                while ($user = $userSQL->fetch(PDO::FETCH_ASSOC)) {
                    $name = $user['scope'];
                    if (!isset($userData[$name])) {
                        $userData[$name] = $user['scope'];
                    }
                }
                break;
            default:
                $configContent = constant('dbb_license');
                $datas = json_decode($configContent, true);

                foreach ($datas as $key => $value) {
                    $name = $value['scope'];
                    if (stripos($name, $query) === 0) {
                        $userData[$name] = $name;
                    }
                }
                break;
        }

        $filteredResults = array_values($userData);

        header('Content-Type: application/json');
        echo json_encode($filteredResults);
    } catch (Exception $e) {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => $e->getMessage()]);
    }
}

if ($request == 'chart_license_overview') {
	switch (strtolower(DB_TYPE)) {
		case 'mysql':
			$license = isset($_POST['dataid']) ? htmlspecialchars($_POST['dataid'], ENT_QUOTES, 'UTF-8') : null;
			if ($license !== null) {
				$currentYear = date('Y');
				$acceptedData = array_fill(0, 12, 0);
				$deniedData = array_fill(0, 12, 0);

				$chartData = $connx->prepare("
					SELECT DATE_FORMAT(since, '{$currentYear}-%m') AS month, COALESCE(SUM(value), 0) AS total_value
					FROM `dbb_logs`
					WHERE type = 'Accepted' AND `license` = ? AND YEAR(since) = ?
					GROUP BY month
					ORDER BY month
				");
				$chartData->execute([$license, $currentYear]);

				while ($row = $chartData->fetch(PDO::FETCH_ASSOC)) {
					$month = intval(substr($row['month'], 5));
					$acceptedData[$month - 1] = $row['total_value'];
				}

				$deniedChartData = $connx->prepare("
					SELECT DATE_FORMAT(since, '{$currentYear}-%m') AS month, COALESCE(SUM(value), 0) AS totald_value
					FROM `dbb_logs`
					WHERE type = 'Denied' AND `license` = ? AND YEAR(since) = ? 
					GROUP BY month
					ORDER BY month
				");
				$deniedChartData->execute([$license, $currentYear]);

				while ($row = $deniedChartData->fetch(PDO::FETCH_ASSOC)) {
					$month = intval(substr($row['month'], 5));
					$deniedData[$month - 1] = $row['totald_value'];
				}

				$acceptedData = array_map('intval', $acceptedData);
				$deniedData = array_map('intval', $deniedData);

				header('Content-Type: application/json');
				echo json_encode(['acceptedData' => $acceptedData, 'deniedData' => $deniedData]);
			} else {
				echo "Error: Falta el parámetro 'dataid'.";
			}
			break;
		default:
			$json_data = defined('dbb_logs') ? json_decode(dbb_logs, true) : [];

			$license = isset($_POST['dataid']) ? htmlspecialchars($_POST['dataid'], ENT_QUOTES, 'UTF-8') : null;

			if ($license !== null) {
				$currentYear = date('Y');
				$acceptedData = array_fill(0, 12, 0);
				$deniedData = array_fill(0, 12, 0);

				foreach ($json_data as $entry) {
					$entry_license = $entry['license'];
					$entry_type = $entry['type'];
					$entry_value = intval($entry['value']);
					$entry_since = new DateTime($entry['since']);

					if ($entry_license == $license && $entry_since->format('Y') == $currentYear) {
						$entry_month = $entry_since->format('n') - 1; 

						if ($entry_type == 'Accepted') {
							$acceptedData[$entry_month] += $entry_value;
						} elseif ($entry_type == 'Denied') {
							$deniedData[$entry_month] += $entry_value;
						}
					}
				}

				header('Content-Type: application/json');
				echo json_encode(['acceptedData' => $acceptedData, 'deniedData' => $deniedData]);
			} else {
				echo "Error: Falta el parámetro 'dataid'.";
			}
			break;
	}
}

?>