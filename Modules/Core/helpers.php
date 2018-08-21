<?php
//---------------------------------------------------
function br2nl($string)
{
    return preg_replace('/\<br(\s*)?\/?\>/i', "\n", $string);
}
//---------------------------------------------------
function moduleAssets($name)
{
    $asset = asset("public/assets/modules/" . $name);
    return $asset;
}

//---------------------------------------------------
function assetsCoreGlobal()
{
    $asset = asset("public/assets/theme/global");
    return $asset;
}

//---------------------------------------------------
function assetsCoreGlobalVendor()
{
    $asset = asset("public/assets/theme/global/vendor");
    return $asset;
}

//---------------------------------------------------
function assetsCoreMmenu()
{
    $asset = asset("public/assets/theme/mmenu/assets");
    return $asset;
}

//---------------------------------------------------
function loadExtendableView($view_name)
{
    /*$modules = new Modules\Core\Entities\Module();
    $modules = $modules->enabled()->slugs()->toArray();*/

    $modules = \NwidartModule::enabled();
    $modules = (array)json_decode(json_encode($modules));

    $module_order = array();


    $view = "";
    $i = 0;
    foreach ($modules as $module=>$item) {
        $module = strtolower($module);

        $order = Config::get($module.".order");

        if($order == 0 && $module != 'core')
        {
            $order = $i;
        }
        $module_order[$order] = $module;

        $i++;
    }

    ksort($module_order);


    foreach ($module_order as $module) {
        $module = strtolower($module);
        $full_view_name = $module . '::backend.extendable.' . $view_name;

        if (View::exists($full_view_name)) {
            try {
                $view = \View::make($full_view_name);
                echo $view;
            } catch (Exception $e) {
                echo json_encode($e->getMessage());
            }
        }
    }
}

//---------------------------------------------------
function isValidateDate($date)
{
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}

//---------------------------------------------------
function errorsToArray($errors)
{
    $errors = $errors->toArray();
    $error = array();
    foreach ($errors as $error_list) {
        foreach ($error_list as $item) {
            $error[] = $item;
        }
    }
    return $error;
}

//---------------------------------------------------
function fileNameFromPath($path)
{
    $info = pathinfo($path);
    $file_name = basename($path, '.' . $info['extension']);
    return $file_name;
}

//---------------------------------------------------
function imageResize($path, $width = null, $height = null, $new_file_name = null, $destination = null)
{

    //read more details about the package at: http://image.intervention.io/getting_started/installation#laravel

    if($width==null && $height == null)
    {
        return $path;
    }

    $file_name = fileNameFromPath($path);
    $file_extension = $extension = pathinfo($path, PATHINFO_EXTENSION);
    $full_file_name = $file_name . "." . $file_extension;
    $file_directory = str_replace($full_file_name, "", $path);
    if ($new_file_name == null)
    {
        if ($width != null) {
            $new_file_name = $file_name . "-" . $width;
        }
        if ($height != null) {
            $new_file_name = $new_file_name . "-" . $height;
        }
    }
    $new_file_name = $new_file_name . "." . $file_extension;

    if($destination == null)
    {
        $destination = $file_directory. $new_file_name;
    }

    if(file_exists( $destination)) {
        return $destination;
    }
    $img = \Image::make($path)->resize($width, $height, function ($constraint) {
        $constraint->aspectRatio();
    });
    $img->save($destination);
    return $destination;
}

//---------------------------------------------------
function getConstant($key)
{
    $val = null;
    switch ($key) {
        case 'permission.denied':
            $val = "Permission denied";
            break;
        //------------------------------------------
        case 'credentials.invalid':
            $val = "Invalid credentials";
            break;
        //------------------------------------------
        case 'account.disabled':
            $val = "Your account is disabled";
            break;
        //------------------------------------------
        case 'login.required':
            $val = "You must be logged in";
            break;
        //------------------------------------------
        case 'core.backend.logout':
            $val = "You have successfully logged out";
            break;
        //------------------------------------------
        case 'core.backend.not-found':
            $val = "Record not found";
            break;
        //------------------------------------------
    }
    return $val;
}
//---------------------------------------------------
function getRawQuery($model_query, $dump = false)
{
    $query = str_replace(array('?'), array('\'%s\''), $model_query->toSql());
    $query = vsprintf($query, $model_query->getBindings());

    if($dump)
    {
        dump($query);
    }

    return $query;
}
//---------------------------------------------------
//---------------------------------------------------
//---------------------------------------------------
//---------------------------------------------------
//---------------------------------------------------
