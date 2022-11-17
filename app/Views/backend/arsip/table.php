<?=$this->extend('backend/template')?>
 
<?=$this->section('content')?>
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Arsip</h1>
                    <p class="mb-4">Data Arsip untuk mengelola data pengguna yang ada di sistem.</p>


<div class="container mt-5">

<div class="card shadow mb-4">
    <div class="card-header py-3">
        
        <button id="btn-tambah" class="btn btn-primary">Tambah data</button>
        <h6 class="m-0 font-weight-bold text-primary">
            
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
                                

    <table id='table-arsip' class="datatable table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor</th>
                <th>Judul</th>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Nama</th>
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
                <h5 class="modal-title">Form Arsip</h5>
                <button class="btn-close" data-bs-dismiss="modal" ></button>
            </div>
            <div class="modal-body">
                <form id="formArsip" method="post" action="<?=base_url('arsip')?>">
                    <input type="hidden" name="id" />
                    <input type="hidden" name="_method" />
                    <div class="mb-3">
                        <label class="label-control">Nomor Surat</label>
                        <input  class="form-control" type="text" name="nomor" />
                    </div>
                    <div class="mb-3">
                        <label class="label-control">Judul Surat</label>
                        <input  class="form-control" type="text" name="judul" />
                    </div>
                    <div class="mb-3">
                        <label class="label-control">Ringkasan</label>
                        <textarea name="ringkasan" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="label-control">Tanggal Surat</label>
                        <input  class="form-control" type="date" name="tgl" />
                    </div>
                    <div class="mb-3">
                        <label class="label-control">Kategori</label>
                        <select name="kategori_id" class="form-control">
                         <?php foreach($data_kategori as $k): ?>
                            <option value="<?=$k['id']?>"><?=$k['kategori']?></option>
                         <?php endforeach; ?>
                        </select>
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
        $('select[name=kategori_id]').select2({
            width:'100%', dropdownParent: $('#formModal')
        });

        $('table#table-arsip').on('click', 'button.btn-hapus', function(){
            var id = $(this).data('id');
            var c = confirm('Beneran mau hapus data ????');
            if(c === true){
                $.post('<?=base_url('arsip')?>', 
                    {_method:'delete', id:id}).done(function(e){
                       if(e.result === true){
                        $('table#table-arsip').DataTable().ajax.reload();
                       }else{   
                            alert('maaf gagal hapus data');
                       }     
                });
            }
        });

        $('table#table-arsip').on('click', 'button.btn-edit',  function(){
            var id = $(this).data('id'); 
            $.get('<?=base_url('arsip')?>/' + id).done(function(e){
                $('#formModal').modal('show');
                $('input[name=id]').val(e.id);  
                $('input[name=nomor]').val(e.nomor);    
                $('input[name=judul]').val(e.judul);    
                $('input[name=tgl]').val(e.tgl);    
                $('textarea[name=ringkasan]').val(e.ringkasan);    
                $('select[name=kategori_id]').val(e.kategori_id);    
              
                $('input[name=_method]').val('patch');
            });
        });

        $('form#formArsip').submitAjax({
            pre:()=>{
                $('button#btn-simpan').hide();
            },
            pasca:()=>{
                $('button#btn-simpan').show();     
            },
            success: (response, status)=>{
                $('table#table-arsip').DataTable().ajax.reload();
                $('#formModal').modal('hide');
            },
            error: (xhr, status)=>{
                alert('maaf, terjadi gagal simpan data arsip');
            }
        });

        $('button#btn-simpan').click(function(){
            $('form#formArsip').submit();
        });

        $("button#btn-tambah").on('click', function(){
            $('div#formModal').modal('show');
            $('form#formArsip').trigger('reset');
            $('input[name=_method]').val('');
        });

        $('table#table-arsip').DataTable({
            processing: true,
            serverSide: true,
            ajax:{
                url: "<?=base_url('arsip/all')?>",
                method: 'GET'
            },
            columns: [
                { data: 'id', sortable:false, searchable:false,
                  render: (data,type,row,meta)=>{
                    return meta.settings._iDisplayStart + meta.row + 1;
                  }
                },
                { data: 'nomor' },
                { data: 'judul' },
                { data: 'tgl' }, 
                { data: 'kategori' }, 
                { data: 'pengguna' }, 
            
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