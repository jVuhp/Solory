<?php

if ($page[1] == 'new' OR $codeAuth[0] == 'group/new') {

		if (!(has('dbb.soroly.group.*') || has('dbb.soroly.group.new'))) {
			echo '<script>location.href = "' . URI . '/group"; </script>';
		}
?>
	<div class="page-header mb-3">
	  <div class="row align-items-center">
		<div class="col">
		  <div class="page-pretitle">
			<a href="<?php echo URI; ?>/group" class="text-muted">Groups</a> - Actions
		  </div>
		  <h2 class="page-title">
			Creating new group.
		  </h2>
		</div>
		<div class="col-auto ms-auto">
		</div>
	  </div>
	</div>
    <div class="col-12 mb-3">
		<form class="accordion" id="generating_new_license" method="POST">
				
			<div class="accordion-item mb-3">
                <h2 class="accordion-header bg-indigo-lt" id="heading-1">
					<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-1" aria-expanded="true">Configuration #1</button>
                </h2>
                <div id="collapse-1" class="accordion-collapse  collapse show" data-bs-parent="#generating_new_license" style="">
                    <div class="accordion-body pt-0">
						
						<div class="card-body mt-2 license-form">
						
						  <div class="mb-3">
							<label class="form-label required" for="name">Name</label>
							<div>
								<div class="row g-2">
									<div class="col input-icon">
										<span class="input-icon-addon">
											<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24" style="margin-left: 10px;"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7.5 7.5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M3 6v5.172a2 2 0 0 0 .586 1.414l7.71 7.71a2.41 2.41 0 0 0 3.408 0l5.592 -5.592a2.41 2.41 0 0 0 0 -3.408l-7.71 -7.71a2 2 0 0 0 -1.414 -.586h-5.172a3 3 0 0 0 -3 3z" /></svg>
										</span>
										<input type="text" class="form-control" name="name" id="name" placeholder="Owner">
									</div>
									<div class="col-auto">
										<label class="form-selectgroup-item">
										<input type="color" class="form-control form-control-color" value="#0054a6" name="color" id="color" title="Choose your color">
										</label>
									</div>
									<div class="col-auto">
										<label class="form-selectgroup-item">
										<input type="checkbox" name="default" value="1" class="form-selectgroup-input">
										<span class="form-selectgroup-label">Default</span>
										</label>
									</div>
								</div>
								<small class="form-hint pt-0"></small>
							</div>
						  </div>
				  
						</div>
                    </div>
                </div>
			</div>

			<button class="btn" type="submit">
				<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon "><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8.56 3.69a9 9 0 0 0 -2.92 1.95" /><path d="M3.69 8.56a9 9 0 0 0 -.69 3.44" /><path d="M3.69 15.44a9 9 0 0 0 1.95 2.92" /><path d="M8.56 20.31a9 9 0 0 0 3.44 .69" /><path d="M15.44 20.31a9 9 0 0 0 2.92 -1.95" /><path d="M20.31 15.44a9 9 0 0 0 .69 -3.44" /><path d="M20.31 8.56a9 9 0 0 0 -1.95 -2.92" /><path d="M15.44 3.69a9 9 0 0 0 -3.44 -.69" /><path d="M9 12l2 2l4 -4" /></svg>
				Create
			</button>
		</form>
	</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
	
	$('#generating_new_license').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serializeArray();
		formData.push({ name: 'result', value: 'create_group' });
		var i = 0;
		var expireValue = $('#name').val();
		if (expireValue.trim() === '') { $('#name').addClass('is-invalid'); i++; } else { $('#name').removeClass('is-invalid'); }
		
		if (i > 0) { return; }
		
		$.ajax({
			type: "POST",
			url: site_domain + '/execute/action.php',
			data: formData,
			success: function(response) {
				var jsonData = JSON.parse(response);
				alertify.set('notifier','position', 'top-right');
				alertify.notify(jsonData.message, jsonData.type, 5, function(){  console.log(jsonData.message); });
				if (jsonData.type == 'success') {
					location.href = site_domain + '/group/' + jsonData.id;
				}
			}
		});
	});
	

});
</script>
<?php 

} else if ($page[1] == 'add' OR $codeAuth[0] == 'group/add') {
		if (!(has('dbb.soroly.group.*') || has('dbb.soroly.group.user.add'))) {
			echo '<script>location.href = "' . URI . '/group"; </script>';
		}
?>

	<div class="page-header mb-3">
	  <div class="row align-items-center">
		<div class="col">
		  <div class="page-pretitle">
			<a href="<?php echo URI; ?>/group" class="text-muted">Groups</a> - Add - <?php echo userInfo('id', $subpage[2])['name']; ?>
		  </div>
		  <h2 class="page-title">
			Overview
		  </h2>
		</div>
		<div class="col-auto ms-auto"></div>
	  </div>
	</div>
    <div class="col-12">
                    <div class="card">
                      <div class="card-header">
                        <h3 class="card-title">Select groups</h3>
						
						<div class="ms-auto text-secondary">
							Search:
							<div class="ms-2 d-inline-block">
								<input type="text" class="form-control form-control-sm" aria-label="Search invoice" id="search">
							</div>
						</div>
                      </div>
                      <div class="list-group list-group-flush" id="content_table">
					  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-loader text-center">
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
						
                      </div>
                    </div>
    </div>
<?php if (has('dbb.soroly.group.*') OR has('dbb.soroly.group.user.add')) { ?>
<script>
function addThisGroupToUser(id, user) {
    $.ajax({
        type: "POST",
        url: site_domain + "/execute/action.php",
        data: { result: 'add_user_in_group', dataid: id, user: user },
        dataType: "json",
        success: function(response) {
            
				alertify.set('notifier','position', 'top-right');
				alertify.notify(response.message, response.type, 5, function(){  console.log(response.message); });
				if (response.type == 'success') {
					setTimeout(function() { updateAdminSQL(); }, 1000);
				}
        },
        error: function(error) {
            console.error("Error ", error);
        }
    });
}
</script>
<?php } ?>
<?php if (has('dbb.soroly.group.*') OR has('dbb.soroly.group.user.remove')) { ?>
<script>
function removeThisGroupToUser(id, user) {
    $.ajax({
        type: "POST",
        url: site_domain + "/execute/action.php",
        data: { result: 'delete_user_in_group', dataid: id },
        dataType: "json",
        success: function(response) {
            
				alertify.set('notifier','position', 'top-right');
				alertify.notify(response.message, response.type, 5, function(){  console.log(response.message); });
				if (response.type == 'success') {
					setTimeout(function() { updateAdminSQL(); }, 1500);
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
	var s = $('#search');

    window.updateAdminSQL = function() {
        var search = s.val();
        var result = 'group_user_add';

        $.ajax({
            url: site_domain + '/execute/table.php',
            type: 'POST',
            data: { result: result, search: search, where: '1', pag: '1', total: '500', userid: '<?php echo $page[2]; ?>' },
            success: function(response) {
                var jsonData = JSON.parse(response);
				
                $('#content_table').html(jsonData.html);

			}
		});
	}
    s.change(updateAdminSQL);
    s.on('input', updateAdminSQL);
	
	updateAdminSQL();

});
</script>
<?php
} else { 

	if (!$page[1]) {
		if (!(has('dbb.soroly.group.*') || has('dbb.soroly.group'))) {
			echo '<script>location.href = "' . URI . '/group"; </script>';
		}
?>

	<div class="page-header mb-3">
	  <div class="row align-items-center">
		<div class="col">
		  <div class="page-pretitle">
			Groups
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
                          <th>Name</th>
                          <th>Default</th>
                          <th>Creator</th>
                          <th>Registered</th>
                          <?php if ((has('dbb.soroly.group.*') OR has('dbb.soroly.group') OR has('dbb.soroly.group.edit') OR has('dbb.soroly.group.delete'))) { ?><th class="w-1">Actions</th><?php } ?>
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
        var result = 'group';

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
			$plataformSQL = $connx->prepare("SELECT * FROM `dbb_group` WHERE `id` = ?");
			$plataformSQL->execute([$page[1]]);

			while ($doc = $plataformSQL->fetch(PDO::FETCH_ASSOC)) {
				$resultsArray[] = $doc;
			}
			break;

		default:
			$filename = 'dbb_json.php';
			$configContent = file_get_contents($filename);

			$existing_data = json_decode(dbb_group, true);
			
			foreach ($existing_data as $key => $entry) {
				if ($entry['id'] == $page[1]) {
					$resultsArray[] = $entry;
				}
			}
			break;
	}
	$resultsArray = $resultsArray[0];
	$creatorinfo = userInfo('id', $resultsArray['creator']);

	
	if (isset($resultsArray)) {
	if ($page[2] == 'edit' OR $subpage[2] == 'edit') {
		if (!(has('dbb.soroly.group.*') || has('dbb.soroly.group.edit'))) {
			echo '<script>location.href = "' . URI . '/group"; </script>';
		}
?>

	<div class="page-header mb-3">
	  <div class="row align-items-center">
		<div class="col">
		  <div class="page-pretitle">
			<a href="<?php echo URI; ?>/group" class="text-muted">Groups</a> - Actions
		  </div>
		  <h2 class="page-title">
			Editting group.
		  </h2>
		</div>
		<div class="col-auto ms-auto">
		</div>
	  </div>
	</div>
    <div class="col-12 mb-3">
		<form class="accordion" id="generating_new_license" method="POST">
				
			<div class="accordion-item mb-3">
                <h2 class="accordion-header bg-indigo-lt" id="heading-1">
					<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-1" aria-expanded="true">Configuration #1</button>
                </h2>
                <div id="collapse-1" class="accordion-collapse  collapse show" data-bs-parent="#generating_new_license" style="">
                    <div class="accordion-body pt-0">
						
						<div class="card-body mt-2 license-form">
						
						  <div class="mb-3">
							<label class="form-label required" for="name">Name</label>
							<div>
								<div class="row g-2">
									<div class="col input-icon">
										<span class="input-icon-addon">
											<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24" style="margin-left: 10px;"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7.5 7.5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M3 6v5.172a2 2 0 0 0 .586 1.414l7.71 7.71a2.41 2.41 0 0 0 3.408 0l5.592 -5.592a2.41 2.41 0 0 0 0 -3.408l-7.71 -7.71a2 2 0 0 0 -1.414 -.586h-5.172a3 3 0 0 0 -3 3z" /></svg>
										</span>
										<input type="text" class="form-control" name="name" id="name" placeholder="Owner" value="<?php echo $resultsArray['name']; ?>">
										<input type="hidden" class="form-control" name="group" id="group" placeholder="" value="<?php echo $resultsArray['id']; ?>">
									</div>
									<div class="col-auto">
										<label class="form-selectgroup-item">
										<input type="color" class="form-control form-control-color" value="<?php echo $resultsArray['color']; ?>" name="color" id="color" title="Choose your color">
										</label>
									</div>
									<div class="col-auto">
										<label class="form-selectgroup-item">
										<input type="checkbox" name="default" value="1" <?php echo ($resultsArray['default']) ? 'checked=""' : ''; ?> class="form-selectgroup-input">
										<span class="form-selectgroup-label">Default</span>
										</label>
									</div>
								</div>
								<small class="form-hint pt-0"></small>
							</div>
						  </div>
				  
						</div>
                    </div>
                </div>
			</div>

			<button class="btn" type="submit">
				<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon "><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8.56 3.69a9 9 0 0 0 -2.92 1.95" /><path d="M3.69 8.56a9 9 0 0 0 -.69 3.44" /><path d="M3.69 15.44a9 9 0 0 0 1.95 2.92" /><path d="M8.56 20.31a9 9 0 0 0 3.44 .69" /><path d="M15.44 20.31a9 9 0 0 0 2.92 -1.95" /><path d="M20.31 15.44a9 9 0 0 0 .69 -3.44" /><path d="M20.31 8.56a9 9 0 0 0 -1.95 -2.92" /><path d="M15.44 3.69a9 9 0 0 0 -3.44 -.69" /><path d="M9 12l2 2l4 -4" /></svg>
				Save
			</button>
		</form>
	</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
	
	$('#generating_new_license').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serializeArray();
		formData.push({ name: 'result', value: 'edit_group' });
		var i = 0;
		var expireValue = $('#name').val();
		if (expireValue.trim() === '') { $('#name').addClass('is-invalid'); i++; } else { $('#name').removeClass('is-invalid'); }
		
		if (i > 0) { return; }
		
		$.ajax({
			type: "POST",
			url: site_domain + '/execute/action.php',
			data: formData,
			success: function(response) {
				var jsonData = JSON.parse(response);
				alertify.set('notifier','position', 'top-right');
				alertify.notify(jsonData.message, jsonData.type, 5, function(){  console.log(jsonData.message); });
				if (jsonData.type == 'success') {
					location.href = site_domain + '/group/' + jsonData.id;
				}
			}
		});
	});
	

});
</script>
<?php
	} else if ($page[2] == 'delete' OR $subpage[2] == 'delete') {
		if (!(has('dbb.soroly.group.*') || has('dbb.soroly.group.delete'))) {
			echo '<script>location.href = "' . URI . '/group"; </script>';
		}
?>
	<div class="page-header mb-3">
	  <div class="row align-items-center">
		<div class="col">
		  <div class="page-pretitle">
			<a href="<?php echo URI; ?>/group" class="text-muted">Groups</a> - <a href="<?php echo URI; ?>/group/<?php echo $resultsArray['id']; ?>" class="text-muted"><?php echo $resultsArray['name']; ?></a> - Deleting
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
                        <div class="font-weight-medium">Safe to delete the group?</div>
                        <div class="text-secondary">Once accepted, there will be no return or recovery of data and everything that has to do with the group will be deleted.</div>
                      </div>
                      <div class="col-auto">
                        <div class="dropdown">
                          <a href="#" class="btn-action" data-bs-toggle="dropdown" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path><path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path><path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path></svg>
                          </a>
                          <div class="dropdown-menu dropdown-menu-end">
                            <a href="<?php echo URI; ?>/group/<?php echo $page[1]; ?>/delete/confirm" class="dropdown-item text-danger" id="deleting_license">Confirm</a>
                            <a href="<?php echo URI; ?>/group" class="dropdown-item">Cancel</a>
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
		formData.push({ name: 'result', value: 'delete_group' }, { name: 'dataid', value: '<?php echo $page[1]; ?>' });
		
		$.ajax({
			type: "POST",
			url: site_domain + '/execute/action.php',
			data: formData,
			success: function(response) {
				var jsonData = JSON.parse(response);
				alertify.set('notifier','position', 'top-right');
				alertify.notify(jsonData.message, jsonData.type, 5, function(){  console.log(jsonData.message); });
				if (jsonData.type == 'success') {
					location.href = site_domain + '/group';
				}
			}
		});
	});
	

});
</script>
<?php
	} else if ($page[2] == 'add-permissions' OR $subpage[2] == 'add-permissions') {
		if (!(has('dbb.soroly.group.*') || has('dbb.soroly.group.permission.add'))) {
			echo '<script>location.href = "' . URI . '/group"; </script>';
		}
?>

	<div class="page-header mb-3">
	  <div class="row align-items-center">
		<div class="col">
		  <div class="page-pretitle">
			<a href="<?php echo URI; ?>/group" class="text-muted">Groups</a> - <a href="<?php echo URI; ?>/group/<?php echo $resultsArray['id']; ?>" class="text-muted"><?php echo $resultsArray['name']; ?></a> - Add Permission
		  </div>
		  <h2 class="page-title">
			Adding permission to group.
		  </h2>
		</div>
		<div class="col-auto ms-auto">
		</div>
	  </div>
	</div>
    <div class="col-12 mb-3">
		<form class="accordion" id="generating_new_license" method="POST">
				
			<div class="accordion-item mb-3">
                <h2 class="accordion-header bg-indigo-lt" id="heading-1">
					<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-1" aria-expanded="true">Configuration #1</button>
                </h2>
                <div id="collapse-1" class="accordion-collapse  collapse show" data-bs-parent="#generating_new_license" style="">
                    <div class="accordion-body pt-0">
						
						<div class="card-body mt-2 license-form">
						
						  <div class="mb-3">
							<label class="form-label required" for="name">Permission</label>
							<div>
								<div class="row g-2">
									<div class="col input-icon">
										<span class="input-icon-addon">
											<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24" style="margin-left: 10px;"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7.5 7.5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M3 6v5.172a2 2 0 0 0 .586 1.414l7.71 7.71a2.41 2.41 0 0 0 3.408 0l5.592 -5.592a2.41 2.41 0 0 0 0 -3.408l-7.71 -7.71a2 2 0 0 0 -1.414 -.586h-5.172a3 3 0 0 0 -3 3z" /></svg>
										</span>
										<input type="text" class="form-control" name="name" id="name" placeholder="dbb.soroly.permission" value="">
										<input type="hidden" class="form-control" name="group" id="group" placeholder="0" value="<?php echo $resultsArray['id']; ?>">
									</div>
								</div>
								<small class="form-hint pt-0">Don't know any permissions? Go ahead and check any permissions in our <a href="https://docs.devbybit.com/license-softwares/soroly/permissions" target="_BLANK">documentation</a>!</small>
							</div>
						  </div>
				  
						</div>
                    </div>
                </div>
			</div>

			<button class="btn" type="submit">
				<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon "><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8.56 3.69a9 9 0 0 0 -2.92 1.95" /><path d="M3.69 8.56a9 9 0 0 0 -.69 3.44" /><path d="M3.69 15.44a9 9 0 0 0 1.95 2.92" /><path d="M8.56 20.31a9 9 0 0 0 3.44 .69" /><path d="M15.44 20.31a9 9 0 0 0 2.92 -1.95" /><path d="M20.31 15.44a9 9 0 0 0 .69 -3.44" /><path d="M20.31 8.56a9 9 0 0 0 -1.95 -2.92" /><path d="M15.44 3.69a9 9 0 0 0 -3.44 -.69" /><path d="M9 12l2 2l4 -4" /></svg>
				Add
			</button>
		</form>
	</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
	
	$('#generating_new_license').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serializeArray();
		formData.push({ name: 'result', value: 'add_permission_to_group' });
		var i = 0;
		var expireValue = $('#name').val();
		if (expireValue.trim() === '') { $('#name').addClass('is-invalid'); i++; } else { $('#name').removeClass('is-invalid'); }
		
		if (i > 0) { return; }
		
		$.ajax({
			type: "POST",
			url: site_domain + '/execute/action.php',
			data: formData,
			success: function(response) {
				var jsonData = JSON.parse(response);
				alertify.set('notifier','position', 'top-right');
				alertify.notify(jsonData.message, jsonData.type, 5, function(){  console.log(jsonData.message); });
				if (jsonData.type == 'success') {
					location.reload();
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
			<a href="<?php echo URI; ?>/group" class="text-muted">Groups</a> - Viewing
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
                        <span class="avatar avatar-lg" style="background-image: url(<?php echo $creatorinfo['avatar']; ?>)"></span>
                      </div>
                      <div class="col">
                        <h4 class="card-title m-0">
                          Creator
                        </h4>
                        <div class="text-secondary">
                          <a href="<?php echo URI; ?>/user/<?php echo $creatorinfo['id']; ?>"><?php echo $creatorinfo['name']; ?></a>
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
							
							<?php if (has('dbb.soroly.group.*') OR has('dbb.soroly.group.edit') OR has('dbb.soroly.group.delete')) { ?>
							<div class="col-auto">
								<div class="dropdown">
								  <a href="#" class="btn-action" data-bs-toggle="dropdown" aria-expanded="false">
									<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path><path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path><path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path></svg>
								  </a>
								  <div class="dropdown-menu dropdown-menu-end" style="">
									<?php if (has('dbb.soroly.group.*') OR has('dbb.soroly.group.edit')) { ?><a href="<?php echo URI; ?>/group/<?php echo $resultsArray['id']; ?>/edit" class="dropdown-item">Edit</a><?php } ?>
									<?php if (has('dbb.soroly.group.*') OR has('dbb.soroly.group.delete')) { ?><a href="<?php echo URI; ?>/group/<?php echo $resultsArray['id']; ?>/delete" class="dropdown-item text-danger">Delete</a><?php } ?>
								  </div>
								</div>
							</div>
							<?php } ?>
						</div>
                        <div class="mb-2">
							<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon me-2 text-secondary"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7.5 7.5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M3 6v5.172a2 2 0 0 0 .586 1.414l7.71 7.71a2.41 2.41 0 0 0 3.408 0l5.592 -5.592a2.41 2.41 0 0 0 0 -3.408l-7.71 -7.71a2 2 0 0 0 -1.414 -.586h-5.172a3 3 0 0 0 -3 3z" /></svg>
							Name: <strong><?php echo $resultsArray['name']; ?></strong>
                        </div>
                        <div class="mb-2">
							<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon me-2 text-secondary"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 19a2 2 0 0 1 -2 -2v-4l-1 -1l1 -1v-4a2 2 0 0 1 2 -2" /><path d="M12 11.875l3 -1.687" /><path d="M12 11.875v3.375" /><path d="M12 11.875l-3 -1.687" /><path d="M12 11.875l3 1.688" /><path d="M12 8.5v3.375" /><path d="M12 11.875l-3 1.688" /><path d="M18 19a2 2 0 0 0 2 -2v-4l1 -1l-1 -1v-4a2 2 0 0 0 -2 -2" /></svg>
							Default: <strong><?php echo ($resultsArray['default']) ? 'Yes' : 'No'; ?></strong>
                        </div>
                        <div class="mb-2">
							<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon me-2 text-secondary"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 21a9 9 0 0 1 0 -18c4.97 0 9 3.582 9 8c0 1.06 -.474 2.078 -1.318 2.828c-.844 .75 -1.989 1.172 -3.182 1.172h-2.5a2 2 0 0 0 -1 3.75a1.3 1.3 0 0 1 -1 2.25" /><path d="M8.5 10.5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M12.5 7.5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M16.5 10.5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /></svg>
							Color: <strong><?php echo $resultsArray['color']; ?></strong>
                        </div>
                        <div class="mb-2">
							<svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-secondary" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 7m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z"></path><path d="M8 7v-2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v2"></path><path d="M12 12l0 .01"></path><path d="M3 13a20 20 0 0 0 18 0"></path></svg>
							Created by: <strong><?php echo $creatorinfo['name']; ?></strong>
                        </div>
                        <div class="mb-2">
							<svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-secondary" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z"></path><path d="M16 3v4"></path><path d="M8 3v4"></path><path d="M4 11h16"></path><path d="M11 15h1"></path><path d="M12 15v3"></path></svg>
							Created  <strong><?php echo counttime($resultsArray['since']); ?></strong>
                        </div>
                      </div>
            </div>
		</div>
		<?php if (has('dbb.soroly.group.*') OR has('dbb.soroly.group.user')) { ?>
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
								<h3 class="card-title">User List</h3>
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
		<?php } ?>
	</div>
	<?php if (has('dbb.soroly.group.*') OR has('dbb.soroly.group.permission')) { ?>
		<div class="col-md-12 mb-3">
			<div class="row" align="left" style="display: none;">
				<div class="col" align="center">
					<input type="text" placeholder="Search..." class="form-control" id="searchs" value="<?php echo $page[1]; ?>">
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
			<div class="card">
                      <div class="card-header row g-2 align-items-center">
						
							<div class="col">
								<h3 class="card-title">Permission List</h3>
							</div>
							
							<div class="col-auto">
								<?php if (has('dbb.soroly.group.*') OR has('dbb.soroly.group.permission.add')) { ?>
								<div class="dropdown">
								  <a href="#" class="btn-action" data-bs-toggle="dropdown" aria-expanded="false">
									<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path><path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path><path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path></svg>
								  </a>
								  <div class="dropdown-menu dropdown-menu-end" style="">
									<a href="<?php echo URI; ?>/group/<?php echo $resultsArray['id']; ?>/add-permissions" class="dropdown-item">Add Permission</a>
								  </div>
								</div>
								<?php } ?>
							</div>
                      </div>
                      <div class="list-group list-group-flush" id="content_tables">

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
				<div class="card-footer d-flex align-items-center">
						<div class="col-lg-6 col-md-6 col-sm-12">
							<ul class="pagination m-0 ms-auto" id="pagination_lists"></ul>
						</div>
						<div class="text-end col-lg-6 col-md-6 col-sm-12">
							<p class="m-0 text-secondary" id="pagination_infos"></p>
						</div>
				</div>
			</div>
		</div>
	<?php } ?>
<?php if (has('dbb.soroly.group.*') OR has('dbb.soroly.group.permission.remove')) { ?>
<script>
function removeThisPermission(id) {
    $.ajax({
        type: "POST",
        url: site_domain + "/execute/action.php",
        data: { result: 'delete_permission_to_group', dataid: id },
        dataType: "json",
        success: function(response) {
            
				var jsonData = JSON.parse(response);
				alertify.set('notifier','position', 'top-right');
				alertify.notify(jsonData.message, jsonData.type, 5, function(){  console.log(jsonData.message); });
				if (jsonData.type == 'success') {
					$('#rowList_' + id).remove();
				}
        },
        error: function(error) {
            console.error("Error ", error);
        }
    });
}
</script>
<?php } if (has('dbb.soroly.group.*') OR has('dbb.soroly.group.user.remove')) { ?>
<script>
function removeThisUser(id) {
    $.ajax({
        type: "POST",
        url: site_domain + "/execute/action.php",
        data: { result: 'delete_user_in_group', dataid: id },
        dataType: "json",
        success: function(response) {
				var jsonData = JSON.parse(response);
				alertify.set('notifier','position', 'top-right');
				alertify.notify(jsonData.message, jsonData.type, 5, function(){  console.log(jsonData.message); });
				if (jsonData.type == 'success') {
					$('#rowLists_' + id).remove();
				}
        },
        error: function(error) {
            console.error("Error ", error);
        }
    });
}
</script>
<?php } if (has('dbb.soroly.group.*') OR has('dbb.soroly.group.user')) { ?>
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
        var result = 'users_group';

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
<?php } if (has('dbb.soroly.group.*') || has('dbb.soroly.group.permission')) { ?>
<script>
$(document).ready(function() {
    var es = $('#totals');
    var ws = $('#wheres');
    var ss = $('#searchs');
    window.updateAdminSQLs = function() {
        var pag = $('#paginationIDs').val();
        var total = es.val();
        var where = ws.val();
        var search = ss.val();
        var result = 'permission_group';

        $.ajax({
            url: site_domain + '/execute/table.php',
            type: 'POST',
            data: { result: result, search: search, where: where, pag: pag, total: total },
            success: function(response) {
                var jsonData = JSON.parse(response);
				
				var lin1 = [':compag_to:', ':end:', ':results:'];
				var lin2 = [jsonData.inicio, jsonData.fin, jsonData.totalRegistros];
				var lin3 = 'Showing :compag_to: to :end: of :results: entries';
				
                $('#content_tables').html(jsonData.html);
                $('#pagination_infos').text(str_replaces(lin1, lin2, lin3));
                $('#pagination_lists').html(jsonData.paginations_list);

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

});

</script>
<?php
}
	}
	} else {
?>
	<div class="page page-center">
      <div class="container-tight py-4">
        <div class="empty">
          <div class="empty-img"><img src="https://devbybit.com/demos/tablerio/static/illustrations/undraw_quitting_time_dm8t.svg" height="128" alt="">
          </div>
          <p class="empty-title">Non-existent group</p>
          <p class="empty-subtitle text-secondary">
            Sorry, this group does not exist or is not active.
          </p>
          <div class="empty-action">
            <a href="<?php echo URI; ?>/group/<?php echo $page[1]; ?>" class="btn btn-ghost-azure">
				<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19.933 13.041a8 8 0 1 1 -9.925 -8.788c3.899 -1 7.935 1.007 9.425 4.747" /><path d="M20 4v5h-5" /></svg>
				Try again
            </a>
            <a href="<?php echo URI; ?>/group" class="btn btn-primary">
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
} ?>