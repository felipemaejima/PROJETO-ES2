<div class="container">
    <div class="box-create-password">
        <div class="box-content">
            <div class="box box-infos-color">
                <?php echo form_open('create-password', array('id' => 'create-password')); ?>
                <h1>Portal de acesso</h1>
                <p>Defina uma senha para logar na plataforma.</p>
                <div class="form-input-content">
                    <input type="hidden" name="email" value="<?php echo $user[0]->email; ?>">

                    <div class="form-input-box">
                        <i class="ph ph-lock-simple-open" style="color: #6b46c1;"></i>
                        <input type="password" name="password" placeholder="Senha">
                        <i class="ph ph-eye"></i>
                    </div>
                    <div class="error-password error-input"></div>
                </div>
                <div class="form-input-content">
                    <div class="form-input-box">
                        <i class="ph ph-lock-simple" style="color: #6b46c1;"></i>
                        <input type="password" name="confirm_password" placeholder="Confirmar senha">
                        <i class="ph ph-eye"></i>
                    </div>
                    <div class="error-confirm-password error-input"></div>
                    <div class="error-message error-input"></div>

                </div>
                <button type="submit" class="btn-purple" id="submit-create-password">Enviar</button>
                <?php echo form_close(); ?>
            </div>
        </div>

        <div id="modal-create-password" class="modal">
            <div class="modal-large">
                <div class="modal-header">
                    <div class="close">
                        <i class="ph ph-x"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>