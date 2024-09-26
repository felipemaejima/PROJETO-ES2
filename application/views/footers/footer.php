<div id="dialog-modal" title="">
  <p></p>
</div>
<div id="wait" style="display: none;">
  <div class="loader">
    aguarde
  </div>
</div>
<?php if ($this->session->flashdata('success')): ?>
  <div id="flash-message">
    <div class="alert alert-success">
      <i class="ph-fill ph-warning-diamond"></i>
      <?php echo $this->session->flashdata('success'); ?>
    </div>
  </div>
<?php endif; ?>
<?php if ($this->session->flashdata('error')): ?>
  <div id="flash-message">
    <div class="alert alert-danger">
      <i class="ph-fill ph-warning-diamond"></i>
      <?php echo $this->session->flashdata('error'); ?>
    </div>
  </div>
<?php endif; ?>
<script type="text/javascript">
  const base_url = '<?php echo base_url(); ?>'
  const ajaxConfig = {
    type: 'post',
    cache: false,
    contentType: false,
    processData: false,
    dataType: 'json',
  };
  const permission = <?php echo $permission ?? 0; ?>; 
</script>
<?php if ($js): ?>
  <?php foreach ($js as $value => $key): ?>
    <?php if (substr_count($key, 'http')): ?>
      <script type="text/javascript" src="<?php echo $key; ?>"></script>
    <?php else: ?>
      <script type="text/javascript" src="<?php echo base_url('public/js/' . $key); ?>"></script>
    <?php endif; ?>
  <?php endforeach; ?>
<?php endif; ?>
</body>

</html>