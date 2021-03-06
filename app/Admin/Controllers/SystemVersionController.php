<?php

namespace App\Admin\Controllers;

use App\Models\SystemVersion;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SystemVersionController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '系统版本发布';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new SystemVersion);

        $grid->model()->orderBy('identifier','desc');

        $grid->column('version', __('版本号'));
        $grid->column('identifier', __('身份标识'));
        $grid->column('is_show', __('是否展示'));

        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableView();
        });
        $grid->disableRowSelector();
        $grid->disableExport();


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
        $show = new Show(SystemVersion::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('version', __('Version'));
        $show->field('introduction', __('Introduction'));
        $show->field('file_path', __('File path'));
        $show->field('is_show', __('Is show'));
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
        $form = new Form(new SystemVersion);

        $form->text('version', __('发布版本号'))->rules('required',[
            'required'=>'必填'
        ]);
        $form->text('identifier', __('身份标识'))->rules('required',[
            'required'=>'必填'
        ])->help('唯一标识[必填]，格式：system');

        $form->textarea('introduction', __('版本更新内容'))->rules('required',[
            'required'=>'必填'
        ])->help('使用"&&"进行分隔');

        $form->file('file_path', __('上传打包文件'))->rules('required',[
            'required'=>'必填'
        ]);
        $form->switch('is_show', __('是否展示'))->default(0);

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
