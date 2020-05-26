<?php 
    use \koolreport\widgets\koolphp\Table;
    use \koolreport\widgets\google\ColumnChart;
	use \koolreport\bootstrap3\Theme;
?>
<html>
<head>
	<link rel="stylesheet" href="../koolreport/packages/bootstrap3/assets/core/css/bootstrap.min.css" />
	<link rel="stylesheet" href="../koolreport/packages/bootstrap3/assets/core/css/bootstrap-theme.min.css" /> 
	<link href='../css/table_styles.css' rel='stylesheet' type='text/css'/>		
    <link href='../css/menustyle.css' rel='stylesheet' type='text/css'/>
</head>
    <body style="margin:0.5in 1in 0.5in 1in">

        <div class="page-header" style="text-align:right"><i>CRM Report</i></div>
        <div class="page-footer" style="text-align:right">{1}</div>
        <div class="text-center">
            <h1></h1>
            <h4>Contracts revenue by year</h4>
        </div>
        <hr/>

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

    <?php
    Table::create(array(
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
        "cssClass"=>array(
            "table"=>"table table-hover table-bordered"
        )
    ));
    ?>
	
    </body>
</html>