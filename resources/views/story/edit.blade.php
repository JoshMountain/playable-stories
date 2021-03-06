@extends('framework')

@section('header-include')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="/css/bootstrap-colorpicker.min.css">
@stop

@section('navbar-right')
    <div id="navbar" class="navbar-collapse collapse">
        <div class="navbar-right">
            <a href="/story/{{ $story->id }}" class="btn btn-sm btn-default navbar-btn" target="_blank">View</a>
            <a href="" class="btn btn-sm btn-primary navbar-btn" id="save-button">Save</a>
        </div>
    </div>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                @include('partials.input-errors')
                @include('flash::message')
                <p class="pull-right">Public Link: <a href="/story/{{ $story->id }}" target="_blank">{{ getenv('APP_URL') }}/story/{{ $story->id }}</a></p>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#builder" aria-controls="builder" role="tab" data-toggle="tab">Builder</a></li>
                    <li role="presentation"><a href="#meters" aria-controls="meters" role="tab" data-toggle="tab">Meters</a></li>
                    <li role="presentation"><a href="#design" aria-controls="design" role="tab" data-toggle="tab">Design</a></li>
                </ul>

                <form method="POST" action="/story/{{ $story->id }}" id="story-builder-form" enctype="multipart/form-data">
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="builder">

                            <div class="form-group">
                                <label for="story-name">Story Name</label>
                                <input type="text" class="form-control" id="story-name" name="story-name" placeholder="Story Name" value="{{ $story->name }}">
                            </div>

                            @if (count($story->introductions()->get()) == 0)
                                <a class="btn btn-default btn-margin-bottom" href="/story/{{ $story->id }}/introduction" role="button"><i class="fa fa-plus"></i> Add Introduction Slide</a>
                            @else
                                @foreach ($story->introductions()->get() as $introduction)
                                    <div class="panel panel-default panel-no-body">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><a href="/story/{{ $story->id }}/introduction/edit">Introduction Slide</a></h3>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <hr />
                            @foreach ($story->slides()->get() as $slide)
                                <div class="panel panel-default panel-no-body">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">
                                            <a href="/slide/{{ $slide->id }}/edit">{{ $slide->name }}</a>
                                            <div class="btn-group pull-right">
                                                <a href="/slide/{{ $slide->id }}/shift/down" class="btn btn-panel-transparent"><i class="fa fa-chevron-up text-valign-center"></i></a>
                                                <a href="/slide/{{ $slide->id }}/shift/up" class="btn btn-panel-transparent"><i class="fa fa-chevron-down text-valign-center"></i></a>
                                                <a href="/slide/{{ $slide->id }}/duplicate" class="btn btn-panel-transparent"><i class="fa fa-files-o text-valign-center"></i></a>
                                                <a href="javascript:deleteSlide('{{ $slide->id }}')" class="btn btn-panel-transparent"><i class="fa fa-times text-valign-center"></i></a>
                                            </div>
                                        </h3>

                                    </div>
                                </div>
                            @endforeach

                            <a class="btn btn-default btn-margin-bottom" href="/story/{{ $story->id }}/slide" role="button"><i class="fa fa-plus"></i> Add New Slide</a>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="meters">
                            <div class="row">
                                <div class="col-xs-12">
                                    <p>Add Up to 2 Meters:<br/>Name your meter, select a meter type, and define the start, min, and max values. The start value is the value of the meter at the begining of the game. The min and max values will trigger messages defined below that will end the game. If there is no min or max value, leave the field blank.</p>
                                    @foreach ($story->meters()->get() as $meter)
                                        <div class="panel panel-default panel-no-body">
                                            <div class="panel-heading">
                                                <h3 class="panel-title"><a href="/meter/{{ $meter->id }}/edit">{{ $meter->name }}</a></h3>
                                            </div>
                                        </div>
                                    @endforeach
                                    @if (count($story->meters()->get()) < 2)
                                        <a class="btn btn-default btn-margin-bottom" href="/slide/{{ $story->id }}/meter" role="button"><i class="fa fa-plus"></i> Add New Meter</a>
                                    @endif
                                    <p>The success message will be displayed once the player finishes the game without exceeding a min or max value defined above.
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Success Message</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class="form-group">
                                                        <label>Header</label>
                                                        <input type="text" class="form-control" name="success-heading" value="{{ $story->success_heading }}" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class="form-group">
                                                        <label>Text</label>
                                                        <textarea class="form-control wysiwyg" rows="3" name="success-content">{!! $story->success_content !!}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="design">
                            <div class="row">
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <label for="background-color">Background Color</label>
                                        <div class="input-group background-color">
                                            <span class="input-group-addon"><i></i></span>
                                            <input type="text" value="{{ $story->background_color }}" class="form-control" name="background-color" id="background-color" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="heading-font">Heading Font</label>
                                        <select class="form-control" name="heading-font" id="heading-font">
                                            @foreach ( $fonts as $key => $value )
                                                @if ( $story->heading_font == $key )
                                                    <option value="{{ $key }}" selected>{{ $key }}</option>
                                                @else
                                                    <option value="{{ $key }}">{{ $key }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="heading-font-color">Heading Font Color</label>
                                        <div class="input-group heading-font-color">
                                            <span class="input-group-addon"><i></i></span>
                                            <input type="text" value="{{ $story->heading_font_color }}" class="form-control" name="heading-font-color" id="heading-font-color" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="body-font">Body Font</label>
                                        <select class="form-control" name="body-font" id="body-font">
                                            @foreach ( $fonts as $key => $value )
                                                @if ( $story->body_font == $key )
                                                    <option value="{{ $key }}" selected>{{ $key }}</option>
                                                @else
                                                    <option value="{{ $key }}">{{ $key }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="body-font-size">Body Font Size</label>
                                        <input type="number" class="form-control" name="body-font-size" id="body-font-size" value="{{ $story->body_font_size }}" min="10" />
                                    </div>

                                    <div class="form-group">
                                        <label for="body-font-color">Body Font Color</label>
                                        <div class="input-group body-font-color">
                                            <span class="input-group-addon"><i></i></span>
                                            <input type="text" value="{{ $story->body_font_color }}" class="form-control" name="body-font-color" id="body-font-color" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="link-color">Link Color</label>
                                        <div class="input-group link-color">
                                            <span class="input-group-addon"><i></i></span>
                                            <input type="text" value="{{ $story->link_color }}" class="form-control" name="link-color" id="link-color" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="button-background-color">Button Color</label>
                                        <div class="input-group button-background-color">
                                            <span class="input-group-addon"><i></i></span>
                                            <input type="text" value="{{ $story->button_background_color }}" class="form-control" name="button-background-color" id="button-background-color" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="button-text-color">Button Text Color</label>
                                        <div class="input-group button-text-color">
                                            <span class="input-group-addon"><i></i></span>
                                            <input type="text" value="{{ $story->button_text_color }}" class="form-control" name="button-text-color" id="button-text-color" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
            </div>
        </div>
    </div>
@stop

@section('footer-include')
    <script src="/js/bootstrap-colorpicker.min.js"></script>
    <script src="//tinymce.cachefly.net/4.2/tinymce.min.js"></script>
    <script>
        $(function(){
            // Initialize ColorPicker
            $('.background-color, .heading-font-color, .body-font-color, .link-color, .button-background-color, .button-text-color').colorpicker({
                align: 'left',
                format: 'hex',
            });

            // Initialize TinyMCE
            tinymce.init({
                selector: '.wysiwyg',
                elementpath: false,
                statusbar: false,
                menubar: false,
                plugins: [
                    "link", "autoresize",
                ],
                toolbar: 'formatselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link',
                fontsize_formats: "8pt 10pt 12pt 14pt 16pt 18pt 21pt 24pt 32pt 36pt",
            });

            // Javascript to enable link to tab
            var hash = document.location.hash;
            var prefix = "tab_";
            if (hash) {
                $('.nav-tabs a[href='+hash.replace(prefix,"")+']').tab('show');
            }

            // Change hash for page-reload
            $('.nav-tabs a').on('shown.bs.tab', function (e) {
                window.location.hash = e.target.hash.replace("#", "#" + prefix);
            });
        });

        // Submit for when clicking 'Save' button
        $( "#save-button" ).click(function(event) {
            event.preventDefault();
            $( "#story-builder-form" ).submit();
        });

        function deleteSlide(id) {
            if (confirm('Delete this slide?')) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "DELETE",
                    url: '/slide/' + id,
                    success: function(affectedRows) {
                        if (affectedRows > 0) location.reload();
                    }
                });
            }
        }
    </script>
@stop