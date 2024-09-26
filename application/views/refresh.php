	<div class="container">
		<div class="box">
			<div class="box-content">
				<div class="box-infos">
					<div class="logo">4natomy</div>
					<?php if ($has_refreshed->used): ?>
					<div class="title">Parabéns!</div>
					<p>Sua senha foi alterada com sucesso. Agora você pode fazer login na sua conta com a sua nova senha!</p>
					<a href="<?php echo base_url('login'); ?>"><i class="ph-bold ph-arrow-left"></i> voltar ao login</a>
					<?php else: ?>
					<div class="title">Altere sua senha!</div>
					<p>Você está a apenas alguns passos de garantir a segurança da sua conta. Agora que você clicou no link de acesso para redefinir sua senha, basta seguir as instruções na tela para criar uma nova senha segura e forte. Lembre-se de escolher uma combinação que seja fácil para você lembrar, mas difícil para outras pessoas adivinharem.</p>
					<a href="<?php echo base_url('login'); ?>"><i class="ph-bold ph-arrow-left"></i> voltar ao login</a>
					<?php endif; ?>
				</div>
				<?php if (!$has_refreshed->used): ?>
				<div class="box-infos box-infos-color">
					<div class="subtitle">Altere sua senha</div>
					<?php echo form_open('redefinir-senha', array('id' => 'refresh')); ?>
					<div class="form-input-content">
						<div class="form-input-box">
							<i class="ph ph-envelope-simple"></i>
							<input type="text" name="email" placeholder="Seu e-mail">
							<input type="hidden" name="hash" value="<?php echo $this->input->get('codigo'); ?>">
						</div>
						<div class="error-email error-input"></div>
					</div>
					<div class="form-input-content">
						<div class="form-input-box">
							<i class="ph ph-lock-simple"></i>
							<input type="password" name="password" placeholder="Sua senha">
							<i class="ph ph-eye"></i>
						</div>
						<div class="error-password error-input"></div>
					</div>
					<div class="form-input-content">
						<div class="form-input-box">
							<i class="ph ph-lock-simple"></i>
							<input type="password" name="confirm_password" placeholder="Confirme sua senha">
							<i class="ph ph-eye"></i>
						</div>
						<div class="error-confirm-password error-input"></div>
					</div>
					<div class="form-input-content">
						<div class="error-message error-input"></div>
					</div>
					<button type="submit" class="btn-blue" id="submit-refresh">Alterar senha</button>
					<?php echo form_close(); ?>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
