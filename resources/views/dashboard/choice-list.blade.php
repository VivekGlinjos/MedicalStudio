@extends('layouts.dashboard')

@section('title', 'Choice List Builder - Medical Studio')

@section('content')
<div style="max-width: 1200px; margin: 0 auto;" x-data="choiceListBuilder({{ $courses->toJson() }})" x-init="init()">
    <div style="display: flex; flex-wrap: wrap; align-items: flex-end; justify-content: space-between; gap: 1rem; margin-bottom: 2rem;">
        <div>
            <span class="eyebrow" style="margin-bottom: 0.5rem;" x-text="list.name || 'Strategy'"></span>
            <h1 class="section-title" style="margin: 0;">Choice List Builder</h1>
            <p style="color: var(--muted); margin-top: 0.5rem;">Build and simulate your MCC preference list before you submit. Drag and drop to reorder.</p>
        </div>
        <button class="btn btn-teal" @click="searchModalOpen = true"><i class="fa-solid fa-plus"></i> Add College</button>
    </div>

    {{-- Search Modal Overlay --}}
    <style>
        .modal-overlay { display: flex; }
    </style>
    <div x-show="searchModalOpen" x-cloak class="modal-overlay" style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 2000; align-items: center; justify-content: center;">
        <div class="card" style="width: 100%; max-width: 600px; max-height: 80vh; display: flex; flex-direction: column; overflow: hidden; padding: 0;" @click.away="searchModalOpen = false">
            <div style="padding: 1.5rem; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; background: var(--bg-soft);">
                <h3 style="margin: 0; font-family: var(--font-heading); font-size: 1.1rem;">Search Colleges</h3>
                <button @click="searchModalOpen = false" style="font-size: 1.2rem; color: var(--muted); cursor: pointer;"><i class="fa-solid fa-xmark"></i></button>
            </div>
            
            <div style="padding: 1.5rem;">
                <select x-model="selectedCourseId" class="form-control" style="width: 100%; margin-bottom: 1rem; padding: 0.75rem 1rem; font-size: 1rem;">
                    <template x-for="c in courses" :key="c.id">
                        <option :value="c.id" x-text="c.name"></option>
                    </template>
                </select>
                <input type="text" x-model="searchQuery" @input.debounce.300ms="searchColleges" class="form-control" placeholder="Search by college name or state..." style="width: 100%; margin-bottom: 1rem; padding: 0.75rem 1rem; font-size: 1rem;">
                
                <div x-show="isSearching" style="text-align: center; color: var(--muted); padding: 1rem;">
                    <i class="fa-solid fa-spinner fa-spin"></i> Searching...
                </div>

                <div style="max-height: 400px; overflow-y: auto;">
                    <template x-for="result in searchResults" :key="result.college_id">
                        <div style="padding: 1rem; border: 1px solid var(--border); border-radius: 8px; margin-bottom: 0.5rem; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <div style="font-weight: 700; color: var(--ink); font-size: 0.9rem;" x-text="result.college_name"></div>
                                <div style="font-size: 0.75rem; color: var(--muted); margin-top: 0.25rem;">MBBS</div>
                            </div>
                            <button class="btn btn-outline" style="padding: 0.4rem 0.8rem; font-size: 0.75rem;" @click="addChoice(result.college_id)">Add</button>
                        </div>
                    </template>
                    <div x-show="searchResults.length === 0 && !isSearching && searchQuery.length > 2" style="text-align: center; color: var(--muted); padding: 1rem;">
                        No colleges found.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="predictor-layout">
        <div class="card" style="padding: 2rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h3 style="font-family: var(--font-heading); font-size: 1.1rem; font-weight: 700; color: var(--ink); margin: 0;">My Active Preference List</h3>
                <span x-show="isSaving" style="font-size: 0.75rem; color: var(--muted);"><i class="fa-solid fa-spinner fa-spin"></i> Saving...</span>
                <span x-show="!isSaving && choices.length > 0" style="font-size: 0.75rem; color: var(--green);"><i class="fa-solid fa-check"></i> Saved</span>
            </div>
            
            <div style="border: 1px solid var(--border); border-radius: 12px; overflow: hidden; margin-bottom: 1.5rem;" x-show="choices.length > 0">
                <div id="sortable-list">
                    <template x-for="(choice, index) in choices" :key="choice.id">
                        <div class="sortable-item" :data-id="choice.id" style="display: flex; align-items: center; padding: 1.25rem; border-bottom: 1px solid var(--border); background: var(--white); transition: background 0.2s;">
                            <div style="width: 30px; font-weight: 700; color: var(--muted-lt);" x-text="index + 1"></div>
                            <div style="flex: 1;">
                                <a :href="'{{ url('/colleges') }}/' + choice.college.slug" style="font-weight: 600; color: var(--blue); text-decoration: none;" x-text="choice.college.college_name" target="_blank"></a>
                                <div style="font-size: 0.8rem; color: var(--muted); margin-top: 2px;"><span x-text="choice.course.name"></span> · <span x-text="choice.quota"></span></div>
                            </div>
                            <button @click="removeChoice(choice.id)" style="color: #ef4444; background: transparent; border: none; cursor: pointer; padding: 0.5rem; margin-right: 0.5rem; opacity: 0.5; transition: opacity 0.2s;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.5"><i class="fa-solid fa-trash"></i></button>
                            <div class="drag-handle" style="color: var(--muted-lt); cursor: grab; padding: 0.5rem;"><i class="fa-solid fa-grip-lines"></i></div>
                        </div>
                    </template>
                </div>
            </div>

            <div x-show="choices.length === 0" style="text-align: center; padding: 3rem 1rem; border: 2px dashed var(--border); border-radius: 12px; margin-bottom: 1.5rem;">
                <div style="font-size: 2rem; color: var(--border); margin-bottom: 1rem;"><i class="fa-solid fa-list-ul"></i></div>
                <h4 style="font-size: 1rem; font-weight: 700; color: var(--ink); margin: 0 0 0.5rem 0;">Your list is empty</h4>
                <p style="font-size: 0.85rem; color: var(--muted); margin: 0 0 1.5rem 0;">Start building your preference list by adding colleges.</p>
                <button class="btn btn-outline" @click="searchModalOpen = true"><i class="fa-solid fa-search"></i> Search Colleges</button>
            </div>
            
            <button class="btn btn-outline" style="width: 100%; border-style: dashed;" @click="searchModalOpen = true" x-show="choices.length > 0"><i class="fa-solid fa-search"></i> Search and add more colleges</button>
        </div>
        
        <div>
            <div class="card predictor-sidebar" style="padding: 1.5rem; position: sticky; top: calc(var(--nav-h) + 1.5rem); background: var(--bg-soft);">
                <h3 style="font-family: var(--font-heading); font-size: 1rem; font-weight: 700; color: var(--ink); margin: 0 0 1rem 0;">List Analysis</h3>
                
                <div style="margin-bottom: 1rem;">
                    <div style="display: flex; justify-content: space-between; font-size: 0.85rem; margin-bottom: 0.5rem;">
                        <span style="color: var(--muted);">Total Choices</span>
                        <span style="font-weight: 700; color: var(--ink);" x-text="choices.length"></span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.85rem; margin-bottom: 0.5rem;">
                        <span style="color: var(--muted);">Risk Level</span>
                        <span style="font-weight: 700;" :style="choices.length < 5 ? 'color: #d97706;' : 'color: #16a34a;'" x-text="choices.length < 5 ? 'High Risk' : 'Safe'"></span>
                    </div>
                </div>
                
                <div class="alert alert-warning" style="margin: 0 0 1.5rem 0; padding: 1rem; font-size: 0.8rem;" x-show="choices.length > 0 && choices.length < 5">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <div>
                        Your list is too narrow. Consider adding more safe options below your top preferences to secure an allotment.
                    </div>
                </div>

                <div class="alert alert-success" style="margin: 0 0 1.5rem 0; padding: 1rem; font-size: 0.8rem;" x-show="choices.length >= 5">
                    <i class="fa-solid fa-circle-check"></i>
                    <div>
                        Great job! You have built a robust preference list. Make sure to review the order carefully.
                    </div>
                </div>
                
                <button class="btn btn-black" style="width: 100%; margin-bottom: 0.5rem;" :disabled="choices.length === 0" onclick="window.print()"><i class="fa-solid fa-download"></i> Export PDF</button>
            </div>
        </div>
    </div>
</div>

<script>
function choiceListBuilder(courses) {
    return {
        list: {},
        choices: [],
        courses: courses,
        selectedCourseId: courses.length > 0 ? courses[0].id : 1,
        searchModalOpen: false,
        searchQuery: '',
        searchResults: [],
        isSearching: false,
        isSaving: false,

        init() {
            this.fetchActiveList();
        },

        async fetchActiveList() {
            try {
                const response = await fetch('{{ url("/api/choice-list/active") }}');
                const data = await response.json();
                this.list = data.list;
                this.choices = data.choices;
                
                // Initialize SortableJS after Alpine updates DOM
                this.$nextTick(() => {
                    this.initSortable();
                });
            } catch (e) {
                console.error("Error fetching list:", e);
            }
        },

        initSortable() {
            const el = document.getElementById('sortable-list');
            if(el) {
                new Sortable(el, {
                    handle: '.drag-handle',
                    animation: 150,
                    ghostClass: 'bg-blue-50', // Tailwind-like color class or just rely on transparency
                    onEnd: (evt) => {
                        this.reorderChoices(evt.oldIndex, evt.newIndex);
                    }
                });
            }
        },

        reorderChoices(oldIndex, newIndex) {
            // Reorder array logically
            const movedItem = this.choices.splice(oldIndex, 1)[0];
            this.choices.splice(newIndex, 0, movedItem);
            
            // Reassign preference orders
            const newOrders = this.choices.map((choice, idx) => {
                choice.preference_order = idx + 1;
                return { id: choice.id, preference_order: choice.preference_order };
            });

            this.saveOrder(newOrders);
        },

        async saveOrder(newOrders) {
            this.isSaving = true;
            try {
                await fetch('{{ url("/api/choice-list/update-order") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ orders: newOrders })
                });
            } catch (e) {
                console.error("Failed to save order", e);
            } finally {
                this.isSaving = false;
            }
        },

        async searchColleges() {
            if (this.searchQuery.length < 2) {
                this.searchResults = [];
                return;
            }
            this.isSearching = true;
            try {
                const response = await fetch('{{ url("/api/choice-list/search") }}?q=' + encodeURIComponent(this.searchQuery));
                this.searchResults = await response.json();
            } catch (e) {
                console.error("Search failed", e);
            } finally {
                this.isSearching = false;
            }
        },

        async addChoice(collegeId) {
            this.isSaving = true;
            try {
                const response = await fetch('{{ url("/api/choice-list/store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        list_id: this.list.id,
                        college_id: collegeId,
                        course_id: this.selectedCourseId,
                        quota: 'AIQ',
                        category: 'UR'
                    })
                });
                const newChoice = await response.json();
                this.choices.push(newChoice);
                this.searchModalOpen = false;
                this.searchQuery = '';
                this.searchResults = [];
                
                // Reinitialize sortable to capture new element
                this.$nextTick(() => {
                    this.initSortable();
                });
            } catch (e) {
                console.error("Failed to add choice", e);
            } finally {
                this.isSaving = false;
            }
        },

        async removeChoice(id) {
            this.isSaving = true;
            try {
                await fetch('{{ url("/api/choice-list") }}/' + id, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                this.choices = this.choices.filter(c => c.id !== id);
                
                // Update orders of remaining items
                const newOrders = this.choices.map((choice, idx) => {
                    choice.preference_order = idx + 1;
                    return { id: choice.id, preference_order: choice.preference_order };
                });
                
                if(newOrders.length > 0) {
                    this.saveOrder(newOrders);
                } else {
                    this.isSaving = false;
                }
            } catch (e) {
                console.error("Failed to remove choice", e);
                this.isSaving = false;
            }
        }
    }
}
</script>

<style>
    .predictor-layout {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 2rem;
    }
    @media (max-width: 992px) {
        .predictor-layout {
            grid-template-columns: 1fr;
        }
        .predictor-sidebar {
            position: static !important;
        }
    }
    /* SortableJS styles */
    [x-cloak] { display: none !important; }
    .sortable-item.sortable-ghost {
        opacity: 0.4;
        background: var(--bg-soft) !important;
    }
    .sortable-item.sortable-drag {
        background: var(--white) !important;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        border-radius: 8px;
    }
    /* Simple custom scrollbar for search results */
    div::-webkit-scrollbar {
        width: 6px;
    }
    div::-webkit-scrollbar-track {
        background: transparent;
    }
    div::-webkit-scrollbar-thumb {
        background: var(--border);
        border-radius: 4px;
    }

    @media print {
        /* Hide everything by default */
        body * {
            visibility: hidden;
        }
        /* Only show the choice list container */
        #sortable-list, #sortable-list * {
            visibility: visible;
        }
        /* Position the list at the top left of the printed page */
        #sortable-list {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        /* Hide the trash icons and drag handles on the PDF */
        .fa-trash, .drag-handle, button {
            display: none !important;
        }
    }
</style>
@endsection
