@extends('admin.backend_master')

@section('contentpanel')

    <div class="page-title">
        Welcome, {{ auth()->user()->name ?? 'Administrator' }} 👋
    </div>
    <p style="color: #64748b; font-size: 0.95rem; margin-bottom: 2rem;">Manage colleges, courses, and track enquiries — all in one place.</p>

    {{-- Stats Cards Grid --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 2.5rem;">
        
        {{-- Enquiries Stat --}}
        <div class="card" style="margin-bottom: 0;">
            <div class="card-body">
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem; color: #64748b; font-weight: 600; font-size: 0.9rem;">
                    <i class="fa-regular fa-envelope" style="font-size: 1.1rem; color: #0f172a;"></i>
                    Total Enquiries
                </div>
                <div style="font-size: 2.5rem; font-weight: 800; color: #0f172a; margin-bottom: 0.5rem; line-height: 1;">
                    {{ $enquiryCount ?? '0' }}
                </div>
            </div>
        </div>

        {{-- Colleges Stat --}}
        <div class="card" style="margin-bottom: 0;">
            <div class="card-body">
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem; color: #64748b; font-weight: 600; font-size: 0.9rem;">
                    <i class="fa-regular fa-building" style="font-size: 1.1rem; color: #0f172a;"></i>
                    Total Colleges
                </div>
                <div style="font-size: 2.5rem; font-weight: 800; color: #0f172a; margin-bottom: 0.5rem; line-height: 1;">
                    {{ $collegeCount ?? '0' }}
                </div>
            </div>
        </div>

        {{-- Courses Stat --}}
        <div class="card" style="margin-bottom: 0;">
            <div class="card-body">
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem; color: #64748b; font-weight: 600; font-size: 0.9rem;">
                    <i class="fa-solid fa-graduation-cap" style="font-size: 1.1rem; color: #0f172a;"></i>
                    Total Courses
                </div>
                <div style="font-size: 2.5rem; font-weight: 800; color: #0f172a; margin-bottom: 0.5rem; line-height: 1;">
                    {{ $courseCount ?? '0' }}
                </div>
            </div>
        </div>

        {{-- Users Stat --}}
        <div class="card" style="margin-bottom: 0;">
            <div class="card-body">
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem; color: #64748b; font-weight: 600; font-size: 0.9rem;">
                    <i class="fa-regular fa-user" style="font-size: 1.1rem; color: #0f172a;"></i>
                    Total Users
                </div>
                <div style="font-size: 2.5rem; font-weight: 800; color: #0f172a; margin-bottom: 0.5rem; line-height: 1;">
                    {{ $userCount ?? '0' }}
                </div>
            </div>
        </div>
    </div>


    {{-- Recent Enquiries Table --}}
    <div class="card">
        <div class="card-header" style="display: flex; align-items: center; justify-content: space-between; border-bottom: none; padding-bottom: 0;">
            <span style="font-size: 1.1rem;">Recent Enquiries</span>
            <button style="background: transparent; border: 1px solid #e2e8f0; border-radius: 8px; padding: 0.4rem 0.75rem; font-size: 0.85rem; font-weight: 600; color: #334155; cursor: pointer;">
                Filter <i class="fa-solid fa-sliders" style="margin-left: 0.25rem;"></i>
            </button>
        </div>
        <div class="card-body">
            <div style="background: #f8fafc; border-radius: 12px; padding: 0.5rem; border: 1px solid #f1f5f9;">
                <table class="table" style="margin-bottom: 0;">
                    <thead>
                        <tr>
                            <th style="border: none; padding-left: 1.5rem;">ID <i class="fa-solid fa-arrow-down-short-wide" style="margin-left: 0.5rem;"></i></th>
                            <th style="border: none;">Name</th>
                            <th style="border: none;">Email</th>
                            <th style="border: none;">Phone</th>
                            <th style="border: none;">Date</th>
                            <th style="border: none;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($enquiry))
                            @foreach ($enquiry->take(5) as $item)
                            <tr>
                                <td style="padding-left: 1.5rem; font-weight: 600; color: #0f172a;">
                                    <input type="checkbox" style="margin-right: 0.75rem;"> ENQ-{{ $item->id }}
                                </td>
                                <td style="font-weight: 500;">{{ Str::limit($item->name, 25) }}</td>
                                <td style="color: #64748b;">{{ Str::limit($item->email, 25) }}</td>
                                <td style="color: #64748b;">{{ $item->phone }}</td>
                                <td style="color: #64748b;">{{ $item->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.enquiries.show', $item->id) }}" style="color: #0ea5e9; font-weight: 600; text-decoration: none; font-size: 0.85rem;">
                                        <i class="fa-regular fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" style="text-align: center; color: #94a3b8; padding: 2rem;">No recent enquiries found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection