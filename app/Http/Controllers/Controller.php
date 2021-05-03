<?php

namespace App\Http\Controllers;

use App\Models\Assemblyman;
use App\Models\User;
use App\Models\UserAssemblyman;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\State;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $users;

    protected function getListUsers(){
        $this->users = User::all();
    }

    public function statesList(){
        return State::lists('uf','id');
    }


}
