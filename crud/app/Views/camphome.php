<script>

	// this is function for edit section of 

	$(document).on('click', '.edit', function(e) {

		e.preventDefault();
		var id = $(this).parent().siblings()[0].value;

		//craeting a single user route using ajax
		$.ajax({
            
            url: "<?php echo base_url(); ?>" + "/getSingleUsercamp/" + id,
			method: "GET",
			success: function(result) {
                
                //  result parameter contains the response from the server, which is expected to be a JSON string. It is parsed into a JavaScript object using JSON.parse(result).
				var res = JSON.parse(result);
                
                
				$(".updateUsername").val(res.cname);
				$(".updatePassword").val(res.superid);
				$(".updateId").val(res.cid);
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
				url: "<?php echo base_url(); ?>" + "/deleteUsercamp",
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

		

		if(checkboxes.length >0){

			$('#confirmModal').modal('show');

			$('#confirmYes').on('click', function(){

				var ids = [];

				
			// now we are storing values from the checkboxes into the ids array
			checkboxes.each(function(){

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


</script>

<!-- Navbar -->

<nav class="navbar navbar-expand-lg navbar-dark bg-dark " style="gap:18px">
	<a class="navbar-brand" href="/dashboard">Dashboard</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
		<div class="navbar-nav">
			<a class="nav-item nav-link active" href="/">Admin</a>
			<a class="nav-item nav-link active" href="/campaign">Campaign </a>
            <a class="nav-item nav-link active" href="/logout" style="color: red; border:1.5px solid white; margin-left:900px">Logout </a>

		</div>		
<!-- input  -->

<form class="form" action="<?php echo site_url('uploadfile')?>" method="post" enctype="multipart/form-data">
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
			<div class="table-title" style="background-color:rgb(4, 48, 38)" >
				<div class="row">
					<div class="col-sm-6">
						<h2>Campaign Details</h2>
					
					</div>
					<div class="col-sm-6">
						
							
						<a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New Campaign</span></a>
						<a href="#filtermodal" class="btn btn-success" data-toggle="modal" style="background-color:rgb(46, 81, 236);"><i class="material-icons">&#xE15C;</i> <span>Filter</span></a>
						 
					</div>
				</div>
			</div>
			<table class="table table-striped table-hover" id="">
				<thead>
					<tr>
						<th>
							<span class="custom-checkbox">
								<input type="checkbox" id="selectAll">
								<label for="selectAll"></label>
							</span>
						</th>
						<th>CId</th>
						<th>Campaign Name</th>
						<th>Supervisor</th>
						<th>Description</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>

					<?php


						
						$num = 1;

					if ($superuser) {
						
                        
						foreach ($superuser as $user) {

					?>
							<tr>
								<input type="hidden" id="userId" name="id" value="<?php echo $user->cid; ?>">
								<td>
									<span class="custom-checkbox">
										<input type="checkbox" id="data_checkbox" class="data_checkbox" name="data_checkbox" value="<?php echo $user->cid; ?>">
										<label for="data_checkbox"></label>
									</span>
								</td>
								<td><?php echo $num ?></td>
								<td ><?php echo $user->cname; ?></td>
								<td ><?php echo $user->supervisor; ?></td>
								<td ><?php echo $user->cdesc; ?></td>
								<?php $num = $num+1;?>
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

			<!-- Pagination Links -->  <div class="pager">  <?= $pager ?> </div> 
			
		</div>
	</div>
</div>




<!-- Add Modal HTML -->
<div id="addEmployeeModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="<?php echo base_url() . 'saveUsercamp'; ?>" method="POST">
				<div class="modal-header" style="background-color:rgb(13, 65, 6);">
					<h4 class="modal-title">Add campaign</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="">&times;</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Campaign Name</label>
						<input type="text" class="form-control" name="username" required>
					</div>
					<div class="form-group">
						<label>Supervisor ID</label>
						<select class="form-select" aria-label="Default select example" name="email">
							<?php foreach($users as $user){
								?>
							<option value="<?=$user['id'] ?>"> <?= $user['email'] ?> </option>
								  <?php } ?>
						</select>
					</div>
                    <div class="form-group">
						<label>Description</label>
						<input type="text" class="form-control" name="desc" required>
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

<!-- filter modal HTML -->
<div id="filtermodal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="/campaign" >
				<div class="modal-header" style="background-color:rgb(13, 65, 6);">
					<h4 class="modal-title">Filter</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="">&times;</button>
				</div>
				<div class="modal-body">
					
					<div class="form-group">
						<label>Supervisor ID</label>
						<select class="form-select" aria-label="Default select example" name="camp">
							
							<?php foreach($allData as $user){
								?>
							<option value="<?=$user['cid'] ?>" <?= ($filterdata== $user['cid']) ? 'selected': '' ?> > <?= $user['cname'] ?> </option>
								  <?php } ?>
						</select>


						<div>Search Email:</div>
						<input type="text" name="supervisor">
					</div>
                    
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" name="submit" data-dismiss="modal" value="Cancel">
					<input type="submit" class="btn btn-success" value="Search">
				</div>
			</form>
		</div>
	</div>
</div>




<!-- Edit Modal HTML -->
<div id="editEmployeeModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="<?php echo base_url() . 'updateUsercamp'; ?>" method="POST">
				<div class="modal-header">
					<h4 class="modal-title">Edit Campaign</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="updateId" class="updateId" >
					<div class="form-group">
						<label>Campaign</label>
						<input type="text" class="form-control updateUsername" name="username" required>
					</div>
					<div class="form-group">
						<label>Supervisor</label>

						<select class="form-select" aria-label="Default select example" name="role">
							<?php foreach($users as $user){
								?>
							<option value="<?=$user['id'] ?>"> <?= $user['email'] ?> </option>
								  <?php } ?>
						</select>
  							
							
						</select>
					
						<!-- <input type="int" class="form-control updatePassword" name="role" required> -->
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


