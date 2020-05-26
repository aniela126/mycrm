<?php

require_once "../koolreport/core/autoload.php";

use \koolreport\KoolReport;
use \koolreport\processes\Filter;
use \koolreport\processes\TimeBucket;
use \koolreport\processes\Group;
use \koolreport\processes\Limit;

class Report extends KoolReport
{
	//  use \koolreport\cloudexport\Exportable;
    function settings()
    {
        return array(
            "dataSources"=>array(
                "sakila_rental"=>array(
                    "connectionString"=>"mysql:host=localhost:3308;dbname=project",
                    "username"=>"root",
                    "password"=>"",
                    "charset"=>"utf8"
                ),
            )
        ); 
    }    
    protected function setup()
    {
        $this->src('sakila_rental')
        ->query("SELECT DATE_OF_RECEIPT	, COST  FROM contracts")
        ->pipe(new TimeBucket(array(
            "DATE_OF_RECEIPT"=>"year"
        )))
        ->pipe(new Group(array(
            "by"=>"DATE_OF_RECEIPT",
            "sum"=>"COST"
        )))
        ->pipe($this->dataStore('contracts_by_year'));
    } 
}

?>


