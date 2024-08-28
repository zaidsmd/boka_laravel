<?php

namespace App\Http\Controllers;

use App\Models\GlobalSetting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function liste()
    {
        $settings = GlobalSetting::all();
        return view('back_office.settings.liste', compact('settings'));
    }

    public function mettre_a_jour(Request $request)
    {
        $settings = GlobalSetting::all();
        foreach ($settings as $set){
            GlobalSetting::where('nom',$set->nom)->update([
                'valeur' => $request->get($set->nom)['valeur'] ?? false,

            ]);
        }
        session()->flash('success','تم تحديث الإعدادات العامة');
        return redirect()->route('settings.liste');
    }
}
