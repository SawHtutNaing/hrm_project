<?php

namespace Modules\FieldService\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\file\FileServices;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\FieldService\Entities\FsCampaign;
use Modules\FieldService\Entities\ImageGallery;

class ImageGalleryController extends Controller
{
    public $path = '';

    public function __construct()
    {

        $this->path = 'gallery/';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('fieldservice::gallery.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('fieldservice::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $path = $this->path;
        $fileNames = [];
        try {
            DB::beginTransaction();
            $campaign_id = $request->campaign_id;
            if (! FsCampaign::where('id', $campaign_id)->exists()) {
                throw new Exception('Campaign Not found');
            }

            $note = $request->note;
            $fileNames = $this->uploadImage($request);
            ImageGallery::create([
                'note' => $note,
                'images' => json_encode($fileNames),
                'created_by' => Auth::user()->id,
                'campaign_id' => $campaign_id,
            ]);
            DB::commit();

            return back()->with('success', 'Successfully Uploaded');
        } catch (\Throwable $th) {
            foreach ($fileNames as $file) {
                FileServices::delete($file, $path);
            }
            DB::rollback();

            return back()->with('error', $th->getMessage());
        }
    }

    public function uploadImage($request, $filename = 'images')
    {
        $fileNames = [];
        $path = $this->path;
        $hasImages = $request->hasFile($filename);
        if ($hasImages) {
            $images = $request->file($filename);
            foreach ($images as $image) {
                $fileName = FileServices::upload($image, $path);
                $fileNames = [...$fileNames, $fileName];
            }
        }

        return $fileNames;
    }

    public function data($campaign_id)
    {
        return ImageGallery::where('campaign_id', $campaign_id)
            ->with('user.personal_info:id,first_name,last_name,profile_photo')
            ->orderBy('id', 'DESC')->paginate(30);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('fieldservice::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ImageGallery $gallery)
    {
        return view('fieldservice::gallery.edit', compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {

        $path = $this->path;
        try {
            DB::beginTransaction();
            $gallery = ImageGallery::where('id', $id)->first();
            $galleryFiles = json_decode($gallery->images);
            $files = json_decode($request->remove_file);
            $updatedFile = array_diff($galleryFiles, $files);

            $fileNames = $this->uploadImage($request, 'newimages');
            $updatedFile = [...$updatedFile, ...$fileNames];
            $gallery->update([
                'note' => $request->note,
                'images' => json_encode($updatedFile),
                'updated_at' => now(),
            ]);
            foreach ($files as $f) {
                FileServices::delete($f, $this->path);
            }

            DB::commit();

            return back()->with('success', 'Successfully Uploaded');
        } catch (\Throwable $th) {
            foreach ($fileNames as $file) {
                FileServices::delete($file, $path);
            }
            DB::rollback();

            return back()->with('error', $th->getMessage());
        }

        return back()->with('success', 'Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        logger('here');
        try {
            DB::beginTransaction();

            ImageGallery::where('id', $id)->first()->delete();
            DB::commit();

            return response()->json(['message' => 'Successfully Deleted'], 200);
        } catch (\Throwable $th) {
            logger($th->getMessage());
            DB::rollBack();

            return response()->json(['message' => 'Something Wrong'], $th->getCode());
        }
    }
}
