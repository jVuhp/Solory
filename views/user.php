<?php 
	if (!$page[1]) {
?>

	<div class="page-header mb-3">
	  <div class="row align-items-center">
		<div class="col">
		  <div class="page-pretitle">
			Users
		  </div>
		  <h2 class="page-title">
			Overview
		  </h2>
		</div>
		<div class="col-auto ms-auto"></div>
	  </div>
	</div>
    <div class="col-12 mb-3">
		<div class="card">
			<div class="card-body border-bottom py-3">
                <div class="d-flex">
                    <div class="text-secondary">
                        Show
                        <div class="mx-2 d-inline-block">
							<select class="form-select form-select-sm" id="total">
								<option value="20" selected>20</option>
								<option value="60">60</option>
								<option value="100">100</option>
								<option value="200">200</option>
								<option value="500">500</option>
							</select>
                        </div>
                        entries
                    </div>
                    <div class="ms-auto text-secondary">
                        Search:
                        <div class="ms-2 d-inline-block">
							<input type="text" class="form-control form-control-sm" aria-label="Search invoice" id="search">
							<input type="hidden" value="1" id="paginationID">
                        </div>
                    </div>
					<select id="where" hidden>
						<option value="1" selected>New</option>
						<option value="">Old</option>
					</select>
                </div>
            </div>
				<div class="table-responsive mb-3">
			
                    <table class="table card-table table-vcenter text-nowrap datatable table-hover">
                      <thead>
                        <tr>
                          <th>User</th>
                          <th>Last Group</th>
                          <th>Google ID</th>
                          <th>Email</th>
                          <th>Date</th>
                          <?php if ((has('dbb.soroly.user.*') OR has('dbb.soroly.user') OR has('dbb.soroly.user.delete'))) { ?><th class="w-1">Actions</th><?php } ?>
                        </tr>
                      </thead>
                      <tbody id="content_table" class="content_table">
						<tr><td colspan="12">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-loader">
									  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
									  <path d="M12 6l0 -3" />
									  <path d="M16.25 7.75l2.15 -2.15" />
									  <path d="M18 12l3 0" />
									  <path d="M16.25 16.25l2.15 2.15" />
									  <path d="M12 18l0 3" />
									  <path d="M7.75 16.25l-2.15 2.15" />
									  <path d="M6 12l-3 0" />
									  <path d="M7.75 7.75l-2.15 -2.15" />
						</svg>
						Loading.
						<span class="animated-ellipsis"></span>
						</td></tr></tbody>
                    </table>
					
                </div>
			<div class="card-footer d-flex align-items-center">
				<div class="col-lg-6 col-md-6 col-sm-12">
					<ul class="pagination m-0 ms-auto" id="pagination_list"></ul>
				</div>
				<div class="text-end col-lg-6 col-md-6 col-sm-12">
					<p class="m-0 text-secondary" id="pagination_info"></p>
				</div>
			</div>
		</div>
	</div>
<script>

$(document).ready(function() {
	
    var e = $('#total');
    var w = $('#where');
    var s = $('#search');

    window.updateAdminSQL = function() {
        var pag = $('#paginationID').val();
        var total = e.val();
        var where = w.val();
        var search = s.val();
        var result = 'user';

        $.ajax({
            url: site_domain + '/execute/table.php',
            type: 'POST',
            data: { result: result, search: search, where: where, pag: pag, total: total },
            success: function(response) {
                var jsonData = JSON.parse(response);
				
				var lin1 = [':compag_to:', ':end:', ':results:'];
				var lin2 = [jsonData.inicio, jsonData.fin, jsonData.totalRegistros];
				var lin3 = 'Showing :compag_to: to :end: of :results: entries';
				
                $('#content_table').html(jsonData.html);
                $('#pagination_info').text(str_replaces(lin1, lin2, lin3));
                $('#pagination_list').html(jsonData.paginations_list);

			}
		});
	}
	
	window.updatePage = function(id) {
		var paginationID = $('#paginationID');
		paginationID.val(id);
		updateAdminSQL();
	}

    e.change(updateAdminSQL);
    w.change(updateAdminSQL);
    s.change(updateAdminSQL);
    s.on('input', updateAdminSQL);
	
	updateAdminSQL();

});
</script>
<?php 
	} else {
	$resultsArray = [];
	switch(strtolower(DB_TYPE)) {
		case 'mysql':
			$plataformSQL = $connx->prepare("SELECT * FROM `$dbb_user` WHERE `id` = ?");
			$plataformSQL->execute([$page[1]]);

			while ($doc = $plataformSQL->fetch(PDO::FETCH_ASSOC)) {
				$resultsArray[] = $doc;
			}
			break;

		default:
			$filename = 'dbb_json.php';
			$configContent = file_get_contents($filename);

			$existing_data = json_decode(dbb_user, true);
			
			foreach ($existing_data as $key => $entry) {
				if ($entry['id'] == $page[1]) {
					$resultsArray[] = $entry;
				}
			}
			break;
	}
	$resultsArray = $resultsArray[0];
	
	if (isset($resultsArray)) {
	
	if (!(has('dbb.soroly.user.*') || has('dbb.soroly.user')) && $resultsArray['id'] != $_SESSION[$dbb_user]['id']) {
		echo '<script>location.href = "' . URI . '/license"; </script>';
	}
	if ($page[2] == 'delete' OR $subpage[2] == 'delete') {
		if (!(has('dbb.soroly.user.*') || has('dbb.soroly.user.delete'))) {
			echo '<script>location.href = "' . URI . '/license"; </script>';
		}
?>
	<div class="page-header mb-3">
	  <div class="row align-items-center">
		<div class="col">
		  <div class="page-pretitle">
			<a href="<?php echo URI; ?>/user" class="text-muted">Users</a> - <a href="<?php echo URI; ?>/user/<?php echo $resultsArray['id']; ?>" class="text-muted"><?php echo $resultsArray['name']; ?></a> - Deleting
		  </div>
		  <h2 class="page-title">
			Sure on this?
		  </h2>
		</div>
		<div class="col-auto ms-auto"></div>
	  </div>
	</div>
	<div class="row row-cards">
              <div class="col-lg-12">

				<div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-auto">
                        <span class="avatar rounded"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-alert-triangle"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 9v4" /><path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z" /><path d="M12 16h.01" /></svg></span>
                      </div>
                      <div class="col">
                        <div class="font-weight-medium">Safe to delete the user?</div>
                        <div class="text-secondary">Once accepted, there will be no return or recovery of data and everything that has to do with the user will be deleted.</div>
                      </div>
                      <div class="col-auto">
                        <div class="dropdown">
                          <a href="#" class="btn-action" data-bs-toggle="dropdown" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path><path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path><path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path></svg>
                          </a>
                          <div class="dropdown-menu dropdown-menu-end">
                            <a href="<?php echo URI; ?>/user/<?php echo $page[1]; ?>/delete/confirm" class="dropdown-item text-danger" id="deleting_license">Confirm</a>
                            <a href="<?php echo URI; ?>/user" class="dropdown-item">Cancel</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
    </div>

<script>

document.addEventListener('DOMContentLoaded', function() {
	
	$('#deleting_license').on('click', function(e) {
        e.preventDefault();
        var formData = $(this).serializeArray();
		formData.push({ name: 'result', value: 'delete_user' }, { name: 'dataid', value: '<?php echo $page[1]; ?>' });
		
		$.ajax({
			type: "POST",
			url: site_domain + '/execute/action.php',
			data: formData,
			success: function(response) {
				var jsonData = JSON.parse(response);
				alertify.set('notifier','position', 'top-right');
				alertify.notify(jsonData.message, jsonData.type, 5, function(){  console.log(jsonData.message); });
				if (jsonData.type == 'success') {
					location.href = site_domain + '/user';
				}
			}
		});
	});
	

});
</script>
<?php
	} else {
?>

	<div class="page-header mb-3">
	  <div class="row align-items-center">
		<div class="col">
		  <div class="page-pretitle">
			<a href="<?php echo URI; ?>/user" class="text-muted">Users</a> - Viewing
		  </div>
		  <h2 class="page-title">
			Overview
		  </h2>
		</div>
		<div class="col-auto ms-auto"></div>
	  </div>
	</div>
	<div class="col-md-12 mb-3">
                <div class="card">
                  <div class="card-body">
                    <div class="row g-2 align-items-center">
                      <div class="col-auto">
                        <span class="avatar avatar-lg" style="background-image: url(<?php echo $resultsArray['avatar']; ?>)"></span>
                      </div>
                      <div class="col">
                        <h4 class="card-title m-0">
                          <a href="<?php echo URI; ?>/user/<?php echo $resultsArray['id']; ?>"><?php echo $resultsArray['name']; ?></a>
                        </h4>
                        <div class="text-secondary">
                          <?php echo $resultsArray['email']; ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
	<div class="row row-cards">
		<div class="col-md-4 mb-3">
			<div class="card">
                      <div class="card-body">
						<div class="row g-2 align-items-center">
							<div class="col">
								<div class="card-title">Information</div>
							</div>
							
							<div class="col-auto">
								<?php if (has('dbb.soroly.user.*') || has('dbb.soroly.license.*') || has('dbb.soroly.user.delete') || has('dbb.soroly.license.new')) { ?>
								<div class="dropdown">
								  <a href="#" class="btn-action" data-bs-toggle="dropdown" aria-expanded="false">
									<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path><path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path><path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path></svg>
								  </a>
								  <div class="dropdown-menu dropdown-menu-end" style="">
									<?php if (has('dbb.soroly.license.*') || has('dbb.soroly.license.new')) { ?>
									<a href="<?php echo URI; ?>/license/new/<?php echo $resultsArray['g_id']; ?>" class="dropdown-item text-primary">Create License</a>
									<?php } ?>
									<?php if (has('dbb.soroly.user.*') || has('dbb.soroly.user.delete')) { ?>
									<a href="<?php echo URI; ?>/user/<?php echo $resultsArray['id']; ?>/delete" class="dropdown-item text-danger">Delete</a>
									<?php } ?>
								  </div>
								</div>
								<?php } ?>
							</div>
						</div>
                        <div class="mb-2">
							<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon me-2 text-secondary"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20.945 11a9 9 0 1 1 -3.284 -5.997l-2.655 2.392a5.5 5.5 0 1 0 2.119 6.605h-4.125v-3h7.945z" /></svg>
							<strong><?php echo $resultsArray['g_id']; ?></strong>
                        </div>
                        <div class="mb-2">
							<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon me-2 text-secondary"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7.5 7.5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M3 6v5.172a2 2 0 0 0 .586 1.414l7.71 7.71a2.41 2.41 0 0 0 3.408 0l5.592 -5.592a2.41 2.41 0 0 0 0 -3.408l-7.71 -7.71a2 2 0 0 0 -1.414 -.586h-5.172a3 3 0 0 0 -3 3z" /></svg>
							<strong><?php echo $resultsArray['name']; ?></strong>
                        </div>
                        <div class="mb-2">
							<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon me-2 text-secondary"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" /><path d="M3 7l9 6l9 -6" /></svg>
							<strong><?php echo $resultsArray['email']; ?></strong>
                        </div>
                        <div class="mb-2">
							<svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-secondary" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z"></path><path d="M16 3v4"></path><path d="M8 3v4"></path><path d="M4 11h16"></path><path d="M11 15h1"></path><path d="M12 15v3"></path></svg>
							Created  <strong><?php echo counttime($resultsArray['since']); ?></strong>
                        </div>
                      </div>
            </div>
		</div>
		<div class="col-md-8 mb-3">
		
			<div class="row" align="left" style="display: none;">
				<div class="col" align="center">
					<input type="text" placeholder="Search..." class="form-control" id="search" value="<?php echo $page[1]; ?>">
				</div>
				<div class="col" align="right">
					<select class="form-select" style="width: 20%;" id="total">
						<option value="20" selected>20</option>
						<option value="60">60</option>
						<option value="100">100</option>
						<option value="200">200</option>
						<option value="500">500</option>
                    </select>
					<select id="where" hidden>
						<option value="1" selected>New</option>
						<option value="">Old</option>
					</select>
					<input type="hidden" value="1" id="paginationID">
				</div>
			</div>
			<div class="card">
                      <div class="card-header row g-2 align-items-center">
						
							<div class="col">
								<h3 class="card-title">Groups</h3>
							</div>
							
							<div class="col-auto">
								<?php if (has('dbb.soroly.group.*') || has('dbb.soroly.group.user.add')) { ?>
								<div class="dropdown">
								  <a href="#" class="btn-action" data-bs-toggle="dropdown" aria-expanded="false">
									<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path><path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path><path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path></svg>
								  </a>
								  <div class="dropdown-menu dropdown-menu-end" style="">
									<a href="<?php echo URI; ?>/group/add/<?php echo $resultsArray['id']; ?>" class="dropdown-item">Add Group</a>
								  </div>
								</div>
								<?php } ?>
							</div>
                      </div>
                      <div class="list-group list-group-flush" id="content_table">

						<div class="list-group-item">
							<div class="row align-items-center">
								<div class="col">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-loader">
									  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
									  <path d="M12 6l0 -3" />
									  <path d="M16.25 7.75l2.15 -2.15" />
									  <path d="M18 12l3 0" />
									  <path d="M16.25 16.25l2.15 2.15" />
									  <path d="M12 18l0 3" />
									  <path d="M7.75 16.25l-2.15 2.15" />
									  <path d="M6 12l-3 0" />
									  <path d="M7.75 7.75l-2.15 -2.15" />
									</svg>
									Loading.
									<span class="animated-ellipsis"></span>
								</div>
								<div class="col-auto">
									<button class="btn-action">
									</button>
								</div>
							</div>
						</div>
						
                      </div>
			</div>
		</div>
		
		<div class="col-12 mb-3">
			<div class="card">
				<div class="row" align="left" style="display: none;">
					<div class="col" align="center">
						<input type="text" placeholder="Search..." class="form-control" id="searchs">
					</div>
					<div class="col" align="right">
						<select class="form-select" style="width: 20%;" id="totals">
							<option value="20" selected>20</option>
							<option value="60">60</option>
							<option value="100">100</option>
							<option value="200">200</option>
							<option value="500">500</option>
						</select>
						<select id="wheres" hidden>
							<option value="1" selected>New</option>
							<option value="">Old</option>
						</select>
						<input type="hidden" value="1" id="paginationIDs">
					</div>
				</div>
				<div class="table-responsive">
				
						<table class="table card-table table-vcenter text-nowrap datatable table-hover">
						  <thead>
							<tr>
							  <th>Client</th>
							  <th>Key</th>
							  <th>Scope</th>
							  <th>IP Cap</th>
							  <th>Date</th>
							  <th class="w-1">Actions</th>
							</tr>
						  </thead>
						  <tbody id="content_tables" class="content_table"></tbody>
						</table>
						
				</div>
				<div class="card-footer d-flex align-items-center">
						<div class="col-lg-6 col-md-6 col-sm-12">
							<ul class="pagination m-0 ms-auto" id="pagination_list"></ul>
						</div>
						<div class="text-end col-lg-6 col-md-6 col-sm-12">
							<p class="m-0 text-secondary" id="pagination_info"></p>
						</div>
				</div>
			</div>
		</div>
	</div>
<?php if (has('dbb.soroly.group.*') OR has('dbb.soroly.group.user.remove')) { ?>
<script>
function removeThisUser(id) {
    $.ajax({
        type: "POST",
        url: site_domain + "/execute/action.php",
        data: { result: 'delete_user_in_group', dataid: id },
        dataType: "json",
        success: function(response) {
				alertify.set('notifier','position', 'top-right');
				alertify.notify(response.message, response.type, 5, function(){  console.log(response.message); });
				if (response.type == 'success') {
					$('#rowList_' + id).remove();
				}
        },
        error: function(error) {
            console.error("Error ", error);
        }
    });
}
</script>
<?php } ?>
<script>

$(document).ready(function() {
	
    var e = $('#total');
    var w = $('#where');
    var s = $('#search');
    var es = $('#totals');
    var ws = $('#wheres');
    var ss = $('#searchs');

    window.updateAdminSQL = function() {
        var pag = $('#paginationID').val();
        var total = e.val();
        var where = w.val();
        var search = s.val();
        var result = 'user_group';

        $.ajax({
            url: site_domain + '/execute/table.php',
            type: 'POST',
            data: { result: result, search: search, where: where, pag: pag, total: total },
            success: function(response) {
                var jsonData = JSON.parse(response);
                $('#content_table').html(jsonData.html);
			}
		});
	}
	
	window.updatePage = function(id) {
		var paginationID = $('#paginationID');
		paginationID.val(id);
		updateAdminSQL();
	}

    e.change(updateAdminSQL);
    w.change(updateAdminSQL);
    s.change(updateAdminSQL);
    s.on('input', updateAdminSQL);
	


    window.updateAdminSQLs = function() {
        var pag = $('#paginationIDs').val();
        var total = es.val();
        var where = ws.val();
        var search = ss.val();
        var result = 'user_license';
        var dataid = '<?php echo $resultsArray['g_id']; ?>';

        $.ajax({
            url: site_domain + '/execute/table.php',
            type: 'POST',
            data: { result: result, search: search, where: where, pag: pag, total: total, dataid: dataid },
            success: function(response) {
                var jsonData = JSON.parse(response);
				
				var lin1 = [':compag_to:', ':end:', ':results:'];
				var lin2 = [jsonData.inicio, jsonData.fin, jsonData.totalRegistros];
				var lin3 = 'Showing :compag_to: to :end: of :results: entries';
				
                $('#content_tables').html(jsonData.html);
                $('#pagination_info').text(str_replaces(lin1, lin2, lin3));
                $('#pagination_list').html(jsonData.paginations_list);

			}
		});
	}
	
	window.updatePages = function(id) {
		var paginationID = $('#paginationIDs');
		paginationID.val(id);
		updateAdminSQLs();
	}

    es.change(updateAdminSQLs);
    ws.change(updateAdminSQLs);
    ss.change(updateAdminSQLs);
    ss.on('input', updateAdminSQLs);
	
	updateAdminSQLs();
	updateAdminSQL();

});
</script>
<?php
	}
	} else {
?>
	<div class="page page-center">
      <div class="container-tight py-4">
        <div class="empty">
          <div class="empty-img"><img src="https://devbybit.com/demos/tablerio/static/illustrations/undraw_quitting_time_dm8t.svg" height="128" alt="">
          </div>
          <p class="empty-title">Non-existent user</p>
          <p class="empty-subtitle text-secondary">
            Sorry, this user does not exist or is not active.
          </p>
          <div class="empty-action">
            <a href="<?php echo URI; ?>/user/<?php echo $page[1]; ?>" class="btn btn-ghost-azure">
				<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19.933 13.041a8 8 0 1 1 -9.925 -8.788c3.899 -1 7.935 1.007 9.425 4.747" /><path d="M20 4v5h-5" /></svg>
				Try again
            </a>
            <a href="<?php echo URI; ?>/user" class="btn btn-primary">
				<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 12l14 0"></path><path d="M5 12l6 6"></path><path d="M5 12l6 -6"></path></svg>
				Take me home
            </a>
          </div>
        </div>
      </div>
    </div>
<?php
	}
	}
?>