<?php

namespace App\Admin\Controllers;

use App\Models\Module;
use App\Models\ModuleVersion;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ModuleVersionController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '模块版本发布';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ModuleVersion);


        $grid->module()->module_name('模块名称');
        $grid->column('version', '版本号');
        $grid->column('is_show', '是否展示')->switch();
        $grid->column('identifier', '身份id');

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
        $show = new Show(ModuleVersion::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('module_id', __('Module id'));
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
        $form = new Form(new ModuleVersion);

        $form->select('module_id', '模块名称')->options(Module::where('is_show',1)->get()->pluck('module_name','id'))->rules('required',[
            'required'=>'必填'
        ]);
        $form->text('version', '发布版本号')->rules('required',[
            'required'=>'必填'
        ]);
        $form->text('frame_version', '需要框架版本号')->rules('required',[
            'required'=>'必填'
        ]);
        $form->text('identifier','身份id')->rules('required',[
            'required'=>'必填'
        ])->help('请按照规则填写');

        $form->textarea('introduction', '版本更新内容')->rules('required',[
            'required'=>'必填'
        ]);
        $form->file('file_path', '上传打包文件')->rules('required',[
            'required'=>'必填'
        ]);
        $form->switch('is_show', '是否展示')->default(0);



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
