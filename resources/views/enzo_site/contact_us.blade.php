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
        <h3>Contact Us</h3>
        <div class="agile_mail_grids">
            <div class="col-md-5 contact-left">
                <h4>Address</h4>
                <p>{{ $company_info[0]->company_full_address }}</p>
                <ul>
                    <li>Phone : {{ $company_info[0]->company_phone }}</li>
                    <li>Fax : {{ $company_info[0]->company_fax }}</li>
                    <li><a href="mailto:{{ $company_info[0]->company_email }}">{{ $company_info[0]->company_email }}</a></li>
                </ul>
            </div>
            <form action="{{ route('contact_message') }}" method="post">

                {{ csrf_field() }}

                <div class="col-md-7 contact-left">
                    <h4>Contact Form</h4>

                    @if(Session::has('message'))
                        <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('message') }}</p>
                    @endif

                    <input type="text" name="name" value="" placeholder="Your Name" required="required">
                    <input type="email" name="email_address" value="" placeholder="Your Email Address" required="required">
                    <input type="text" name="contact_no" value="" placeholder="Your Contact No">
                    <textarea name="query_message" placeholder="Your Message" required="required"></textarea>
                    <input type="submit" value="SUBMIT" >

                </div>
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