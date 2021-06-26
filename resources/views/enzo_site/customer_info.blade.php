@extends('enzo_site.layout')

@section('content')

<!-- banner -->
<div class="" id="">
    <div class="container">

    </div>
</div>
<!-- //banner -->

<!-- mail -->
<div class="mail">
    <div class="container">
        <h3>My Profile</h3>
        <div class="agile_mail_grids">

            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('message') }}</p>
            @endif

            <form action="{{ route('customer.update', $customer_info->id) }}" method="post">

                @method('PATCH')
                {{ csrf_field() }}

                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th class="text-right">Nick Name <span style="color: red">*</span></th>
                                <td>
                                    <input type="text" class="form-control" name="nick_name" value="{{ $customer_info->nick_name }}" placeholder="Your Nick Name" required="required">
                                </td>
                            </tr>
                            <tr>
                                <th class="text-right">Full Name <span style="color: red">*</span></th>
                                <td>
                                    <input type="text" class="form-control" name="full_name" value="{{ $customer_info->full_name }}" placeholder="Your Full Name" required="required">
                                </td>
                            </tr>
                            <tr>
                                <th class="text-right">Email Address <span style="color: red">*</span></th>
                                <td>
                                    {{ $customer_info->email }}
                                </td>
                            </tr>
                            <tr>
                                <th class="text-right">Contact No <span style="color: red">*</span></th>
                                <td>
                                    <input type="text" class="form-control" name="contact_no" value="{{ $customer_info->contact_no }}" placeholder="Your Contact No" required="required">
                                </td>
                            </tr>
                            <tr>
                                <th class="text-right">Address <span style="color: red">*</span></th>
                                <td>
                                    <textarea name="address" class="form-control" placeholder="Your Address" required="required">{{ $customer_info->address }}</textarea>
                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <td>
                                    <input type="submit" class="btn btn-success" value="UPDATE" >
                                </td>
                            </tr>

                        </table>
                    </div>

                </div>
                <div class="col-md-2"></div>
            </form>

            <div class="clearfix"> </div>
        </div>

        <div class="contact-bottom">
            <iframe src="{!! $company_info[0]->iframe_location !!}" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
</div>
<!-- //mail -->

@endsection