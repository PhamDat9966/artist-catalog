{{--  @extends('admin.main')  --}}

@php
    use App\Helpers\template as Template;
    use App\Helpers\Form as FormTemplate;
    //dd($itemEn->toArray());

    $request = Request::capture();
    global $host;
    $host = $request->getHost();
    $host = 'http://'.$host;

    $nameEn           = (isset($itemEn['name']))? $itemEn->name : '';
    $descriptionEn    = (isset($itemEn['description']))? $itemEn->description : '';

    $formlabelAttr     = Config::get('zvn.template.form_label');
    $formInputAttr     = Config::get('zvn.template.form_input');

    // $elements   = [
    //     [
    //         'label'     =>  Form::label('name', 'Name', $formlabelAttr),
    //         'element'   =>  Form::text('name-en', $nameEn,   $formInputAttr)
    //     ],
    //     [
    //         'label'     =>  Form::label('description', 'Description',$formlabelAttr),
    //         'element'   =>  Form::text('description-en', $descriptionEn ,  $formInputAttr)
    //     ]
    // ];

    $elements   = [
        [
            'label'     =>  html()->label('name', 'Name')->attributes($formlabelAttr),
            'element'   =>  html()->text('name-en', $nameEn)->attributes($formInputAttr)
        ],
        [
            'label'     =>  html()->label('description', 'Description')->attributes($formlabelAttr),
            'element'   =>  html()->text('description-en', $descriptionEn)->attributes($formInputAttr)
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

{{-- <div class="tab-pane fade show active in" id="form-en" role="tabpanel" aria-labelledby="home-tab">
    <!-- x Content -->
    <div class="x_content" style="display: block;">
        {!! Form::open([
                'url'               =>  Route($controllerName.'/save'),
                'method'            =>  'POST',
                'accept-charset'    =>  'UTF-8',
                'enctype'           =>  'multipart/form-data',
                'class'             =>  'form-horizontal form-label-left',
                'id'                =>  'main-form'
            ]) !!}

            {!! FormTemplate::show($elements)!!}
        {!! Form::close() !!}
    </div>
</div> --}}

