<div id="user-contents" class="contents">
	<?php
	if (!empty($active)) {
		echo "<h2>Currently active result: ".$active[0]['results_name']."</h2>";
		echo "<p>Activating KPIs is not allowed.</p>";
	}
	else {
		echo $this->session->flashdata('errors');
		echo "<h3>Inactive KPIs:</h3>";
		if (empty($inactive)): echo "<p>No inactive KPIs.</p>";
		else:
			echo "<input type='checkbox'  class='checklist'>Select All</input>";
			echo form_open('activate_kpi');
			echo "<ul id='treeList' class='indented-list'>";
			foreach ($kpi as $kpi_item):
				echo '<li><input type="checkbox" class="checklist" name="kpi[]" value="'.$kpi_item->kpi_id.'">'.$kpi_item->kpi_name.'</input>';
				echo '<ul class="indented-list">';
				foreach ($subkpi as $subkpi_item):
					if ($subkpi_item->parent_kpi == $kpi_item->kpi_id):
						echo '<li><input type="checkbox" class="checklist" name="subkpi[]" value="'.$subkpi_item->kpi_id.'">'.$subkpi_item->kpi_name.'</input>';
						echo '<ul class="indented-list">';
						foreach ($inactive as $inactive_item):
							if ( $inactive_item->kpi_id == $subkpi_item->kpi_id ):
								echo '<li><input class="checklist" type="checkbox" name="metric[]" value="'.$inactive_item->field_id.'">'.$inactive_item->field_name.'</input>';
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
			echo "</ul>";
			echo "<button type='submit'>Activate</button>";
			echo form_close();
		endif;
	}
	?>
	<script>
	$(function() {
      $('input[type="checkbox"]').change(function(e) {
      var checked = $(this).prop("checked"),
          container = $(this).parent(),
          siblings = container.siblings();
  
      container.find('input[type="checkbox"]').prop({
          indeterminate: false,
          checked: checked
      });
  
      function checkSiblings(el) {
          var parent = el.parent().parent(),
              all = true;
  
          el.siblings().each(function() {
              return all = ($(this).children('input[type="checkbox"]').prop("checked") === checked);
          });
  
          if (all && checked) {
              parent.children('input[type="checkbox"]').prop({
                  indeterminate: false,
                  checked: checked
              });
              checkSiblings(parent);
          } else if (all && !checked) {
              parent.children('input[type="checkbox"]').prop("checked", checked);
              parent.children('input[type="checkbox"]').prop("indeterminate", (parent.find('input[type="checkbox"]:checked').length > 0));
              checkSiblings(parent);
          } else {
              el.parents("li").children('input[type="checkbox"]').prop({
                  indeterminate: true,
                  checked: false
              });
          }
        }
    
        checkSiblings(container);
      });
    });
    </script>
</div>

