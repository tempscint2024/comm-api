<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;

use App\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends ApiBaseController
{
    public function getAllProductCategories () {
        $productCategories = ProductCategory::all();
        return $this->respond($productCategories, 200);
    }


    public function getTopLevelProductCategories () {
        $topLevelProductCategories = ProductCategory::all()->where('parent','=', null);
        return $this->respond($topLevelProductCategories, 200);
    }

}
