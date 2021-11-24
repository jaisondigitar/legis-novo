<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Libraries\Repositories\ProfileRepository;
use Flash;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Response;

class ProfileController extends AppBaseController
{
    /** @var ProfileRepository */
    private $profileRepository;

    public function __construct(ProfileRepository $profileRepo)
    {
        $this->profileRepository = $profileRepo;
    }

    /**
     * Display a listing of the Profile.
     *
     * @return Response
     */
    public function index()
    {
        $profiles = $this->profileRepository->paginate(10);

        return view('profiles.index')
            ->with('profiles', $profiles);
    }

    /**
     * Show the form for creating a new Profile.
     *
     * @return Response
     */
    public function create()
    {
        return view('profiles.create');
    }

    /**
     * Store a newly created Profile in storage.
     *
     * @param CreateProfileRequest $request
     *
     * @return Response
     */
    public function store(CreateProfileRequest $request)
    {
        $input = $request->all();

        $profile = $this->profileRepository->create($input);

        flash('Registro salvo com sucesso!')->success();

        return redirect(route('profiles.index'));
    }

    /**
     * Display the specified Profile.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $profile = $this->profileRepository->findBy('user_id', $id);

        if (empty($profile)) {
            $input['user_id'] = $id;
            $input['active'] = '1';
            $this->profileRepository->create($input);
        }

        return view('profiles.show')->with('profile', $profile);
    }

    /**
     * Show the form for editing the specified Profile.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $profile = $this->profileRepository->findBy('user_id', Auth::user()->id);

        if (empty($profile)) {
            $input['user_id'] = Auth::user()->id;
            $profile = $this->profileRepository->create($input);
        }

        return view('profiles.edit')->with('profile', $profile);
    }

    /**
     * Update the specified Profile in storage.
     *
     * @param  int              $id
     * @param UpdateProfileRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProfileRequest $request)
    {
        $profile = $this->profileRepository->findBy('user_id', Auth::user()->id);

        if (empty($profile)) {
            flash('Registro não existe.')->error();

            return redirect(route('profiles.index'));
        }

        $profile = $this->profileRepository->updateRich($request->all(), $id);
        $profile = $this->profileRepository->findBy('user_id', Auth::user()->id);
        $public = '/public';
        $path = '/uploads/images/profiles/';
        if (is_file($request->file('image'))) {
            $imageName = $profile->id.'.'.$request->file('image')->getClientOriginalExtension();
            if ($request->file('image')->move(base_path().$public.$path, $imageName)) {
                $profile->image = $path.$imageName;
                $profile->save();

                $image = Image::make(base_path().$public.$path.$imageName);
                $image->resize(100, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save();
            }
        }
        flash('Registro editado com sucesso!')->success();

        return redirect(route('profiles.index'));
    }

    /**
     * Remove the specified Profile from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $profile = $this->profileRepository->find($id);

        if (empty($profile)) {
            flash('Registro não existe.')->error();

            return redirect(route('profiles.index'));
        }

        $this->profileRepository->delete($id);

        flash('Registro deletado com sucesso!')->success();

        return redirect(route('profiles.index'));
    }

    /**
     * Update status of specified Profile from storage.
     *
     * @param  int $id
     *
     * @return Json
     */
    public function toggle($id)
    {
        $register = $this->profileRepository->find($id);
        $register->active = $register->active > 0 ? 0 : 1;
        $register->save();

        return json_encode(true);
    }
}
