<?php

namespace App\Http\Controllers;

use App\Models\Assemblyman;
use App\Models\UserAssemblyman;
use Illuminate\Support\Facades\Auth;
use InfyOm\Generator\Utils\ResponseUtil;
use Response;


/**
 * @SWG\Swagger(
 *   basePath="api/v1",
 *   @SWG\Info(
 *     title="Laravel Generator APIs",
 *     version="1.0.0",
 *   )
 * )
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */
class AppBaseController extends Controller
{

    public function sendResponse($result, $message)
    {
        return Response::json(ResponseUtil::makeResponse($message, $result));
    }

    public function checkPath($path)
    {
        if(!file_exists($path)) {
            mkdir($path, 0777, true);
        }
    }

    public function getAssembbyIds($gabs)
    {
        $ret = [];
        foreach($gabs as $gab)
        {
            $ret[] = $gab->assemblyman_id;
        }
        return $ret;
    }
}
