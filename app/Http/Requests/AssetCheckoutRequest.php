<?php

namespace App\Http\Requests;

use App\Models\Asset;
use App\Models\AssetModel;

class AssetCheckoutRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'assigned_user'         => 'required_without_all:assigned_asset,assigned_location',
            'assigned_asset'        => 'required_without_all:assigned_user,assigned_location',
            'assigned_location'     => 'required_without_all:assigned_user,assigned_asset',
            'status_id'             => 'exists:status_labels,id,deployable,1',
            'checkout_to_type'      => 'required|in:asset,location,user',
            'checkout_at' => [
                'nullable',
                'date',
            ],
            'expected_checkin' => [
                'nullable',
                'date'
            ],
        ];

        $asset = Asset::findOrFail($this->route('assetId'));
        $model = AssetModel::findOrFail($asset->model_id);

        if (($model) && ($model->fieldset)) {

            // todo: setting on the asset should happen in the controller and then $asset->save() should be called...
//            foreach ($model->fieldset->fields as $field){
//                if($field->format == 'BOOLEAN'){
//                    $asset->{$field->db_column} = filter_var($asset->{$field->db_column}, FILTER_VALIDATE_BOOLEAN);
//                }
//            }

           // $rules += $model->fieldset->validation_rules();

//            if ($asset->model->fieldset){
//                foreach ($asset->model->fieldset->fields as $field){
//                    if($field->format == 'BOOLEAN'){
//                        $asset->{$field->db_column} = filter_var($asset->{$field->db_column}, FILTER_VALIDATE_BOOLEAN);
//                    }
//                }
//            }
        }

        //dd($rules);

        return $rules;
    }
}
