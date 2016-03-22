<h3>Total</h3>
<h4 class="positive">+ <?php echo $view->total_credit;?></h4>
<h4 class="negative">- <?php echo $view->total_debit;?></h4>
<hr>
<h4 class="<?php echo $view->diff_class();?> "> <?php echo $view->total_diff; ?> </h4>