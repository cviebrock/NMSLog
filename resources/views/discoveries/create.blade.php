@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1>Add a New Star System</h1>
            </div>
        </div>

        <form role="form" method="POST" action="{{ route('discoveries.store') }}">
            {{ csrf_field() }}

            <div class="row">
                <div class="col-xs-12">

                    <div class="form-group required{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name">Name</label>
                        <input id="name" type="text" class="form-control" name="name"
                               value="{{ old('name') }}"
                               required autofocus/>
                        @if ($errors->has('name'))
                            <div class="help-block">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group required{{ $errors->has('class') ? ' has-error' : '' }}">
                        <label for="class">Star Class</label>
                        <input id="class" type="text" class="form-control" name="class"
                               value="{{ old('class') }}"
                               placeholder="e.g. F0p; X if black hole/atlas/unknown"
                               required
                        />
                        @if ($errors->has('class'))
                            <div class="help-block">
                                {{ $errors->first('class') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group required{{ $errors->has('coordinates') ? ' has-error' : '' }}">
                        <label for="coordinates">Coordinates</label>
                        <input id="coordinates" type="text" class="form-control" name="coordinates"
                               value="{{ old('coordinates') }}"
                               placeholder="ALPHA:0000:0000:0000:0000"
                               required/>
                        @if ($errors->has('coordinates'))
                            <div class="help-block">
                                {{ $errors->first('coordinates') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('planets') ? ' has-error' : '' }}">
                        <label for="planets">Number of Planets</label>
                        <input id="planets" type="number" class="form-control" name="planets"
                               min="0"
                               value="{{ old('planets') }}"/>
                        @if ($errors->has('planets'))
                            <div class="help-block">
                                {{ $errors->first('planets') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('moons') ? ' has-error' : '' }}">
                        <label for="moons">Number of Moons</label>
                        <input id="moons" type="number" class="form-control" name="moons"
                               min="0"
                               value="{{ old('moons') }}"/>
                        @if ($errors->has('moons'))
                            <div class="help-block">
                                {{ $errors->first('moons') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('black_hole') ? ' has-error' : '' }}">
                        <label>Black Hole?</label>
                        <div>
                            <label class="radio-inline">
                                <input type="radio" name="black_hole" id="black_hole_0"
                                       value="0"
                                  {{ old('black_hole') ? '' : 'checked' }}
                                /> No
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="black_hole" id="black_hole_1"
                                       value="1"
                                  {{ old('black_hole') ? 'checked' : '' }}
                                /> Yes
                            </label>
                        </div>
                        @if ($errors->has('black_hole'))
                            <div class="help-block">
                                {{ $errors->first('black_hole') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('atlas_interface') ? ' has-error' : '' }}">
                        <label>Atlas Interface?</label>
                        <div>
                            <label class="radio-inline">
                                <input type="radio" name="atlas_interface" id="atlas_interface_0"
                                       value="0"
                                  {{ old('atlas_interface') ? '' : 'checked' }}
                                /> No
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="atlas_interface" id="atlas_interface_1"
                                       value="1"
                                  {{ old('atlas_interface') ? 'checked' : '' }}
                                /> Yes
                            </label>
                        </div>
                        @if ($errors->has('atlas_interface'))
                            <div class="help-block">
                                {{ $errors->first('atlas_interface') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('notes') ? ' has-error' : '' }}">
                        <label for="notes">Notes</label>
                        <textarea id="notes" type="text" class="form-control" name="notes">{{ old('notes') }}</textarea>
                    </div>

                    <div class="form-group required{{ $errors->has('discovered_on') ? ' has-error' : '' }}">
                        <label for="discovered_on">Discovered On</label>
                        <input id="discovered_on" type="datetime" class="form-control" name="discovered_on"
                               value="{{ old('discovered_on') ?: $currentTime->format('Y-m-d H:i') }}"
                               placeholder="YYYY-MM-DD HH:MM"
                               required
                        />
                        @if ($errors->has('discovered_on'))
                            <div class="help-block">
                                {{ $errors->first('discovered_on') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
