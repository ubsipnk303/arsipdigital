<?=$this->extend('backend/template')?>
 
<?=$this->section('content')?>
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Pengguna</h1>
                    <p class="mb-4">Data pengguna untuk mengelola data pengguna yang ada di sistem.</p>


<div class="container mt-5">

<div class="card shadow mb-4">
    <div class="card-header py-3">
        
        <button id="btn-tambah" class="btn btn-primary">Tambah data</button>
        <h6 class="m-0 font-weight-bold text-primary">
            
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
                                

    <table id='table-pelanggan' class="datatable table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Aksi</th>
            </tr>
        </thead>
    </table>

        </div>
    </div>
</div>

</div>

<div id="formModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Pengguna</h5>
                <button class="btn-close" data-bs-dismiss="modal" ></button>
            </div>
            <div class="modal-body">
                <form id="formPengguna" method="post" action="<?=base_url('pengguna')?>">
                    <input type="hidden" name="id" />
                    <input type="hidden" name="_method" />
                    <div class="mb-3">
                        <label class="label-control">Nama Lengkap</label>
                        <input  class="form-control" type="text" name="nama" />
                    </div>
                    
                    <div class="mb-3">
                        <label class="label-control">Jenis Kelamin</label>
                        <select class="form-control" name='gender'>
                            <option>Pilih Jenis Kelamin</option>
                            <option value="L">Laki - Laki</option>
                            <option value="P">Perempuan</option>
                            
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="label-control">Email</label>
                        <input  class="form-control" type="email" name="email" />
                    </div>
                    <div class="mb-3">
                        <label class="label-control">Sandi</label>
                        <input  class="form-control" type="password" name="sandi" />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btn-simpan" class="btn btn-success">Simpan</button>
            </div>
        </div>
    </div>
</div>

<?=$this->endSection()?>

<?=$this->section('script')?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" 
    crossorigin="anonymous"></script> 
<script src="https://cdn.jsdelivr.net/gh/agoenxz2186/submitAjax@develop/submit_ajax.js" 
    ></script> 
<link href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script> 

<script>
    $(document).ready(function(){
        $('table#table-pelanggan').on('click', 'button.btn-hapus', function(){
            var id = $(this).data('id');
            var c = confirm('Beneran mau hapus data ????');
            if(c === true){
                $.post('<?=base_url('pengguna')?>', 
                    {_method:'delete', id:id}).done(function(e){
                       if(e.result === true){
                        $('table#table-pelanggan').DataTable().ajax.reload();
                       }else{   
                            alert('maaf gagal hapus data');
                       }     
                });
            }
        });

        $('table#table-pelanggan').on('click', 'button.btn-edit',  function(){
            var id = $(this).data('id'); 
            $.get('<?=base_url('pengguna')?>/' + id).done(function(e){
                $('#formModal').modal('show');
                $('input[name=nama]').val(e.nama);    
                $('select[name=gender]').val(e.gender);
                $('input[name=email]').val(e.email);
                $('input[name=id]').val(e.id);
                
                $('input[name=_method]').val('patch');
            });
        });

        $('form#formPengguna').submitAjax({
            pre:()=>{
                $('button#btn-simpan').hide();
            },
            pasca:()=>{
                $('button#btn-simpan').show();     
            },
            success: (response, status)=>{
                $('table#table-pelanggan').DataTable().ajax.reload();
                $('#formModal').modal('hide');
            },
            error: (xhr, status)=>{
                alert('maaf, terjadi gagal simpan data pengguna');
            }
        });

        $('button#btn-simpan').click(function(){
            $('form#formPengguna').submit();
        });

        $("button#btn-tambah").on('click', function(){
            $('div#formModal').modal('show');
            $('form#formPengguna').trigger('reset');
            $('input[name=_method]').val('');
        });

        $('table#table-pelanggan').DataTable({
            processing: true,
            serverSide: true,
            ajax:{
                url: "<?=base_url('pengguna/all')?>",
                method: 'GET'
            },
            columns: [
                { data: 'id', sortable:false, searchable:false,
                  render: (data,type,row,meta)=>{
                    return meta.settings._iDisplayStart + meta.row + 1;
                  }
                },
                { data: 'nama' },
                { data: 'email' },
                { data: 'gender',
                  render: (data, type, meta, row)=>{
                     if( data === 'L'){
                        return 'Laki-Laki';
                     }else if( data === 'P' ){
                        return 'Perempuan';
                     }
                     return data;
                  }
                },
                { data: 'id',
                  render: (data, type, meta, row)=>{
                     var btnEdit  = `<button class='btn-edit btn btn-primary' data-id='${data}'> Edit </button>`;
                     var btnHapus = `<button class='btn-hapus btn btn-danger' data-id='${data}'> Hapus </button>`;
                     return btnEdit + btnHapus;
                  }
                }
            ]
        });
    });
</script>
  
<?=$this->endSection()?>