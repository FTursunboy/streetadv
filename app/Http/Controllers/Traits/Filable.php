<?php

namespace App\Http\Controllers\Traits;

use File;
use Image;

trait Filable
{

    /**
     * @param $folder
     * @param $filePath
     * @param null $width
     * @param null $height
     * @return mixed
     */
    public function moveFile($folder, $filePath, $width = null, $height = null)
    {
        $file = a_end(explode('/', $filePath));

        if(File::exists(public_path('/uploads/admin/'). $file)){
            if(is_image($file)){
                $img = Image::make(public_path('/uploads/admin/'. $file));
                if(!is_null($width) || !is_null($height)){
                    $img->fit($width,$height)->save();
                }
            }

           File::move(public_path('uploads/admin/'. $file), public_path('uploads/'.$folder.'/'. $file));
        }
        
        return $file;
    }


}