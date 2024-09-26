<div class="container">
  <div class="box">
    <div class="box-content">
      <div class="box-infos">
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
          </div>
        </div>

        <?php echo get_input('hidden', 'id', 'ID', FALSE, uuidv4()); ?>
        <div class="group-title">informações principais</div>
        <div class="column">
          <div class="column-33 c-large c-medium c-small">
          </div>
          <div class="column-33 c-large c-medium c-small">
          </div>
          <div class="column-33 c-large c-medium c-small">
          </div>
        </div>


        <div class="column">
          <div class="column-40 c-large c-medium c-small">
            <div class="table">

              <div class="table-head" style="max-width: 100%;">
                <div class="column" style="min-width: 33%; padding-right: 1rem;">mês</div>
                <div class="column" style="min-width: 33%; padding-right: 1rem;">planejado</div>
                <div class="column" style="min-width: 33%; padding-right: 1rem;">realizado</div>
              </div>
              <?php $months = array(
                '1' => 'january',
                '2' => 'february',
                '3' => 'march',
                '4' => 'april',
                '5' => 'may',
                '6' => 'june',
                '7' => 'july',
                '8' => 'august',
                '9' => 'september',
                '10' => 'october',
                '11' => 'november',
                '12' => 'december',
                '1t' => 'janeiro',
                '2t' => 'fevereiro',
                '3t' => 'março',
                '4t' => 'abril',
                '5t' => 'maio',
                '6t' => 'junho',
                '7t' => 'julho',
                '8t' => 'agosto',
                '9t' => 'setembro',
                '10t' => 'outubro',
                '11t' => 'novembro',
                '12t' => 'dezembro',
              ); ?>
              <?php foreach ($invoices as $key => $invoice): ?>
                <div class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?>"
                  style="max-width: 100%;">
                  <?php $month = $months[$key + 1]; ?>
                  <div class="column" style="min-width: 33%; padding-right: 1rem;">
                    <?php echo mb_strtoupper($months[$key + 1 . 't'], 'UTF-8'); ?>
                  </div>
                  <div class="column" style="min-width: 33%; padding-right: 1rem;"><?php echo $goal[0]->$month; ?></div>
                  <div class="column" style="min-width: 33%; padding-right: 1rem;"><?php echo ($invoice->total ?? 0); ?>
                  </div>
                </div>
              <?php endforeach; ?>

            </div>
          </div>
          <div class="column-60 c-large c-medium c-small">
            <div style="width: 100%;"><canvas id="goal-chart"></canvas></div>
          </div>
        </div>

        <script type="text/javascript">
          const months = {
            '1': 'Janeiro',
            '2': 'Fevereiro',
            '3': 'Março',
            '4': 'Abril',
            '5': 'Maio',
            '6': 'Junho',
            '7': 'Julho',
            '8': 'Agosto',
            '9': 'Setembro',
            '10': 'Outubro',
            '11': 'Novembro',
            '12': 'Dezembro'
          };

          const data = [
            <?php foreach ($invoices as $key => $invoice): ?>
                      <?php echo '{ month: months[' . $invoice->month . '], total: ' . ($invoice->total ?? 0) . ' },' . PHP_EOL; ?>
            <?php endforeach; ?>
          ];

          const goal = [
            <?php echo '{ month: "Janeiro", total: ' . ($goal[0]->january ?? 0) . ' },'; ?>
            <?php echo '{ month: "Fevereiro", total: ' . ($goal[0]->february ?? 0) . ' },'; ?>
            <?php echo '{ month: "Março", total: ' . ($goal[0]->march ?? 0) . ' },'; ?>
            <?php echo '{ month: "Abril", total: ' . ($goal[0]->april ?? 0) . ' },'; ?>
            <?php echo '{ month: "Maio", total: ' . ($goal[0]->may ?? 0) . ' },'; ?>
            <?php echo '{ month: "Junho", total: ' . ($goal[0]->june ?? 0) . ' },'; ?>
            <?php echo '{ month: "Julho", total: ' . ($goal[0]->july ?? 0) . ' },'; ?>
            <?php echo '{ month: "Agosto", total: ' . ($goal[0]->august ?? 0) . ' },'; ?>
            <?php echo '{ month: "Setembro", total: ' . ($goal[0]->september ?? 0) . ' },'; ?>
            <?php echo '{ month: "Outubro", total: ' . ($goal[0]->october ?? 0) . ' },'; ?>
            <?php echo '{ month: "Novembro", total: ' . ($goal[0]->november ?? 0) . ' },'; ?>
            <?php echo '{ month: "Dezembro", total: ' . ($goal[0]->december ?? 0) . ' },'; ?>
          ];
        </script>

      </div>
    </div>
  </div>
</div>


