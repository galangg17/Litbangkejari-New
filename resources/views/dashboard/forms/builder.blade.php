@extends('layouts.app')

@section('content')
<div style="min-height: 100vh; background: #F8FAFC; color: #0F172A; font-family: 'Plus Jakarta Sans', sans-serif;" 
     x-data="{ 
         activeStudioTab: 'questions',
         showAddComposer: false,
         selectedType: 'radio',
         hasReason: false,
         reasonLabel: 'Sebutkan alasan atau penjelasan pilihan Anda...',
         reasonTrigger: 'all',
         editingField: null,
         isEditModalOpen: false,
         searchQuestion: '',
         openEditModal(field) {
             this.editingField = JSON.parse(JSON.stringify(field));
             this.isEditModalOpen = true;
         },
         applyPreset(type) {
             this.showAddComposer = true;
             this.$nextTick(() => {
                 const catInput = document.getElementById('field_category_input');
                 const labelInput = document.getElementById('field_label_input');
                 const helpInput = document.getElementById('field_help_input');
                 const optionsInput = document.getElementById('options_raw_input');
                 const reasonLabelInput = document.getElementById('reason_label_input');
                 
                 if (type === 'identity') {
                     if (catInput) catInput.value = 'Identitas Responden';
                     labelInput.value = 'Nama Lengkap Peserta';
                     if (helpInput) helpInput.value = 'Tuliskan nama lengkap beserta gelar akademik.';
                     this.selectedType = 'text';
                     this.hasReason = false;
                     if (optionsInput) optionsInput.value = '';
                 } else if (type === 'class') {
                     if (catInput) catInput.value = 'Identitas Responden';
                     labelInput.value = 'Kelas / Kelompok Belajar';
                     if (helpInput) helpInput.value = 'Contoh: Kelas A, Kelompok II Diklat PPPJ 2026';
                     this.selectedType = 'text';
                     this.hasReason = false;
                     if (optionsInput) optionsInput.value = '';
                 } else if (type === 'eval_reason') {
                     if (catInput) catInput.value = 'Evaluasi Kurikulum & Mata Kuliah';
                     labelInput.value = 'Penyesuaian Jam Pelajaran Mata Kuliah';
                     if (helpInput) helpInput.value = 'Apakah ada mata kuliah yang menurut Anda perlu ditambah atau dikurangi jam pelajarannya? Sebutkan alasannya.';
                     this.selectedType = 'radio';
                     this.hasReason = true;
                     this.reasonLabel = 'Sebutkan alasan & mata kuliah yang Anda maksud:';
                     if (reasonLabelInput) reasonLabelInput.value = this.reasonLabel;
                     if (optionsInput) {
                         optionsInput.value = 'Perlu Ditambah Jam Pelajarannya\nPerlu Dikurangi Jam Pelajarannya\nSudah Cukup & Sesuai';
                     }
                 } else if (type === 'checkbox_eval') {
                     if (catInput) catInput.value = 'Evaluasi Kurikulum & Mata Kuliah';
                     labelInput.value = 'Mata Kuliah Yang Memerlukan Penyesuaian';
                     if (helpInput) helpInput.value = 'Pilih satu atau lebih mata kuliah yang menurut Anda perlu dievaluasi atau disesuaikan.';
                     this.selectedType = 'checkbox';
                     this.hasReason = true;
                     this.reasonLabel = 'Tuliskan alasan evaluasi untuk mata kuliah yang dipilih:';
                     if (reasonLabelInput) reasonLabelInput.value = this.reasonLabel;
                     if (optionsInput) {
                         optionsInput.value = 'PBB & Disiplin\nOlahraga & Kesamaptaan\nPemberlakuan KUHP Nasional\nPemberlakuan KUHAP 2025\nSistem Peradilan Pidana Anak\nPenanganan Tindak Pidana Cyber / AI';
                     }
                 } else if (type === 'rating_scale') {
                     if (catInput) catInput.value = 'Kualitas Pembelajaran';
                     labelInput.value = 'Tingkat Efektivitas Pembelajaran & Kurikulum';
                     if (helpInput) helpInput.value = 'Berikan penilaian obyektif Anda terhadap kurikulum dan penyampaian materi oleh pengajar.';
                     this.selectedType = 'radio';
                     this.hasReason = true;
                     this.reasonLabel = 'Tuliskan saran konstruktif perbaikan:';
                     if (reasonLabelInput) reasonLabelInput.value = this.reasonLabel;
                     if (optionsInput) {
                         optionsInput.value = '5 - Sangat Memuaskan\n4 - Memuaskan\n3 - Cukup\n2 - Kurang Memuaskan\n1 - Tidak Memuaskan';
                     }
                 }
                 labelInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                 labelInput.focus();
             });
         }
     }">

    <style>
        .studio-nav-btn {
            background: transparent;
            border: none;
            color: #64748B;
            font-weight: 800;
            font-size: 0.84375rem;
            padding: 0.6rem 1.15rem;
            border-radius: 8px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            transition: all 0.15s ease;
            font-family: inherit;
        }
        .studio-nav-btn:hover {
            color: #0F172A;
            background: #E2E8F0;
        }
        .studio-nav-btn.active {
            background: #0F172A !important;
            color: #FFFFFF !important;
            font-weight: 800 !important;
        }
        .action-tool-btn {
            background: #FFFFFF;
            border: 1px solid #CBD5E1;
            color: #475569;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0.35rem 0.65rem;
            border-radius: 6px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            transition: all 0.15s ease;
            text-decoration: none;
        }
        .action-tool-btn:hover {
            background: #F8FAFC;
            border-color: #94A3B8;
            color: #0F172A;
        }
        .action-tool-btn:disabled {
            opacity: 0.35;
            cursor: not-allowed;
        }
        .options-chip-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 0.4rem;
            max-height: 200px;
            overflow-y: auto;
            padding: 0.25rem;
        }
        .options-chip-item {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            padding: 0.35rem 0.65rem;
            border-radius: 6px;
            font-size: 0.8125rem;
            color: #334155;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.45rem;
        }
        .studio-modal-backdrop {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            z-index: 999999 !important;
            background: rgba(15, 23, 42, 0.65) !important;
            backdrop-filter: blur(6px) !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 1.5rem !important;
            box-sizing: border-box !important;
        }
        .studio-modal-card {
            background: #FFFFFF !important;
            width: 100% !important;
            max-width: 620px !important;
            max-height: 90vh !important;
            overflow-y: auto !important;
            border-radius: 16px !important;
            border: 1px solid #CBD5E1 !important;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3) !important;
            padding: 1.75rem !important;
            margin: auto !important;
            position: relative !important;
            box-sizing: border-box !important;
        }
    </style>

    <!-- 1. TOP STUDIO HEADER (SOPHISTICATED DARK SLATE & MUTED ACCENT) -->
    <header style="background: #072718; border-bottom: 2px solid #D4AF37; padding: 1.15rem 2rem; color: #FFF; box-shadow: 0 4px 15px rgba(0,0,0,0.15);">
        <div style="max-width: 1100px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            
            <div style="display: flex; align-items: center; gap: 0.85rem;">
                <a href="{{ route('dashboard.index', ['tab' => 'custom_forms']) }}" 
                   style="background: rgba(255,255,255,0.1); color: #D4AF37; border: 1px solid rgba(212,175,55,0.3); text-decoration: none; font-size: 1rem; width: 38px; height: 38px; border-radius: 8px; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease;">
                    ←
                </a>
                <div>
                    <div style="font-size: 0.6875rem; color: #D4AF37; font-weight: 800; letter-spacing: 0.05em; text-transform: uppercase;">
                        STUDIO PENGELOLA FORMULIR & KUESIONER
                    </div>
                    <h1 style="font-size: 1.25rem; font-weight: 800; margin: 0.15rem 0 0; color: #FFF;">
                        {{ $form->title }}
                    </h1>
                </div>
            </div>

            <div style="display: flex; align-items: center; gap: 0.6rem; flex-wrap: wrap;">
                <a href="{{ route('forms.show', $form->slug) }}" target="_blank" 
                   style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.25); color: #FFF; font-size: 0.8125rem; font-weight: 700; padding: 0.5rem 1rem; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.35rem;">
                    👁️ Pratinjau Publik
                </a>
                <a href="{{ route('dashboard.forms.responses', $form->id) }}" 
                   style="background: #15803D; color: #FFF; font-size: 0.8125rem; font-weight: 800; padding: 0.5rem 1.15rem; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.35rem;">
                    📊 Rekap Respon ({{ $form->responses()->count() }})
                </a>
            </div>

        </div>
    </header>

    @if(session('toast'))
        <div style="max-width: 1100px; margin: 1.25rem auto 0; padding: 0 1.5rem;">
            <div style="background: #F0FDF4; border: 1px solid #86EFAC; color: #166534; font-weight: 700; font-size: 0.875rem; padding: 0.75rem 1.15rem; border-radius: 10px; display: flex; align-items: center; gap: 0.5rem;">
                <span>✨</span>
                <span>{{ session('toast') }}</span>
            </div>
        </div>
    @endif

    <!-- 2. STUDIO TABS NAVIGATION -->
    <div style="background: #FFFFFF; border-bottom: 1px solid #E2E8F0; padding: 0.5rem 1.5rem;">
        <div style="max-width: 1100px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem;">
            
            <div style="display: inline-flex; background: #F1F5F9; padding: 0.25rem; border-radius: 8px; gap: 0.25rem;">
                <button type="button" 
                        @click="activeStudioTab = 'questions'" 
                        class="studio-nav-btn" 
                        :class="{ 'active': activeStudioTab === 'questions' }">
                    <span>📝</span>
                    <span>Daftar Pertanyaan ({{ $form->fields->count() }})</span>
                </button>
                <button type="button" 
                        @click="activeStudioTab = 'settings'" 
                        class="studio-nav-btn" 
                        :class="{ 'active': activeStudioTab === 'settings' }">
                    <span>⚙️</span>
                    <span>Pengaturan Formulir</span>
                </button>
            </div>

            <!-- TOGGLE COMPOSER BUTTON -->
            <button type="button" 
                    @click="showAddComposer = !showAddComposer" 
                    style="background: #072718; color: #D4AF37; font-weight: 800; font-size: 0.8125rem; padding: 0.5rem 1.15rem; border-radius: 8px; border: 1px solid #C59B27; cursor: pointer; display: inline-flex; align-items: center; gap: 0.35rem;">
                <span x-text="showAddComposer ? '▲ Tutup Panel Input' : '➕ Tambah Pertanyaan Baru'"></span>
            </button>

        </div>
    </div>

    <!-- 3. MAIN WORKSPACE CONTAINER -->
    <main style="max-width: 1100px; margin: 1.5rem auto 5rem; padding: 0 1.5rem;">

        <!-- ============================================================== -->
        <!-- TAB 1: PERTANYAAN KUESIONER                                     -->
        <!-- ============================================================== -->
        <div x-show="activeStudioTab === 'questions'">

            <!-- 1.1 COMPOSER PANEL (TAMBAH PERTANYAAN BARU) -->
            <div x-show="showAddComposer" 
                 x-transition
                 style="background: #FFFFFF; border: 1.5px solid #CBD5E1; border-radius: 14px; padding: 1.5rem; margin-bottom: 1.75rem; box-shadow: 0 4px 15px rgba(0,0,0,0.04);">
                
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; border-bottom: 1px solid #F1F5F9; padding-bottom: 0.75rem;">
                    <div>
                        <h3 style="font-size: 1.05rem; font-weight: 800; color: #0F172A; margin: 0;">
                            Tambah Pertanyaan Kuesioner Baru
                        </h3>
                        <div style="font-size: 0.75rem; color: #64748B; margin-top: 0.15rem;">
                            Tentukan kategori, judul pertanyaan, dan detail penjelasan soal.
                        </div>
                    </div>
                    <button type="button" @click="showAddComposer = false" style="background: #F1F5F9; border: none; width: 28px; height: 28px; border-radius: 6px; font-size: 0.9rem; cursor: pointer; color: #64748B;">✕</button>
                </div>

                <!-- PRESET TEMPLATES (CALM TONES) -->
                <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; padding: 0.75rem; margin-bottom: 1.25rem;">
                    <div style="font-size: 0.7rem; font-weight: 800; color: #475569; text-transform: uppercase; margin-bottom: 0.4rem;">
                        ⚡ Template Cepat 1-Klik:
                    </div>
                    <div style="display: flex; gap: 0.4rem; flex-wrap: wrap;">
                        <button type="button" @click="applyPreset('identity')" style="background: #FFF; border: 1px solid #CBD5E1; color: #334155; font-size: 0.75rem; font-weight: 700; padding: 0.35rem 0.75rem; border-radius: 6px; cursor: pointer;">
                            👤 Nama Peserta
                        </button>
                        <button type="button" @click="applyPreset('class')" style="background: #FFF; border: 1px solid #CBD5E1; color: #334155; font-size: 0.75rem; font-weight: 700; padding: 0.35rem 0.75rem; border-radius: 6px; cursor: pointer;">
                            🏛️ Kelas / Kelompok
                        </button>
                        <button type="button" @click="applyPreset('eval_reason')" style="background: #FFF; border: 1px solid #CBD5E1; color: #334155; font-size: 0.75rem; font-weight: 800; padding: 0.35rem 0.75rem; border-radius: 6px; cursor: pointer;">
                            💬 Evaluasi Jam MK + Alasan
                        </button>
                        <button type="button" @click="applyPreset('checkbox_eval')" style="background: #FFF; border: 1px solid #CBD5E1; color: #334155; font-size: 0.75rem; font-weight: 700; padding: 0.35rem 0.75rem; border-radius: 6px; cursor: pointer;">
                            ☑️ Multi-Pilih MK (Checkbox)
                        </button>
                        <button type="button" @click="applyPreset('rating_scale')" style="background: #FFF; border: 1px solid #CBD5E1; color: #334155; font-size: 0.75rem; font-weight: 700; padding: 0.35rem 0.75rem; border-radius: 6px; cursor: pointer;">
                            ⭐ Rating Kepuasan 1-5
                        </button>
                    </div>
                </div>

                <!-- ADD FORM -->
                <form action="{{ route('dashboard.forms.fields.store', $form->id) }}" method="POST" style="display: flex; flex-direction: column; gap: 1rem;">
                    @csrf

                    <!-- 1. KATEGORI PERTANYAAN -->
                    <div>
                        <label style="font-size: 0.78125rem; font-weight: 800; color: #334155; display: block; margin-bottom: 0.35rem;">
                            Kategori / Bagian Pertanyaan (Opsional)
                        </label>
                        <input type="text" id="field_category_input" name="category" placeholder="Contoh: Identitas Peserta, Evaluasi Kurikulum, Kualitas Pembelajaran, atau Saran" style="width: 100%; background: #F8FAFC; border: 1px solid #CBD5E1; border-radius: 8px; padding: 0.55rem 0.75rem; font-size: 0.84375rem; outline: none;" />
                        <div style="font-size: 0.71875rem; color: #64748B; margin-top: 0.2rem;">
                            Digunakan untuk mengelompokkan butir soal agar rapi dan terstruktur.
                        </div>
                    </div>

                    <!-- 2. JUDUL BESAR PERTANYAAN -->
                    <div>
                        <label style="font-size: 0.78125rem; font-weight: 800; color: #0F172A; display: block; margin-bottom: 0.35rem;">
                            Judul Besar Pertanyaan / Label Soal *
                        </label>
                        <input type="text" id="field_label_input" name="field_label" placeholder="Contoh: Penyesuaian Jam Pelajaran Mata Kuliah" required style="width: 100%; background: #FFFFFF; border: 1.5px solid #94A3B8; border-radius: 8px; padding: 0.6rem 0.85rem; font-size: 0.90625rem; font-weight: 700; outline: none; font-family: inherit;" />
                    </div>

                    <!-- 3. DETAIL / URAIAN PERTANYAAN -->
                    <div>
                        <label style="font-size: 0.78125rem; font-weight: 800; color: #334155; display: block; margin-bottom: 0.35rem;">
                            Detail / Uraian Pertanyaan (Opsional)
                        </label>
                        <textarea id="field_help_input" name="help_text" rows="2" placeholder="Contoh: Apakah ada mata kuliah yang menurut Anda perlu ditambah atau dikurangi jam pelajarannya? Sebutkan alasannya." style="width: 100%; background: #F8FAFC; border: 1px solid #CBD5E1; border-radius: 8px; padding: 0.55rem 0.75rem; font-size: 0.84375rem; outline: none; font-family: inherit; line-height: 1.5;"></textarea>
                        <div style="font-size: 0.71875rem; color: #64748B; margin-top: 0.2rem;">
                            Penjelasan rinci atau sub-pertanyaan yang muncul tepat di bawah judul pertanyaan.
                        </div>
                    </div>

                    <!-- 4. TIPE JAWABAN -->
                    <div>
                        <label style="font-size: 0.78125rem; font-weight: 800; color: #334155; display: block; margin-bottom: 0.35rem;">
                            Tipe Jawaban Responden *
                        </label>
                        <select name="field_type" x-model="selectedType" required style="width: 100%; background: #F8FAFC; border: 1px solid #CBD5E1; border-radius: 8px; padding: 0.55rem 0.75rem; font-size: 0.84375rem; outline: none; font-weight: 700; cursor: pointer;">
                            <option value="radio">🔘 Pilihan Ganda (Satu Pilihan)</option>
                            <option value="checkbox">☑️ Kotak Centang (Bisa Pilih Banyak)</option>
                            <option value="select">🔽 Dropdown Pilihan</option>
                            <option value="text">✏️ Jawaban Singkat (Text Pendek)</option>
                            <option value="textarea">📝 Paragraf Panjang (Uraian)</option>
                            <option value="file">📎 Unggah Berkas / Dokumen / Foto</option>
                            <option value="date">📅 Tanggal (Date)</option>
                            <option value="number">🔢 Angka / Nilai (Number)</option>
                        </select>
                    </div>

                    <!-- OPSIONAL PILIHAN OPSI (UNTUK RADIO, SELECT, CHECKBOX) -->
                    <div x-show="['radio', 'checkbox', 'select'].includes(selectedType)" 
                         x-transition
                         style="background: #F8FAFC; border: 1px solid #CBD5E1; border-radius: 10px; padding: 0.85rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.35rem;">
                            <label style="font-size: 0.78125rem; font-weight: 800; color: #0F172A;">
                                Daftar Pilihan Jawaban (Tulis 1 pilihan per baris):
                            </label>
                            <span style="font-size: 0.71875rem; color: #64748B;">Enter = baris baru</span>
                        </div>
                        <textarea id="options_raw_input" name="options_raw" rows="4" placeholder="Perlu Ditambah Jam Pelajarannya&#10;Perlu Dikurangi Jam Pelajarannya&#10;Sudah Cukup & Sesuai" style="width: 100%; background: #FFF; border: 1px solid #CBD5E1; border-radius: 8px; padding: 0.55rem 0.75rem; font-size: 0.84375rem; outline: none; font-family: inherit; line-height: 1.5;"></textarea>
                    </div>

                    <!-- FITUR KOTAK ALASAN / PENJELASAN TAMBAHAN (SOOTHING TEAL/SLATE) -->
                    <div x-show="['radio', 'checkbox', 'select', 'textarea', 'text'].includes(selectedType)"
                         x-transition
                         style="background: #F8FAFC; border: 1px solid #CBD5E1; border-left: 3px solid #0F766E; border-radius: 8px; padding: 0.85rem 1rem;">
                        <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.8125rem; font-weight: 800; color: #0F766E; cursor: pointer;">
                            <input type="checkbox" name="has_reason" value="1" x-model="hasReason" style="width: 16px; height: 16px; accent-color: #0F766E; cursor: pointer;" />
                            <span>💬 Tambahkan Kolom Alasan / Penjelasan Otomatis</span>
                        </label>
                        <div style="font-size: 0.72rem; color: #64748B; margin-top: 0.2rem; line-height: 1.4;">
                            Bila diaktifkan, responden dapat mengisi uraian alasan atau pertimbangan pilihannya.
                        </div>

                        <div x-show="hasReason" style="margin-top: 0.65rem;">
                            <label style="font-size: 0.75rem; font-weight: 700; color: #334155; display: block; margin-bottom: 0.25rem;">
                                Petunjuk Isian Kolom Alasan:
                            </label>
                            <input type="text" id="reason_label_input" name="reason_label" x-model="reasonLabel" placeholder="Contoh: Sebutkan alasan atau penjelasan pilihan Anda:" style="width: 100%; background: #FFF; border: 1px solid #CBD5E1; border-radius: 6px; padding: 0.45rem 0.65rem; font-size: 0.8125rem; outline: none;" />
                        </div>
                    </div>

                    <div style="display: flex; align-items: center; justify-content: space-between; border-top: 1px solid #E2E8F0; padding-top: 0.85rem;">
                        <label style="display: flex; align-items: center; gap: 0.45rem; font-size: 0.8125rem; font-weight: 700; color: #0F172A; cursor: pointer;">
                            <input type="checkbox" name="is_required" value="1" checked style="width: 16px; height: 16px; accent-color: #0F172A; cursor: pointer;" />
                            <span>Wajib Diisi (Required *)</span>
                        </label>

                        <div style="display: flex; gap: 0.5rem;">
                            <button type="button" @click="showAddComposer = false" style="background: #F1F5F9; border: 1px solid #CBD5E1; color: #475569; font-weight: 700; font-size: 0.8125rem; padding: 0.55rem 1rem; border-radius: 8px; cursor: pointer;">
                                Tutup
                            </button>
                            <button type="submit" style="background: #072718; color: #D4AF37; font-weight: 800; font-size: 0.8125rem; padding: 0.55rem 1.25rem; border-radius: 8px; border: 1px solid #C59B27; cursor: pointer; display: inline-flex; align-items: center; gap: 0.35rem;">
                                ➕ Simpan ke Kuesioner
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- 1.2 QUESTION CARDS LIST (CLEAN, MUTED, EYE-FRIENDLY) -->
            <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 1.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; border-bottom: 1px solid #F1F5F9; padding-bottom: 0.85rem; flex-wrap: wrap; gap: 0.75rem;">
                    <div>
                        <div style="font-size: 0.6875rem; font-weight: 800; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em;">
                            STRUKTUR INSTRUMEN KUESIONER
                        </div>
                        <h2 style="font-size: 1.15rem; font-weight: 800; color: #0F172A; margin: 0.15rem 0 0;">
                            Daftar Pertanyaan ({{ $form->fields->count() }} Butir Soal)
                        </h2>
                    </div>

                    <!-- SEARCH FILTER & ADD SHORTCUT -->
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <input type="text" x-model="searchQuestion" placeholder="🔍 Cari butir pertanyaan..." style="background: #F8FAFC; border: 1px solid #CBD5E1; border-radius: 8px; padding: 0.4rem 0.75rem; font-size: 0.8125rem; outline: none; width: 220px;" />
                        <button type="button" @click="showAddComposer = true; window.scrollTo({ top: 120, behavior: 'smooth' })" style="background: #072718; color: #D4AF37; font-weight: 800; font-size: 0.78125rem; padding: 0.45rem 0.95rem; border-radius: 8px; border: 1px solid #C59B27; cursor: pointer; display: inline-flex; align-items: center; gap: 0.35rem;">
                            ➕ Tambah
                        </button>
                    </div>
                </div>

                @if($form->fields->isEmpty())
                    <!-- EMPTY STATE -->
                    <div style="text-align: center; padding: 3.5rem 1.5rem; color: #94A3B8; border: 2px dashed #CBD5E1; border-radius: 12px; background: #F8FAFC;">
                        <div style="font-size: 3rem; margin-bottom: 0.5rem;">📝</div>
                        <div style="font-weight: 800; font-size: 1.05rem; color: #334155; margin-bottom: 0.25rem;">Belum Ada Pertanyaan di Formulir Ini</div>
                        <div style="font-size: 0.8125rem; max-width: 440px; margin: 0 auto 1.25rem; line-height: 1.5;">
                            Gunakan tombol <strong>+ Tambah Pertanyaan Baru</strong> di atas untuk mulai menyusun butir soal kuesioner.
                        </div>
                        <button type="button" @click="applyPreset('eval_reason')" style="background: #072718; color: #D4AF37; font-weight: 800; font-size: 0.8125rem; padding: 0.55rem 1.15rem; border-radius: 8px; border: 1px solid #C59B27; cursor: pointer;">
                            ✨ Isi Contoh Pertanyaan + Alasan
                        </button>
                    </div>
                @else
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        @foreach($form->fields as $index => $field)
                            @php
                                $type = strtolower($field->field_type);
                                $optCount = !empty($field->options) ? count($field->options) : 0;
                            @endphp

                            <div x-show="!searchQuestion || '{{ strtolower(addslashes($field->field_label . ' ' . $field->category . ' ' . $field->help_text)) }}'.includes(searchQuestion.toLowerCase())"
                                 style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 12px; padding: 1.25rem 1.4rem; transition: all 0.15s ease; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                                
                                <!-- TOP ROW: NUMBER, CATEGORY, TYPE, REQUIRED, REASON BADGES & ACTION BUTTONS -->
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.65rem; flex-wrap: wrap; gap: 0.5rem;">
                                    
                                    <div style="display: flex; align-items: center; gap: 0.45rem; flex-wrap: wrap;">
                                        <!-- NUMBER BADGE (SUBTLE SLATE PILL) -->
                                        <span style="background: #0F172A; color: #FFFFFF; font-weight: 800; font-size: 0.72rem; padding: 0.18rem 0.55rem; border-radius: 6px;">
                                            #{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                        </span>

                                        <!-- CATEGORY BADGE (IF SET) -->
                                        @if(!empty($field->category))
                                            <span style="font-size: 0.7rem; font-weight: 800; color: #047857; background: #F0FDF4; border: 1px solid #BBF7D0; padding: 0.18rem 0.55rem; border-radius: 6px; display: inline-flex; align-items: center; gap: 0.25rem;">
                                                <span>📁</span>
                                                <span>{{ $field->category }}</span>
                                            </span>
                                        @endif

                                        <!-- TYPE PILL (MUTED SLATE) -->
                                        <span style="font-size: 0.7rem; font-weight: 700; color: #475569; background: #F1F5F9; border: 1px solid #E2E8F0; padding: 0.18rem 0.55rem; border-radius: 6px;">
                                            @if($type === 'radio') Pilihan Ganda
                                            @elseif($type === 'checkbox') Kotak Centang
                                            @elseif($type === 'select') Dropdown
                                            @elseif($type === 'text') Jawaban Singkat
                                            @elseif($type === 'textarea') Paragraf / Uraian
                                            @elseif($type === 'file') Berkas
                                            @elseif($type === 'date') Tanggal
                                            @elseif($type === 'number') Angka
                                            @else {{ strtoupper($type) }}
                                            @endif
                                        </span>

                                        @if($field->is_required)
                                            <span style="font-size: 0.6875rem; font-weight: 700; color: #DC2626; background: #FEF2F2; border: 1px solid #FEE2E2; padding: 0.18rem 0.5rem; border-radius: 6px;">
                                                * Wajib
                                            </span>
                                        @endif

                                        @if($field->has_reason)
                                            <span style="font-size: 0.6875rem; font-weight: 700; color: #0F766E; background: #F0FDFA; border: 1px solid #CCFBF1; padding: 0.18rem 0.5rem; border-radius: 6px; display: inline-flex; align-items: center; gap: 0.2rem;">
                                                <span>💬</span>
                                                <span>Kolom Alasan</span>
                                            </span>
                                        @endif
                                    </div>

                                    <!-- ACTION TOOLBAR -->
                                    <div style="display: flex; align-items: center; gap: 0.3rem;">
                                        <!-- MOVE UP -->
                                        <form action="{{ route('dashboard.forms.fields.move', [$field->id, 'up']) }}" method="POST" style="margin: 0;">
                                            @csrf
                                            <button type="submit" {{ $index === 0 ? 'disabled' : '' }} class="action-tool-btn" title="Pindahkan ke Atas">
                                                ▲
                                            </button>
                                        </form>

                                        <!-- MOVE DOWN -->
                                        <form action="{{ route('dashboard.forms.fields.move', [$field->id, 'down']) }}" method="POST" style="margin: 0;">
                                            @csrf
                                            <button type="submit" {{ $loop->last ? 'disabled' : '' }} class="action-tool-btn" title="Pindahkan ke Bawah">
                                                ▼
                                            </button>
                                        </form>

                                        <!-- EDIT -->
                                        <button type="button" @click="openEditModal({{ json_encode($field) }})" class="action-tool-btn" style="border-color: #94A3B8; color: #0F172A; font-weight: 800;">
                                            ✏️ Edit
                                        </button>

                                        <!-- DUPLICATE -->
                                        <form action="{{ route('dashboard.forms.fields.duplicate', $field->id) }}" method="POST" style="margin: 0;">
                                            @csrf
                                            <button type="submit" class="action-tool-btn" title="Duplikat Pertanyaan">
                                                📋 Salin
                                            </button>
                                        </form>

                                        <!-- DELETE -->
                                        <form action="{{ route('dashboard.forms.fields.destroy', $field->id) }}" method="POST" onsubmit="return confirm('Hapus pertanyaan ini dari kuesioner?')" style="margin: 0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-tool-btn" style="border-color: #FECACA; color: #DC2626; background: #FFF5F5;" title="Hapus Pertanyaan">
                                                🗑️
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <!-- QUESTION HEADLINE & DETAIL DESCRIPTION -->
                                <div style="margin: 0.4rem 0 0.5rem;">
                                    <h3 style="font-size: 1.05rem; font-weight: 800; color: #0F172A; line-height: 1.4; margin: 0 0 0.25rem;">
                                        {{ $field->field_label }}
                                    </h3>

                                    @if($field->help_text)
                                        <div style="font-size: 0.84375rem; color: #475569; line-height: 1.5; font-weight: 500;">
                                            {{ $field->help_text }}
                                        </div>
                                    @endif
                                </div>

                                <!-- OPTIONS PREVIEW (CLEAN COMPACT CHIP GRID) -->
                                @if(!empty($field->options))
                                    <div style="margin-top: 0.65rem; background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 8px; padding: 0.75rem 0.85rem;">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.4rem;">
                                            <span style="font-size: 0.7rem; font-weight: 700; color: #64748B; text-transform: uppercase;">
                                                Pilihan Responden ({{ $optCount }} Opsi):
                                            </span>
                                            @if($optCount > 6)
                                                <span style="font-size: 0.7rem; color: #0284C7; font-weight: 600;">
                                                    Scroll untuk opsi lainnya ↓
                                                </span>
                                            @endif
                                        </div>

                                        <div class="options-chip-grid">
                                            @foreach($field->options as $optIndex => $opt)
                                                @php $cleanOpt = ltrim(trim($opt), "• -*\t "); @endphp
                                                <div class="options-chip-item">
                                                    <span style="color: #94A3B8; font-size: 0.7rem; font-weight: 700; min-width: 18px;">{{ $optIndex + 1 }}.</span>
                                                    <span>{{ $cleanOpt }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- REASON CALLOUT (CALM TEAL ACCENT, NO NEON DASHED BORDERS) -->
                                @if($field->has_reason)
                                    <div style="margin-top: 0.65rem; background: #F8FAFC; border: 1px solid #E2E8F0; border-left: 3px solid #0F766E; border-radius: 6px; padding: 0.5rem 0.85rem; display: flex; align-items: center; gap: 0.45rem; font-size: 0.8125rem; color: #334155;">
                                        <span style="font-size: 0.95rem;">💬</span>
                                        <div>
                                            <strong style="color: #0F766E;">Kolom Alasan Tambahan:</strong> "{{ $field->reason_label ?? 'Sebutkan alasan atau penjelasan pilihan Anda...' }}"
                                        </div>
                                    </div>
                                @endif

                            </div>
                        @endforeach
                    </div>
                @endif

            </div>

        </div>

        <!-- ============================================================== -->
        <!-- TAB 2: PENGATURAN & IDENTITAS FORMULIR                          -->
        <!-- ============================================================== -->
        <div x-show="activeStudioTab === 'settings'" style="display: none;">
            <div style="background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 16px; padding: 1.75rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                
                <div style="border-bottom: 1px solid #F1F5F9; padding-bottom: 0.85rem; margin-bottom: 1.35rem;">
                    <span style="font-size: 0.6875rem; font-weight: 800; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em;">KONFIGURASI FORMULIR</span>
                    <h2 style="font-size: 1.2rem; font-weight: 800; color: #0F172A; margin: 0.2rem 0 0;">
                        Pengaturan & Identitas Kuesioner
                    </h2>
                    <p style="font-size: 0.8125rem; color: #64748B; margin: 0.25rem 0 0;">
                        Kelola judul kuesioner, petunjuk pengisian, batas waktu, dan pesan terima kasih setelah pengisian.
                    </p>
                </div>

                <form action="{{ route('dashboard.forms.update', $form->id) }}" method="POST" style="display: flex; flex-direction: column; gap: 1.25rem; max-width: 760px;">
                    @csrf
                    @method('PUT')

                    <div>
                        <label style="font-size: 0.8125rem; font-weight: 700; color: #0F172A; display: block; margin-bottom: 0.35rem;">
                            Judul Formulir Kuesioner *
                        </label>
                        <input type="text" name="title" value="{{ $form->title }}" required style="width: 100%; background: #F8FAFC; border: 1px solid #CBD5E1; border-radius: 8px; padding: 0.6rem 0.85rem; font-size: 0.875rem; font-weight: 700; outline: none;" />
                    </div>

                    <div>
                        <label style="font-size: 0.8125rem; font-weight: 700; color: #0F172A; display: block; margin-bottom: 0.35rem;">
                            Deskripsi / Petunjuk Pengisian untuk Responden
                        </label>
                        <textarea name="description" rows="3" style="width: 100%; background: #F8FAFC; border: 1px solid #CBD5E1; border-radius: 8px; padding: 0.6rem 0.85rem; font-size: 0.84375rem; outline: none; line-height: 1.5; font-family: inherit;">{{ $form->description }}</textarea>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div>
                            <label style="font-size: 0.8125rem; font-weight: 700; color: #0F172A; display: block; margin-bottom: 0.35rem;">
                                Status Penerimaan Respon
                            </label>
                            <select name="status" style="width: 100%; background: #F8FAFC; border: 1px solid #CBD5E1; border-radius: 8px; padding: 0.6rem 0.85rem; font-size: 0.84375rem; outline: none; font-weight: 700; cursor: pointer;">
                                <option value="open" {{ $form->status === 'open' ? 'selected' : '' }}>🟢 Buka (Menerima Tanggapan)</option>
                                <option value="closed" {{ $form->status === 'closed' ? 'selected' : '' }}>🔴 Ditutup (Tidak Menerima Tanggapan)</option>
                            </select>
                        </div>
                        <div>
                            <label style="font-size: 0.8125rem; font-weight: 700; color: #0F172A; display: block; margin-bottom: 0.35rem;">
                                Tenggat Waktu Penutupan (Opsional)
                            </label>
                            <input type="datetime-local" name="deadline_at" value="{{ $form->deadline_at ? $form->deadline_at->format('Y-m-d\TH:i') : '' }}" style="width: 100%; background: #F8FAFC; border: 1px solid #CBD5E1; border-radius: 8px; padding: 0.6rem 0.85rem; font-size: 0.8125rem; outline: none;" />
                        </div>
                    </div>

                    <div>
                        <label style="font-size: 0.8125rem; font-weight: 700; color: #0F172A; display: block; margin-bottom: 0.35rem;">
                            Pesan Sukses Setelah Mengisi (Thank You Message)
                        </label>
                        <input type="text" name="success_message" value="{{ $form->success_message }}" placeholder="Tanggapan Anda telah berhasil disimpan. Terima Kasih." style="width: 100%; background: #F8FAFC; border: 1px solid #CBD5E1; border-radius: 8px; padding: 0.6rem 0.85rem; font-size: 0.84375rem; outline: none;" />
                    </div>

                    <div style="border-top: 1px solid #F1F5F9; padding-top: 1.15rem;">
                        <button type="submit" style="background: #072718; color: #D4AF37; font-weight: 800; font-size: 0.84375rem; padding: 0.65rem 1.5rem; border-radius: 8px; border: 1px solid #C59B27; cursor: pointer;">
                            💾 Simpan Perubahan Pengaturan
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </main>

    <!-- MODAL EDIT PERTANYAAN -->
    <div x-show="isEditModalOpen" 
         x-cloak
         class="studio-modal-backdrop"
         @keydown.escape.window="isEditModalOpen = false"
         @click="isEditModalOpen = false">
        
        <div class="studio-modal-card" 
             @click.stop>
            
            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #F1F5F9; padding-bottom: 0.75rem; margin-bottom: 1.15rem;">
                <div>
                    <h3 style="font-size: 1.1rem; font-weight: 800; color: #0F172A; margin: 0;">
                        Edit Butir Pertanyaan
                    </h3>
                    <div style="font-size: 0.75rem; color: #64748B;">Sesuaikan kategori, judul, dan detail pertanyaan</div>
                </div>
                <button type="button" @click="isEditModalOpen = false" style="background: #F1F5F9; border: none; width: 28px; height: 28px; border-radius: 6px; font-size: 0.9rem; cursor: pointer; color: #64748B;">✕</button>
            </div>

            <template x-if="editingField">
                <form :action="'/dashboard/forms/fields/' + editingField.id + '/update'" method="POST" style="display: flex; flex-direction: column; gap: 1rem;">
                    @csrf
                    @method('PUT')

                    <!-- KATEGORI PERTANYAAN -->
                    <div>
                        <label style="font-size: 0.78125rem; font-weight: 700; color: #334155; display: block; margin-bottom: 0.35rem;">
                            Kategori / Bagian Pertanyaan (Opsional)
                        </label>
                        <input type="text" name="category" x-model="editingField.category" placeholder="Contoh: Identitas Peserta, Evaluasi Kurikulum, dll." style="width: 100%; background: #F8FAFC; border: 1px solid #CBD5E1; border-radius: 8px; padding: 0.55rem 0.75rem; font-size: 0.84375rem; outline: none;" />
                    </div>

                    <!-- JUDUL BESAR PERTANYAAN -->
                    <div>
                        <label style="font-size: 0.78125rem; font-weight: 800; color: #0F172A; display: block; margin-bottom: 0.35rem;">
                            Judul Besar Pertanyaan / Label Soal *
                        </label>
                        <input type="text" name="field_label" x-model="editingField.field_label" required style="width: 100%; background: #FFFFFF; border: 1.5px solid #94A3B8; border-radius: 8px; padding: 0.6rem 0.85rem; font-size: 0.90625rem; font-weight: 700; outline: none; font-family: inherit;" />
                    </div>

                    <!-- DETAIL / URAIAN PERTANYAAN -->
                    <div>
                        <label style="font-size: 0.78125rem; font-weight: 700; color: #334155; display: block; margin-bottom: 0.35rem;">
                            Detail / Uraian Pertanyaan (Opsional)
                        </label>
                        <textarea name="help_text" rows="2" x-model="editingField.help_text" placeholder="Detail penjelasan pertanyaan..." style="width: 100%; background: #F8FAFC; border: 1px solid #CBD5E1; border-radius: 8px; padding: 0.55rem 0.75rem; font-size: 0.84375rem; outline: none; font-family: inherit; line-height: 1.5;"></textarea>
                    </div>

                    <!-- TIPE JAWABAN -->
                    <div>
                        <label style="font-size: 0.78125rem; font-weight: 700; color: #334155; display: block; margin-bottom: 0.35rem;">
                            Tipe Jawaban *
                        </label>
                        <select name="field_type" x-model="editingField.field_type" required style="width: 100%; background: #F8FAFC; border: 1px solid #CBD5E1; border-radius: 8px; padding: 0.55rem 0.75rem; font-size: 0.84375rem; outline: none; font-weight: 700; cursor: pointer;">
                            <option value="radio">🔘 Pilihan Ganda (Radio Button)</option>
                            <option value="checkbox">☑️ Kotak Centang (Multi-pilih)</option>
                            <option value="select">🔽 Dropdown Pilihan</option>
                            <option value="text">✏️ Jawaban Singkat (Text)</option>
                            <option value="textarea">📝 Paragraf Panjang (Textarea)</option>
                            <option value="file">📎 Unggah Berkas / File</option>
                            <option value="date">📅 Tanggal (Date)</option>
                            <option value="number">🔢 Angka (Number)</option>
                        </select>
                    </div>

                    <!-- OPSIONAL PILIHAN OPSI DI MODAL EDIT -->
                    <div x-show="['radio', 'checkbox', 'select'].includes(editingField.field_type)" style="background: #F8FAFC; border: 1px solid #CBD5E1; border-radius: 10px; padding: 0.85rem;">
                        <label style="font-size: 0.78125rem; font-weight: 700; color: #0F172A; display: block; margin-bottom: 0.35rem;">
                            Daftar Pilihan Jawaban (Tulis 1 pilihan per baris):
                        </label>
                        <textarea name="options_raw" rows="5" :value="editingField.options ? editingField.options.join('\n') : ''" placeholder="Opsi 1&#10;Opsi 2&#10;Opsi 3" style="width: 100%; background: #FFF; border: 1px solid #CBD5E1; border-radius: 8px; padding: 0.55rem 0.75rem; font-size: 0.84375rem; outline: none; font-family: inherit; line-height: 1.5;"></textarea>
                    </div>

                    <!-- FITUR KOTAK ALASAN DI MODAL EDIT -->
                    <div x-show="['radio', 'checkbox', 'select', 'textarea', 'text'].includes(editingField.field_type)" style="background: #F8FAFC; border: 1px solid #CBD5E1; border-left: 3px solid #0F766E; border-radius: 8px; padding: 0.85rem;">
                        <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.8125rem; font-weight: 700; color: #0F766E; cursor: pointer;">
                            <input type="checkbox" name="has_reason" value="1" x-model="editingField.has_reason" style="width: 16px; height: 16px; accent-color: #0F766E; cursor: pointer;" />
                            <span>💬 Aktifkan Kolom Alasan / Penjelasan Otomatis</span>
                        </label>
                        <div x-show="editingField.has_reason" style="margin-top: 0.65rem;">
                            <label style="font-size: 0.75rem; font-weight: 700; color: #334155; display: block; margin-bottom: 0.25rem;">
                                Petunjuk Kolom Alasan:
                            </label>
                            <input type="text" name="reason_label" x-model="editingField.reason_label" placeholder="Contoh: Sebutkan alasan atau penjelasan pilihan Anda:" style="width: 100%; background: #FFF; border: 1px solid #CBD5E1; border-radius: 6px; padding: 0.45rem 0.65rem; font-size: 0.8125rem; outline: none;" />
                        </div>
                    </div>

                    <div style="display: flex; align-items: center; justify-content: space-between; border-top: 1px solid #F1F5F9; padding-top: 0.85rem;">
                        <label style="display: flex; align-items: center; gap: 0.45rem; font-size: 0.8125rem; font-weight: 700; color: #0F172A; cursor: pointer;">
                            <input type="checkbox" name="is_required" value="1" x-model="editingField.is_required" style="width: 16px; height: 16px; accent-color: #0F172A; cursor: pointer;" />
                            <span>Wajib Diisi (Required *)</span>
                        </label>

                        <div style="display: flex; gap: 0.5rem;">
                            <button type="button" @click="isEditModalOpen = false" style="background: #F1F5F9; border: 1px solid #CBD5E1; color: #475569; font-weight: 700; font-size: 0.8125rem; padding: 0.55rem 1rem; border-radius: 6px; cursor: pointer;">
                                Batal
                            </button>
                            <button type="submit" style="background: #072718; color: #D4AF37; font-weight: 800; font-size: 0.8125rem; padding: 0.55rem 1.25rem; border-radius: 6px; border: 1px solid #C59B27; cursor: pointer;">
                                💾 Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </template>
        </div>
    </div>

</div>
@endsection
