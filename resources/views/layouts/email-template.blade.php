@extends('layouts.layout')
@section('title', 'KYC-XEPAYS-Email')
@section('content')
<div class="container"
        style="max-width: 600px; margin: 0 auto; padding: 20px; background-color: #ffffff; border-radius: 10px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
        <div class="avatar avatar-online">
            <img src="{{ asset('assets/img/avatars/logo.jpeg') }}" alt=""
            class="w-px-40 h-auto rounded-circle">
        </div>
        <div class="title" style="font-size: 24px; font-weight: bold; margin-top: 20px; color: #333; text-align: center;">
            KYC-XEPAYS - Email Verification</div>
        <div class="content" style="margin-top: 20px; color: #333; text-align: left;">
            <h3>Hello,</h3>
            <p>{!! $body !!}</p>
        </div>
        <a href="{{ $actionLink }}" class="button"
            style="display: block; width: 100%; text-align: center; background-color: #ff0000; color: #ffffff; text-decoration: none; padding: 10px; border-radius: 5px; margin-top: 20px;">Verify
            my email address</a>
        <div class="footer" style="margin-top: 20px; text-align: center; color: #333;">
            Follow us on:
            <a href="facebook-link" style="color: #333; text-decoration: none; margin: 0 5px;">Facebook</a> |
            <a href="twitter-link" style="color: #333; text-decoration: none; margin: 0 5px;">Twitter</a> |
            <a href="linkedin-link" style="color: #333; text-decoration: none; margin: 0 5px;">LinkedIn</a> |
            <a href="instagram-link" style="color: #333; text-decoration: none; margin: 0 5px;">Instagram</a>
            <br>
            800 Broadway Suite 1500, New York, NY 000423, USA
            <br>
            <a href="privacy-policy-link" style="color: #333; text-decoration: none;">Privacy Policy</a> | <a
                href="contact-link" style="color: #333; text-decoration: none;">Contact</a>
        </div>
    </div>
@endsection
