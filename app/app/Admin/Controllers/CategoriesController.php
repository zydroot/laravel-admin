<?php


namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\User;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Row;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Box;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index(Content $content){
        // 选填
        $content->header('分类管理');

        // 选填
        $content->description('分类管理详情');

        // 添加面包屑导航 since v1.5.7
        $content->breadcrumb(
            ['text' => '首页', 'url' => '/admin'],
            ['text' => '用户管理', 'url' => '/admin/users'],
            ['text' => '编辑用户']
        );

        // 填充页面body部分，这里可以填入任何可被渲染的对象
        //$content->body('hello world');

        // 在body中添加另一段内容
        //$content->body($this->grid());
        $content->body(Category::tree());

        // 直接渲染视图输出，Since v1.6.12
        //$content->view('dashboard', ['data' => 'foo']);

        return $content;
    }

    protected function grid()
    {
        $grid = new Grid(new Category());

        $grid->id('ID')->sortable();
        $grid->column('title')->setAttributes(['style' => 'color:red;']);
        $grid->parent_id('上级分类')->display(function($category_id){
            $cat = Category::find($category_id);
            return $cat!=null? $cat->name : "无";
        });
        /*$grid->released('上映?')->display(function ($released) {
            return $released ? '是' : '否';
        });*/
        $grid->created_at('创建时间');


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
            ->header('新建分类')
            ->description('产品分类新增页面')
            ->body($this->form());
    }

    public function store(Request $request, Category $category){
        $attribute = $request->all();
        $category->fill($attribute);
        $category->save();
    }



    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Category());

        //$categories = Category::getAllCate();

        $form->select('parent_id', '上级分类')->options(Category::selectOptions());;
        $form->text('title', '分类名称');
        $form->number('order', '排序');
        $form->display('created_at', '创建时间');

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

    public function update(Request $request, Category $category){

        $category->parent_id = $request->parent_id;
        $category->order = $request->order;
        $category->title = $request->title;
        $category->save();
        admin_toastr('分类创建成功..', 'success');
    }

    public function show($id, Content $content){

        return $content->header('Post')
            ->description('详情')
            ->body(\Encore\Admin\Facades\Admin::show(Category::findOrFail($id), function (Show $show) {
                $show->id('ID');
                $show->parent_id('上级分类')->as(function($parent_id){
                    return Category::find($parent_id)->title;
                });
                $show->order('排序');
                $show->created_at('创建时间');
            }));

    }

    public function destroy(Category $category) {

        $category->delete();
        admin_toastr('分类删除成功..', 'success');

    }
}