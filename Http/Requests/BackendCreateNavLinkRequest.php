<?php

namespace Cms\Modules\Admin\Http\Requests;

use Cms\Http\Requests\Request;
use Auth;

class BackendCreateNavLinkRequest extends Request
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
        return [
            'title' => 'required|string',
            'class' => 'string',
            'blank' => 'required|boolean',
            'url' => 'required_without:route',
            'route' => 'required_without:url',
        ];
    }
}
