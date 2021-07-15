<?= $this->extend('layout/template1') ?>

<?= $this->section('content'); ?>
<div id="content" class="container">

    <div class="card-deck mb-3">
        <!-- Pendaftaran reguler-->
        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <h4 class="my-0 font-weight-normal">Syarat Pendaftaran</h4>
            </div>
            <div class="card-body">
                <ol> &nbsp;
                    <li>&nbsp;Akta Kelahiran</li>
                    <li>&nbsp;Foto Copy ijaxah</li>
                    <li>&nbsp;SKHUN</li>
                    <li>&nbsp;Foto</li>
                </ol>
            </div>
        </div>

        <!--Pendaftaran online-->

        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <h4 class="my-0 font-weight-normal">Waktu Pendaftaran</h4>
            </div>
            <div class="card-body text-center">

                <table width="100%" class="table">
                    <tbody>
                        <tr>
                            <td><strong>Gelombang 1</strong><br>
                                Pendaftaran &amp; Seleksi : <b>15-20 Juni 2020</b><br>
                                Pengumuman : <b>22 Juni 2020</b> <br>
                                Daftar Ulang : <b>22 - 27 Juni 2020</b>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Gelombang 2</strong><br>
                                One Day Service : <b>29 Juni - 9 Juli 2020</b>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Modal -->
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            </div>
                            <div class="modal-body">
                                Pendaftaran Secara ON-LINE akan dibuka mulai tanggal 13 Januari 2020 Jam 00:01 WIB
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <p align="center"><i>*Pendaftaran akan ditutup jika sudah memenuhi kuota.</i></p>
    <div id="text-content" class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h3>contact person</h3>
        <br>
        <div class="row">
            <div class="col-lg-6">
                <div class="container-person">
                    <div class="image-person" style="background-image: url(/img/person2.jpg);"></div>
                    <div id="person-info">
                        <h2>Ibu widi setyo pratiwi</h2>
                        <div class="info">
                            <i class="ion-ios-location-outline"></i> &nbsp; <address>Jl. Raya Karanganyar No.KM,
                                RW.2</address>
                        </div>
                        <div class="info">
                            <i class="ion-ios-telephone-outline"></i> &nbsp; <p><a href="tel:+62 8580 0299 849">+62
                                    8580 0299 849</a></p>
                        </div>
                        <div class="info">
                            <i class="ion-ios-email-outline"></i> &nbsp; <p><a href="mailto:riosaja63711@gmail.com">riosaja63711@gmail.com</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="container-person">
                    <div class="image-person" style="background-image: url(/img/person2.jpg);"></div>
                    <div id="person-info">
                        <h2>pak miftahudin</h2>
                        <div class="info">
                            <i class="ion-ios-location-outline"></i> &nbsp; <address>Jl. Raya Karanganyar No.KM,
                                RW.2</address>
                        </div>
                        <div class="info">
                            <i class="ion-ios-telephone-outline"></i> &nbsp; <p><a href="tel:+62 8580 0299 849">+62
                                    8580 0299 849</a></p>
                        </div>
                        <div class="info">
                            <i class="ion-ios-email-outline"></i> &nbsp; <p><a href="mailto:riosaja63711@gmail.com">riosaja63711@gmail.com</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>