@extends('layouts.app')

@section('content')
<div class="card shadow-lg">
    <div class="card-header text-white bg-dark">
      <div class="row justify-content-between">
        <div class="col-12 col-md-6 text-center text-md-left">
          <h3>Users List</h3>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="row bg-white text-white">
        <div class="col">
          {{-- filters begin --}}
          <form id="user_list" action="{{ route('users.report') }}" method="GET">
            <div class="row justify-content-start">
                <div class="form-group col-12 col-md-2">
                    <label for="gender_id" class="h5 font-weight-bold text-dark">Gender</label>
                    <select name="gender_id" id="gender_id" class="form-control">
                      <option value="" >All</option>
                      @foreach($genders as $gender)
                      <option value="{{$gender->id}}" {{isset($query['gender_id']) ? ($query['gender_id'] == $gender->id ? 'selected' : null) : null}}>{{$gender->name}}</option>
                      @endforeach
                    </select>
                  </div>
              <div class="form-group col-12 col-md-2">
                <label for="occupation_id" class="h5 font-weight-bold text-dark">Occupation</label>
                <select name="occupation_id" id="occupation_id" class="form-control">
                  <option value="" selected>All</option>
                  @foreach($occupations as $occupation)
                  <option value="{{$occupation->id}}" {{isset($query['occupation_id']) ? ($query['occupation_id'] == $occupation->id ? 'selected' : null) : null}}>{{$occupation->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group col-12 col-md-2">
                <label for="family_type_id" class="h5 font-weight-bold text-dark">Family Type</label>
                <select name="family_type_id" id="family_type_id" class="form-control">
                  <option value="" >All</option>
                  @foreach($family_types as $family_type)
                  <option value="{{$family_type->id}}" {{isset($query['family_type_id']) ? ($query['family_type_id'] == $family_type->id ? 'selected' : null) : null}}>{{$family_type->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group col-12 col-md-2">
                <label for="manglik" class="h5 font-weight-bold text-dark">Manglik</label>
                <select name="manglik" id="manglik" class="form-control">
                  <option value="" >Both</option>
                  <option value="Yes" {{isset($query['manglik']) ? ($query['manglik'] == "Yes" ? 'selected' : null) : null}}>Yes</option>
                  <option value="No" {{isset($query['manglik']) ? ($query['manglik'] == "No" ? 'selected' : null) : null}}>No</option>
                </select>
              </div>

              <div class="col-12 mt-10">
                  <div class="row mt-10">
                      <div class="form-group col-6 col-md-2">
                        <label for="manglik" class="h5 font-weight-bold text-dark">Age</label>
                        <input required type="text" name="age_range" id="age_range"
                            style="border:0; font-weight:bold;">
                            <div id="age-slider-range"></div>
                        </div>
                        <div class="form-group col-6 col-md-2">
                        <label for="annual_income_range" class="h5 font-weight-bold text-dark">Annual Income ₹ </label>
                            <input  type="text" name="annual_income_range"
                                id="annual_income_range" style="border:0; font-weight:bold;"
                                class=" @error('annual_income_range') is-invalid @enderror">
                            <div id="slider-range"></div>
                        </div>
                        <div class="col-6  d-flex align-items-center">
                            <div class="row ">
                                <div class="mr-2">
                                    <button class="btn btn-primary mr-10">Sumbit</button>
                                </div>
                                <div class="">
                                    <a href="{{ route('users.report') }}" class="btn btn-primary">reset</a>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
              </div>

            
        </div>   
          </form>
          {{-- filters end --}}
        </div>
      </div>
      </div>
    </div>
  
    <div class="card shadow-lg mt-5">
      <div class="card-header text-white">
        <div class="row justify-content-between">
          <div class="col-12 col-md-6 text-dark font-weight-bold">
            {{-- <h3>{{ 'There are ' .$total.' Plan page views from ' .Carbon\Carbon::parse($query['from_date'])->format('d-m-Y'). ((isset($query['to_date'])) ? " to " .Carbon\Carbon::parse($query['to_date'])->format('d-m-Y') : null)}} </h3> --}}
          </div>
         
        </div>
      </div>
    <div class="card-body">
      <div class="table-responsive-sm">
        <table class="table table-hover table-bordered bg-white text-center">
          <thead class="bg-success text-dark">
            <tr>
              <td>#</td>
              <td>Name</td>
              <td>Email</td>
              <td>Gender</td>
              <td>Age</td>
              <td>Manglik</td>
              <td>Annual income</td>
              <td>Family Type</td>
              <td>Occupation</td>
            </tr>
            </thead>
          <tbody>
            @if(sizeOf($users) > 0)
            @foreach ($users as $user)
            <tr>
              <td>{{$loop->iteration}}</td>
              <td>{{$user->first_name.'  '.$user->last_name}}</td>
              <td>{{$user->email}}</td>
              <td>{{$user->gender}}</td>
              <td>{{($user->dob != null) ? Carbon\Carbon::parse($user->dob)->diffForHumans() : null}}</td>
              <td>{{$user->manglik}}</td>
              <td>{{$user->annual_income}}</td>
              <td>{{$user->family_type}}</td>
              <td>{{$user->occupation}}</td>
            </tr>      
            @endforeach
            @else
            <tr class="text-center" style="font-size:16px">
              <td colspan="12">
                No results
              </td>
            </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>
  </div>

@endsection
@section('scripts')
<script>
    $(function() {
        [from, to] = "{{ $query['age_range'] ?? '18-60' }}".split('-')
        $("#age-slider-range").slider({
            range: true,
            min: 18,
            max: 60,
            values: [from, to],
            slide: function(event, ui) {
                $("#age_range").val(ui.values[0] + " - " + ui.values[1]);
            }
        });
        $("#age_range").val($("#age-slider-range").slider("values", 0) +
            " - " + $("#age-slider-range").slider("values", 1));
    });
</script>
<script>
    $(function() {
        [from, to] = "{{ $query['annual_income_range'] ?? '100000-2000000' }}".split('-')
        $("#slider-range").slider({
            range: true,
            min: 100000,
            max: 2000000,
            values: [from, to],
            slide: function(event, ui) {
                $("#annual_income_range").val(ui.values[0] + " - " + ui.values[1]);
            }
        });
        $("#annual_income_range").val($("#slider-range").slider("values", 0) +
            " - " + $("#slider-range").slider("values", 1));
    });
</script>

@endsection