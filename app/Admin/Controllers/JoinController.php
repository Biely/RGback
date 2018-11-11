<?php

namespace App\Admin\Controllers;

use App\Models\Join;
use Illuminate\Http\Request;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class JoinController extends Controller
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

            $content->header('加盟申请');
            $content->description('申请列表');

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

    public function update(Request $request, $join){
        $data = Join::find($join);
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
        return Admin::grid(Join::class, function (Grid $grid) {
            $grid->disableCreateButton();
             $states = [
                'on'  => ['value' => 'on', 'text' => '已处理', 'color' => 'primary'],
                '0ff' => ['value' => 'off', 'text' => '未处理', 'color' => 'danger']
            ];
            $grid->id('ID')->sortable();
            $grid->name('姓名');
            $grid->tel('联系方式');
            $grid->where('所在地区');
            $grid->type('申请类型');
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
        return Admin::form(Join::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
