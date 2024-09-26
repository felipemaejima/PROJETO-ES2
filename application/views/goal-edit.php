<div class="container">
  <div class="box">
    <div class="box-content">
      <div class="box-infos">
        <?php echo form_open('goal/' . $this->uri->segment(2), array('id' => 'goal-edit')); ?>
        <div class="align-items">
          <div class="tab-column-title">
            <div class="title"><i class="ph ph-chart-line-up"></i> Meta</div>

            <div class="functions-tab">
              <div class="legal-infos">
                <?php echo $goal[0]->salesmanname; ?><br />
                Meta de:
                <?php echo $goal[0]->year; ?><br />
              </div>
            </div>

            <div class="functions-tab tab-row">
              <button type="submit" class="btn-purple" id="submit-goal-create">editar</button>
              <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
            </div>
          </div>
        </div>

        <?php echo get_input('hidden', 'id', 'ID', FALSE, uuidv4()); ?>
        <div class="group-title">informações principais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'year', 'ano', FALSE, $goal[0]->year, TRUE); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', 'goal', 'aplicar meta'); ?>
          </div>
          <div class="column-33 c-large c-medium c-small">
          </div>
        </div>

        <div class="column">
          <div class="group-title">valores</div>
          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', '1', 'meta de janeiro', FALSE, $goal[0]->january); ?>

            <?php echo get_input('text', '2', 'meta de fevereiro', FALSE, $goal[0]->february); ?>

            <?php echo get_input('text', '3', 'meta de março', FALSE, $goal[0]->march); ?>

            <?php echo get_input('text', '4', 'meta de abril', FALSE, $goal[0]->april); ?>
          </div>

          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', '5', 'meta de maio', FALSE, $goal[0]->may); ?>

            <?php echo get_input('text', '6', 'meta de junho', FALSE, $goal[0]->june); ?>

            <?php echo get_input('text', '7', 'meta de julho', FALSE, $goal[0]->july); ?>

            <?php echo get_input('text', '8', 'meta de agosto', FALSE, $goal[0]->august); ?>
          </div>

          <div class="column-33 c-large c-medium c-small">
            <?php echo get_input('text', '9', 'meta de setembro', FALSE, $goal[0]->september); ?>

            <?php echo get_input('text', '10', 'meta de outubro', FALSE, $goal[0]->october); ?>

            <?php echo get_input('text', '11', 'meta de novembro', FALSE, $goal[0]->november); ?>

            <?php echo get_input('text', '12', 'meta de dezembro', FALSE, $goal[0]->december); ?>
          </div>
        </div>


        <div class="form-input-content">
          <div class="error-message error-input"></div>
        </div>
        <div class="functions-tab tab-row">
          <button type="submit" class="btn-purple" id="submit-goal-create">editar</button>
          <button type="button" onclick="window.history.back();" class="btn-gray">voltar</button>
        </div>

        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>
