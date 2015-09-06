@extends('layouts.main')

@section('header', 'Contact Us')

@section('content')
    <div class="row">
        @if (Session::has('flash_notification.message'))
            <div class="alert alert-{{ Session::get('flash_notification.level') }}">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                {{ Session::get('flash_notification.message') }}
            </div>
        @endif

        <div class="form_title">
            <h3><strong><i class="icon-pencil"></i></strong>Fill the form below</h3>
            <p>
                Mussum ipsum cacilds, vidis litro abertis.
            </p>
        </div>
        <div class="step">

            <div id="message-contact">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            {!! Form::open(['url' => '/contact-us']) !!}
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label>First Name</label>
                            {!! Form::text('firstname', null, ['placeholder' => 'Enter Name', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label>Last Name</label>
                            {!! Form::text('lastname', null, ['placeholder' => 'Enter Last Name', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <!-- End row -->
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label>Email</label>
                            {!! Form::email('email', null, ['placeholder' => 'Enter Email', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label>Phone</label>
                            {!! Form::text('phone', null, ['placeholder' => 'Enter Phone number', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Message</label>
                            {!! Form::textarea('message', null, ['placeholder' => 'Write your message', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label>Human verification</label>
                        <input type="text" id="verify" name="verify" class="form-control add_bottom_30" placeholder="Are you human? 3 + 1 =">
                        <input type="submit" value="Submit" class="btn_1" id="submit-contact">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection