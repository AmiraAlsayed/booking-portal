@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="/booking">
                            {{ csrf_field() }}
                            @if(session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif
                            @if(session()->has('error'))
                                <div class="alert alert-danger">
                                    {{ session()->get('error') }}
                                </div>
                            @endif
                            @if(isset($name))
                                <div class="form-group">
                                    <label for="name" class="col-md-4 control-label">{{ __('Name') }}</label>
                                    <div class="col-md-6">
                                        <input id="name" type="text" placeholder="John Doe" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $name) }}" required autocomplete="name" autofocus>
                                        @if ($errors->has('name'))
                                            <span class="text-danger">
                                        <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="form-group">
                                    <label for="name" class="col-md-4 control-label">{{ __('Name') }}</label>
                                    <div class="col-md-6">
                                        <input id="name" type="text" placeholder="John Doe" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                        @if ($errors->has('name'))
                                            <span class="text-danger">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            @if(isset($email))
                                <div class="form-group">
                                    <label for="email" class="col-md-4 control-label">{{ __('Email') }}</label>
                                    <div class="col-md-6">
                                        <input id="email" type="text" placeholder="example@domian.com" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $description) }}" required autocomplete="email" autofocus>
                                        @if ($errors->has('email'))
                                            <span class="text-danger">
                                        <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="form-group">
                                    <label for="email" class="col-md-4 control-label">{{ __('Email') }}</label>
                                    <div class="col-md-6">
                                        <input id="email" type="text" placeholder="example@domian.com" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        @if ($errors->has('email'))
                                            <span class="text-danger">
                                        <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            @if(isset($phone))
                                <div class="form-group">
                                    <label for="phone_number" class="col-md-4 control-label">{{ __('Phone') }}</label>
                                    <div class="col-md-6">
                                        <input id="number" type="tel" placeholder="123 456 789" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number', $phone) }}" required autocomplete="phone_number" autofocus>
                                        @if ($errors->has('phone_number'))
                                            <span class="text-danger">
                                            <strong>{{ $errors->first('phone_number') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="form-group">
                                    <label for="phone_number" class="col-md-4 control-label">{{ __('Phone') }}</label>
                                    <div class="col-md-6">
                                        <input id="number" type="tel" placeholder="123 456 789" class="form-control @error('phone') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}" required autocomplete="phone_number" autofocus>
                                        @if ($errors->has('phone_number'))
                                            <span class="text-danger">
                                            <strong>{{ $errors->first('phone_number') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            <div class="form-group">
                            <label for="ticket" class="col-md-4 control-label">{{ __('Tickets Categories') }}</label>
                            @if(isset($availableTickets) && $availableTickets != [])
                                <div class="col-md-6">
                                    @foreach($availableTickets as $id => $ticketData)
                                        <div class="container checkboxes">
                                        <label class="checkbox-inline">
                                        @if($ticketData[1] < 200)
                                            <input type="checkbox" name="ticket[{{$id}}]" value="{{$ticketData[0]}}"/>{{$ticketData[0] }}</label>
                                        @else
                                            <input type="checkbox" name="ticket[{{$id}}]" value="{{$ticketData[0]}}" disabled/>{{$ticketData[0] }}
                                                </label>
                                        @endif
                                        </div>
                                    @endforeach
                                    @if ($errors->has("ticket"))
                                        <p class="text-danger">
                                          <strong>{{ $errors->first("ticket") }}</strong>
                                        </p>
                                    @endif
                                </div>
                            @else
                                <div class="col-md-6 panel-body list-group list-group-contacts second">
                                    <h6 class="four-o-four " style="padding-top: 10px;">No tickets found in the system.</h6>
                                </div>
                            @endif
                            </div>
                            <div class="form-group">
                                <div class="col-md-4 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary pull-right">
                                        {{ __('Book your ticket') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection