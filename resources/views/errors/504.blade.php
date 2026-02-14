@extends('errors::minimal')

@section('title', 'Gateway Timeout')
@section('code', '504')
@section('message')
    <pre style="color: var(--heading, #00d2d3); font-family: 'Courier New', monospace; font-size: 12px; margin: 16px 0;">
     ╔══════════════════════════════════╗
     ║   504 GATEWAY TIMEOUT           ║
     ║   The upstream server didn't    ║
     ║   respond in time.              ║
     ╚══════════════════════════════════╝
    </pre>
    <p style="color: #888; font-size: 13px;">The server took too long to respond. Please try again shortly.</p>
    <p style="margin-top: 16px;">
        <a href="{{ url('/') }}" style="color: var(--link, #48dbfb);">← back to home</a> |
        <a href="javascript:location.reload()" style="color: var(--link, #48dbfb);">↻ retry</a>
    </p>
@endsection