<div class="flex gap-3">

    <button
        id="btnTarget"
        data-tab="target"
        class="tab-btn rounded-xl bg-[#15803D] px-6 py-3 font-semibold text-white transition">

        Target

    </button>

    <button
        id="btnRealisasi"
        data-tab="realisasi"
        class="tab-btn rounded-xl border border-[#15803D] px-6 py-3 font-semibold text-[#15803D] transition">

        Realisasi

    </button>

</div>

<script>
    const btnTarget = document.getElementById('btnTarget');
    const btnRealisasi = document.getElementById('btnRealisasi');

    function setActiveButton(activeButton, inactiveButton) {
        activeButton.classList.remove(
            'border',
            'border-[#15803D]',
            'text-[#15803D]'
        );

        activeButton.classList.add(
            'bg-[#15803D]',
            'text-white'
        );

        inactiveButton.classList.remove(
            'bg-[#15803D]',
            'text-white'
        );

        inactiveButton.classList.add(
            'border',
            'border-[#15803D]',
            'text-[#15803D]'
        );
    }

    btnTarget.addEventListener('click', () => {
        setActiveButton(btnTarget, btnRealisasi);

        // panggil fungsi target
        loadTarget();
    });

    btnRealisasi.addEventListener('click', () => {
        setActiveButton(btnRealisasi, btnTarget);

        // panggil fungsi realisasi
        loadRealisasi();
    });
</script>