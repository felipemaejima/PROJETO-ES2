<div class="container">
  <div class="box">
    <div class="box-content">

      <div class="box-infos box-infos-color">
        <?php echo form_open('login', array('id' => 'login')); ?>
        <div class="form-input-content">
          <div class="form-input-box">
            <i class="ph ph-envelope-simple"></i>
            <input type="text" name="email" placeholder="Email">
            <input type="hidden" name="ref" value="<?php echo $this->input->get('ref'); ?>">
          </div>
          <div class="error-email error-input"></div>
        </div>
        <div class="form-input-content">
          <div class="form-input-box">
            <i class="ph ph-lock-simple"></i>
            <input type="password" name="password" placeholder="Senha">
            <i class="ph ph-eye"></i>
          </div>
          <div class="error-password error-input"></div>
        </div>
        <div class="form-input-content">
          <div class="error-message error-input"></div>
        </div>
        <button type="submit" class="btn-purple" id="submit-login">Entrar</button>
        <?php echo form_close(); ?>
      </div>

      <div class="box-infos">
        <div class="logo">
          <?php echo $this->config->item('name'); ?>
        </div>
        <div class="title">Entrar<br />na plataforma</div>
        <p>Com acesso seguro, uma interface intuitiva e recursos poderosos, você terá controle total sobre seu
          negócios. Nossos relatórios detalhados garantem que você esteja sempre no comando. Faça login agora para
          um gerenciamento de negócios mais inteligentes e simplificado!</p>
      </div>
    </div>
  </div>
</div>

<div id="modal-lost-password" class="modal">
  <div class="modal-header">
    <div class="close">
      <i class="ph ph-x"></i>
    </div>
  </div>
  <div class="modal-content">

    <?php echo form_open('forgot-my-password', array('id' => 'lost-password')); ?>
    <div class="form-input-content">
      <div class="success-message"></div>
    </div>
    <div class="form-input-content">
      <div class="form-input-box">
        <i class="ph ph-envelope-simple"></i>
        <input type="text" name="email" placeholder="Email">
      </div>
      <div class="error-email error-input"></div>
    </div>
    <button type="submit" class="btn-purple" id="submit-lost-password">Enviar</button>
    <div class="form-input-content">
      <div class="error-message error-input"></div>
    </div>
    <?php echo form_close(); ?>

  </div>
  <div class="modal-footer">
  </div>
</div>