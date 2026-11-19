@extends('layouts.dashboard')

@section('title', 'My Enquiries - Medical Studio')

@section('content')
<div style="max-width: 1000px; margin: 0 auto;">
    
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2rem;">
        <div>
            <h1 style="font-family: var(--font-display); font-size: 2rem; font-weight: 800; color: var(--ink); margin: 0 0 0.25rem 0;">My Enquiries</h1>
            <p style="color: var(--muted); margin: 0; font-size: 0.95rem;">Track the status of your queries and counseling requests.</p>
        </div>
        <a href="{{ route('contact') }}" class="btn" style="background: var(--blue); color: var(--white); font-weight: 600; padding: 0.75rem 1.5rem; border-radius: 8px;">
            <i class="fa-solid fa-plus" style="margin-right: 0.5rem;"></i> New Enquiry
        </a>
    </div>

    <div class="card" style="padding: 0; overflow: hidden;">
        @if(count($enquiries) > 0)
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: var(--bg-soft); border-bottom: 1px solid var(--border); text-align: left;">
                        <th style="padding: 1rem 1.5rem; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--muted); font-weight: 700;">Date</th>
                        <th style="padding: 1rem 1.5rem; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--muted); font-weight: 700;">Subject / For</th>
                        <th style="padding: 1rem 1.5rem; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--muted); font-weight: 700;">Message Preview</th>
                        <th style="padding: 1rem 1.5rem; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--muted); font-weight: 700;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($enquiries as $enq)
                        <tr style="border-bottom: 1px solid var(--border);">
                            <td style="padding: 1.25rem 1.5rem; color: var(--ink); font-size: 0.9rem; font-weight: 500;">
                                {{ $enq->created_at->format('d M Y') }}
                                <div style="font-size: 0.75rem; color: var(--muted); margin-top: 0.2rem;">{{ $enq->created_at->format('h:i A') }}</div>
                            </td>
                            <td style="padding: 1.25rem 1.5rem; color: var(--ink); font-size: 0.9rem; font-weight: 600;">
                                {{ $enq->enquiry_for ?? 'General Enquiry' }}
                            </td>
                            <td style="padding: 1.25rem 1.5rem; color: var(--muted); font-size: 0.85rem; max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ $enq->message }}
                            </td>
                            <td style="padding: 1.25rem 1.5rem;">
                                <span style="background: rgba(22, 163, 74, 0.1); color: var(--green); padding: 4px 10px; border-radius: 4px; font-size: 0.75rem; font-weight: 700;">Submitted</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div style="padding: 1.5rem; border-top: 1px solid var(--border);">
                {{ $enquiries->links('pagination::tailwind') }}
            </div>
        @else
            <div style="padding: 4rem 2rem; text-align: center;">
                <div style="width: 80px; height: 80px; border-radius: 50%; background: var(--bg-soft); color: var(--muted); display: flex; align-items: center; justify-content: center; font-size: 2.5rem; margin: 0 auto 1.5rem auto;">
                    <i class="fa-regular fa-envelope-open"></i>
                </div>
                <h3 style="font-family: var(--font-heading); font-size: 1.25rem; font-weight: 700; color: var(--ink); margin-bottom: 0.5rem;">No Enquiries Yet</h3>
                <p style="color: var(--muted); margin-bottom: 1.5rem; max-width: 400px; margin-left: auto; margin-right: auto;">You haven't submitted any counseling or general enquiries yet. Need help? Reach out to us!</p>
                <a href="{{ route('contact') }}" class="btn" style="background: var(--bg-soft); color: var(--ink); border: 1px solid var(--border); font-weight: 600; padding: 0.5rem 1.25rem;">Contact Support</a>
            </div>
        @endif
    </div>

</div>
@endsection
