{{--  @extends('admin.main')  --}}

@php
    use App\Helpers\template as Template;
    use App\Helpers\Form as FormTemplate;
    use Illuminate\Support\Facades\Config;

    $nameVi           = (isset($item['name'])) ? $item->name : '';
    $descriptionVi    = (isset($item['description'])) ? $item->description : '';

    $formlabelAttr    = Config::get('zvn.template.form_label');
    $formInputAttr    = Config::get('zvn.template.form_input');

    // Chuyển đổi cú pháp Form:: sang html()->
    $elements = [
        [
            'label'   => html()->label('Tên', 'name-vi')->attributes($formlabelAttr),
            'element' => html()->text('name-vi', $nameVi)->attributes($formInputAttr)
        ],
        [
            'label'   => html()->label('Miêu tả', 'description-vi')->attributes($formlabelAttr),
            'element' => html()->text('description-vi', $descriptionVi)->attributes($formInputAttr)
        ]
    ];

@endphp

<div class="tab-pane fade show active in" id="form-vi" role="tabpanel" aria-labelledby="home-tab">
    <div class="x_content" style="display: block;">
            {!! FormTemplate::show($elements) !!}
    </div>
</div>

        {{-- {{ html()->form('POST', route($controllerName.'/save'))
            ->attribute('accept-charset', 'UTF-8')
            ->attribute('enctype', 'multipart/form-data')
            ->class('form-horizontal form-label-left')
            ->id('main-form')
            ->open() }}

            {!! FormTemplate::show($elements) !!}

        {{ html()->form()->close() }} --}}
