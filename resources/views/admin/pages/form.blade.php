<!-- Title Form Input -->
<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
    {!! Form::label('title', 'Title:', []) !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
    {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
</div>

<!-- Slug Form Input -->
<div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
    {!! Form::label('slug', 'Slug:', []) !!}
    {!! Form::text('slug', null, ['class' => 'form-control']) !!}
    {!! $errors->first('slug', '<span class="help-block">:message</span>') !!}
</div>

<!-- Body Form Input -->
<div class="form-group {{ $errors->has('body') ? 'has-error' : '' }}">
    {!! Form::label('body', 'Body:', []) !!}
    {!! Form::textarea('body', null, ['class' => 'form-control']) !!}
    {!! $errors->first('body', '<span class="help-block">:message</span>') !!}
</div>

@section('header_css')
        <!-- Include Font Awesome. -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css">

<!-- Include Editor style. -->
<link href="css/froala_editor.min.css" rel="stylesheet" type="text/css">
<link href="css/froala_style.min.css" rel="stylesheet" type="text/css">
@endsection

@section('footer_javascript')
    @parent
    <script src="js/jquery.slugify.js"></script>
    <script>
        $('#slug').slugify('#title');
    </script>

    <!-- Include JS files. -->
    <script src="js/froala_editor.min.js"></script>

    <!-- Include IE8 JS. -->
    <!--[if lt IE 9]>
    <script src="js/froala_editor_ie8.min.js"></script>
    <![endif]-->
    <script src="js/plugins/tables.min.js"></script>
    <script src="js/plugins/lists.min.js"></script>
    <script src="js/plugins/colors.min.js"></script>
    <script src="js/plugins/media_manager.min.js"></script>
    <script src="js/plugins/font_family.min.js"></script>
    <script src="js/plugins/font_size.min.js"></script>
    <script src="js/plugins/block_styles.min.js"></script>
    <script src="js/plugins/video.min.js"></script>

    <!-- Initialize the editor. -->
    <script>
        $(function() {
            $('#body').editable({
                inlineMode: false,
                imageUploadURL: '{{ route('admin.pages.upload') }}',
                imageUploadParams: {
                    _token: '{{ csrf_token() }}'
                },
                height: 300
            })
        });
    </script>
@endsection