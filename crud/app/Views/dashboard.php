<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<link href='https://unpkg.com/boxicons@2.1.4/dist/boxicons.js' rel='stylesheet'>

	<!-- My CSS -->
	<link rel="stylesheet" href="assets/css/dashboard.css">
    <!-- <script src="assets/js/dashboard.js"></script> -->

	<title>SlashRTC</title>
</head>
<body>


	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
            <img src="assets/slash.png" alt="" style="height:40px">
            <span class="text">SlashRTC</span>
		</a>
		<ul class="side-menu top">
			<li class="active">
				<a href="#">
					<i class='bx bxs-dashboard bx-sm' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			
			<li>
				<a href="/">
					<i class='bx bxs-doughnut-chart bx-sm' ></i>
					<span class="text">Admin Section</span>
				</a>
			</li>
			<li>
				<a href="/campaign">
					<i class='bx bxs-doughnut-chart bx-sm' ></i>
					<span class="text">Campaign Section</span>
				</a>
			</li>
			<li>
				<a href="/chat">
					<i class='bx bxs-message-dots bx-sm' ></i>
					<span class="text">Chat</span>
				</a>
			</li>
			
		</ul>
		<ul class="side-menu bottom">
			
			<li>
				<a href="/logout" class="logout">
					<i class='bx bx-power-off bx-sm bx-burst-hover' ></i>
					<span class="/logout">Logout</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->



	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
<nav>
    <i class='bx bx-menu bx-sm' ></i>
    
    <form action="#">
        <div class="form-input">
            <input type="search" placeholder="Search...">
            <button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
        </div>
    </form>
    <input type="checkbox" class="checkbox" id="switch-mode" hidden />
    <label class="swith-lm" for="switch-mode">
        <i class="bx bxs-moon"></i>
        <i class="bx bx-sun"></i>
        <div class="ball"></div>
    </label>

    <!-- Notification Bell -->
    <a href="#" class="notification" id="notificationIcon">
        <i class='bx bxs-bell bx-tada-hover' ></i>
        <span class="num">8</span>
    </a>
    <div class="notification-menu" id="notificationMenu">
        <ul>
            <li>New message from John</li>
            <li>Your order has been shipped</li>
            <li>New comment on your post</li>
            <li>Update available for your app</li>
            <li>Reminder: Meeting at 3PM</li>
        </ul>
    </div>

    <!-- Profile Menu -->
    
    <div class="profile-menu" id="profileMenu">
        <ul>

            <li><a href="/logout">Log Out</a></li>
        </ul>
    </div>
</nav>
<!-- NAVBAR -->


		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Dashboard</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Home</a>
						</li>
					</ul>
				</div>
				<a href="#" class="btn-download">
					<i class='bx bxs-cloud-download bx-fade-down-hover' ></i>
                    <select class="form-select " aria-label="Default select example" style="width: 120px; font-size:16px; background-color:#3c91e6; border:none;color:white" onchange="window.location.href=this.value;"> 
                    <option selected disabled>Reports</option>  
                    <option value="<?php echo base_url('/showReport/1') ?>">Mysql</option>
                    <option value="<?php echo base_url('/showReport/2') ?>">Mongo</option>
                    <option value="<?php echo base_url('/showReport/3') ?>">Elastic</option>
                    </select>
                   
				</a>
			</div>

			<ul class="box-info">
				<li>
					
                    <i class='bx bxs-group' ></i>
					<span class="text">
						<h3>48</h3>
						<p>Active Agents</p>
					</span>
				</li>
				<li>
                    <i class='bx bxs-calendar-check' ></i>
					<span class="text">
						<h3>15</h3>
						<p>Campaigns</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-dollar-circle' ></i>
					<span class="text">
						<h3>2543</h3>
						<p>Total Calls</p>
					</span>
				</li>
			</ul>


			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Live Calls</h3>
						<i class='bx bx-search' ></i>
						<i class='bx bx-filter' ></i>
					</div>
					<table>
						<thead>
							<tr>
								<th>User</th>
								<th>Date</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<img src="https://placehold.co/600x400/png">
									<p>Micheal John</p>
								</td>
								<td>18-10-2021</td>
								<td><span class="status completed">Completed</span></td>
							</tr>
							<tr>
								<td>
									<img src="https://placehold.co/600x400/png">
									<p>Ryan Doe</p>
								</td>
								<td>01-06-2022</td>
								<td><span class="status pending">Pending</span></td>
							</tr>
							<tr>
								<td>
									<img src="https://placehold.co/600x400/png">
									<p>Tarry White</p>
								</td>
								<td>14-10-2021</td>
								<td><span class="status process">Process</span></td>
							</tr>
							<tr>
								<td>
									<img src="https://placehold.co/600x400/png">
									<p>Selma</p>
								</td>
								<td>01-02-2023</td>
								<td><span class="status pending">Pending</span></td>
							</tr>
							<tr>
								<td>
									<img src="https://placehold.co/600x400/png">
									<p>Andreas Doe</p>
								</td>
								<td>31-10-2021</td>
								<td><span class="status completed">Completed</span></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="todo">
					<div class="head">
						<h3>Campaigns</h3>
						<i class='bx bx-plus icon'></i>
						<i class='bx bx-filter' ></i>
	
					</div>
					<ul class="todo-list">
						<li class="completed">
							<p>sales & Marketing</p>
							<i class='bx bx-dots-vertical-rounded' ></i>
						</li>
						<li class="completed">
							<p>Product Delivery Team</p>
							<i class='bx bx-dots-vertical-rounded' ></i>
						</li>
						<li class="not-completed">
							<p>Product Promotion</p>
							<i class='bx bx-dots-vertical-rounded' ></i>
						</li>
						<li class="completed">
							<p>Enquiry & Complaints</p>
							<i class='bx bx-dots-vertical-rounded' ></i>
						</li>
						
					</ul>
				</div>
			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="assets/js/dashboard.js"></script>
</body>
</html>