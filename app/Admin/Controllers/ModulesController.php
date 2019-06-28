<?php

namespace App\Admin\Controllers;

use App\Models\Module;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ModulesController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '模块';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Module);

        $grid->model()->orderBy('sort');
        $grid->column('module_name', __('模块名称'));
        $grid->column('image', __('图标'))->image();
        $grid->column('is_show', __('是否展示'))->switch();
        $grid->column('sort', __('排序'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Module::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('module_name', __('Module name'));
        $show->field('image', __('Image'));
        $show->field('introduction', __('Introduction'));
        $show->field('is_show', __('Is show'));
        $show->field('sort', __('Sort'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Module);

        $form->text('module_name', __('模块名称'))->rules('required',[
            'required'=>'必填'
        ]);
        $form->image('image', __('图标'))->rules('required',[
            'required'=>'必填'
        ]);
        $form->text('introduction', __('简介'))->rules('required',[
            'required'=>'必填'
        ]);
        $form->switch('is_show', __('是否展示'))->default(0);
        $form->number('sort', __('排序'))->default(50);

        $form->footer(function ($footer) {


            // 去掉`查看`checkbox
            $footer->disableViewCheck();

            // 去掉`继续编辑`checkbox
            $footer->disableEditingCheck();

            // 去掉`继续创建`checkbox
            $footer->disableCreatingCheck();

        });

        return $form;
    }
}
