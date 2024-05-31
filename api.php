<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

require_once('config.php');
require_once('function.php');

if (DEBUGG) {
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
}

$secret = filter_input(INPUT_GET, 'secret', FILTER_SANITIZE_STRING);
$deviceIp = getUserIp();

if ($secret == SECRET_KEY) {
		$lic_key = filter_input(INPUT_GET, 'key', FILTER_SANITIZE_STRING);
		$product = filter_input(INPUT_GET, 'scope', FILTER_SANITIZE_STRING);
		$validation = 0;
		
		if (empty($lic_key)) { 
			echo json_encode(array("valid" => false,"message" => "KEY_FIELD_EMPTY"));
			return;
		}
		
		$resultsArray = [];
		switch (strtolower(DB_TYPE)) {
			case 'mysql':
				global $connx;
				$docsSQL = $connx->prepare("SELECT * FROM `dbb_license` WHERE `key` = ?;");
				$docsSQL->execute([$lic_key]);
				if ($docsSQL->RowCount() > 0) {
					while($doc = $docsSQL->fetch(PDO::FETCH_ASSOC)) {
						$resultsArray[] = $doc;
					}
				}
				break;
			default:
				$existing_data = json_decode(dbb_license, true);
				
				foreach ($existing_data as $key => $entry) {
					if ($entry['key'] == $lic_key) {
						$resultsArray[] = $entry;
					}
				}
				
				break;
		}
		
		if (!empty($resultsArray)) {
			$license = $resultsArray[0];
			$time = time();
			$dates = date('Y-m-d h:i:s');
			$IPS = $license['ip_cap'];
			$activity = $license['time_cap'];
			$arrIPs = array();
			$arrRef = array();
			
			if (time() > $license['expire'] AND $license['expire'] != '-1') {
				echo json_encode(array("valid" => false,"message" => "EXPIRED_KEY"));
				return;
			}
			
			if ($license['bound']) {
				if ($product != $license['scope']) {
					echo json_encode(array("valid" => false,"message" => "PRODUCT_INCORRECT"));
					return;
				} else if (empty($product)) {
					echo json_encode(array("valid" => false,"message" => "PRODUCT_FIELD_EMPTY"));
					return;
				}
			}
			
			$disableCurrentTime = strtotime('-1 Hours', $time);
			$valued = 1;
			
			switch (strtolower(DB_TYPE)) {
				case 'mysql':

					$requestSQL = $connx->prepare("SELECT * FROM `dbb_logs` WHERE `license` = ? ORDER BY since DESC;");
					$requestSQL->execute([$license['id']]);
					$request = $requestSQL->fetch(PDO::FETCH_ASSOC);
					$since_request = strtotime($request['since']);
					
					if ($requestSQL->RowCount() > 0) {
						if ($since_request <= $disableCurrentTime) {
							$insertSQL = $connx->prepare("INSERT INTO `dbb_logs`(`license`, `type`, `value`) 
							VALUES (?, 'Accepted', ?);");
							$insertSQL->execute([$license['id'], $valued]);
						} else {
							$valued = $request['value'] + 1;
							$updateSQL = $connx->prepare("UPDATE `dbb_logs` SET `value`= ?,`since`= ? WHERE `id` = ?;");
							$updateSQL->execute([$valued, $dates, $request['id']]);
						}
					} else {
						$insertSQL = $connx->prepare("INSERT INTO `dbb_logs`(`license`, `type`, `value`) 
						VALUES (?, 'Accepted', ?);");
						$insertSQL->execute([$license['id'], $valued]);
					}
					break;
				default:
					$filename = '../dbb_json.php';
					$configContent = file_get_contents($filename);
					$logs_data = json_decode(dbb_logs, true);

					$request = null;
					$since_request = 0;

					foreach ($logs_data as $log) {
						if ($log['license'] == $license['id']) {
							if ($request === null || strtotime($log['since']) > $since_request) {
								$request = $log;
								$since_request = strtotime($log['since']);
							}
						}
					}

					if ($request) {
						if ($since_request <= $disableCurrentTime) {

							if (is_array($logs_data)) {
								$new_id = 1;

								if (count($logs_data) > 0) {
									$last_item = end($logs_data);

									if (isset($last_item['id'])) {
										$new_id = $last_item['id'] + 1;
									}
								}
							}
							$new_log = [
								'id' => $new_id,
								'license' => $license['id'],
								'type' => 'Accepted',
								'value' => $valued,
								'since' => date('Y-m-d H:i:s')
							];
							$logs_data[] = $new_log;
						} else {
							foreach ($logs_data as $log) {
								if ($log['id'] == $request['id']) {
									$log['value'] = $request['value'] + 1;
									$log['since'] = date('Y-m-d H:i:s');
									break;
								}
							}
						}
					} else {
						if (is_array($logs_data)) {
							$new_id = 1;

							if (count($logs_data) > 0) {
								$last_item = end($logs_data);

								if (isset($last_item['id'])) {
									$new_id = $last_item['id'] + 1;
								}
							}
						}
						$new_log = [
							'id' => $new_id,
							'license' => $license['id'],
							'type' => 'Accepted',
							'value' => $valued,
							'since' => date('Y-m-d H:i:s')
						];
						$logs_data[] = $new_log;
					}

					$new_data_json = json_encode($logs_data);
					$newConfigContent = preg_replace("/define\('dbb_logs',\s*.*\);/", "define('dbb_logs', '" . $new_data_json . "');", $configContent);
					file_put_contents($filename, $newConfigContent);
					break;
			}
			
			if($IPS){
				$arrIPs = explode('#', $IPS);
				$arrRef = explode('#', $activity);

				for ($entryId=0; $entryId < count($arrIPs); $entryId++) {
					if ($arrIPs[$entryId] == $deviceIp) {
						$arrRef[$entryId] = time();
						$validation = 1;
					}
				}
				
				if (!$validation AND count($arrIPs) < $license['ips']) {
					array_unshift($arrIPs, $deviceIp);
					array_unshift($arrRef, time());
					$validation = 1;
				}
			} else {
				array_unshift($arrIPs, $deviceIp);
				array_unshift($arrRef, time());
				$validation = 1;
			}
			
			if ($validation) {
				$implodedIPs = implode("#", $arrIPs);
				$implodedRef = implode("#", $arrRef);
				
				switch (strtolower(DB_TYPE)) {
					case 'mysql':
						$updateIPSQL = $connx->prepare("UPDATE `dbb_license` SET `ip_cap`= ?,`time_cap`= ? WHERE `id` = ?;");
						$updateIPSQL->execute([$implodedIPs, $implodedRef, $license['id']]);
						break;
					default:
						$filenames = '../dbb_json.php';

						$configContents = file_get_contents($filenames);

						$license_data = json_decode(dbb_license, true);

						if (isset($license_data[$license['id']])) {
							$license_data[$license['id']]['ip_cap'] = $implodedIPs;
							$license_data[$license['id']]['time_cap'] = $implodedRef;

						}
						$new_data_json = json_encode($license_data);

						$newConfigContent = preg_replace("/define\('dbb_license',\s*.*\);/", "define('dbb_license', '" . $new_data_json . "');", $configContents);

						file_put_contents($filenames, $newConfigContent);
						break;
				}
				
				$responsed = [
					"valid" => 1,
					"message" => 'LICENSE_VERIFIED',
				];
			}
			
		} else {
			echo json_encode(array("valid" => 0,"message" => "KEY_NOT_EXISTS"));
			return;
		}

		echo json_encode($responsed);
		exit();
	
} else {
	if (empty($secret)) { 
		echo json_encode(array("valid" => false,"message" => "SECRET_FIELD_EMPTY"));
		return;
	} else {
		echo json_encode(array("valid" => false,"message" => "SECRET_INCORRECT"));
		return;
	}
}

?>