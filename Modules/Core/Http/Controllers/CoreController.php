<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Entities\Module;



class CoreController extends Controller
{

	//--------------------------------------------------------
    function fileUpload()
    {
        return view( 'core::frontend.file-upload' );
    }
	//--------------------------------------------------------
    public function fileUploader(Request $request)
    {
        error_reporting(E_ALL | E_STRICT);
        new \Modules\Core\Http\Controllers\UploadController();
        //return response()->json($response);

    }
	//--------------------------------------------------------
	public function modulesSyncWithDb()
	{
		try{
			$list = \NwidartModule::all();
			$list = (array)json_decode(json_encode($list));
			if(is_array($list) && count($list) >0)
			{
				foreach ($list as $module_name => $item)
				{
					$path = base_path()."/Modules/".$module_name."/module.json";
					if (\File::exists($path))
					{
						$file = \File::get($path);
						$module_config = json_decode($file);
						$config = (array)$module_config;

						$module = Module::firstOrNew(['slug' => $config['alias']]);
						$module->name = $config['name'];
						$module->slug = $config['alias'];
						if(isset($config['version']))
						{
							$parse_version = explode(".",$config['version']);
							if(isset($parse_version[0]))
							{
								$module->version_major = $parse_version[0];
							}
							if(isset($parse_version[1]))
							{
								$module->version_minor = $parse_version[1];
							}

							if(isset($parse_version[2]))
							{
								$module->version_revision = $parse_version[2];
							}

							if(isset($parse_version[3]))
							{
								$module->version_build = $parse_version[3];
							}
						}

						if(isset($config['description']))
						{
							$module->details = $config['description'];
						}

						$module->meta = json_encode($config);
						if(isset($config['active']))
						{
							$module->enable = $config['active'];
						}
						$module->save();
					}
				}
			}
			$response['status'] = 'success';

		}catch(Exception $e)
		{
		    $response['status'] = 'failed';
		    $response['errors'][] = $e->getMessage();
		}

		return response()->json( $response );

	}
	//--------------------------------------------------------
	public function ui()
	{
		return view( 'core::frontend.ui' );
	}
	//--------------------------------------------------------
	public function doc()
	{
		return view( 'core::frontend.doc' );
	}
	//--------------------------------------------------------
    public function test()
    {



        return view( 'core::frontend.test' );
    }
	//--------------------------------------------------------
    public function emailTemplate($name)
    {
        return view( 'core::emails.'.$name );
    }
	//--------------------------------------------------------
	//--------------------------------------------------------
	//--------------------------------------------------------
	//--------------------------------------------------------

}
