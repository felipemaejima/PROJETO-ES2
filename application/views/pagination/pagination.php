<?php
$searchparams = '?';
if($this->input->get()){
	foreach($this->input->get() as $key => $value) {
		$searchparams .= $key.'='.$value.'&';
	}
}
?>
<div class="pagination-box">
	<div class="totals">
		<?php echo $initial; ?> de
		<?php echo $final; ?>
		<?php echo $final > 1 ? 'páginas' : 'página'; ?> de
		<?php echo $total; ?>
		<?php echo $total > 1 ? 'registros' : 'registro'; ?>
	</div>

	<?php if (in_array($this->uri->segment(1), array('roles', 'users', 'employees', 'subsidiaries', 'customers', 'suppliers', 'carriers', 'items', 'inventory', 'purchaseorders', 'salesorders', 'estimates', 'invoices', 'goals', 'creditmemos'))): ?>
		<div class="pagination">
			<?php $i = 1; ?>
			<?php $page_name = in_array($this->uri->segment(1), array('roles', 'employees', 'subsidiaries', 'customers', 'suppliers', 'carriers', 'items', 'inventory', 'purchaseorders', 'salesorders', 'estimates', 'invoices', 'goals', 'creditmemos')) ? $this->uri->segment(1) . '/' : ''; ?>
			<?php foreach ($pagination as $page): ?>
				<?php if ($page > 0): ?>
					<?php if ($page > $i): ?>
						<span>...</span>
						<a class="<?php echo $this->uri->segment(2) == $page ? 'disabled' : ''; ?>"
							href="<?php echo base_url($page_name . $page) . $searchparams; ?>"><?php echo $page; ?></a>
					<?php else: ?>
						<a class="<?php echo $this->uri->segment(2) == $page ? 'disabled' : ''; ?>"
							href="<?php echo base_url($page_name . $page) . $searchparams; ?>"><?php echo $page; ?></a>
					<?php endif; ?>
				<?php endif; ?>
				<?php $i = $page + 1; ?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>
