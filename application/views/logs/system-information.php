
<div class="overflow">
    <div class="table">
      <div class="table-head" style="min-width: 1450px; max-width: 100%;">
        <div class="column" style="min-width: 170px; padding-right: 1rem;">data</div>
        <div class="column" style="min-width: 170px; padding-right: 1rem;">definido por</div>
        <div class="column" style="min-width: 170px; padding-right: 1rem;">ação</div>
        <div class="column" style="min-width: 350px; padding-right: 1rem;">mensagem</div>
        <div class="column" style="min-width: 170px; padding-right: 1rem;">ip</div>
        <div class="column" style="min-width: 170px; padding-right: 1rem;">plataforma</div>
        <div class="column" style="min-width: 170px; padding-right: 1rem;">agente</div>
        <div class="column" style="min-width: 170px; padding-right: 1rem;"></div>
      </div>
      <?php foreach ($logs as $key => $log): ?>
        <div class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?>" style="min-width: 1450px; max-width: 100%;">
          <div class="column" style="min-width: 170px; padding-right: 1rem;">
            <?php echo date('d/m/Y H:i', $log->created); ?>
          </div>
          <div class="column" style="min-width: 170px; padding-right: 1rem;">
            <?php echo $log->name; ?>
          </div>
          <div class="column" style="min-width: 170px; padding-right: 1rem;">
            <?php echo $log->action; ?>
          </div>
          <div class="column" style="min-width: 350px; padding-right: 1rem;">
            <?php $data = json_decode($log->data); ?>
            <?php echo $data->message; ?>
          </div>
          <div class="column" style="min-width: 170px; padding-right: 1rem;">
            <?php echo $log->ip; ?>
          </div>
          <div class="column" style="min-width: 170px; padding-right: 1rem;">
            <?php echo $log->platform; ?>
          </div>
          <div class="column" style="min-width: 170px; padding-right: 1rem;">
            <?php echo $log->agent; ?>
          </div>
          <div class="column" style="min-width: 170px; padding-right: 1rem;">
            <?php if (isset($data->process) && $data->process): ?>
              <a href="" class="btn-log">
                <i class="ph-bold ph-plus-circle toggle-data"></i>
              </a>
            <?php endif; ?>
          </div>
        </div>
        <?php if (isset($data->process) && $data->process): ?>
          <div class="table-content-toggle">
            <div class="table-head dark">
              <div class="column column-10">campo</div>
              <div class="column column-30">valor antigo</div>
              <div class="column column-30">valor novo</div>
            </div>
            <?php foreach ($data->process as $key => $field): ?>
              <div class="table-content">
                <div class="column column-10">
                  <?php echo $key; ?>
                </div>
                <div class="column column-30">
                  <?php echo json_decode($field->previus) ? json_decode($field->previus) : $field->previus; ?>
                </div>
                <div class="column column-30">
                  <?php echo json_decode($field->new) ? json_decode($field->new) : $field->new; ?>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </div>