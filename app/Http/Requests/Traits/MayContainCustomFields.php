<?php

namespace App\Http\Requests\Traits;

use App\Models\AssetModel;
use App\Models\CustomField;

trait MayContainCustomFields
{
    // this gets called automatically on a form request
    public function withValidator($validator)
    {
        // find the model
        if ($this->method() == 'POST') {
            $asset_model = AssetModel::find($this->model_id);
        }
        if ($this->method() == 'PATCH' || $this->method() == 'PUT') {
            // this is dependent on the asset update request PR
            $asset_model = $this->asset;
        }
        // collect the custom fields in the request
        $validator->after(function ($validator) use ($asset_model) {
            $request_fields = $this->collect()->keys()->filter(function ($attributes) {
                return str_starts_with($attributes, '_snipeit_');
            });
            // if there are custom fields, find the one's that don't exist on the model's fieldset and add an error to the validator's error bag
            if (count($request_fields) > 0) {
                $request_fields->diff($asset_model->fieldset->fields->pluck('db_column'))
                        ->each(function ($request_field_name) use ($request_fields, $validator) {
                            if (CustomField::where('db_column', $request_field_name)->exists()) {
                                $validator->errors()->add($request_field_name, 'This field seems to exist, but is not available on this Asset Model\'s fieldset.');
                            } else {
                                $validator->errors()->add($request_field_name, 'This field does not seem to exist, please double check your custom field names.');
                            }
                        });
            }
        });
    }
}

