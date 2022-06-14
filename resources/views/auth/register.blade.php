@extends('layouts.app')

@section('content')
<style>
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        margin: 0;
    }

</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card shadow-lg">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h4>Registration From</h4>
                        </div>

                        <div class="col text-right">
                            <a href="/auth/google/redirect" class="btn btn-dark font-weight-bold">
                                <img src="/media/icons/icons8-google-24.png" /> Signup with Google
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="card-title h5 ">Basic Details</div>
                    <hr>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-row">
                            <div class="col-12 col-md-6">
                                <label class="font-weight-bold" for="first_name">First Name</label>
                                <input type="text" class="form-control" name="first_name" id="first_name" value="{{old('first_name' ?? null)}}" placeholder="First Name">
                                <div class="text-danger">{{ $errors->first('first_name') }}</div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="font-weight-bold" for="last_name">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" value="{{old('last_name' ?? null)}}" placeholder="Last Name">
                                <div class="text-danger">{{ $errors->first('last_name') }}</div>
                            </div>
                        </div>

                        <div class="form-row mt-2">
                            <div class="col-12 col-md-6">
                                <label class="font-weight-bold" for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email" value="{{old('email' ?? null)}}" placeholder="Email">
                                <div class="text-danger">{{ $errors->first('email') }}</div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="font-weight-bold" for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                <div class="text-danger">{{ $errors->first('password') }}</div>
                            </div>
                        </div>

                        <div class="form-row mt-2">
                            <div class="col-12 col-md-6">
                                <label class="font-weight-bold" for="dob">Date Of Birth</label>
                                <input type="date" class="form-control" id="dob" name="dob" value="{{old('dob') ?? null}}" placeholder="DOB">
                                <div class="text-danger">{{ $errors->first('dob') }}</div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="font-weight-bold" for="gender_id">Gender</label>
                                @foreach($genders as $gender)
                                <div class="form-check">
                                    <input class="form-check-input @error('gender_id') is-invalid @enderror" type="radio" name="gender_id" value="{{$gender->id}}" {{(old('gender_id') == $gender->id ) ? "checked" : null }}>
                                    <label class="form-check-label" for="gender_id">
                                        {{$gender->name}}
                                    </label>
                                </div>
                                @endforeach
                                <div class="text-danger">{{ $errors->first('gender_id') }}</div>

                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-12 col-md-6">
                                <label class="font-weight-bold" for="annual_income">Annual Income</label>
                                <input type="number" class="form-control" id="annual_income" name="annual_income" placeholder="Annual Income">
                                <div class="text-danger">{{ $errors->first('annual_income') }}</div>

                            </div>
                            <div class="col-12 col-md-6">
                                <label class="font-weight-bold" for="occupation_id">Occupation</label>
                                <select class="form-control {{ $errors->has('occupation_id') ? 'is-invalid' : '' }} form-control-solid" name="occupation_id" required="required">
                                    <option value="">Select</option>
                                    @foreach ($occupations as $occupation)
                                    <option value="{{ $occupation->id }}" {{(old('occupation_id') ==  $occupation->id) ? 'selected' : "" }}>
                                        {{ $occupation->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">{{ $errors->first('occupation_id') }}</div>
                            </div>
                        </div>

                        <div class="form-row mt-2">
                            <div class="col-12 col-md-6">
                                <label class="font-weight-bold" for="family_type_id">Family Type</label>
                                <select class="form-control {{ $errors->has('family_type_id') ? 'is-invalid' : '' }} form-control-solid" name="family_type_id" required="required">
                                    <option value="">Select</option>
                                    @foreach ($family_types as $family_type)
                                    <option value="{{ $family_type->id }}" {{(old('family_type_id') ==  $family_type->id) ? 'selected' : "" }}>
                                        {{ $family_type->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">{{ $errors->first('family_type_id') }}</div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="font-weight-bold" for="manglik">Manglik</label>
                                <select class="form-control {{ $errors->has('manglik') ? 'is-invalid' : '' }} form-control-solid" name="manglik" required="required">
                                    <option value="">Select </option>
                                    <option value="Yes" {{old('manglik') == 'Yes' ? 'selected' : null}}>Yes</option>
                                    <option value="No" {{old('manglik') == 'No' ? 'selected' : null}}>No</option>
                                </select>
                                <div class="text-danger">{{ $errors->first('manglik') }}</div>
                            </div>
                        </div>
                        <div class="card-title mt-5 h5">Partner Preference Details</div>
                        <hr>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <label for="amount">Annual Income:</label>
                                <input type="text" id="amount" name="annual_income_range" style="border:0; font-weight:bold;">
                                <div class="mt-3" id="slider-range"></div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group"> <label class="font-weight-bold">Occupation</label>
                                    <select name="occupations[]" class="form-control select2 select2-hidden-accessible" multiple="" data-placeholder="Select" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                        @foreach ($occupations as $occupation)
                                        <option value="{{$occupation->id}}">{{$occupation->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group"> <label class="font-weight-bold">Family Type</label>
                                    <select name="family_types[]" class="form-control select2 select2-hidden-accessible" multiple="" data-placeholder="Select" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                        @foreach ($family_types as $family_type)
                                        <option value="{{$family_type->id}}">{{$family_type->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="font-weight-bold" for="manglik_preference">Manglik</label>
                                <select class="form-control {{ $errors->has('manglik_preference') ? 'is-invalid' : '' }} form-control-solid" name="manglik_preference" required="required">
                                    <option value="">Select </option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                    <option value="Both">Both</option>
                                </select>
                                <div class="invalid-feedback">{{ $errors->first('manglik_preference') }}</div>
                            </div>
                        </div>

                        <div class="row">
                            <button type="submit" class="btn btn-primary mx-auto mt-2">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            closeOnSelect: false
        });
    });

</script>
<script>
    $(function() {
        console.log(123);
        $("#slider-range").slider({
            range: true
            , min: 100000
            , max: 2000000
            , values: [100000, 2000000]
            , slide: function(event, ui) {
                $("#amount").val(ui.values[0] + " - " + ui.values[1]);
            }
        });
        $("#amount").val("₹" + $("#slider-range").slider("values", 0) +
            " - ₹" + $("#slider-range").slider("values", 1));
    });

</script>
@stop
