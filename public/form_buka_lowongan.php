<?php

$judul_halaman = "Form Buka Lowongan";
include '../header.php';
?>
<div class="max-w-screen-2xl mx-auto mt-10 bg-white p-8 rounded-lg border border-gray-200 shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-center">Form Pendaftaran Perusahaan</h2>
    <form action="proses_buka_lowongan.php" method="POST">
        <h4 class="text-lg font-semibold mt-4 mb-2">Data Perusahaan</h4>
        <div class="mb-4">
            <label for="nama_perusahaan" class="block mb-1 font-medium">Nama Perusahaan</label>
            <input type="text" class="w-full border rounded px-3 py-2" id="nama_perusahaan" name="nama_perusahaan"
                required>
        </div>
        <div class="mb-4">
            <label for="alamat_perusahaan" class="block mb-1 font-medium">Alamat Perusahaan</label>
            <textarea class="w-full border rounded px-3 py-2" id="alamat_perusahaan" name="alamat_perusahaan" rows="2"
                required></textarea>
        </div>
        <div class="mb-4">
            <label for="email_perusahaan" class="block mb-1 font-medium">Email Perusahaan</label>
            <input type="email" class="w-full border rounded px-3 py-2" id="email_perusahaan" name="email_perusahaan"
                required>
        </div>
        <div class="mb-4">
            <label for="telepon_perusahaan" class="block mb-1 font-medium">Telepon Perusahaan</label>
            <input type="text" class="w-full border rounded px-3 py-2" id="telepon_perusahaan" name="telepon_perusahaan"
                required>
        </div>
        <div class="mb-4">
            <label for="website_perusahaan" class="block mb-1 font-medium">Website Perusahaan (opsional)</label>
            <input type="url" class="w-full border rounded px-3 py-2" id="website_perusahaan" name="website_perusahaan">
        </div>

        <h4 class="text-lg font-semibold mt-6 mb-2">Pilih Paket</h4>
        <div class="mb-6">
            <label class="block mb-2 font-medium">Paket yang tersedia:</label>
            <div class="flex flex-col gap-2">
                <label class="inline-flex items-center">
                    <input type="radio" class="form-radio" name="paket" value="bronze" required
                        onchange="showBenefit(this.value)">
                    <span class="ml-2">Bronze</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" class="form-radio" name="paket" value="silver"
                        onchange="showBenefit(this.value)">
                    <span class="ml-2">Silver</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" class="form-radio" name="paket" value="gold" onchange="showBenefit(this.value)">
                    <span class="ml-2">Gold</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" class="form-radio" name="paket" value="diamond"
                        onchange="showBenefit(this.value)">
                    <span class="ml-2">Diamond</span>
                </label>
            </div>
            <div id="benefit-paket"
                class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded text-blue-900 text-sm hidden"></div>
        </div>

        <button type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">Kirim Lowongan
        </button>
    </form>
</div>
<script>
    const benefitData = {
        bronze: `<ul class="list-disc pl-5">
            <li>Posting 1 lowongan aktif</li>
            <li>Durasi tayang 7 hari</li>
            <li>Basic support</li>
        </ul>`,
        silver: `<ul class="list-disc pl-5">
            <li>Posting hingga 3 lowongan aktif</li>
            <li>Durasi tayang 14 hari</li>
            <li>Prioritas pencarian menengah</li>
            <li>Email support</li>
        </ul>`,
        gold: `<ul class="list-disc pl-5">
            <li>Posting hingga 10 lowongan aktif</li>
            <li>Durasi tayang 30 hari</li>
            <li>Prioritas pencarian tinggi</li>
            <li>Highlight lowongan</li>
            <li>Email & chat support</li>
        </ul>`,
        diamond: `<ul class="list-disc pl-5">
            <li>Posting unlimited lowongan aktif</li>
            <li>Durasi tayang 60 hari</li>
            <li>Prioritas pencarian tertinggi</li>
            <li>Highlight & featured lowongan</li>
            <li>Dedicated account manager</li>
        </ul>`
    };

    function showBenefit(paket) {
        const benefitDiv = document.getElementById('benefit-paket');
        if (benefitData[paket]) {
            benefitDiv.innerHTML = `<strong>Benefit Paket ${paket.charAt(0).toUpperCase() + paket.slice(1)}:</strong>` + benefitData[paket];
            benefitDiv.classList.remove('hidden');
        } else {
            benefitDiv.innerHTML = '';
            benefitDiv.classList.add('hidden');
        }
    }
</script>
</body>

</html>