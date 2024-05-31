<?php

if ($page[1] == 'new' OR $codeAuth[0] == 'license/new') {

		if (!(has('dbb.soroly.license.*') || has('dbb.soroly.license.new'))) {
			echo '<script>location.href = "' . URI . '/license"; </script>';
		}
?>
	<div class="page-header mb-3">
	  <div class="row align-items-center">
		<div class="col">
		  <div class="page-pretitle">
			<a href="<?php echo URI; ?>/license" class="text-muted">Licenses</a> - Actions
		  </div>
		  <h2 class="page-title">
			Creating new license.
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
							<label class="form-label required" for="license_key">License Key</label>
							<div>
								<div class="row g-2">
									<div class="col input-icon mb-0">
										<span class="input-icon-addon">
											<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-key" style="margin-left: 10px;" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16.555 3.843l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.643 2.643a2.877 2.877 0 0 1 -4.069 0l-.301 -.301l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.877 2.877 0 0 1 0 -4.069l2.643 -2.643a2.877 2.877 0 0 1 4.069 0z" /><path d="M15 9h.01" /></svg>
										</span>
										<?php
										
										$chars = (!isset($_COOKIE['refill_key_chars'])) ? '0123456789asdfghjklqwertyuiopzxcvbnm0123456789ASDFGHJKLQWERTYUIOPZXCVBNM0123456789asdfghjklqwertyuiopzxcvbnm' : $_COOKIE['refill_key_chars'];
										
										$chars = (empty($_COOKIE['refill_key_chars'])) ? '0123456789asdfghjklqwertyuiopzxcvbnm0123456789ASDFGHJKLQWERTYUIOPZXCVBNM0123456789asdfghjklqwertyuiopzxcvbnm' : $_COOKIE['refill_key_chars'];
										
										$line_1 = customChar(8, $chars);
										$line_2 = customChar(4, $chars);
										$line_3 = customChar(4, $chars);
										$line_4 = customChar(4, $chars);
										$line_5 = customChar(8, $chars);
										
										$separator = '-';
										
										$refill_key = $line_1 . $separator . $line_2 . $separator . $line_3 . $separator . $line_4 . $separator . $line_5;
										?>
										<input type="text" value="<?php echo $refill_key; ?>" class="form-control" placeholder="Key" name="license_key" id="license_key">
									</div>
									<div class="col-auto">
										<label class="form-selectgroup-item refill_key">
											<span class="form-selectgroup-label">
												<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-rotate-360" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 16h4v4" /><path d="M19.458 11.042c.86 -2.366 .722 -4.58 -.6 -5.9c-2.272 -2.274 -7.185 -1.045 -10.973 2.743c-3.788 3.788 -5.017 8.701 -2.744 10.974c2.227 2.226 6.987 1.093 10.74 -2.515" /></svg>
											</span>
										</label>
									</div>
									<div class="col-auto">
										<label class="form-selectgroup-item" data-bs-toggle="offcanvas" href="#settings_key" role="button" aria-controls="settings_key">
											<span class="form-selectgroup-label">
												<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-settings" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" /><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /></svg>
											</span>
										</label>
									</div>
								</div>
								<small class="form-hint pt-0">This key will be used to verify your articles.</small>
							</div>
						  </div>
						  
						  <div class="mb-3 search-container">
							<label class="form-label required" for="client_id">Client</label>
							<div>
								<div class="input-icon mb-0">
									<span class="input-icon-addon">
										<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h1.5" /><path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M20.2 20.2l1.8 1.8" /></svg>
									</span>
									<input type="text" value="<?php echo $page[2]; ?>" class="form-control" placeholder="Client" name="client_id" id="client_id">
									<ul id="clientResults" class="search-results"></ul>
								</div>
								<small class="form-hint pt-0">Enter the user ID. If there is a platform to synchronize the user that synchronizes their account with the same ID, they will be able to see the key automatically.</small>
							</div>
						  </div>
						  
						  <div class="mb-3 search-container">
							<label class="form-label required" for="product">Scope</label>
							<div>
								<div class="row g-2">
									<div class="col input-icon">
										<span class="input-icon-addon">
											<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-box-seam" style="margin-left: 10px;" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3l8 4.5v9l-8 4.5l-8 -4.5v-9l8 -4.5" /><path d="M12 12l8 -4.5" /><path d="M8.2 9.8l7.6 -4.6" /><path d="M12 12v9" /><path d="M12 12l-8 -4.5" /></svg>
										</span>
										<input type="text" class="form-control" name="product" id="product" placeholder="Soroly">
										<ul id="clientResult" class="search-results"></ul>
									</div>
									<div class="col-auto">
										<label class="form-selectgroup-item">
										<input type="checkbox" name="bound" value="1" class="form-selectgroup-input">
										<span class="form-selectgroup-label">Must usage</span>
										</label>
									</div>
								</div>
								<small class="form-hint pt-0"></small>
							</div>
						  </div>
						  
						  <div class="mb-3">
							<label class="form-label required" for="expiration">Expiration</label>
							<div>
								<div class="row g-2">
									<div class="col input-icon">
										<span class="input-icon-addon">
											<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-stats" style="margin-left: 10px;" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4" /><path d="M18 14v4h4" /><path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M15 3v4" /><path d="M7 3v4" /><path d="M3 11h16" /></svg>
										</span>
										<input type="number" value="" class="form-control" min="1" placeholder="30" name="expire" id="expire">
									</div>
									<div class="col-auto">
										<select class="form-select" name="expiration" id="expiration">
											<option value="Seconds">Seconds</option>
											<option value="Minutes">Minutes</option>
											<option value="Hours">Hours</option>
											<option value="Days" selected>Days</option>
											<option value="Months">Months</option>
											<option value="Years">Years</option>
											<option value="Never">Never Expire</option>
										</select>
									</div>
								</div>
								<small class="form-hint pt-0">Time during which the key will stop working, and will enter a frozen state until renewed or modified by staff.</small>
							</div>
						  </div>
						  
						  <div class="mb-3">
							<label class="form-label required" for="ip_cap">IP Cap max</label>
							<div>
								<div class="input-icon mb-0">
									<span class="input-icon-addon">
										<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map-pins" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.828 9.828a4 4 0 1 0 -5.656 0l2.828 2.829l2.828 -2.829z" /><path d="M8 7l0 .01" /><path d="M18.828 17.828a4 4 0 1 0 -5.656 0l2.828 2.829l2.828 -2.829z" /><path d="M16 15l0 .01" /></svg>
									</span>
									<input type="number" value="5" class="form-control" min="0" placeholder="5" name="ip_cap" id="ip_cap">
								</div>
								<small class="form-hint pt-0">Number of IP's in the license, if it is 0 it will be unlimited.</small>
							</div>
						  </div>
						  <div class="mb-3">
							<label class="form-label" for="note">Note</label>
							<div>
								<div class="input-icon mb-0">
									<span class="input-icon-addon">
										<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-note" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M13 20l7 -7" /><path d="M13 20v-6a1 1 0 0 1 1 -1h6v-7a2 2 0 0 0 -2 -2h-12a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7" /></svg>
									</span>
									<textarea type="text" class="form-control" placeholder="" name="note" id="note"></textarea>
								</div>
								<small class="form-hint pt-0">Save one note for this license. Is optional.</small>
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
<div class="offcanvas offcanvas-end" tabindex="-1" id="settings_key" aria-labelledby="offcanvasEndLabel" aria-modal="true" role="dialog">
    <div class="offcanvas-header">
        <h2 class="offcanvas-title" id="offcanvasEndLabel">
			<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-key" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16.555 3.843l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.643 2.643a2.877 2.877 0 0 1 -4.069 0l-.301 -.301l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.877 2.877 0 0 1 0 -4.069l2.643 -2.643a2.877 2.877 0 0 1 4.069 0z" /><path d="M15 9h.01" /></svg>
			Key Custom Chars.
		</h2>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div>
			<textarea id="settings_char_key" rows="4" placeholder="Char for the license key." class="form-control"><?php echo (!isset($_COOKIE['refill_key_chars'])) ? '0123456789asdfghjklqwertyuiopzxcvbnm0123456789ASDFGHJKLQWERTYUIOPZXCVBNM0123456789asdfghjklqwertyuiopzxcvbnm' : $_COOKIE['refill_key_chars']; ?></textarea>
        </div>
        <div class="mt-3">
            <button class="btn btn-ghost-tabler save_refill_key" type="button" data-bs-dismiss="offcanvas">
                Save Setting
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
	
	$('#generating_new_license').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serializeArray();
		formData.push({ name: 'result', value: 'create_license' });
		var i = 0;
		var expireValue = $('#expire').val();
		if (expireValue.trim() === '') { $('#expire').addClass('is-invalid'); i++; } else { $('#expire').removeClass('is-invalid'); }
		
		var clientValue = $('#client_id').val();
		if (clientValue.trim() === '') { $('#client_id').addClass('is-invalid'); i++; } else { $('#client_id').removeClass('is-invalid'); }
		
		var clientValue = $('#product').val();
		if (clientValue.trim() === '') { $('#product').addClass('is-invalid'); i++; } else { $('#product').removeClass('is-invalid'); }
		
		var keyValue = $('#license_key').val();
		if (keyValue.trim() === '') { $('#license_key').addClass('is-invalid'); i++; } else { $('#license_key').removeClass('is-invalid'); }
		
		var ipValue = $('#ip_cap').val();
		if (ipValue.trim() === '') { $('#ip_cap').addClass('is-invalid'); i++; } else { $('#ip_cap').removeClass('is-invalid'); }
		
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
					location.href = site_domain + '/license/' + jsonData.id;
				}
			}
		});
	});
	

});

$(document).ready(function() {
	var clientResults = $('#clientResults');
	var clientResult = $('#clientResult');
	$('#client_id').on('input', function() {
		var result = 'sub_search_client';
		var query = $(this).val();

		if (query.length >= 0) {
		  $.ajax({
			url: site_domain + '/execute/action.php',
			type: 'POST',
			data: { result: result, query: query },
			dataType: 'json',
			success: function(data) {
			  displayResults(data);
			  clientResults.show();
			},
			error: function(error) {
			  console.error('Error en la solicitud AJAX:', error);
			}
		  });
		} else {
			clientResults.hide();
		}
	});
	
	$(document).on('click', function(e) {
		if (!clientResults.is(e.target) && clientResults.has(e.target).length === 0) {
		  clientResults.hide();
		}
	});
	$('#clientResults').on('click', 'li', function() {
		var selectedName = $(this).text();
		var selectedUdid = $(this).data('gid');
		var selectedNamed = $(this).data('name');

		$('#client_id').val(selectedUdid);

		$('#clientResults').empty();
	});

	function displayResults(results) {
		var resultList = $('#clientResults');
		resultList.empty();

		$.each(results, function(index, result) {
		  var listItem = $('<li>').text(result.name).data({
			'name': result.name,
			'gid': result.gid
		  });
		  resultList.append(listItem);
		});
	}
	
	$('#product').on('input', function() {
		var result = 'sub_search_scope';
		var query = $(this).val();

		if (query.length >= 0) {
			$.ajax({
				url: site_domain + '/execute/action.php',
				type: 'POST',
				data: { result: result, query: query },
				dataType: 'json',
				success: function(data) {
					displayResult(data);
					$('#clientResult').show();
				},
				error: function(error) {
					console.error('Error en la solicitud AJAX:', error);
				}
			});
		} else {
			$('#clientResult').hide();
		}
	});

	$('#clientResult').on('click', 'li', function() {
		var selectedName = $(this).text();
		$('#product').val(selectedName);

		$('#clientResult').empty();
	});

	$(document).on('click', function(e) {
		if (!$('#clientResult').is(e.target) && $('#clientResult').has(e.target).length === 0) {
			$('#clientResult').hide();
		}
	});

	function displayResult(results) {
		var resultList = $('#clientResult');
		resultList.empty();
		$.each(results, function(index, result) {
			var listItem = $('<li>').text(result).data({
				'scope': result
			});
			resultList.append(listItem);
		});
	}
});
	
	
	$(document).on('click', '.save_refill_key', function() {
		var chars = $('#settings_char_key').val();
		
		setPermanentCookie('refill_key_chars', chars);
	});
	
	$(document).on('click', '.refill_key', function(e) {
		e.preventDefault();
		
		var chars = $('#settings_char_key').val();
		if (chars.trim() === '') { 
			$('#settings_char_key').val('0123456789asdfghjklqwertyuiopzxcvbnm0123456789ASDFGHJKLQWERTYUIOPZXCVBNM0123456789asdfghjklqwertyuiopzxcvbnmasdfghjklqwertyuiopzxcvbnmdfsgfd'); 
		}
		
		refillKey();
	});
function refillKey() {
    var chars = document.getElementById('settings_char_key').value; // Obtener el valor del campo 'chars' del formulario
    var line_1 = customChar(8, chars);
    var line_2 = customChar(4, chars);
    var line_3 = customChar(4, chars);
    var line_4 = customChar(4, chars);
    var line_5 = customChar(12, chars);

    var separator = '-';
    var key = line_1 + separator + line_2 + separator + line_3 + separator + line_4 + separator + line_5;

    document.getElementById('license_key').value = key;
	alertify.notify('Refilled', 'success', 5, function(){  console.log('Refilled'); });
}

function customChar(length, chars) {
    var result = '';
    var characters = chars.split('');
    var charactersLength = characters.length;
    for (var i = 0; i < length; i++) {
        result += characters[Math.floor(Math.random() * charactersLength)];
    }
    return result;
}
</script>
<?php } else { 

	if (!$page[1] OR $page[1] == 'admin' OR $subpage[1] == 'admin') {
		if (!(has('dbb.soroly.license.*') || has('dbb.soroly.license')) && ($page[1] == 'admin' || $subpage[1] == 'admin')) {
			echo '<script>location.href = "' . URI . '/license"; </script>';
		}
?>

	<div class="page-header mb-3">
	  <div class="row align-items-center">
		<div class="col">
		  <div class="page-pretitle">
			Licenses
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
                          <th>Client</th>
                          <th>Key</th>
                          <th>Scope</th>
                          <th>IP Cap</th>
                          <th>Date</th>
                          <th class="w-1">Actions</th>
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
						</td></tr>
					  </tbody>
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
        var result = 'license<?php echo ($subpage[1] == 'admin') ? '_' . $subpage[1] : ''; ?>';

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
			$plataformSQL = $connx->prepare("SELECT * FROM `dbb_license` WHERE `id` = ?");
			$plataformSQL->execute([$page[1]]);

			while ($doc = $plataformSQL->fetch(PDO::FETCH_ASSOC)) {
				$resultsArray[] = $doc;
			}
			break;

		default:
			$filename = 'dbb_json.php';
			$configContent = file_get_contents($filename);

			$existing_data = json_decode(dbb_license, true);
			
			foreach ($existing_data as $key => $entry) {
				if ($entry['id'] == $page[1]) {
					$resultsArray[] = $entry;
				}
			}
			break;
	}
	$resultsArray = $resultsArray[0];
	
	if (!(has('dbb.soroly.license.*') || has('dbb.soroly.license')) && $resultsArray['client'] != $_SESSION[$dbb_user]['g_id']) {
		echo '<script>location.href = "' . URI . '/license"; </script>';
	}
	
	$userinfo = userInfo('g_id', $resultsArray['client']);
	$creatorinfo = userInfo('id', $resultsArray['creator']);
	
	$ips = explode('#', $resultsArray['ip_cap']);
	$counts = ($resultsArray['ip_cap'] == NULL) ? 0 : count($ips);
	
	if (isset($resultsArray)) {
	if ($page[2] == 'edit' OR $subpage[2] == 'edit') {
		
		if (!(has('dbb.soroly.license.*') || has('dbb.soroly.license.edit'))) {
			echo '<script>location.href = "' . URI . '/license"; </script>';
		}
?>
	<div class="page-header mb-3">
	  <div class="row align-items-center">
		<div class="col">
		  <div class="page-pretitle">
			<a href="<?php echo URI; ?>/license" class="text-muted">Licenses</a> - Actions
		  </div>
		  <h2 class="page-title">
			Editting license.
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
							<label class="form-label required" for="license_key">License Key</label>
							<div>
								<div class="row g-2">
									<div class="col input-icon mb-0">
										<span class="input-icon-addon">
											<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-key" style="margin-left: 10px;" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16.555 3.843l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.643 2.643a2.877 2.877 0 0 1 -4.069 0l-.301 -.301l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.877 2.877 0 0 1 0 -4.069l2.643 -2.643a2.877 2.877 0 0 1 4.069 0z" /><path d="M15 9h.01" /></svg>
										</span>

										<input type="text" class="form-control" placeholder="Key" name="license_key" id="license_key" value="<?php echo $resultsArray['key']; ?>">
									</div>
									<div class="col-auto">
										<label class="form-selectgroup-item refill_key">
											<span class="form-selectgroup-label">
												<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-rotate-360" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 16h4v4" /><path d="M19.458 11.042c.86 -2.366 .722 -4.58 -.6 -5.9c-2.272 -2.274 -7.185 -1.045 -10.973 2.743c-3.788 3.788 -5.017 8.701 -2.744 10.974c2.227 2.226 6.987 1.093 10.74 -2.515" /></svg>
											</span>
										</label>
									</div>
									<div class="col-auto">
										<label class="form-selectgroup-item" data-bs-toggle="offcanvas" href="#settings_key" role="button" aria-controls="settings_key">
											<span class="form-selectgroup-label">
												<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-settings" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" /><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /></svg>
											</span>
										</label>
									</div>
								</div>
								<small class="form-hint pt-0">This key will be used to verify your articles.</small>
							</div>
						  </div>
						  
						  <div class="mb-3 search-container">
							<label class="form-label required" for="client_id">Client</label>
							<div>
								<div class="input-icon mb-0">
									<span class="input-icon-addon">
										<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h1.5" /><path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M20.2 20.2l1.8 1.8" /></svg>
									</span>
									<input type="text" class="form-control" placeholder="Client" name="client_id" id="client_id" value="<?php echo $resultsArray['client']; ?>">
									<ul id="clientResults" class="search-results"></ul>
								</div>
								<small class="form-hint pt-0">Enter the user ID. If there is a platform to synchronize the user that synchronizes their account with the same ID, they will be able to see the key automatically.</small>
							</div>
						  </div>
						  
						  <div class="mb-3 search-container">
							<label class="form-label required" for="product">Scope</label>
							<div>
								<div class="row g-2">
									<div class="col input-icon">
										<span class="input-icon-addon">
											<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-box-seam" style="margin-left: 10px;" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3l8 4.5v9l-8 4.5l-8 -4.5v-9l8 -4.5" /><path d="M12 12l8 -4.5" /><path d="M8.2 9.8l7.6 -4.6" /><path d="M12 12v9" /><path d="M12 12l-8 -4.5" /></svg>
										</span>
										<input type="text" class="form-control" name="product" id="product" placeholder="Soroly" value="<?php echo $resultsArray['scope']; ?>">
										<ul id="clientResult" class="search-results"></ul>
									</div>
									<div class="col-auto">
										<label class="form-selectgroup-item">
										<input type="checkbox" name="bound" value="1" class="form-selectgroup-input" <?php echo ($resultsArray['bound']) ? 'checked=""' : ''; ?>>
										<span class="form-selectgroup-label">Must usage</span>
										</label>
									</div>
								</div>
								<small class="form-hint pt-0"></small>
							</div>
						  </div>
						  <?php
							$timestamp_expiracion = $resultsArray['expire'];

							$diferencia = new DateTime("@$timestamp_expiracion");
							$ahora = new DateTime("@".time());
							$diferencia = $ahora->diff($diferencia);

							$mayor_unidad = obtenerMayorUnidad($diferencia);
							$valors = ($resultsArray['expire'] == '-1') ? '1' : $mayor_unidad['valor'];
							$timing = ($resultsArray['expire'] == '-1') ? 'Never' : $mayor_unidad['unidad'];
						  ?>
						  <div class="mb-3">
							<label class="form-label required" for="expiration">Expiration</label>
							<div>
								<div class="row g-2">
									<div class="col input-icon">
										<span class="input-icon-addon">
											<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-stats" style="margin-left: 10px;" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4" /><path d="M18 14v4h4" /><path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M15 3v4" /><path d="M7 3v4" /><path d="M3 11h16" /></svg>
										</span>
										<input type="number" class="form-control" min="1" placeholder="30" name="expire" id="expire" value="<?php echo $valors; ?>">
									</div>
									<div class="col-auto">
										<select class="form-select" name="expiration" id="expiration">
											<option value="Seconds" <?php echo ($timing == 'seconds') ? 'selected' : ''; ?>>Seconds</option>
											<option value="Minutes" <?php echo ($timing == 'minutes') ? 'selected' : ''; ?>>Minutes</option>
											<option value="Hours" <?php echo ($timing == 'hours') ? 'selected' : ''; ?>>Hours</option>
											<option value="Days" <?php echo ($timing == 'days') ? 'selected' : ''; ?>>Days</option>
											<option value="Months" <?php echo ($timing == 'months') ? 'selected' : ''; ?>>Months</option>
											<option value="Years" <?php echo ($timing == 'years') ? 'selected' : ''; ?>>Years</option>
											<option value="Never" <?php echo ($timing == 'Never') ? 'selected' : ''; ?>>Never Expire</option>
										</select>
									</div>
								</div>
								<small class="form-hint pt-0">Time during which the key will stop working, and will enter a frozen state until renewed or modified by staff.</small>
							</div>
						  </div>
						  
						  <div class="mb-3">
							<label class="form-label required" for="ip_cap">IP Cap max</label>
							<div>
								<div class="input-icon mb-0">
									<span class="input-icon-addon">
										<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map-pins" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.828 9.828a4 4 0 1 0 -5.656 0l2.828 2.829l2.828 -2.829z" /><path d="M8 7l0 .01" /><path d="M18.828 17.828a4 4 0 1 0 -5.656 0l2.828 2.829l2.828 -2.829z" /><path d="M16 15l0 .01" /></svg>
									</span>
									<input type="number" class="form-control" min="0" placeholder="5" name="ip_cap" id="ip_cap" value="<?php echo $resultsArray['ips']; ?>">
								</div>
								<small class="form-hint pt-0">Number of IP's in the license, if it is 0 it will be unlimited.</small>
							</div>
						  </div>
						  <div class="mb-3">
							<label class="form-label" for="note">Note</label>
							<div>
								<div class="input-icon mb-0">
									<span class="input-icon-addon">
										<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-note" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M13 20l7 -7" /><path d="M13 20v-6a1 1 0 0 1 1 -1h6v-7a2 2 0 0 0 -2 -2h-12a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7" /></svg>
									</span>
									<textarea type="text" class="form-control" placeholder="" name="note" id="note"><?php echo $resultsArray['note']; ?></textarea>
								</div>
								<small class="form-hint pt-0">Save one note for this license. Is optional.</small>
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
<div class="offcanvas offcanvas-end" tabindex="-1" id="settings_key" aria-labelledby="offcanvasEndLabel" aria-modal="true" role="dialog">
    <div class="offcanvas-header">
        <h2 class="offcanvas-title" id="offcanvasEndLabel">
			<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-key" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16.555 3.843l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.643 2.643a2.877 2.877 0 0 1 -4.069 0l-.301 -.301l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.877 2.877 0 0 1 0 -4.069l2.643 -2.643a2.877 2.877 0 0 1 4.069 0z" /><path d="M15 9h.01" /></svg>
			Key Custom Chars.
		</h2>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div>
			<textarea id="settings_char_key" rows="4" placeholder="Char for the license key." class="form-control"><?php echo (!isset($_COOKIE['refill_key_chars'])) ? '0123456789asdfghjklqwertyuiopzxcvbnm0123456789ASDFGHJKLQWERTYUIOPZXCVBNM0123456789asdfghjklqwertyuiopzxcvbnm' : $_COOKIE['refill_key_chars']; ?></textarea>
        </div>
        <div class="mt-3">
            <button class="btn btn-ghost-tabler save_refill_key" type="button" data-bs-dismiss="offcanvas">
                Save Setting
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
	
	$('#generating_new_license').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serializeArray();
		formData.push({ name: 'result', value: 'edit_license' }, { name: 'dataid', value: '<?php echo $page[1]; ?>' });
		var i = 0;
		var expireValue = $('#expire').val();
		if (expireValue.trim() === '') { $('#expire').addClass('is-invalid'); i++; } else { $('#expire').removeClass('is-invalid'); }
		
		var clientValue = $('#client_id').val();
		if (clientValue.trim() === '') { $('#client_id').addClass('is-invalid'); i++; } else { $('#client_id').removeClass('is-invalid'); }
		
		var clientValue = $('#product').val();
		if (clientValue.trim() === '') { $('#product').addClass('is-invalid'); i++; } else { $('#product').removeClass('is-invalid'); }
		
		var keyValue = $('#license_key').val();
		if (keyValue.trim() === '') { $('#license_key').addClass('is-invalid'); i++; } else { $('#license_key').removeClass('is-invalid'); }
		
		var ipValue = $('#ip_cap').val();
		if (ipValue.trim() === '') { $('#ip_cap').addClass('is-invalid'); i++; } else { $('#ip_cap').removeClass('is-invalid'); }
		
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
					location.href = site_domain + '/license/' + jsonData.id;
				}
			}
		});
	});
	

});

$(document).ready(function() {
	var clientResults = $('#clientResults');
	var clientResult = $('#clientResult');
	
	$('#client_id').on('input', function() {
		var result = 'sub_search_client';
		var query = $(this).val();

		if (query.length >= 2) {
		  $.ajax({
			url: site_domain + '/execute/action.php',
			type: 'POST',
			data: { result: result, query: query },
			dataType: 'json',
			success: function(data) {
			  displayResults(data);
			  clientResults.show();
			},
			error: function(error) {
			  console.error('Error en la solicitud AJAX:', error);
			}
		  });
		} else {
			clientResults.hide();
		}
	});
	
	$(document).on('click', function(e) {
		if (!clientResults.is(e.target) && clientResults.has(e.target).length === 0) {
		  clientResults.hide();
		}
	});
	
	$('#clientResults').on('click', 'li', function() {
		var selectedName = $(this).text();
		var selectedUdid = $(this).data('gid');
		var selectedNamed = $(this).data('name');

		$('#client_id').val(selectedUdid);

		$('#clientResults').empty();
	});

	function displayResults(results) {
		var resultList = $('#clientResults');
		resultList.empty();

		$.each(results, function(index, result) {
		  var listItem = $('<li>').text(result.name).data({
			'name': result.name,
			'gid': result.gid
		  });
		  resultList.append(listItem);
		});
	}
	
	$('#product').on('input', function() {
		var result = 'sub_search_scope';
		var query = $(this).val();

		if (query.length >= 0) {
			$.ajax({
				url: site_domain + '/execute/action.php',
				type: 'POST',
				data: { result: result, query: query },
				dataType: 'json',
				success: function(data) {
					displayResult(data);
					$('#clientResult').show();
				},
				error: function(error) {
					console.error('Error en la solicitud AJAX:', error);
				}
			});
		} else {
			$('#clientResult').hide();
		}
	});

	$('#clientResult').on('click', 'li', function() {
		var selectedName = $(this).text();
		$('#product').val(selectedName);

		$('#clientResult').empty();
	});

	$(document).on('click', function(e) {
		if (!$('#clientResult').is(e.target) && $('#clientResult').has(e.target).length === 0) {
			$('#clientResult').hide();
		}
	});

	function displayResult(results) {
		var resultList = $('#clientResult');
		resultList.empty();
		$.each(results, function(index, result) {
			var listItem = $('<li>').text(result).data({
				'scope': result
			});
			resultList.append(listItem);
		});
	}
});
	
	
	$(document).on('click', '.save_refill_key', function() {
		var chars = $('#settings_char_key').val();
		
		setPermanentCookie('refill_key_chars', chars);
	});
	
	$(document).on('click', '.refill_key', function(e) {
		e.preventDefault();
		
		var chars = $('#settings_char_key').val();
		if (chars.trim() === '') { 
			$('#settings_char_key').val('0123456789asdfghjklqwertyuiopzxcvbnm0123456789ASDFGHJKLQWERTYUIOPZXCVBNM0123456789asdfghjklqwertyuiopzxcvbnmasdfghjklqwertyuiopzxcvbnmdfsgfd'); 
		}
		
		refillKey();
	});
function refillKey() {
    var chars = document.getElementById('settings_char_key').value; // Obtener el valor del campo 'chars' del formulario
    var line_1 = customChar(8, chars);
    var line_2 = customChar(4, chars);
    var line_3 = customChar(4, chars);
    var line_4 = customChar(4, chars);
    var line_5 = customChar(12, chars);

    var separator = '-';
    var key = line_1 + separator + line_2 + separator + line_3 + separator + line_4 + separator + line_5;

    document.getElementById('license_key').value = key;
	alertify.notify('Refilled', 'success', 5, function(){  console.log('Refilled'); });
}

function customChar(length, chars) {
    var result = '';
    var characters = chars.split('');
    var charactersLength = characters.length;
    for (var i = 0; i < length; i++) {
        result += characters[Math.floor(Math.random() * charactersLength)];
    }
    return result;
}
</script>
<?php
	} else if ($page[2] == 'delete' OR $subpage[2] == 'delete') {
		
		if (!(has('dbb.soroly.license.*') || has('dbb.soroly.license.delete'))) {
			echo '<script>location.href = "' . URI . '/license"; </script>';
		}
?>
	<div class="page-header mb-3">
	  <div class="row align-items-center">
		<div class="col">
		  <div class="page-pretitle">
			<a href="<?php echo URI; ?>/license" class="text-muted">Licenses</a> - <a href="<?php echo URI; ?>/license/<?php echo $resultsArray['id']; ?>" class="text-muted"><?php echo $resultsArray['key']; ?></a> - Deleting
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
                        <div class="font-weight-medium">Safe to delete the license?</div>
                        <div class="text-secondary">Once accepted, there will be no return or recovery of data and everything that has to do with the license will be deleted.</div>
                      </div>
                      <div class="col-auto">
                        <div class="dropdown">
                          <a href="#" class="btn-action" data-bs-toggle="dropdown" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path><path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path><path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path></svg>
                          </a>
                          <div class="dropdown-menu dropdown-menu-end">
                            <a href="<?php echo URI; ?>/license/<?php echo $page[1]; ?>/delete/confirm" class="dropdown-item text-danger" id="deleting_license">Confirm</a>
                            <a href="<?php echo URI; ?>/license" class="dropdown-item">Cancel</a>
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
		formData.push({ name: 'result', value: 'delete_license' }, { name: 'dataid', value: '<?php echo $page[1]; ?>' });
		
		$.ajax({
			type: "POST",
			url: site_domain + '/execute/action.php',
			data: formData,
			success: function(response) {
				var jsonData = JSON.parse(response);
				alertify.set('notifier','position', 'top-right');
				alertify.notify(jsonData.message, jsonData.type, 5, function(){  console.log(jsonData.message); });
				if (jsonData.type == 'success') {
					location.href = site_domain + '/license';
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
			<a href="<?php echo URI; ?>/license" class="text-muted">Licenses</a> - Viewing
		  </div>
		  <h2 class="page-title">
			Overview
		  </h2>
		</div>
		<div class="col-auto ms-auto"></div>
	  </div>
	</div>
    <div class="col-12 mb-3">
              <div class="col-lg-12">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex">
                      <h3 class="card-title">Request</h3>
                      <div class="ms-auto">
                        <div class="dropdown">
                          <a class="dropdown-toggle text-muted" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Last Year</a>
                          <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="#">Last Year</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <div id="license_chart"></div>
                      </div>
                      <div class="col-md-auto">
                        <div class="divide-y divide-y-fill">
                          <div class="px-3" id="list_two">
                            
                          </div>
                          <div class="px-3" id="list_one">
                            
                          </div>
                          <div class="px-3" id="list_tree">
                            
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
	</div>
	<div class="col-md-12 mb-3">
                <div class="card">
                  <div class="card-body">
                    <div class="row g-2 align-items-center">
                      <div class="col-auto">
                        <span class="avatar avatar-lg" style="background-image: url(<?php echo $userinfo['avatar']; ?>)"></span>
                      </div>
                      <div class="col">
                        <h4 class="card-title m-0">
                          <a href="<?php echo URI; ?>/user/<?php echo $userinfo['id']; ?>"><?php echo $userinfo['name']; ?></a>
                        </h4>
                        <div class="text-secondary">
                          <?php echo $userinfo['email']; ?>
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
							<?php if (has('dbb.soroly.license.*') OR has('dbb.soroly.license.edit') OR has('dbb.soroly.license.delete')) { ?>
							<div class="col-auto">
								<div class="dropdown">
								  <a href="#" class="btn-action" data-bs-toggle="dropdown" aria-expanded="false">
									<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path><path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path><path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path></svg>
								  </a>
								  <div class="dropdown-menu dropdown-menu-end" style="">
									<?php if (has('dbb.soroly.license.*') OR has('dbb.soroly.license.edit')) { ?><a href="<?php echo URI; ?>/license/<?php echo $resultsArray['id']; ?>/edit" class="dropdown-item">Edit</a><?php } ?>
									<?php if (has('dbb.soroly.license.*') OR has('dbb.soroly.license.delete')) { ?><a href="<?php echo URI; ?>/license/<?php echo $resultsArray['id']; ?>/delete" class="dropdown-item text-danger">Delete</a><?php } ?>
								  </div>
								</div>
							</div>
							<?php } ?>
						</div>
                        <div class="mb-2">
							<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon me-2 text-secondary"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16.555 3.843l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.643 2.643a2.877 2.877 0 0 1 -4.069 0l-.301 -.301l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.877 2.877 0 0 1 0 -4.069l2.643 -2.643a2.877 2.877 0 0 1 4.069 0z" /><path d="M15 9h.01" /></svg>
							Key: <strong><?php echo $resultsArray['key']; ?></strong>
                        </div>
                        <div class="mb-2">
							<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon me-2 text-secondary"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 4m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" /><path d="M5 8v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-10" /><path d="M10 12l4 0" /></svg>
							Scope: <strong><?php echo $resultsArray['scope']; ?></strong>
                        </div>
                        <div class="mb-2">
							<svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-secondary" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path><path d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z"></path></svg>
							IP Max: <strong><?php echo $counts; ?>/<?php echo ($resultsArray['ips'] == 0) ? '<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-infinity"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9.828 9.172a4 4 0 1 0 0 5.656a10 10 0 0 0 2.172 -2.828a10 10 0 0 1 2.172 -2.828a4 4 0 1 1 0 5.656a10 10 0 0 1 -2.172 -2.828a10 10 0 0 0 -2.172 -2.828" /></svg>' : $resultsArray['ips']; ?></strong>
                        </div>
                        <div class="mb-2">
							<svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-secondary" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path><path d="M12 7v5l3 3"></path></svg>
							Expire in: <strong><?php echo ($resultsArray['expire'] == '-1') ? 'Never' : counttimedown($resultsArray['expire'], 'Finalized'); ?></strong>
                        </div>
                        <div class="mb-2">
							<svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-secondary" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 7m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z"></path><path d="M8 7v-2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v2"></path><path d="M12 12l0 .01"></path><path d="M3 13a20 20 0 0 0 18 0"></path></svg>
							Created by: <strong><?php echo $creatorinfo['name']; ?></strong>
                        </div>
                        <div>
							<svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-secondary" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z"></path><path d="M16 3v4"></path><path d="M8 3v4"></path><path d="M4 11h16"></path><path d="M11 15h1"></path><path d="M12 15v3"></path></svg>
							Created  <strong><?php echo counttime($resultsArray['since']); ?></strong>
                        </div>
                      </div>
            </div>
		</div>
		<div class="col-md-8 mb-3">
			<div class="card">
                      <div class="card-header">
                        <h3 class="card-title">IP History</h3>
                      </div>
                      <div class="list-group list-group-flush">
						<?php
						for ($i = 0; $i < $counts; $i++) {
						?>
						<div class="list-group-item" id="listip_<?php echo $i; ?>">
							<div class="row align-items-center">
								<div class="col">
									<?php echo $ips[$i]; ?>
								</div>
								<div class="col-auto">
									<button class="btn-action" onclick="removeThisIp('<?php echo $ips[$i]; ?>', '<?php echo $i; ?>');"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg></button>
								</div>
							</div>
						</div>
						<?php
						}
						if ($counts == 0) {
						?>
						<div class="list-group-item">
							<div class="row align-items-center">
								<div class="col">
									Empty ips history.
								</div>
								<div class="col-auto">
									<button class="btn-action"></button>
								</div>
							</div>
						</div>
						<?php
						}
						
						?>
                      </div>
			</div>
		</div>
	</div>
	<?php if (has('dbb.soroly.license.*') OR has('dbb.soroly.license.note.views')) { ?>
	<?php if (!empty($resultsArray['note'])) { ?>
	<div class="col-12 mb-3">
		<div class="alert alert-info bg-dark" role="alert">
            <div class="d-flex">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path><path d="M12 9h.01"></path><path d="M11 12h1v4h1"></path></svg>
                </div>
                <div>
					<h4 class="alert-title">Note saved:</h4>
					<div class="text-secondary"><?php echo $resultsArray['note']; ?></div>
                </div>
            </div>
		</div>
	</div>
	<?php } ?>
	<?php } ?>


<script>
function removeThisIp(ip, index) {
    $.ajax({
        type: "POST",
        url: site_domain + "/execute/action.php",
        data: { result: 'removethisip', ip: ip, index: index, dataid: '<?php echo $page[1]; ?>' },
        dataType: "json",
        success: function(response) {
			console.log(response);
            $('#listip_' + index).remove();
        },
        error: function(error) {
            console.error("Error ", error);
        }
    });
}
$(document).ready(function() {
	var element = $('[data-bs-theme]');
    if (element.length > 0 && element.attr('data-bs-theme') === 'dark') {
        var styled = 'dark';
    } else {
        var styled = 'light';
    }
    function updateComprasChart() {
        $.ajax({
            type: "POST",
            url: site_domain + "/execute/action.php",
            data: { result: 'chart_license_overview', dataid: '<?php echo $page[1]; ?>' },
            dataType: "json",
            success: function(response) {
				var deniedCount = response.deniedData.reduce((a, b) => a + b, 0);
				var acceptedCount = response.acceptedData.reduce((a, b) => a + b, 0);

				var mostData = deniedCount >= acceptedCount ? 'Denied' : 'Accepted';
				var leastData = deniedCount < acceptedCount ? 'Denied' : 'Accepted';
				var totalData = deniedCount + acceptedCount;
				$('#list_two').html('<div class="text-muted"><span class="status-dot bg-green"></span> ' + mostData + '</div><div class="h2">' + (mostData === 'Denied' ? deniedCount : acceptedCount) + '</div>');
				$('#list_one').html('<div class="text-muted"><span class="status-dot bg-red"></span> ' + leastData + '</div><div class="h2">' + (leastData === 'Denied' ? deniedCount : acceptedCount) + '</div>');
				$('#list_tree').html('<div class="text-muted"><span class="status-dot bg-warning"></span> Total</div><div class="h2">' + totalData + '</div>');
                chart.updateSeries([
                    { name: 'Denied', data: response.deniedData },
                    { name: 'Accepted', data: response.acceptedData }
                ]);
            },
            error: function(error) {
                console.error("Error al obtener datos del servidor:", error);
            }
        });
    }

    var charts = {
        colors: [tabler.getColor("danger"), tabler.getColor("green")],
        series: [{
            name: 'Denied',
            data: []
        }, {
            name: 'Accepted',
            data: []
        }],
        chart: {
            background: 'transparent',
            type: 'area',
            height: 350
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded'
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 1,
            colors: ['#fff']
        },
        xaxis: {
            categories: ['Enero', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        },
        yaxis: {
            title: {
                text: ''
            }
        },
        fill: {
            opacity: 0.6
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return val;
                }
            }
        },
        theme: {
            mode: styled
        }
    };

    var chart = new ApexCharts(document.querySelector("#license_chart"), charts);
    chart.render();

    updateComprasChart();

    setInterval(updateComprasChart, 60000);
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
          <p class="empty-title">Non-existent license</p>
          <p class="empty-subtitle text-secondary">
            Sorry, this license does not exist or is not active.
          </p>
          <div class="empty-action">
            <a href="<?php echo URI; ?>/license/<?php echo $page[1]; ?>" class="btn btn-ghost-azure">
				<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19.933 13.041a8 8 0 1 1 -9.925 -8.788c3.899 -1 7.935 1.007 9.425 4.747" /><path d="M20 4v5h-5" /></svg>
				Try again
            </a>
            <a href="<?php echo URI; ?>/license" class="btn btn-primary">
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