@extends('layouts.app')

@section('content')
<div style="min-height: 100vh; background: #F8FAFC; color: #0F172A; font-family: 'Plus Jakarta Sans', sans-serif;" 
     x-data="{ 
         activeStudioTab: 'questions',
         showAddComposer: false,
         selectedType: 'radio',
         hasReason: true,
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
                 const labelInput = document.getElementById('field_label_input');
                 const optionsInput = document.getElementById('options_raw_input');
                 const reasonLabelInput = document.getElementById('reason_label_input');
                 
                 if (type === 'identity') {
                     labelInput.value = 'Nama Lengkap Peserta';
                     this.selectedType = 'text';
                     this.hasReason = false;
                     if (optionsInput) optionsInput.value = '';
                 } else if (type === 'class') {
                     labelInput.value = 'Kelas / Kelompok Belajar';
                     this.selectedType = 'text';
                     this.hasReason = false;
                     if (optionsInput) optionsInput.value = '';
                 } else if (type === 'eval_reason') {
                     labelInput.value = 'Apakah ada mata kuliah yang menurut Anda perlu ditambah atau dikurangi jam pelajarannya? Sebutkan alasannya';
                     this.selectedType = 'radio';
                     this.hasReason = true;
                     this.reasonLabel = 'Sebutkan alasan & mata kuliah yang Anda maksud:';
                     if (reasonLabelInput) reasonLabelInput.value = this.reasonLabel;
                     if (optionsInput) {
                         optionsInput.value = 'Perlu Ditambah Jam Pelajarannya\nPerlu Dikurangi Jam Pelajarannya\nSudah Cukup & Sesuai';
                     }
                 } else if (type === 'checkbox_eval') {
                     labelInput.value = 'Menurut Anda, mata kuliah apa saja yang memerlukan penyesuaian jam atau kurikulum?';
                     this.selectedType = 'checkbox';
                     this.hasReason = true;
                     this.reasonLabel = 'Tuliskan alasan evaluasi untuk mata kuliah yang dipilih:';
                     if (reasonLabelInput) reasonLabelInput.value = this.reasonLabel;
                     if (optionsInput) {
                         optionsInput.value = 'PBB & Disiplin\nOlahraga & Kesamaptaan\nPemberlakuan KUHP Nasional\nPemberlakuan KUHAP 2025\nSistem Peradilan Pidana Anak\nPenanganan Tindak Pidana Cyber / AI';
                     }
                 } else if (type === 'rating_scale') {
                     labelInput.value = 'Tingkat kepuasan Anda terhadap efektivitas kurikulum dan materi pembelajaran:';
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
            font-size: 0.875rem;
            padding: 0.65rem 1.25rem;
            border-radius: 10px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
            font-family: inherit;
        }
        .studio-nav-btn:hover {
            color: #072718;
            background: #E2E8F0;
        }
        .studio-nav-btn.active {
            background: #072718 !important;
            color: #D4AF37 !important;
            font-weight: 900 !important;
            box-shadow: 0 4px 12px rgba(7,39,24,0.25);
        }
        .action-tool-btn {
            background: #FFFFFF;
            border: 1px solid #CBD5E1;
            color: #334155;
            font-size: 0.75rem;
            font-weight: 800;
            padding: 0.35rem 0.65rem;
            border-radius: 8px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            transition: all 0.15s ease;
            text-decoration: none;
        }
        .action-tool-btn:hover {
            background: #F1F5F9;
            border-color: #94A3B8;
            color: #0F172A;
        }
        .action-tool-btn:disabled {
            opacity: 0.35;
            cursor: not-allowed;
        }
        .options-chip-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 0.45rem;
            max-height: 220px;
            overflow-y: auto;
            padding: 0.35rem;
        }
        .options-chip-item {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            padding: 0.4rem 0.75rem;
            border-radius: 8px;
            font-size: 0.8125rem;
            color: #1E293B;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }
    </style>

    <!-- 1. TOP STUDIO HEADER (KEJAKSAAN RI EMERALD & GOLD) -->
    <header style="background: linear-gradient(135deg, #072718 0%, #0D3E27 100%); border-bottom: 2.5px solid #D4AF37; padding: 1.15rem 2rem; color: #FFF; box-shadow: 0 10px 30px rgba(0,0,0,0.25);">
        <div style="max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            
            <div style="display: flex; align-items: center; gap: 1rem;">
                <a href="{{ route('dashboard.index', ['tab' => 'custom_forms']) }}" 
                   style="background: rgba(255,255,255,0.12); color: #D4AF37; border: 1px solid rgba(212,175,55,0.4); text-decoration: none; font-size: 1.1rem; width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease;">
                    ←
                </a>
                <div>
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.2rem;">
                        <span style="font-size: 0.65rem; color: #D4AF37; font-weight: 900; letter-spacing: 0.06em; text-transform: uppercase; background: rgba(212,175,55,0.18); border: 1px solid rgba(212,175,55,0.4); padding: 0.15rem 0.55rem; border-radius: 9999px;">
                            STUDIO DESAIN FORMULIR LITBANG
                        </span>
                        @if($form->isOpen())
                            <span style="font-size: 0.65rem; color: #86EFAC; font-weight: 800; background: rgba(16,185,129,0.2); border: 1px solid #10B981; padding: 0.15rem 0.55rem; border-radius: 9999px;">
                                🟢 AKTIF MENERIMA RESPON
                            </span>
                        @else
                            <span style="font-size: 0.65rem; color: #FCA5A5; font-weight: 800; background: rgba(239,68,68,0.2); border: 1px solid #EF4444; padding: 0.15rem 0.55rem; border-radius: 9999px;">
                                🔴 FORMULIR DITUTUP
                            </span>
                        @endif
                    </div>
                    <h1 style="font-size: 1.3rem; font-weight: 900; margin: 0; color: #FFF; letter-spacing: -0.01em;">
                        {{ $form->title }}
                    </h1>
                </div>
            </div>

            <div style="display: flex; align-items: center; gap: 0.65rem; flex-wrap: wrap;">
                <a href="{{ route('forms.show', $form->slug) }}" target="_blank" 
                   style="background: rgba(255,255,255,0.12); border: 1.5px solid rgba(255,255,255,0.3); color: #FFF; font-size: 0.8125rem; font-weight: 800; padding: 0.55rem 1.1rem; border-radius: 10px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem; backdrop-filter: blur(8px);">
                    👁️ Pratinjau Publik
                </a>
                <a href="{{ route('dashboard.forms.responses', $form->id) }}" 
                   style="background: linear-gradient(135deg, #16A34A 0%, #15803D 100%); color: #FFF; font-size: 0.8125rem; font-weight: 900; padding: 0.55rem 1.25rem; border-radius: 10px; text-decoration: none; box-shadow: 0 4px 15px rgba(22,163,74,0.35); display: inline-flex; align-items: center; gap: 0.4rem;">
                    📊 Pusat Tanggapan ({{ $form->responses()->count() }})
                </a>
            </div>

        </div>
    </header>

    @if(session('toast'))
        <div style="max-width: 1100px; margin: 1.25rem auto 0; padding: 0 1.5rem;">
            <div style="background: #ECFDF5; border: 1.5px solid #10B981; color: #065F46; font-weight: 800; font-size: 0.875rem; padding: 0.85rem 1.25rem; border-radius: 14px; box-shadow: 0 4px 15px rgba(16,185,129,0.15); display: flex; align-items: center; gap: 0.5rem;">
                <span>✨</span>
                <span>{{ session('toast') }}</span>
            </div>
        </div>
    @endif

    <!-- 2. STUDIO TABS NAVIGATION (GOOGLE FORMS EXECUTIVE STYLE) -->
    <div style="background: #FFFFFF; border-bottom: 1.5px solid #E2E8F0; padding: 0.5rem 1.5rem;">
        <div style="max-width: 1100px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem;">
            
            <div style="display: inline-flex; background: #F1F5F9; padding: 0.3rem; border-radius: 12px; gap: 0.35rem;">
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
                    <span>Pengaturan & Identitas Formulir</span>
                </button>
            </div>

            <!-- TOGGLE COMPOSER BUTTON -->
            <button type="button" 
                    @click="showAddComposer = !showAddComposer" 
                    style="background: linear-gradient(135deg, #072718 0%, #15803D 100%); color: #D4AF37; font-weight: 900; font-size: 0.8125rem; padding: 0.55rem 1.25rem; border-radius: 10px; border: 1.5px solid #C59B27; cursor: pointer; display: inline-flex; align-items: center; gap: 0.4rem; box-shadow: 0 4px 12px rgba(7,39,24,0.2);">
                <span x-text="showAddComposer ? '▲ Tutup Panel Buat Pertanyaan' : '➕ Tambah Pertanyaan Baru'"></span>
            </button>

        </div>
    </div>

    <!-- 3. MAIN WORKSPACE CONTAINER -->
    <main style="max-width: 1100px; margin: 1.75rem auto 5rem; padding: 0 1.5rem;">

        <!-- ============================================================== -->
        <!-- TAB 1: PERTANYAAN KUESIONER                                     -->
        <!-- ============================================================== -->
        <div x-show="activeStudioTab === 'questions'">

            <!-- 1.1 COLLAPSIBLE COMPOSER PANEL (TAMBAH PERTANYAAN BARU) -->
            <div x-show="showAddComposer" 
                 x-transition
                 style="background: #FFFFFF; border: 2px solid #072718; border-radius: 20px; padding: 1.75rem; margin-bottom: 2rem; box-shadow: 0 12px 35px rgba(7,39,24,0.12);">
                
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; border-bottom: 1.5px solid #F1F5F9; padding-bottom: 0.75rem;">
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span style="background: #072718; color: #D4AF37; font-size: 0.95rem; padding: 0.35rem 0.6rem; border-radius: 8px;">➕</span>
                        <h3 style="font-size: 1.1rem; font-weight: 900; color: #072718; margin: 0;">
                            Buat Pertanyaan Kuesioner Baru
                        </h3>
                    </div>
                    <button type="button" @click="showAddComposer = false" style="background: #F1F5F9; border: none; width: 32px; height: 32px; border-radius: 8px; font-size: 1rem; cursor: pointer; color: #64748B;">✕</button>
                </div>

                <!-- 1-CLICK PRESET TEMPLATES -->
                <div style="background: #F8FAFC; border: 1.5px solid #E2E8F0; border-radius: 14px; padding: 0.85rem 1rem; margin-bottom: 1.25rem;">
                    <div style="font-size: 0.72rem; font-weight: 900; color: #475569; text-transform: uppercase; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.35rem;">
                        <span>⚡</span>
                        <span>Template Cepat 1-Klik (Siap Pakai untuk Diklat PPPJ):</span>
                    </div>
                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                        <button type="button" @click="applyPreset('identity')" style="background: #FFF; border: 1.5px solid #CBD5E1; color: #334155; font-size: 0.78125rem; font-weight: 800; padding: 0.4rem 0.85rem; border-radius: 8px; cursor: pointer;">
                            👤 Nama Peserta
                        </button>
                        <button type="button" @click="applyPreset('class')" style="background: #FFF; border: 1.5px solid #CBD5E1; color: #334155; font-size: 0.78125rem; font-weight: 800; padding: 0.4rem 0.85rem; border-radius: 8px; cursor: pointer;">
                            🏛️ Kelas / Kelompok
                        </button>
                        <button type="button" @click="applyPreset('eval_reason')" style="background: #ECFDF5; border: 1.5px solid #10B981; color: #065F46; font-size: 0.78125rem; font-weight: 900; padding: 0.4rem 0.85rem; border-radius: 8px; cursor: pointer; box-shadow: 0 2px 6px rgba(16,185,129,0.15);">
                            💬 Evaluasi Jam MK + Alasan
                        </button>
                        <button type="button" @click="applyPreset('checkbox_eval')" style="background: #EFF6FF; border: 1.5px solid #93C5FD; color: #1E40AF; font-size: 0.78125rem; font-weight: 800; padding: 0.4rem 0.85rem; border-radius: 8px; cursor: pointer;">
                            ☑️ Multi-Pilih MK (Checkbox)
                        </button>
                        <button type="button" @click="applyPreset('rating_scale')" style="background: #FFFBEB; border: 1.5px solid #FCD34D; color: #92400E; font-size: 0.78125rem; font-weight: 800; padding: 0.4rem 0.85rem; border-radius: 8px; cursor: pointer;">
                            ⭐ Rating Kepuasan 1-5
                        </button>
                    </div>
                </div>

                <!-- ADD FORM -->
                <form action="{{ route('dashboard.forms.fields.store', $form->id) }}" method="POST" style="display: flex; flex-direction: column; gap: 1.15rem;">
                    @csrf

                    <div>
                        <label style="font-size: 0.8125rem; font-weight: 800; color: #1E293B; display: block; margin-bottom: 0.4rem;">
                            Teks Pertanyaan / Label Soal *
                        </label>
                        <textarea id="field_label_input" name="field_label" rows="2" placeholder="Contoh: Apakah ada mata kuliah yang menurut Anda perlu ditambah atau dikurangi jam pelajarannya? Sebutkan alasannya" required style="width: 100%; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 12px; padding: 0.75rem 1rem; font-size: 0.875rem; outline: none; font-family: inherit; line-height: 1.5;"></textarea>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div>
                            <label style="font-size: 0.8125rem; font-weight: 800; color: #1E293B; display: block; margin-bottom: 0.4rem;">
                                Tipe Jawaban Responden *
                            </label>
                            <select name="field_type" x-model="selectedType" required style="width: 100%; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 10px; padding: 0.65rem 0.85rem; font-size: 0.84375rem; outline: none; font-weight: 700; cursor: pointer;">
                                <option value="radio">🔘 Pilihan Ganda (Satu Pilihan)</option>
                                <option value="checkbox">☑️ Kotak Centang (Bisa Pilih Lebih Dari Satu)</option>
                                <option value="select">🔽 Dropdown Pilihan</option>
                                <option value="text">✏️ Jawaban Singkat (Text Pendek)</option>
                                <option value="textarea">📝 Paragraf Panjang (Uraian)</option>
                                <option value="file">📎 Unggah Berkas / Dokumen / Foto</option>
                                <option value="date">📅 Tanggal (Date)</option>
                                <option value="number">🔢 Angka / Nilai (Number)</option>
                            </select>
                        </div>

                        <div>
                            <label style="font-size: 0.8125rem; font-weight: 800; color: #1E293B; display: block; margin-bottom: 0.4rem;">
                                Teks Bantuan / Petunjuk Singkat (Opsional)
                            </label>
                            <input type="text" name="help_text" placeholder="Contoh: Boleh memilih lebih dari satu mata kuliah..." style="width: 100%; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 10px; padding: 0.65rem 0.85rem; font-size: 0.84375rem; outline: none;" />
                        </div>
                    </div>

                    <!-- OPSIONAL PILIHAN OPSI (UNTUK RADIO, SELECT, CHECKBOX) -->
                    <div x-show="['radio', 'checkbox', 'select'].includes(selectedType)" 
                         x-transition
                         style="background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 14px; padding: 1rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.4rem;">
                            <label style="font-size: 0.78125rem; font-weight: 800; color: #0F172A;">
                                Daftar Pilihan Jawaban (Tulis 1 pilihan per baris):
                            </label>
                            <span style="font-size: 0.72rem; color: #64748B;">Tekan Enter untuk baris berikutnya</span>
                        </div>
                        <textarea id="options_raw_input" name="options_raw" rows="5" placeholder="Perlu Ditambah Jam Pelajarannya&#10;Perlu Dikurangi Jam Pelajarannya&#10;Sudah Cukup & Sesuai" style="width: 100%; background: #FFF; border: 1.5px solid #CBD5E1; border-radius: 10px; padding: 0.65rem 0.85rem; font-size: 0.84375rem; outline: none; font-family: inherit; line-height: 1.5;"></textarea>
                    </div>

                    <!-- FITUR KOTAK ALASAN / PENJELASAN TAMBAHAN (CONDITIONAL REASON BOX) -->
                    <div x-show="['radio', 'checkbox', 'select'].includes(selectedType)"
                         x-transition
                         style="background: #F0FDF4; border: 1.5px solid #86EFAC; border-radius: 14px; padding: 1rem;">
                        <label style="display: flex; align-items: center; gap: 0.6rem; font-size: 0.84375rem; font-weight: 900; color: #166534; cursor: pointer;">
                            <input type="checkbox" name="has_reason" value="1" x-model="hasReason" style="width: 18px; height: 18px; accent-color: #16A34A; cursor: pointer;" />
                            <span>💬 Aktifkan Kolom Alasan / Penjelasan Otomatis</span>
                        </label>
                        <div style="font-size: 0.75rem; color: #15803D; margin-top: 0.25rem; line-height: 1.4;">
                            Bila fitur ini dicentang, saat responden memilih opsi di atas akan otomatis muncul kolom untuk menguraikan alasan atau penjelasannya.
                        </div>

                        <div x-show="hasReason" style="margin-top: 0.75rem;">
                            <label style="font-size: 0.75rem; font-weight: 800; color: #166534; display: block; margin-bottom: 0.25rem;">
                                Label / Petunjuk Kolom Alasan:
                            </label>
                            <input type="text" id="reason_label_input" name="reason_label" x-model="reasonLabel" placeholder="Contoh: Sebutkan alasan atau mata kuliah yang Anda maksud:" style="width: 100%; background: #FFF; border: 1.5px solid #86EFAC; border-radius: 10px; padding: 0.55rem 0.85rem; font-size: 0.8125rem; outline: none;" />
                        </div>
                    </div>

                    <div style="display: flex; align-items: center; justify-content: space-between; border-top: 1.5px solid #F1F5F9; padding-top: 1rem;">
                        <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.84375rem; font-weight: 800; color: #0F172A; cursor: pointer;">
                            <input type="checkbox" name="is_required" value="1" checked style="width: 18px; height: 18px; accent-color: #072718; cursor: pointer;" />
                            <span>Wajib Diisi (Required *)</span>
                        </label>

                        <div style="display: flex; gap: 0.6rem;">
                            <button type="button" @click="showAddComposer = false" style="background: #F1F5F9; border: 1.5px solid #CBD5E1; color: #475569; font-weight: 800; font-size: 0.8125rem; padding: 0.65rem 1.25rem; border-radius: 10px; cursor: pointer;">
                                Tutup
                            </button>
                            <button type="submit" style="background: linear-gradient(135deg, #072718 0%, #16A34A 100%); color: #FFF; font-weight: 900; font-size: 0.84375rem; padding: 0.65rem 1.5rem; border-radius: 10px; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 0.4rem; box-shadow: 0 4px 15px rgba(7,39,24,0.25);">
                                ➕ Tambahkan ke Kuesioner
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- 1.2 QUESTION CARDS LIST -->
            <div style="background: #FFFFFF; border: 1.5px solid #E2E8F0; border-radius: 20px; padding: 1.75rem; box-shadow: 0 8px 25px rgba(0,0,0,0.03);">
                
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1.5px solid #F1F5F9; padding-bottom: 1rem; flex-wrap: wrap; gap: 1rem;">
                    <div>
                        <div style="font-size: 0.6875rem; font-weight: 900; color: #64748B; text-transform: uppercase; letter-spacing: 0.06em;">
                            STRUKTUR INSTRUMEN KUESIONER
                        </div>
                        <h2 style="font-size: 1.25rem; font-weight: 900; color: #072718; margin: 0.2rem 0 0;">
                            Daftar Pertanyaan Aktif ({{ $form->fields->count() }} Butir Soal)
                        </h2>
                    </div>

                    <!-- SEARCH FILTER & ADD SHORTCUT -->
                    <div style="display: flex; align-items: center; gap: 0.65rem;">
                        <input type="text" x-model="searchQuestion" placeholder="🔍 Cari butir pertanyaan..." style="background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 10px; padding: 0.45rem 0.85rem; font-size: 0.8125rem; outline: none; width: 220px;" />
                        <button type="button" @click="showAddComposer = true; window.scrollTo({ top: 120, behavior: 'smooth' })" style="background: #072718; color: #D4AF37; font-weight: 900; font-size: 0.78125rem; padding: 0.45rem 1rem; border-radius: 10px; border: 1px solid #C59B27; cursor: pointer; display: inline-flex; align-items: center; gap: 0.35rem;">
                            ➕ Tambah
                        </button>
                    </div>
                </div>

                @if($form->fields->isEmpty())
                    <!-- EMPTY STATE -->
                    <div style="text-align: center; padding: 4rem 1.5rem; color: #94A3B8; border: 2px dashed #CBD5E1; border-radius: 16px; background: #F8FAFC;">
                        <div style="font-size: 3.5rem; margin-bottom: 0.75rem;">📝</div>
                        <div style="font-weight: 900; font-size: 1.15rem; color: #334155; margin-bottom: 0.35rem;">Belum Ada Pertanyaan di Formulir Ini</div>
                        <div style="font-size: 0.84375rem; max-width: 460px; margin: 0 auto 1.5rem; line-height: 1.6;">
                            Gunakan tombol <strong>+ Tambah Pertanyaan Baru</strong> di atas atau gunakan template 1-klik untuk menyusun pertanyaan kuesioner Anda.
                        </div>
                        <button type="button" @click="applyPreset('eval_reason')" style="background: #072718; color: #D4AF37; font-weight: 900; font-size: 0.84375rem; padding: 0.65rem 1.35rem; border-radius: 10px; border: 1px solid #C59B27; cursor: pointer;">
                            ✨ Isi Otomatis Contoh Pertanyaan + Alasan
                        </button>
                    </div>
                @else
                    <div style="display: flex; flex-direction: column; gap: 1.15rem;">
                        @foreach($form->fields as $index => $field)
                            @php
                                $type = strtolower($field->field_type);
                                $optCount = !empty($field->options) ? count($field->options) : 0;
                            @endphp

                            <div x-show="!searchQuestion || '{{ strtolower(addslashes($field->field_label)) }}'.includes(searchQuestion.toLowerCase())"
                                 style="background: #FFFFFF; border: 1.5px solid #E2E8F0; border-radius: 16px; padding: 1.35rem 1.6rem; transition: all 0.2s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.02); position: relative;">
                                
                                <!-- CARD TOP ROW -->
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem; flex-wrap: wrap; gap: 0.6rem;">
                                    
                                    <div style="display: flex; align-items: center; gap: 0.45rem; flex-wrap: wrap;">
                                        <!-- NUMBER BADGE -->
                                        <span style="background: #072718; color: #D4AF37; font-weight: 900; font-size: 0.75rem; padding: 0.2rem 0.6rem; border-radius: 7px; border: 1px solid #C59B27;">
                                            #{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                        </span>

                                        <!-- TYPE PILL -->
                                        <span style="font-size: 0.72rem; font-weight: 800; color: #0284C7; background: #E0F2FE; border: 1px solid #BAE6FD; padding: 0.2rem 0.6rem; border-radius: 6px;">
                                            @if($type === 'radio') 🔘 PILIHAN GANDA
                                            @elseif($type === 'checkbox') ☑️ KOTAK CENTANG (MULTI-PILIH)
                                            @elseif($type === 'select') 🔽 DROPDOWN
                                            @elseif($type === 'text') ✏️ JAWABAN SINGKAT
                                            @elseif($type === 'textarea') 📝 PARAGRAF / URAIAN
                                            @elseif($type === 'file') 📎 BERKAS
                                            @elseif($type === 'date') 📅 TANGGAL
                                            @elseif($type === 'number') 🔢 ANGKA
                                            @else {{ strtoupper($type) }}
                                            @endif
                                        </span>

                                        @if($field->is_required)
                                            <span style="font-size: 0.6875rem; font-weight: 900; color: #991B1B; background: #FEE2E2; border: 1px solid #FECACA; padding: 0.2rem 0.55rem; border-radius: 6px;">
                                                WAJIB
                                            </span>
                                        @endif

                                        @if($field->has_reason)
                                            <span style="font-size: 0.6875rem; font-weight: 900; color: #166534; background: #DCFCE7; border: 1.5px solid #86EFAC; padding: 0.2rem 0.6rem; border-radius: 6px; display: inline-flex; align-items: center; gap: 0.25rem;">
                                                <span>💬</span>
                                                <span>KOLOM ALASAN AKTIF</span>
                                            </span>
                                        @endif
                                    </div>

                                    <!-- ACTION BUTTONS -->
                                    <div style="display: flex; align-items: center; gap: 0.35rem;">
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
                                        <button type="button" @click="openEditModal({{ json_encode($field) }})" class="action-tool-btn" style="border-color: #0284C7; color: #0284C7;">
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
                                            <button type="submit" class="action-tool-btn" style="border-color: #FCA5A5; color: #991B1B; background: #FFF5F5;" title="Hapus Pertanyaan">
                                                🗑️
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <!-- QUESTION LABEL -->
                                <h3 style="font-size: 1.05rem; font-weight: 900; color: #0F172A; line-height: 1.45; margin: 0 0 0.35rem;">
                                    {{ $field->field_label }}
                                </h3>

                                @if($field->help_text)
                                    <div style="font-size: 0.78125rem; color: #64748B; margin-bottom: 0.65rem; font-style: italic;">
                                        ℹ️ {{ $field->help_text }}
                                    </div>
                                @endif

                                <!-- OPTIONS PREVIEW (CLEAN COMPACT MULTI-COLUMN CHIPS GRID) -->
                                @if(!empty($field->options))
                                    <div style="margin-top: 0.75rem; background: #F8FAFC; border: 1.5px solid #E2E8F0; border-radius: 12px; padding: 0.85rem 1rem;">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                            <span style="font-size: 0.72rem; font-weight: 800; color: #475569; text-transform: uppercase;">
                                                Daftar Pilihan Responden ({{ $optCount }} Butir Pilihan):
                                            </span>
                                            @if($optCount > 6)
                                                <span style="font-size: 0.72rem; color: #0284C7; font-weight: 700;">
                                                    Scroll untuk melihat semua pilihan ↓
                                                </span>
                                            @endif
                                        </div>

                                        <div class="options-chip-grid">
                                            @foreach($field->options as $optIndex => $opt)
                                                @php $cleanOpt = ltrim(trim($opt), "• -*\t "); @endphp
                                                <div class="options-chip-item">
                                                    <span style="color: #64748B; font-size: 0.72rem; font-weight: 800; min-width: 20px;">{{ $optIndex + 1 }}.</span>
                                                    <span style="color: #1E293B;">{{ $cleanOpt }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- REASON PREVIEW CALLOUT -->
                                @if($field->has_reason)
                                    <div style="margin-top: 0.65rem; background: #F0FDF4; border: 1.5px dashed #86EFAC; border-radius: 10px; padding: 0.6rem 0.95rem; display: flex; align-items: center; gap: 0.55rem; font-size: 0.8125rem; color: #166534;">
                                        <span style="font-size: 1.1rem;">💬</span>
                                        <div>
                                            <strong>Kolom Alasan Tambahan:</strong> "{{ $field->reason_label ?? 'Sebutkan alasan atau penjelasan pilihan Anda...' }}"
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
            <div style="background: #FFFFFF; border: 1.5px solid #E2E8F0; border-radius: 20px; padding: 2rem; box-shadow: 0 8px 25px rgba(0,0,0,0.03);">
                
                <div style="border-bottom: 1.5px solid #F1F5F9; padding-bottom: 1rem; margin-bottom: 1.5rem;">
                    <span style="font-size: 0.6875rem; font-weight: 900; color: #64748B; text-transform: uppercase; letter-spacing: 0.06em;">KONFIGURASI FORMULIR</span>
                    <h2 style="font-size: 1.3rem; font-weight: 900; color: #072718; margin: 0.2rem 0 0;">
                        Pengaturan & Identitas Kuesioner
                    </h2>
                    <p style="font-size: 0.84375rem; color: #64748B; margin: 0.35rem 0 0;">
                        Kelola judul, petunjuk pengisian, batas waktu penutupan kuesioner, dan pesan terima kasih.
                    </p>
                </div>

                <form action="{{ route('dashboard.forms.update', $form->id) }}" method="POST" style="display: flex; flex-direction: column; gap: 1.35rem; max-width: 800px;">
                    @csrf
                    @method('PUT')

                    <div>
                        <label style="font-size: 0.84375rem; font-weight: 800; color: #0F172A; display: block; margin-bottom: 0.35rem;">
                            Judul Formulir Kuesioner *
                        </label>
                        <input type="text" name="title" value="{{ $form->title }}" required style="width: 100%; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 10px; padding: 0.65rem 0.85rem; font-size: 0.90625rem; font-weight: 700; outline: none;" />
                    </div>

                    <div>
                        <label style="font-size: 0.84375rem; font-weight: 800; color: #0F172A; display: block; margin-bottom: 0.35rem;">
                            Deskripsi / Petunjuk Pengisian untuk Responden
                        </label>
                        <textarea name="description" rows="3" style="width: 100%; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 10px; padding: 0.65rem 0.85rem; font-size: 0.84375rem; outline: none; line-height: 1.5; font-family: inherit;">{{ $form->description }}</textarea>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
                        <div>
                            <label style="font-size: 0.84375rem; font-weight: 800; color: #0F172A; display: block; margin-bottom: 0.35rem;">
                                Status Penerimaan Respon
                            </label>
                            <select name="status" style="width: 100%; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 10px; padding: 0.65rem 0.85rem; font-size: 0.84375rem; outline: none; font-weight: 700; cursor: pointer;">
                                <option value="open" {{ $form->status === 'open' ? 'selected' : '' }}>🟢 Buka (Menerima Tanggapan)</option>
                                <option value="closed" {{ $form->status === 'closed' ? 'selected' : '' }}>🔴 Ditutup (Tidak Menerima Tanggapan)</option>
                            </select>
                        </div>
                        <div>
                            <label style="font-size: 0.84375rem; font-weight: 800; color: #0F172A; display: block; margin-bottom: 0.35rem;">
                                Tenggat Waktu Penutupan (Opsional)
                            </label>
                            <input type="datetime-local" name="deadline_at" value="{{ $form->deadline_at ? $form->deadline_at->format('Y-m-d\TH:i') : '' }}" style="width: 100%; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 10px; padding: 0.65rem 0.85rem; font-size: 0.84375rem; outline: none;" />
                        </div>
                    </div>

                    <div>
                        <label style="font-size: 0.84375rem; font-weight: 800; color: #0F172A; display: block; margin-bottom: 0.35rem;">
                            Pesan Sukses Setelah Mengisi (Thank You Message)
                        </label>
                        <input type="text" name="success_message" value="{{ $form->success_message }}" placeholder="Tanggapan Anda telah berhasil disimpan. Terima Kasih." style="width: 100%; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 10px; padding: 0.65rem 0.85rem; font-size: 0.84375rem; outline: none;" />
                    </div>

                    <div style="border-top: 1.5px solid #F1F5F9; padding-top: 1.25rem;">
                        <button type="submit" style="background: #072718; color: #D4AF37; font-weight: 900; font-size: 0.875rem; padding: 0.75rem 1.75rem; border-radius: 10px; border: 1.5px solid #C59B27; cursor: pointer; box-shadow: 0 4px 15px rgba(7,39,24,0.25);">
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
         style="position: fixed; inset: 0; z-index: 99999; background: rgba(15,23,42,0.7); backdrop-filter: blur(8px); display: flex; align-items: center; justify-content: center; padding: 1.25rem;"
         @keydown.escape.window="isEditModalOpen = false">
        
        <div class="modal-card" 
             style="background: #FFF; width: 100%; max-width: 620px; max-height: 90vh; overflow-y: auto; border-radius: 20px; border: 2px solid #072718; box-shadow: 0 25px 60px rgba(0,0,0,0.3); padding: 1.75rem;"
             @click.stop>
            
            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1.5px solid #F1F5F9; padding-bottom: 0.85rem; margin-bottom: 1.25rem;">
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <span style="background: #072718; color: #D4AF37; font-size: 0.9rem; padding: 0.3rem 0.5rem; border-radius: 8px;">✏️</span>
                    <h3 style="font-size: 1.15rem; font-weight: 900; color: #072718; margin: 0;">
                        Edit Butir Pertanyaan
                    </h3>
                </div>
                <button type="button" @click="isEditModalOpen = false" style="background: #F1F5F9; border: none; width: 32px; height: 32px; border-radius: 8px; font-size: 1rem; cursor: pointer; color: #64748B;">✕</button>
            </div>

            <template x-if="editingField">
                <form :action="'/dashboard/forms/fields/' + editingField.id + '/update'" method="POST" style="display: flex; flex-direction: column; gap: 1.15rem;">
                    @csrf
                    @method('PUT')

                    <div>
                        <label style="font-size: 0.8125rem; font-weight: 800; color: #1E293B; display: block; margin-bottom: 0.35rem;">
                            Teks Pertanyaan / Label Soal *
                        </label>
                        <textarea name="field_label" rows="3" x-model="editingField.field_label" required style="width: 100%; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 10px; padding: 0.65rem 0.85rem; font-size: 0.875rem; outline: none; font-family: inherit; line-height: 1.5;"></textarea>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div>
                            <label style="font-size: 0.8125rem; font-weight: 800; color: #1E293B; display: block; margin-bottom: 0.35rem;">
                                Tipe Jawaban *
                            </label>
                            <select name="field_type" x-model="editingField.field_type" required style="width: 100%; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 10px; padding: 0.65rem 0.85rem; font-size: 0.84375rem; outline: none; font-weight: 700; cursor: pointer;">
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
                        <div>
                            <label style="font-size: 0.8125rem; font-weight: 800; color: #1E293B; display: block; margin-bottom: 0.35rem;">
                                Teks Bantuan (Opsional)
                            </label>
                            <input type="text" name="help_text" x-model="editingField.help_text" style="width: 100%; background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 10px; padding: 0.65rem 0.85rem; font-size: 0.84375rem; outline: none;" />
                        </div>
                    </div>

                    <!-- OPSIONAL PILIHAN OPSI DI MODAL EDIT -->
                    <div x-show="['radio', 'checkbox', 'select'].includes(editingField.field_type)" style="background: #F8FAFC; border: 1.5px solid #CBD5E1; border-radius: 12px; padding: 1rem;">
                        <label style="font-size: 0.78125rem; font-weight: 800; color: #0F172A; display: block; margin-bottom: 0.35rem;">
                            Daftar Pilihan Jawaban (Tulis 1 pilihan per baris):
                        </label>
                        <textarea name="options_raw" rows="5" :value="editingField.options ? editingField.options.join('\n') : ''" placeholder="Opsi 1&#10;Opsi 2&#10;Opsi 3" style="width: 100%; background: #FFF; border: 1.5px solid #CBD5E1; border-radius: 8px; padding: 0.6rem 0.85rem; font-size: 0.84375rem; outline: none; font-family: inherit; line-height: 1.5;"></textarea>
                    </div>

                    <!-- FITUR KOTAK ALASAN DI MODAL EDIT -->
                    <div x-show="['radio', 'checkbox', 'select'].includes(editingField.field_type)" style="background: #F0FDF4; border: 1.5px solid #86EFAC; border-radius: 12px; padding: 1rem;">
                        <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.84375rem; font-weight: 900; color: #166534; cursor: pointer;">
                            <input type="checkbox" name="has_reason" value="1" x-model="editingField.has_reason" style="width: 18px; height: 18px; accent-color: #16A34A; cursor: pointer;" />
                            <span>💬 Aktifkan Kolom Alasan / Penjelasan Otomatis</span>
                        </label>
                        <div x-show="editingField.has_reason" style="margin-top: 0.75rem;">
                            <label style="font-size: 0.75rem; font-weight: 800; color: #166534; display: block; margin-bottom: 0.25rem;">
                                Label / Petunjuk Kolom Alasan:
                            </label>
                            <input type="text" name="reason_label" x-model="editingField.reason_label" placeholder="Contoh: Sebutkan alasan atau penjelasan pilihan Anda:" style="width: 100%; background: #FFF; border: 1.5px solid #86EFAC; border-radius: 8px; padding: 0.5rem 0.75rem; font-size: 0.8125rem; outline: none;" />
                        </div>
                    </div>

                    <div style="display: flex; align-items: center; justify-content: space-between; border-top: 1.5px solid #F1F5F9; padding-top: 1rem; margin-top: 0.5rem;">
                        <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.84375rem; font-weight: 800; color: #0F172A; cursor: pointer;">
                            <input type="checkbox" name="is_required" value="1" x-model="editingField.is_required" style="width: 18px; height: 18px; accent-color: #072718; cursor: pointer;" />
                            <span>Wajib Diisi (Required *)</span>
                        </label>

                        <div style="display: flex; gap: 0.6rem;">
                            <button type="button" @click="isEditModalOpen = false" style="background: #F1F5F9; border: 1.5px solid #CBD5E1; color: #475569; font-weight: 800; font-size: 0.8125rem; padding: 0.6rem 1.15rem; border-radius: 8px; cursor: pointer;">
                                Batal
                            </button>
                            <button type="submit" style="background: #072718; color: #D4AF37; font-weight: 900; font-size: 0.8125rem; padding: 0.6rem 1.35rem; border-radius: 8px; border: 1.5px solid #C59B27; cursor: pointer;">
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
