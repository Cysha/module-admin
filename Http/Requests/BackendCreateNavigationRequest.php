<?php

namespace Cms\Modules\Admin\Http\Requests;

use Cms\Http\Requests\Request;
use Auth;

class BackendCreateNavigationRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() && Auth::user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $tblPrefix = config('cms.admin.table-prefix', 'core_');

        return [
            'name' => 'required|unique:'.$tblPrefix.'navigation,name',
            'class' => 'string',
        ];
    }
}
