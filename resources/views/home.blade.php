@extends('layouts.app')

@section('content')
<style>
    .card{
        margin-top: 20px
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
                <div class="card">
                    <div class="card-header bg-dark text-white h4">
                        {{$user->first_name.' '.$user->last_name}}
                    </div>
                    <div class="card-body">
                        <div class="card-title font-weight-bolder">
                           Basic Details
                        </div>
                        <div class="row">
                         <div class="col-12 col-md-6">
                            <div class="row">
                                <div class="font-weight-bold col-6 col-md-5">
                                    Gender     
                                </div>
                                <div class="col-6">
                                    {{$user->gender->name ?? null}}
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="row">
                                <div class="font-weight-bold col-6 col-md-5">
                                    Date Of Birth     
                                </div>
                                <div class="col-6">
                                    {{$user->dob ?? null}} ({{ Carbon\Carbon::parse($user->dob)->diffInYears() }} Years)
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="row">
                                    <div class="font-weight-bold col-6 col-md-5">
                                        Occupation    
                                    </div>
                                    <div class="col-6">
                                        {{$user->occupation->name ?? null}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="row">
                                    <div class="font-weight-bold col-6 col-md-5">
                                        Family Type     
                                    </div>
                                    <div class="col-6">
                                        {{$user->family_type->name ?? null}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="row">
                                    <div class="font-weight-bold col-6 col-md-5">
                                        Annual Income     
                                    </div>
                                    <div class="col-6">
                                        {{$user->annual_income }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="row">
                                    <div class="font-weight-bold col-6 col-md-5">
                                        Manglik     
                                    </div>
                                    <div class="col-6">
                                        {{$user->manglik}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="card-title font-weight-bolder">
                            Partner Preference Details
                         </div>
                         <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="row">
                                    <div class="font-weight-bold col-6 col-md-5">
                                        Occupation     
                                    </div>
                                    <div class="col-6">
                                        {{$partner_preference->occupations}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="row">
                                    <div class="font-weight-bold col-6 col-md-5">
                                        Family Type     
                                    </div>
                                    <div class="col-6">
                                        {{$partner_preference->family_types}}
                                    </div>
                                </div>
                            </div>
                        </div>
                         <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="row">
                                    <div class="font-weight-bold col-6 col-md-5">
                                        Annual Income     
                                    </div>
                                    <div class="col-6">
                                        {{$partner_preference->annual_income_minimum." - ". $partner_preference->annual_income_maximum}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="row">
                                    <div class="font-weight-bold col-6 col-md-5">
                                        Manglik     
                                    </div>
                                    <div class="col-6">
                                        {{$partner_preference->manglik}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="container mt-10">
            <div class="row p-10 justify-content-center">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header h4">
                            My Matches
                        </div>
                        <div class="card-body row justify-content-center">
                            <div class="col-xl-8 col-md-12 col-12">

                                @foreach($my_matches as $prospect)
                                    <div class="card">
                                        <div class="card-header font-weight-bold bg-primary text-white">
                                            {{$prospect->first_name." ".$prospect->last_name}}
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                            
                                                <div class="col-xl-4 col-md-12 text-center mb-5 mb-md-0 col-12">
                                                    @php 
                                                    $src = $prospect->gender_id == 1 ? '/media/users/male.png' : '/media/users/female.png';
                                                    @endphp
                                                    <img src="{{$src}}" alt="img" style="height: 175px;width:175px">
                                                </div>

                                                <div class="col-md-12 col-xl-8  mt-xl-0 col-12">
                                                    <div class="row">
                                                        <div class="col-12 mt-1">
                                                            <div class="row">
                                                                <div class="col-6 font-weight-bold">
                                                                    Gender 
                                                                </div>
                                                                <div class="col-6">
                                                                    {{$prospect->gender->name}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mt-1">
                                                            <div class="row">
                                                                <div class="col-6 font-weight-bold">
                                                                    Age 
                                                                </div>
                                                                <div class="col-6">
                                                                    {{ Carbon\Carbon::parse($prospect->dob)->diffInYears() }} Years
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mt-1">
                                                            <div class="row">
                                                                <div class="col-6 font-weight-bold">
                                                                    Occupation 
                                                                </div>
                                                                <div class="col-6">
                                                                    {{$prospect->occupation->name}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mt-1">
                                                            <div class="row">
                                                                <div class="col-6 font-weight-bold">
                                                                    Family Type 
                                                                </div>
                                                                <div class="col-6">
                                                                    {{$prospect->family_type->name}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mt-1">
                                                            <div class="row">
                                                                <div class="col-6 font-weight-bold">
                                                                    Manglik
                                                                </div>
                                                                <div class="col-6">
                                                                    {{$prospect->manglik}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mt-1">
                                                            <div class="row">
                                                                <div class="col-6 font-weight-bold">
                                                                    Matching Score
                                                                </div>
                                                                <div class="col-6">
                                                                    {{$prospect->score}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
 
@endsection
