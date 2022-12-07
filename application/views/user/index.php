<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">My Profile</h1>

    <div class="card mb-3">
        <div class="col-md-2 container my-auto ">
            <img class="card-img-top" src="<?= base_url('assets/img/profile/') . $login['image']; ?>" alt="Card image cap">
        </div>
        <div class="card-body">
            <h5 class="card-title"><?= $login['name']; ?></h5>
            <p class="card-text"><?= $login['email']; ?></p>
            <p class="card-text"><small class="text-muted">member since <?= date('d F y', $login['date_created']); ?></small></p>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->