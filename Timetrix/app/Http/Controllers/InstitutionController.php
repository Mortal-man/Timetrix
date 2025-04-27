<?php

namespace App\Http\Controllers;

use App\Models\Institution;
use Illuminate\Http\Request;

class InstitutionController extends Controller
{
    public function index()
    {
        $institution = Institution::first();
        return view('institutions.index', compact('institution'));
    }

    public function edit($id)
    {
        $institution = Institution::findOrFail($id);
        return view('institutions.edit', compact('institution'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'nullable|email',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $institution = Institution::findOrFail($id);
        $data = $request->only([
            'name', 'abbreviation', 'motto', 'email',
            'phone', 'website', 'address'
        ]);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('logos'), $filename);
            $data['logo'] = 'logos/' . $filename;
        }

        $institution->update($data);

        return redirect()->route('institution.index')->with('success', 'Institution details updated successfully.');
    }
}
