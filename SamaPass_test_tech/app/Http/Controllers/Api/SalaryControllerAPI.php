<?php

namespace App\Http\Controllers\Api;

use App\Models\Salary;
use Illuminate\Http\Request;
use App\Imports\SalariesImport;
use App\Repositories\SalaryRepository;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\AppBaseController;
use Excel;


class SalaryControllerAPI extends AppBaseController
{
         /** @var  SalaryRepository */
    private $salaryRepository;

    public function __construct(SalaryRepository $salaryRepo)
    {
        $this->salaryRepository = $salaryRepo;
    }

     /**
     * Display a listing of the Salary.
     * GET|HEAD /salaries
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $salaries = Salary::all();
        return $this->sendResponse($salaries,"Success", 200);
    }


    /**
     * Store a newly created Salary in storage.
     * POST /salaries
     *
     * @param Create Salary API Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Salary::$rules);
        if ($validator->fails()) {
            $errorString = implode(",", $validator->messages()->all());
            return $this->sendError($errorString, 400);
        }
        $input = $request->all();

        $salary = $this->salaryRepository->create($input);
        return $this->sendResponse($salary,"Success", 200);
    }

    /**
     * Display the specified Salary.
     * GET|HEAD /salaries/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Salary $salary */
        $salary = $this->salaryRepository->find($id);

        if (empty($salary)) {
            return $this->sendError('Business Unit not found');
        }

        return $this->sendResponse($salary,"Success", 200);
    }


    /**
     * Update the specified Salary in storage.
     * PUT/PATCH /salaries/{id}
     *
     * @param int $id
     * @param UpdateSalaryAPIRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $input = $request->all();

        /** @var Salary $salary */
        $salary = $this->salaryRepository->find($id);

        if (empty($salary)) {
            return $this->sendError('Business Unit not found');
        }

        $salary = $this->salaryRepository->update($input, $id);

        return $this->sendResponse($salary,"Success", 200);
    }

    /**
     * Remove the specified Salary from storage.
     * DELETE /salaries/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Salary $salary */
        $salary = $this->salaryRepository->find($id);

        if (empty($salary)) {
            return $this->sendError('Business Unit not found');
        }

        $salary->delete();

        return $this->sendResponse($id, 'Business Unit deleted successfully');
    }

    /**
     * Import Bulk Salaries from CSV.
     * POST /salaries/import
     *
     *
     * @throws \Exception
     *
     * @return Response
     */

    public function import(Request $request)
    {
        $import = new SalariesImport;
        Excel::import($import, $request->file('file'));
        if (sizeof($import->Errors) > 0) return $this->sendError($import->Errors,400);
        return $this->sendResponse('Data imported', 200);
    }

}
