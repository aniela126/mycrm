<?php
    use \koolreport\widgets\koolphp\Table;
    use \koolreport\widgets\google\ColumnChart;
?>
<div class="text-center" style="margin: 0 ;padding:1">
        <h1>Reports</h1>
		<div class="text-center" style="  margin: 0; ">
                <a href="report_file.php?td=pdf" class="btn-download">Download PDF</a>
                <a href="report_file.php?td=json" class="btn-download">Download JSON</a>
                <a href="report_file.php?td=xml" class="btn-download">Download XML</a>
            </div>
    </div>
	
<div class="panel with-nav-tabs panel-default"  style="width: 1000;  margin: 0 auto;   text-align: center;" >
	<div class="panel-heading">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#tab1default" data-toggle="tab">Revenue</a></li>
				<li><a href="#tab2default" data-toggle="tab">New clients</a></li>
				<li><a href="#tab3default" data-toggle="tab">Top contracts</a></li>
			</ul>
	</div>
	<div class="panel-body">
		<div class="tab-content">
			<div class="tab-pane fade in active" id="tab1default">
			<div class="container" style="width: 950;  margin: 0 auto;   text-align: center;" >
    
		
        <div class="report-content">
            
            
            <?php
            ColumnChart::create(array(
                "dataStore"=>$this->dataStore('contracts_by_year'),  
                "columns"=>array(
                    "DATE_OF_RECEIPT"=>array(
                        "label"=>"Year",
                        "type"=>"datetime",
                        "format"=>"Y",
                        "displayFormat"=>"Y",
                    ),
                    "COST"=>array(
                        "label"=>"Revenue",
                        "type"=>"number",
                        "prefix"=>"$",
                    )
                ),
                "width"=>"100%",
            ));
            ?>
        </div>
    
</div>
</div>
			<div class="tab-pane fade" id="tab2default">
				<iframe width="950" height="420" src="//embed.chartblocks.com/1.0/?c=5ecaaa543ba0f68276d82b5b&t=7a1d36c501288d6" frameBorder="0"></iframe>
			</div>
			<div class="tab-pane fade" id="tab3default">
				
				<iframe width="800" height="400" src="//embed.chartblocks.com/1.0/?c=5ecc0b683ba0f6b57fd82b5b&t=0bc5570981e671b" frameBorder="0"></iframe>
	
			</div>
		</div>
	</div>
</div>
</div>