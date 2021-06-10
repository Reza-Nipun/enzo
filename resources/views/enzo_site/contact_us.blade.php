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
            <div class="col-md-7 contact-left">
                <h4>Contact Form</h4>
                <form action="#" method="post">
                    <input type="text" name="Name" value="Name" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Name';}" required="">
                    <input type="email" name="Email" value="Email" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Email';}" required="">
                    <input type="text" name="Telephone" value="Telephone" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Telephone';}" required="">
                    <textarea name="message" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Message...';}" required="">Message...</textarea>
                    <input type="submit" value="Submit" >
                </form>
            </div>
            <div class="clearfix"> </div>
        </div>

        <div class="contact-bottom">
            <iframe src="{!! $company_info[0]->iframe_location !!}" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
</div>
<!-- //mail -->

@endsection