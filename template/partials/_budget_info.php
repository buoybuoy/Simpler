<h3>
	<a href="#" data-toggle="modal" data-target="#budgetModal" class="hover-animate hover-animate-left">
		Budget <i class="fa fa-cog"></i>
	</a>
</h3>
<table class="table">
<tbody>
<?php foreach ($this->budgeted_amounts as $key => $budgeted_amount){
	if ($key == 0){
		echo '<tr class="small">';
		echo '<td><i>' . $budgeted_amount['category_name'] . '</i></td><td><i>$' . $budgeted_amount['spent'] . '</i></td><td></td>';
	} else {
		echo '<tr>';
		echo '<td>' . $budgeted_amount['category_name'] . '</td><td>$' . $budgeted_amount['spent'] . ' spent</td><td>$' . $budgeted_amount['remaining'] . ' left</td>';
	}
	echo '</tr>';
} ?>
</tbody>
</table>