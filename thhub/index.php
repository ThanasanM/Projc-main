<?php
session_start();
require_once '../config/db.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css">
	<!-- My CSS -->
	<link rel="stylesheet" href="assets\css\style.css">

	<title>TeacherHub</title>
</head>

<body>


	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="index.php" class="brand">
			<i class='bx bxs-smile'></i>
			<span class="text">TeacherHub</span>
		</a>
		<ul class="side-menu top">
			<li class="active">
				<a href="index.php">
					<i class='bx bxs-dashboard'></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="program.php">
					<i class='bx bxs-book-content'></i>
					<span class="text">Study program</span>
				</a>
			</li>
			<li>
				<a href="Edit_user.php">
					<i class='bx bxs-user-plus'></i>
					<span class="text">Edit user</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class='bx bxs-message-dots'></i>
					<span class="text">Message</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">
			<li>
				<a href="../homepage.html" class="ho">
					<i class='bx bxs-home'></i>
					<span class="text">Home</span>
				</a>
			</li>
			<li>
				<a href="../page_login\logout.php" class="logout">
					<i class='bx bxs-log-out-circle'></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->



	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu'></i>
			<a href="#" class="nav-link">Categories</a>
			<form action="#">
				<div class="form-input">
					<input type="search" placeholder="Search...">
					<button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
				</div>
			</form>
			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label>
			<a href="#" class="notification">
				<i class='bx bxs-bell'></i>
				<span class="num">0</span>
			</a>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<ul class="box-info">
				<li>
					<i class='bx bxs-group'></i>
					<span class="text">
						<?php

						$sql = "SELECT COUNT(*) as members FROM users WHERE urole='member'";
						$query = $conn->prepare($sql);
						$query->execute();
						$fetch = $query->fetch();

						?>
						<h3>
							<?= $fetch['members'] ?>
							<p>Member</p>
						</h3>
					</span>
				</li>
				<li>
					<i class='bx bxs-videos'></i>
					<span class="text">
						<h3>1020</h3>
						<p>Videos</p>
					</span>
				</li>
			</ul>


			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Recent Users</h3>
					</div>
					<table id="myTable">
						<thead>
							<tr>
								<th>Firstname</th>
								<th>Lastname</th>
								<th>Email</th>
								<th>Role</th>
							</tr>
						</thead>
						<tbody>
							<?php

							$stmt = $conn->query("SELECT * FROM users WHERE urole='member'");
							$stmt->execute();

							$users = $stmt->fetchAll();
							foreach ($users as $user) {
							?>
								<tr>
									<td><?php echo $user['firstname'] ?></td>
									<td><?php echo $user['lastname'] ?></td>
									<td><?php echo $user['email'] ?></td>
									<td><?php echo $user['urole'] ?></td>
								</tr>
							<?php
							}
							?>
						</tbody>
					</table>
				</div>

			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->

	<script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
	<script src="assets\js\script.js"></script>
</body>

</html>