<?php

namespace App\Admin\Controllers;

use App\Models\Shequ;
use Illuminate\Http\Request;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ShequController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('社区合伙人');
            $content->description('社区合伙人申请');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form()->edit($id));
        });
    }

    public function update(Request $request, $shequ){
        $data = Shequ::find($shequ);
        $data->status = $request->input('status');
        if($data->save()){
            return ['message'=>'更新成功'];
        }else{
            return ['message'=>'更新失败'];;
        }
    }
    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Shequ::class, function (Grid $grid) {
            $grid->disableCreateButton();
             $states = [
                'on'  => ['value' => 'on', 'text' => '已处理', 'color' => 'primary'],
                '0ff' => ['value' => 'off', 'text' => '未处理', 'color' => 'danger']
            ];
            $grid->id('ID')->sortable();
            $grid->name('姓名');
            $grid->tel('联系方式');
            $grid->area('所在地区');
            $grid->job('职业');
            $grid->created_at();
            $grid->updated_at();
            $grid->status('处理状态')->switch($states);
            $grid->actions(function ($actions) {
                $actions->disableEdit();
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Shequ::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
