<div id="user-contents" class="contents">	
	<div id="user-kpimenu" class="accordion lefted">
		<div><h3>Report1</h3>
		</div>
		<div><h3>Report2</h3>
		</div>
		<div><h3>Report3</h3>
		</div>
	</div>
	<div id="user-inside" class="lefted">
		<div class="resultchart"></div>
		<div id="downloadas">Download:
			<select>
			  <option value="">PDF</option>
			  <option value="">EXCEL</option>
			  <option value="">TXT</option>
			</select>
		</div>
	</div>
</div>

<!--javascript-->
<script type="text/javascript">
$(document).ready(function(){
		$('.resultchart').highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: 'Fruit Consumption'
        },
        xAxis: {
            categories: ['Apples', 'Bananas', 'Oranges']
        },
        yAxis: {
            title: {
                text: 'Fruit eaten'
            }
        },
        series: [{
            name: 'Jane',
            data: [1, 0, 4]
        }, {
            name: 'John',
            data: [5, 7, 3]
        }],
    });
	});
</script>