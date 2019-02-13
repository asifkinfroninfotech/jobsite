<?php
namespace App\Helpers;
class DashboardSummaryData
{
     public $InterestShown;
     public $InvestorAssetsUnderManagement;
    //  public $FinancialRequests_Inprocess;
    //  public $FinancialRequests_Committed;
    //  public $AverageFinancialRequests_Committed;
     public $New_PreRegistrations;
     public $Noof_Views_Pipeline;
     public $Noof_Views_NewEnterprises;
     public $Incomplete_Profiles;
     public $New_Entity_Connections;
    //  public $Noof_ESOs_ConnectedWith_Enterprises;

    //Bar Chart Related
    public $Enterprise_Sector_Chart;
    // public $Sector_Lebels_Series; 
    // public $Sector_EnterprisesCount_Series; 
}

class ChartData
{
    public $Labels;
    public $Data;
}
