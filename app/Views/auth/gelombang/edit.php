<!-- Modal -->
<div class="modal fade" id="modaledit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open_multipart('', ['class' => 'formedit']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <input type="hidden" class="form-control" id="id_file" value="<?= $id_file ?>" name="id_file" readonly>

                <div class="form-group">
                    <label>Gelombang</label>
                    <?php if ($gelombang_id != 1 && $gelombang_id != 2) {
                    ?>
                        <input type="text" class="form-control" value="<?= $gelombang_id ?>" id="gelombang_id" name="gelombang_id">
                    <?php } else { ?>
                        <input type="text" class="form-control" value="<?= $gelombang_id ?>" id="gelombang_id" name="gelombang_id" readonly>
                    <?php } ?>
                    <div class="invalid-feedback errorGelombang">
                    </div>
                </div>

                <div class="form-group">
                    <label>File</label>
                    <input type="file" class="form-control" id="file_pdf" name="file_pdf">
                    <div class="invalid-feedback errorFile">

                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btnsimpan"><i class="fa fa-share-square"></i> Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

            <?= form_close() ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.btnsimpan').click(function(e) {
            e.preventDefault();

            let form = $('.formedit')[0];
            let data = new FormData(form);

            $.ajax({
                type: "post",
                url: '<?= site_url('siswa/updategelombang') ?>',
                data: data,
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                dataType: "json",
                beforeSend: function() {
                    $('.btnsimpan').attr('disable', 'disable');
                    $('.btnsimpan').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>');
                },
                complete: function() {
                    $('.btnsimpan').removeAttr('disable', 'disable');
                    $('.btnsimpan').html('<i class="fa fa-share-square"></i>  Simpan');
                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.gelombang_id) {
                            $('#gelombang_id').addClass('is-invalid');
                            $('.errorGelombang').html(response.error.gelombang_id);
                        } else {
                            $('#gelombang_id').removeClass('is-invalid');
                            $('.errorGelombang').html('');
                        }
                        
                        if (response.error.file_pdf) {
                            $('#file_pdf').addClass('is-invalid');
                            $('.errorFile').html(response.error.file_pdf);
                        } else {
                            $('#file_pdf').removeClass('is-invalid');
                            $('.errorFile').html('');
                        }
                    } else {
                        Swal.fire({
                            title: "Berhasil!",
                            text: response.sukses,
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#modaledit').modal('hide');
                        listgelombang();
                    }
                }
            });
        })
    });
</script>