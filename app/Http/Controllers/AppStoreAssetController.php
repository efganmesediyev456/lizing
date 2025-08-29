<?php
namespace App\Http\Controllers;

use App\Models\AppStoreAsset;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
      use Intervention\Image\ImageManagerStatic as Image;

class AppStoreAssetController extends Controller
{
    public function index()
    {
        $asset = AppStoreAsset::first();
        if(is_null(($asset))){
            $asset = AppStoreAsset::create([

            ]);
        }
        return view('app-store-assets.index', compact('asset'));
    }

   

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'app_name' => 'required|string|max:255',
            'description' => 'required|string',
            'app_icon' => 'sometimes|image|mimes:png,jpg,jpeg|max:2048|dimensions:min_width=512,min_height=512',
            'screenshots.*' => 'image|mimes:png,jpg,jpeg|max:2048',
            'app_category' => 'required|string',
            'privacy_policy_url' => 'nullable|url'
        ]);

        $iconPath = null;
        $manager = new ImageManager(new GdDriver());


        $data=[
            'app_name' => $request->input('app_name'),
            'description' => $request->input('description'),
            'app_category' => $request->input('app_category'),
            'privacy_policy_url' => $request->input('privacy_policy_url'),
            'full_description' => $request->input('full_description'),
        ];

        if ($request->hasFile('app_icon')) {
            $icon = $request->file('app_icon');
            $iconName = 'app_icon_' . time() . '.' . $icon->getClientOriginalExtension();
            $iconPath = $icon->storeAs('app_store_assets/icons', $iconName, 'public');
            $data['icon_path'] = $iconPath;
        }

        if ($request->hasFile('feature_graphic_image')) {
            $icon = $request->file('feature_graphic_image');
            $iconName = 'feature_graphic_image_' . time() . '.' . $icon->getClientOriginalExtension();
            $iconPath = $icon->storeAs('app_store_assets/icons', $iconName, 'public');
            $data['feature_graphic_image'] = $iconPath;
        }


        $screenshotPaths = [];
        if ($request->hasFile('screenshots')) {
            foreach ($request->file('screenshots') as $screenshot) {
                $screenshotName = 'screenshot_' . uniqid() . '.' . $screenshot->getClientOriginalExtension();
                $screenshotPath = $screenshot->storeAs('app_store_assets/screenshots', $screenshotName, 'public');

                // $screenshotFullPath = storage_path('app/public/' . $screenshotPath);

                // $manager->read($screenshotFullPath)
                //         ->resize(1242, 2688)
                //         ->save($screenshotFullPath);

                $screenshotPaths[] = $screenshotPath;


            }

            $data['screenshot_paths']= json_encode($screenshotPaths);

        }

        $tablets = [];
        if ($request->hasFile('tablets')) {
            foreach ($request->file('tablets') as $screenshot) {
                $screenshotName = 'screenshot_' . uniqid() . '.' . $screenshot->getClientOriginalExtension();
                $screenshotPath = $screenshot->storeAs('app_store_assets/tablets', $screenshotName, 'public');
                $tablets[] = $screenshotPath;
            }
            $data['tablets']= json_encode($tablets);
        }



        $appAsset = AppStoreAsset::first()->update($data);

        return $this->responseMessage('success','Successfully Updated', null, 200, null);
       
    }
}
