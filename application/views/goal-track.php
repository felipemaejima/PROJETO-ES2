<div class="container">
  <div class="box">
    <div class="box-title">
      Acompanhamento
      <div>

      </div>
    </div>
    <div class="group-title search-tab"><i class="ph ph-minus-circle"></i> filtros</div>
    <div class="box-search search-estimates">
      <div class="box-content">
        <div class="box-infos">
          <?php echo form_open(base_url($this->uri->segment(1) . '/' . $this->uri->segment(2)), array('id' => 'search', 'method' => 'get')); ?>
          <?php echo get_input('hidden', $this->security->get_csrf_token_name(), $this->security->get_csrf_token_name(), FALSE, $this->security->get_csrf_hash()); ?>
          <div class="column">
            <div class="column-25 c-large c-medium c-small">
              <?php echo get_input('text', 'year', 'ano', FALSE, $this->input->get('year')); ?>
              <?php echo get_input('hidden', 'search', 'search', FALSE, uuidv4()); ?>
            </div>
            <div class="column-25 c-large c-medium c-small">
              <?php echo get_select($months, 'month', 'mês', FALSE, $this->input->get('month')); ?>
            </div>
            <div class="column-25 c-large c-medium c-small">
              <?php if ($permission): ?>
                <?php echo get_select($salespersons, 'salesperson', 'vendedor', FALSE, $this->input->get('salesperson')); ?>
              <?php endif; ?>
            </div>

            <div class="column-15 c-large c-medium c-small c-button">
              <div class="form-input-content">
                <div class="form-input-box">
                  <button type="submit" class="btn-blue">pesquisar</button>
                </div>
                <div class="error-submit error-input"></div>
              </div>
            </div>
            <div class="column-10 c-large c-medium c-small c-button">
              <div class="form-input-content">
                <div class="form-input-box">
                  <button type="button" class="btn-gray"
                    onclick="window.location.href='<?php echo base_url($this->uri->segment(1) . '/' . $this->uri->segment(2)); ?>'">limpar</button>
                </div>
                <div class="error-clear error-input"></div>
              </div>
            </div>
          </div>
          <?php echo form_close(); ?>
        </div>
      </div>
    </div>

    <div class="box-content">
      <div class="box-infos">
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
              <?php $month = ($this->input->get('month') ? $this->input->get('month') : (int) date('m')); ?>
              <?php $year = ($this->input->get('year') ? $this->input->get('year') : (int) date('Y')); ?>
              <?php $totalglobal = 0; ?>
              <?php foreach ($invoices as $key => $invoice): ?>
                <?php $totalglobal += $invoice->total; ?>
              <?php endforeach; ?>
              <?php $monthtranslate = $months[$month]; ?>
              <div class="table-content" style="max-width: 100%;">
                <div class="column" style="min-width: 33%; padding-right: 1rem;">
                  <?php echo mb_strtoupper($months[$month . 't'], 'UTF-8'); ?>
                </div>
                <div class="column" style="min-width: 33%; padding-right: 1rem;">
                  <?php echo $goal[0]->$monthtranslate ?? 0; ?>
                </div>
                <div class="column" style="min-width: 33%; padding-right: 1rem;"><?php echo ($totalglobal ?? 0); ?>
                </div>
              </div>
            </div>
          </div>

          <div class="column-60 c-large c-medium c-small">
            <div style="width: 100%;">
              <canvas id="goal-chart-track-per-day"></canvas>
            </div>
            <script type="text/javascript">
              const month = <?php echo ($this->input->get('month') ? $this->input->get('month') : date('m')); ?>;
              const year = <?php echo ($this->input->get('year') ? $this->input->get('year') : date('Y')); ?>;
              const data = [];
              const goal = [];
              <?php $totalbyday = []; ?>
              <?php $lasttotal = 0; ?>
              <?php $daysinmonth = cal_days_in_month(CAL_GREGORIAN, $month, $year); ?>
              <?php
              foreach ($invoices as $key => $invoice) {
                $day = (int) date('d', $invoice->date);

                if (!isset($totalbyday[$day])) {
                  $totalbyday[$day] = 0;
                }
                $totalbyday[$day] += $invoice->total;
              }
              for ($day = 1; $day <= $daysinmonth; $day++) {
                if (isset($totalbyday[$day])) {
                  $lasttotal += $totalbyday[$day];
                }
                echo "data.push({ day: '" . $day . "/" . $month . "/" . $year . "', total: " . round($lasttotal, 2) . " });" . PHP_EOL;
                echo "goal.push({ day: '" . $day . "/" . $month . "/" . $year . "', total: " . round($goal[0]->$monthtranslate, 2) . " });" . PHP_EOL;
              }
              ?>
            </script>
          </div>
        </div>
      </div>
    </div>

    <div class="tab-wrapper" style="width: 100%">
      <div class="tab-wrapper-content">
        <div class="overflow">
          <div class="table">
            <div class="table-head" style="min-width: 950px; max-width: 100%;">
              <div class="column" style="min-width: 100px; padding-right: 1rem;">fatura</div>
              <div class="column" style="min-width: 50px; padding-right: 1rem;">NFe</div>
              <div class="column" style="min-width: 50px; padding-right: 1rem;">data da NFe</div>
              <div class="column" style="min-width: 450px; padding-right: 1rem;">cliente</div>
              <div class="column" style="min-width: 100px; padding-right: 1rem; justify-content: flex-end;">valor bruto
              </div>
              <div class="column" style="min-width: 50px; padding-right: 1rem; justify-content: flex-end;">frete</div>
              <div class="column" style="min-width: 50px; padding-right: 1rem; justify-content: flex-end;">desconto
              </div>
              <div class="column" style="min-width: 100px; padding-right: 1rem; justify-content: flex-end;">total</div>
            </div>
            <?php foreach ($invoices as $key => $invoice): ?>
              <div class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?>"
                style="min-width: 950px; max-width: 100%;">
                <div class="column" style="min-width: 100px; padding-right: 1rem;">
                  <strong>
                    <a href="<?php echo base_url('invoice/' . $invoice->id); ?>" target="_blank" class="btn-link">
                      <?php echo 'Fatura ' . $invoice->tranid; ?>
                    </a>
                  </strong>
                </div>
                <div class="column" style="min-width: 50px; padding-right: 1rem;">
                  <strong>
                    <?php echo $invoice->fiscaldocnumber; ?>
                  </strong>
                </div>
                <div class="column" style="min-width: 50px; padding-right: 1rem;">
                  <?php echo $invoice->fiscaldocdate; ?>
                </div>
                <div class="column" style="min-width: 450px; padding-right: 1rem;">
                  <?php echo $invoice->customername; ?>
                </div>
                <div class="column" style="min-width: 100px; padding-right: 1rem; justify-content: flex-end;">
                  <?php echo $invoice->itemgrossvalue; ?>
                </div>
                <div class="column" style="min-width: 50px; padding-right: 1rem; justify-content: flex-end;">
                  <?php echo $invoice->itemfreight; ?>
                </div>
                <div class="column" style="min-width: 50px; padding-right: 1rem; justify-content: flex-end;">
                  <?php echo $invoice->itemdiscount; ?>
                </div>
                <div class="column" style="min-width: 100px; padding-right: 1rem; justify-content: flex-end;">
                  <strong>
                    <?php echo $invoice->total; ?>
                  </strong>
                </div>
              </div>
            <?php endforeach; ?>
            <div class="table-content table-content-color" style="min-width: 950px; max-width: 100%; margin-top: 1rem;">
              <div class="column" style="min-width: 100px; padding-right: 1rem;"></div>
              <div class="column" style="min-width: 50px; padding-right: 1rem;"></div>
              <div class="column" style="min-width: 50px; padding-right: 1rem;"></div>
              <div class="column" style="min-width: 450px; padding-right: 1rem;"></div>
              <div class="column" style="min-width: 100px; padding-right: 1rem; justify-content: flex-end;"></div>
              <div class="column" style="min-width: 50px; padding-right: 1rem; justify-content: flex-end;"></div>
              <div class="column" style="min-width: 50px; padding-right: 1rem; justify-content: flex-end;"></div>
              <div class="column" style="min-width: 100px; padding-right: 1rem; justify-content: flex-end;">
                <strong>
                  <?php echo number_format($totalglobal, 2, '.', ''); ?>
                </strong>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
