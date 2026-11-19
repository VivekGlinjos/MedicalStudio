@extends('admin.backend_master')

@section('contentpanel')
<div class="container-fluid py-4" x-data="cutoffManager()">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Manage College Cutoffs</h4>
            <a href="{{ route('admin.cutoffs.index') }}" class="btn btn-outline-secondary">
                <i class="fa-solid fa-arrow-left me-1"></i> Back to Cutoffs
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger text-white mb-4">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-bottom py-3">
            <h5 class="mb-0">1. Select Context</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-bold">College <span class="text-danger">*</span></label>
                    <select x-model="context.college_id" class="form-select" @change="fetchExisting()">
                        <option value="">Select College</option>
                        @foreach($colleges as $c)
                            <option value="{{ $c->college_id }}">{{ $c->college_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Course <span class="text-danger">*</span></label>
                    <select x-model="context.course_id" class="form-select" @change="fetchExisting()">
                        <option value="">Select Course</option>
                        @foreach($courses as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Year <span class="text-danger">*</span></label>
                    <select x-model="context.year" class="form-select" @change="fetchExisting()">
                        <option value="">Select Year</option>
                        <option value="2026">2026</option>
                        <option value="2024">2024</option>
                        <option value="2023">2023</option>
                        <option value="2022">2022</option>
                        <option value="2021">2021</option>
                        <option value="2020">2020</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Round <span class="text-danger">*</span></label>
                    <select x-model="context.round" class="form-select" @change="fetchExisting()">
                        <option value="">Select Round</option>
                        <option value="1">Round 1</option>
                        <option value="2">Round 2</option>
                        <option value="3">Round 3 (Mop-up)</option>
                        <option value="4">Round 4 (Stray)</option>
                        <option value="5">Round 5</option>
                        <option value="6">Round 6</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.cutoffs.store-managed') }}" x-show="isContextReady()" x-cloak>
        @csrf
        <input type="hidden" name="college_id" :value="context.college_id">
        <input type="hidden" name="course_id" :value="context.course_id">
        <input type="hidden" name="year" :value="context.year">
        <input type="hidden" name="round" :value="context.round">

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">2. Manage Ranks (Cutoffs)</h5>
                <span class="badge bg-success" x-show="isLoading">Loading...</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Quota</th>
                                <th>Category</th>
                                <th>Closing Rank</th>
                                <th>Closing Score (Opt)</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(cutoff, index) in cutoffs" :key="index">
                                <tr>
                                    <td class="ps-4">
                                        <input type="text" :name="'cutoffs['+index+'][quota]'" x-model="cutoff.quota" class="form-control form-control-sm" required placeholder="e.g. AIQ">
                                    </td>
                                    <td>
                                        <input type="text" :name="'cutoffs['+index+'][category]'" x-model="cutoff.category" class="form-control form-control-sm" required placeholder="e.g. UR">
                                    </td>
                                    <td>
                                        <input type="number" :name="'cutoffs['+index+'][closing_rank]'" x-model="cutoff.closing_rank" class="form-control form-control-sm" required>
                                    </td>
                                    <td>
                                        <input type="number" :name="'cutoffs['+index+'][closing_score]'" x-model="cutoff.closing_score" class="form-control form-control-sm">
                                    </td>
                                    <td class="text-end pe-4">
                                        <button type="button" @click="removeRow(index)" class="btn btn-sm btn-outline-danger" title="Remove Row">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                            <tr x-show="cutoffs.length === 0">
                                <td colspan="5" class="text-center py-4 text-muted">No cutoffs added yet for this context. Click "Add Row" below.</td>
                            </tr>
                        </tbody>
                        <tfoot class="bg-light">
                            <tr>
                                <td colspan="5" class="p-3 text-center">
                                    <button type="button" @click="addRow()" class="btn btn-sm btn-outline-primary">
                                        <i class="fa-solid fa-plus me-1"></i> Add Row
                                    </button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white border-top text-end py-3">
                <button type="submit" class="btn btn-success px-4" :disabled="cutoffs.length === 0">
                    <i class="fa-solid fa-save me-1"></i> Save All Cutoffs
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    function cutoffManager() {
        return {
            context: {
                college_id: '',
                course_id: '',
                year: '',
                round: ''
            },
            cutoffs: [],
            isLoading: false,
            
            isContextReady() {
                return this.context.college_id !== '' && 
                       this.context.course_id !== '' && 
                       this.context.year !== '' && 
                       this.context.round !== '';
            },

            async fetchExisting() {
                if (!this.isContextReady()) return;

                this.isLoading = true;
                
                try {
                    const params = new URLSearchParams(this.context);
                    const response = await fetch(`{{ route('admin.cutoffs.fetch-managed') }}?${params.toString()}`);
                    const data = await response.json();
                    
                    if (data && data.length > 0) {
                        this.cutoffs = data.map(item => ({
                            quota: item.quota,
                            category: item.category,
                            closing_rank: item.closing_rank,
                            closing_score: item.closing_score
                        }));
                    } else {
                        // If no existing data, start with one empty row
                        this.cutoffs = [{ quota: '', category: '', closing_rank: '', closing_score: '' }];
                    }
                } catch (error) {
                    console.error("Error fetching cutoffs:", error);
                    // Fallback to one empty row on error
                    this.cutoffs = [{ quota: '', category: '', closing_rank: '', closing_score: '' }];
                } finally {
                    this.isLoading = false;
                }
            },

            addRow() {
                this.cutoffs.push({ quota: '', category: '', closing_rank: '', closing_score: '' });
            },

            removeRow(index) {
                this.cutoffs.splice(index, 1);
            }
        }
    }
</script>
@endsection
