<?php

namespace App\Admin\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class NewsController extends Controller
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

            $content->header('新闻动态');
            $content->description('新闻列表');

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

            $content->header('新闻编辑');
            $content->description('修改内容');

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

            $content->header('新闻发布');
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
        return Admin::grid(News::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->title('标题');
            $grid->sort('排序')->color('#dd4b39');
            $grid->thumb('封面图')->image();
            $grid->descr('简介');
            $grid->created_at('创建时间');
            $grid->updated_at('更新时间');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(News::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('title','标题')->rules('required');
            $form->select('cat','栏目')->options(['liuxue' => '低龄留学', 'news' => '雅际资讯']);
    		$form->image('thumb','封面图')->uniqueName()->removable()->rules('required');
    		$form->textarea('descr','简介')->rules('required');
    		$form->editor('content','详细内容');
    		$form->number('sort', '排序')->help('0-999排序越大越靠前')->min(0)->max(999)->default('0');
            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
        });
    }

    protected function rand($len)
    {
    	$chars='ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
          $string=time();
          for(;$len>=1;$len--)
          {
              $position=rand()%strlen($chars);
              $position2=rand()%strlen($string);
              $string=substr_replace($string,substr($chars,$position,1),$position2,0);
         }
         return $string;
    }

    protected function newslist(Request $request){
        $data = News::orderBy('sort', 'desc')->orderBy('created_at', 'desc')->paginate(5);
        return $data;
    }
}
