<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login Sistem Informasi Arsip Digital</title>

    <!-- Custom fonts for this template-->
    <link href="<?=base_url('assets')?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="//fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?=base_url('assets')?>/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-6 col-lg-6 col-md-6">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <!-- <div class="col-lg-6 d-none d-lg-block bg-login-image"></div> -->
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Login ke Sistem Arsip Digital</h1>
                                    </div>
                                    <form id="form-login" method="post" action="<?=base_url('/login')?>">
                                        <div class="form-group">
                                            <input name="email" type="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Masukkan alamat surat elektronik...">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="sandi" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Kata sandi">
                                        </div>
                                        
                                        <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
 
                                        <hr>
                                       
                                    </form>
                                    <hr>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?=base_url('assets')?>/vendor/jquery/jquery.min.js"></script>
    <script src="<?=base_url('assets')?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?=base_url('assets')?>/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?=base_url('assets')?>/js/sb-admin-2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/agoenxz2186/submitAjax@develop/submit_ajax.js" 
            ></script> 
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" 
            crossorigin="anonymous"></script>

    <script>
       $(document).ready(function(){
          $('form#form-login').submitAjax({
            pre:()=>{
                $('form#form-login button[type=submit]').hide();
            },
            pasca:()=>{
                $('form#form-login button[type=submit]').show();
            },
            success: (response, status)=>{
                var js = $.parseJSON(response);
                alert(js.message);
                window.location = "<?=url_to('pengguna')?>";
            },
            error: (xhr, status)=>{
                var json = $.parseJSON(  xhr.responseText ); 
                alert(json.message);
            }
          });
       });
    </script>

</body>

</html>