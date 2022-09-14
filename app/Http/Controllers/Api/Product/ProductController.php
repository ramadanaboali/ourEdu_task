<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;

use App\Http\Repositories\Eloquent\Product\ProductRepo;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\Api\ProductRequest;
use App\Http\Requests\PaginateRequest;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\SearchResource;
use App\Imports\ProductImport;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    protected $repo;
    public function __construct(ProductRepo $repo)
    {
        $this->repo = $repo;
    }

    public function index(PaginateRequest $request)
    {
        $input = $this->repo->inputs($request->all());
        $model = new Product();
        $columns = Schema::getColumnListing($model->getTable());

        if (count($input["columns"]) < 1 || (count($input["columns"]) != count($input["column_values"])) || (count($input["columns"]) != count($input["operand"]))) {
            $wheres = [];
        } else {
            $wheres = $this->repo->whereOptions($input, $columns);

        }
        $data = $this->repo->Paginate($input, $wheres);

        return responseSuccess([
            'data' => $input["resource"] == "all" ? ProductResource::collection($data) : SearchResource::collection($data),
            'meta' => [
                'total' => $data->count(),
                'currentPage' => $input["offset"],
                'lastPage' => $input["paginate"] != "false" ? $data->lastPage() : 1,
            ],
        ], 'data returned successfully');
    }

    public function get($Product)
    {
        $data = $this->repo->findOrFail($Product);

        return responseSuccess([
            'data' => new ProductResource($data),
        ], 'data returned successfully');
    }



    public function store(ProductRequest $request)
    {
        $object = new ProductImport();
        Excel::import($object, request()->file('file'));
        return responseSuccess([], 'data saved successfully');

    }

    public function update($Product, ProductRequest $request)
    {
        $Product = $this->repo->findOrFail($Product);
        $input = [
            'name' => $request->name ??  $Product->name,

        ];

            $data = $this->repo->update($input, $Product);

          if ($data) {

            return responseSuccess(new ProductResource($Product->refresh()), 'data Updated successfully');
          } else {
            return responseFail('something went wrong');
          }



    }



    public function bulkDelete(BulkDeleteRequest $request)
    {
        DB::beginTransaction();
        try {

            $data = $this->repo->bulkDelete($request->ids);
            if ($data) {

                DB::commit();
                return responseSuccess([], 'data deleted successfully');
            } else {
                return responseFail('something went wrong');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return responseFail('something went wrong');
        }
    }

    public function bulkRestore(BulkDeleteRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $this->repo->bulkRestore($request->ids);
            if ($data) {

                DB::commit();
                return responseSuccess([], 'data restored successfully');
            } else {
                return responseFail('something went wrong');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return responseFail('something went wrong');
        }
    }


}
