<?php include("header.php"); ?>

<?php include("side_bar.php");
$clients_query = mysqli_query($con, "SELECT * from payments");

?>
<div class="dashboard-wrapper">
	<div class="dashboard-influence">
		<div class="container-fluid dashboard-content">
			<div class="row">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					<div class="page-header">
						<h3 class="mb-2">Jeremy and Jazzy</h3>
						<div class="page-breadcrumb">
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
								</ol>
							</nav>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					<div class="card influencer-profile-data">
						<div class="card-body">
							<h3>Payment List</h3>
									<?php
									if (isset($_SESSION['s_msg']) && !empty($_SESSION['s_msg'])) {
										echo '<div class="alert alert-success">' . $_SESSION['s_msg'] . '</div>';
										unset($_SESSION['s_msg']);
									}
									?>
										<div class="table-responsive">
											<table class="table table-striped table-bordered datatable">
												<thead>
													<tr>
														<th>Sr No</th>
														<th>Client Name</th>
														<th>Payment ID</th>
														<th>Payment Date</th>
														<th>Transaction Amount</th>
														<th>Transaction ID</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
													<?php while ($fetch = mysqli_fetch_assoc($clients_query)) {
														$sr_no = 1; ?>
														<tr>
															<td><?php echo $sr_no; ?></td>
															<td><?php echo isset($fetch['first_name']) ? $fetch['first_name'] : ''; ?></td>
															<td><?php echo isset($fetch['last_name']) ? $fetch['last_name'] : ''; ?></td>
															<td><?php echo isset($fetch['user_name']) ? $fetch['user_name'] : ''; ?></td>
															<td><?php echo isset($fetch['email']) ? $fetch['email'] : ''; ?></td>
															<td><?php echo isset($fetch['mobile']) ? $fetch['mobile'] : ''; ?></td>
															
															
															<td>
																<a href="add-user.php?edit_id=<?php echo $fetch['id']; ?>" class="btn btn-primary">Edit</a>
															</td>
														</tr>
													<?php $sr_no++;
													} ?>
												</tbody>

											</table>
										</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include("footer.php"); ?>
</div>

</div>
</div>
<?php include("includes_bottom.php"); ?>
</body>

</html>