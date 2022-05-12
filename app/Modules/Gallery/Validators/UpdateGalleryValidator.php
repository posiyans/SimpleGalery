<?php

namespace App\Modules\Gallery\Validators;


use App\Modules\Gallery\Models\MediaDirModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;


class UpdateGalleryValidator  extends FormRequest
{

    /**
     * Проверка на создателя галереи или админа.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();
        if ($user->role == 'admin') {
            return true;
        }
        $galleryId = $this->route('gallery');
        return MediaDirModel::where('id', $galleryId)
            ->where('user_id', $user->id)
            ->exists();
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
//            'parent_id'  => 'exists:App\Modules\Gallery\Models\MediaDirModel,id',
            'parent_id'  => 'numeric|nullable',
            'access' => 'string|max:255',
            'name' => 'string|max:255'
        ];
    }


}
