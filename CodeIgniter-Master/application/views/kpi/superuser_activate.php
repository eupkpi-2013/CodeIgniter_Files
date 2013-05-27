<script type="text/javascript">
	$(document).ready(function() {
	    $('input.checklist').change(function() {
			$(this).siblings('ul')
				   .find("input[type='checkbox']")
				   .prop('checked', this.checked);
			/* if ($(this).is(':checked')) {
				$(this).parents('ul').siblings('input:checkbox').attr('checked', true);
				//alert($(this).parents().siblings().find('input:checkbox:checked').length);
				//$(this).parents().siblings().css({background:'red'});
				//$(this).parent().children().css({background:'red'});
			}
			else
			{
				$(this).parent().children().find('input:checkbox:checked').attr('checked', false);

				if($(this).parents().siblings().find('input:checkbox:checked').length == 0)
				{
					$(this).parents('ul').siblings('input:checkbox').attr('checked', false);
				}
			} */
		});
	});
</script>

<div id="user-contents" class="contents">
	<h3>Inactive KPIs:</h3>
	<?php //echo form_open('shit'); ?>
	<input type="checkbox"  class="checklist">Select All</input>
	<ul class="indented-list">
		<?php
		foreach ($kpi as $kpi_item):
			echo '<li><input type="checkbox" class="checklist">'.$kpi_item->kpi_name.'</input><br />';
			echo '<ul class="indented-list">';
			foreach ($subkpi as $subkpi_item):
				if ($subkpi_item->parent_kpi == $kpi_item->kpi_id):
					echo '<li><input type="checkbox" class="checklist" name="subkpi[]" value="'.$subkpi_item->kpi_id.'">'.$subkpi_item->kpi_name.'</input><br />';
					echo '<ul class="indented-list">';
					foreach ($inactive as $inactive_item):
						if ( $inactive_item->kpi_id == $subkpi_item->kpi_id ):
							echo '<li><input class="checklist" type="checkbox" name="metric['.$subkpi_item->kpi_id.'][]" value="'.$inactive_item->field_id.'">'.$inactive_item->field_name.'</input>';
							if ( $inactive_item->has_breakdown ):
								echo '<ul class="indented-list">';
								foreach ( $submetric as $submetric_item ):
									echo '<li><input class="checklist" type="checkbox" name="submetric[]" value="'.$submetric_item->breakdown_id.'">'.$submetric_item->breakdown_name.'</input></li>';
								endforeach;
								echo '</ul>';
							endif;
							echo '</li>';
						endif;
					endforeach;
					echo '</ul></li>';
				endif;
			endforeach;
			echo '</ul></li>';
		endforeach;
		?>
	</ul>
	<a href="superuser_activated"><button>Activate</button></a>
	<?php //echo form_close(); ?>
</div>

</body>
</html>