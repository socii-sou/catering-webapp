@extends('layouts.app')

@section('title', 'Paket ' . $paket->nm_paket . ' - RASACI Catering')
@section('meta-description', 'Kustomisasi paket catering ' . $paket->nm_paket . ' Anda di RASACI Catering. Pilihlah lauk pilihan terbaik untuk acara Anda.')

@section('styles')
        <style>
            .active-lauk-card {
                border-color: #2D5A27 !important;
                background-color: rgba(45, 90, 39, 0.03) !important;
            }
            .prasmanan-lauk-card.active-card {
                border-color: #2D5A27 !important;
                background-color: rgba(45, 90, 39, 0.02) !important;
            }
        </style>
@endsection

@section('content')
        @php
            $isPrasmanan = str_contains(strtolower($paket->nm_paket), 'prasmanan');
            $isTumpeng = str_contains(strtolower($paket->nm_paket), 'tumpeng');
            $heroImage = $isPrasmanan ? asset('images/prasmanan.jpg') : asset('images/nasi_kotak.jpg');

            if ($isTumpeng) {
                $heroImage = asset('images/tumpeng.jpg');
            }

            $paketDeskripsi = !empty($paket->deskripsi) ? $paket->deskripsi : 'Solusi praktis untuk rapat kantor, seminar, atau konsumsi panitia dengan cita rasa Nusantara yang konsisten dan higienis.';
            if (!str_contains($paketDeskripsi, 'dan higienis')) {
                $paketDeskripsi = rtrim($paketDeskripsi, '.') . ' dan higienis.';
            }

            $hargaAwal = (int) $paket->harga_paket > 0 ? (int) $paket->harga_paket : ($isPrasmanan ? 65000 : ($isTumpeng ? 500000 : 35000));
            $minPax = $isPrasmanan ? 20 : ($isTumpeng ? 1 : 10);
        @endphp

        <!-- Main Content Area -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 w-full">

            @if($isPrasmanan)
                @include('partials.detail.prasmanan')
            @elseif($isTumpeng)
                @include('partials.detail.tumpeng')
            @else
                @include('partials.detail.nasi_kotak')
            @endif

        </main>
@endsection

@section('scripts')
        <script>
            // Date bounds
            const detailDateInput = document.getElementById('detailTglAcara');
            if (detailDateInput) {
                const tomorrow = new Date();
                tomorrow.setDate(tomorrow.getDate() + 1);
                const year = tomorrow.getFullYear();
                const month = String(tomorrow.getMonth() + 1).padStart(2, '0');
                const day = String(tomorrow.getDate()).padStart(2, '0');
                detailDateInput.min = `${year}-${month}-${day}`;
            }

            // Price & Category configurations
            let currentUnitPrice = {{ $hargaAwal }};
            let currentMaxLauk = {{ $paket->jumlah_lauk_pilihan }};
            let selectedLaukIds = [1, 3, 6];
            let prasmananCategoryLimits = {
                ayam: 1,
                daging: 1,
                sayur: 1
            };

            // Prasmanan Variant Selection
            function selectPrasmananVariant(card, price, maxLauk, name) {
                document.querySelectorAll('.prasmanan-variant-card').forEach(c => {
                    c.classList.remove('border-2', 'border-gray-900');
                    c.classList.add('border', 'border-gray-200');
                    c.querySelector('.active-badge')?.classList.add('hidden');
                });
                card.classList.remove('border', 'border-gray-200');
                card.classList.add('border-2', 'border-gray-900');
                card.querySelector('.active-badge')?.classList.remove('hidden');

                currentUnitPrice = price;
                currentMaxLauk = maxLauk;

                const label = document.getElementById('sidebarPriceLabel');
                if (label) label.innerText = 'Rp ' + price.toLocaleString('id-ID');

                const summaryLabel = document.getElementById('summaryHargaPerPax');
                if (summaryLabel) summaryLabel.innerText = 'Rp ' + price.toLocaleString('id-ID');

                const isPremium = (price === 95000 || name.toLowerCase().includes('premium'));

                if (isPremium) {
                    prasmananCategoryLimits = { ayam: 2, daging: 2, sayur: 1 };
                    
                    const labelAyam = document.getElementById('label-ayam-title');
                    if (labelAyam) labelAyam.innerHTML = '<span>🍴</span> Aneka Ayam (Pilih 2)';
                    
                    const labelDaging = document.getElementById('label-daging-title');
                    if (labelDaging) labelDaging.innerHTML = '<span>🍲</span> Aneka Daging (Pilih 2)';
                    
                    const labelSayur = document.getElementById('label-sayur-title');
                    if (labelSayur) labelSayur.innerHTML = '<span>🥬</span> Aneka Sayur (Pilih 1)';

                    // Default auto-select for Premium (Ayam 1 & 2, Daging 3 & 5, Sayur 6)
                    setCategorySelections('ayam', [1, 2]);
                    setCategorySelections('daging', [3, 5]);
                    setCategorySelections('sayur', [6]);
                } else {
                    prasmananCategoryLimits = { ayam: 1, daging: 1, sayur: 1 };
                    
                    const labelAyam = document.getElementById('label-ayam-title');
                    if (labelAyam) labelAyam.innerHTML = '<span>🍴</span> Aneka Ayam (Pilih 1)';
                    
                    const labelDaging = document.getElementById('label-daging-title');
                    if (labelDaging) labelDaging.innerHTML = '<span>🍲</span> Aneka Daging (Pilih 1)';
                    
                    const labelSayur = document.getElementById('label-sayur-title');
                    if (labelSayur) labelSayur.innerHTML = '<span>🥬</span> Aneka Sayur (Pilih 1)';

                    // Default auto-select for Standard (Ayam 1, Daging 3, Sayur 6)
                    setCategorySelections('ayam', [1]);
                    setCategorySelections('daging', [3]);
                    setCategorySelections('sayur', [6]);
                }

                syncSelectedLaukIds();
                calculateDetailPrice();
            }

            function setCategorySelections(category, targetIds) {
                const cards = document.querySelectorAll(`.prasmanan-lauk-card[data-category="${category}"]`);
                cards.forEach(card => {
                    const laukId = Number(card.getAttribute('data-lauk-id'));
                    const input = card.querySelector('.lauk-input');
                    const icon = card.querySelector('.check-box-icon');

                    if (targetIds.includes(laukId)) {
                        card.classList.add('active-card', 'border-2', 'border-[#2D5A27]');
                        card.classList.remove('border-gray-200');
                        if (icon) {
                            icon.className = "check-box-icon w-4.5 h-4.5 rounded-full bg-[#2D5A27] text-white flex items-center justify-center text-[10px] font-bold";
                            icon.innerText = "✓";
                        }
                        if (input) input.checked = true;
                    } else {
                        card.classList.remove('active-card', 'border-2', 'border-[#2D5A27]');
                        card.classList.add('border-gray-200');
                        if (icon) {
                            icon.className = "check-box-icon w-4.5 h-4.5 rounded-full border border-gray-300 bg-white flex items-center justify-center text-[10px] font-bold";
                            icon.innerText = "";
                        }
                        if (input) input.checked = false;
                    }
                });
            }

            function syncSelectedLaukIds() {
                selectedLaukIds = [];
                document.querySelectorAll('.prasmanan-lauk-card.active-card').forEach(card => {
                    const laukId = Number(card.getAttribute('data-lauk-id'));
                    if (laukId && !selectedLaukIds.includes(laukId)) {
                        selectedLaukIds.push(laukId);
                    }
                });
            }

            // Prasmanan Lauk Selection (Dynamic limit per category)
            function selectPrasmananLauk(card, category) {
                const limit = prasmananCategoryLimits[category] || 1;
                const siblings = Array.from(document.querySelectorAll(`.prasmanan-lauk-card[data-category="${category}"]`));
                const activeSiblings = siblings.filter(c => c.classList.contains('active-card'));
                const isCardActive = card.classList.contains('active-card');

                if (limit === 1) {
                    // Radio behavior
                    siblings.forEach(s => setCardActiveState(s, false));
                    setCardActiveState(card, true);
                } else {
                    // Multi selection up to limit
                    if (isCardActive) {
                        if (activeSiblings.length > 1) {
                            setCardActiveState(card, false);
                        }
                    } else {
                        if (activeSiblings.length >= limit) {
                            // Uncheck the first selected card and check this new one
                            setCardActiveState(activeSiblings[0], false);
                        }
                        setCardActiveState(card, true);
                    }
                }

                syncSelectedLaukIds();
            }

            function setCardActiveState(card, active) {
                const icon = card.querySelector('.check-box-icon');
                const input = card.querySelector('.lauk-input');

                if (active) {
                    card.classList.add('active-card', 'border-2', 'border-[#2D5A27]');
                    card.classList.remove('border-gray-200');
                    if (icon) {
                        icon.className = "check-box-icon w-4.5 h-4.5 rounded-full bg-[#2D5A27] text-white flex items-center justify-center text-[10px] font-bold";
                        icon.innerText = "✓";
                    }
                    if (input) input.checked = true;
                } else {
                    card.classList.remove('active-card', 'border-2', 'border-[#2D5A27]');
                    card.classList.add('border-gray-200');
                    if (icon) {
                        icon.className = "check-box-icon w-4.5 h-4.5 rounded-full border border-gray-300 bg-white flex items-center justify-center text-[10px] font-bold";
                        icon.innerText = "";
                    }
                    if (input) input.checked = false;
                }
            }


            // Nasi Kotak Lauk Card Toggle
            function toggleLaukCard(card, limit) {
                const checkbox = card.querySelector('.lauk-checkbox');
                const checkIndicator = card.querySelector('.check-indicator');
                const boxIndicator = card.querySelector('.box-indicator');

                if (checkbox.checked) {
                    checkbox.checked = false;
                    card.classList.remove('active-lauk-card', 'border-[#2D5A27]');
                    card.classList.add('border-gray-200');
                    if (checkIndicator) checkIndicator.classList.add('hidden');
                    if (boxIndicator) boxIndicator.classList.remove('hidden');
                    selectedLaukIds = selectedLaukIds.filter(id => id !== Number(checkbox.value));
                } else {
                    if (selectedLaukIds.length >= limit) {
                        alert(`Anda hanya boleh memilih maksimal ${limit} lauk untuk paket ini.`);
                        return;
                    }
                    checkbox.checked = true;
                    card.classList.add('active-lauk-card', 'border-[#2D5A27]');
                    card.classList.remove('border-gray-200');
                    if (checkIndicator) checkIndicator.classList.remove('hidden');
                    if (boxIndicator) boxIndicator.classList.add('hidden');
                    selectedLaukIds.push(Number(checkbox.value));
                }
            }

            // Increment / Decrement
            function incrementPax() {
                const input = document.getElementById('detailJumlahPax');
                const isTumpeng = {{ $isTumpeng ? 'true' : 'false' }};
                const step = isTumpeng ? 1 : 10;
                input.value = parseInt(input.value) + step;
                calculateDetailPrice();
            }

            function decrementPax() {
                const input = document.getElementById('detailJumlahPax');
                const isTumpeng = {{ $isTumpeng ? 'true' : 'false' }};
                const min = {{ $minPax }};
                const step = isTumpeng ? 1 : 10;
                const current = parseInt(input.value);
                if (current > min) {
                    input.value = current - step;
                    calculateDetailPrice();
                }
            }

            // Price Calculation
            function calculateDetailPrice() {
                const paxInput = document.getElementById('detailJumlahPax');
                const inputJml = document.getElementById('prasmananInputJmlPaket') || document.getElementById('detailInputJmlPaket');
                if (!paxInput) return;

                const pax = Number(paxInput.value) || 0;
                if (inputJml) inputJml.value = pax;

                const subtotal = pax * currentUnitPrice;
                const formatted = 'Rp ' + subtotal.toLocaleString('id-ID');

                const summaryLabel = document.getElementById('summaryHargaPerPax');
                if (summaryLabel) summaryLabel.innerText = 'Rp ' + currentUnitPrice.toLocaleString('id-ID');

                const subtotalLabel = document.getElementById('detailSubtotal');
                if (subtotalLabel) subtotalLabel.innerText = formatted;

                const totalLabel = document.getElementById('detailTotal');
                if (totalLabel) totalLabel.innerText = formatted;
            }

            // AJAX Submit
            function submitDetailOrder(event) {
                event.preventDefault();

                @guest
                    openLoginModal();
                    return;
                @endguest

                const paxInput = document.getElementById('detailJumlahPax').value;
                const tglAcara = document.getElementById('detailTglAcara').value;

                const submitBtn = document.getElementById('detailSubmitBtn');
                const spinner = document.getElementById('detailSpinner');
                if (submitBtn) submitBtn.disabled = true;
                if (spinner) spinner.classList.remove('hidden');
                
                const errBanner = document.getElementById('detailErrorBanner');
                if (errBanner) errBanner.classList.add('hidden');

                const payload = {
                    tgl_acara: tglAcara,
                    jumlah_pax: Number(paxInput),
                    items: [
                        {
                            paket_id: {{ $paket->id }},
                            jml_paket: Number(paxInput),
                            lauk_ids: selectedLaukIds
                        }
                    ]
                };

                fetch('{{ route("web.pesanan.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(payload)
                })
                .then(response => {
                    return response.json().then(data => {
                        if (!response.ok) {
                            throw new Error(data.message || 'Terjadi kesalahan sistem.');
                        }
                        return data;
                    });
                })
                .then(data => {
                    const overlay = document.getElementById('successOverlay');
                    if (overlay) overlay.classList.remove('hidden');
                })
                .catch(error => {
                    showDetailError(error.message);
                })
                .finally(() => {
                    if (submitBtn) submitBtn.disabled = false;
                    if (spinner) spinner.classList.add('hidden');
                });
            }

            function showDetailError(message) {
                const banner = document.getElementById('detailErrorBanner');
                const text = document.getElementById('detailErrorText');
                if (banner && text) {
                    text.innerText = message;
                    banner.classList.remove('hidden');
                }
            }
        </script>
@endsection
