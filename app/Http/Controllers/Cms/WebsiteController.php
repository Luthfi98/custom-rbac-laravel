<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settingPath = storage_path('settings.json');
        $jsonContents = file_get_contents($settingPath);

        // Decode the JSON content
        $setting = json_decode($jsonContents);
        $data = ['title' => 'Website Setting', 'data' => $setting];
        return view('cms.setting', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name'              => 'required|string',
            // 'description'       => 'required|string',
            // 'name_sender_email' => 'required|string',
            // 'sender_email'      => 'required|string',
            // 'password_email'    => 'required|string',
            // 'name_sender_wa'    => 'required|string',
            // 'sender_wa'         => 'required|string|numeric',
            // 'url_api_wa'        => 'required|string',
            // 'key_wa'            => 'required|string',
        ];

        $data = $request->input();
        unset($data['_token']);

        if($request->hasFile('logo'))
        {
            $rules[] = [
                'logo' => 'required|file|max:2048|mimes:jpeg,png,jpg'
            ];
        }

        if($request->hasFile('icon'))
        {
            $rules[] = [
                'icon' => 'required|file|max:2048|mimes:jpeg,png,jpg'
            ];
        }

        $validator = Validator::make($request->all(), $rules);

        // dd($request->hasFile('image'));

        if ($validator->fails()) {
            return redirect(route('website.index'))
                ->withErrors($validator)
                ->withInput();
        }

        $settingPath = storage_path('settings.json');
        $jsonContents = file_get_contents($settingPath);

        // Decode the JSON content
        $setting = json_decode($jsonContents);
        $data['logo'] = $setting->logo??'';
        $data['icon'] = $setting->icon??'';

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '_logo_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/website'), $filename);
            $logo = 'uploads/website/' . $filename;
            $data['logo'] = $logo;
        }

        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $filename = time() . '_icon_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/website'), $filename);
            $icon = 'uploads/website/' . $filename;
            $data['icon'] = $icon;
        }
        $data['notif_wa'] = $request->notif_wa;
        $data['notif_email'] = $request->notif_email;

        $settingPath = storage_path('settings.json');
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);

        file_put_contents($settingPath, $jsonData);

        session()->flash('success', 'Successfully Updated Data');

        return redirect(route('website.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
