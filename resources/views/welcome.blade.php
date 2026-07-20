@extends('layouts.app')

@section('title', 'Rasaci Catering - Hidangan Lezat untuk Momen Spesial Anda')
@section('meta-description', 'Rasaci Catering menghadirkan layanan catering bintang lima dengan cita rasa Nusantara autentik untuk pesta pernikahan, rapat kantor, syukuran, dan acara spesial Anda.')

@section('content')
    <!-- HERO SECTION -->
    @include('partials.landing.hero')

    <!-- WHY US SECTION -->
    @include('partials.landing.why-us')

    <!-- PACKAGES SECTION -->
    @include('partials.landing.packages')

    <!-- HOW IT WORKS SECTION -->
    @include('partials.landing.how-it-works')

    <!-- REVIEWS SECTION -->
    @include('partials.landing.reviews')

    <!-- CTA SECTION -->
    @include('partials.landing.cta')
@endsection

@section('modals')
    <!-- BOOKING MODAL -->
    @include('partials.landing.booking-modal')
@endsection

@section('scripts')
    <script>
        // Date bounds
        const dateInput = document.getElementById('tglAcaraInput');
        if (dateInput) {
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            const year = tomorrow.getFullYear();
            const month = String(tomorrow.getMonth() + 1).padStart(2, '0');
            const day = String(tomorrow.getDate()).padStart(2, '0');
            dateInput.min = `${year}-${month}-${day}`;
        }

        // Global State Variables for Booking
        let currentPackage = {
            id: null,
            name: '',
            price: 0,
            maxLauk: 0
        };
        let selectedLaukIds = [];

        // 1. OPEN BOOKING MODAL
        function openBookingModal(id, name, price, maxLauk) {
            const modal = document.getElementById('bookingModal');
            if (!modal) return;

            currentPackage = { id, name, price, maxLauk };
            selectedLaukIds = [];

            // Reset forms
            const form = document.getElementById('orderForm');
            if (form) {
                form.reset();
                const checkBoxes = document.querySelectorAll('.lauk-checkbox');
                checkBoxes.forEach(cb => {
                    cb.checked = false;
                    cb.disabled = false;
                });
                document.getElementById('laukCounter').innerText = '0';
                document.getElementById('laukWarning').classList.add('hidden');
                document.getElementById('errorBanner').classList.add('hidden');
            }

            // Set package specific fields in Modal
            const titleLabel = document.getElementById('selectedPaketName');
            const priceLabel = document.getElementById('selectedPaketPriceLabel');
            const maxLaukLabel = document.getElementById('maxLaukLabel');
            const inputId = document.getElementById('inputPaketId');
            
            if (titleLabel) titleLabel.innerText = name;
            if (priceLabel) priceLabel.innerText = 'Rp ' + Number(price).toLocaleString('id-ID');
            if (maxLaukLabel) maxLaukLabel.innerText = maxLauk;
            if (inputId) inputId.value = id;

            // Open Modal with Transition
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.firstElementChild.classList.remove('scale-95', 'opacity-0');
            }, 10);

            calculateLivePrice();
        }

        // 2. CLOSE BOOKING MODAL
        function closeBookingModal() {
            const modal = document.getElementById('bookingModal');
            if (!modal) return;
            modal.firstElementChild.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // 3. LAUK CHECKBOX LOGIC
        function updateLaukSelection(checkbox) {
            const checkboxes = document.querySelectorAll('.lauk-checkbox');
            const checkedBoxes = Array.from(checkboxes).filter(cb => cb.checked);
            const count = checkedBoxes.length;

            const counterLabel = document.getElementById('laukCounter');
            if (counterLabel) counterLabel.innerText = count;

            const limit = currentPackage.maxLauk;
            const warning = document.getElementById('laukWarning');

            if (count >= limit) {
                checkboxes.forEach(cb => {
                    if (!cb.checked) cb.disabled = true;
                });
                if (warning) warning.classList.remove('hidden');
            } else {
                checkboxes.forEach(cb => cb.disabled = false);
                if (warning) warning.classList.add('hidden');
            }

            selectedLaukIds = checkedBoxes.map(cb => Number(cb.value));
        }

        // 4. LIVE PRICE CALCULATION
        function calculateLivePrice() {
            const paxInput = document.getElementById('jumlahPaxInput');
            if (!paxInput) return;

            const pax = Number(paxInput.value) || 0;
            
            const inputJml = document.getElementById('inputJmlPaket');
            if (inputJml) inputJml.value = pax;

            const subtotalPaket = pax * currentPackage.price;
            
            const gubukanSelect = document.getElementById('gubukanSelect');
            let gubukanPrice = 0;
            if (gubukanSelect && gubukanSelect.selectedIndex > 0) {
                const selectedOption = gubukanSelect.options[gubukanSelect.selectedIndex];
                gubukanPrice = Number(selectedOption.getAttribute('data-price')) || 0;
            }

            const total = subtotalPaket + gubukanPrice;

            const calcPax = document.getElementById('calcPaxLabel');
            const calcPrice = document.getElementById('calcPriceLabel');
            const calcSubtotal = document.getElementById('calcSubtotalPaket');
            const calcGubukanPrice = document.getElementById('calcGubukanPrice');
            const calcGubukanRow = document.getElementById('calcGubukanRow');
            const calcTotal = document.getElementById('calcTotalPrice');

            if (calcPax) calcPax.innerText = pax;
            if (calcPrice) calcPrice.innerText = 'Rp ' + Number(currentPackage.price).toLocaleString('id-ID');
            if (calcSubtotal) calcSubtotal.innerText = 'Rp ' + subtotalPaket.toLocaleString('id-ID');
            
            if (gubukanPrice > 0) {
                if (calcGubukanPrice) calcGubukanPrice.innerText = 'Rp ' + gubukanPrice.toLocaleString('id-ID');
                if (calcGubukanRow) calcGubukanRow.classList.remove('hidden');
            } else {
                if (calcGubukanRow) calcGubukanRow.classList.add('hidden');
            }

            if (calcTotal) calcTotal.innerText = 'Rp ' + total.toLocaleString('id-ID');
        }

        // 5. AJAX SUBMIT ORDER
        function submitOrder(event) {
            event.preventDefault();

            if (selectedLaukIds.length !== currentPackage.maxLauk) {
                showFormError(`Anda harus memilih tepat ${currentPackage.maxLauk} lauk untuk paket ini.`);
                return;
            }

            const paxInput = document.getElementById('jumlahPaxInput').value;
            const tglAcara = document.getElementById('tglAcaraInput').value;
            const gubukanId = document.getElementById('gubukanSelect').value;
            const catatan = document.getElementById('catatanTextarea').value;

            const submitBtn = document.getElementById('submitBtn');
            const spinner = document.getElementById('submitSpinner');
            if (submitBtn) submitBtn.disabled = true;
            if (spinner) spinner.classList.remove('hidden');
            document.getElementById('errorBanner').classList.add('hidden');

            const payload = {
                gubukan_id: gubukanId ? Number(gubukanId) : null,
                tgl_acara: tglAcara,
                jumlah_pax: Number(paxInput),
                catatan: catatan,
                items: [
                    {
                        paket_id: currentPackage.id,
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
                closeBookingModal();
                const overlay = document.getElementById('successOverlay');
                if (overlay) {
                    overlay.classList.remove('hidden');
                }
            })
            .catch(error => {
                showFormError(error.message);
            })
            .finally(() => {
                if (submitBtn) submitBtn.disabled = false;
                if (spinner) spinner.classList.add('hidden');
            });
        }

        function showFormError(message) {
            const banner = document.getElementById('errorBanner');
            const text = document.getElementById('errorText');
            if (banner && text) {
                text.innerText = message;
                banner.classList.remove('hidden');
            }
        }
    </script>
@endsection
