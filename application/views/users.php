<div class="container">
	<div class="box">
		<div class="box-title">
			Users
			<div>
				<a href="<?php echo base_url('user'); ?>">new user</a>
			</div>
		</div>
		<div class="table">
			<div class="table-head">
				<div class="column column-30">User</div>
				<div class="column column-20">Role</div>
				<div class="column column-10">Active</div>
				<div class="column column-20">Login attempts</div>
				<div class="column column-10"></div>
			</div>
			<?php foreach ($users as $key => $user): ?>
				<div class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?>">
					<div class="column column-30">
						<i class="ph-fill ph-circle <?php echo $user->confirmed == 'T' ? 'active' : 'invalid'; ?>"></i>
						<div>
							<strong>
								<?php echo $user->name; ?>
							</strong>
							</br>
							<small>
								<?php echo $user->email; ?>
							</small>
						</div>
					</div>
					<div class="column column-20">
						<?php echo $user->role; ?>
					</div>
					<div class="column column-10">
						<?php echo $user->confirmed == 'T' ? 'active' : 'inactive'; ?>
					</div>
					<div class="column column-20">
						<?php echo $user->login_attempts; ?>
					</div>
					<div class="column column-10">
						<a href="<?php echo base_url('user/' . $user->id); ?>">edit</a>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<?php require_once('pagination/pagination.php'); ?>
	</div>
</div>

<?php if ($this->session->flashdata('success')): ?>
	<div id="flash-message">
		<div class="alert alert-success">
			<i class="ph-fill ph-warning-diamond"></i>
			<?php echo $this->session->flashdata('success'); ?>
		</div>
	</div>
<?php endif; ?>
