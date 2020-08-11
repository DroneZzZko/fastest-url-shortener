<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Hashids\Hashids;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Routing\Controller as BaseController;
use Throwable;

class DefaultController extends BaseController
{
    private Hashids $hashService;

    public function __construct(Hashids  $hashService)
    {
        $this->hashService = $hashService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @throws ValidationException
     * @throws Throwable if unable to save short url
     */
    public function shortUrl(Request $request): JsonResponse
    {
        $this->validate($request, [
            'url' => 'required|url'
        ]);

        $url = new Url();
        $url->url = $request->input('url');
        $url->saveOrFail();

        return response()->json([
            'newUrl' => url("/{$this->hashService->encode($url->id)}")
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function fullUrl(Request $request): RedirectResponse
    {
        $url = Url::find($this->hashService->decode($request->url)[0]);

        if ($url === null) {
            abort(404);
        }

        return redirect($url->url);
    }
}
