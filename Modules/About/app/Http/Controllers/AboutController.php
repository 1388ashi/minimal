<?php

namespace Modules\About\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Modules\About\Http\Requests\AboutUsDestroyRequest;
use Modules\About\Http\Requests\AboutUsStoreRequest;
use Modules\About\Http\Requests\AboutUsUpdateRequest;
use Modules\About\Models\AboutUs;

class AboutController extends Controller
{
    public function store(AboutUsStoreRequest  $request)
    {
        $validated = $request->validated();
        AboutUs::query()->create($validated);

        return redirect()->route('admin.about-us.edit')
            ->with('success', 'کلید تنظیمات با موفقیت ثبت شد');
    }

    public function edit(): Renderable
    {
        $aboutUsTypes = AboutUs::query()->get()->groupBy('type');
        $types = AboutUs::getAllTypes();

        return view('about::about-us', compact('aboutUsTypes',  'types'));
    }
    public function update(AboutUsUpdateRequest $request): RedirectResponse
    {
        $inputs = $request->except(['_token', '_method']);
        foreach ($inputs as $name => $text) {
            if ($aboutUs = AboutUs::where('name', $name)->first()) {
                if (in_array($aboutUs->type, ['image', 'video']) && $text->isValid()) {
                    $aboutUs->uploadFile($text);
                    $aboutUs->refresh();
                    $text = $aboutUs->file['url'];
                }
                $aboutUs->update(['text' => $text]);
            }
        }
        $data = [
            'status' => 'success',
            'message' => 'کلید با موفقیت ویرایش شد'
        ];
        return redirect()->back()
            ->with($data);
    }

    public function destroy(AboutUsDestroyRequest $request): RedirectResponse
    {
        AboutUs::query()
            ->where('name', $request->input('name'))
            ->delete();

        return redirect()->back()
            ->with('success', 'کلید با موفقیت حذف شد!');
    }

    /**
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\MediaCannotBeDeleted
     */
    public function deleteFile(AboutUs $aboutUs): RedirectResponse
    {
        abort_if(!in_array($aboutUs->type, ['image', 'video']), 403);

        $aboutUs->deleteMedia($aboutUs->file['id']);
        $aboutUs->update(['value' => null]);

        return redirect()->back()
            ->with('success', 'فایل با موفقیت حذف شد');
    }
}
