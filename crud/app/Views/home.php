<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
	// this is function for edit section of 

	$(document).on('click', '.edit', function(e) {

		e.preventDefault();
		var id = $(this).parent().siblings()[0].value;

		//craeting a single user route using ajax
		$.ajax({

			url: "<?php echo base_url(); ?>" + "/getSingleUser/" + id,
			method: "GET",
			success: function(result) {

				//  result parameter contains the response from the server, which is expected to be a JSON string. It is parsed into a JavaScript object using JSON.parse(result).
				var res = JSON.parse(result);

				$(".updateUsername").val(res.email);
				$(".updatePassword").val(res.role);
				$(".updateId").val(res.id);
			}
		})

	})


	// for deleteing the user


	$(document).on('click', '.delete', function(e) {

		//preventing the default functions of the button
		e.preventDefault();

		var id = $(this).parent().siblings()[0].value;

		//now we have to send the post request for deleting the data from database

		$('#confirmModal').modal('show');

		$('#confirmYes').on('click', function() {

			// if the user enter yes then we will proceed with the deletion process using ajax
			$('#confirmModal').modal('hide');

			$.ajax({
				url: "<?php echo base_url(); ?>" + "/deleteUser",
				method: "POST",
				data: {
					id: id
				},
				success: function(res) {

					if (res.includes("deleted")) {

						//for refreshing the page

						window.location.href = window.location.href;
					}
				}
			})

		});

	})



	//for deleting the multile user

	$(document).on('click', '.delete_all_data', function(e) {

		var checkboxes = $(".data_checkbox:checked");



		if (checkboxes.length > 0) {

			$('#confirmModal').modal('show');

			$('#confirmYes').on('click', function() {

				var ids = [];


				// now we are storing values from the checkboxes into the ids array
				checkboxes.each(function() {

					ids.push($(this).val());
				})

				$.ajax({
					url: "<?php echo base_url(); ?>" + "/deleteMultiUser",
					method: "POST",
					data: {
						ids: ids
					},
					success: function(res) {

						if (res.includes("multideleted")) {

							//for refreshing the page

							location.reload();
						}
					}
				})

			});


		}
	})

	//for filter
	$(document).ready(function() {
		$('#categorySelect').change(function() {
			var selectedOption = $(this).val();
			$.ajax({
				url: '<?= site_url('library/fetch-books') ?>',
				type: 'POST',
				data: {
					option: selectedOption
				},
				dataType: 'json',
				success: function(response) {
					$('#booksList').empty(); // Clear the previous data 
					// Append new data 
					$.each(response, function(index, book) {
						$('#booksList').append('<li>' + book.title + '</li>');
					});
				}
			});
		});
	});
</script>

<!-- Navbar -->

<nav class="navbar navbar-expand-lg navbar-dark bg-dark " style="gap:18px">
	<a class="navbar-brand" href="/dashboard">Dashboard</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
		<div class="navbar-nav">
			<a class="nav-item nav-link active" href="/">Admin </a>
			<a class="nav-item nav-link active" href="/campaign">Campaign </a>
			
			<div class="dropdown">
				<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Dropdown button
				</button>
				<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					<a class="dropdown-item" href="#">Action</a>
					<a class="dropdown-item" href="#">Another action</a>
					<a class="dropdown-item" href="#">Something else here</a>
				</div>
			</div>
	
			<a class="nav-item nav-link active" href="/logout" style="color: red; border:1.5px solid white; margin-left:800px">Logout </a>

		</div>
		<!-- input  -->

		<form class="form" action="<?php echo site_url('uploadfile') ?>" method="post" enctype="multipart/form-data">
			<div class="mb-1 form-group myclass-defined">



			</div>


			<div class="mb-3 form-group myclass-defined">

			</div>

		</form>
	</div>
	</div>
</nav>


<!--        main prgram           -->

<div class="container-xl">
	<div class="table-responsive d-flex flex-column">

		<?php
		if (session()->getFlashdata("success")) {


		?>
			<div class="alert w-50 align-self-center alert-success alert-dismissible fade show" role="alert">
				<?php echo session()->getFlashdata("success"); ?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		<?php } ?>

		<?php
		if (session()->getFlashdata("fail")) {


		?>
			<div class="alert w-50 align-self-center alert-danger alert-dismissible fade show" role="alert">
				<?php echo session()->getFlashdata("fail"); ?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		<?php } ?>
		<div class="table-wrapper">
			<div class="table-title" style="background-color:rgb(19, 47, 58);">
				<div class="row">
					<div class="col-sm-6">
						<h2>Admin Info</h2>

					</div>
					<div class="col-sm-6">
						<a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal" style="background-color:rgb(26, 176, 202);"><i class="material-icons">&#xE147;</i> <span>Add New Admin</span></a>
						<a href="#filterEmployeeModal" class="btn btn-success" data-toggle="modal" style="background-color:rgb(13, 180, 69);"><i class="material-icons">&#xE147;</i> <span>Filter</span></a>
						<!-- <a href="#editEmployeeModal" class=" btn btn-danger"><i class="material-icons">&#xE15C;</i> <span>Delete</span></a> -->
					</div>
				</div>
			</div>
			<!-- mydatatable -->
			<table class="table table-striped table-hover" id="">
				<thead>
					<tr>
						<th>
							<span class="custom-checkbox">
								<input type="checkbox" id="selectAll">
								<label for="selectAll"></label>
							</span>
						</th>
						<th>Id</th>
						<th>Email</th>
						<th style="text-align: center;">Role</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>

					<?php



					$num = 1;

					if ($accessuser) {

						foreach ($accessuser as $user) {

							// print_r($role);


					?>
							<tr>
								<input type="hidden" id="userId" name="id" value="<?php echo $user->id; ?>">
								<td>
									<span class="custom-checkbox">
										<input type="checkbox" id="data_checkbox" class="data_checkbox" name="data_checkbox" value="<?php echo $user->id; ?>">
										<label for="data_checkbox"></label>
									</span>
								</td>
								<td><?php echo $num ?></td>
								<td><?php echo $user->email; ?></td>
								<td style="background-color:rgb(190, 241, 226); text-align: center;"><?php echo $user->accessname; ?></td>
								<?php $num = $num + 1; ?>
								<td>
									<a href="#editEmployeeModal" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
									<a href="#" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
								</td>
							</tr>






					<?php


						}
					}
					?>
				</tbody>
			</table>
			<!-- Pagination Links -->
			<div> <?= $pager ?> </div>

		</div>
	</div>
</div>




<!-- Add Modal HTML -->
<div id="addEmployeeModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="<?php echo base_url() . 'saveUser'; ?>" method="POST">
				<div class="modal-header" style="background-color:rgb(35, 78, 83);">
					<h4 class="modal-title">Add Admin Data</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="margin-left: 120px;">&times;</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Email</label>
						<input type="text" class="form-control" name="username" required>
					</div>
					<div class="form-group">
						<label>Role</label>

						<select class="form-select" aria-label="Default select example" name="email">
							<option value="1">Admin</option>
							<option value="2">Supervisor</option>
							<option value="3">Teamleader</option>
							<option value="4">Agent</option>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" name="submit" data-dismiss="modal" value="Cancel">
					<input type="submit" class="btn btn-success" value="Add">
				</div>
			</form>
		</div>
	</div>
</div>





<!-- Edit Modal HTML -->
<div id="editEmployeeModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="<?php echo base_url() . 'updateUser'; ?>" method="POST">
				<div class="modal-header">
					<h4 class="modal-title">Edit Employee</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="margin-left: 130px;">&times;</button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="updateId" class="updateId">
					<div class="form-group">
						<label>Email</label>
						<input type="text" class="form-control updateUsername" name="username" required>
					</div>
					<div class="form-group">
						<label>Role</label>

						<select class="form-select" aria-label="Default select example" name="role">
							<option selected value="1">Admin</option>
							<option value="2">Supervisor</option>
							<option value="3">Teamleader</option>
							<option value="4">Agent</option>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<input type="button" name="submit" class="btn btn-default" data-dismiss="modal" value="Cancel">
					<input type="submit" class="btn btn-info" value="Save">
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Filter Modal HTML -->
<div id="filterEmployeeModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- /filter -->
			<form action="/">
				<div class="modal-header">
					<h4 class="modal-title">Filter</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="margin-left: 130px;">&times;</button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="updateId" class="updateId">
					Select Role:
					<select class="form-select" aria-label="Default select example" name="role">

						<option value="1" <?= ($filterdata == '1') ? 'selected' : '' ?>>Admin</option>
						<option value="2" <?= ($filterdata == '2') ? 'selected' : '' ?>>Supervisor</option>
						<option value="3" <?= ($filterdata == '3') ? 'selected' : '' ?>>Teamleader</option>
						<option value="4" <?= ($filterdata == '4') ? 'selected' : '' ?>>Agent</option>
					</select>

					<div>Search Email</div>
					<input type="text" name="search" value= "<?= old('search') ?>">

				</div>
				<div class="modal-footer">
					<input type="button" name="submit" class="btn btn-default" data-dismiss="modal" value="Cancel">
					<input type="submit" class="btn btn-info" value="Save">
				</div>
			</form>
		</div>
	</div>
</div>


<!-- Custom Confirmation Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #f08696;">
				<h5 class="modal-title" id="confirmModalLabel">Confirm </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				Are you sure you want to delete the data?
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-primary" id="confirmYes">OK</button>
			</div>
		</div>
	</div>
</div>