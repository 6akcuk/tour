<!-- Title Form Input -->
<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
    {!! Form::label('title', 'Title:', []) !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
    {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
</div>

<!-- Category Form Input -->
<div class="form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
    {!! Form::label('category_id', 'Category:', []) !!}
    {!! Form::select('category_id', $categories, null, ['class' => 'form-control']) !!}
    {!! $errors->first('category_id', '<span class="help-block">:message</span>') !!}
</div>

<!-- Slug Form Input -->
<div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
    {!! Form::label('slug', 'Slug:', []) !!}
    {!! Form::text('slug', null, ['class' => 'form-control']) !!}
    {!! $errors->first('slug', '<span class="help-block">:message</span>') !!}
</div>

<!-- Photo Form Input -->
<div class="form-group {{ $errors->has('photo') ? 'has-error' : '' }}">
    {!! Form::label('photo', 'Photo:', []) !!}
    @if (isset($post))
        <img src="uploads/blogs/{{ $post->photo }}" class="img-responsive">
        <div class="help-block">
            You can change photo by choosing new.
        </div>
    @endif
    {!! Form::file('photo') !!}
    {!! $errors->first('photo', '<span class="help-block">:message</span>') !!}
</div>

<!-- Tags Form Input -->
<div class="form-group {{ $errors->has('tags') ? 'has-error' : '' }}">
    {!! Form::label('tags', 'Tags:', []) !!}
    <div>
        {!! Form::text('tags', isset($post) ? implode(',', $post->tags()->lists('tag')->toArray()) : null, ['class' => 'form-control']) !!}
        {!! $errors->first('tags', '<span class="help-block">:message</span>') !!}
    </div>
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

    <link href="css/bootstrap-tagsinput.css" rel="stylesheet" type="text/css">
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

    <script src="js/bootstrap-tagsinput.min.js"></script>
    <script src="js/typeahead.js"></script>

    <!-- Initialize the editor. -->
    <script>
        $(function() {
            $('#body').editable({
                inlineMode: false,
                imageUpload: false,
                height: 300
            })

            var tags = new Bloodhound({
                local: {!! json_encode($tags) !!},
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                datumTokenizer: Bloodhound.tokenizers.whitespace
            });
            tags.initialize();

            $('#tags').tagsinput({
                typeaheadjs: {
                    name: 'tags',
                    source: tags.ttAdapter()
                }
            });
        });
    </script>
@endsection