<div class="container">
  <div class="box">
    <div class="box-content">
      <div class="box-infos">
        <?php echo form_open('goal', array('id' => 'goal-create')); ?>
        <div class="align-items">
          <div class="tab-column-title">
            <div class="title"><i class="ph ph-chart-line-up"></i> Meta</div>

            <div class="functions-tab tab-row">
              <button type="submit" class="btn-purple" id="submit-goal-create">criar</button>
              <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
            </div>
          </div>
        </div>

        <?php echo get_input('hidden', 'id', 'ID', FALSE, uuidv4()); ?>
        <div class="group-title">informações principais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'year', 'ano'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'goal', 'aplicar meta'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
          </div>
        </div>

        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <div class="group-title">vendedores</div>
            <?php foreach ($salespersons as $salesperson): ?>
              <div class="draggable-person">
                <i class="ph-thin ph-hand-coins"></i>
                <?php echo $salesperson->name; ?>
                <?php echo get_input('hidden', 'salespersonid[]', 'salespersonid', FALSE, $salesperson->id); ?>
                <?php echo get_input('hidden', 'salespersonname[]', 'salespersonname', FALSE, $salesperson->name); ?>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <div class="group-title">vendedores selecionados</div>
            <div class="droppable-person" style="min-height: 100px;"></div>
          </div>

          <div class="column-33 c-large c-medium c-small">
            <div class="group-title">valores</div>

            <div class="form-input-content">
              <div class="form-input-box">
                <input class="goal-value" type="text" name="1" placeholder="meta de janeiro" value="">
              </div>
              <div class="error-1 error-input"></div>
            </div>

            <div class="form-input-content">
              <div class="form-input-box">
                <input class="goal-value" type="text" name="2" placeholder="meta de fevereiro" value="">
              </div>
              <div class="error-2 error-input"></div>
            </div>

            <div class="form-input-content">
              <div class="form-input-box">
                <input class="goal-value" type="text" name="3" placeholder="meta de março" value="">
              </div>
              <div class="error-3 error-input"></div>
            </div>

            <div class="form-input-content">
              <div class="form-input-box">
                <input class="goal-value" type="text" name="4" placeholder="meta de abril" value="">
              </div>
              <div class="error-4 error-input"></div>
            </div>

            <div class="form-input-content">
              <div class="form-input-box">
                <input class="goal-value" type="text" name="5" placeholder="meta de maio" value="">
              </div>
              <div class="error-5 error-input"></div>
            </div>

            <div class="form-input-content">
              <div class="form-input-box">
                <input class="goal-value" type="text" name="6" placeholder="meta de junho" value="">
              </div>
              <div class="error-6 error-input"></div>
            </div>

            <div class="form-input-content">
              <div class="form-input-box">
                <input class="goal-value" type="text" name="7" placeholder="meta de julho" value="">
              </div>
              <div class="error-7 error-input"></div>
            </div>

            <div class="form-input-content">
              <div class="form-input-box">
                <input class="goal-value" type="text" name="8" placeholder="meta de agosto" value="">
              </div>
              <div class="error-8 error-input"></div>
            </div>

            <div class="form-input-content">
              <div class="form-input-box">
                <input class="goal-value" type="text" name="9" placeholder="meta de setembro" value="">
              </div>
              <div class="error-9 error-input"></div>
            </div>

            <div class="form-input-content">
              <div class="form-input-box">
                <input class="goal-value" type="text" name="10" placeholder="meta de outubro" value="">
              </div>
              <div class="error-10 error-input"></div>
            </div>

            <div class="form-input-content">
              <div class="form-input-box">
                <input class="goal-value" type="text" name="11" placeholder="meta de novembro" value="">
              </div>
              <div class="error-11 error-input"></div>
            </div>

            <div class="form-input-content">
              <div class="form-input-box">
                <input class="goal-value" type="text" name="12" placeholder="meta de dezembro" value="">
              </div>
              <div class="error-12 error-input"></div>
            </div>

          </div>
        </div>


        <div class="form-input-content">
          <div class="error-message error-input"></div>
        </div>
        <div class="functions-tab tab-row">
          <button type="submit" class="btn-purple" id="submit-goal-create">criar</button>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>

        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>
