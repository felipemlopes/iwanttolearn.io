<div class="form-group">
    {!! Form::label('name', 'Name', ['class'=>'control-label']) !!}
    {!! Form::text('name', null, ['class'=>'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('slug', 'Slug', ['class'=>'control-label']) !!}
    {!! Form::text('slug', null, ['class'=>'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('description', 'Description', ['class'=>'control-label']) !!}
    {!! Form::textarea('description', null, ['class'=>'form-control']) !!}
</div>

@include('admin/parts/tag-selection', ['label' => 'Related Tags'])

<div class="clearfix"></div>

<div class="form-group">
    <button class="btn btn-success" type="submit"><i class="fa fa-save"></i> Save</button>
</div>

<script>
    $(document).ready(function() {
        var slug = $('input[name="slug"]').first();
        $('input[name="name"]').change(function() {
            if(slug.val() === '') {
                var name = $(this).val();
                slug.val(name.replace(/ /g, '-').toLowerCase())
            }
        });
    });
</script>

@include('admin/parts/errors')