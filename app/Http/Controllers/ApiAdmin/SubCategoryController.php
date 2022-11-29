<?php

namespace App\Http\Controllers\ApiAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Admin\SubCategoryRepository;
use Exception;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    private $subCategoryRepository;
    public function __construct(SubCategoryRepository $subCategoryRepository)
    {
        $this->subCategoryRepository = $subCategoryRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = $this->subCategoryRepository->getSubCategoryOfIndex();
            return $this->RespondWithSuccess('All subCategory list show successfull', $data, 200);
        } catch (Exception $e) {
            return $this->RespondWithEorror('All subCategory list not show successfull !!', $e->getMessage(), 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:sub_categories',

        ]);
        if ($validator->fails()) {
            return $this->RespondWithEorror('validation subCategory error ', $validator->errors(), 422);
        }
        try {
            $data = $this->subCategoryRepository->StoreSubCategory($request);
            return $this->RespondWithSuccess('subCategory create successfull !! ', $data, 200);
        } catch (Exception $e) {
            return $this->RespondWithEorror('subCategory not create successfull', $e->getMessage(), 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data = $this->subCategoryRepository->getSubCategoryId($id);
            return $this->RespondWithSuccess('Show subCategory successfull !! ', $data, 200);
        } catch (Exception $e) {
            return $this->RespondWithEorror('not show subCategory successfull', $e->getMessage(), 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'unique:sub_categories,name,' . $id,

        ]);
        if ($validator->fails()) {
            return $this->RespondWithEorror('validation subCategory error ', $validator->errors(), 422);
        }
        try {
            $data = $this->subCategoryRepository->updateSubCategory($request, $id);
            return $this->RespondWithSuccess('SubCategory update successfull !! ', $data, 200);
        } catch (Exception $e) {
            return $this->RespondWithEorror('SubCategory not update successfull', $e->getMessage(), 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = $this->subCategoryRepository->deleteSubCategory($id);
            return $this->RespondWithSuccess('SubCategory delete successfull !!', $data, 200);
        } catch (Exception $e) {
            return $this->RespondWithEorror('SubCategory not successfull', $e->getMessage(), 400);
        }
    }
}
