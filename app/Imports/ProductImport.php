<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProductImport implements ToCollection
{

    protected $repo;

//    /**
//    * @param array $row
//    *
//    * @return \Illuminate\Database\Eloquent\Model|null
//    */
//    public function model(array $row)
//    {
//        return new ElectronicInvoice([
//            //
//        ]);
//    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        try {
            DB::beginTransaction();
            $ordersArr = [];
            foreach ($rows as $key => $row) {
                if ($key < 1 || $row[1] == null || $row[1] == ' ') {
                    continue;
                }

                //*********Validations start**********//
                if (empty($row[0])) {
                    throw new \Exception("please enter product name");
                }
                if (empty($row[1])) {
                    throw new \Exception("please enter product number");
                }
                if (empty($row[2])) {
                    throw new \Exception("please enter article group Id");
                }
                if (empty($row[3])) {
                    throw new \Exception("please enter price");
                }

                //*********Validations end**********//


                $model = [];
                $model['product_name'] = $row[0];
                $model['part_number'] = $row[1];
                $model['article_group_id'] = $row[2];
                $model['price'] = $row[3];
                $ordersArr[] = $model;
            }
            if (count($ordersArr) > 0) {
                //use service to import data
                $this->createProducts($ordersArr);
            } else {
                throw new \Exception('something went wrong');
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception('something went wrong');
        }
    }

    public function createProducts(array $ordersArr)
    {
       return Product::insert($ordersArr);

    }


}
