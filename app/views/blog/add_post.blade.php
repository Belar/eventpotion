@extends('allround.master')

@section('head_scripts')
<link href="{{{ URL::asset('css/bootstrap-datetimepicker.min.css') }}}" rel="stylesheet">
<link href="{{{ URL::asset('css/summernote.css') }}}" rel="stylesheet">
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div id="reg-login-forms">	
                <h3>Add article</h3>			
                <div class="form-body">
                    {{ Form::open(array('url' => 'blog/add', 'role' => 'form', 'files'=> true)) }}
                    <ul class="errors">
                        @foreach($errors->all() as $message)
                        <li class="text-danger">{{{ $message }}}</li>
                        @endforeach
                    </ul>
                    <div class="form-step">			
                        <div class="form-group">
                            {{ Form::label('title', 'Title') }} <span class="text-danger">*</span>
                            {{ Form::text('title', '', array('class'=>'form-control')) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('image', 'Image') }} <span class="text-danger">*</span>
                            {{ Form::file('image', '', array('class'=>'form-control')) }}
                        </div>
                    </div>	

                    <div class="form-step">		
                        <div class="form-group">
                            {{ Form::label('content', 'Content') }}
                            {{ Form::textarea('content', '', array('id'=>'post_content', 'class'=>'form-control textarea-about')) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('tags', 'Tags') }} 
                            {{ Form::text('tags', '', array('class'=>'form-control')) }}
                            <p><small>Separate tags with commas.</small></p>
                        </div>
                    </div>
                    <div class="checkbox">
                        {{ Form::checkbox('public_state', '1', Input::old('public', true) ) }}   <p>Public <small>(Uncheck to save an event as a draft.)</small>
                    </div>

                    {{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}			
                    {{ Form::close() }}

                </div>
            </div>
        </div>
        <div class="col-md-4">
            @include('generals.event_change_sidebar')
        </div>
    </div>
</div>
</div>
@stop

@section('footer')
<script type="text/javascript" src="{{{ URL::asset('js/bootstrap-datetimepicker-smalot.min.js') }}}"></script>
<script src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script src="{{{ URL::asset('js/jquery-gmaps-latlon-picker.js') }}}"></script>

<script src="{{{ URL::asset('js/summernote.min.js') }}}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.textarea-about').summernote({
            height: 300,
            toolbar: [
                //['style', ['style']], // no style button
                ['style', ['bold', 'italic', 'underline', 'clear']],
                //['fontsize', ['fontsize']],
                //['color', ['color']],
                ['para', ['ul', 'ol']],
                ['height', ['height']],
                ['insert', ['picture', 'link','video']], // no insert buttons
                ['table', ['table']], // no table button
                //['help', ['help']] //no help button
                ['misc', ['fullscreen', 'codeview']]
            ]
        });
    });
</script>		
@stop