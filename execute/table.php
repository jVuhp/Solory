<?php
session_start();
require_once('../config.php');
require_once('../function.php');
$request = $_POST['result'];


if ($request == 'license' OR $request == 'license_admin') {
	
	$search = (!empty($_POST['search'])) ? $_POST['search'] : '';
	$where = (!empty($_POST['where'])) ? $_POST['where'] : 0;
	$pagination = (!empty($_POST['pag'])) ? $_POST['pag'] : 1;
	$total = (!empty($_POST['total'])) ? $_POST['total'] : 100;	
	$compag = (int)(!isset($pagination)) ? 1 : $pagination;

	switch(strtolower(DB_TYPE)) {
		case 'mysql':
			$wheres = ($where == 1) ? "ORDER BY id DESC" : "ORDER BY id ASC";
			if ($request == 'license_admin') {
				$params = (!empty($search)) ? ['%' . $search . '%', '%' . $search . '%', '%' . $search . '%'] : [];
				$searching = (!empty($search)) ? " WHERE `client` LIKE ? OR `key` LIKE ? OR `scope` LIKE ? " : "";
			} else {
				$params = (!empty($search)) ? [$_SESSION[$dbb_user]['g_id'], '%' . $search . '%', '%' . $search . '%'] : [$_SESSION[$dbb_user]['g_id']];
				$searching = (!empty($search)) ? " WHERE `client` = ? AND `key` LIKE ? OR `scope` LIKE ? " : "WHERE `client` = ?";
			}
			
			$plataformSQL = $connx->prepare("SELECT * FROM `dbb_license` $searching $wheres LIMIT " . (($compag - 1) * $total) . " , " . $total);
			$plataformSQL->execute($params);
			$TotalRegistro = ceil($plataformSQL->RowCount() / $total);

			$resultsArray = [];

			while ($doc = $plataformSQL->fetch(PDO::FETCH_ASSOC)) {
				$resultsArray[] = $doc;
			}

			$plataformSQL->closeCursor();

			$totalRegistros = count($resultsArray);
			break;

		default:
			$filename = '../dbb_json.php';
			$configContent = file_get_contents($filename);

			$existing_data = json_decode(dbb_license, true);

			$search = (!empty($_POST['search'])) ? $_POST['search'] : '';
			$where = (!empty($_POST['where'])) ? $_POST['where'] : 0;
			$wheres = ($where == 1) ? "DESC" : "ASC";

			$searchResults = [];
			foreach ($existing_data as $key => $entry) {
				if ($request == 'license_admin') {
					if (stripos($entry['client'], $search) !== false OR stripos($entry['key'], $search) !== false OR stripos($entry['scope'], $search) !== false) {
						$searchResults[] = $entry;
					}
				} else {
					if ($entry['client'] == $_SESSION[$dbb_user]['g_id']) {
						if (stripos($entry['key'], $search) !== false OR stripos($entry['scope'], $search) !== false) {
							$searchResults[] = $entry;
						}
					}
				}
			}

			function sortByID($a, $b) {
				return $a['id'] - $b['id'];
			}

			usort($searchResults, ($wheres == "ASC") ? 'sortByID' : function ($a, $b) {
				return $b['id'] - $a['id'];
			});


			$totalRegistros = count($searchResults);

			$startIndex = (($pagination - 1) * $total);
			$resultsSlice = array_slice($searchResults, $startIndex, $total);

			$TotalRegistro = ceil($totalRegistros / $total);

			$resultsArray = $resultsSlice;
			$totalRegistrosPaginados = count($resultsArray);
			break;
	}

	ob_start();
	if (!empty($resultsArray)) {
		foreach ($resultsArray as $doc) {
		$userinfo = userInfo('g_id', $doc['client']);
		$creatorinfo = userInfo('id', $doc['creator']);
		$ips = explode('#', $doc['ip_cap']);
		$counts = ($doc['ip_cap'] == NULL) ? 0 : count($ips);
		$bound = ($doc['bound']) ? '<span class="text-success">Required</span>' : '<span class="text-danger">Optional</span>';
	?>
		<tr data-id="<?php echo $doc['id']; ?>">
			<td data-label="">
				<div class="row g-3 align-items-center">
                    <a href="<?php echo URI; ?>/user/<?php echo $userinfo['id']; ?>" class="col-auto">
                        <span class="avatar" style="background-image: url(<?php echo $userinfo['avatar']; ?>)"></span>
                    </a>
                    <div class="col text-truncate">
                        <a href="<?php echo URI; ?>/user/<?php echo $userinfo['id']; ?>" class="text-reset d-block text-truncate"><?php echo $userinfo['name']; ?></a>
                        <div class="text-secondary text-truncate mt-n1"></div>
                    </div>
                </div>
			</td>
			<td data-label=""><?php echo '<span class="text-danger">' . $doc['key'] . '</span>'; ?></td>
			<td data-label=""><?php echo '<span class="text-success">' . $doc['scope'] . '</span><br>' . $bound; ?></td>
			<td data-label=""><?php echo $counts; ?>/<?php echo ($doc['ips'] == 0) ? '<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-infinity"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9.828 9.172a4 4 0 1 0 0 5.656a10 10 0 0 0 2.172 -2.828a10 10 0 0 1 2.172 -2.828a4 4 0 1 1 0 5.656a10 10 0 0 1 -2.172 -2.828a10 10 0 0 0 -2.172 -2.828" /></svg>' : $doc['ips']; ?></td>
			<td class="text-secondary" data-label=""><?php echo counttime($doc['since']); echo '<br>'; echo ($doc['expire'] == '-1') ? '<span class="text-warning">Never</span>' : counttimedown($doc['expire'], '<span class="text-danger">Finalized</span>'); ?></td>
			<td>
				<div class="btn-list dropdown flex-nowrap">
					
					<?php if ((has('dbb.soroly.license.*') OR has('dbb.soroly.license.edit') OR has('dbb.soroly.license.delete'))) { ?>
					<a href="<?php echo URI; ?>/license/<?php echo $doc['id']; ?>" class="btn-action dropdown" data-bs-toggle="dropdown" aria-label="Open user menu">
						<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path><path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path><path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path></svg>
					</a>
					
					<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
					  <a class="dropdown-item" href="<?php echo URI; ?>/license/<?php echo $doc['id']; ?>">
						<svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"></path><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path></svg>
						Manage
					  </a>
					  <?php if ((has('dbb.soroly.license.*') OR has('dbb.soroly.license.edit'))) { ?>
					  <a class="dropdown-item" href="<?php echo URI; ?>/license/<?php echo $doc['id']; ?>/edit">
						<svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path><path d="M16 5l3 3"></path></svg>
						Edit
					  </a>
					  <?php } ?>
					  
					  <?php if ((has('dbb.soroly.license.*') OR has('dbb.soroly.license.delete'))) { ?>
					  <a class="dropdown-item text-danger" href="<?php echo URI; ?>/license/<?php echo $doc['id']; ?>/delete">
						<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon dropdown-item-icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
						Delete
					  </a>
					  <?php } ?>
					</div>
					<?php } else { ?>
					<a href="<?php echo URI; ?>/license/<?php echo $doc['id']; ?>" class="btn-action">
						<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"></path><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path></svg>
					</a>
					<?php } ?>
				</div>
			</td>
		</tr>
		
	<?php
		}
	} else {
		echo '<tr><td colspan="6">No results found.</td></tr>';
	}
	$html = ob_get_clean();

	$inicio = (($compag - 1) * $total) + 1;
	$fin = min($inicio + $total - 1, $totalRegistros);
	ob_start();
	echo paginationButtons($TotalRegistro, $compag, $total, 'updatePage');
	$paginations_list = ob_get_clean();
	
	$data = [
		'totalRegistros' => $totalRegistros,
		'inicio' => $inicio,
		'fin' => $fin,
		'html' => $html,
		'paginations_list' => $paginations_list,
	];

	echo json_encode($data);
}

if ($request == 'group') {
	
	$search = (!empty($_POST['search'])) ? $_POST['search'] : '';
	$where = (!empty($_POST['where'])) ? $_POST['where'] : 0;
	$pagination = (!empty($_POST['pag'])) ? $_POST['pag'] : 1;
	$total = (!empty($_POST['total'])) ? $_POST['total'] : 100;	
	$compag = (int)(!isset($pagination)) ? 1 : $pagination;

	switch(strtolower(DB_TYPE)) {
		case 'mysql':
			$wheres = ($where == 1) ? "ORDER BY id DESC" : "ORDER BY id ASC";
			$params = (!empty($search)) ? ['%' . $search . '%'] : [];
			$searching = (!empty($search)) ? " WHERE `name` LIKE ?" : "";
			
			$plataformSQL = $connx->prepare("SELECT * FROM `dbb_group` $searching $wheres LIMIT " . (($compag - 1) * $total) . " , " . $total);
			$plataformSQL->execute($params);
			$TotalRegistro = ceil($plataformSQL->RowCount() / $total);

			$resultsArray = [];

			while ($doc = $plataformSQL->fetch(PDO::FETCH_ASSOC)) {
				$resultsArray[] = $doc;
			}

			$plataformSQL->closeCursor();

			$totalRegistros = count($resultsArray);
			break;

		default:
			$filename = '../dbb_json.php';
			$configContent = file_get_contents($filename);

			$existing_data = json_decode(dbb_group, true);

			$search = (!empty($_POST['search'])) ? $_POST['search'] : '';
			$where = (!empty($_POST['where'])) ? $_POST['where'] : 0;
			$wheres = ($where == 1) ? "DESC" : "ASC";

			$searchResults = [];
			foreach ($existing_data as $key => $entry) {
				if (stripos($entry['name'], $search) !== false) {
					$searchResults[] = $entry;
				}
			}

			function sortByID($a, $b) {
				return $a['id'] - $b['id'];
			}

			usort($searchResults, ($wheres == "ASC") ? 'sortByID' : function ($a, $b) {
				return $b['id'] - $a['id'];
			});


			$totalRegistros = count($searchResults);

			$startIndex = (($pagination - 1) * $total);
			$resultsSlice = array_slice($searchResults, $startIndex, $total);

			$TotalRegistro = ceil($totalRegistros / $total);

			$resultsArray = $resultsSlice;
			$totalRegistrosPaginados = count($resultsArray);
			break;
	}

	ob_start();
	if (!empty($resultsArray)) {
		foreach ($resultsArray as $doc) {
		$creatorinfo = userInfo('id', $doc['creator']);
	?>
		<tr data-id="<?php echo $doc['id']; ?>">
			<td data-label="" style="color: <?php echo $doc['color']; ?>;"><?php echo $doc['name']; ?></td>
			<td data-label=""><?php echo ($doc['default']) ? 'Yes' : 'No'; ?></td>
			<td data-label=""><?php echo $creatorinfo['name']; ?></td>
			<td class="text-secondary" data-label=""><?php echo counttime($doc['since']); ?></td>
			<?php if ((has('dbb.soroly.group.*') OR has('dbb.soroly.group.edit') OR has('dbb.soroly.group.delete') OR has('dbb.soroly.group'))) { ?>
			<td>
				<div class="btn-list dropdown flex-nowrap">
					<a href="<?php echo URI; ?>/group/<?php echo $doc['id']; ?>" class="btn-action dropdown" data-bs-toggle="dropdown" aria-label="Open user menu">
						<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path><path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path><path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path></svg>
					</a>
					
					<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
					  <?php if ((has('dbb.soroly.group.*') OR has('dbb.soroly.group'))) { ?>
					  <a class="dropdown-item" href="<?php echo URI; ?>/group/<?php echo $doc['id']; ?>">
						<svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"></path><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path></svg>
						Manage
					  </a>
					  <?php } ?>
					  <?php if ((has('dbb.soroly.group.*') OR has('dbb.soroly.group.edit'))) { ?>
					  <a class="dropdown-item" href="<?php echo URI; ?>/group/<?php echo $doc['id']; ?>/edit">
						<svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path><path d="M16 5l3 3"></path></svg>
						Edit
					  </a>
					  <?php } ?>
					  <?php if ((has('dbb.soroly.group.*') OR has('dbb.soroly.group.delete'))) { ?>
					  <a class="dropdown-item text-danger" href="<?php echo URI; ?>/group/<?php echo $doc['id']; ?>/delete">
						<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon dropdown-item-icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
						Delete
					  </a>
					  <?php } ?>
					</div>
					
				</div>
			</td>
			<?php } ?>
		</tr>
		
	<?php
		}
	} else {
		echo '<tr><td colspan="6">No results found.</td></tr>';
	}
	$html = ob_get_clean();

	$inicio = (($compag - 1) * $total) + 1;
	$fin = min($inicio + $total - 1, $totalRegistros);
	ob_start();
	echo paginationButtons($TotalRegistro, $compag, $total, 'updatePage');
	$paginations_list = ob_get_clean();
	
	$data = [
		'totalRegistros' => $totalRegistros,
		'inicio' => $inicio,
		'fin' => $fin,
		'html' => $html,
		'paginations_list' => $paginations_list,
	];

	echo json_encode($data);
}

if ($request == 'user') {
	
	$search = (!empty($_POST['search'])) ? $_POST['search'] : '';
	$where = (!empty($_POST['where'])) ? $_POST['where'] : 0;
	$pagination = (!empty($_POST['pag'])) ? $_POST['pag'] : 1;
	$total = (!empty($_POST['total'])) ? $_POST['total'] : 100;	
	$compag = (int)(!isset($pagination)) ? 1 : $pagination;

	switch(strtolower(DB_TYPE)) {
		case 'mysql':
			$wheres = ($where == 1) ? "ORDER BY id DESC" : "ORDER BY id ASC";
			$params = (!empty($search)) ? ['%' . $search . '%'] : [];
			$searching = (!empty($search)) ? " WHERE `name` LIKE ?" : "";
			
			$plataformSQL = $connx->prepare("SELECT * FROM `dbb_user` $searching $wheres LIMIT " . (($compag - 1) * $total) . " , " . $total);
			$plataformSQL->execute($params);
			$TotalRegistro = ceil($plataformSQL->RowCount() / $total);

			$resultsArray = [];

			while ($doc = $plataformSQL->fetch(PDO::FETCH_ASSOC)) {
				$resultsArray[] = $doc;
			}

			$plataformSQL->closeCursor();

			$totalRegistros = count($resultsArray);
			break;

		default:
			$filename = '../dbb_json.php';
			$configContent = file_get_contents($filename);

			$existing_data = json_decode(dbb_user, true);

			$search = (!empty($_POST['search'])) ? $_POST['search'] : '';
			$where = (!empty($_POST['where'])) ? $_POST['where'] : 0;
			$wheres = ($where == 1) ? "DESC" : "ASC";

			$searchResults = [];
			foreach ($existing_data as $key => $entry) {
				if (stripos($entry['name'], $search) !== false) {
					$searchResults[] = $entry;
				}
			}

			function sortByID($a, $b) {
				return $a['id'] - $b['id'];
			}

			usort($searchResults, ($wheres == "ASC") ? 'sortByID' : function ($a, $b) {
				return $b['id'] - $a['id'];
			});


			$totalRegistros = count($searchResults);

			$startIndex = (($pagination - 1) * $total);
			$resultsSlice = array_slice($searchResults, $startIndex, $total);

			$TotalRegistro = ceil($totalRegistros / $total);

			$resultsArray = $resultsSlice;
			$totalRegistrosPaginados = count($resultsArray);
			break;
	}

	ob_start();
	if (!empty($resultsArray)) {
		foreach ($resultsArray as $doc) {
	?>
		<tr data-id="<?php echo $doc['id']; ?>">
			<td data-label="">
				<div class="row g-3 align-items-center">
                    <a href="<?php echo URI; ?>/user/<?php echo $doc['id']; ?>" class="col-auto">
                        <span class="avatar" style="background-image: url(<?php echo $doc['avatar']; ?>)"></span>
                    </a>
                    <div class="col text-truncate">
                        <a href="<?php echo URI; ?>/user/<?php echo $doc['id']; ?>" class="text-reset d-block text-truncate"><?php echo $doc['name']; ?></a>
                        <div class="text-secondary text-truncate mt-n1"></div>
                    </div>
                </div>
			</td>
			<td data-label=""><?php echo rank('name', $doc['id']); ?></td>
			<td data-label=""><?php echo $doc['g_id']; ?></td>
			<td data-label=""><?php echo $doc['email']; ?></td>
			<td class="text-secondary" data-label=""><?php echo counttime($doc['since']); ?></td>
			<?php if ((has('dbb.soroly.user.*') OR has('dbb.soroly.user') OR has('dbb.soroly.user.delete'))) { ?>
			<td>
				<div class="btn-list dropdown flex-nowrap">
					<a href="<?php echo URI; ?>/user/<?php echo $doc['id']; ?>" class="btn-action dropdown" data-bs-toggle="dropdown" aria-label="Open user menu">
						<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path><path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path><path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path></svg>
					</a>
					<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
					  <?php if ((has('dbb.soroly.user.*') OR has('dbb.soroly.user'))) { ?>
					  <a class="dropdown-item" href="<?php echo URI; ?>/user/<?php echo $doc['id']; ?>">
						<svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"></path><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path></svg>
						Manage
					  </a>
					  <?php } ?>
					  <?php if ((has('dbb.soroly.group.*') OR has('dbb.soroly.group.user.add'))) { ?>
					  <a class="dropdown-item" href="<?php echo URI; ?>/group/add/<?php echo $doc['id']; ?>">
						<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon dropdown-item-icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
						Add Group
					  </a>
					  <?php } ?>
					  <?php if ((has('dbb.soroly.user.*') OR has('dbb.soroly.user.delete'))) { ?>
					  <a class="dropdown-item text-danger" href="<?php echo URI; ?>/user/<?php echo $doc['id']; ?>/delete">
						<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon dropdown-item-icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
						Delete
					  </a>
					  <?php } ?>
					</div>
					
				</div>
			</td>
			<?php } ?>
		</tr>
		
	<?php
		}
	} else {
		echo '<tr><td colspan="6">No results found.</td></tr>';
	}
	$html = ob_get_clean();

	$inicio = (($compag - 1) * $total) + 1;
	$fin = min($inicio + $total - 1, $totalRegistros);
	ob_start();
	echo paginationButtons($TotalRegistro, $compag, $total, 'updatePage');
	$paginations_list = ob_get_clean();
	
	$data = [
		'totalRegistros' => $totalRegistros,
		'inicio' => $inicio,
		'fin' => $fin,
		'html' => $html,
		'paginations_list' => $paginations_list,
	];

	echo json_encode($data);
}


if ($request == 'user_group') {
	
	$search = (!empty($_POST['search'])) ? $_POST['search'] : '';
	$where = (!empty($_POST['where'])) ? $_POST['where'] : 0;
	$pagination = (!empty($_POST['pag'])) ? $_POST['pag'] : 1;
	$total = (!empty($_POST['total'])) ? $_POST['total'] : 100;	
	$compag = (int)(!isset($pagination)) ? 1 : $pagination;

	switch(strtolower(DB_TYPE)) {
		case 'mysql':
			$wheres = ($where == 1) ? "ORDER BY id DESC" : "ORDER BY id ASC";
			$params = [$search];
			$searching = " WHERE `user` = ?";
			
			$plataformSQL = $connx->prepare("SELECT * FROM `dbb_group_user` $searching $wheres LIMIT " . (($compag - 1) * $total) . " , " . $total);
			$plataformSQL->execute($params);
			$TotalRegistro = ceil($plataformSQL->RowCount() / $total);

			$resultsArray = [];

			while ($doc = $plataformSQL->fetch(PDO::FETCH_ASSOC)) {
				$resultsArray[] = $doc;
			}

			$plataformSQL->closeCursor();

			$totalRegistros = count($resultsArray);
			break;

		default:
			$existing_data = json_decode(dbb_group_user, true);

			$search = (!empty($_POST['search'])) ? $_POST['search'] : '';
			$where = (!empty($_POST['where'])) ? $_POST['where'] : 0;
			$wheres = ($where == 1) ? "DESC" : "ASC";

			$searchResults = [];
			foreach ($existing_data as $key => $entry) {
				if ($entry['user'] == $search) {
					$searchResults[] = $entry;
				}
			}

			function sortByID($a, $b) {
				return $a['id'] - $b['id'];
			}

			usort($searchResults, ($wheres == "ASC") ? 'sortByID' : function ($a, $b) {
				return $b['id'] - $a['id'];
			});

			$totalRegistros = count($searchResults);

			$startIndex = (($pagination - 1) * $total);
			$resultsSlice = array_slice($searchResults, $startIndex, $total);

			$TotalRegistro = ceil($totalRegistros / $total);

			$resultsArray = $resultsSlice;
			$totalRegistrosPaginados = count($resultsArray);
			break;
	}

	ob_start();
	if (!empty($resultsArray)) {
		foreach ($resultsArray as $doc) {
			$group = groupInfo('id', $doc['group']);
	?>

		<div class="list-group-item" id="rowList_<?php echo $doc['id']; ?>">
			<div class="row align-items-center">
				<div class="col">
					<span style="color: <?php echo $group['color']; ?>;">
						<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-point"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /></svg>
					</span>
					<?php echo $group['name']; ?>
				</div>
				<?php if (has('dbb.soroly.group.*') OR has('dbb.soroly.group.user.remove')) { ?>
				<div class="col-auto">
					<button class="btn-action" onclick="removeThisUser('<?php echo $doc['id']; ?>');">
						<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-minus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /></svg>
					</button>
				</div>
				<?php } ?>
			</div>
		</div>
		
	<?php
		}
	} else {
		echo '<div class="list-group-item"><div class="row align-items-center"><div class="col">' . rank('name', $search) . '</div><div class="col-auto"><button class="btn-action"></button></div></div></div>';
	}
	$html = ob_get_clean();

	$inicio = (($compag - 1) * $total) + 1;
	$fin = min($inicio + $total - 1, $totalRegistros);
	ob_start();
	echo paginationButtons($TotalRegistro, $compag, $total, 'updatePage');
	$paginations_list = ob_get_clean();
	
	$data = [
		'totalRegistros' => $totalRegistros,
		'inicio' => $inicio,
		'fin' => $fin,
		'html' => $html,
		'paginations_list' => $paginations_list,
	];

	echo json_encode($data);
}

if ($request == 'user_license') {
	
	$dataid = $_POST['dataid'];
	$search = (!empty($_POST['search'])) ? $_POST['search'] : '';
	$where = (!empty($_POST['where'])) ? $_POST['where'] : 0;
	$pagination = (!empty($_POST['pag'])) ? $_POST['pag'] : 1;
	$total = (!empty($_POST['total'])) ? $_POST['total'] : 100;	
	$compag = (int)(!isset($pagination)) ? 1 : $pagination;

	switch(strtolower(DB_TYPE)) {
		case 'mysql':
			$wheres = ($where == 1) ? "ORDER BY id DESC" : "ORDER BY id ASC";
			$params = (!empty($search)) ? [$dataid, '%' . $search . '%', '%' . $search . '%'] : [$dataid];
			$searching = (!empty($search)) ? " WHERE `client` = ? OR `key` LIKE ? OR `scope` LIKE ? " : " WHERE `client` = ?";
			
			$plataformSQL = $connx->prepare("SELECT * FROM `dbb_license` $searching $wheres LIMIT " . (($compag - 1) * $total) . " , " . $total);
			$plataformSQL->execute($params);
			$TotalRegistro = ceil($plataformSQL->RowCount() / $total);

			$resultsArray = [];

			while ($doc = $plataformSQL->fetch(PDO::FETCH_ASSOC)) {
				$resultsArray[] = $doc;
			}

			$plataformSQL->closeCursor();

			$totalRegistros = count($resultsArray);
			break;

		default:
			$existing_data = json_decode(dbb_license, true);

			$search = (!empty($_POST['search'])) ? $_POST['search'] : '';
			$where = (!empty($_POST['where'])) ? $_POST['where'] : 0;
			$wheres = ($where == 1) ? "DESC" : "ASC";

			$searchResults = [];
			foreach ($existing_data as $key => $entry) {
				if ($entry['client'] == $dataid) {
					$searchResults[] = $entry;
				}
			}

			function sortByID($a, $b) {
				return $a['id'] - $b['id'];
			}

			usort($searchResults, ($wheres == "ASC") ? 'sortByID' : function ($a, $b) {
				return $b['id'] - $a['id'];
			});

			$totalRegistros = count($searchResults);

			$startIndex = (($pagination - 1) * $total);
			$resultsSlice = array_slice($searchResults, $startIndex, $total);

			$TotalRegistro = ceil($totalRegistros / $total);

			$resultsArray = $resultsSlice;
			$totalRegistrosPaginados = count($resultsArray);
			break;
	}

	ob_start();
	if (!empty($resultsArray)) {
		foreach ($resultsArray as $doc) {
		$userinfo = userInfo('g_id', $doc['client']);
		$creatorinfo = userInfo('id', $doc['creator']);
		$ips = explode('#', $doc['ip_cap']);
		$counts = ($doc['ip_cap'] == NULL) ? 0 : count($ips);
		$bound = ($doc['bound']) ? '<span class="text-success">Required</span>' : '<span class="text-danger">Optional</span>';
	?>
		<tr data-id="<?php echo $doc['id']; ?>">
			<td data-label="">
				<div class="row g-3 align-items-center">
                    <a href="<?php echo URI; ?>/user/<?php echo $userinfo['id']; ?>" class="col-auto">
                        <span class="avatar" style="background-image: url(<?php echo $userinfo['avatar']; ?>)"></span>
                    </a>
                    <div class="col text-truncate"></div>
                </div>
			</td>
			<td data-label=""><?php echo '<span class="text-danger">' . $doc['key'] . '</span>'; ?></td>
			<td data-label=""><?php echo '<span class="text-success">' . $doc['scope'] . '</span><br>' . $bound; ?></td>
			<td data-label=""><?php echo $counts; ?>/<?php echo $doc['ips']; ?></td>
			<td class="text-secondary" data-label=""><?php echo counttime($doc['since']); echo '<br>'; echo ($doc['expire'] == '-1') ? '<span class="text-warning">Never</span>' : counttimedown($doc['expire'], '<span class="text-danger">Finalized</span>'); ?></td>
			<td>
				<div class="btn-list dropdown flex-nowrap">
					<?php if ((has('dbb.soroly.license.*') OR has('dbb.soroly.license.edit') OR has('dbb.soroly.license.delete'))) { ?>
					<a href="<?php echo URI; ?>/license/<?php echo $doc['id']; ?>" class="btn-action dropdown" data-bs-toggle="dropdown" aria-label="Open user menu">
						<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path><path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path><path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path></svg>
					</a>
					
					<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
					  <a class="dropdown-item" href="<?php echo URI; ?>/license/<?php echo $doc['id']; ?>">
						<svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"></path><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path></svg>
						Manage
					  </a>
					  <?php if ((has('dbb.soroly.license.*') OR has('dbb.soroly.license.edit'))) { ?>
					  <a class="dropdown-item" href="<?php echo URI; ?>/license/<?php echo $doc['id']; ?>/edit">
						<svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path><path d="M16 5l3 3"></path></svg>
						Edit
					  </a>
					  <?php } ?>
					  
					  <?php if ((has('dbb.soroly.license.*') OR has('dbb.soroly.license.delete'))) { ?>
					  <a class="dropdown-item text-danger" href="<?php echo URI; ?>/license/<?php echo $doc['id']; ?>/delete">
						<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon dropdown-item-icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
						Delete
					  </a>
					  <?php } ?>
					</div>
					<?php } else { ?>
					<a href="<?php echo URI; ?>/license/<?php echo $doc['id']; ?>" class="btn-action">
						<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"></path><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path></svg>
					</a>
					<?php } ?>
					
				</div>
			</td>
		</tr>
		
	<?php
		}
	} else {
		echo '<tr><td colspan="6">No results found.</td></tr>';
	}
	$html = ob_get_clean();

	$inicio = (($compag - 1) * $total) + 1;
	$fin = min($inicio + $total - 1, $totalRegistros);
	ob_start();
	echo paginationButtons($TotalRegistro, $compag, $total, 'updatePages');
	$paginations_list = ob_get_clean();
	
	$data = [
		'totalRegistros' => $totalRegistros,
		'inicio' => $inicio,
		'fin' => $fin,
		'html' => $html,
		'paginations_list' => $paginations_list,
	];

	echo json_encode($data);
}


if ($request == 'users_group') {
	
	$search = (!empty($_POST['search'])) ? $_POST['search'] : '';
	$where = (!empty($_POST['where'])) ? $_POST['where'] : 0;
	$pagination = (!empty($_POST['pag'])) ? $_POST['pag'] : 1;
	$total = (!empty($_POST['total'])) ? $_POST['total'] : 100;	
	$compag = (int)(!isset($pagination)) ? 1 : $pagination;

	switch(strtolower(DB_TYPE)) {
		case 'mysql':
			$wheres = ($where == 1) ? "ORDER BY id DESC" : "ORDER BY id ASC";
			$params = [$search];
			$searching = " WHERE `group` = ?";
			
			$plataformSQL = $connx->prepare("SELECT * FROM `dbb_group_user` $searching $wheres LIMIT " . (($compag - 1) * $total) . " , " . $total);
			$plataformSQL->execute($params);
			$TotalRegistro = ceil($plataformSQL->RowCount() / $total);

			$resultsArray = [];

			while ($doc = $plataformSQL->fetch(PDO::FETCH_ASSOC)) {
				$resultsArray[] = $doc;
			}

			$plataformSQL->closeCursor();

			$totalRegistros = count($resultsArray);
			break;

		default:
			$existing_data = json_decode(dbb_group_user, true);

			$search = (!empty($_POST['search'])) ? $_POST['search'] : '';
			$where = (!empty($_POST['where'])) ? $_POST['where'] : 0;
			$wheres = ($where == 1) ? "DESC" : "ASC";

			$searchResults = [];
			foreach ($existing_data as $key => $entry) {
				if ($entry['group'] == $search) {
					$searchResults[] = $entry;
				}
			}

			function sortByID($a, $b) {
				return $a['id'] - $b['id'];
			}

			usort($searchResults, ($wheres == "ASC") ? 'sortByID' : function ($a, $b) {
				return $b['id'] - $a['id'];
			});

			$totalRegistros = count($searchResults);

			$startIndex = (($pagination - 1) * $total);
			$resultsSlice = array_slice($searchResults, $startIndex, $total);

			$TotalRegistro = ceil($totalRegistros / $total);

			$resultsArray = $resultsSlice;
			$totalRegistrosPaginados = count($resultsArray);
			break;
	}

	ob_start();
	if (!empty($resultsArray)) {
		foreach ($resultsArray as $doc) {
			$user = userInfo('id', $doc['user']);
	?>

		<div class="list-group-item" id="rowList_<?php echo $doc['id']; ?>">
			<div class="row align-items-center">
				<div class="col">
					<div class="row g-3 align-items-center">
						<a href="<?php echo URI; ?>/user/<?php echo $user['id']; ?>" class="col-auto">
							<span class="avatar" style="background-image: url(<?php echo $user['avatar']; ?>)"></span>
						</a>
						<div class="col text-truncate">
							<a href="<?php echo URI; ?>/user/<?php echo $user['id']; ?>" class="text-reset d-block text-truncate"><?php echo $user['name']; ?></a>
							<div class="text-secondary text-truncate mt-n1"></div>
						</div>
					</div>
				</div>
				<div class="col-auto">
					<?php if (has('dbb.soroly.group.*') OR has('dbb.soroly.group.user.remove')) { ?>
					<button class="btn-action" onclick="removeThisUser('<?php echo $doc['id']; ?>');">
						<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-minus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /></svg>
					</button>
					<?php } ?>
				</div>
			</div>
		</div>
	<?php
		}
	} else {
		echo '<div class="list-group-item"><div class="row align-items-center"><div class="col">Without users</div><div class="col-auto"><button class="btn-action"></button></div></div></div>';
	}
	$html = ob_get_clean();

	$inicio = (($compag - 1) * $total) + 1;
	$fin = min($inicio + $total - 1, $totalRegistros);
	ob_start();
	echo paginationButtons($TotalRegistro, $compag, $total, 'updatePage');
	$paginations_list = ob_get_clean();
	
	$data = [
		'totalRegistros' => $totalRegistros,
		'inicio' => $inicio,
		'fin' => $fin,
		'html' => $html,
		'paginations_list' => $paginations_list,
	];

	echo json_encode($data);
}

if ($request == 'permission_group') {
	
	$search = (!empty($_POST['search'])) ? $_POST['search'] : '';
	$where = (!empty($_POST['where'])) ? $_POST['where'] : 0;
	$pagination = (!empty($_POST['pag'])) ? $_POST['pag'] : 1;
	$total = (!empty($_POST['total'])) ? $_POST['total'] : 100;	
	$compag = (int)(!isset($pagination)) ? 1 : $pagination;

	switch(strtolower(DB_TYPE)) {
		case 'mysql':
			$wheres = ($where == 1) ? "ORDER BY id DESC" : "ORDER BY id ASC";
			$params = [$search];
			$searching = " WHERE `group` = ?";
			
			$plataformSQL = $connx->prepare("SELECT * FROM `dbb_group_permission` $searching $wheres LIMIT " . (($compag - 1) * $total) . " , " . $total);
			$plataformSQL->execute($params);
			$TotalRegistro = ceil($plataformSQL->RowCount() / $total);

			$resultsArray = [];

			while ($doc = $plataformSQL->fetch(PDO::FETCH_ASSOC)) {
				$resultsArray[] = $doc;
			}

			$plataformSQL->closeCursor();

			$totalRegistros = count($resultsArray);
			break;

		default:
			$existing_data = json_decode(dbb_group_permission, true);

			$search = (!empty($_POST['search'])) ? $_POST['search'] : '';
			$where = (!empty($_POST['where'])) ? $_POST['where'] : 0;
			$wheres = ($where == 1) ? "DESC" : "ASC";

			$searchResults = [];
			foreach ($existing_data as $key => $entry) {
				if ($entry['group'] == $search) {
					$searchResults[] = $entry;
				}
			}

			function sortByID($a, $b) {
				return $a['id'] - $b['id'];
			}

			usort($searchResults, ($wheres == "ASC") ? 'sortByID' : function ($a, $b) {
				return $b['id'] - $a['id'];
			});

			$totalRegistros = count($searchResults);

			$startIndex = (($pagination - 1) * $total);
			$resultsSlice = array_slice($searchResults, $startIndex, $total);

			$TotalRegistro = ceil($totalRegistros / $total);

			$resultsArray = $resultsSlice;
			$totalRegistrosPaginados = count($resultsArray);
			break;
	}

	ob_start();
	if (!empty($resultsArray)) {
		foreach ($resultsArray as $doc) {
	?>

		<div class="list-group-item" id="rowLists_<?php echo $doc['id']; ?>">
			<div class="row align-items-center">
				<div class="col">
					<?php echo $doc['permission']; ?>
				</div>
				<div class="col-auto">
					<?php if (has('dbb.soroly.group.*') OR has('dbb.soroly.group.permission.remove')) { ?>
					<button class="btn-action" onclick="removeThisPermission('<?php echo $doc['id']; ?>');">
						<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-minus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /></svg>
					</button>
					<?php } ?>
				</div>
			</div>
		</div>
		
	<?php
		}
	} else {
		echo '<div class="list-group-item"><div class="row align-items-center"><div class="col">Without users</div><div class="col-auto"><button class="btn-action"></button></div></div></div>';
	}
	$html = ob_get_clean();

	$inicio = (($compag - 1) * $total) + 1;
	$fin = min($inicio + $total - 1, $totalRegistros);
	ob_start();
	echo paginationButtons($TotalRegistro, $compag, $total, 'updatePage');
	$paginations_list = ob_get_clean();
	
	$data = [
		'totalRegistros' => $totalRegistros,
		'inicio' => $inicio,
		'fin' => $fin,
		'html' => $html,
		'paginations_list' => $paginations_list,
	];

	echo json_encode($data);
}
if ($request == 'group_user_add') {
	
	$search = (!empty($_POST['search'])) ? $_POST['search'] : '';
	$where = (!empty($_POST['where'])) ? $_POST['where'] : 0;
	$pagination = (!empty($_POST['pag'])) ? $_POST['pag'] : 1;
	$total = (!empty($_POST['total'])) ? $_POST['total'] : 100;	
	$compag = (int)(!isset($pagination)) ? 1 : $pagination;

	switch(strtolower(DB_TYPE)) {
		case 'mysql':
			$wheres = ($where == 1) ? "ORDER BY id DESC" : "ORDER BY id ASC";
			$params = ['%' . $search . '%'];
			$searching = " WHERE `name` LIKE ?";
			
			$plataformSQL = $connx->prepare("SELECT * FROM `dbb_group` $searching $wheres LIMIT " . (($compag - 1) * $total) . " , " . $total);
			$plataformSQL->execute($params);
			$TotalRegistro = ceil($plataformSQL->RowCount() / $total);

			$resultsArray = [];

			while ($doc = $plataformSQL->fetch(PDO::FETCH_ASSOC)) {
				$resultsArray[] = $doc;
			}

			$plataformSQL->closeCursor();

			$totalRegistros = count($resultsArray);
			break;

		default:
			$existing_data = json_decode(dbb_group, true);

			$search = (!empty($_POST['search'])) ? $_POST['search'] : '';
			$where = (!empty($_POST['where'])) ? $_POST['where'] : 0;
			$wheres = ($where == 1) ? "DESC" : "ASC";

			$searchResults = [];
			foreach ($existing_data as $key => $entry) {
				if (stripos($entry['name'], $search) !== false) {
					$searchResults[] = $entry;
				}
			}

			function sortByID($a, $b) {
				return $a['id'] - $b['id'];
			}

			usort($searchResults, ($wheres == "ASC") ? 'sortByID' : function ($a, $b) {
				return $b['id'] - $a['id'];
			});

			$totalRegistros = count($searchResults);

			$startIndex = (($pagination - 1) * $total);
			$resultsSlice = array_slice($searchResults, $startIndex, $total);

			$TotalRegistro = ceil($totalRegistros / $total);

			$resultsArray = $resultsSlice;
			$totalRegistrosPaginados = count($resultsArray);
			break;
	}

	ob_start();
	if (!empty($resultsArray)) {
		$i=0;
		foreach ($resultsArray as $doc) {
			$groups = groupUserInfo('group', $doc['id'], 'user', $_POST['userid']);
	?>

                        <div class="list-group-item <?php echo ($groups['group'] == $doc['id']) ? 'active' : (($doc['default']) ? 'active' : ''); ?>">
                          <div class="row align-items-center">
                            <div class="col-auto"><input type="checkbox" class="form-check-input" <?php echo ($groups['group'] == $doc['id']) ? 'onclick="removeThisGroupToUser(\'' . $groups['id'] . '\');" checked=""' : ''; echo ($doc['default']) ? 'checked="" disabled' : 'onclick="addThisGroupToUser(\'' . $doc['id'] . '\', \'' . $_POST['userid'] . '\');" '; ?>></div>
                            <div class="col-auto">
                              <a href="<?php echo URI; ?>/group/<?php echo $doc['id']; ?>">
                                <span class="avatar"><?php echo simplyText($doc['name']); ?></span>
                              </a>
                            </div>
                            <div class="col text-truncate">
                              <a href="<?php echo URI; ?>/group/<?php echo $doc['id']; ?>" class="text-reset d-block"><?php echo $doc['name']; ?></a>
                              <div class="d-block text-secondary text-truncate mt-n1"><?php echo ($groups['group'] == $doc['id']) ? 'Group selected for the user.' : 'Group not selected for the user.'; ?></div>
                            </div>
                          </div>
                        </div>
		
	<?php
		$i++;
		}
	} else {
		echo '<div class="list-group-item"><div class="row align-items-center"><div class="col">Without users</div><div class="col-auto"><button class="btn-action"></button></div></div></div>';
	}
	$html = ob_get_clean();

	$inicio = (($compag - 1) * $total) + 1;
	$fin = min($inicio + $total - 1, $totalRegistros);
	ob_start();
	echo paginationButtons($TotalRegistro, $compag, $total, 'updatePage');
	$paginations_list = ob_get_clean();
	
	$data = [
		'totalRegistros' => $totalRegistros,
		'inicio' => $inicio,
		'fin' => $fin,
		'html' => $html,
		'paginations_list' => $paginations_list,
	];

	echo json_encode($data);
}
?>