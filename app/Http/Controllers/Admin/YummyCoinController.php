<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BackendController;
use App\Models\YummyCoin;
use Illuminate\Http\Request;

class YummyCoinController extends BackendController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $this->data['yummycoin'] = YummyCoin::all();
      return view('admin.yummycoin.index', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $yummy                         = new YummyCoin;
        $yummy->nombre                 = $request->get('nombre');
        $yummy->valeur                 = $request->get('valeur');
        $yummy->actif                  = $request->get('actif');
        $yummy->save();
        return redirect()->back()->withSuccess('Nombre de YummyCoin achetable ajouté avec succès');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $yummy                         = YummyCoin::findOrFail($id);
      $yummy->nombre                 = $request->get('nombre');
      $yummy->valeur                 = $request->get('valeur');
      $yummy->actif                  = $request->get('actif');
      $yummy->save();
      return redirect()->back()->withSuccess('Nombre de YummyCoin achetable modifié avec succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      YummyCoin::findOrFail($id)->delete();
      return redirect()->back()->withSuccess('Nombre de YummyCoin achetable supprimé avec succès');
    }
}
