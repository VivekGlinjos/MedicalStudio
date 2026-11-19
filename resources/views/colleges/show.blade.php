@extends('layouts.dashboard')

@section('title', $college->college_name . ' - Medical Studio')

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">
    
    <!-- Breadcrumb -->
    <div style="margin-bottom: 1rem; font-size: 0.85rem; color: var(--muted); display: flex; align-items: center; gap: 0.5rem;">
        <a href="{{ route('dashboard') }}" style="color: var(--muted); text-decoration: none;">Dashboard</a>
        <i class="fa-solid fa-chevron-right" style="font-size: 0.6rem;"></i>
        <a href="{{ route('colleges.index') }}" style="color: var(--muted); text-decoration: none;">Colleges</a>
        <i class="fa-solid fa-chevron-right" style="font-size: 0.6rem;"></i>
        <span style="color: var(--blue); font-weight: 600;">{{ $college->college_name }}</span>
    </div>

    <!-- ZyNerd-Style Hero Header -->
    <div style="position: relative; margin-bottom: 3rem; border-radius: 16px; overflow: hidden; background: var(--white); box-shadow: 0 10px 30px rgba(0,0,0,0.08);">
        
        <!-- Banner Image -->
        <div style="width: 100%; height: 350px; background: url('{{ $college->getBannerUrl() }}') center/cover no-repeat; position: relative; border-bottom: 1px solid var(--border);">
            
            <!-- Gallery Button Overlay -->
            <button onclick="document.getElementById('galleryModal').style.display='flex'" style="position: absolute; bottom: 1.5rem; right: 1.5rem; background: var(--white); color: var(--ink); border: none; padding: 0.6rem 1.2rem; border-radius: 8px; font-weight: 600; font-size: 0.9rem; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 12px rgba(0,0,0,0.15); transition: transform 0.2s;">
                <i class="fa-regular fa-images"></i> View all photos &rarr;
            </button>
        </div>

        <!-- Overlapping Content Area -->
        <div style="padding: 0 2rem 2rem 2rem; position: relative; margin-top: -60px; display: flex; flex-wrap: wrap; gap: 2rem; align-items: flex-end;">
            
            <!-- Overlapping Logo -->
            <div style="width: 140px; height: 140px; background: var(--white); border-radius: 12px; padding: 0.5rem; box-shadow: 0 8px 24px rgba(0,0,0,0.1); flex-shrink: 0; display: flex; align-items: center; justify-content: center; position: relative; z-index: 10; border: 1px solid var(--border);">
                <img src="{{ $college->getImageUrl() }}" alt="Logo" style="max-width: 100%; max-height: 100%; object-fit: contain;">
            </div>

            <!-- College Title & Details -->
            <div style="flex: 1; min-width: 300px; padding-bottom: 0.5rem;">
                <h1 style="font-family: var(--font-display); font-size: 2.2rem; font-weight: 800; color: var(--ink); margin: 0 0 0.5rem 0; line-height: 1.2;">
                    {{ $college->college_name }}
                </h1>
                <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 0.75rem; font-size: 0.95rem; color: var(--muted);">
                    <span style="color: #e63946; font-weight: 600; text-decoration: underline; text-decoration-color: rgba(230,57,70,0.3); text-underline-offset: 4px;">{{ $college->getTypeLabel() }}</span>
                    <span style="color: var(--border);">•</span>
                    <span>{{ $college->city ?? $college->place }}</span>
                    <span style="color: var(--border);">•</span>
                    <span>{{ $college->stateRelation->name ?? $college->state }}</span>
                    @if($college->year_of_inspection)
                        <span style="color: var(--border);">•</span>
                        <span>Est. {{ $college->year_of_inspection }}</span>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div style="display: flex; gap: 1rem; padding-bottom: 0.5rem;">
                <a href="{{ $college->website_link ?? '#' }}" {{ $college->website_link ? 'target="_blank"' : 'onclick="alert(\'Website link not available\'); return false;"' }} class="btn btn-primary" style="padding: 0.7rem 1.5rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem; border-radius: 8px;">
                    <i class="fa-solid fa-globe"></i> Website <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 0.7rem; opacity: 0.7;"></i>
                </a>
                
                @auth
                <button id="saveToListBtn" class="btn btn-outline" style="padding: 0.7rem 1.5rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem; border-radius: 8px;" data-college-id="{{ $college->college_id }}">
                    <i class="fa-regular fa-bookmark" id="saveIcon"></i> <span id="saveText">Save</span>
                </button>
                @else
                <a href="{{ route('login') }}" class="btn btn-outline" style="padding: 0.7rem 1.5rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem; border-radius: 8px;">
                    <i class="fa-regular fa-bookmark"></i> Save
                </a>
                @endauth
            </div>
        </div>
    </div>

    <style>
        .college-layout {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
        }
        @media (max-width: 992px) {
            .college-layout {
                grid-template-columns: 1fr;
            }
            .college-sidebar {
                position: static !important;
            }
        }
    </style>
    <!-- Main Content Grid -->
    <div class="college-layout">
        
        <!-- Left content (Tabs) -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;" x-data="{ tab: 'overview' }">
            
            <!-- Tab Navigation -->
            <div style="display: flex; gap: 1rem; border-bottom: 1px solid var(--border); margin-bottom: 2rem; overflow-x: auto; flex-wrap: wrap;">
                <button @click="tab = 'overview'" style="padding: 1rem 1.5rem; background: none; border: none; font-weight: 600; cursor: pointer; transition: all 0.2s; outline: none; display: flex; align-items: center; gap: 0.5rem; white-space: nowrap;" :style="tab === 'overview' ? 'color: var(--blue); border-bottom: 3px solid var(--blue); background: rgba(29, 78, 216, 0.03);' : 'color: var(--muted); border-bottom: 3px solid transparent;'">
                    <i class="fa-solid fa-circle-info"></i> Overview
                </button>
                @if($college->seatMatrices && $college->seatMatrices->count() > 0)
                <button @click="tab = 'seat_matrix'" style="padding: 1rem 1.5rem; background: none; border: none; font-weight: 600; cursor: pointer; transition: all 0.2s; outline: none; display: flex; align-items: center; gap: 0.5rem; white-space: nowrap;" :style="tab === 'seat_matrix' ? 'color: var(--blue); border-bottom: 3px solid var(--blue); background: rgba(29, 78, 216, 0.03);' : 'color: var(--muted); border-bottom: 3px solid transparent;'">
                    <i class="fa-solid fa-border-all"></i> Seat Matrix
                </button>
                @endif
                @if($college->cutoffs && $college->cutoffs->count() > 0)
                <button @click="tab = 'cutoffs'" style="padding: 1rem 1.5rem; background: none; border: none; font-weight: 600; cursor: pointer; transition: all 0.2s; outline: none; display: flex; align-items: center; gap: 0.5rem; white-space: nowrap;" :style="tab === 'cutoffs' ? 'color: var(--blue); border-bottom: 3px solid var(--blue); background: rgba(29, 78, 216, 0.03);' : 'color: var(--muted); border-bottom: 3px solid transparent;'">
                    <i class="fa-solid fa-chart-line"></i> Cutoffs
                </button>
                @endif
            </div>

            <!-- Tab Content Area -->
            <div class="card" style="padding: 2rem;">
                
                <!-- Overview Tab -->
                <div x-show="tab === 'overview'">
                    <h3 style="font-family: var(--font-heading); font-size: 1.25rem; font-weight: 700; color: var(--ink); margin: 0 0 1.5rem 0;">About {{ $college->college_name }}</h3>
                    
                    <!-- Quick Facts Grid -->
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
                        @if($college->total_seats)
                        <div style="background: var(--bg-soft); padding: 1rem; border-radius: 8px; border: 1px solid var(--border);">
                            <span style="color: var(--muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 0.25rem;">Total Seats</span>
                            <span style="font-size: 1.1rem; font-weight: 700; color: var(--ink);">{{ $college->total_seats }}</span>
                        </div>
                        @endif

                        @if($college->hospital_beds)
                        <div style="background: var(--bg-soft); padding: 1rem; border-radius: 8px; border: 1px solid var(--border);">
                            <span style="color: var(--muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 0.25rem;">Hospital Beds</span>
                            <span style="font-size: 1.1rem; font-weight: 700; color: var(--ink);">{{ $college->hospital_beds }}</span>
                        </div>
                        @endif

                        @if($college->college_fees)
                        <div style="background: var(--bg-soft); padding: 1rem; border-radius: 8px; border: 1px solid var(--border);">
                            <span style="color: var(--muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 0.25rem;">College Fees</span>
                            <span style="font-size: 1.1rem; font-weight: 700; color: var(--ink);">{{ $college->college_fees }}</span>
                        </div>
                        @endif

                        @if($college->general_rank)
                        <div style="background: var(--bg-soft); padding: 1rem; border-radius: 8px; border: 1px solid var(--border);">
                            <span style="color: var(--muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 0.25rem;">Gen Cutoff {{ $college->cutoff_year ? '('.$college->cutoff_year.')' : 'Rank' }}</span>
                            <span style="font-size: 1.1rem; font-weight: 700; color: var(--ink);">{{ $college->general_rank }}</span>
                        </div>
                        @endif
                        
                        @if($college->obc_rank)
                        <div style="background: var(--bg-soft); padding: 1rem; border-radius: 8px; border: 1px solid var(--border);">
                            <span style="color: var(--muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 0.25rem;">OBC Cutoff {{ $college->cutoff_year ? '('.$college->cutoff_year.')' : 'Rank' }}</span>
                            <span style="font-size: 1.1rem; font-weight: 700; color: var(--ink);">{{ $college->obc_rank }}</span>
                        </div>
                        @endif
                        
                        @if($college->sc_rank)
                        <div style="background: var(--bg-soft); padding: 1rem; border-radius: 8px; border: 1px solid var(--border);">
                            <span style="color: var(--muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 0.25rem;">SC Cutoff {{ $college->cutoff_year ? '('.$college->cutoff_year.')' : 'Rank' }}</span>
                            <span style="font-size: 1.1rem; font-weight: 700; color: var(--ink);">{{ $college->sc_rank }}</span>
                        </div>
                        @endif

                        @if($college->st_rank)
                        <div style="background: var(--bg-soft); padding: 1rem; border-radius: 8px; border: 1px solid var(--border);">
                            <span style="color: var(--muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 0.25rem;">ST Cutoff {{ $college->cutoff_year ? '('.$college->cutoff_year.')' : 'Rank' }}</span>
                            <span style="font-size: 1.1rem; font-weight: 700; color: var(--ink);">{{ $college->st_rank }}</span>
                        </div>
                        @endif
                    </div>
                    <div style="font-size: 0.95rem; color: var(--ink); line-height: 1.7;">
                        @if($college->about_us)
                            {!! $college->about_us !!}
                        @else
                            <p style="color: var(--muted); font-style: italic;">No about information available for this college.</p>
                        @endif
                    </div>
                    
                    @if($college->remarks)
                    <div style="margin-top: 2rem; background: rgba(245, 158, 11, 0.1); border-left: 4px solid #f59e0b; padding: 1rem 1.5rem; border-radius: 4px;">
                        <h4 style="font-size: 1rem; color: #d97706; margin: 0 0 0.5rem 0; display: flex; align-items: center; gap: 0.5rem;"><i class="fa-solid fa-triangle-exclamation"></i> Remarks / Important Note</h4>
                        <div style="font-size: 0.9rem; color: var(--ink); line-height: 1.6;">
                            {{ $college->remarks }}
                        </div>
                    </div>
                    @endif

                    @if($college->college_description)
                    <div style="font-size: 0.95rem; color: var(--ink); line-height: 1.7; margin-top: 1.5rem;">
                        {!! $college->college_description !!}
                    </div>
                    @endif

                    <div style="margin-top: 2.5rem; border-top: 1px solid var(--border); padding-top: 2rem;">
                        <h3 style="font-family: var(--font-heading); font-size: 1.25rem; font-weight: 700; color: var(--ink); margin: 0 0 1.5rem 0;">Contact & Info</h3>
                        
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem;">
                            <div style="background: var(--bg-soft); padding: 1.5rem; border-radius: 8px; border: 1px solid var(--border);">
                                <h4 style="font-size: 1.05rem; margin-top: 0; margin-bottom: 0.75rem; color: var(--ink);">Dean</h4>
                                <p style="margin: 0 0 0.5rem 0; font-size: 0.9rem; color: var(--muted);"><i class="fa-regular fa-envelope me-2"></i> {{ $college->dean_email ?? 'N/A' }}</p>
                                <p style="margin: 0; font-size: 0.9rem; color: var(--muted);"><i class="fa-solid fa-phone me-2"></i> {{ $college->dean_contact ?? 'N/A' }}</p>
                            </div>
                            
                            <div style="background: var(--bg-soft); padding: 1.5rem; border-radius: 8px; border: 1px solid var(--border);">
                                <h4 style="font-size: 1.05rem; margin-top: 0; margin-bottom: 0.75rem; color: var(--ink);">Principal</h4>
                                <p style="margin: 0 0 0.5rem 0; font-size: 0.9rem; color: var(--muted);"><i class="fa-regular fa-envelope me-2"></i> {{ $college->principal_email ?? 'N/A' }}</p>
                                <p style="margin: 0; font-size: 0.9rem; color: var(--muted);"><i class="fa-solid fa-phone me-2"></i> {{ $college->principal_contact ?? 'N/A' }}</p>
                            </div>
                            
                            <div style="background: var(--bg-soft); padding: 1.5rem; border-radius: 8px; border: 1px solid var(--border);">
                                <h4 style="font-size: 1.05rem; margin-top: 0; margin-bottom: 0.75rem; color: var(--ink);">Nodal Officer</h4>
                                <p style="margin: 0 0 0.5rem 0; font-size: 0.9rem; color: var(--muted);"><i class="fa-regular fa-envelope me-2"></i> {{ $college->nodal_email ?? 'N/A' }}</p>
                                <p style="margin: 0; font-size: 0.9rem; color: var(--muted);"><i class="fa-solid fa-phone me-2"></i> {{ $college->nodal_contact ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Seat Matrix Tab -->
                @if($college->seatMatrices && $college->seatMatrices->count() > 0)
                <div x-show="tab === 'seat_matrix'" style="display: none;" :style="tab === 'seat_matrix' ? 'display: block;' : 'display: none;'">
                    <h3 style="font-family: var(--font-heading); font-size: 1.25rem; font-weight: 700; color: var(--ink); margin: 0 0 1.5rem 0;">Seat Matrix Distribution</h3>
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: var(--bg-soft); text-align: left;">
                                <th style="padding: 0.75rem 1rem; font-size: 0.8rem; text-transform: uppercase; color: var(--muted);">Course</th>
                                <th style="padding: 0.75rem 1rem; font-size: 0.8rem; text-transform: uppercase; color: var(--muted);">Category</th>
                                <th style="padding: 0.75rem 1rem; font-size: 0.8rem; text-transform: uppercase; color: var(--muted);">Seats</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($college->seatMatrices as $matrix)
                            <tr style="border-bottom: 1px solid var(--border);">
                                <td style="padding: 1rem; font-weight: 600;">{{ $matrix->course->name ?? 'MBBS' }}</td>
                                <td style="padding: 1rem;">{{ $matrix->category }} ({{ $matrix->quota }})</td>
                                <td style="padding: 1rem; font-weight: 700; color: var(--blue);">{{ $matrix->seats }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif

                <!-- Cutoffs Tab (Upgraded with AlpineJS Filtering) -->
                @if($college->cutoffs && $college->cutoffs->count() > 0)
                <div x-show="tab === 'cutoffs'" style="display: none;" :style="tab === 'cutoffs' ? 'display: block;' : 'display: none;'" 
                     x-data="{ 
                         searchYear: '', 
                         searchCategory: '',
                         cutoffs: {{ json_encode($college->cutoffs->map(function($c) { return ['year' => $c->year, 'round' => $c->round, 'category' => $c->category, 'quota' => $c->quota, 'closing_rank' => $c->closing_rank, 'closing_score' => $c->closing_score]; })) }},
                         get filteredCutoffs() {
                             return this.cutoffs.filter(c => {
                                 let matchYear = this.searchYear === '' || c.year.toString() === this.searchYear;
                                 let matchCat = this.searchCategory === '' || c.category.toLowerCase().includes(this.searchCategory.toLowerCase());
                                 return matchYear && matchCat;
                             });
                         },
                         get uniqueYears() {
                             return [...new Set(this.cutoffs.map(c => c.year))].sort((a,b) => b-a);
                         },
                         get uniqueCategories() {
                             return [...new Set(this.cutoffs.map(c => c.category))].sort();
                         }
                     }">
                     
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
                        <h3 style="font-family: var(--font-heading); font-size: 1.25rem; font-weight: 700; color: var(--ink); margin: 0;">Previous Year Cutoffs</h3>
                        <a href="{{ route('past-allotments.index', ['college_id' => $college->college_id]) }}" class="btn btn-sm btn-outline-primary" style="font-size: 0.85rem; border-radius: 6px;">Open in Explorer <i class="fa-solid fa-arrow-right ms-1"></i></a>
                    </div>
                    
                    <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem; background: var(--bg-soft); padding: 1rem; border-radius: 8px;">
                        <div style="flex: 1;">
                            <label style="font-size: 0.8rem; font-weight: 600; color: var(--muted); display: block; margin-bottom: 0.25rem;">Filter by Year</label>
                            <select x-model="searchYear" class="form-select form-select-sm" style="border: 1px solid var(--border);">
                                <option value="">All Years</option>
                                <template x-for="yr in uniqueYears" :key="yr">
                                    <option :value="yr.toString()" x-text="yr"></option>
                                </template>
                            </select>
                        </div>
                        <div style="flex: 1;">
                            <label style="font-size: 0.8rem; font-weight: 600; color: var(--muted); display: block; margin-bottom: 0.25rem;">Filter by Category</label>
                            <select x-model="searchCategory" class="form-select form-select-sm" style="border: 1px solid var(--border);">
                                <option value="">All Categories</option>
                                <template x-for="cat in uniqueCategories" :key="cat">
                                    <option :value="cat" x-text="cat"></option>
                                </template>
                            </select>
                        </div>
                    </div>

                    <div style="overflow-x: auto; border-radius: 8px; border: 1px solid var(--border);">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="background: var(--bg-soft); text-align: left;">
                                    <th style="padding: 0.75rem 1rem; font-size: 0.8rem; text-transform: uppercase; color: var(--muted);">Year / Round</th>
                                    <th style="padding: 0.75rem 1rem; font-size: 0.8rem; text-transform: uppercase; color: var(--muted);">Category (Quota)</th>
                                    <th style="padding: 0.75rem 1rem; font-size: 0.8rem; text-transform: uppercase; color: var(--muted);">Closing Rank</th>
                                    <th style="padding: 0.75rem 1rem; font-size: 0.8rem; text-transform: uppercase; color: var(--muted);">Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="cutoff in filteredCutoffs" :key="cutoff.year + '-' + cutoff.round + '-' + cutoff.category + '-' + cutoff.quota">
                                    <tr style="border-bottom: 1px solid var(--border);">
                                        <td style="padding: 1rem; font-weight: 600;">
                                            <span x-text="cutoff.year"></span> / <span class="text-muted" style="font-size: 0.85rem;" x-text="'Round ' + cutoff.round"></span>
                                        </td>
                                        <td style="padding: 1rem;">
                                            <span style="font-weight: 600; color: var(--blue);" x-text="cutoff.category"></span> 
                                            <span style="font-size: 0.85rem; color: var(--muted);" x-text="'(' + cutoff.quota + ')'"></span>
                                        </td>
                                        <td style="padding: 1rem; font-weight: 700; color: var(--danger); font-size: 1.1rem;" x-text="new Intl.NumberFormat('en-IN').format(cutoff.closing_rank)"></td>
                                        <td style="padding: 1rem;">
                                            <span x-show="cutoff.closing_score" class="badge bg-secondary" x-text="cutoff.closing_score"></span>
                                            <span x-show="!cutoff.closing_score" class="text-muted">-</span>
                                        </td>
                                    </tr>
                                </template>
                                <tr x-show="filteredCutoffs.length === 0">
                                    <td colspan="4" style="padding: 2rem; text-align: center; color: var(--muted);">
                                        No cutoffs found for the selected filters.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

            </div>
        </div>

        <!-- Right content (Stats & Enquiry) -->
        <div class="college-sidebar" style="display: flex; flex-direction: column; gap: 1.5rem; position: sticky; top: 100px; align-self: start;">
            
            <div class="card" style="padding: 0; overflow: hidden;">
                <div style="background: linear-gradient(135deg, var(--bg-soft), var(--white)); padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border);">
                    <h3 style="font-weight: 700; color: var(--ink); margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fa-solid fa-bolt" style="color: var(--yellow);"></i> Quick Facts
                    </h3>
                </div>
                
                <div style="padding: 0;">
                    <ul style="list-style: none; margin: 0; padding: 0;">
                        <li style="padding: 1rem 1.5rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border);">
                            <span style="color: var(--muted); font-size: 0.85rem;">Affiliation</span>
                            <span style="color: var(--ink); font-weight: 600; text-align: right; max-width: 60%;">{{ $college->affiliation ?? 'N/A' }}</span>
                        </li>
                        <li style="padding: 1rem 1.5rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border);">
                            <span style="color: var(--muted); font-size: 0.85rem;">Total Seats</span>
                            <span style="color: var(--ink); font-weight: 600;">{{ $college->total_seats ?? 'N/A' }}</span>
                        </li>
                        <li style="padding: 1rem 1.5rem; display: flex; justify-content: space-between; align-items: center;">
                            <span style="color: var(--muted); font-size: 0.85rem;">Website</span>
                            @if($college->website_link)
                            <a href="{{ $college->website_link }}" target="_blank" style="color: var(--blue); font-weight: 600;">Visit Site</a>
                            @else
                            <span style="color: var(--muted); font-weight: 600;">N/A</span>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>

            <!-- College Enquiry Form -->
            <div class="card" style="padding: 1.5rem;">
                <h3 style="font-family: var(--font-heading); font-size: 1.1rem; font-weight: 700; color: var(--ink); margin: 0 0 1rem 0; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fa-solid fa-envelope" style="color: var(--teal);"></i> Enquire about Admission
                </h3>
                
                <form action="{{ route('contact.submit') }}" method="POST">
                    @csrf
                    <input type="hidden" name="enquiry_for" value="{{ $college->college_name }}">
                    
                    <div style="margin-bottom: 1rem;">
                        <input type="text" name="name" class="form-control" placeholder="Your Name" value="{{ auth()->user()->name ?? '' }}" required style="width: 100%; padding: 0.6rem 1rem; border-radius: 8px; border: 1px solid var(--border);">
                    </div>
                    
                    <div style="margin-bottom: 1rem;">
                        <input type="email" name="email" class="form-control" placeholder="Email Address" value="{{ auth()->user()->email ?? '' }}" required style="width: 100%; padding: 0.6rem 1rem; border-radius: 8px; border: 1px solid var(--border);">
                    </div>
                    
                    <div style="margin-bottom: 1rem;">
                        <input type="tel" name="phone" class="form-control" placeholder="Phone Number" required style="width: 100%; padding: 0.6rem 1rem; border-radius: 8px; border: 1px solid var(--border);" maxlength="15" oninput="this.value = this.value.replace(/[^0-9+\s-]/g, '')">
                    </div>
                    
                    <div style="margin-bottom: 1rem;">
                        <textarea name="message" class="form-control" rows="3" placeholder="I am interested in admission for MBBS..." required style="width: 100%; padding: 0.6rem 1rem; border-radius: 8px; border: 1px solid var(--border);"></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-block" style="background: var(--blue); color: var(--white); width: 100%; padding: 0.75rem; border-radius: 8px; font-weight: 600;">
                        Send Enquiry
                    </button>
                </form>
            </div>

        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('saveToListBtn');
    if (!btn) return;

    btn.addEventListener('click', async function() {
        const collegeId = this.dataset.collegeId;
        const saveText = document.getElementById('saveText');
        const saveIcon = document.getElementById('saveIcon');

        // Disable button immediately
        btn.disabled = true;
        saveText.textContent = 'Saving...';

        try {
            // Step 1: Get or create the active choice list
            const listRes = await fetch('{{ url("/api/choice-list/active") }}', {
                headers: { 'Accept': 'application/json' }
            });
            const listData = await listRes.json();

            if (!listData.list) {
                throw new Error('Could not get choice list');
            }

            // Step 2: Check if already saved
            const existing = listData.choices?.find(c => c.college_id == collegeId);
            if (existing) {
                saveText.textContent = 'Already Saved';
                saveIcon.className = 'fa-solid fa-bookmark';
                btn.style.background = 'var(--bg-soft)';
                btn.style.color = 'var(--blue)';
                showToast('This college is already in your choice list!', 'info');
                return;
            }

            // Step 3: Add to choice list (use first course as default)
            const storeRes = await fetch('{{ url("/api/choice-list/store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                },
                body: JSON.stringify({
                    list_id: listData.list.id,
                    college_id: collegeId,
                    course_id: 1,
                    quota: 'AIQ',
                    category: 'UR'
                })
            });

            if (storeRes.ok) {
                saveText.textContent = 'Saved!';
                saveIcon.className = 'fa-solid fa-bookmark';
                btn.style.background = 'rgba(29, 78, 216, 0.1)';
                btn.style.color = 'var(--blue)';
                btn.style.borderColor = 'var(--blue)';
                showToast('College added to your choice list!', 'success');
            } else {
                throw new Error('Failed to save');
            }
        } catch (err) {
            saveText.textContent = 'Save to List';
            btn.disabled = false;
            showToast('Failed to save. Please try again.', 'error');
            console.error(err);
        }
    });

    function showToast(message, type) {
        const toast = document.createElement('div');
        toast.style.cssText = `
            position: fixed; bottom: 2rem; right: 2rem; z-index: 9999;
            padding: 1rem 1.5rem; border-radius: 8px; font-weight: 600; font-size: 0.9rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15); animation: slideUp 0.3s ease;
            ${type === 'success' ? 'background: #059669; color: white;' : type === 'error' ? 'background: #dc2626; color: white;' : 'background: #2563eb; color: white;'}
        `;
        toast.textContent = message;
        document.body.appendChild(toast);
        setTimeout(() => { toast.style.opacity = '0'; toast.style.transition = 'opacity 0.3s'; }, 2500);
        setTimeout(() => toast.remove(), 3000);
    }
});
</script>
<style>
@keyframes slideUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

<!-- Gallery Modal -->
<div id="galleryModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.9); z-index: 99999; align-items: center; justify-content: center; flex-direction: column;">
    <button onclick="document.getElementById('galleryModal').style.display='none'" style="position: absolute; top: 1.5rem; right: 2rem; background: none; border: none; color: white; font-size: 2rem; cursor: pointer; opacity: 0.8; transition: opacity 0.2s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.8'">&times;</button>
    
    <div style="width: 90%; max-width: 1000px; position: relative;">
        <!-- Main Image Viewer -->
        <div style="width: 100%; height: 60vh; background: transparent; display: flex; align-items: center; justify-content: center; margin-bottom: 2rem;">
            <img id="modalMainImg" src="{{ $college->getBannerUrl() }}" style="max-width: 100%; max-height: 100%; object-fit: contain; border-radius: 8px; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
        </div>
        
        <!-- Thumbnails -->
        <div style="display: flex; gap: 1rem; overflow-x: auto; padding-bottom: 1rem; justify-content: center;">
            @php
                // Build an array of all images (banner, logo, + gallery)
                $allImages = [
                    $college->getBannerUrl(),
                    $college->getImageUrl()
                ];
                if(isset($college->galleries) && $college->galleries->count() > 0) {
                    foreach($college->galleries as $g) {
                        $allImages[] = Storage::url($g->image_path);
                    }
                }
            @endphp
            
            @foreach($allImages as $idx => $imgUrl)
                <img src="{{ $imgUrl }}" onclick="document.getElementById('modalMainImg').src=this.src" style="width: 80px; height: 60px; object-fit: cover; border-radius: 6px; cursor: pointer; border: 2px solid rgba(255,255,255,0.2); transition: all 0.2s;" onmouseover="this.style.borderColor='white'" onmouseout="this.style.borderColor='rgba(255,255,255,0.2)'">
            @endforeach
        </div>
    </div>
</div>

@endpush
