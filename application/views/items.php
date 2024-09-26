<div class="container">
  <div class="box">
    <div class="box-title">
      Itens
      <div>
        <a href="<?php echo base_url('item'); ?>">novo item</a>
      </div>
    </div>
    <div class="group-title search-tab"><i class="ph ph-minus-circle"></i> filtros</div>
    <div class="box-search search-items">
      <div class="box-content">
        <div class="box-infos">
          <?php echo form_open(base_url($this->uri->segment(1) . '/1'), array('id' => 'search', 'method' => 'get')); ?>
          <?php echo get_input('hidden', $this->security->get_csrf_token_name(), $this->security->get_csrf_token_name(), FALSE, $this->security->get_csrf_hash()); ?>


          <div class="column-reverse">
            <div class="column column-top">
              <div class="column-25 c-large c-medium c-small">
                <?php echo get_input('text', 'name', 'nome', FALSE, $this->input->get('name')); ?>
                <?php echo get_input('hidden', 'search', 'search', FALSE, uuidv4()); ?>
              </div>
              <div class="column-25 c-large c-medium c-small">
                <?php echo get_select($brands, 'brands', 'marcas', FALSE, $this->input->get('brands')); ?>
              </div>
              <div class="column-25 c-large c-medium c-small">
                <?php echo get_input('text', 'supplier', 'fornecedor', FALSE, $this->input->get('supplier')); ?>
                <?php echo get_input('hidden', 'supplierid', 'supplierid', FALSE, $this->input->get('supplierid')); ?>
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
                      onclick="window.location.href='<?php echo base_url($this->uri->segment(1) . '/1'); ?>'">limpar</button>
                  </div>
                  <div class="error-clear error-input"></div>
                </div>
              </div>
            </div>

            <div class="column column-bottom">
              <div class="column-25 c-large c-medium c-small">
                <?php echo get_select($groups, 'group', 'grupo', FALSE, $this->input->get('group')); ?>
              </div>
              <div class="column-25 c-large c-medium c-small">
                <?php echo get_select(FALSE, 'subgroup', 'sub grupo', FALSE, $this->input->get('subgroup')); ?>
              </div>
              <div class="column-25">

              </div>
              <div class="column-15">

              </div>
              <div class="column-10">
              </div>

            </div>
          </div>

          <?php echo form_close(); ?>
        </div>
      </div>
    </div>

    <div class="tab-wrapper" style="width: 100%">
      <div class="tab-wrapper-content">
        <div class="overflow">
          <div class="table">
            <div class="table-head" style="min-width: 1400px; max-width: 100%;">
              <div class="column" style="min-width: 400px; padding-right: 1rem;">nome</div>
              <div class="column" style="min-width: 400px; padding-right: 1rem;">marca</div>
              <div class="column" style="min-width: 300px; padding-right: 1rem;">código de venda</div>
              <div class="column" style="min-width: 300px; padding-right: 1rem;"></div>
            </div>
            <?php foreach ($items as $key => $item): ?>
              <div class="table-content <?php echo (($key + 1) % 2) == 0 ? 'table-content-color' : ''; ?>" style="min-width: 1400px; max-width: 100%;">
                <div class="column" style="min-width: 400px; padding-right: 1rem;">
                  <i
                    class="ph-fill ph-circle <?php echo $item->confirmed == 'T' ? $item->isinactive == 'F' ? 'active' : 'invalid' : ''; ?>"></i>
                  <div class="thumb">
                    <i class="ph ph-image"></i>
                    <?php if ($item->image): ?>
                      <?php echo get_input('hidden', 'image', 'image', FALSE, $item->image); ?>
                    <?php endif; ?>
                  </div>
                  <div>
                    <strong>
                      <?php echo $item->name; ?>
                    </strong>
                    </br>
                    <small>
                      <?php echo $item->brand; ?>
                    </small>
                  </div>
                </div>
                <div class="column" style="min-width: 400px; padding-right: 1rem;;">
                  <?php echo $item->brand; ?>
                </div>
                <div class="column" style="min-width: 300px; padding-right: 1rem;">
                  <?php echo $item->salescode; ?>
                </div>
                <div class="column" style="min-width: 300px; padding-right: 1rem;">
                  <a class="btn-blue" href="<?php echo base_url('item/' . $item->id); ?>">ver</a>
                  <a href="<?php echo base_url('item/' . $item->id . '?edit=T'); ?>">editar</a>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>


    <?php require_once ('pagination/pagination.php'); ?>
  </div>
</div>