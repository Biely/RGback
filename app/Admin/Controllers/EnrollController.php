<?php

namespace App\Admin\Controllers;

use App\Models\Enroll;
use Illuminate\Http\Request;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class EnrollController extends Controller
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

            $content->header('试听报名');
            $content->description('报名列表');

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

            $content->header('试听报名');
            $content->description('编辑信息');

            $content->body($this->form()->edit($id));
        });
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
     
    public function update(Request $request, $enroll){
        $data = Enroll::find($enroll);
        $data->status = $request->input('status');
        if($data->save()){
            return ['message'=>'更新成功'];
        }else{
            return ['message'=>'更新失败'];;
        }
    }
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Enroll::class, function (Grid $grid) {
            $grid->disableCreateButton();
            $states = [
                'on'  => ['value' => 'on', 'text' => '已处理', 'color' => 'primary'],
                '0ff' => ['value' => 'off', 'text' => '未处理', 'color' => 'danger']
            ];
            $grid->id('ID')->sortable();
            $grid->name('姓名');
            $grid->sex('性别');
            $grid->age('年龄');
            $grid->tel('联系方式');
            $grid->area('所在地区');
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
        return Admin::form(Enroll::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('name','姓名')->rules('required');
            $form->text('age','年龄')->rules('required');
            $form->radio('sex','性别')->options(['男' => '男', '女'=> '女'])->default('男');
            $form->mobile('tel','电话号码');
            $form->text('area','所在地区');
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
