<?php


namespace App\Http\Traits;



trait CompanyDetailsTrait
{
    public function getCompanyDetailsForAsExcellRows($colnumber = 1)
    {
        $aExcelRows = [];

        $aExcelRows[] = [config('company.name')];
        $aExcelRows[] = [config('company.address')];
        $aExcelRows[] = [config('company.zip') . ' ' . config('company.city')];
        //   $aExcelRows[] = [config('company.country')];
        $aExcelRows[] = ['Telefoon: ' . config('company.phone')];
        $aExcelRows[] = ['Bankrekening: ' . config('company.bankaccount') . ' t.n.v. ' . config('company.bankaccountname')];
        $aExcelRows[] = ['BTW id nummer; ' . config('company.vatnumber')];
        $aExcelRows[] = ['KvK nummer: ' . config('company.kvknumber')];


        foreach ($aExcelRows as $key => $aExcelRow) {
            $count = 1;
            while ($count < $colnumber) {
                array_unshift($aExcelRows[$key], '');
                $count++;
            }
        }
        return $aExcelRows;
    }



    public function getAllCompanyDetails()
    {
        return config('company');
    }
}
