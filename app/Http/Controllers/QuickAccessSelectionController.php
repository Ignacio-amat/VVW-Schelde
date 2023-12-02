<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class QuickAccessSelectionController extends Controller
{
    public function index(){
        $categories = Category::all();
        return view('categories.quick-access-selection', compact('categories'));
    }

    /**
     * Updates quickAccess attribute of category as specified by ID
     *
     * @param Request $request
     * @param $id
     */
    public function update(Request $request, $id){
        $category = Category::findOrFail($id);

        $validatedData = $request->validate([
            'quickAccess' => 'required|boolean'
        ]);

        $category->quickAccess = $validatedData['quickAccess'];
        $category->save();

        return redirect(route('index'));
    }

}
