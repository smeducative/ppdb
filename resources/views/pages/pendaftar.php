<?= $this->extend('layout/template2') ?>

<?= $this->section('content'); ?>
<div id="content" class="container">

    <form action="" method="POST">
        <div class="input-group mb-3">
            <input type="text" name="cari" class="form-control" placeholder="Minimal masukan 1 kata nama" aria-label="Recipient's username" aria-describedby="button-addon2" autocomplete="off" autofocus="">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit" name="carix" id="button-addon2">Cari</button>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="5%">No.</th>
                    <th width="5%"> Gel</th>
                    <th width="10%"> No Pendaftaran</th>
                    <th width="30%">Nama</th>
                    <th width="30%"> Program Studi</th>
                    <th width="40%">Asal Sekolah</th>
                    <!-- <td width="5%">Skor</td> -->
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>1</td>
                    <td>12</td>
                    <td>Rio Aprianto</td>
                    <td>Teknik Komputer Dan Jaringan</td>
                    <td>SMP 1 Kajen</td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>2</td>
                    <td>12</td>
                    <td>Rio Aprianto</td>
                    <td>Teknik Komputer Dan Jaringan</td>
                    <td>SMP 1 Kajen</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>3</td>
                    <td>12</td>
                    <td>Rio Aprianto</td>
                    <td>Teknik Komputer Dan Jaringan</td>
                    <td>SMP 1 Kajen</td>
                </tr>
            </tbody>
        </table>
    </div>

</div>
<?= $this->endSection(); ?>