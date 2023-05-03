<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function getAllData()
    {
        $data = Product::orderBy('id', 'desc')->get();
        return response()->json([
            'data' => $data,
        ]);
    }

    public function store(Request $request)
    {

        $data = $request->all();

        // profile_picture
        $profile_picture = $request->hasFile('image');

        if ($profile_picture) {
            // return true;
            $profile_picture = $request->file('image');
            $profilePictureWithExt = $profile_picture->getClientOriginalName();
            $random_value = Str::random(30);
            $profilePictureExtension = pathinfo($profilePictureWithExt, PATHINFO_EXTENSION);
            $profilePictureExtension = Str::lower($profilePictureExtension);
            $filenameProfilePicture = $random_value . '.' . $profilePictureExtension;

            $profile_picture_path = public_path('/assets/picture/');
            if (!File::isDirectory($profile_picture_path)) {

                File::makeDirectory($profile_picture_path, 777, true, true);
            }
            $profile_picture->storeAs('/picture', $filenameProfilePicture);
            $data['image'] = $filenameProfilePicture;
        }

        DB::beginTransaction(); // initiate transaction

        try {
            Product::create($data);

            DB::commit(); //finish transaction

            return response()->json([
                'message' => 'Successfully created',
            ]);
        } catch (\Exception $e) {
            DB::rollBack(); // if anything goes wrong then undo transaction
            return response()->json([
                'message' => 'Error,Something went wrong',
                'error' => 'error is ' . $e,
            ]);

        }

    }

    public function edit($id)
    {
        $data = Product::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $getData = Product::findOrFail($id);
        // profile_picture
        $profile_picture = $request->hasFile('image');

        if ($profile_picture) {
            // return true;
            $profile_picture = $request->file('image');

            $profilePictureWithExt = $profile_picture->getClientOriginalName();

            $random_value = Str::random(30);

            $profilePictureExtension = pathinfo($profilePictureWithExt, PATHINFO_EXTENSION);
            $profilePictureExtension = Str::lower($profilePictureExtension);
            $filenameProfilePicture = $random_value . '.' . $profilePictureExtension;

            $profile_picture_path = public_path('/assets/picture/');

            // Delete the previous image file associated with the data being updated
            if ($getData->image != null) {
                @unlink($profile_picture_path . $getData->image); // delete the previous image file
                $profile_picture->storeAs('/picture', $filenameProfilePicture);
                $data['image'] = $filenameProfilePicture;
            } else {

                if (!File::isDirectory($profile_picture_path)) {
                    File::makeDirectory($profile_picture_path, 777, true, true);
                }
                $profile_picture->storeAs('/picture', $filenameProfilePicture);
                $data['image'] = $filenameProfilePicture;
            }
            DB::beginTransaction();
            try {
                //code...
                $getData->fill($data)->save();
                DB::commit();
                return response()->json([
                    'message' => 'Information updated successfully',
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'error' => 'Something went wrong' . $e->getMessage(),
                ]);
            }

        }

    }

    public function deleteData($id)
    {
        $getData = Product::findOrFail($id);
        if ($getData->image != null) {
            $profile_picture_path = public_path('/assets/picture/');
            @unlink($profile_picture_path . $getData->image);
        }
        DB::beginTransaction();
        try {
            //code...
            $getData->delete();
            DB::commit();
            return response()->json([
                'message' => 'Successfully deleted',
            ]);
        } catch (\Exception $e) {
            //throw $th;
            DB::rollBack();
            return response()->json([
                'error' => 'Something went wrong' . $e->getMessage(),
            ]);
        }

    }

}
