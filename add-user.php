<?php include("header.php"); ?>
	
<?php include("side_bar.php");
if(isset($_GET['edit_id']) && $_GET['edit_id'] > 0){
	$fetchid = $_GET['edit_id'];
	$fetchData_q  = mysqli_query($con,"SELECT * from clients where id = $fetchid");
	$fetchData = mysqli_fetch_array($fetchData_q);
}
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
									<h3>Add New Users</h3>
									<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="">
                            <form action="post-user.php" method="POST"  autocomplete="off">
								<?php if(isset($fetchid) && $fetchid > 0 ){?>
									<input type="hidden" name="edit_id" value="<?php echo $fetchid;  ?>">
								<?php } ?>
								
								<div class="">
									<div class="col-sm-6">
									<div class=" form-group">
									<label style="margin-top: 10px;" for="">First Name</label>
									<input type="text" name="first_name" value="<?php echo isset($fetchData['first_name'])? $fetchData['first_name']:''; ?>" required class="form-control" placeholder="First Name">
									
									<label style="margin-top: 10px;" for="">Last Name</label>
									<input type="text" name="last_name" value="<?php echo isset($fetchData['last_name'])? $fetchData['last_name']:''; ?>" required class="form-control" placeholder="Last Name">
									

									<label style="margin-top: 10px;" for="">User Name</label>
									<input type="text" name="user_name" value="<?php echo isset($fetchData['user_name'])? $fetchData['user_name']:''; ?>" required class="form-control" placeholder="User Name">
									

									<label style="margin-top: 10px;" for="">Email</label>
									<input type="email" name="email" value="<?php echo isset($fetchData['email'])? $fetchData['email']:''; ?>" required class="form-control" placeholder="Email">
									

									<label style="margin-top: 10px;" for="">Mobile</label>
									<input type="text" name="mobile" value="<?php echo isset($fetchData['mobile'])? $fetchData['mobile']:''; ?>" required class="form-control" placeholder="Mobile">
									

									<label style="margin-top: 10px;" for="">Password</label>
									<input type="password" autocomplete="off" name="password" required class="form-control" placeholder="Password">									
									<label style="margin-top: 10px; " for="">Status</label>
									<select name="status" id="" class="form-control">
										<option <?php echo isset($fetchData['status']) && $fetchData['status']==1 ? "selected" : ''; ?> value="1" >Active</option>
										<option <?php echo isset($fetchData['status']) && $fetchData['status']==0 ? "selected" : ''; ?> value="0" >In-Active</option>
									</select>
									<input style="margin-top: 10px; "  type="submit" name="save" value="Save" class="btn btn-primary">
									</div>
									</div>
									<div class="col-sm-6"></div>
								</div>
							</form>
                        </div>
                    </div>
								</div>
								
							</div>
						</div>
					</div>
					</div>
					</div>
					<?php include("footer.php");?>
			</div>
			
		</div>
	</div>
	<?php include("includes_bottom.php");?>
</body>

</html>