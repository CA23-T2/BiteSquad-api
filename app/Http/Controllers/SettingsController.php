<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{

    public function index() {

        $settings = Setting::all();

        return view('admin.settings.index', compact('settings'));
    }

    public function update (Request $request, $id){
        $setting = Setting::findOrFail($id);

        $setting->update(['value' => $request->value]);

        return redirect()->back();
    }
}
