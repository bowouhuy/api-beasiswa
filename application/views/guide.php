<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous"><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
    <div class="container mt-4 col-6">
        <h3>Restfull API Documnntation</h3>
        <div class="card mt-6">
            <div class="card-body">
                Dokumentasi API Craete, Update, Edit, Delete.
                <div class="card mt-3">
                    <div class="card-body">
                        Menampilkan Data </br>
                        METHOD : <b>GET</b> </br>
                        Endpoint : <a href="<?php echo base_url('api/mahasiswa')?>" class="stretched-link"><?php echo base_url('api/mahasiswa')?></a>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-body">
                        Menambahkan Data </br>
                        METHOD : <b>POST</b> </br>
                        Endpoint : <a href="<?php echo base_url('api/mahasiswa')?>"><?php echo base_url('api/mahasiswa')?></a></BR>
                        <button class="btn btn-primary mt-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            Show Parameter
                        </button>
                        <div class="collapse" id="collapseExample">
                            <div class="card card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <td><b>Name</b></td>
                                        <td><b>Value</b></td>
                                    </tr>
                                    <tr>
                                        <td>npm</td>
                                        <td>Inputan NPM</td>
                                    </tr>
                                    <tr>
                                        <td>nama</td>
                                        <td>Inputan Nama</td>
                                    </tr>
                                    <tr>
                                        <td>prodi</td>
                                        <td>Inputan Prodi</td>
                                    </tr>
                                    <tr>
                                        <td>semester</td>
                                        <td>Inputan Semester</td>
                                    </tr>
                                    <tr>
                                        <td>beasiswa</td>
                                        <td>Inputan Beasiswa</td>
                                    </tr>
                                    <tr>
                                        <td>periode</td>
                                        <td>Inputan Periode</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-body">
                        Mengupdate Data </br>
                        METHOD : <b>PUT</b> </br>
                        Endpoint : <a href="<?php echo base_url('api/mahasiswa')?>" class=""><?php echo base_url('api/mahasiswa')?></a></br>
                        <button class="btn btn-primary mt-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUpdate" aria-expanded="false" aria-controls="collapseExample">
                            Show Parameter
                        </button>
                        <div class="collapse" id="collapseUpdate">
                            <div class="card card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <td><b>Name</b></td>
                                        <td><b>Value</b></td>
                                    </tr>
                                    <tr>
                                        <td>npm</td>
                                        <td>Inputan NPM</td>
                                    </tr>
                                    <tr>
                                        <td>nama</td>
                                        <td>Inputan Nama</td>
                                    </tr>
                                    <tr>
                                        <td>prodi</td>
                                        <td>Inputan Prodi</td>
                                    </tr>
                                    <tr>
                                        <td>semester</td>
                                        <td>Inputan Semester</td>
                                    </tr>
                                    <tr>
                                        <td>beasiswa</td>
                                        <td>Inputan Beasiswa</td>
                                    </tr>
                                    <tr>
                                        <td>periode</td>
                                        <td>Inputan Periode</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-body">
                        Menghapus Data </br>
                        METHOD : <b>DELETE</b> </br>
                        Endpoint : <a href="<?php echo base_url('api/mahasiswa')?>" class=""><?php echo base_url('api/mahasiswa')?></a></br>
                        <button class="btn btn-primary mt-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDelete" aria-expanded="false" aria-controls="collapseExample">
                            Show Parameter
                        </button>
                        <div class="collapse" id="collapseDelete">
                            <div class="card card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <td><b>Name</b></td>
                                        <td><b>Value</b></td>
                                    </tr>
                                    <tr>
                                        <td>npm</td>
                                        <td>Inputan NPM</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-body">
                        Mengimport Data </br>
                        METHOD : <b>POST</b> </br>
                        Endpoint : <a href="<?php echo base_url('api/import')?>" class=""><?php echo base_url('api/import')?></a></br>
                        <button class="btn btn-primary mt-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseImport" aria-expanded="false" aria-controls="collapseExample">
                            Show Parameter
                        </button>
                        <div class="collapse" id="collapseImport">
                            <div class="card card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <td><b>Name</b></td>
                                        <td><b>Value</b></td>
                                    </tr>
                                    <tr>
                                        <td>userfile</td>
                                        <td>Form data input type file</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-3">
                <div class="card-body">
                        Mengexport Data </br>
                        METHOD : <b>GET</b> </br>
                        Endpoint : <a href="<?php echo base_url('api/export')?>" class=""><?php echo base_url('api/export')?></a></br>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>
