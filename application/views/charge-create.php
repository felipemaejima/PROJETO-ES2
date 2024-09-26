<div class="container">
  <div class="box">
    <div class="box-content">
      <div class="box-infos box-charges">
        <?php echo form_open('charge', array('id' => 'charge-create')); ?>
        <div class="align-items">
          <div class="tab-column-title">
            <div class="title"><i class="ph ph-receipt"></i> Cobrança</div>

            <div class="functions-tab tab-row">
              <button type="submit" class="btn-purple" id="submit-charge-create">criar</button>
              <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
            </div>
          </div>
        </div>

        <?php echo get_input('hidden', 'id', 'ID', FALSE, uuidv4()); ?>
        <div class="group-title">informações principais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'supplier', 'fornecedor', '<i class="ph ph-share"></i>'); ?>
            <?php echo get_input('hidden', 'supplierid', 'supplier id'); ?>
            <?php echo get_input('text', 'aracct', 'plano de conta', '<i class="ph ph-share"></i>'); ?>
            <?php echo get_input('hidden', 'supplierid', 'supplier id'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_select($subsidiaries, 'subsidiary', 'subsidiaria'); ?>
            <?php echo get_input('text', 'deadline', 'pagar até'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_textarea('comments', 6, 'anotações'); ?>
          </div>
        </div>
        <div class="tab-container">
          <label class="tab-btn active" data-toggle="charge">faturamento</label> |
          <label class="tab-btn" data-toggle="items">gastos</label>
        </div>
        <div class="tab-wrapper">
          <div id="gastos" class="tab-wrapper-content" style="display: none">
           
          </div>
          <div id="charge" class="tab-wrapper-content" style="display: flex">
            <div class="group-title">endereço</div>
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_select(FALSE, 'selectbilladdress', 'endereço'); ?>
              </div>
              <div class="column-33 c-large c-medium c-small">
                <?php echo get_textarea('billaddress', 6, 'endereço da fatura', FALSE, TRUE); ?>
              </div>
              <div class="column-33">
              </div>
            </div>
            <div class="group-title">prestações</div>
            <div class="column">
              <div class="column-33 c-large c-medium c-small">
                <div class="form-input-content">
                  <label for="terms">condições</label>
                  <div class="form-input-box">
                    <select name="terms">
                      <option value="">Escolha um(a) condições</option>
                      <?php foreach ($terms as $term): ?>
                        <option value="<?php echo $term->id; ?>" data-installments="<?php echo $term->installments; ?>"
                          data-timeqty="<?php echo $term->timeqty; ?>" data-leadtime="<?php echo $term->leadtime; ?>">
                          <?php echo $term->title; ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="error-terms error-input"></div>
                </div>
              </div>
              <div class="column-33">
              </div>
              <div class="column-33">
              </div>
            </div>

            <div class="overflow">
              <div class="table">
                <div class="table-head" style="min-width: 600px; max-width: 100%;">
                  <div class="column" style="min-width:200px; padding-right: 1rem;">prestação</div>
                  <div class="column" style="min-width:200px; padding-right: 1rem;">data</div>
                  <div class="column" style="min-width:0px; padding-right: 1rem;"></div>
                  <div class="column" style="min-width:200px; padding-right: 1rem;">porcentagem</div>
                </div>
              </div>
            </div>

          </div>
        </div>
        <div class="form-input-content">
          <div class="error-message error-input"></div>
        </div>
        <div class="functions-tab tab-row">
          <button type="submit" class="btn-purple" id="submit-charge-create">criar</button>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>