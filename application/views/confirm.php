	<div class="container">
		<div class="box">
			<div class="box-content">
				<div class="box-infos">
					<div class="logo"><?php echo $this->config->item('name'); ?></div>
					<?php if ($has_valid): ?>
					<div class="title">Success</div>
					<p>Agradecemos por confirmar seu email em nossa plataforma. Agora você pode desfrutar de todos os benefícios que temos a oferecer! Faça o login e aproveite ao máximo!</p>
					<a href="<?php echo base_url('login'); ?>"><i class="ph-bold ph-arrow-left"></i> back to login</a>
					<?php else: ?>
					<div class="title">Invalid link</div>
					<p>Thank you for confirming your email on our platform. Now you can enjoy all the benefits we have to offer! Log in and make the most of it!</p>
					<a href="<?php echo base_url('login'); ?>"><i class="ph-bold ph-arrow-left"></i> back to login</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
