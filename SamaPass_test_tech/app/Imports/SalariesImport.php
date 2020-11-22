<?php

namespace App\Imports;

use App\Models\Salary;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Illuminate\Support\Facades\Validator;

class SalariesImport implements ToCollection, WithHeadingRow,WithCalculatedFormulas
{
    public $Errors;
    private $row_num = 0;

    function __construct() {
       $this->Errors = array();
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {

        foreach ($rows as $row)
        {
            ++$this->row_num;
            if(!$row->filter()->isNotEmpty())continue;
            $validator = Validator::make($row->toArray(), Salary::$rules);
            if($validator->fails()){
                $errorString = implode(",", $validator->messages()->all());
                $obj1 = new \stdClass;
                $obj1->message = $errorString;
                $obj1->row_num = $this->row_num;
                array_push($this->Errors,$obj1);
            }else{
                Salary::create([
                    'employee'=> $row['employee'],
                    'amount'=> $row['amount']
                ]);
            }

        }

    }
}
