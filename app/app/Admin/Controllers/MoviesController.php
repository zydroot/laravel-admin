<?php


namespace App\Admin\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\User;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Row;
use Encore\Admin\Layout\Content;

class MoviesController extends Controller
{
    public function index(Content $content){
        // 选填
        $content->header('填写页面头标题');

        // 选填
        $content->description('填写页面描述小标题');

        // 添加面包屑导航 since v1.5.7
        $content->breadcrumb(
            ['text' => '首页', 'url' => '/admin'],
            ['text' => '用户管理', 'url' => '/admin/users'],
            ['text' => '编辑用户']
        );

        // 填充页面body部分，这里可以填入任何可被渲染的对象
        $content->body('hello world');

        // 在body中添加另一段内容
        $content->body($this->grid());

        // 直接渲染视图输出，Since v1.6.12
        //$content->view('dashboard', ['data' => 'foo']);

        return $content;
    }

    protected function grid()
    {
        $grid = new Grid(new Movie());

        $grid->id('ID')->sortable();
        $grid->column('title')->setAttributes(['style' => 'color:red;']);
        $grid->describe('描述')->editable();
        $grid->director('用户')->display(function($userid){
            return User::find($userid)->name;
        });
        $grid->released('上映?')->display(function ($released) {
            return $released ? '是' : '否';
        });
        $grid->created_at('Created at');
        $grid->actions(function($actions){
            $actions->disableView();
            $actions->prepend('<a href=""><i class="fa fa-paper-plane">A</i></a>');
        });

        return $grid;
    }


    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('新建产品')
            ->description('新建产品页面')
            ->body($this->form());
    }



    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Movie());

        $form->display('id', 'ID');
        $form->display('describe', 'describe');
        $form->display('director', 'director');
        $form->display('created_at', 'Created At');
        $form->display('updated_at', 'Updated At');

        return $form;
    }


    /**
     * Edit interface.
     *
     * @param mixed   $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('编辑')
            ->description('description')
            ->body($this->form()->edit($id));
    }
}