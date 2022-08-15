@extends('layouts.app')

@section('content')
<div class="">

            <div class="row">

              <div class="col-md-6 col-sm-12 col-xs-12">

                <div class="x_panel">

                <div class="x_title">
                  <h3>{{ $c->name }} {{ $c->middle_name }} {{ $c->last_name }}
                  &nbsp;&nbsp;&nbsp;&nbsp;
                  <a href=' {{ url("/customers/$c->customer_id/edit") }} ' class="btn btn-success">UPDATE</a>
                  <a href=' {{ url("/customers") }} ' class="btn btn-info">View All</a>
                  </h3>                    
                </div>

                  <div class="x_content">
                    <table class="table table-striped table-bordered dataTable no-footer">
                      <tr>
                        <td>ID</td>
                        <td><b>{{ $c->customer_id }}</b></td>
                      </tr>

                      <tr>
                        <td>Name</td>
                        <td><b>{{ $c->name }} {{ $c->middle_name }} {{ $c->last_name }}</b></td>
                      </tr>

                      <tr>
                        <td>Business Name</td>
                        <td><b>{{ $c->business_name }}</b></td>
                      </tr>

                      <tr>
                        <td>Address</td>
                        <td><b>{{ $c->customer_add }}</b></td>
                      </tr>

                      <tr>
                        <td>City </td>
                        <td><b>{{ $c->city}}</b></td>
                      </tr>

                      <tr>
                        <td>Post Code </td>
                        <td><b>{{ $c->postcode }}</b></td>
                      </tr>

                      <tr>
                        <td>Mobile No</td>
                        <td><b>{{ $c->mob_no}}</b></td>
                      </tr>

                      <tr>
                        <td>Office No </td>
                        <td><b>{{ $c->office_no}}</b></td>
                      </tr>

                      <tr>
                        <td>Email</td>
                        <td><b>{{ $c->email}}</b></td>
                      </tr>

                    </table>
                  </div>
                </div>
                </div>

              </div>

            </div>         
@endsection
