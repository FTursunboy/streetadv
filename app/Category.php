<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = 'categoryID';

    protected $table = 'categories';

    public static function categoriesJson ($quest)
    {
        $arrCategoriesIDs = explode(',', $quest->categoryIDs);
        $oCategories = Category::whereIn('categoryID', $arrCategoriesIDs)->get();

        $arrCategories = [];
        foreach ($oCategories as $category) {
            $arrCategories[] = [
                'id' => $category->categoryID,
                'lang_id' => $category->languageID,
                'name' => $category->name,
                'color' => $category->color,
                'sort_number' => $category->sort_number,
                'bg_image' => $category->bg_image ? asset('uploads/categories/' . $category->bg_image) : '',
                'icon_image' => $category->icon_image ? asset('uploads/categories/' . $category->icon_image) : '',
                'created_at' => $category->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $category->updated_at->format('Y-m-d H:i:s')
            ];
        }

        return $arrCategories;
    }

    public static function categoriesForJson ($category)
    {
        $arrCategories = [
            'id' => $category->categoryID,
            'lang_id' => $category->languageID,
            'name' => $category->name,
            'color' => $category->color,
            'sort_number' => $category->sort_number,
            'bg_image' => $category->bg_image ? asset('uploads/categories/' . $category->bg_image) : '',
            'icon_image' => $category->icon_image ? asset('uploads/categories/' . $category->icon_image) : '',
            'created_at' => $category->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $category->updated_at->format('Y-m-d H:i:s')
        ];

        return $arrCategories;
    }
}
