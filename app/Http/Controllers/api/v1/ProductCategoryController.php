<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;

use App\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{

    public function getTopLevelProductCategories () {
        $topLevelProductCategories = ProductCategory::all()->where('parent','=', null);
        return $topLevelProductCategories;
    }

}
