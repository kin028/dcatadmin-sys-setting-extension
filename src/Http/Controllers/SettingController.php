<?php

namespace Kin\Setting\Http\Controllers;

use Dcat\Admin\Form;
use Dcat\Admin\Http\JsonResponse;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Admin;
use Dcat\Admin\Models\Setting;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Validator;

class SettingController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->title('配置')
            ->description('')
            ->body($this->form());
    }

    protected function form()
    {
        return Form::make(new Setting(), function(Form $form){

            $data = Setting::get()->toArray();
            $table = json_encode($data, 320);

            $form->disableHeader();
            $form->disableViewButton();
            $form->disableEditingCheck();

            $form->table('table', "",function(Form\NestedForm $table) use ($data){

                $table->text("title", "标题")->required();
                $slugField = $table->text("slug", "名称")->required();

                // 如果当前嵌套表单的键存在于默认数据中，则禁用slug字段
                if (isset($data[$table->getKey()])) {
                    $slugField->disable();
                    $table->hidden('slug');
                }
                $table->text("value", "值");

            })->default($table)->width(8,2);

            $form->action(admin_url("setting/save"));
        });
    }

    public function save(JsonResponse $jsonResponse)
    {
        $data = request()->input('table');

        $insert = [];
        $delete = [];
        foreach ($data as $item) {
            if($item['_remove_'] == 0){
                $tmp = [
                    'title' => $item['title'],
                    'slug' => $item['slug'],
                    'value' => $item['value'],
                ];
                \Illuminate\Support\Facades\Validator::validate($tmp, [
                    'title' => 'required|max:191',
                    'slug' => 'required|max:100',
                    'value' => 'required',
                ], [
                    'title.required' => '标题不能为空',
                    'slug.required' => '名称不能为空',
                    'value.required' => '值不能为空',
                    'title.max' => '标题最大长度为191',
                    'slug.max' => '标题最大长度为100',
                ]);
                $insert[] = $tmp;
            } else {
                $delete[] = $item['slug'];
            }

        }





        Setting::upsert($insert, ['slug'], ['title','value']);
        Setting::whereIn('slug', $delete)->delete();

        return $jsonResponse->success("保存完成")->send();

    }
}
